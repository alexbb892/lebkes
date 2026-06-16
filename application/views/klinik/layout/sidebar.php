  <!-- Sidebar -->
  <nav id="sidebar" class="d-flex flex-column shadow-sm">
    <!-- Brand Logo -->
    <div class="d-flex align-items-center justify-content-center py-4 border-bottom">
      <a href="<?= site_url('klinik/dashboard') ?>" class="text-decoration-none text-dark d-flex align-items-center">
        <img src="<?= base_url('assets/img/logolabkes.png') ?>" alt="Logo" class="rounded-circle shadow-sm me-2" style="width: 45px; height: 45px;">
        <span class="h5 fw-bold mb-0 d-none d-md-block">UPTD LABKES</span>
      </a>
    </div>

    <!-- Sidebar Search -->
    <div class="p-3">
      <div class="input-group">
        <input type="text" class="form-control border-end-0 bg-light" placeholder="Cari menu..." onkeyup="searchSidebar(this.value)">
        <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="flex-grow-1 overflow-auto pb-4">
      <ul class="nav flex-column mb-auto" id="sidebarMenu">
        
        <?php
        $user_role = strtolower((string) $this->session->userdata('role'));
        $is_admin = ($user_role === 'admin');
        $is_pemeriksa = ($user_role === 'pemeriksa sampel');
        $is_pendaftaran = ($user_role === 'petugas pendaftaran');
        $is_rm = ($user_role === 'petugas rm');
        ?>

        <li class="nav-header">Menu Utama</li>
        <li class="nav-item">
          <a href="<?= site_url('klinik/dashboard') ?>" class="nav-link <?= $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == '' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-hospital-user text-primary"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <?php if ($is_admin || $is_pendaftaran || $is_pemeriksa): ?>
          <li class="nav-header">Klinik dan Rekam Medis</li>
          <li class="nav-item">
            <a class="nav-link <?= in_array($this->uri->segment(1), ['form_permintaan_klinik', 'uji_klinik', 'uji_rekam_klinik', 'laporan_uji_klinik']) ? 'active' : 'collapsed' ?>" data-bs-toggle="collapse" href="#collapseKlinik" role="button" aria-expanded="<?= in_array($this->uri->segment(1), ['form_permintaan_klinik', 'uji_klinik', 'uji_rekam_klinik', 'laporan_uji_klinik']) ? 'true' : 'false' ?>">
              <i class="nav-icon fas fa-clinic-medical text-success"></i>
              <span>Klinik</span>
              <i class="fas fa-chevron-down arrow-icon"></i>
            </a>
            <div class="collapse <?= in_array($this->uri->segment(1), ['form_permintaan_klinik', 'uji_klinik', 'uji_rekam_klinik', 'laporan_uji_klinik']) ? 'show' : '' ?>" id="collapseKlinik" data-bs-parent="#sidebarMenu">
              <ul class="nav flex-column ms-3 mt-1">
                <?php if ($is_admin || $is_pendaftaran): ?>
                <li class="nav-item">
                  <a href="<?= site_url('klinik/form_permintaan_klinik') ?>" class="nav-link <?= $this->uri->segment(1) == 'form_permintaan_klinik' ? 'active' : '' ?>">
                    <i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Form Pendaftaran Klinik
                  </a>
                </li>
                <?php endif; ?>
                <?php if ($is_admin || $is_pemeriksa): ?>
                <li class="nav-item">
                  <a href="<?= site_url('klinik/uji_klinik') ?>" class="nav-link <?= $this->uri->segment(1) == 'uji_klinik' ? 'active' : '' ?>">
                    <i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Uji Lab Klinik
                  </a>
                </li>
                <?php endif; ?>
                <?php if ($is_admin || $is_pemeriksa || $is_rm): ?>
                <li class="nav-item">
                  <a href="<?= site_url('klinik/uji_rekam_klinik') ?>" class="nav-link <?= $this->uri->segment(1) == 'uji_rekam_klinik' ? 'active' : '' ?>">
                    <i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Detail Rekam Klinik
                  </a>
                </li>
                <?php endif; ?>
                <?php if ($is_admin || $is_pendaftaran || $is_pemeriksa): ?>
                <li class="nav-item">
                  <a href="<?= site_url('klinik/laporan_uji_klinik') ?>" class="nav-link <?= $this->uri->segment(1) == 'laporan_uji_klinik' ? 'active' : '' ?>">
                    <i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Laporan Uji Lab
                  </a>
                </li>
                <?php endif; ?>
              </ul>
            </div>
          </li>
        <?php endif; ?>

        <?php if ($is_admin || $is_pendaftaran || $is_rm): ?>
          <li class="nav-item">
            <a class="nav-link <?= in_array($this->uri->segment(1), ['form_permintaan_rm', 'uji_rekam_medis', 'hasil_laporan']) ? 'active' : 'collapsed' ?>" data-bs-toggle="collapse" href="#collapseRM" role="button" aria-expanded="<?= in_array($this->uri->segment(1), ['form_permintaan_rm', 'uji_rekam_medis', 'hasil_laporan']) ? 'true' : 'false' ?>">
              <i class="nav-icon fas fa-notes-medical text-danger"></i>
              <span>Rekam Medis</span>
              <i class="fas fa-chevron-down arrow-icon"></i>
            </a>
            <div class="collapse <?= in_array($this->uri->segment(1), ['form_permintaan_rm', 'uji_rekam_medis', 'hasil_laporan']) ? 'show' : '' ?>" id="collapseRM" data-bs-parent="#sidebarMenu">
              <ul class="nav flex-column ms-3 mt-1">
                <li class="nav-item">
                  <a href="<?= site_url('klinik/form_permintaan_rm') ?>" class="nav-link <?= $this->uri->segment(1) == 'form_permintaan_rm' ? 'active' : '' ?>">
                    <i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Pendaftaran Pasien RM 
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= site_url('klinik/uji_rekam_medis') ?>" class="nav-link <?= $this->uri->segment(1) == 'uji_rekam_medis' ? 'active' : '' ?>">
                    <i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Detail Kunjungan
                  </a>
                </li>
                <!-- <?php if ($is_admin || $is_rm): ?>
                <li class="nav-item">
                  <a href="<?= site_url('klinik/hasil_laporan') ?>" class="nav-link <?= $this->uri->segment(1) == 'hasil_laporan' ? 'active' : '' ?>">
                    <i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Laporan Hasil Lab & SOAP
                  </a>
                </li>
                <?php endif; ?> -->
              </ul>
            </div>
          </li>
        <?php endif; ?>

        <?php if ($is_admin || $is_rm): ?>
          <li class="nav-header">Laporan Akhir</li>
          <li class="nav-item">
            <a href="<?= site_url('klinik/form_laporan_akhir') ?>" class="nav-link <?= $this->uri->segment(1) == 'form_laporan_akhir' ? 'active' : '' ?>">
              <i class="nav-icon far fa-file-alt text-info"></i>
              <span>Form Laporan Akhir</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if ($is_admin): ?>
          <li class="nav-header">Sistem</li>
          <li class="nav-item">
            <a href="<?= site_url('klinik/user') ?>" class="nav-link <?= $this->uri->segment(1) == 'user' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users-cog text-warning"></i>
              <span>Manajemen Akun User</span>
            </a>
          </li>
          <!-- Simplification for management links -->
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collapseManajemen" role="button" aria-expanded="false">
              <i class="nav-icon fas fa-cogs text-secondary"></i>
              <span>Manajemen Petugas</span>
              <i class="fas fa-chevron-down arrow-icon"></i>
            </a>
            <div class="collapse" id="collapseManajemen" data-bs-parent="#sidebarMenu">
              <ul class="nav flex-column ms-3 mt-1">
                <li class="nav-item"><a href="<?= site_url('klinik/petugas_sampel') ?>" class="nav-link"><i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Petugas Klinik</a></li>
                <li class="nav-item"><a href="<?= site_url('klinik/petugas_verifikasi') ?>" class="nav-link"><i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Petugas Verifikasi</a></li>
                <li class="nav-item"><a href= "<?= site_url('klinik/petugas_validasi') ?>" class="nav-link" ><i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i>Petugas Validasi</a></li>
                <li class="nav-item"><a href="<?= site_url('klinik/verifikator') ?>" class="nav-link"><i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Petugas Verifikator Hasil</a></li>
                <li class="nav-item"><a href="<?= site_url('klinik/penanggung_teknis') ?>" class="nav-link"><i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Petugas Penanggung Jawab</a></li>
                <li class="nav-item"><a href="<?= site_url('klinik/petugas_dokter') ?>" class="nav-link"><i class="nav-icon far fa-circle" style="font-size: 0.5rem;"></i> Dokter Pemeriksa Rekam Medis</a></li>
              </ul>
            </div>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <script>
    function searchSidebar(keyword) {
      const items = document.querySelectorAll('#sidebarMenu .nav-item');
      const term = keyword.toLowerCase();
      items.forEach(item => {
        const span = item.querySelector('span');
        if(span) {
          item.style.display = span.innerText.toLowerCase().includes(term) ? '' : 'none';
        }
      });
    }
  </script>

  <!-- Main Content Wrapper -->
  <div id="content-wrapper">
    <!-- Navbar Top -->
    <nav class="navbar navbar-expand top-navbar px-4 py-3">
      <div class="container-fluid">
        <!-- Sidebar Toggle -->
        <button type="button" id="sidebarCollapse" class="btn btn-light shadow-sm text-success me-3 rounded-circle" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
          <i class="fas fa-bars"></i>
        </button>

        <div class="d-flex align-items-center text-dark">
          <span class="fw-bold mb-0 d-none d-md-block ms-2 h5 mb-0">
            <?php 
              $sess_role = $this->session->userdata('role');
              $display_role = (strtolower($sess_role) == 'petugas rm') ? 'Dokter' : ucfirst($sess_role);
            ?>
            Halo <?= $display_role ?>
          </span>
        </div>

        <!-- Center App Name -->
        <div class="position-absolute w-100 d-flex justify-content-center" style="left: 0; pointer-events: none;">
          <span class="h5 fw-bold text-white d-none d-lg-block mb-0" style="letter-spacing: 0.5px;">Laboratorium Kesehatan Kota Pangkal Pinang</span>
        </div>

        <div class="ms-auto">
          <a href="<?= site_url('klinik/petugas_klinik/logout') ?>" class="btn rounded-pill px-4 py-2 shadow-sm d-flex align-items-center" style="background-color: #bce9dc; color: #1c3c34; font-weight: 600; font-size: 0.9rem;">
            <i class="fas fa-sign-out-alt me-2"></i> <span>Sign Out</span>
          </a>
        </div>
      </div>
    </nav>
    
    <!-- Page Content (Dashboard content will go here) -->
    <main class="p-0 flex-grow-1">