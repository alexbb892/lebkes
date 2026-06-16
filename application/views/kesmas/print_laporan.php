<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Hasil Uji</title>
  <style>
    @page { size: A4 portrait; margin: 5mm; }
    * { box-sizing: border-box; }
    body { font-family: Arial, Helvetica, sans-serif; font-size: 11px; color:#000; }

    .kop-wrap { display:flex; align-items:flex-start; gap:8px; }
    .logo { width:60px; height:60px; object-fit:contain; margin-left: 8mm; }
    .kop { flex:1; text-align:center; line-height:1.2; padding-right: calc(60px + 8mm); }
    .kop .l1, .kop .l2 { font-weight:bold; font-size:14px; }
    .kop .l3 { font-size:10px; line-height:1.1; }
    .line { border-top:2px solid #000; margin:2px 0 4px; }
    .judul { text-align:center; font-weight:bold; text-decoration:underline; margin:2px 0 4px; font-size:13px; }

    table { border-collapse:collapse; width:100%; }
    .info td { padding:0 1px; vertical-align:top; }
    .info .lbl { width:145px; }
    .info .lbl2 { width:190px; }

    /* =========================
       WATERMARK KHUSUS KOLOM BAKU MUTU
       ========================= */
    .hasil-wrapper {
      position: relative;
      /* overflow: hidden; */ /* aman */
    }
    .hasil-wrapper::before {
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;

      /* MELIPUTI SELURUH TABEL */
      left: 0;
      width: 100%;

      background-image: url("<?= base_url('assets/img/background.png') ?>");
      background-repeat: no-repeat;
      background-position: center center;
      
      /* UTUH, tidak distorsi, di dalam kontainer */
      background-size: contain;

      opacity: 0.15;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
      pointer-events: none;
    }

    /* kunci lebar kolom persen */
    table.hasil { table-layout: fixed; }

    .hasil {
      position: relative;
      background-color: transparent;
    }
    .hasil th, .hasil td {
      border:1px solid #000;
      padding:1px 2px;
      background-color: transparent !important;
    }
    .hasil th { text-align:center; font-weight:bold; }
    .section td {
      font-weight:bold;
      background: rgba(242, 242, 242, 0.7) !important;
    }
    .center { text-align:center; }

    .ket { font-size:10px; margin-top:4px; line-height:1.1; }

    /* proporsi tabel */
    .w-no { width:4%; }
    .w-satuan { width:9%; }
    .w-baku { width:15%; }
    .w-metode { width:19%; }
    .w-hasil { width:14%; }
  </style>
</head>
<body onload="window.print()">

<?php
  // Format tanggal Indonesia
  if (!function_exists('format_indo')) {
    function format_indo($datetime_string, $format = 'tanggal') {
      if (empty($datetime_string) || !strtotime($datetime_string)) return '-';
      $timestamp = strtotime($datetime_string);
      $bulan_indo = [
        1 => 'Januari','Februari','Maret','April','Mei','Juni',
             'Juli','Agustus','September','Oktober','November','Desember'
      ];
      $hari  = date('d', $timestamp);
      $bulan = $bulan_indo[(int)date('m', $timestamp)];
      $tahun = date('Y', $timestamp);

      if ($format === 'tanggal_jam') {
        $jam = date('H.i', $timestamp);
        return "$hari $bulan $tahun / $jam WIB";
      }
      return "$hari $bulan $tahun";
    }
  }

  // Normalisasi nilai agar '-' / kosong tampil rapi
  if (!function_exists('val_or_dash')) {
    function val_or_dash($v) {
      $s = trim((string)$v);
      if ($s === '' || $s === '-' || strtolower($s) === 'null') return '-';
      return $s;
    }
  }

  // Data dari controller
  $no_reg        = $permintaan['no_registrasi'] ?? '-';
  $nama_sampel   = $permintaan['nama_sampel'] ?? '-';
  $kategori_sample = $permintaan['kategori_sample'] ?? '-';
  $jenis_sampel  = $permintaan['jenis_sampel'] ?? '-';
  $lokasi        = $permintaan['lokasi_pengambilan'] ?? '-';
  $nama_pengirim = $permintaan['nama_pengirim'] ?? '-';
  $tgl_pengiriman = $permintaan['tgl_permintaan'] ?? null;
  $kondisi       = $permintaan['status_kelayakan'] ?? '-';

  $petugas_pengambil   = $petugas_pengambil_spesimen_nama ?? '-';
  $tgl_jam_pengambilan = $tgl_jam_pengambilan_display ?? null;
  $tgl_jam_pemeriksaan = $tgl_jam_pemeriksaan_display ?? null;
  $tgl_jam_selesai     = $tgl_jam_selesai_display ?? null;

  // kanan bawah: pakai tgl lapor, fallback tgl selesai, fallback hari ini
  $tgl_kanan = $tgl_jam_lapor_display ?? ($tgl_jam_selesai_display ?? date('Y-m-d'));

  // kategori sampel untuk prefix helper get_kelompok_prefix (mengikuti detail)
  $kategori_sampel = strtolower(str_replace(' ', '_', $permintaan['jenis_sampel'] ?? ''));

  // (tetap dipakai kalau Anda butuh variabel ini di tempat lain)
  $bg_size = 'auto 100%';
?>

  <!-- KOP -->
  <div class="kop-wrap">
    <img class="logo" src="<?= base_url('assets/img/logo.png?v='.time()) ?>" alt="logo" onerror="this.style.display='none';">
    <div class="kop">
      <div class="l1">DINAS KESEHATAN</div>
      <div class="l2">UPTD. LABORATORIUM KESEHATAN</div>
      <div class="l3">
        Jalan Delima Siam VI Girimaya Pangkalpinang Telp. (0717) 9120759<br>
        Pos el : upt-labkesehatan@pangkalpinangkota.go.id
      </div>
    </div>
  </div>
  <div class="line"></div>

  <div class="judul">LAPORAN HASIL UJI</div>

  <!-- IDENTITAS -->
  <table class="info">
    <tr>
      <td style="width:50%; vertical-align:top;">
        <table class="info">
          <tr><td class="lbl">No. Registrasi</td><td>: <?= htmlspecialchars($no_reg) ?></td></tr>
          <tr><td class="lbl">Nama Sampel</td><td>: <?= htmlspecialchars($nama_sampel) ?></td></tr>
          <tr><td class="lbl">Alamat</td><td>: <?= htmlspecialchars($lokasi) ?></td></tr>
          <tr><td class="lbl">Kategori Sampel</td><td>: <?= htmlspecialchars($kategori_sample) ?></td></tr>
          <tr><td class="lbl">Jenis Sampel</td><td>: <?= htmlspecialchars($jenis_sampel) ?></td></tr>
          <tr><td class="lbl">Nama Pengirim</td><td>: <?= htmlspecialchars($nama_pengirim) ?></td></tr>
          <tr><td class="lbl">Tanggal Pengiriman</td><td>: <?= format_indo($tgl_pengiriman, 'tanggal') ?></td></tr>
        </table>
      </td>
      <td style="width:50%; vertical-align:top;">
        <table class="info">
          <tr><td class="lbl2">Petugas Pengambil Sampel</td><td>: <?= htmlspecialchars($petugas_pengambil) ?></td></tr>
          <tr><td class="lbl2">Tgl / Jam Pengambilan Sampel</td><td>: <?= format_indo($tgl_jam_pengambilan, 'tanggal_jam') ?></td></tr>
          <tr><td class="lbl2">Tgl / Jam Pemeriksaan</td><td>: <?= format_indo($tgl_jam_pemeriksaan, 'tanggal_jam') ?></td></tr>
          <tr><td class="lbl2">Tgl / Jam Selesai</td><td>: <?= format_indo($tgl_jam_selesai, 'tanggal_jam') ?></td></tr>
          <tr><td class="lbl2">Kondisi Sampel</td><td>: <?= htmlspecialchars($kondisi) ?></td></tr>
        </table>
      </td>
    </tr>
  </table>

  <!-- TABEL HASIL -->
  <div class="hasil-wrapper">
    <table class="hasil">
      <!-- kunci lebar kolom agar watermark tepat -->
      <colgroup>
        <col style="width:4%">
        <col style="width:42%">
        <col style="width:9%">
        <col style="width:15%">
        <col style="width:16%">
        <col style="width:14%">
      </colgroup>

      <thead>
        <tr>
          <th class="w-no">No.</th>
          <th>JENIS PEMERIKSAAN</th>
          <th class="w-satuan">SATUAN</th>
          <th class="w-baku">BAKU MUTU</th>
          <th class="w-metode">METODE PEMERIKSAAN</th>
          <th class="w-hasil">HASIL PEMERIKSAAN</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($grouped_items) && is_array($grouped_items)): ?>
          <?php foreach ($grouped_items as $kelompok => $items_in_group): ?>
            <?php $item_no = 1; // Reset number for each group ?>
            <tr class="section">
              <td colspan="6"><?= htmlspecialchars($kelompok) ?></td>
            </tr>

            <?php foreach ($items_in_group as $it): ?>
              <tr data-permintaan-item-id="<?= (int)($it['permintaan_item_id'] ?? 0) ?>">
                <td class="center"><?= $item_no++ ?></td>
                <td><?= e_html($it['nama_pemeriksaan']) ?></td>
                <td class="center"><?= e_html($it['satuan']) ?></td>
                <td class="center baku-cell"><?= e_html($it['baku_mutu']) ?></td>
                <td class="center metode-cell"><?= e_html($it['metode']) ?></td>
                <td class="center"><?= e_html($it['hasil'] ?? '-') ?></td>
              </tr>
            <?php endforeach; ?>

          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="center">Data pemeriksaan belum tersedia.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- KETERANGAN -->
  <div class="ket">
    <b>Ket :</b><br>
    1. Kadar maksimum Fisik dan Kimia Air Minum berdasarkan Permenkes RI no. 2 Tahun 2023<br>
    2. Kadar maksimum Sulfat, Klorida berdasarkan Permenkes RI no. 492/Menkes/Per/IV/2010<br>
    3. Angka Lempeng Total (ALT) dihitung sebagai ALT akhir berdasarkan SNI 3554 : 2015<br>
    4. Hasil analisa berlaku hanya untuk sampel yang diuji<br>
    5. Pengambilan sampel diluar tanggung jawab UPTD. Laboratorium Kesehatan Kota Pangkalpinang
  </div>

  <!-- TTD -->
  <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 20px;">
    <!-- KIRI: Petugas & Verifikator -->
    <div style="width: 45%;">
      <table style="border-collapse: collapse; border-top: 1px solid #000; border-bottom: 1px solid #000; width: auto;">
          <tr>
              <td style="width: 85px; padding: 5px 8px; border-bottom: 1px solid #000;">Petugas :</td>
              <td style="width: 200px; font-weight:bold; text-align:left; padding: 5px 8px; border-bottom: 1px solid #000;"><?= isset($petugas_pemeriksa['nama']) ? htmlspecialchars($petugas_pemeriksa['nama']) : '-' ?></td>
          </tr>
          <tr>
              <td style="padding: 5px 8px;">Verifikator :</td>
              <td style="font-weight:bold; text-align:left; padding: 5px 8px;"><?= isset($verifikator['nama']) ? htmlspecialchars($verifikator['nama']) : '-' ?></td>
          </tr>
      </table>
    </div>

    <!-- KANAN: Penanggung Jawab -->
    <div style="width: 45%; text-align: center; line-height: 1.2;">
      Pangkalpinang, <?= format_indo($tgl_kanan, 'tanggal') ?><br>
      <b>PENANGGUNG JAWAB TEKNIS LABORATORIUM KESMAS</b><br>
      UPTD. LABKES KOTA PANGKALPINANG
      <br><br><br><br>
      <b><u><?= isset($penanggung_jawab_teknis['nama']) ? htmlspecialchars($penanggung_jawab_teknis['nama']) : '____________________' ?></u></b><br>
      NIP. <?= isset($penanggung_jawab_teknis['nip']) ? htmlspecialchars($penanggung_jawab_teknis['nip']) : '____________________' ?>
    </div>
  </div>

<script>
  // Skrip untuk menerapkan override dari localStorage, sama seperti di detail view
  document.addEventListener('DOMContentLoaded', function(){
    try {
      const permintaanId = <?= (int)($permintaan['id'] ?? 0) ?>;
      const key = 'permintaan_overrides_' + permintaanId;
      const raw = localStorage.getItem(key);
      if (!raw) return;
      const overrides = JSON.parse(raw || '{}');
      Object.keys(overrides).forEach(pid => {
        const row = document.querySelector('tr[data-permintaan-item-id="' + pid + '"]');
        if (!row) return;
        const bakuCell = row.querySelector('.baku-cell');
        const metodeCell = row.querySelector('.metode-cell');
        const obj = overrides[pid] || {};
        if (obj.baku_mutu && bakuCell) {
          bakuCell.innerHTML = obj.baku_mutu;
        }
        if (obj.metode && metodeCell) {
          metodeCell.innerHTML = obj.metode;
        }
      });
    } catch (e) {
      // silently ignore apply errors
    }
  });
</script>

</body>
</html>
