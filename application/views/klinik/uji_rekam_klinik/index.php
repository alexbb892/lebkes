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
                    <span>RIWAYAT KUNJUNGAN PASIEN KLINIK <?= !empty($this->input->get('search')) ? '<span class="badge bg-primary text-sm ms-2">Pencarian: "' . htmlspecialchars($this->input->get('search')) . '"</span>' : '' ?></span>
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

                <style>
                    .search-box-container {
                        transition: all 0.3s ease;
                        border: 1px solid #ced4da;
                        overflow: hidden;
                    }
                    .search-box-container:focus-within {
                        border-color: #1e3a8a !important;
                        box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.15) !important;
                    }
                    #custom-search:focus {
                        outline: none;
                        box-shadow: none;
                    }
                    #btn-search:hover {
                        background-color: #152962 !important;
                    }
                </style>

                <div class="card shadow-sm w-100">
                    <div class="card-body p-3">
                        <!-- Custom Search Box -->
                        <form action="<?= site_url('uji_rekam_klinik') ?>" method="get">
                            <div class="row mb-3">
                                <div class="col-12 col-md-4 ms-auto">
                                    <div class="input-group shadow-sm rounded search-box-container">
                                        <span class="input-group-text bg-white border-0">
                                            <i class="fas fa-search text-primary"></i>
                                        </span>
                                        <input type="text" name="search" id="custom-search" class="form-control border-0 ps-0" placeholder="Cari nama atau NIK..." value="<?= htmlspecialchars($this->input->get('search') ?? '') ?>" style="box-shadow: none;">
                                        <button class="btn btn-primary border-0 px-4" type="submit" id="btn-search" style="background-color: #1e3a8a; border-radius: 0;">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table id="tabel-kunjungan" class="table table-bordered table-striped table-hover nowrap"
                                style="width:100%">
                                <thead style="background-color: #d1e3ff;">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="15%">No. RM</th>
                                        <th width="30%">Nama Pasien</th>
                                        <th width="20%">NIK</th>
                                        <th width="10%">Jenis Kelamin</th>
                                        <th width="10%" class="text-center">Total Uji Lab</th>
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
                                                    <span class="badge bg-success p-2 rounded-pill"><?= $p->total_uji ?> Kali</span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= site_url('klinik/uji_rekam_klinik/detail/' . $p->id_pasien) ?>"
                                                        class="btn btn-sm btn-primary text-white" title="Lihat Riwayat Pemeriksaan">
                                                        <i class="fas fa-eye me-1"></i>Lihat Riwayat
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
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            var table = $('#tabel-kunjungan').DataTable({
                responsive: true,
                autoWidth: false,
                dom: 'lrtip', // Hide default DataTable search filter ('f')
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        });
    </script>