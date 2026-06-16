<div class="container my-4">
    <h2><?php echo $title; ?></h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Total Survei</h5>
                    <h2><?php echo $stats['total_survei']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Rata-rata Pelayanan</h5>
                    <h2><?php echo $stats['avg_pelayanan']; ?> / 5</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Rata-rata Fasilitas</h5>
                    <h2><?php echo $stats['avg_fasilitas']; ?> / 5</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Survei</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Permintaan ID</th>
                            <th>Pelayanan</th>
                            <th>Fasilitas</th>
                            <th>Komentar</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($survei as $s): ?>
                        <tr>
                            <td><strong><?php echo $s['permintaan_id']; ?></strong></td>
                            <td>
                                <span class="badge <?php echo $s['skor_pelayanan'] >= 4 ? 'badge-success' : ($s['skor_pelayanan'] >= 3 ? 'badge-warning' : 'badge-danger'); ?>">
                                    <?php echo str_repeat('⭐', $s['skor_pelayanan']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?php echo $s['skor_fasilitas'] >= 4 ? 'badge-success' : ($s['skor_fasilitas'] >= 3 ? 'badge-warning' : 'badge-danger'); ?>">
                                    <?php echo str_repeat('⭐', $s['skor_fasilitas']); ?>
                                </span>
                            </td>
                            <td><small><?php echo strlen($s['komentar_saran']) > 50 ? substr($s['komentar_saran'], 0, 50) . '...' : $s['komentar_saran']; ?></small></td>
                            <td><small><?php echo date('d/m/Y H:i', strtotime($s['tgl_survei'])); ?></small></td>
                            <td>
                                <a href="<?php echo base_url('kesmas/survei/view/' . $s['id']); ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
