<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- CSS & Fonts -->
<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">


<div class="content-wrapper px-4 pt-4 pb-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark m-0" style="font-family: 'Inter', sans-serif;">Dashboard Pendaftaran</h2>
  </div>

  <!-- Welcome Alert -->
  <div class="custom-alert mb-4">
    <i class="fas fa-hand-sparkles me-3"></i>
    <div>
        Halo, <span class="fw-bold text-primary"><?= $this->session->userdata('nama') ?></span>. Anda login sebagai <span class="text-danger fw-bold"><?= $this->session->userdata('role') ?></span>.
    </div>
  </div>

  <div class="row mb-4">
    <!-- Pendaftaran Hari Ini -->
    <div class="col-md-4 mb-3">
      <div class="total-card h-100">
        <div class="total-card-left">
            <div class="total-card-icon"><i class="fas fa-users"></i></div>
            <div class="total-card-info">
                <div class="total-card-title">PENDAFTARAN HARI INI</div>
                <div class="total-card-value"><?= isset($total_pasien) ? $total_pasien : 0 ?></div>
                <div class="total-card-trend"><i class="fas fa-check-circle"></i> Data Real-time</div>
            </div>
        </div>
        <img src="<?= base_url('assets/img/doctor_patient.png') ?>" alt="Doctor Patient" class="total-card-image">
      </div>
    </div>
    
    <!-- Nominal Pembayaran -->
    <div class="col-md-4 mb-3">
        <div class="dashboard-card h-100 p-4 d-flex flex-column justify-content-center">
            <h5 class="fw-bold mb-4" style="font-size: 1.1rem; color: #2d3748;">Nominal Pembayaran Hari Ini</h5>
            <div class="d-flex align-items-center mb-1">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 56px; height: 56px; background-color: rgba(16, 185, 129, 0.1);">
                    <i class="fas fa-money-bill-wave text-success" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <span style="font-size: 0.9rem; font-weight: 600; color: #718096;">Total</span>
                    <h3 class="fw-bold text-dark m-0" style="font-family: 'Inter', sans-serif;">
                        Rp <?= number_format(isset($total_pendapatan) ? $total_pendapatan : 0, 0, ',', '.') ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Demografi Pasien -->
    <div class="col-md-4 mb-3">
      <div class="dashboard-card h-100">
        <div class="dashboard-card-header">
          <h5 class="dashboard-card-title fw-bold">Demografi Pasien</h5>
        </div>
        <div class="card-body p-2 d-flex align-items-center justify-content-center">
          <div class="chart-container" style="height: 180px; width: 100%;">
            <canvas id="chartGenderBaru"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Table Section -->
  <div class="dashboard-card">
    <div class="dashboard-card-header d-flex justify-content-between align-items-center p-4 border-bottom-0">
        <h5 class="fw-bold m-0" style="color: #2d3748; font-size: 1.1rem;">Daftar Pasien Terbaru</h5>
        <div class="d-flex gap-2">
            <a href="<?= site_url('form_permintaan_klinik/create') ?>" class="btn btn-cyan btn-sm px-3 py-2 fw-bold shadow-sm d-flex align-items-center" style="border-radius: 8px;">
                <i class="fas fa-stethoscope me-2"></i> Pasien Klinik
            </a>
            <a href="<?= site_url('form_permintaan_rm/create') ?>" class="btn btn-primary btn-sm px-3 py-2 fw-bold shadow-sm d-flex align-items-center" style="border-radius: 8px; background-color: #3b82f6; border-color: #3b82f6;">
                <i class="fas fa-user-plus me-2"></i> Pasien Baru
            </a>
        </div>
    </div>
    <div class="px-4 pb-3 d-flex justify-content-end">
        <input type="text" class="search-input w-25" placeholder="Search...">
    </div>
    <div class="table-responsive px-4 pb-4">
        <table class="table table-hover table-custom table-bordered mb-0">
            <thead>
                <tr>
                    <th>Waktu Daftar <i class="fas fa-sort text-muted ms-1 float-end mt-1"></i></th>
                    <th>No. Registrasi <i class="fas fa-sort text-muted ms-1 float-end mt-1"></i></th>
                    <th>Nama Pasien <i class="fas fa-sort text-muted ms-1 float-end mt-1"></i></th>
                    <th>Jenis Kelamin <i class="fas fa-sort text-muted ms-1 float-end mt-1"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($pasien_terbaru)): ?>
                    <?php foreach($pasien_terbaru as $p): ?>
                    <tr>
                        <td><?= $p->tgl_daftar ?></td>
                        <td><?= $p->no_registrasi ?></td>
                        <td><?= $p->nama_pasien ?></td>
                        <td><?= $p->jenis_kelamin ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada pasien terdaftar hari ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link text-muted" href="#" style="border-radius: 4px 0 0 4px;">Pagination</a></li>
                    <li class="page-item active"><a class="page-link" href="#" style="background-color: #459a96; border-color: #459a96;">1</a></li>
                    <li class="page-item"><a class="page-link text-dark" href="#" style="border-radius: 0 4px 4px 0;">Next ></a></li>
                </ul>
            </nav>
        </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctxGender = document.getElementById("chartGenderBaru").getContext("2d");
    
    fetch("<?= site_url('dashboard/get_demographic_data') ?>")
      .then(response => response.json())
      .then(result => {
        let totalData = 0;
        result.data.forEach(val => totalData += parseInt(val));
        
        const labelsWithCount = result.labels.map((l, i) => `${l} (${result.data[i]})`);
        
        const centerTextPluginLocal = {
          id: 'centerTextLocal',
          beforeDraw: function(chart) {
            if (chart.config.type !== 'doughnut') return;
            const { width, height, ctx } = chart;
            ctx.restore();
            
            ctx.font = "bold 2rem 'Inter', sans-serif";
            ctx.textBaseline = "middle";
            ctx.textAlign = "center";
            ctx.fillStyle = "#2d3748";
            
            const textX = Math.round(width / 2);
            const textY = Math.round(height / 2) - 5;
            
            ctx.fillText(totalData, textX, textY);
            
            ctx.font = "600 0.8rem 'Inter', sans-serif";
            ctx.fillStyle = "#718096";
            ctx.fillText("Orang", textX, textY + 25);
            ctx.save();
          }
        };

        new Chart(ctxGender, {
          type: "doughnut",
          data: {
            labels: labelsWithCount,
            datasets: [{
              data: result.data,
              backgroundColor: ["#3b82f6", "#f43f5e"],
              borderColor: "#ffffff",
              borderWidth: 2,
              hoverOffset: 4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
              legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 15, font: { size: 11 } } }
            }
          },
          plugins: [centerTextPluginLocal]
        });
      });
});
</script>
