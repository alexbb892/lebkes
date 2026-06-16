<?php
/**
 * Permintaan List View
 * 
 * @var string $title - Page title
 * @var array $rows - List of permintaan data
 * @var array $filters - Filter parameters
 */
?>
<!-- Optional (kalau belum ada di layout/header): Bootstrap Icons -->
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

  /* ===== ENHANCED STYLES ===== */
  
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
    background: linear-gradient(135deg, #0b1220 0%, #0d6efd 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
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

  .badge-soft{
    border-radius: 999px;
    padding: .5rem .8rem;
    font-weight: 800;
    border: 1.5px solid;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    cursor: default;
  }

  .badge-soft:hover {
    transform: translateY(-2px);
  }

  .badge-air { 
    border-color: rgba(13,110,253,.35); 
    background: linear-gradient(135deg, rgba(13,110,253,.12) 0%, rgba(100,200,255,.08) 100%);
    color: #0b5ed7;
    box-shadow: 0 4px 12px rgba(13,110,253,.15);
  }

  .badge-makanan{ 
    border-color: rgba(245,158,11,.35); 
    background: linear-gradient(135deg, rgba(245,158,11,.12) 0%, rgba(255,180,50,.08) 100%);
    color: #b45309;
    box-shadow: 0 4px 12px rgba(245,158,11,.15);
  }

  .badge-lingkungan{ 
    border-color: rgba(34,197,94,.35);
    background: linear-gradient(135deg, rgba(34,197,94,.12) 0%, rgba(100,220,150,.08) 100%);
    color: #15803d;
    box-shadow: 0 4px 12px rgba(34,197,94,.15);
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

  .btn-action:hover i {
    transform: scale(1.15) rotate(10deg);
  }

  .btn-action.btn-success:hover i {
    color: #fff;
  }

  /* ===== PREMIUM SOLID BUTTON STYLES ===== */
  
  .btn-action.btn-outline-primary {
    color: #ffffff;
    border: none;
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
  }

  .btn-action.btn-outline-primary:hover {
    background: linear-gradient(135deg, #0b5ed7 0%, #0a3f99 100%);
    box-shadow: 0 8px 24px rgba(13, 110, 253, 0.4);
    transform: translateY(-2px);
  }

  .btn-action.btn-outline-primary:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
  }

  .btn-action.btn-outline-warning {
    color: #ffffff;
    border: none;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
  }

  .btn-action.btn-outline-warning:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
    transform: translateY(-2px);
  }

  .btn-action.btn-outline-warning:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
  }

  .btn-action.btn-outline-secondary {
    color: #ffffff;
    border: none;
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
  }

  .btn-action.btn-outline-secondary:hover {
    background: linear-gradient(135deg, #4b5563 0%, #2d3748 100%);
    box-shadow: 0 8px 24px rgba(107, 114, 128, 0.4);
    transform: translateY(-2px);
  }

  .btn-action.btn-outline-secondary:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(107, 114, 128, 0.3);
  }

  .btn-action.btn-outline-danger {
    color: #ffffff;
    border: none;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
  }

  .btn-action.btn-outline-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    box-shadow: 0 8px 24px rgba(239, 68, 68, 0.4);
    transform: translateY(-2px);
  }

  .btn-action.btn-outline-danger:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
  }

  .btn-action.btn-danger {
    color: #ffffff;
    border: none;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
  }

  .btn-action.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    box-shadow: 0 8px 24px rgba(239, 68, 68, 0.4);
    transform: translateY(-2px);
  }

  .btn-action.btn-danger:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
  }

  .btn-action.btn-success {
    color: #ffffff;
    border: none;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
  }

  .btn-action.btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
    transform: translateY(-2px);
  }

  .btn-action.btn-success:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
  }

  .btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,.1);
  }

  .btn-outline-primary.btn-action {
    color: #0d6efd;
    border-color: rgba(13,110,253,.4);
    background: rgba(13,110,253,.05);
  }

  .btn-outline-primary.btn-action:hover {
    background: rgba(13,110,253,.1);
    color: #0b5ed7;
    border-color: rgba(13,110,253,.6);
  }

  .btn-outline-warning.btn-action {
    color: #b45309;
    border-color: rgba(180,83,9,.4);
    background: rgba(245,158,11,.05);
  }

  .btn-outline-warning.btn-action:hover {
    background: rgba(245,158,11,.1);
    color: #a16207;
    border-color: rgba(180,83,9,.6);
  }

  .btn-outline-secondary.btn-action {
    color: #6b7280;
    border-color: rgba(107,114,128,.3);
    background: rgba(107,114,128,.05);
  }

  .btn-outline-secondary.btn-action:hover {
    background: rgba(107,114,128,.1);
    border-color: rgba(107,114,128,.5);
  }

  .btn-outline-danger.btn-action {
    color: #dc2626;
    border-color: rgba(220,38,38,.4);
    background: rgba(220,38,38,.05);
  }

  .btn-outline-danger.btn-action:hover {
    background: rgba(220,38,38,.1);
    color: #b91c1c;
    border-color: rgba(220,38,38,.6);
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

  .empty-icon{
    width: 64px;
    height: 64px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(13,110,253,.15) 0%, rgba(100,200,255,.08) 100%);
    border: 2px solid rgba(13,110,253,.25);
    color: #0b5ed7;
    box-shadow: 0 12px 30px rgba(13,110,253,.12);
    margin-bottom: 1rem;
    font-size: 1.8rem;
    transition: all 0.3s ease;
  }

  .empty-icon:hover {
    transform: scale(1.1) rotate(-5deg);
    box-shadow: 0 16px 40px rgba(13,110,253,.2);
  }

  .row-hover {
    transition: all 0.3s ease;
  }

  .row-hover:hover td{
    background: linear-gradient(90deg, rgba(13,110,253,.04) 0%, transparent 100%);
  }

  .row-hover:hover {
    box-shadow: inset 0 0 20px rgba(13,110,253,.08);
  }

  .no-reg-text {
    font-weight: 700;
    color: #0b1220;
    font-size: 0.95rem;
  }

  .sampel-text {
    color: #475569;
    font-weight: 500;
  }

  .date-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    color: #64748b;
    font-size: 0.85rem;
    padding: 0.3rem 0.6rem;
    background: rgba(100,112,179,.06);
    border-radius: 8px;
    border: 1px solid rgba(100,112,179,.15);
  }

  @media (max-width: 767.98px){
    .page-hero{ padding: 1.1rem; border-radius: 22px; }
    .page-hero h3 { font-size: 1.25rem; }
    .filter-shell{ border-radius: 18px; padding: 0.9rem; }
    .card-wow{ border-radius: 18px; }
    .table { font-size: 0.85rem; }
    .btn-action { padding: 0.4rem 0.6rem; font-size: 0.75rem; }
    .badge-soft { padding: 0.4rem 0.6rem; font-size: 0.75rem; }
  }
</style>

<!-- HERO HEADER -->
<div class="page-hero mb-4">
  <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
    <div>
      <a class="btn btn-outline-secondary btn-sm me-2" href="javascript:history.back();" style="border-radius: 10px; padding: 0.5rem 0.9rem; font-weight: 600; transition: all 0.3s ease;">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
      <h3 style="display:inline-block; margin:0; font-size: 1.8rem;"><?= htmlspecialchars($title) ?></h3>
      <div class="sub">📋 Kelola dan pantau semua permintaan pendaftaran sampel</div>
    </div>
    <?php if ($title !== 'Terima Sample'): ?>
    <a class="btn btn-primary btn-add" href="<?= site_url('kesmas/form_permintaan_kesmas/create') ?>">
      <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Tambah Baru
    </a>
    <?php endif; ?>
  </div>
</div>

<!-- FILTER -->
<form class="filter-shell row g-2 mb-4" method="get">
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-text bg-transparent border-0" style="color:#0d6efd; font-weight: 700;"><i class="bi bi-search"></i></span>
      <input class="form-control" name="q" placeholder="🔍 Cari no. reg / sampel / jenis / pengirim..."
             value="<?= htmlspecialchars($filters['q'] ?? '') ?>">
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

  <!-- UI only: quick reset (tidak mengubah logic, tetap GET biasa) -->
  <div class="col-md-2">
    <label class="form-label small fw-bold" style="color: #64748b; margin-bottom: 0.3rem;">&nbsp;</label>
    <a class="btn btn-outline-secondary btn-filter w-100" href="<?= current_url() ?>" style="font-weight: 700;">
      <i class="bi bi-arrow-counterclockwise me-1" aria-hidden="true"></i> Reset
    </a>
  </div>
</form>

<!-- TABLE -->
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
            <th>📊 Status</th>
            <th class="text-end">⚙️ Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <?php
              $jenis = strtolower(trim((string)($r['jenis_sampel'] ?? '')));
              $badgeClass = 'badge-soft';
              if (strpos($jenis, 'air') !== false) $badgeClass .= ' badge-air';
              else if (strpos($jenis, 'makan') !== false) $badgeClass .= ' badge-makanan';
              else if (strpos($jenis, 'lingkung') !== false) $badgeClass .= ' badge-lingkungan';
            ?>
            <tr class="row-hover">
              <td class="no-reg-text"><?= htmlspecialchars($r['no_registrasi']) ?></td>
              <td class="sampel-text" style="font-weight: 600;"><?= htmlspecialchars($r['nama_sampel']) ?></td>
              <td>
                <span class="<?= $badgeClass ?>">
                  <i class="bi bi-tag" aria-hidden="true"></i>
                  <?= htmlspecialchars($r['jenis_sampel']) ?>
                </span>
              </td>
              <td>
                <span class="date-badge">
                  <i class="bi bi-calendar3" aria-hidden="true"></i>
                  <?= htmlspecialchars($r['tgl_permintaan'] ?? '-') ?>
                </span>
              </td>
            <td>
              <span class="badge bg-secondary" style="border-radius: 8px;"><i class="bi bi-list-check me-1"></i><?= $r['jumlah_pemeriksaan'] ?? 0 ?> Item</span>
            </td>
            <td>
              <?php if ($r['is_diterima'] == 1): ?>
                <span class="badge bg-success" style="border-radius: 8px;"><i class="bi bi-check-circle me-1"></i>Diterima</span>
              <?php elseif ($r['is_diterima'] == 2): ?>
                <span class="badge bg-danger" style="border-radius: 8px;"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
              <?php else: ?>
                <span class="badge bg-warning text-dark" style="border-radius: 8px;"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>
              <?php endif; ?>
            </td>
              <td class="text-end">
                <div class="btn-group" role="group" aria-label="Aksi">
                  <a class="btn btn-sm btn-outline-primary btn-action"
                     href="<?= site_url('kesmas/form_permintaan_kesmas/detail/'.$r['id']) ?>"
                     title="Lihat detail permintaan">
                    <i class="bi bi-zoom-in"></i><span class="d-none d-md-inline">Detail</span>
                  </a>
                  
                  <?php if (isset($title) && $title === 'Terima Sample'): ?>
                  <a class="btn btn-sm btn-danger btn-action"
                     href="<?= site_url('kesmas/permintaan_sample/tolak/'.$r['id']) ?>"
                     onclick="return confirm('Apakah Anda yakin ingin menolak sample ini?');"
                     title="Tolak sample">
                    <i class="bi bi-hand-thumbs-down"></i><span class="d-none d-md-inline">Tolak</span>
                  </a>
                  <a class="btn btn-sm btn-success btn-action"
                     href="<?= site_url('kesmas/permintaan_sample/verifikasi/'.$r['id']) ?>"
                     title="Verifikasi dan terima sample">
                    <i class="bi bi-hand-thumbs-up"></i><span class="d-none d-md-inline">Terima</span>
                  </a>
                  <?php else: ?>
                  <a class="btn btn-sm btn-outline-warning btn-action"
                     href="<?= site_url('kesmas/form_permintaan_kesmas/kaji_ulang/'.$r['id']) ?>"
                     title="Kaji ulang permintaan">
                    <i class="bi bi-clipboard-check"></i><span class="d-none d-md-inline">Kaji</span>
                  </a>
                  <a class="btn btn-sm btn-outline-secondary btn-action"
                     href="<?= site_url('kesmas/form_permintaan_kesmas/edit/'.$r['id']) ?>"
                     title="Edit permintaan">
                    <i class="bi bi-pencil"></i><span class="d-none d-md-inline">Edit</span>
                  </a>
                  <form action="<?= site_url('kesmas/form_permintaan_kesmas/delete/'.$r['id']) ?>"
                        method="post"
                        class="d-inline"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger btn-action" title="Hapus permintaan">
                      <i class="bi bi-trash"></i><span class="d-none d-md-inline">Hapus</span>
                    </button>
                  </form>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (empty($rows)): ?>
            <tr>
              <td colspan="6" class="text-center">
                <div class="empty-state">
                  <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                  <div class="fw-bold" style="color:#334155; font-size: 1.05rem;">📭 Belum ada data</div>
                  <?php if (isset($title) && $title === 'Terima Sample'): ?>
                  <div class="small text-muted mb-3">Belum ada permintaan sample baru yang masuk. Menungkan pelanggan untuk mendaftar...</div>
                  <?php else: ?>
                  <div class="small text-muted mb-3">Klik tombol <strong>Tambah Baru</strong> untuk membuat permintaan pertama Anda.</div>
                  <a class="btn btn-primary btn-add" href="<?= site_url('kesmas/form_permintaan_kesmas/create') ?>" style="margin-top: 1rem;">
                    <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Buat Permintaan Baru
                  </a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
