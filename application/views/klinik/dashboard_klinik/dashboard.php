<!-- CSS & Fonts -->
<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

<div class="content-wrapper px-4 pt-4 pb-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark m-0" style="font-family: 'Inter', sans-serif;">Dashboard Analytics</h2>
  </div>

  <!-- Welcome Alert -->
  <div class="custom-alert mb-4">
    <i class="fas fa-hand-sparkles me-3"></i>
    <div>
        <?php 
          $sess_role_dash = $this->session->userdata('role');
          $display_role_dash = (strtolower($sess_role_dash) == 'petugas rm') ? 'Dokter' : $sess_role_dash;
        ?>
        Halo, <span class="fw-bold text-primary"><?= $this->session->userdata('nama') ?></span>. Anda login sebagai <span class="text-danger fw-bold"><?= $display_role_dash ?></span>.
    </div>
  </div>

  <!-- Summary Card -->
  <div class="row mb-4">
    <div class="col-md-5">
      <div class="total-card">
        <div class="total-card-left">
            <div class="total-card-icon"><i class="fas fa-users"></i></div>
            <div class="total-card-info">
                <div class="total-card-title">Total Pasien Hari Ini</div>
                <div class="total-card-value"><?= isset($total_pasien) ? $total_pasien : 0 ?></div>
                <div class="total-card-trend"><i class="fas fa-check-circle"></i> Data Real-time</div>
            </div>
        </div>
        <img src="<?= base_url('assets/img/doctor_patient.png') ?>" alt="Doctor Patient" class="total-card-image">
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Statistik Kunjungan (Single Line) -->
    <div class="col-lg-8 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-card-header">
          <h3 class="dashboard-card-title">Statistik Kunjungan Pasien Bulanan</h3>
        </div>
        <div class="card-body">
          <div class="chart-container" style="height: 350px;">
            <canvas id="chartKunjungan"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Demografi Gender -->
    <div class="col-lg-4 mb-4">
      <div class="dashboard-card h-100">
        <div class="dashboard-card-header">
          <h3 class="dashboard-card-title">Demografi Gender Pasien (Hari Ini)</h3>
        </div>
        <div class="card-body d-flex align-items-center justify-content-center">
          <div class="chart-container" style="height: 320px; width: 100%;">
            <canvas id="chartGender"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Plugin untuk teks di tengah Doughnut Chart
  const centerTextPlugin = {
    id: 'centerText',
    beforeDraw: function(chart) {
      if (chart.config.type !== 'doughnut') return;
      const { width, height, ctx } = chart;
      ctx.restore();
      
      let total = 0;
      if (chart.data.datasets[0]) {
          chart.data.datasets[0].data.forEach(val => total += parseInt(val));
      }

      ctx.font = "bold 2.5rem 'Inter', sans-serif";
      ctx.textBaseline = "middle";
      ctx.textAlign = "center";
      ctx.fillStyle = "#2d3748";
      
      const textX = Math.round(width / 2);
      const textY = Math.round(height / 2) - 10;
      
      ctx.fillText(total, textX, textY);
      
      ctx.font = "600 1rem 'Inter', sans-serif";
      ctx.fillStyle = "#718096";
      ctx.fillText("Orang", textX, textY + 30);
      ctx.save();
    }
  };

  Chart.register(centerTextPlugin);

  document.addEventListener("DOMContentLoaded", function () {
    
    // 1. Chart Statistik Kunjungan (Single Line - Total Pasien)
    fetch("<?= site_url('klinik/dashboard/get_monthly_kunjungan_data') ?>")
      .then(response => response.json())
      .then(result => {
        const ctx = document.getElementById("chartKunjungan").getContext("2d");
        
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, "rgba(52, 152, 219, 0.4)");
        gradient.addColorStop(1, "rgba(52, 152, 219, 0.0)");

        new Chart(ctx, {
          type: "line",
          data: {
            labels: result.labels,
            datasets: [{
              label: "Total Pasien",
              data: result.data,
              borderColor: "#3498db",
              backgroundColor: gradient,
              borderWidth: 3,
              fill: true,
              tension: 0.4,
              pointRadius: 4,
              pointBackgroundColor: "#fff"
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: true, position: 'top' }
            },
            scales: {
              y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
          }
        });
      });

    // 2. Chart Demografi Gender
    fetch("<?= site_url('klinik/dashboard/get_demographic_data') ?>")
      .then(response => response.json())
      .then(result => {
        const ctxGender = document.getElementById("chartGender").getContext("2d");
        const labelsWithCount = result.labels.map((l, i) => `${l} (${result.data[i]} Orang)`);

        new Chart(ctxGender, {
          type: "doughnut",
          data: {
            labels: labelsWithCount,
            datasets: [{
              data: result.data,
              backgroundColor: ["#5c6bc0", "#ff8a65"],
              borderColor: "#ffffff",
              borderWidth: 4,
              hoverOffset: 5
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
              legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            }
          }
        });
      });
  });
</script>