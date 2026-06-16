<?php
// =================================================================================
// Konfigurasi dan Koneksi Database
// =================================================================================
$db_host = '127.0.0.1';
$db_name = getenv('DB_NAME') ?: ($_GET['db'] ?? 'kesmas_new');
$db_user = 'root';
$db_pass = '';
$db_charset = 'utf8mb4';

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// =================================================================================
// Logika Pengambilan Data (Sesuai Halaman)
// =================================================================================

// Filter bulan, default ke bulan lalu jika tidak ada
$bulan_filter = $_GET['bulan'] ?? date('Y-m', strtotime('first day of last month'));
$bulan_sebelumnya = date('Y-m', strtotime($bulan_filter . ' -1 month'));
$nama_bulan_filter = date("F Y", strtotime($bulan_filter . '-01'));
$nama_bulan_sebelumnya = date("F Y", strtotime($bulan_sebelumnya . '-01'));

// --- Helper Function ---
function isMemenuhiSyarat($hasil, $baku_mutu) {
    if ($hasil === null || $baku_mutu === null || $baku_mutu === '' || $baku_mutu === '-') return true; // Anggap MS jika tidak ada baku mutu

    $hasil_str = strtolower(trim((string)$hasil));
    $baku_mutu_str = strtolower(trim((string)$baku_mutu));

    // Normalize decimal comma to dot
    $baku_mutu_str = preg_replace('/(?<=\d),(?=\d)/', '.', $baku_mutu_str);
    $hasil_str = preg_replace('/(?<=\d),(?=\d)/', '.', $hasil_str);

    // Handle 'maks' or 'maksimum'
    if (preg_match('/\b(maks|maksimum)\b\s*[:\-\s]*([0-9\.,]+)/i', $baku_mutu_str, $m_maks)) {
        $limit = (float)str_replace(',', '.', $m_maks[2]);
        if (preg_match('/-?\d+[\d\.]*?/', $hasil_str, $hm)) {
            $val = (float)$hm[0];
            return $val <= $limit;
        }
    }

    // Handle operators: <=, >=, <, >, =
    if (preg_match('/([<>≤≥]=?|=)\s*([0-9\.]+)/u', $baku_mutu_str, $m)) {
        $op = $m[1];
        $op = str_replace(['≤','≥'], ['<=','>='], $op);
        $limit = (float)$m[2];
        if (preg_match('/-?\d+[\d\.]*?/', $hasil_str, $hm)) {
            $val = (float)$hm[0];
            switch ($op) {
                case '<': return $val < $limit;
                case '<=': return $val <= $limit;
                case '>': return $val > $limit;
                case '>=': return $val >= $limit;
                case '=': return abs($val - $limit) < 1e-9;
            }
        }
    }

    // Range like 'x - y'
    if (preg_match('/([0-9\.]+)\s*[-–]\s*([0-9\.]+)/u', $baku_mutu_str, $m2)) {
        $low = (float)$m2[1];
        $high = (float)$m2[2];
        if (preg_match('/-?\d+[\d\.]*?/', $hasil_str, $hm2)) {
            $val = (float)$hm2[0];
            return $val >= $low && $val <= $high;
        }
    }

    // Exact zero or 'negatif'
    if (preg_match('/\b0\b/', $baku_mutu_str) || strpos($baku_mutu_str, 'negatif') !== false) {
        if (preg_match('/\d+/', $hasil_str, $hm3)) {
            $val = (int)$hm3[0];
            return $val === 0;
        }
        if (strpos($hasil_str, 'positif') !== false) return false;
        return true;
    }

    // Textual: 'tidak berbau' vs 'berbau'
    if (strpos($baku_mutu_str, 'tidak berbau') !== false || strpos($baku_mutu_str, 'tidak bau') !== false) {
        return strpos($hasil_str, 'bau') === false && strpos($hasil_str, 'berbau') === false;
    }

    // Presence: 'negatif/25g'
    if (strpos($baku_mutu_str, 'negatif') !== false || strpos($baku_mutu_str, 'tidak ada') !== false) {
        if (strpos($hasil_str, 'positif') !== false || preg_match('/\d+/', $hasil_str)) return false;
        return true;
    }

    // Default to MS if unrecognized
    return true;
}


// Halaman 2: Jumlah Pelanggan per Kategori
function getDataPage2($pdo, $bulan_filter, $bulan_sebelumnya) {
    $stmt_current = $pdo->prepare("SELECT jenis_sampel, COUNT(*) as total FROM kesmas_permintaan WHERE DATE_FORMAT(tgl_permintaan, '%Y-%m') = ? GROUP BY jenis_sampel");
    $stmt_current->execute([$bulan_filter]);
    $data_current = $stmt_current->fetchAll();

    $stmt_prev = $pdo->prepare("SELECT jenis_sampel, COUNT(*) as total FROM kesmas_permintaan WHERE DATE_FORMAT(tgl_permintaan, '%Y-%m') = ? GROUP BY jenis_sampel");
    $stmt_prev->execute([$bulan_sebelumnya]);
    $data_prev = $stmt_prev->fetchAll();

    $merged = [];
    foreach ($data_current as $row) { $merged[$row['jenis_sampel']]['current'] = $row['total']; }
    foreach ($data_prev as $row) { $merged[$row['jenis_sampel']]['prev'] = $row['total']; }
    
    $labels = array_keys($merged);
    $data_curr_final = [];
    $data_prev_final = [];
    foreach($labels as $label) {
        $data_curr_final[] = $merged[$label]['current'] ?? 0;
        $data_prev_final[] = $merged[$label]['prev'] ?? 0;
    }

    return ['table' => $merged, 'chart' => ['labels' => $labels, 'current' => $data_curr_final, 'prev' => $data_prev_final]];
}

// Halaman 3: Data Pemeriksaan per Wilayah
function getDataPage3($pdo, $bulan_filter) {
    $stmt = $pdo->prepare("SELECT lokasi_pengambilan, jenis_sampel, COUNT(*) as total FROM kesmas_permintaan WHERE DATE_FORMAT(tgl_permintaan, '%Y-%m') = ? AND lokasi_pengambilan IS NOT NULL AND lokasi_pengambilan != '' GROUP BY lokasi_pengambilan, jenis_sampel");
    $stmt->execute([$bulan_filter]);
    $rows = $stmt->fetchAll();

    $pivot = [];
    $sample_types = [];
    foreach ($rows as $row) {
        $pivot[$row['lokasi_pengambilan']][$row['jenis_sampel']] = $row['total'];
        if (!in_array($row['jenis_sampel'], $sample_types)) {
            $sample_types[] = $row['jenis_sampel'];
        }
    }
    sort($sample_types);
    return ['pivot_table' => $pivot, 'sample_types' => $sample_types];
}


// Halaman 4: MS / TMS
function getDataPage4($pdo, $bulan_filter) {
    $sql = "SELECT m.nama_pemeriksaan, h.hasil, m.baku_mutu, h.keterangan 
            FROM kesmas_hasil h
            JOIN kesmas_permintaan_item i ON h.permintaan_item_id = i.id
            JOIN kesmas_permintaan p ON i.permintaan_id = p.id
            JOIN kesmas_master_pemeriksaan m ON i.master_pemeriksaan_id = m.id
            WHERE DATE_FORMAT(p.tgl_permintaan, '%Y-%m') = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bulan_filter]);
    $rows = $stmt->fetchAll();

    $results = [];
    foreach ($rows as $row) {
        $pemeriksaan = $row['nama_pemeriksaan'];
        if (!isset($results[$pemeriksaan])) {
            $results[$pemeriksaan] = ['ms' => 0, 'tms' => 0, 'total' => 0];
        }
        $keterangan = $row['keterangan'];
        if ($keterangan === 'MS') {
            $results[$pemeriksaan]['ms']++;
        } elseif ($keterangan === 'TMS') {
            $results[$pemeriksaan]['tms']++;
        } else {
            // Jika belum ditentukan, hitung otomatis
            if (isMemenuhiSyarat($row['hasil'], $row['baku_mutu'])) {
                $results[$pemeriksaan]['ms']++;
            } else {
                $results[$pemeriksaan]['tms']++;
            }
        }
        $results[$pemeriksaan]['total']++;
    }
    ksort($results);
    return $results;
}


// Halaman 5: 10 Pemeriksaan Terbanyak
function getDataPage5($pdo, $bulan_filter) {
    $sql = "SELECT m.nama_pemeriksaan, COUNT(i.master_pemeriksaan_id) as total 
            FROM kesmas_permintaan_item i
            JOIN kesmas_master_pemeriksaan m ON i.master_pemeriksaan_id = m.id
            JOIN kesmas_permintaan p ON i.permintaan_id = p.id
            WHERE DATE_FORMAT(p.tgl_permintaan, '%Y-%m') = ?
            GROUP BY m.nama_pemeriksaan
            ORDER BY total DESC
            LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bulan_filter]);
    return $stmt->fetchAll();
}

// Halaman 6: Data per Obyek
function getDataPage6($pdo, $bulan_filter) {
    $sql = "SELECT 
                CASE 
                    WHEN LOWER(instansi) LIKE '%pdam%' THEN 'PDAM'
                    WHEN LOWER(instansi) LIKE '%rs%' OR LOWER(instansi) LIKE '%klinik%' OR LOWER(instansi) LIKE '%puskesmas%' THEN 'Rumah Sakit/Klinik'
                    WHEN LOWER(instansi) LIKE '%restoran%' OR LOWER(instansi) LIKE '%rumah makan%' OR LOWER(instansi) LIKE '%hotel%' OR LOWER(instansi) LIKE '%depot%' THEN 'Restoran/Rumah Makan'
                    ELSE 'Masyarakat' 
                END as kategori_instansi, 
                COUNT(*) as total 
            FROM kesmas_permintaan 
            WHERE DATE_FORMAT(tgl_permintaan, '%Y-%m') = ?
            GROUP BY kategori_instansi";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bulan_filter]);
    return $stmt->fetchAll();
}

$data_p2 = getDataPage2($pdo, $bulan_filter, $bulan_sebelumnya);
$data_p3 = getDataPage3($pdo, $bulan_filter);
$data_p4 = getDataPage4($pdo, $bulan_filter);
$data_p5 = getDataPage5($pdo, $bulan_filter);
$data_p6 = getDataPage6($pdo, $bulan_filter);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Pemeriksaan Laboratorium Kesmas - <?= $nama_bulan_filter ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
        }
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .page { page-break-after: always; }
            .no-print { display: none; }
        }
        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 2cm;
            margin: 1cm auto;
            border: 1px #D3D3D3 solid;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 { text-align: center; font-weight: bold; }
        h1 { font-size: 16pt; }
        h2 { font-size: 14pt; }
        h3 { font-size: 12pt; }
        .text-center { text-align: center; }
        .table-bordered {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .table-bordered th { background-color: #EFEFEF; text-align: center; }
        .signature-table { width: 100%; margin-top: 80px; }
        .signature-table td { text-align: center; padding: 20px; width: 50%; }
        .chart-container { width: 100%; max-width: 800px; margin: auto; margin-bottom: 30px; }
        .button-container { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="no-print button-container">
    <button onclick="window.print()">Cetak Laporan</button>
</div>

<!-- HALAMAN 1: COVER & BAB 1 -->
<div class="page">
    <h1 style="margin-top:4cm;">LAPORAN HASIL PEMERIKSAAN LABORATORIUM KESEHATAN MASYARAKAT</h1>
    <h2 style="margin-top:1cm;"><?= strtoupper($nama_bulan_filter) ?></h2>
    <div style="text-align: center; margin-top: 5cm;">
        <img src="assets/img/logo.png" alt="Logo" style="width: 150px;"/>
    </div>
    <h3 style="position: absolute; bottom: 2cm; width: 17cm; text-align: center;">NAMA INSTANSI<br>TAHUN <?= date("Y", strtotime($bulan_filter . '-01')) ?></h3>
</div>

<div class="page">
    <h2>BAB I PENDAHULUAN</h2>
    <p style="text-indent: 50px;">Laboratorium Kesehatan Masyarakat (KESMAS) merupakan salah satu unit pelayanan teknis yang memegang peranan penting dalam mendukung program-program kesehatan masyarakat. Fungsi utamanya adalah melakukan pemeriksaan sampel lingkungan, makanan, dan air untuk mendeteksi potensi risiko kesehatan yang dapat memengaruhi populasi.</p>
    <p style="text-indent: 50px;">Laporan ini disusun untuk menyajikan rekapitulasi dan analisis data hasil pemeriksaan yang telah dilakukan oleh Laboratorium Kesmas selama periode bulan <?= $nama_bulan_filter ?>. Data yang disajikan mencakup berbagai aspek, mulai dari jumlah dan jenis sampel yang diperiksa, distribusi pelanggan, hingga tingkat kepatuhan hasil pemeriksaan terhadap baku mutu yang berlaku.</p>
    <p style="text-indent: 50px;">Tujuan dari laporan ini adalah untuk memberikan gambaran yang komprehensif mengenai kinerja laboratorium, serta menyediakan data yang valid dan akurat bagi para pemangku kepentingan. Data ini diharapkan dapat menjadi dasar untuk pengambilan keputusan, perencanaan program intervensi kesehatan lingkungan, serta evaluasi terhadap upaya-upaya yang telah dilakukan. Melalui laporan ini, diharapkan dapat teridentifikasi tren, pola, dan area yang memerlukan perhatian khusus guna meningkatkan kualitas kesehatan masyarakat secara keseluruhan.</p>
</div>


<!-- HALAMAN 2: JUMLAH PELANGGAN -->
<div class="page">
    <h2>BAB II ANALISIS DATA PELANGGAN DAN SAMPEL</h2>
    <h3>2.1 Jumlah Pelanggan/Pengguna Jasa per Kategori Sampel</h3>
    <div class="chart-container">
        <canvas id="chartPage2"></canvas>
    </div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Jenis Sampel</th>
                <th><?= $nama_bulan_sebelumnya ?></th>
                <th><?= $nama_bulan_filter ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data_p2['table'] as $label => $counts): ?>
            <tr>
                <td><?= htmlspecialchars($label) ?></td>
                <td class="text-center"><?= $counts['prev'] ?? 0 ?></td>
                <td class="text-center"><?= $counts['current'] ?? 0 ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- HALAMAN 3: DATA PER WILAYAH -->
<div class="page">
    <h2>BAB III ANALISIS SPASIAL DAN PEMERIKSAAN</h2>
    <h3>3.1 Data Pemeriksaan Berdasarkan Wilayah Puskesmas</h3>
    <div class="chart-container">
        <canvas id="chartPage3"></canvas>
    </div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Lokasi Pengambilan</th>
                <?php foreach($data_p3['sample_types'] as $type): ?>
                <th><?= htmlspecialchars($type) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data_p3['pivot_table'] as $lokasi => $types): ?>
            <tr>
                <td><?= htmlspecialchars($lokasi) ?></td>
                <?php foreach($data_p3['sample_types'] as $type): ?>
                <td class="text-center"><?= $types[$type] ?? 0 ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- HALAMAN 4: MS/TMS -->
<div class="page">
    <h3>3.2 Pemeriksaan Memenuhi Syarat (MS) dan Tidak Memenuhi Syarat (TMS)</h3>
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Nama Pemeriksaan</th>
                <th>Jumlah Diperiksa</th>
                <th>MS</th>
                <th>TMS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data_p4 as $nama => $data): ?>
            <tr>
                <td><?= htmlspecialchars($nama) ?></td>
                <td class="text-center"><?= $data['total'] ?></td>
                <td class="text-center"><?= $data['ms'] ?></td>
                <td class="text-center"><?= $data['tms'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- HALAMAN 5: 10 PEMERIKSAAN TERBANYAK -->
<div class="page">
    <h2>BAB IV FOKUS PEMERIKSAAN</h2>
    <h3>4.1 Jumlah 10 Pemeriksaan Terbanyak</h3>
    <div class="chart-container">
        <canvas id="chartPage5"></canvas>
    </div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Nama Pemeriksaan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data_p5 as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_pemeriksaan']) ?></td>
                <td class="text-center"><?= $row['total'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- HALAMAN 6: PEMERIKSAAN PER OBYEK -->
<div class="page">
    <h3>4.2 Data Pemeriksaan Laboratorium Kesmas per Obyek</h3>
     <div class="chart-container" style="max-width: 500px;">
        <canvas id="chartPage6"></canvas>
    </div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Kategori Instansi</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $total_p6 = 0;
            foreach($data_p6 as $row): 
            $total_p6 += $row['total'];
        ?>
            <tr>
                <td><?= htmlspecialchars($row['kategori_instansi']) ?></td>
                <td class="text-center"><?= $row['total'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th class="text-center"><?= $total_p6 ?></th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- HALAMAN 7: PENUTUP -->
<div class="page">
    <h2>BAB V PENUTUP</h2>
    <p style="text-indent: 50px;">Demikian laporan bulanan kegiatan Laboratorium Kesehatan Masyarakat ini kami sampaikan. Laporan ini merupakan ringkasan dari seluruh data pemeriksaan yang telah dilakukan selama periode <?= $nama_bulan_filter ?>. Semua data yang disajikan telah melalui proses verifikasi untuk menjamin keakuratannya.</p>
    <p style="text-indent: 50px;">Kami berharap laporan ini dapat memberikan manfaat dan menjadi acuan bagi pihak-pihak terkait dalam merumuskan kebijakan dan program tindak lanjut. Evaluasi dan analisis yang berkelanjutan akan terus kami lakukan untuk meningkatkan mutu pelayanan laboratorium demi terwujudnya masyarakat yang lebih sehat.</p>
    <p style="text-indent: 50px;">Atas perhatian dan kerja sama semua pihak, kami ucapkan terima kasih.</p>

    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                Kepala Laboratorium
                <br><br><br><br><br>
                (_________________)<br>
                NIP. ...................
            </td>
            <td>
                ................, <?= date("d F Y") ?><br>
                Penyusun Laporan
                <br><br><br><br><br>
                (_________________)<br>
                NIP. ...................
            </td>
        </tr>
    </table>
</div>

<script>
// Chart for Page 2
const ctx2 = document.getElementById('chartPage2').getContext('2d');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: <?= json_encode($data_p2['chart']['labels']) ?>,
        datasets: [{
            label: '<?= $nama_bulan_sebelumnya ?>',
            data: <?= json_encode($data_p2['chart']['prev']) ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }, {
            label: '<?= $nama_bulan_filter ?>',
            data: <?= json_encode($data_p2['chart']['current']) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: { scales: { y: { beginAtZero: true } } }
});

// Chart for Page 3
const ctx3 = document.getElementById('chartPage3').getContext('2d');
const sampleTypesP3 = <?= json_encode($data_p3['sample_types']) ?>;
const locationsP3 = <?= json_encode(array_keys($data_p3['pivot_table'])) ?>;
const pivotDataP3 = <?= json_encode($data_p3['pivot_table']) ?>;
const datasetsP3 = sampleTypesP3.map((type, index) => {
    const colors = ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)'];
    return {
        label: type,
        data: locationsP3.map(loc => pivotDataP3[loc][type] || 0),
        backgroundColor: colors[index % colors.length],
    };
});
new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: locationsP3,
        datasets: datasetsP3
    },
    options: {
        scales: {
            x: { stacked: true },
            y: { stacked: true, beginAtZero: true }
        }
    }
});


// Chart for Page 5
const ctx5 = document.getElementById('chartPage5').getContext('2d');
new Chart(ctx5, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($data_p5, 'nama_pemeriksaan')) ?>,
        datasets: [{
            label: 'Jumlah Pemeriksaan',
            data: <?= json_encode(array_column($data_p5, 'total')) ?>,
            backgroundColor: 'rgba(153, 102, 255, 0.5)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y',
        scales: { x: { beginAtZero: true } }
    }
});

// Chart for Page 6
const ctx6 = document.getElementById('chartPage6').getContext('2d');
new Chart(ctx6, {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_column($data_p6, 'kategori_instansi')) ?>,
        datasets: [{
            label: 'Jumlah per Obyek',
            data: <?= json_encode(array_column($data_p6, 'total')) ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
            ],
            hoverOffset: 4
        }]
    }
});
</script>

</body>
</html>
