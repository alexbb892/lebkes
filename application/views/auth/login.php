<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - KESMASNEW</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand-color: #005c97;
      --brand-color-dark: #363795;
      --secondary-color: #1cb5e0;
      --light-grey: #f8f9fa;
      --text-color: #212529;
      --text-muted: #6c757d;
      --card-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, var(--brand-color), var(--brand-color-dark), var(--secondary-color));
      background-size: 400% 400%;
      color: var(--text-color);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 1rem;
      animation: animated-gradient 15s ease infinite;
    }

    @keyframes animated-gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .login-container {
      max-width: 420px;
      width: 100%;
    }

    .login-card {
      background-color: rgba(255, 255, 255, 0.95);
      border: none;
      border-radius: 24px;
      padding: 2.5rem;
      box-shadow: var(--card-shadow);
      backdrop-filter: blur(10px);
      animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
    
    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .login-header .logo-icon {
      display: inline-block;
      background: linear-gradient(135deg, var(--brand-color), var(--secondary-color));
      color: #2d3748;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      line-height: 60px;
      font-size: 1.8rem;
      margin-bottom: 1rem;
      animation: pulse 2s infinite ease-in-out;
    }
    
    @keyframes pulse {
      0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0, 92, 151, 0.7); }
      70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(0, 92, 151, 0); }
      100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0, 92, 151, 0); }
    }

    .login-header h2 {
      font-weight: 700;
      color: var(--text-color);
      animation: slideInUp 0.6s ease-out;
    }

    .login-header p {
      color: var(--text-muted);
      animation: slideInUp 0.7s ease-out;
    }

    .form-control, .btn, .alert {
      border-radius: 12px;
    }
    
    .form-group {
        animation: slideInUp 0.8s ease-out;
    }

    .form-control {
      padding: 1rem;
      border: 1px solid #dee2e6;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: var(--brand-color);
      box-shadow: 0 0 0 0.25rem rgba(0, 92, 151, 0.2);
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--brand-color), var(--brand-color-dark));
      border: none;
      padding: 1rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      box-shadow: 0 10px 20px -5px rgba(0, 92, 151, 0.4);
      animation: slideInUp 0.9s ease-out;
    }

    .btn-primary:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 25px -5px rgba(0, 92, 151, 0.5);
    }

    .footer-text {
        text-align: center;
        margin-top: 1.5rem;
        color: rgba(255,255,255,0.85);
        font-size: 0.9rem;
        animation: fadeIn 1s ease-out;
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="card login-card">
        <div class="login-header">
            <div class="logo-icon"><i class="bi bi-shield-check"></i></div>
            <h2>Portal KESMAS</h2>
            <p>Silakan masuk untuk melanjutkan</p>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="animation: slideInUp 0.75s ease-out;">
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/do_login') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            
            <div class="mb-3 form-group">
                <label for="username" class="form-label visually-hidden">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>

            <div class="mb-4 form-group" style="animation-delay: 0.1s;">
                <label for="password" class="form-label visually-hidden">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
            </div>
        </form>
    </div>
    <div class="footer-text">
        © <?= date('Y'); ?> KESMASNEW &bull; Sistem Informasi Kesehatan Masyarakat
        <br>
        <span style="font-size: 0.8em; opacity: 0.7;">Alex Ramadhan & Nadine Antya Putri ISB ATMALUHUR PKP 2025</span>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
