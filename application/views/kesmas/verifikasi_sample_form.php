<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Verifikasi Sample Form View
 * 
 * @var string $title - Page title
 * @var array $permintaan - Permintaan data array
 */
?>
<div class="container-fluid">
  <div class="row mb-3 align-items-center">
    <div class="col">
      <h3 class="fw-bold mb-0">Verifikasi & Terima Sample</h3>
      <div class="text-muted small">Lengkapi informasi Nomor Registrasi resmi sebelum menerima sample.</div>
    </div>
    <div class="col-auto">
      <a class="btn btn-outline-secondary" href="<?= site_url('kesmas/permintaan_sample') ?>">
        <i class="bi bi-arrow-left me-1"></i>Kembali
      </a>
    </div>
  </div>

  <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
  <?php endif; ?>

  <div class="card shadow-sm border-0" style="border-radius: 16px;">
    <div class="card-body p-4">
      <div class="row mb-4">
        <div class="col-md-6">
          <table class="table table-borderless table-sm">
            <tr>
              <th style="width: 150px;" class="text-muted">Nama Sampel</th>
              <td class="fw-semibold">: <?= htmlspecialchars($permintaan['nama_sampel']) ?></td>
            </tr>
            <tr>
              <th class="text-muted">Jenis Sampel</th>
              <td>: <?= htmlspecialchars($permintaan['jenis_sampel']) ?></td>
            </tr>
            <tr>
              <th class="text-muted">Kategori</th>
              <td>: <?= htmlspecialchars($permintaan['kategori_sample'] ?? '-') ?></td>
            </tr>
            <tr>
              <th class="text-muted">Pengirim</th>
              <td>: <?= htmlspecialchars($permintaan['nama_pengirim'] ?? '-') ?></td>
            </tr>
          </table>
        </div>
        <div class="col-md-6">
          <div class="alert alert-info border-0" style="background: rgba(13,110,253,.05); border-radius: 12px;">
            <i class="bi bi-info-circle-fill me-2 text-primary"></i>
            Silakan masukkan <strong>Nomor Registrasi</strong> resmi yang terdapat di buku register laboratorium untuk sample ini.
          </div>
        </div>
      </div>

      <hr class="mb-4 text-muted">

      <form method="post" action="<?= site_url('kesmas/permintaan_sample/verifikasi/'.$permintaan['id']) ?>" id="formVerifikasi" novalidate>
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        
        <div class="row mb-4">
          <div class="col-md-6">
            <label class="form-label fw-bold">Nomor Registrasi</label>
            <input type="text" class="form-control form-control-lg" name="no_registrasi" value="<?= htmlspecialchars($permintaan['no_registrasi'] ?? '') ?>" placeholder="Ketik No. Registrasi (Opsional)" autofocus autocomplete="off">
            <div class="form-text mt-2">Nomor registrasi sementara dari pendaftaran publik akan ditimpa dengan nomor ini.</div>
          </div>
        </div>

        <div class="d-flex gap-2">
          <button type="button" class="btn btn-primary" style="border-radius: 12px; font-weight: 700; padding: 0.6rem 1.5rem;" onclick="this.innerHTML='<i class=\'bi bi-hourglass-split me-1\'></i>Menyimpan...'; this.style.pointerEvents='none'; document.getElementById('formVerifikasi').submit();">
            <i class="bi bi-check2-circle me-1"></i>Simpan & Terima Sample
          </button>
          <a href="<?= site_url('kesmas/permintaan_sample') ?>" class="btn btn-light" style="border-radius: 12px; font-weight: 600; padding: 0.6rem 1.5rem;">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>