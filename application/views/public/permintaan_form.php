<?php
// Defensive defaults
if (!isset($permintaan) || !is_array($permintaan)) $permintaan = [];
if (!isset($petugas) || !is_array($petugas)) $petugas = [];
if (!isset($tindakan_sampel) || !is_array($tindakan_sampel)) $tindakan_sampel = [];

$kelompok_prefix_map = [
    'air_minum' => ['Fisika' => 'A', 'Kimia Wajib' => 'B', 'Kimia Khusus' => 'C', 'Bakteriologi' => 'D'],
    'air_bersih' => ['Fisika' => 'A', 'Kimia' => 'B', 'Bakteriologi' => 'C'],
    'makanan' => ['Kimia' => 'A', 'Bakteriologi' => 'B', 'Parasitologi' => 'C'],
];

if (!function_exists('get_prefixed_group_title')) {
    function get_prefixed_group_title(string $category_slug, string $group_name, array $map): string {
        if (isset($map[$category_slug][$group_name])) {
            return $map[$category_slug][$group_name] . '. ' . $group_name;
        }
        return $group_name;
    }
}

$action = site_url('public_pendaftaran/store');
?>

<style>
  .ui-polish-container{ padding: 0; max-width: 1200px; margin: 0 auto; animation: fadeInUp 0.5s ease-out; }

  .page-hero{
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,.8);
    background:
      radial-gradient(900px 340px at 12% 10%, rgba(13,110,253,.20), transparent 62%),
      radial-gradient(900px 340px at 92% 20%, rgba(34,197,94,.10), transparent 62%),
      radial-gradient(900px 340px at 55% 110%, rgba(99,102,241,.12), transparent 62%),
      linear-gradient(180deg, rgba(255,255,255,.95), rgba(255,255,255,.80));
    box-shadow: var(--shadow);
    padding: 1.25rem 1.35rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 1rem;
    backdrop-filter: blur(10px);
  }
  .page-hero h3{ margin:0; font-weight: 900; letter-spacing: -.5px; color: var(--ink); font-size: 1.75rem; }
  .page-hero .sub{ color: var(--muted); margin-top: .25rem; }

  .card-wow{
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,.6);
    background: rgba(255,255,255,.85);
    backdrop-filter: blur(16px);
    box-shadow: var(--shadow2);
    overflow: hidden;
    height: 100%;
  }
  .card-wow .card-header{
    background: transparent;
    border-bottom: 1px solid rgba(15,23,42,.05);
    padding: 1.2rem 1.25rem 0.75rem;
  }
  .card-wow .card-body{ padding: 1.25rem; }

  .section-title{
    display:flex; align-items:center; gap:.6rem; font-weight: 800;
    letter-spacing: -.3px; color: var(--ink); margin: 0;
    font-size: 1.15rem;
  }
  .section-title i{ color: var(--brand); font-size: 1.25rem; }

  .form-label{ font-weight: 700; color: #334155; font-size: 0.9rem; margin-bottom: 0.35rem; }
  .form-control, .form-select{
    border-radius: 14px; border-color: rgba(15,23,42,.10);
    padding: .75rem 1rem; background: rgba(255,255,255,.9);
    font-size: 0.95rem; transition: all 0.2s ease;
  }
  .form-control:focus, .form-select:focus{
    border-color: var(--brand); box-shadow: 0 0 0 4px rgba(13,110,253,.15);
    background: #fff;
  }

  .divider-soft{ height:1px; background: rgba(15,23,42,.08); margin: 1.5rem 0; }

  .tabs-wow{
    border-radius: 16px; border: 1px solid rgba(15,23,42,.05);
    background: rgba(248,250,252,.7); padding: .4rem; gap: .25rem;
  }
  .tabs-wow .nav-link{
    border: 1px solid transparent; border-radius: 12px;
    font-weight: 700; color: #475569; padding: .6rem .85rem; font-size: 0.9rem;
  }
  .tabs-wow .nav-link:hover{ background: rgba(13,110,253,.05); color: var(--brand); }
  .tabs-wow .nav-link.active{
    background: #fff;
    color: var(--brand); box-shadow: 0 4px 12px rgba(0,0,0,.05);
    border-color: rgba(15,23,42,.05);
  }

  .tab-shell{
    margin-top: 1rem; border-radius: 18px; border: 1px solid rgba(15,23,42,.05);
    background: transparent; padding: 0.5rem 0;
  }

  .group-head{
    display:flex; align-items:center; justify-content: space-between; gap: .75rem; margin-bottom: .75rem;
    background: rgba(248,250,252,.8); padding: 0.5rem 1rem; border-radius: 12px;
  }
  .group-title{ font-weight: 800; color: #1e293b; font-size: 0.95rem; }
  .btn-mini{ border-radius: 10px; font-weight: 700; padding: .3rem .6rem; font-size: 0.8rem; }

  .check-tile{
    border-radius: 14px; border: 1px solid rgba(15,23,42,.08);
    background: #fff; padding: .75rem .85rem; transition: all .2s ease;
  }
  .check-tile:hover{ transform: translateY(-2px); box-shadow: 0 8px 20px rgba(13,110,253,.08); border-color: rgba(13,110,253,.3); }
  .check-tile .form-check-input{ cursor:pointer; margin-top: 0.15rem; width: 1.1em; height: 1.1em; border-color: rgba(15,23,42,.2); }
  .check-tile .form-check-input:checked { background-color: var(--brand); border-color: var(--brand); }
  .check-tile .form-check-label{ cursor:pointer; font-weight: 600; color:#334155; font-size: 0.9rem; user-select: none; }

  .sticky-save{
    position: sticky; bottom: .75rem; z-index: 2; border-radius: 22px;
    border: 1px solid rgba(255,255,255,.8); background: rgba(255,255,255,.85);
    backdrop-filter: blur(16px); box-shadow: 0 20px 40px rgba(0,0,0,.1); padding: 1rem 1.25rem; margin-top: 2rem;
  }
  .btn-save{
    border-radius: 14px; font-weight: 800; letter-spacing: .3px;
    padding: .8rem 1.5rem; border:none; background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    box-shadow: 0 8px 20px rgba(13,110,253,.25); color: #fff; transition: all 0.2s ease;
  }
  .btn-save:hover{ transform: translateY(-2px); box-shadow: 0 12px 25px rgba(13,110,253,.35); color: #fff; }
</style>

<div class="container-fluid ui-polish-container">

  <div class="page-hero">
    <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
      <div>
        <h3>Pendaftaran Pengujian Sampel</h3>
        <div class="sub">Silakan isi formulir di bawah ini dengan lengkap dan benar.</div>
      </div>
    </div>
  </div>

  <form method="post" action="<?= $action ?>">
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
              <input type="hidden" name="no_registrasi" value="<?= $no_registrasi ?>">

              <div class="col-md-6">
                <label class="form-label">Kategori Sampel</label>
                <select class="form-select" name="kategori_sample" required style="cursor: pointer;">
                  <option value="">- pilih kategori -</option>
                  <?php foreach (['Air','Makanan','Lingkungan'] as $opt): ?>
                    <option value="<?= $opt ?>"><?= $opt ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Nama Sampel</label>
                <input class="form-control" name="nama_sampel" required placeholder="Contoh: Air Sumur Bor">
              </div>

              <div class="col-md-6">
                <label class="form-label">Jenis Sampel</label>
                <select class="form-select" name="jenis_sampel" required style="cursor: pointer;">
                  <option value="">- pilih -</option>
                  <?php foreach (['Air Minum','Air Bersih','Makanan','Lingkungan'] as $opt): ?>
                    <option value="<?= $opt ?>"><?= $opt ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label">Volume (ml)</label>
                <input class="form-control" type="number" name="volume_ml" placeholder="Cth: 500">
              </div>
              <div class="col-md-4">
                <label class="form-label">Tanggal Pengambilan</label>
                <input class="form-control" type="date" name="tgl_pengambilan" style="cursor: pointer;">
              </div>
              <div class="col-md-4">
                <label class="form-label">Jam Pengambilan</label>
                <input class="form-control" type="time" name="jam_pengambilan" style="cursor: pointer;">
              </div>

              <div class="col-md-12">
                <label class="form-label">Lokasi Pengambilan (Alamat detail)</label>
                <input class="form-control" name="lokasi_pengambilan" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan">
              </div>

              <div class="col-md-12">
                <label class="form-label">Informasi Tambahan</label>
                <textarea class="form-control" name="info_tambahan" rows="2" placeholder="Catatan khusus terkait sampel (opsional)"></textarea>
              </div>
            </div>

            <div class="divider-soft"></div>

            <div class="section-title mb-2">
              <i class="bi bi-person-vcard" aria-hidden="true"></i>
              <span>Identitas Pengirim</span>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <input class="form-control" name="nama_pengirim" required placeholder="Sesuai KTP/Identitas">
              </div>
              <div class="col-md-6">
                <label class="form-label">No. WhatsApp / HP</label>
                <input class="form-control" name="telp_pengirim" required placeholder="08xxxxxxxxxx">
              </div>
              <div class="col-md-12">
                <label class="form-label">Alamat</label>
                <input class="form-control" name="alamat_pengirim">
              </div>
              <div class="col-md-6">
                <label class="form-label">Instansi / Perusahaan</label>
                <input class="form-control" name="instansi" placeholder="Isi jika mewakili instansi">
              </div>
              <div class="col-md-6">
                <label class="form-label">Tanggal Permintaan</label>
                <input class="form-control bg-light" type="date" name="tgl_permintaan" value="<?= date('Y-m-d') ?>" readonly>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-lg-6">
        
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
                  <i class="bi bi-droplet-fill text-primary me-1" aria-hidden="true"></i>Air Minum
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-airbersih" type="button">
                  <i class="bi bi-water text-info me-1" aria-hidden="true"></i>Air Bersih
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-makanan" type="button">
                  <i class="bi bi-basket2-fill text-warning me-1" aria-hidden="true"></i>Makanan
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-lingkungan" type="button">
                  <i class="bi bi-tree-fill text-success me-1" aria-hidden="true"></i>Lingkungan
                </button>
              </li>
            </ul>

            <div class="tab-content tab-shell">
              <?php
                $selected = [];

                function render_group($groups, $selected, $category_slug, $kelompok_prefix_map) {
                  $i = 0;
                  foreach ($groups as $kelompok => $rows) {
                    $i++;
                    $cls = 'ui-polish-checkbox-'.$category_slug.'-g'.$i;
                    echo '<div class="mb-3">';
                    echo '  <div class="group-head">';
                    echo '    <div class="group-title">'.get_prefixed_group_title($category_slug, $kelompok, $kelompok_prefix_map).'</div>';
                    echo '    <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-sm btn-light text-primary border btn-mini" data-check-all=".'.$cls.'">
                                  <i class="bi bi-check2-square me-1" aria-hidden="true"></i>Pilih semua
                                </button>
                                <button type="button" class="btn btn-sm btn-light text-secondary border btn-mini" data-uncheck-all=".'.$cls.'">
                                  <i class="bi bi-square me-1" aria-hidden="true"></i>Kosongkan
                                </button>
                              </div>';
                    echo '  </div>';

                    echo '  <div class="row g-2">';
                    foreach ($rows as $r) {
                      $id = (int)$r['id'];
                      echo '    <div class="col-md-6">
                                  <div class="check-tile">
                                    <div class="form-check mb-0">
                                      <input class="form-check-input '.$cls.'" type="checkbox" name="pemeriksaan[]" value="'.$id.'" id="pemeriksaan_'.$id.'">
                                      <label class="form-check-label" for="pemeriksaan_'.$id.'">'.htmlspecialchars($r['nama_pemeriksaan'] ?? $r['nama']).'</label>
                                    </div>
                                  </div>
                                </div>';
                    }
                    echo '  </div>';
                    echo '</div>';
                  }
                }
              ?>

              <div class="tab-pane fade show active" id="tab-airminum">
                <?php render_group($master_air_minum, $selected, 'air_minum', $kelompok_prefix_map); ?>
              </div>

              <div class="tab-pane fade" id="tab-airbersih">
                <?php render_group($master_air_bersih, $selected, 'air_bersih', $kelompok_prefix_map); ?>
              </div>

              <div class="tab-pane fade" id="tab-makanan">
                <?php render_group($master_makanan, $selected, 'makanan', $kelompok_prefix_map); ?>
              </div>

              <div class="tab-pane fade" id="tab-lingkungan">
                <?php render_group($master_lingkungan, $selected, 'lingkungan', $kelompok_prefix_map); ?>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Sticky save bar -->
    <div class="sticky-save d-flex align-items-center justify-content-between gap-3 flex-wrap">
      <div class="d-flex align-items-center gap-3">
        <div class="form-check">
          <input class="form-check-input mt-1" type="checkbox" name="disclaimer" id="disclaimerCheckbox" required style="width: 1.2em; height: 1.2em; border-color: var(--brand); cursor: pointer;">
          <label class="form-check-label text-muted small" for="disclaimerCheckbox" style="font-weight: 600; cursor: pointer; user-select: none; padding-top: 2px;">
            Saya menjamin data yang saya berikan adalah benar dan menyetujui Syarat & Ketentuan yang berlaku.
          </label>
        </div>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-save" id="btnSubmitForm">
          <i class="bi bi-send-check-fill me-2" aria-hidden="true"></i>Kirim Pendaftaran
        </button>
      </div>
    </div>

  </form>
</div>

<script>
  document.getElementById('formPermintaan')?.addEventListener('submit', function(e) {
    if(this.checkValidity()) {
      const btn = document.getElementById('btnSubmitForm');
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
      btn.classList.add('disabled');
    }
  });
</script>
