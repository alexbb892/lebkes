<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? htmlspecialchars($title) . ' - KESMAS' : 'KESMAS - Health Management' ?></title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png') ?>">
  <link rel="apple-touch-icon" href="<?= base_url('assets/img/logo.png') ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- DataTables & Select2 CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
  
  <!-- Optional: Icons + Font (UI only) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Custom UI Polish -->
  <link rel="stylesheet" href="<?= base_url('assets/css/ui-polish.css') ?>">

  <style>
    :root{
      --ink:#0b1220;
      --muted:#667085;
      --line: rgba(15,23,42,.10);
      --bg:
        radial-gradient(900px 420px at 14% 0%, rgba(13,110,253,.12), transparent 62%),
        radial-gradient(900px 420px at 92% 10%, rgba(34,197,94,.08), transparent 60%),
        linear-gradient(180deg, #f7f8fc 0%, #eef2f7 100%);
      --glass: rgba(255,255,255,.72);
      --shadow: 0 22px 70px rgba(2,6,23,.12);
      --shadow2: 0 12px 30px rgba(2,6,23,.10);
      --brand:#0d6efd;
      --brand2:#0b5ed7;
    }

    body{
      background: var(--bg);
      color: var(--ink);
      font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    /* Navbar */
    .navbar-wow{
      position: sticky;
      top: 0;
      z-index: 1030;
      border-bottom: 1px solid rgba(255, 255, 255, 0.4);
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(12px) saturate(150%);
      -webkit-backdrop-filter: blur(12px) saturate(150%);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      padding: 0.8rem 1rem;
      transition: all 0.3s ease;
    }
    body.dark-mode .navbar-wow {
      background: rgba(15, 23, 42, 0.7);
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .navbar-wow:hover {
      background: rgba(255, 255, 255, 0.85);
    }
    body.dark-mode .navbar-wow:hover {
      background: rgba(15, 23, 42, 0.85);
    }

    .navbar-brand{
      font-weight: 900;
      font-size: 1.25rem;
      color: var(--ink) !important;
      letter-spacing: -0.5px;
      display:flex;
      align-items:center;
    }
    body.dark-mode .navbar-brand {
      color: #f8fafc !important;
    }
    .brand-sub{
      display:block;
      font-size: 0.7rem;
      font-weight: 700;
      color: #4f46e5;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-top: 2px;
    }
    body.dark-mode .brand-sub {
      color: #818cf8;
    }

    .user-pill{
      display:flex;
      align-items:center;
      gap:.75rem;
      padding: 0.4rem 0.6rem 0.4rem 0.4rem;
      border-radius: 50px;
      background: #ffffff;
      border: 1px solid rgba(0,0,0,0.05);
      box-shadow: 0 4px 15px rgba(0,0,0,0.03);
      transition: all 0.3s ease;
    }
    .user-pill:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      border-color: rgba(79, 70, 229, 0.3);
    }
    body.dark-mode .user-pill {
      background: rgba(30, 41, 59, 0.8);
      border-color: rgba(255, 255, 255, 0.1);
    }
    body.dark-mode .user-pill:hover {
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
      border-color: rgba(129, 140, 248, 0.4);
    }

    .avatar{
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display:flex;
      align-items:center;
      justify-content:center;
      background: linear-gradient(135deg, #4f46e5, #9333ea);
      border: 2px solid #fff;
      font-weight: 800;
      font-size: 1rem;
      user-select:none;
      color: white;
      box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    }
    body.dark-mode .avatar {
      border-color: #1e293b;
    }

    .user-meta{
      line-height: 1.1;
    }
    .user-name{
      font-weight: 700;
      font-size: .9rem;
      color: var(--ink);
      max-width: 150px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    body.dark-mode .user-name {
      color: #f8fafc;
    }
    .user-role{
      font-size: 0.75rem;
      font-weight: 600;
      color: #64748b;
      margin-top: 2px;
      display: flex;
      align-items: center;
    }
    body.dark-mode .user-role {
      color: #94a3b8;
    }

    .btn-logout{
      border-radius: 20px;
      font-weight: 600;
      padding: 0.4rem 1rem;
      border: 1px solid rgba(239, 68, 68, 0.2);
      background: rgba(239, 68, 68, 0.05);
      color: #ef4444;
      transition: all 0.3s ease;
      font-size: 0.875rem;
      display: flex;
      align-items: center;
      margin-left: 0.5rem;
    }

    .btn-logout:hover {
      background: #ef4444;
      color: white;
      border-color: #ef4444;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

/* GLOBAL UI polish */
    .sidebar { 
      min-height: 100vh; 
      border-right: none !important; 
    }

    .nav-link.active { font-weight: 800; }

    .table thead th{
      background: rgba(248,250,252,.95);
      border-bottom: 1px solid rgba(15,23,42,.10);
      color: #000;
    }

    .badge-soft{
      background: rgba(13,110,253,.10);
      color: #0b5ed7;
      border: 1px solid rgba(13,110,253,.18);
    }

    /* Cards look consistent */
    .card{
      border-radius: 18px;
      border: 1px solid rgba(15,23,42,.10);
      box-shadow: var(--shadow2);
    }

    /* Make container spacing feel premium */
    .container-fluid{
      padding-left: 1rem;
      padding-right: 1rem;
    }

    @media (max-width: 575.98px){
      .user-name{ max-width: 140px; }
      .brand-sub{ display:none; }
    }

    /* Resizable sidebar layout */
    :root {
      --sidebar-width: 280px; /* Default width */
    }
    .container-fluid > .row {
      flex-wrap: nowrap;
    }
    #sidebar {
      width: var(--sidebar-width);
      flex-shrink: 0;
      /* transition is handled in JS to prevent animation during drag */
    }
    #sidebar-resizer {
      flex-shrink: 0;
      width: 5px;
      cursor: col-resize;
      background-color: transparent;
      transition: background-color 0.2s ease;
      position: sticky;
      top: 85px;
      height: calc(100vh - 85px);
      z-index: 10;
    }
#sidebar-resizer:hover,
#sidebar-resizer.is-resizing {
  background-color: transparent;
}
#main-content {
      flex-grow: 1;
      width: 1px; /* Prevents flexbox from overflowing when content is wide */
      overflow-x: auto;
    }

    /* Mobile Responsive Sidebar */
    .mobile-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(15, 23, 42, 0.4);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      z-index: 1035;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .mobile-overlay.show {
      display: block;
      opacity: 1;
    }
    @media (max-width: 991.98px) {
      #sidebar {
        position: fixed !important;
        left: -320px;
        top: 0 !important;
        height: 100vh !important;
        z-index: 1040;
        transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 280px !important;
        box-shadow: 10px 0 40px rgba(0,0,0,0.15);
      }
      #sidebar.show-mobile {
        left: 0;
      }
      #sidebar-resizer {
        display: none !important;
      }
      #main-content {
        width: 100% !important;
        padding: 1rem !important;
      }
    }
  </style>
</head>
<body>
<script>
  // Apply stored sidebar width from localStorage to a CSS variable on page load
  (function() {
    const storedWidth = localStorage.getItem('sidebarWidth');
    if (storedWidth) {
      document.documentElement.style.setProperty('--sidebar-width', storedWidth);
    }
  })();
</script>

<?php
  // UI-only: inisial avatar (tanpa ubah logic)
  $current_user = $current_user ?? current_user();
  $nm = trim((string)($current_user['nama'] ?? ''));
  $initial = $nm !== '' ? mb_strtoupper(mb_substr($nm, 0, 1)) : 'U';
?>

<nav class="navbar navbar-expand-lg navbar-wow">
  <div class="container-fluid">
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-outline-secondary d-lg-none" id="mobileSidebarToggle" type="button" style="border-radius: 12px; padding: 0.3rem 0.6rem;">
        <i class="bi bi-list" style="font-size: 1.2rem;"></i>
      </button>
      <a class="navbar-brand" href="<?= site_url('dashboard') ?>">
        <span>
          KESMAS
          <span class="brand-sub">Health Management</span>
        </span>
      </a>
    </div>

    <div class="d-flex align-items-center gap-2">
      <div class="user-pill">
        <div class="avatar" aria-hidden="true"><?= htmlspecialchars($initial) ?></div>
        <div class="user-meta">
          <div class="user-name"><?= htmlspecialchars($current_user['nama'] ?? '') ?></div>
          <div class="user-role">
            <i class="bi bi-person-badge me-1" aria-hidden="true"></i>
            <?= htmlspecialchars($current_user['role'] ?? '') ?>
          </div>
        </div>
        <a class="btn-logout" href="<?= site_url('logout') ?>" title="Keluar">
          <i class="bi bi-box-arrow-right me-1" aria-hidden="true"></i>Logout
        </a>
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
