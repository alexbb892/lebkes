<div class="content-wrapper px-4 pt-4">
    <?php
        setlocale(LC_TIME, 'id_ID');
        date_default_timezone_set('Asia/Jakarta');

        // Buat tanggal dengan format manual dalam bahasa Indonesia
        $hariIndo = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu'
        ];

        $bulanIndo = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember'
        ];

        $hari = $hariIndo[date('l')];
        $tanggal = date('d');
        $bulan = $bulanIndo[date('F')];
        $tahun = date('Y');
        $tanggalLengkap = "$hari, $tanggal $bulan $tahun";
    ?>
    <h3 class="text-dark fw-bold mb-4 d-flex justify-content-between align-items-center">
        <span>FORMULIR PERMINTAAN PEMERIKSAAN</span>
        <small class="text-muted fw-normal"><?= $tanggalLengkap ?></small>
    </h3>
    <a href="<?= site_url('klinik/form_permintaan_klinik/create') ?>" class="btn btn-success mb-3 shadow-sm px-4 py-2 d-inline-flex align-items-center">
        <i class="fas fa-plus me-2"></i> Tambah Data
    </a>
    <div class="card shadow-sm w-100">
        <div class="card-body table-responsive p-3"> <!-- Tambahkan padding di sini -->
            <table id="tabel-permintaan" class="table table-bordered table-striped table-hover nowrap" style="width:100%">
                <thead class="bg-light">
                <tr>
                    <th>No</th>
                    <th>No. Register</th>
                    <th>Nama Pasien</th>
                    <th>NIK</th>
                    <th>Jenis Kelamin</th>
                    <th>Nama Dokter</th>
                    <th>Tanggal Form</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?php if (!empty($formulir)): ?>
                        <?php $no = 1; foreach ($formulir as $f): ?>

                        <?php
                        // ❗ Kuning jika kelayakan = Belum Diperiksa
                        $belumDiperiksa = ($f->kelayakan === 'Belum Diperiksa');

                        // Jika belum diperiksa → beri warna kuning
                        $rowStyle = $belumDiperiksa ? 'style="background-color: #fff3cd;"' : '';
                        ?>

                        <tr <?= $rowStyle ?>>
                            <td><?= $no++ ?></td>
                            <td><?= $f->no_register ?></td>
                            <td><?= !empty($f->nama_pasien) ? $f->nama_pasien : ($f->nama ?? '-') ?></td>
                            <td><?= $f->nik ?></td>
                            <td><?= $f->gender ?></td>
                            <td><?= $f->nama_dokter ?></td>
                            <td><?= date('d-m-Y', strtotime($f->tgl_form)) ?></td>

                            <td>
                                <a href="<?= site_url('klinik/form_permintaan_klinik/detail/' . $f->id) ?>"
                                class="btn btn-sm btn-outline-primary me-1" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="<?= site_url('klinik/form_permintaan_klinik/edit/' . $f->id) ?>"
                                class="btn btn-sm btn-outline-success me-1" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <a href="<?= site_url('klinik/form_permintaan_klinik/delete/' . $f->id) ?>"
                                class="btn btn-sm btn-outline-danger"
                                title="Hapus"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>  
    </div>
</div>