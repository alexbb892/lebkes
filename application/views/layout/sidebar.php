<!-- Optional (kalau belum ada di layout/header): Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
  :root {
    --sb-ink: #0f172a;
    --sb-muted: #64748b;
    --sb-brand: #4f46e5;
    --sb-brand-light: #818cf8;
    --sb-bg: rgba(255, 255, 255, 0.6);
    --sb-border: rgba(255, 255, 255, 0.7);
    --sb-hover: rgba(255, 255, 255, 0.9);
  }

  body.dark-mode {
    --sb-ink: #f8fafc;
    --sb-muted: #94a3b8;
    --sb-bg: rgba(15, 23, 42, 0.5);
    --sb-border: rgba(30, 41, 59, 0.6);
    --sb-hover: rgba(30, 41, 59, 0.9);
  }

  /* Sidebar Core */
  .sidebar {
    position: sticky;
    top: 85px; /* Turunkan batas atas agar tidak tertabrak navbar */
    height: calc(100vh - 85px); /* Sesuaikan tinggi agar bagian bawah tidak terpotong */
    overflow-y: auto;
    overflow-x: hidden;
    background: var(--sb-bg) !important;
    backdrop-filter: blur(20px) saturate(200%);
    -webkit-backdrop-filter: blur(20px) saturate(200%);
    border-right: none !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;

    box-shadow: 4px 0 24px rgba(0,0,0,0.02);
    z-index: 1020; /* Pastikan melayang di atas konten tapi tetap di bawah navbar (z-index 1030) */
  }
  
  .sidebar-inner {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    min-height: 100%;
  }

  /* Brand Logo */
  .sb-brand {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.85rem 1rem;
    border-radius: 16px;
    background: transparent;
    border: 1px solid rgba(79, 70, 229, 0.15);
    margin-bottom: 2rem;
    text-decoration: none;
    position: relative;
    transition: all 0.3s ease;
  }
  body.dark-mode .sb-brand {
    border-color: rgba(255,255,255,0.1);
  }
  .sb-brand:hover {
    background: rgba(79, 70, 229, 0.05);
    border-color: rgba(79, 70, 229, 0.3);
    transform: translateY(-2px);
  }
  
  .sb-badge {
    position: relative;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--sb-brand), #9333ea);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    flex-shrink: 0;
    transition: all 0.3s ease;
  }
  .sb-brand:hover .sb-badge {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
  }
  
  /* Glowing Status Dot */
  .sb-badge::after {
    content: '';
    position: absolute;
    top: -3px;
    right: -3px;
    width: 12px;
    height: 12px;
    background-color: #10b981;
    border: 2px solid white;
    border-radius: 50%;
    animation: pulse-dot 2s infinite;
  }
  body.dark-mode .sb-badge::after {
    border-color: #0f172a;
  }
  @keyframes pulse-dot {
    0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
    100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
  }
  
  .sb-text-wrap {
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-top: -2px;
  }
  
  .sb-title {
    font-weight: 900;
    font-size: 1.2rem;
    color: var(--sb-ink);
    letter-spacing: 0.5px;
    line-height: 1.2;
  }
  .sb-sub {
    font-size: 0.7rem;
    color: var(--sb-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    line-height: 1.2;
  }

  /* Section Titles */
  .sb-section {
    font-size: 0.7rem;
    font-weight: 800;
    color: var(--sb-muted);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin: 1.5rem 0 0.75rem 0.5rem;
    display: flex;
    align-items: center;
    opacity: 0.8;
  }
  .sb-section::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--sb-border);
    margin-left: 12px;
  }

  /* Navigation Links */
  .sidebar .nav-pills {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
  }
  .sidebar .nav-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.85rem 1.25rem;
    border-radius: 16px;
    color: var(--sb-ink);
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid transparent;
    position: relative;
    overflow: hidden;
    text-decoration: none;
  }
  .sidebar .nav-link i {
    font-size: 1.25rem;
    color: var(--sb-muted);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    z-index: 1;
  }
  .sidebar .nav-link span {
    z-index: 1;
  }
  
  /* Background effect for links */
  .sidebar .nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--sb-hover);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 0;
  }

  .sidebar .nav-link:hover {
    border-color: var(--sb-border);
    transform: translateX(6px);
  }
  .sidebar .nav-link:hover::before {
    opacity: 1;
  }
  .sidebar .nav-link:hover i {
    color: var(--sb-brand);
    transform: scale(1.15) rotate(-5deg);
  }

  /* Active State */
  .sidebar .nav-link.active {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(147, 51, 234, 0.05));
    border-color: rgba(79, 70, 229, 0.25);
    color: var(--sb-brand);
    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.3);
  }
  body.dark-mode .sidebar .nav-link.active {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.2), rgba(147, 51, 234, 0.15));
    border-color: rgba(79, 70, 229, 0.4);
    color: var(--sb-brand-light);
  }
  .sidebar .nav-link.active::after {
    content: '';
    position: absolute;
    left: 0;
    top: 15%;
    height: 70%;
    width: 4px;
    background: linear-gradient(to bottom, var(--sb-brand), #9333ea);
    border-radius: 0 4px 4px 0;
    box-shadow: 2px 0 12px var(--sb-brand);
    z-index: 2;
  }
  .sidebar .nav-link.active i {
    color: var(--sb-brand);
    filter: drop-shadow(0 2px 5px rgba(79, 70, 229, 0.4));
  }
  body.dark-mode .sidebar .nav-link.active i {
    color: var(--sb-brand-light);
  }

  /* Submenu Styles */
  .sidebar-parent-toggle::after {
    content: '\F282'; /* bootstrap-icons chevron-down */
    font-family: 'bootstrap-icons';
    margin-left: auto;
    font-size: 0.8rem;
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    color: var(--sb-muted);
    z-index: 1;
  }
  .sidebar-parent-toggle.expanded::after {
    transform: rotate(-180deg);
  }
  
  .sidebar-submenu {
    display: none;
    padding-left: 2rem;
    margin-top: 0.25rem;
    margin-bottom: 0.5rem;
    animation: slideDown 0.3s ease-out forwards;
  }
  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .sidebar-submenu.show {
    display: block;
  }
  
  .sidebar-submenu .nav-link {
    padding: 0.65rem 1rem;
    font-size: 0.88rem;
    font-weight: 500;
    border-radius: 12px;
    margin-bottom: 0.2rem;
  }
  .sidebar-submenu .nav-link i {
    font-size: 1.1rem;
    width: 20px;
  }
  .sidebar-submenu .nav-link.active::after {
    display: none;
  }
  .sidebar-submenu .nav-link.active {
    box-shadow: none;
    background: rgba(79, 70, 229, 0.08);
  }

  /* Bottom Actions */
  .sb-bottom {
    margin-top: auto;
    padding-top: 2rem;
  }
  
  .sb-card {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(147, 51, 234, 0.08));
    border: 1px solid rgba(79, 70, 229, 0.2);
    border-radius: 18px;
    padding: 1.25rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  body.dark-mode .sb-card {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(147, 51, 234, 0.15));
  }
  .sb-card:hover {
    box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.2);
    transform: translateY(-2px);
    border-color: rgba(79, 70, 229, 0.4);
  }
  
  .sb-card-icon {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.75rem auto;
    color: var(--sb-brand);
    font-size: 1.2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  }
  body.dark-mode .sb-card-icon {
    background: rgba(30,41,59,0.8);
    color: var(--sb-brand-light);
  }

  .sb-card-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--sb-ink);
    margin-bottom: 0.25rem;
  }
  .sb-card-text {
    font-size: 0.75rem;
    color: var(--sb-muted);
    margin-bottom: 1rem;
    line-height: 1.4;
  }

  .btn-sb-action {
    background: linear-gradient(135deg, var(--sb-brand), #9333ea);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.7rem 1rem;
    font-weight: 600;
    font-size: 0.85rem;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  .btn-sb-action:hover {
    box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
    transform: scale(1.03);
    color: white;
  }

  /* Scrollbar */
  .sidebar::-webkit-scrollbar {
    width: 6px;
  }
  .sidebar::-webkit-scrollbar-track {
    background: transparent;
  }
  .sidebar::-webkit-scrollbar-thumb {
    background: var(--sb-border);
    border-radius: 10px;
  }
  .sidebar::-webkit-scrollbar-thumb:hover {
    background: var(--sb-muted);
  }

  main#main-content {
    background: transparent;
  }
</style>

<aside id="sidebar" class="sidebar">
  <div class="sidebar-inner">
    <?php
      $uri = uri_string();
      $is_kesmas_active = strpos($uri,'kesmas/') !== false && strpos($uri,'kesmas/survei') === false;
      $is_lab_management_active = strpos($uri,'tindakan_sampel') !== false;
      $is_report_active = strpos($uri,'kesmas/survei') !== false;
      $is_petugas_active = strpos($uri,'petugas') !== false || strpos($uri,'verifikator') !== false || strpos($uri,'penanggung_jawab_teknis') !== false;
    ?>

    <!-- Brand -->
    <a href="<?= site_url('dashboard') ?>" class="sb-brand">
      <div class="sb-badge">
        <i class="bi bi-activity"></i>
      </div>
      <div class="sb-text-wrap">
        <div class="sb-title">KESMAS</div>
        <div class="sb-sub">Smart Portal</div>
      </div>
    </a>

    <!-- Menu -->
    <div class="nav flex-column nav-pills">
      
      <a class="nav-link <?= ($uri=='' || $uri=='dashboard') ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
      </a>

      <div class="sb-section">Layanan Kesmas</div>

      <a href="#" class="nav-link sidebar-parent-toggle <?= $is_kesmas_active ? 'active expanded' : '' ?>" data-target="kesmasSubmenu">
        <i class="bi bi-folder-fill"></i>
        <span>Manajemen Sample</span>
      </a>
      <div id="kesmasSubmenu" class="sidebar-submenu <?= $is_kesmas_active ? 'show' : '' ?>">
        <a class="nav-link <?= (strpos($uri,'kesmas/form_permintaan_kesmas')!==false && strpos($uri,'uji_')===false) ? 'active' : '' ?>" href="<?= site_url('kesmas/pendaftaran') ?>">
          <i class="bi bi-clipboard2-check"></i>
          <span>Pendaftaran</span>
        </a>
        <a class="nav-link <?= (strpos($uri,'kesmas/permintaan_sample')!==false) ? 'active' : '' ?>" href="<?= site_url('kesmas/permintaan_sample') ?>">
          <i class="bi bi-inbox-fill"></i>
          <span>Terima Sample</span>
        </a>
        <a class="nav-link <?= (strpos($uri,'kesmas/form_permintaan_kesmas/uji')!==false) ? 'active' : '' ?>" href="<?= site_url('kesmas/uji') ?>">
          <i class="bi bi-ui-checks-grid"></i>
          <span>Input Hasil</span>
        </a>
        <a class="nav-link <?= (strpos($uri,'kesmas/laporan_uji_kesmas')!==false) ? 'active' : '' ?>" href="<?= site_url('kesmas/laporan') ?>">
          <i class="bi bi-bar-chart-line-fill"></i>
          <span>Laporan Uji</span>
        </a>
        <a class="nav-link <?= (strpos($uri,'kesmas/laporan/parameter')!==false) ? 'active' : '' ?>" href="<?= site_url('kesmas/laporan/parameter') ?>">
          <i class="bi bi-list-columns"></i>
          <span>Lap. Parameter</span>
        </a>
      </div>

      <div class="sb-section">Fasilitas Lab</div>

      <a href="#" class="nav-link sidebar-parent-toggle <?= $is_lab_management_active ? 'active expanded' : '' ?>" data-target="labSubmenu">
        <i class="bi bi-building-fill"></i>
        <span>Lab Management</span>
      </a>
      <div id="labSubmenu" class="sidebar-submenu <?= $is_lab_management_active ? 'show' : '' ?>">
        <a class="nav-link <?= (strpos($uri,'tindakan_sampel')!==false) ? 'active' : '' ?>" href="<?= site_url('tindakan_sampel') ?>">
          <i class="bi bi-list-check"></i>
          <span>Tindakan Sampel</span>
        </a>
      </div>

      <div class="sb-section">Pantauan & Audit</div>

      <a href="#" class="nav-link sidebar-parent-toggle <?= $is_report_active ? 'active expanded' : '' ?>" data-target="reportSubmenu">
        <i class="bi bi-journal-text"></i>
        <span>Survei & Log</span>
      </a>
      <div id="reportSubmenu" class="sidebar-submenu <?= $is_report_active ? 'show' : '' ?>">
        <a class="nav-link <?= (strpos($uri,'kesmas/survei')!==false) ? 'active' : '' ?>" href="<?= site_url('kesmas/survei/laporan') ?>">
          <i class="bi bi-chat-left-quote-fill"></i>
          <span>Survei Kepuasan</span>
        </a>
      
      <?php if ($this->session->userdata('role') === 'admin'): ?>
        <a class="nav-link <?= ($uri=='security' || strpos($uri,'security/')===0) ? 'active' : '' ?>" href="<?= site_url('security') ?>">
          <i class="bi bi-shield-lock-fill"></i>
          <span>Security Dashboard</span>
        </a>
      <?php endif; ?>
      </div>

      <div class="sb-section">Sumber Daya</div>

      <a href="#" class="nav-link sidebar-parent-toggle <?= $is_petugas_active ? 'active expanded' : '' ?>" data-target="staffSubmenu">
        <i class="bi bi-people-fill"></i>
        <span>Tim Internal</span>
      </a>
      <div id="staffSubmenu" class="sidebar-submenu <?= $is_petugas_active ? 'show' : '' ?>">
        <a class="nav-link <?= (strpos($uri,'petugas')!==false) ? 'active' : '' ?>" href="<?= site_url('petugas') ?>">
          <i class="bi bi-people-fill"></i>
          <span>Daftar Petugas</span>
        </a>
        <a class="nav-link <?= (strpos($uri,'verifikator')!==false) ? 'active' : '' ?>" href="<?= site_url('verifikator') ?>">
          <i class="bi bi-person-check-fill"></i>
          <span>Verifikator</span>
        </a>
        <a class="nav-link <?= (strpos($uri,'penanggung_jawab_teknis')!==false) ? 'active' : '' ?>" href="<?= site_url('penanggung_jawab_teknis') ?>">
          <i class="bi bi-person-badge"></i>
          <span>PJT</span>
        </a>
      </div>

    </div>

    <!-- Bottom Actions Area -->
    <div class="sb-bottom">
      <div class="sb-card">
        <div class="sb-card-icon">
          <i class="bi bi-moon-stars-fill"></i>
        </div>
        <div class="sb-card-title">Tema Aplikasi</div>
        <div class="sb-card-text">Sesuaikan tampilan antarmuka untuk kenyamanan Anda.</div>
        <button class="btn-sb-action" data-toggle-dark>
          <i class="bi bi-palette-fill"></i>
          Ganti Tema
        </button>
      </div>
    </div>
    
    <!-- Load Premium JS -->
    <script src="<?= base_url('assets/js/premium.js') ?>"></script> 
  </div>
</aside>
<div id="sidebar-resizer"></div>
<main id="main-content" class="p-4">
  <?php $this->load->view('partials/flash'); ?>
  <script>
  (function(){
    try {
      const storageKey = 'sidebar_active_href';
      const stored = localStorage.getItem(storageKey);
      
      if (stored) {
        try {
          document.querySelectorAll('.sidebar .nav-link.active').forEach(function(a){ a.classList.remove('active'); });
          const match = document.querySelector('.sidebar .nav-link[href="' + stored + '"]');
          if (match) {
            match.classList.add('active');
            var submenu = match.closest('.sidebar-submenu');
            if (submenu) {
              submenu.classList.add('show');
              var parentToggle = document.querySelector('.sidebar-parent-toggle[data-target="' + submenu.id + '"]');
              if (parentToggle) parentToggle.classList.add('active','expanded');
            }
          }
        } catch (e) {}
      }

      document.querySelectorAll('.sidebar .nav-link').forEach(function(el){
        el.addEventListener('click', function(e){
          var href = el.getAttribute('href');
          if (href && href !== '#') {
            try { localStorage.setItem(storageKey, href); } catch(_){}
          }
          if(!el.classList.contains('sidebar-parent-toggle')) {
             try {
               document.querySelectorAll('.sidebar .nav-link.active').forEach(function(a){ a.classList.remove('active'); });
             } catch(_){}
             el.classList.add('active');
          }
        });
      });

      document.querySelectorAll('.sidebar-parent-toggle').forEach(function(toggle){
        var targetId = toggle.getAttribute('data-target');
        var submenu = document.getElementById(targetId);
        if (!submenu) return;

        var submenuKey = 'sidebar_' + targetId + '_open';
        var storedOpen = localStorage.getItem(submenuKey);
        if (storedOpen === 'true' || submenu.classList.contains('show')) {
          submenu.classList.add('show');
          toggle.classList.add('expanded');
        }

        toggle.addEventListener('click', function(e){
          e.preventDefault();
          var opened = submenu.classList.toggle('show');
          toggle.classList.toggle('expanded', opened);
          try { localStorage.setItem(submenuKey, opened ? 'true' : 'false'); } catch(_){}
        });
      });
    } catch (err) {}
  })();
  </script>
