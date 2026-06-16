<?php
/**
 * Laporan List View
 * 
 * @var string $title - Page title
 * @var array $rows - List of laporan data
 * @var array $filters - Filter parameters
 */
?>
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <a class="btn btn-outline-secondary btn-sm me-2" href="javascript:history.back();"><i class="fa fa-arrow-left"></i> Kembali</a>
    <h3 class="mb-0 d-inline-block">Laporan Uji</h3>
    <div class="text-muted">Filter dan buka detail</div>
  </div>
  <div>
    <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('kesmas/laporan_uji_kesmas/parameter') ?>">Laporan Parameter</a>
  </div>
</div>

<form class="row g-2 mb-3" method="get">
  <div class="col-md-4">
    <input class="form-control" name="q" placeholder="Cari no. registrasi / nama sampel" value="<?= htmlspecialchars($filters['q'] ?? '') ?>">
  </div>
  <div class="col-md-2">
    <input class="form-control" type="date" name="dari" value="<?= htmlspecialchars($filters['dari'] ?? '') ?>">
  </div>
  <div class="col-md-2">
    <input class="form-control" type="date" name="sampai" value="<?= htmlspecialchars($filters['sampai'] ?? '') ?>">
  </div>
  <div class="col-md-2">
    <button class="btn btn-outline-primary w-100">Filter</button>
  </div>
</form>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-sm table-hover mb-0">
        <thead>
          <tr>
            <th>📌 No Registrasi</th>
            <th>🧪 Nama Sampel</th>
            <th>🏷️ Jenis</th>
            <th>📅 Tgl Permintaan</th>
            <th>📋 Jml Pemeriksaan</th>
            <th>🧑‍🔬 Petugas Pengambil</th>
            <th class="text-end">⚙️ Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td class="fw-semibold"><?= htmlspecialchars($r['no_registrasi']) ?></td>
              <td><?= htmlspecialchars($r['nama_sampel']) ?></td>
              <td><?= htmlspecialchars($r['jenis_sampel']) ?></td>
              <td><?= htmlspecialchars($r['tgl_permintaan'] ?? '-') ?></td>
              <td><span class="badge bg-secondary" style="border-radius: 8px;"><i class="bi bi-list-check me-1"></i><?= htmlspecialchars($r['jumlah_pemeriksaan'] ?? 0) ?> Item</span></td>
              <td><?= htmlspecialchars($r['petugas_pengambil_nama'] ?? '-') ?></td>
              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary" href="<?= site_url('kesmas/laporan_uji_kesmas/detail/'.$r['id']) ?>">Detail</a>
                <a class="btn btn-sm btn-primary" href="<?= site_url('kesmas/laporan_uji_kesmas/print/'.$r['id']) ?>" target="_blank" rel="noopener">Cetak</a>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($rows)): ?>
            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
