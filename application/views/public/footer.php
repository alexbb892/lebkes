</div> <!-- end main-content container-fluid -->

<footer class="mt-auto">
  <div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 px-2 py-3"
         style="
           border-top:1px solid rgba(15,23,42,.10);
           background: rgba(255,255,255,.55);
           backdrop-filter: blur(10px);
           border-radius: 18px 18px 0 0;
           box-shadow: 0 -4px 34px rgba(2,6,23,.05);
         ">
      <div class="small text-muted">
        © <?= date('Y'); ?> <strong>KESMASNEW</strong> • Layanan Publik
      </div>
      <div class="d-flex align-items-center gap-3">
        <button id="btnTop" type="button" class="btn btn-sm btn-outline-secondary"
                style="border-radius:14px; font-weight:800;">
          <i class="bi bi-arrow-up-short" aria-hidden="true"></i> Ke Atas
        </button>
      </div>
    </div>
  </div>
</footer>

<!-- Toast container (UI only) -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
  <div id="miniToast" class="toast align-items-center border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="miniToastBody">OK</div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  (function(){
    // Back to top
    const btnTop = document.getElementById('btnTop');
    if (btnTop) {
      btnTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }

    // Mini toast helper
    const toastEl = document.getElementById('miniToast');
    const toastBody = document.getElementById('miniToastBody');
    const toast = toastEl ? new bootstrap.Toast(toastEl, { delay: 1600 }) : null;

    window.showToast = function(msg) {
      if (!toastEl || !toastBody || !toast) return;
      toastBody.textContent = msg;
      toast.show();
    }

    // Checkbox groups logic
    document.querySelectorAll('[data-check-all]').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const target = btn.getAttribute('data-check-all');
        const boxes = document.querySelectorAll(target);
        boxes.forEach(cb=> cb.checked = true);
        showToast('Semua pilihan ditandai.');
      });
    });

    document.querySelectorAll('[data-uncheck-all]').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const target = btn.getAttribute('data-uncheck-all');
        const boxes = document.querySelectorAll(target);
        boxes.forEach(cb=> cb.checked = false);
        showToast('Semua pilihan dikosongkan.');
      });
    });
  })();
</script>
</body>
</html>
