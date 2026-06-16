<?php
/**
 * Uji List View
 * 
 * @var string $title - Page title
 * @var array $rows - List of permintaan data
 * @var array $filters - Filter parameters
 */
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
  :root{
    --ink:#0b1220;
    --muted:#667085;
    --line: rgba(15,23,42,.10);
    --glass: rgba(255,255,255,.70);
    --shadow: 0 22px 70px rgba(2,6,23,.12);
    --shadow2: 0 12px 30px rgba(2,6,23,.10);
    --ring: rgba(13,110,253,.20);
    --brand:#0d6efd;
    --brand2:#0b5ed7;
  }

  .page-hero{
    border-radius: 26px;
    border: 1px solid rgba(15,23,42,.10);
    background:
      radial-gradient(900px 340px at 12% 10%, rgba(13,110,253,.20), transparent 62%),
      radial-gradient(900px 340px at 92% 20%, rgba(34,197,94,.10), transparent 62%),
      linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.70));
    box-shadow: var(--shadow);
    padding: 1.25rem 1.35rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    animation: slideInDown 0.6s ease-out;
    margin-bottom: 2rem;
  }

  .page-hero:hover {
    transform: translateY(-2px);
    box-shadow: 0 28px 80px rgba(2,6,23,.15);
  }

  @keyframes slideInDown {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .page-hero h3{
    margin: 0;
    font-weight: 950;
    letter-spacing: -.5px;
    color: var(--ink);
    font-size: 1.8rem;
  }

  .page-hero .sub{
    color: var(--muted);
    margin-top: .25rem;
    font-size: 0.93rem;
    letter-spacing: 0.3px;
  }

  .btn-add{
    border-radius: 16px;
    font-weight: 900;
    letter-spacing: .2px;
    padding: .75rem 1.3rem;
    border: none;
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    box-shadow: 0 18px 34px rgba(13,110,253,.25);
    color: white !important;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-add:hover {
    transform: translateY(-3px);
    box-shadow: 0 24px 50px rgba(13,110,253,.35);
    background: linear-gradient(135deg, #0b5ed7 0%, #0a3f99 100%);
    color: white !important;
  }

  .btn-add:active {
    transform: translateY(-1px);
    box-shadow: 0 12px 24px rgba(13,110,253,.3);
  }

  .filter-shell{
    border-radius: 22px;
    border: 1px solid rgba(15,23,42,.10);
    background: var(--glass);
    backdrop-filter: blur(12px);
    box-shadow: var(--shadow2);
    padding: 1.1rem;
    transition: all 0.3s ease;
    animation: fadeInUp 0.6s ease-out 0.1s both;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .filter-shell:hover {
    border-color: rgba(13,110,253,.2);
    box-shadow: 0 16px 40px rgba(2,6,23,.12);
  }

  .filter-shell .form-control{
    border-radius: 14px;
    border-color: rgba(15,23,42,.12);
    padding: .8rem 1rem;
    transition: all 0.3s ease;
    font-weight: 500;
  }

  .filter-shell .form-control:focus{
    border-color: rgba(13,110,253,.5);
    box-shadow: 0 0 0 .25rem var(--ring);
    transform: translateY(-1px);
  }

  .btn-filter{
    border-radius: 14px;
    font-weight: 900;
    padding: .8rem 1rem;
    transition: all 0.3s ease;
  }

  .btn-filter:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(13,110,253,.15);
  }

  .card-wow{
    border-radius: 22px;
    border: 1px solid rgba(15,23,42,.10);
    box-shadow: var(--shadow2);
    overflow: hidden;
    background: rgba(255,255,255,.90);
    transition: all 0.4s ease;
    animation: fadeInUp 0.6s ease-out 0.2s both;
  }

  .card-wow:hover {
    border-color: rgba(13,110,253,.15);
    box-shadow: 0 20px 50px rgba(2,6,23,.15);
  }

  .table thead th{
    background: linear-gradient(135deg, rgba(248,250,252,.95) 0%, rgba(240,245,252,.95) 100%);
    border-bottom: 2px solid rgba(13,110,253,.1);
    font-weight: 900;
    color: #1e293b;
    padding: 1rem .9rem;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
  }

  .table tbody td{
    padding: 1rem .9rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(15,23,42,.05);
  }

  .btn-action{
    border-radius: 12px;
    font-weight: 700;
    padding: .55rem .85rem;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    font-size: 0.85rem;
    border: none;
    letter-spacing: 0.3px;
  }

  .btn-action i { 
    margin-right: .3rem;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: inline-block;
  }

  .btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,.15);
  }

  .btn-action:hover i {
    transform: scale(1.15) rotate(10deg);
  }

  .btn-action.btn-primary {
    color: #ffffff;
    border: none;
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
  }

  .btn-action.btn-primary:hover {
    background: linear-gradient(135deg, #0b5ed7 0%, #0a3f99 100%);
    box-shadow: 0 8px 24px rgba(13, 110, 253, 0.4);
  }

  .btn-action.btn-primary:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
  }

  .row-hover {
    transition: all 0.3s ease;
  }

  .row-hover:hover td{
    background: linear-gradient(90deg, rgba(13,110,253,.04) 0%, transparent 100%);
  }

  .empty-state{
    padding: 3rem 1.5rem;
    color: var(--muted);
    animation: fadeIn 0.5s ease-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  .alert-info {
    border-radius: 14px;
    border: 1px solid rgba(13,110,253,.2);
    background: rgba(13,110,253,.05);
    color: #0b5ed7;
  }

  @media (max-width: 767.98px){
    .page-hero{ padding: 1.1rem; border-radius: 22px; }
    .page-hero h3 { font-size: 1.25rem; }
    .filter-shell{ border-radius: 18px; padding: 0.9rem; }
    .card-wow{ border-radius: 18px; }
    .table { font-size: 0.85rem; }
    .btn-action { padding: 0.4rem 0.6rem; font-size: 0.75rem; }
  }
</style>

<div class="page-hero mb-4">
  <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
    <div>
      <a class="btn btn-outline-secondary btn-sm me-2" href="javascript:history.back();" style="border-radius: 10px; padding: 0.5rem 0.9rem; font-weight: 600;">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
      <h3 style="display:inline-block; margin:0;">Input Hasil 📝</h3>
      <div class="sub">Pilih permintaan untuk input hasil pemeriksaan</div>
    </div>
  </div>
</div>

<form class="filter-shell row g-2 mb-4" method="get">
  <div class="col-12 mb-2">
    <div class="alert alert-info small mb-0" style="border-radius: 12px;">
      ℹ️ Daftar ini menampilkan <strong>hanya permintaan yang sudah dikaji ulang dan berstatus <em>Layak</em></strong>.
      Centang untuk menampilkan juga permintaan yang belum layak atau belum dikaji ulang.
    </div>
  </div>
  <div class="col-12 mb-2">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" id="show_all" name="show_all" value="1" <?= (isset($filters['show_all']) && $filters['show_all']=='1') ? 'checked' : '' ?>>
      <label class="form-check-label small fw-bold" for="show_all">Tampilkan semua (termasuk Tidak Layak / Belum Kaji Ulang)</label>
    </div>
  </div>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-text bg-transparent border-0" style="color:#0d6efd; font-weight: 700;"><i class="bi bi-search"></i></span>
      <input class="form-control" name="q" placeholder="🔍 Cari no. registrasi / nama sampel" value="<?= htmlspecialchars($filters['q'] ?? '') ?>">
    </div>
  </div>
  <div class="col-md-2">
    <label class="form-label small fw-bold" style="color: #64748b; margin-bottom: 0.3rem;">Dari</label>
    <input class="form-control" type="date" name="dari" value="<?= htmlspecialchars($filters['dari'] ?? '') ?>">
  </div>
  <div class="col-md-2">
    <label class="form-label small fw-bold" style="color: #64748b; margin-bottom: 0.3rem;">Sampai</label>
    <input class="form-control" type="date" name="sampai" value="<?= htmlspecialchars($filters['sampai'] ?? '') ?>">
  </div>
  <div class="col-md-2">
    <label class="form-label small fw-bold" style="color: #64748b; margin-bottom: 0.3rem;">&nbsp;</label>
    <button class="btn btn-outline-primary btn-filter w-100" style="font-weight: 700;">
      <i class="bi bi-funnel me-1" aria-hidden="true"></i> Filter
    </button>
  </div>
</form>

<div class="card card-wow">
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
            <th class="text-end">⚙️ Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr class="row-hover">
              <td class="fw-semibold" style="color: #0b1220;"><?= htmlspecialchars($r['no_registrasi']) ?></td>
              <td style="color: #475569; font-weight: 600;"><?= htmlspecialchars($r['nama_sampel']) ?></td>
              <td><?= htmlspecialchars($r['jenis_sampel']) ?></td>
              <td>
                <span style="display: inline-flex; align-items: center; gap: 0.35rem; color: #64748b; font-size: 0.85rem; padding: 0.3rem 0.6rem; background: rgba(100,112,179,.06); border-radius: 8px; border: 1px solid rgba(100,112,179,.15);">
                  <i class="bi bi-calendar3" aria-hidden="true"></i>
                  <?= htmlspecialchars($r['tgl_permintaan'] ?? '-') ?>
                </span>
              </td>
              <td>
                <span class="badge bg-secondary" style="border-radius: 8px;"><i class="bi bi-list-check me-1"></i><?= $r['jumlah_pemeriksaan'] ?? 0 ?> Item</span>
              </td>
              <td class="text-end">
                <a class="btn btn-sm btn-action btn-primary" href="<?= site_url('kesmas/uji/input/'.$r['id']) ?>" title="Input hasil pemeriksaan">
                  <i class="bi bi-pencil"></i><span class="d-none d-md-inline">Input</span>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($rows)): ?>
            <tr>
              <td colspan="5" class="text-center">
                <div class="empty-state">
                  <div style="width: 64px; height: 64px; border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(13,110,253,.15) 0%, rgba(100,200,255,.08) 100%); border: 2px solid rgba(13,110,253,.25); color: #0b5ed7; box-shadow: 0 12px 30px rgba(13,110,253,.12); margin-bottom: 1rem; font-size: 1.8rem;">
                    <i class="bi bi-inbox"></i>
                  </div>
                  <div class="fw-bold" style="color:#334155; font-size: 1.05rem;">📭 Belum ada data</div>
                  <div class="small text-muted">Tidak ada permintaan yang siap untuk input hasil.</div>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
