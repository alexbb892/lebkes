<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <?php
            setlocale(LC_TIME, 'id_ID');
            date_default_timezone_set('Asia/Jakarta');

            $hariIndo = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
            $bulanIndo = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'];

            $hari = $hariIndo[date('l')];
            $tanggal = date('d');
            $bulan = $bulanIndo[date('F')];
            $tahun = date('Y');
            $tanggalLengkap = "$hari, $tanggal $bulan $tahun";
            ?>
            <h3 class="text-dark fw-bold mb-4 d-flex justify-content-between align-items-center">
                <span>DATA KUNJUNGAN PASIEN REKAM MEDIS</span>
                <small class="text-muted fw-normal"><?= $tanggalLengkap ?></small>
            </h3>
            <hr style="border-top: 2px solid #1e3a8a; margin-bottom: 20px;">

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm w-100">
                <div class="card-body table-responsive p-3">
                    <table id="tabel-kunjungan" class="table table-bordered table-striped table-hover nowrap"
                        style="width:100%">
                        <thead style="background-color: #d1e3ff;">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="15%">No. RM</th>
                                <th width="20%">Nama Pasien</th>
                                <th width="15%">NIK</th>
                                <th width="10%">Jenis Kelamin</th>
                                <th width="15%" class="text-center">Riwayat Kunjungan</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pasien)): ?>
                                <?php $no = 1;
                                foreach ($pasien as $p): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($p->no_rm) ?></td>
                                        <td><?= htmlspecialchars($p->nama_pasien) ?></td>
                                        <td><?= htmlspecialchars($p->nik) ?></td>
                                        <td><?= ($p->gender == 'Laki-laki') ? 'L' : 'P' ?></td>
                                        <td class="text-center">
                                            <?php if (isset($p->total_kunjungan) && $p->total_kunjungan > 0): ?>
                                                <span class="badge bg-success p-2 rounded-pill"><?= $p->total_kunjungan ?>
                                                    Kali</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary p-2 rounded-pill">Belum ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                <a href="<?= site_url('klinik/uji_rekam_medis/detail/' . $p->id_pasien) ?>"
                                                    class="btn btn-sm btn-info text-white" title="Pengisian Detail Kunjungan">
                                                    <i class="fas fa-eye me-1"></i>Lihat Kunjungan
                                                </a>
                                                <a href="<?= site_url('klinik/uji_rekam_medis/tambah_kunjungan/' . $p->id_pasien) ?>"
                                                    class="btn btn-sm btn-primary text-white" title="Pengisian Detail Kunjungan">
                                                    <i class="fas fa-plus me-1"></i> Tambah SOAP
                                                </a>
                                                </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        $('#tabel-kunjungan').DataTable({
            responsive: true,
            autoWidth: false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>