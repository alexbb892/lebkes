<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">

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

            <div class="d-flex justify-content-start mb-3">
                <div class="col-md-8 col-12 d-flex justify-content-start">
                    <a href="<?= site_url('klinik/uji_rekam_klinik') ?>"
                        class="btn btn-secondary text-white px-4 rounded-1 shadow-sm" style="font-weight: 500;">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Card Identitas Pasien -->
            <div class="card shadow-sm border-0 mb-4 rounded-3 d-flex flex-column h-100">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 text-secondary" style="font-weight: 500;">Identitas Pasien</h5>
                </div>
                <div class="card-body bg-white rounded-bottom-3" style="font-size: 14px;">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3 mb-md-0 border-end">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td width="35%" class="fw-bold text-dark">Nama</td>
                                    <td class="text-secondary">: <?= htmlspecialchars($pasien->nama_pasien) ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-dark">NIK</td>
                                    <td class="text-secondary">: <?= htmlspecialchars($pasien->nik) ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-dark">Jenis Kelamin</td>
                                    <td class="text-secondary">: <?= htmlspecialchars($pasien->gender) ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-dark">Agama</td>
                                    <td class="text-secondary">:
                                        <?= isset($pasien->agama) && $pasien->agama != '' ? htmlspecialchars($pasien->agama) : '-' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-dark">Status Pernikahan</td>
                                    <td class="text-secondary">:
                                        <?= isset($pasien->status_nikah) && $pasien->status_nikah != '' ? htmlspecialchars($pasien->status_nikah) : '-' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-dark">Pendidikan</td>
                                    <td class="text-secondary">:
                                        <?= isset($pasien->pendidikan) && $pasien->pendidikan != '' ? htmlspecialchars($pasien->pendidikan) : '-' ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-md-6 ps-md-4">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td width="40%" class="fw-bold text-dark">No. RM</td>
                                    <td class="text-secondary">: <?= htmlspecialchars($pasien->no_rm) ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-dark">Tanggal Lahir / Umur</td>
                                    <td class="text-secondary">
                                        : <?= date('d M Y', strtotime($pasien->tgl_lahir)) ?> / <?= $pasien->umur ?> thn
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-dark">No. Telepon</td>
                                    <td class="text-secondary">:
                                        <?= isset($pasien->no_telp) && $pasien->no_telp != '' ? htmlspecialchars($pasien->no_telp) : '-' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-dark">Pekerjaan</td>
                                    <td class="text-secondary">:
                                        <?= isset($pasien->pekerjaan) && $pasien->pekerjaan != '' ? htmlspecialchars($pasien->pekerjaan) : '-' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-dark">Alamat Lengkap</td>
                                    <td class="text-secondary">:
                                        <?= isset($pasien->alamat) && $pasien->alamat != '' ? htmlspecialchars($pasien->alamat) : '-' ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Riwayat Uji Klinik -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 text-secondary" style="font-weight: 500;">Riwayat Hasil Pemeriksaan Uji Lab Klinik</h5>
                </div>
                <div class="card-body bg-white rounded-bottom-3 p-3 p-md-4">
                    <div class="table-responsive">
                        <table id="tabel-detail-kunjungan" class="table table-bordered table-hover w-100"
                             style="font-size: 14px;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th width="5%" class="text-center align-middle py-3">No</th>
                                    <th width="15%" class="align-middle py-3">No. Register</th>
                                    <th width="15%" class="align-middle py-3">Tanggal Form</th>
                                    <th width="20%" class="align-middle py-3">Dokter Pengirim</th>
                                    <th width="20%" class="align-middle py-3">Diagnosa Klinis</th>
                                    <th width="15%" class="align-middle py-3">Status Hasil</th>
                                    <th width="10%" class="align-middle py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($riwayat)): ?>
                                    <?php $no = 1;
                                    foreach ($riwayat as $r): ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= $no++ ?></td>
                                            <td class="align-middle"><?= htmlspecialchars($r->no_register) ?></td>
                                            <td class="align-middle text-secondary">
                                                <?php
                                                $indo_months = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                                                $t = strtotime($r->tgl_form);
                                                echo date('d', $t) . ' ' . $indo_months[(int) date('m', $t)] . ' ' . date('Y', $t);
                                                ?>
                                            </td>
                                            <td class="align-middle"><?= htmlspecialchars($r->nama_dokter) ?></td>
                                            <td class="align-middle text-secondary"><?= htmlspecialchars($r->diagnosa_klinis) ?></td>
                                            <td class="align-middle">
                                                <?php if ($r->hasil_diisi > 0): ?>
                                                    <span class="badge bg-success" style="padding: 6px 12px; font-weight: 500;">Sudah Diinput</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning" style="padding: 6px 12px; font-weight: 500;">Belum Diinput</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php if ($r->hasil_diisi > 0): ?>
                                                    <a href="<?= site_url('klinik/laporan_uji_klinik/detail/' . $r->id) ?>" class="btn btn-sm btn-info text-white shadow-sm" style="font-size:12px; font-weight:500;">
                                                        <i class="fas fa-eye me-1"></i> Lihat Hasil
                                                    </a>
                                                <?php else: ?>
                                                    <?php
                                                    $user_role = strtolower((string) $this->session->userdata('role'));
                                                    if ($user_role === 'admin' || $user_role === 'pemeriksa sampel'):
                                                    ?>
                                                        <a href="<?= site_url('klinik/uji_klinik/input/' . $r->id) ?>" class="btn btn-sm btn-primary text-white shadow-sm" style="font-size:12px; font-weight:500;">
                                                            <i class="fas fa-edit me-1"></i> Input Hasil
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted" style="font-size: 12px; font-style: italic;">Menunggu Input</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        $('#tabel-detail-kunjungan').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json",
                "emptyTable": "Belum ada riwayat pemeriksaan."
            },
            "lengthMenu": [[10, 25, 50, -1], ["10 Baris", "25 Baris", "50 Baris", "Semua"]],
            "searching": false,
            "info": false
        });
    });
</script>
