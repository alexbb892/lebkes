<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- CSS & Fonts -->
<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="content-wrapper px-4 pt-4 pb-5" style="background-color: #f4f7f6;">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark m-0" style="font-family: 'Inter', sans-serif;">Dashboard Pemeriksaan Sampel</h2>
  </div>

    <!-- Welcome Alert -->
  <div class="custom-alert mb-4">
    <i class="fas fa-hand-sparkles me-3"></i>
    <div>
        Halo, <span class="fw-bold text-primary"><?= $this->session->userdata('nama') ?></span>. Anda login sebagai <span class="text-danger fw-bold"><?= $this->session->userdata('role') ?></span>.
    </div>
  </div>

  <div class="row">
    <!-- Main Content -->
    <div class="col-12">
        
      <!-- Top Cards -->
      <div class="row mb-4">
        <!-- Card 1 -->
        <div class="col-md-6 mb-3 mb-md-0">
          <div class="klinik-stat-card d-flex align-items-center p-3">
            <div class="klinik-icon-box me-3">
              <i class="fas fa-users fs-3"></i>
            </div>
            <div>
              <p class="text-muted mb-1 fw-medium" style="font-size: 0.9rem;">Total Pasien Hari Ini</p>
              <h2 class="fw-bold m-0 mb-1" style="color: #1e293b;"><?= isset($total_pasien) ? $total_pasien : 0 ?></h2>
            </div>
          </div>
        </div>
        <!-- Card 2 -->
        <div class="col-md-6">
          <div class="klinik-stat-card d-flex align-items-center p-3">
            <div class="klinik-icon-box me-3" style="background-color: #f0fdf4; color: #16a34a;">
              <i class="fas fa-vial fs-3"></i>
            </div>
            <div>
              <p class="text-muted mb-1 fw-medium" style="font-size: 0.9rem;">HASIL LAB SIAP</p>
              <h2 class="fw-bold m-0 mb-1" style="color: #1e293b;"><?= isset($hasil_lab_siap) ? $hasil_lab_siap : 0 ?></h2>
            </div>
          </div>
        </div>
      </div>

      <!-- Table: Daftar Permintaan Klinik -->
      <div class="klinik-table-card mb-4">
        <h5 class="fw-bold mb-4" style="color: #1e293b;">Daftar Uji Lab Klinik</h5>
        <div class="table-responsive">
          <table id="tabel-permintaan" class="table table-bordered table-striped table-hover nowrap" style="width:100%">
            <thead class="bg-light">
              <tr>
                <th width="5%">No</th>
                <th>No Register</th>
                <th>Nama Pasien</th>
                <th>NIK</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Form</th>
                <th>Dokter Pengirim</th>
                <th width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($formulir)): ?>
                <?php $no = 1; foreach ($formulir as $f): ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $f->no_register ?></td>
                    <td><?= !empty($f->nama_pasien) ? $f->nama_pasien : ($f->nama ?? '-') ?></td>
                    <td><?= $f->nik ?></td>
                    <td><?= $f->gender ?></td>
                    <td><?= $f->tgl_form ?></td>
                    <td><?= $f->nama_dokter ?></td>
                    <td class="text-center">
                      <a href="<?= site_url('uji_klinik/input/'.$f->id) ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-vial"></i> Input Hasil
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Chart: Tren Permintaan
      <div class="klinik-table-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="fw-bold m-0" style="color: #1e293b;">Tren Permintaan & Penyelesaian Mingguan</h5>
          <div class="klinik-chart-controls btn-group rounded-3 shadow-sm">
            <button class="btn btn-sm"><i class="fas fa-filter"></i></button>
            <button class="btn btn-sm"><i class="far fa-calendar"></i> <i class="fas fa-chevron-down ms-1" style="font-size: 0.7rem;"></i></button>
          </div>
        </div>
        <div style="height: 250px; width: 100%;">
          <canvas id="chartTrenKlinik"></canvas>
        </div>
      </div> -->

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("chartTrenKlinik").getContext("2d");
    
    // Create gradient for the area chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, "rgba(75, 192, 192, 0.5)"); // Light teal top
    gradient.addColorStop(1, "rgba(75, 192, 192, 0.0)"); // Transparent bottom

    new Chart(ctx, {
        type: "line",
        data: {
            labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            datasets: [{
                label: "Permintaan",
                data: [5, 2.5, 10, 7.5, 5, 11, 2.5],
                borderColor: "#4bc0c0",
                backgroundColor: gradient,
                borderWidth: 2,
                pointBackgroundColor: "#fff",
                pointBorderColor: "#4bc0c0",
                pointBorderWidth: 2,
                pointRadius: 4,
                fill: true,
                tension: 0.4 // Smooth curve
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(255,255,255,0.9)',
                    titleColor: '#1e293b',
                    bodyColor: '#475569',
                    borderColor: '#e2e8f0',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                },
                y: {
                    min: 0,
                    max: 12,
                    ticks: {
                        stepSize: 2,
                        color: '#94a3b8'
                    },
                    border: { display: false },
                    grid: { color: '#f1f5f9' }
                }
            }
        }
    });
});
</script>
