    </main> <!-- /main page content -->

    <footer class="mt-auto py-3 bg-white border-top text-center shadow-sm">
      <div class="container-fluid text-sm text-muted">
        <strong>&copy; <?= date('Y') ?> ISB Atma Luhur</strong> - Sistem Informasi Laboratorium Kesehatan.
      </div>
    </footer>
  </div> <!-- /content-wrapper -->
</div> <!-- /wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- Custom Sidebar & Layout Script -->
<script>
  $(document).ready(function () {
      // Toggle sidebar
      $('#sidebarCollapse, #sidebarOverlay').on('click', function () {
          if($(window).width() <= 768) {
              $('#sidebar').toggleClass('active');
              $('#sidebarOverlay').toggleClass('active');
          } else {
              $('#sidebar').toggleClass('collapsed');
          }
      });

      // DataTables inisialisasi default
      const dtConfig = {
        responsive: true,
        autoWidth: false,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Cari...",
          paginate: {
            previous: "←",
            next: "→"
          },
          zeroRecords: "Data tidak ditemukan",
          info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
          lengthMenu: "Tampilkan _MENU_ data"
        }
      };

      // Terapkan ke semua tabel
      if($.fn.DataTable) {
          $('#tabel-permintaan, #tabel-dokter, #tabel-pasien, #tabel-ambil-sampel, #tabel-pembayaran').DataTable(dtConfig);
      }
  });
</script>

</body>
</html>
