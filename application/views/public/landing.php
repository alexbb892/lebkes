<div class="container mt-4 mb-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0 animate-fade-up">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill" style="background: rgba(13,110,253,.1); border: 1px solid rgba(13,110,253,.2);">
                <span class="badge bg-primary rounded-pill">Baru</span>
                <span class="small fw-bold text-primary">Portal Layanan Terpadu</span>
            </div>
            <h1 style="font-weight: 900; color: var(--ink); font-size: 3.2rem; letter-spacing: -1.5px; line-height: 1.15;">
                Layanan Pengujian<br>
                <span style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Kesehatan Masyarakat</span>
            </h1>
            <p class="text-muted mt-3 mb-4" style="font-size: 1.15rem; line-height: 1.6; max-width: 90%;">
                Portal resmi untuk pendaftaran pengujian sampel air, makanan, dan lingkungan. 
                Daftarkan sampel Anda secara online dan pantau status pengujiannya secara real-time.
            </p>
            <div class="d-flex gap-3 flex-wrap">
                <a href="<?= site_url('public_pendaftaran/form') ?>" class="btn btn-primary" style="border-radius: 14px; font-weight: 700; padding: 0.8rem 1.8rem; box-shadow: 0 10px 20px rgba(13,110,253,.25); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 25px rgba(13,110,253,.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 20px rgba(13,110,253,.25)';">
                    <i class="bi bi-file-earmark-plus me-2"></i>Daftar Pengujian Baru
                </a>
            </div>
        </div>
        <div class="col-lg-6 animate-fade-up delay-1">
            <div class="card border-0" style="background: var(--glass); border: 1px solid rgba(255,255,255,0.8); backdrop-filter: blur(16px); border-radius: 28px; box-shadow: var(--shadow);">
                <div class="card-body p-5">
                    <h4 style="font-weight: 800; color: var(--ink); margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-signpost-split text-primary"></i> Alur Pelayanan
                    </h4>
                    
                    <div class="d-flex mb-4 align-items-start" style="position: relative;">
                        <div style="position: absolute; left: 24px; top: 40px; bottom: -20px; width: 2px; background: rgba(13,110,253,.15);"></div>
                        <div class="me-3">
                            <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, rgba(13,110,253,.15) 0%, rgba(13,110,253,.05) 100%); color: var(--brand); border: 1px solid rgba(13,110,253,.2); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; z-index: 2; position: relative;">1</div>
                        </div>
                        <div>
                            <h6 style="font-weight: 800; margin-bottom: 0.2rem; color: var(--ink);">Pendaftaran Online</h6>
                            <p class="text-muted small mb-0" style="line-height: 1.5;">Isi formulir pendaftaran dan kelengkapan identitas sampel melalui portal ini.</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4 align-items-start" style="position: relative;">
                        <div style="position: absolute; left: 24px; top: 40px; bottom: -20px; width: 2px; background: rgba(13,110,253,.15);"></div>
                        <div class="me-3">
                            <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, rgba(13,110,253,.15) 0%, rgba(13,110,253,.05) 100%); color: var(--brand); border: 1px solid rgba(13,110,253,.2); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; z-index: 2; position: relative;">2</div>
                        </div>
                        <div>
                            <h6 style="font-weight: 800; margin-bottom: 0.2rem; color: var(--ink);">Penyerahan Sampel</h6>
                            <p class="text-muted small mb-0" style="line-height: 1.5;">Bawa sampel fisik Anda ke laboratorium beserta cetakan bukti pendaftaran.</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4 align-items-start" style="position: relative;">
                        <div style="position: absolute; left: 24px; top: 40px; bottom: -20px; width: 2px; background: rgba(13,110,253,.15);"></div>
                        <div class="me-3">
                            <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, rgba(13,110,253,.15) 0%, rgba(13,110,253,.05) 100%); color: var(--brand); border: 1px solid rgba(13,110,253,.2); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; z-index: 2; position: relative;">3</div>
                        </div>
                        <div>
                            <h6 style="font-weight: 800; margin-bottom: 0.2rem; color: var(--ink);">Proses Pengujian</h6>
                            <p class="text-muted small mb-0" style="line-height: 1.5;">Sampel akan dikaji ulang dan diuji secara teliti oleh analis laboratorium kami.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, rgba(13,110,253,.15) 0%, rgba(13,110,253,.05) 100%); color: var(--brand); border: 1px solid rgba(13,110,253,.2); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; z-index: 2; position: relative;">4</div>
                        </div>
                        <div>
                            <h6 style="font-weight: 800; margin-bottom: 0.2rem; color: var(--ink);">Pengambilan Laporan</h6>
                            <p class="text-muted small mb-0" style="line-height: 1.5;">Laporan hasil uji akan diterbitkan setelah semua proses selesai. Anda akan dihubungi oleh petugas untuk pengambilan laporan.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <!-- Info Section -->
    <div class="row text-center mt-5">
        <div class="col-md-4 mb-4 animate-fade-up delay-2">
            <div class="p-4" style="background: var(--glass); border: 1px solid rgba(255,255,255,0.8); border-radius: 24px; height: 100%; box-shadow: var(--shadow2); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)';" onmouseout="this.style.transform='none';">
                <div style="width: 64px; height: 64px; border-radius: 18px; background: rgba(13,110,253,.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="bi bi-clock-history text-primary" style="font-size: 2rem;"></i>
                </div>
                <h5 class="mt-3" style="font-weight: 700;">Jam Operasional</h5>
                <p class="text-muted small mb-0">Senin - Jumat: 08.00 - 15.00 WIB<br>Sabtu - Minggu: Tutup</p>
            </div>
        </div>
        <div class="col-md-4 mb-4 animate-fade-up delay-3">
            <div class="p-4" style="background: var(--glass); border: 1px solid rgba(255,255,255,0.8); border-radius: 24px; height: 100%; box-shadow: var(--shadow2); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)';" onmouseout="this.style.transform='none';">
                <div style="width: 64px; height: 64px; border-radius: 18px; background: rgba(34,197,94,.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="bi bi-shield-check text-success" style="font-size: 2rem;"></i>
                </div>
                <h5 class="mt-3" style="font-weight: 700;">Terpercaya</h5>
                <p class="text-muted small mb-0">Pengujian dilakukan oleh analis profesional menggunakan standar operasional laboratorium.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4 animate-fade-up delay-4">
            <div class="p-4" style="background: var(--glass); border: 1px solid rgba(255,255,255,0.8); border-radius: 24px; height: 100%; box-shadow: var(--shadow2); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)';" onmouseout="this.style.transform='none';">
                <div style="width: 64px; height: 64px; border-radius: 18px; background: rgba(13,202,240,.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="bi bi-headset text-info" style="font-size: 2rem;"></i>
                </div>
                <h5 class="mt-3" style="font-weight: 700;">Layanan Bantuan</h5>
                <p class="text-muted small mb-0">Hubungi kami di (0717) 9120759 atau email ke upt-labkesehatan@pangkalpinangkota.go.id</p>
            </div>
        </div>
    </div>
</div>
