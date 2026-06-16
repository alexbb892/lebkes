<?php
/**
 * Permintaan Form View
 * 
 * @var string $mode - 'create' or 'edit'
 * @var array|null $permintaan - Permintaan data array (null for create, array for edit)
 * @var string $no_registrasi - Registration number
 * @var array $petugas - List of petugas
 * @var array $tindakan_sampel - List of tindakan sampel
 * @var array $master_air_minum - Master air minum grouped
 * @var array $master_air_bersih - Master air bersih grouped
 * @var array $master_makanan - Master makanan grouped
 * @var array $master_lingkungan - Master lingkungan grouped
 * @var array $selected_ids - Selected master IDs
 * @var string $title - Page title
 */

// =============================
// UI WOW + tetap logic sama
// =============================

// Mapping array for group prefixes based on category and group name.
$kelompok_prefix_map = [
    'air_minum' => [
        'Fisika' => 'A',
        'Kimia Wajib' => 'B',
        'Kimia Khusus' => 'C',
        'Bakteriologi' => 'D',
    ],
    'air_bersih' => [
        'Fisika' => 'A',
        'Kimia' => 'B',
        'Bakteriologi' => 'C',
    ],
    'makanan' => [
        'Kimia' => 'A',
        'Bakteriologi' => 'B',
        'Parasitologi' => 'C',
    ],
    // Add other categories here if they have specific prefixing needs.
];

/**
 * Helper function to generate the prefixed group title for display.
 */
$get_prefixed_group_title = function($category_slug, $group_name, $map) {
    if (isset($map[$category_slug][$group_name])) {
        return $map[$category_slug][$group_name] . '. ' . $group_name;
    }
    return $group_name;
};

$action = ($mode === 'edit')
  ? site_url('kesmas/form_permintaan_kesmas/update/'.(int)$permintaan['id'])
  : site_url('kesmas/form_permintaan_kesmas/store');
?>

<!-- Optional (kalau belum ada di layout/header): Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
  :root{
    --ink:#0b1220;
    --muted:#667085;
    --line: rgba(15,23,42,.10);
    --glass: rgba(255,255,255,.72);
    --glass2: rgba(255,255,255,.58);
    --shadow: 0 26px 80px rgba(2,6,23,.14);
    --shadow2: 0 14px 36px rgba(2,6,23,.10);
    --ring: rgba(13,110,253,.20);
    --brand:#0d6efd;
    --brand2:#0b5ed7;
    --green:#22c55e;
    --amber:#f59e0b;
    --violet:#6366f1;
  }

  .ui-polish-container{ padding: 0; }

  .page-hero{
    border-radius: 26px;
    border: 1px solid rgba(15,23,42,.10);
    background:
      radial-gradient(900px 340px at 12% 10%, rgba(13,110,253,.20), transparent 62%),
      radial-gradient(900px 340px at 92% 20%, rgba(34,197,94,.10), transparent 62%),
      radial-gradient(900px 340px at 55% 110%, rgba(99,102,241,.12), transparent 62%),
      linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.70));
    box-shadow: var(--shadow);
    padding: 1.25rem 1.35rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 1rem;
  }
  .page-hero h3{
    margin:0;
    font-weight: 950;
    letter-spacing: -.5px;
    color: var(--ink);
  }
  .page-hero .sub{
    color: var(--muted);
    margin-top: .25rem;
  }
  .btn-back{
    border-radius: 16px;
    font-weight: 900;
    padding: .60rem .9rem;
  }

  .card-wow{
    border-radius: 22px;
    border: 1px solid rgba(15,23,42,.10);
    background: var(--glass);
    backdrop-filter: blur(12px);
    box-shadow: var(--shadow2);
    overflow: hidden;
  }
  .card-wow .card-header{
    background:
      linear-gradient(180deg, rgba(255,255,255,.86), rgba(255,255,255,.72));
    border-bottom: 1px solid rgba(15,23,42,.08);
    padding: .95rem 1.05rem;
  }
  .card-wow .card-body{
    padding: 1.05rem 1.05rem;
  }

  .section-title{
    display:flex;
    align-items:center;
    gap:.6rem;
    font-weight: 950;
    letter-spacing: -.3px;
    color: var(--ink);
    margin: 0;
  }
  .section-title i{
    color: var(--brand);
    font-size: 1.1rem;
  }

  .form-label{
    font-weight: 800;
    color: #334155;
  }
  .form-control, .form-select{
    border-radius: 16px;
    border-color: rgba(15,23,42,.12);
    padding: .78rem .9rem;
    background: rgba(255,255,255,.86);
  }
  .form-control:focus, .form-select:focus{
    border-color: rgba(13,110,253,.45);
    box-shadow: 0 0 0 .25rem var(--ring);
  }

  .divider-soft{
    height:1px;
    background: rgba(15,23,42,.10);
    margin: 1.1rem 0;
  }

  /* Tabs WOW */
  .tabs-wow{
    border-radius: 18px;
    border: 1px solid rgba(15,23,42,.10);
    background: rgba(255,255,255,.62);
    padding: .55rem;
    gap: .4rem;
  }
  .tabs-wow .nav-link{
    border: 1px solid transparent;
    border-radius: 14px;
    font-weight: 900;
    color: #334155;
    padding: .55rem .85rem;
  }
  .tabs-wow .nav-link:hover{
    background: rgba(13,110,253,.06);
    border-color: rgba(13,110,253,.10);
  }
  .tabs-wow .nav-link.active{
    background: linear-gradient(180deg, var(--brand), var(--brand2));
    color: #fff;
    box-shadow: 0 16px 32px rgba(13,110,253,.18);
  }

  .tab-shell{
    margin-top: .75rem;
    border-radius: 18px;
    border: 1px solid rgba(15,23,42,.10);
    background: rgba(248,250,252,.72);
    padding: 1rem;
  }

  .group-head{
    display:flex;
    align-items:center;
    justify-content: space-between;
    gap: .75rem;
    margin-bottom: .5rem;
  }
  .group-title{
    font-weight: 950;
    color: #334155;
    font-size: .9rem;
    letter-spacing: .2px;
  }
  .btn-mini{
    border-radius: 14px;
    font-weight: 900;
    padding: .35rem .55rem;
  }

  .check-tile{
    border-radius: 16px;
    border: 1px solid rgba(15,23,42,.10);
    background: rgba(255,255,255,.68);
    padding: .65rem .75rem;
    transition: .14s ease;
  }
  .check-tile:hover{
    transform: translateY(-1px);
    box-shadow: 0 14px 28px rgba(2,6,23,.08);
  }
  .check-tile .form-check-input{ cursor:pointer; }
  .check-tile .form-check-label{ cursor:pointer; font-weight: 700; color:#334155; }

  .sticky-save{
    position: sticky;
    bottom: .75rem;
    z-index: 2;
    border-radius: 22px;
    border: 1px solid rgba(15,23,42,.10);
    background: rgba(255,255,255,.72);
    backdrop-filter: blur(12px);
    box-shadow: var(--shadow2);
    padding: .85rem;
    margin-top: 1rem;
  }
  .btn-save{
    border-radius: 18px;
    font-weight: 950;
    letter-spacing: .2px;
    padding: .9rem 1rem;
    border:none;
    background: linear-gradient(180deg, var(--brand), var(--brand2));
    box-shadow: 0 18px 34px rgba(13,110,253,.18);
  }
  .btn-save:hover{ transform: translateY(-1px); }
  .btn-save:active{ transform: translateY(0); }

  @media (max-width: 767.98px){
    .page-hero{ padding: 1.05rem; border-radius: 22px; }
    .card-wow{ border-radius: 18px; }
    .tab-shell{ padding: .85rem; }
  }
</style>

<div class="container-fluid ui-polish-container">

  <!-- HERO -->
  <div class="page-hero">
    <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
      <div>
        <h3><?= ($mode==='edit') ? 'Edit' : 'Tambah' ?> Permintaan</h3>
        <div class="sub">Formulir untuk pengajuan permintaan kesmas.</div>
      </div>
      <a class="btn btn-outline-secondary btn-back" href="<?= site_url('kesmas/form_permintaan_kesmas') ?>">
        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali
      </a>
    </div>
  </div>

  <?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 16px;">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    <?= $this->session->flashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 16px;">
    <i class="bi bi-check-circle-fill me-2"></i>
    <?= $this->session->flashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>

  <form method="post" action="<?= $action ?>" id="formPermintaan" novalidate>
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

    <div class="row g-3">
      <!-- LEFT -->
      <div class="col-lg-6">
        <div class="card card-wow">
          <div class="card-header">
            <div class="section-title">
              <i class="bi bi-droplet-half" aria-hidden="true"></i>
              <span>Identitas Sampel</span>
            </div>
          </div>
          <div class="card-body">
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Nomor Registrasi Sampel</label>
                  <input class="form-control" name="no_registrasi" value="<?= htmlspecialchars($no_registrasi) ?>" placeholder="Isi Nomor Registrasi Manual (Opsional)">
              </div>

              <div class="col-md-6">
                <label class="form-label">Kategori Sampel</label>
                <?php $ks = $permintaan['kategori_sample'] ?? ''; ?>
                <select class="form-select" name="kategori_sample">
                  <option value="">- pilih kategori -</option>
                  <?php foreach (['Air','Makanan','Lingkungan'] as $opt): ?>
                    <option value="<?= $opt ?>" <?= ($ks===$opt)?'selected':'' ?>><?= $opt ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Nama Sampel</label>
                <input class="form-control" name="nama_sampel" value="<?= htmlspecialchars($permintaan['nama_sampel'] ?? '') ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">Jenis Sampel</label>
                <?php $js = $permintaan['jenis_sampel'] ?? ''; ?>
                <select class="form-select" name="jenis_sampel">
                  <option value="">- pilih -</option>
                  <?php foreach (['Air Minum','Air Bersih','Makanan','Lingkungan'] as $opt): ?>
                    <option value="<?= $opt ?>" <?= ($js===$opt)?'selected':'' ?>><?= $opt ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label">Volume (ml)</label>
                <input class="form-control" type="number" name="volume_ml" value="<?= htmlspecialchars($permintaan['volume_ml'] ?? '') ?>">
              </div>
              <div class="col-md-4">
                <label class="form-label">Tanggal Pengambilan</label>
                <input class="form-control" type="date" name="tgl_pengambilan" value="<?= htmlspecialchars($permintaan['tgl_pengambilan'] ?? '') ?>">
              </div>
              <div class="col-md-4">
                <label class="form-label">Jam Pengambilan</label>
                <input class="form-control" type="time" name="jam_pengambilan" value="<?= htmlspecialchars($permintaan['jam_pengambilan'] ?? '') ?>">
              </div>

              <div class="col-md-12">
                <label class="form-label">Lokasi Pengambilan</label>
                <input class="form-control" name="lokasi_pengambilan" value="<?= htmlspecialchars($permintaan['lokasi_pengambilan'] ?? '') ?>">
              </div>

              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <label class="form-label mb-0">Petugas Pengambil</label>
                  <a href="<?= site_url('petugas/add') ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus"></i> Tambah Petugas Baru
                  </a>
                </div>
                <?php $selected_petugas_id = $permintaan['petugas_pengambil_id'] ?? ''; ?>
                <select class="form-select" name="petugas_pengambil_id">
                  <option value="">- Pilih Petugas -</option>
                  <?php foreach ($petugas as $p): ?>
                    <option value="<?= (int)$p['id'] ?>" <?= ((string)$selected_petugas_id === (string)$p['id'])?'selected':'' ?>>
                      <?= htmlspecialchars($p['nama']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-12">
                <label class="form-label">Tindakan Sampel</label>
                <?php $ts = $permintaan['tindakan_sampel'] ?? ''; ?>
                <select class="form-select" name="tindakan_sampel">
                    <option value="">- Pilih Tindakan -</option>
                    <?php if (isset($tindakan_sampel) && is_array($tindakan_sampel)): ?>
                        <?php foreach ($tindakan_sampel as $t): ?>
                            <option value="<?= htmlspecialchars($t['nama']) ?>" <?= ($ts === $t['nama']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
              </div>

              <div class="col-md-12">
                <label class="form-label">Informasi Tambahan</label>
                <textarea class="form-control" name="info_tambahan" rows="2"><?= htmlspecialchars($permintaan['info_tambahan'] ?? '') ?></textarea>
              </div>
            </div>

            <div class="divider-soft"></div>

            <div class="section-title mb-2">
              <i class="bi bi-person-vcard" aria-hidden="true"></i>
              <span>Identitas Pengirim</span>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Nama</label>
                <input class="form-control" name="nama_pengirim" value="<?= htmlspecialchars($permintaan['nama_pengirim'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">No. Telp</label>
                <input class="form-control" name="telp_pengirim" value="<?= htmlspecialchars($permintaan['telp_pengirim'] ?? '') ?>">
              </div>
              <div class="col-md-12">
                <label class="form-label">Alamat</label>
                <input class="form-control" name="alamat_pengirim" value="<?= htmlspecialchars($permintaan['alamat_pengirim'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Instansi</label>
                <input class="form-control" name="instansi" value="<?= htmlspecialchars($permintaan['instansi'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Tanggal Permintaan</label>
                <input class="form-control" type="date" name="tgl_permintaan" value="<?= htmlspecialchars($permintaan['tgl_permintaan'] ?? date('Y-m-d')) ?>">
              </div>
              <div class="col-md-12">
                <label class="form-label">Tanda Tangan Pengirim / Nama Jelas</label>
                <input class="form-control" name="ttd_pengirim" value="<?= htmlspecialchars($permintaan['ttd_pengirim'] ?? '') ?>">
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-lg-6">
        <!-- Pembayaran - Pencatatan Manual -->
        <!-- NOTE: Payment module has been removed. This section is for manual payment recording only. -->
        <div class="card card-wow">
          <div class="card-header">
            <div class="section-title">
              <i class="bi bi-wallet2" aria-hidden="true"></i>
              <span>Pembayaran <small class="text-muted">(Pencatatan Manual)</small></span>
            </div>
          </div>
          <div class="card-body">
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Jumlah Biaya</label>
                <input class="form-control" type="number" name="jumlah_biaya" value="<?= htmlspecialchars($permintaan['jumlah_biaya'] ?? 0) ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Cara Bayar</label>
                <?php $cb = $permintaan['cara_bayar'] ?? ''; ?>
                <select class="form-select" name="cara_bayar">
                  <option value="">-</option>
                  <option value="Tunai" <?= ($cb === 'Tunai') ? 'selected' : '' ?>>Tunai</option>
                  <option value="Non Tunai" <?= ($cb === 'Non Tunai') ? 'selected' : '' ?>>Non Tunai</option>
                  <option value="Lain-lain" <?= ($cb === 'Lain-lain') ? 'selected' : '' ?>>Lain-lain</option>
                </select>
              </div>
              <div class="col-md-12 mt-2">
                <label class="form-label">Jika lain-lain</label>
                <input class="form-control" name="cara_bayar_lainnya" value="<?= htmlspecialchars($permintaan['cara_bayar_lainnya'] ?? '') ?>">
              </div>
            </div>
          </div>
        </div>

        <!-- Catatan -->
        <div class="card card-wow mt-3">
          <div class="card-header">
            <div class="section-title">
              <i class="bi bi-journal-text" aria-hidden="true"></i>
              <span>Catatan</span>
            </div>
          </div>
          <div class="card-body">
            <textarea class="form-control" name="catatan" rows="3"><?= htmlspecialchars($permintaan['catatan'] ?? '') ?></textarea>
          </div>
        </div>

        <!-- Pemeriksaan -->
        <div class="card card-wow mt-3">
          <div class="card-header">
            <div class="section-title">
              <i class="bi bi-list-check" aria-hidden="true"></i>
              <span>Pemeriksaan (Checklist)</span>
            </div>
          </div>
          <div class="card-body">

            <ul class="nav nav-pills tabs-wow" role="tablist">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-airminum" type="button">
                  <i class="bi bi-droplet me-1" aria-hidden="true"></i>Air Minum
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-airbersih" type="button">
                  <i class="bi bi-water me-1" aria-hidden="true"></i>Air Bersih
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-makanan" type="button">
                  <i class="bi bi-basket2 me-1" aria-hidden="true"></i>Makanan
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-lingkungan" type="button">
                  <i class="bi bi-house-heart me-1" aria-hidden="true"></i>Lingkungan
                </button>
              </li>
            </ul>

            <div class="tab-content tab-shell">
              <?php
                $selected = array_flip(array_map('intval', $selected_ids ?? array()));

                $render_group = function($groups, $selected, $category_slug, $kelompok_prefix_map) use ($get_prefixed_group_title) {
                  $i = 0;
                  foreach ($groups as $kelompok => $rows) {
                    $i++;
                    $cls = 'ui-polish-checkbox-'.$category_slug.'-g'.$i; // tanpa dot untuk class
                    echo '<div class="mb-3">';
                    echo '  <div class="group-head">';
                    echo '    <div class="group-title">'.$get_prefixed_group_title($category_slug, $kelompok, $kelompok_prefix_map).'</div>';
                    echo '    <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-sm btn-outline-primary btn-mini" data-check-all=".'.$cls.'">
                                  <i class="bi bi-check2-square me-1" aria-hidden="true"></i>Pilih semua
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-mini" data-uncheck-all=".'.$cls.'">
                                  <i class="bi bi-square me-1" aria-hidden="true"></i>Kosongkan
                                </button>
                              </div>';
                    echo '  </div>';

                    echo '  <div class="row g-2">';
                    foreach ($rows as $r) {
                      $id = (int)$r['id'];
                      $checked = isset($selected[$id]) ? 'checked' : '';
                      echo '    <div class="col-md-6">
                                  <div class="check-tile">
                                    <div class="form-check mb-0">
                                      <input class="form-check-input '.$cls.'" type="checkbox" name="pemeriksaan[]" value="'.$id.'" id="pemeriksaan_'.$id.'" '.$checked.'>
                                      <label class="form-check-label" for="pemeriksaan_'.$id.'">'.htmlspecialchars($r['nama_pemeriksaan'] ?? $r['nama']).'</label>
                                    </div>
                                  </div>
                                </div>';
                    }
                    echo '  </div>';
                    echo '</div>';
                  }
                };
              ?>

              <div class="tab-pane fade show active" id="tab-airminum">
                <?php $render_group($master_air_minum, $selected, 'air_minum', $kelompok_prefix_map); ?>
              </div>

              <div class="tab-pane fade" id="tab-airbersih">
                <?php $render_group($master_air_bersih, $selected, 'air_bersih', $kelompok_prefix_map); ?>
              </div>

              <div class="tab-pane fade" id="tab-makanan">
                <?php $render_group($master_makanan, $selected, 'makanan', $kelompok_prefix_map); ?>
              </div>

              <div class="tab-pane fade" id="tab-lingkungan">
                <?php $render_group($master_lingkungan, $selected, 'lingkungan', $kelompok_prefix_map); ?>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Sticky save bar -->
    <div class="sticky-save d-flex align-items-center justify-content-between gap-3 flex-wrap">
      <div class="text-muted small">
        <i class="bi bi-info-circle me-1" aria-hidden="true"></i>
        Pastikan identitas sampel & checklist pemeriksaan sudah sesuai.
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-secondary btn-back" href="<?= site_url('kesmas/form_permintaan_kesmas') ?>">
          <i class="bi bi-x-lg me-1" aria-hidden="true"></i>Batal
        </a>
        <button type="button" class="btn btn-primary btn-save" onclick="this.innerHTML='<i class=\'bi bi-hourglass-split me-1\'></i>Menyimpan...'; this.style.pointerEvents='none'; document.getElementById('formPermintaan').submit();">
          <i class="bi bi-save2 me-1" aria-hidden="true"></i>Simpan Permintaan
        </button>
      </div>
    </div>

  </form>
</div> <!-- Close ui-polish-container -->
