<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="mb-0 fw-bold">KUESIONER SURVEI KEPUASAN MASYARAKAT (SKM)</h4>
                    <p class="mb-0 text-white-50">PADA UNIT LAYANAN UPTD. LABORATORIUM KESEHATAN KOTA PANGKALPINANG</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form id="survei-form">
                        <input type="hidden" name="permintaan_id" value="<?= isset($permintaan_id) ? htmlspecialchars($permintaan_id) : 0 ?>">
                        
                        <h5 class="border-bottom pb-2 mb-4 text-primary fw-bold">I. PROFIL RESPONDEN</h5>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal Survei <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light" value="<?= date('d M Y') ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jam Survei <span class="text-danger">*</span></label>
                                <select class="form-select form-control" name="jam_survei" required>
                                    <option value="">-- Pilih Jam --</option>
                                    <option value="08.00 - 12.00">08.00 - 12.00</option>
                                    <option value="13.00 - 15.00">13.00 - 15.00</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select form-control" name="jenis_kelamin" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L">Laki-laki (L)</option>
                                    <option value="P">Perempuan (P)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Usia (Tahun) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="usia" placeholder="Misal: 30" required min="10" max="100">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Pendidikan <span class="text-danger">*</span></label>
                                <select class="form-select form-control" name="pendidikan" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Pekerjaan <span class="text-danger">*</span></label>
                                <select class="form-select form-control" name="pekerjaan" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="PNS">PNS</option>
                                    <option value="TNI">TNI</option>
                                    <option value="POLRI">POLRI</option>
                                    <option value="SWASTA">SWASTA</option>
                                    <option value="WIRAUSAHA">WIRAUSAHA</option>
                                    <option value="LAINNYA">LAINNYA</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jenis Layanan yang diterima <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jenis_layanan" placeholder="Misal: KTP, Akta, Sertifikat, Poli Umum, Uji Lab, dll" required>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-4 mt-5 text-primary fw-bold">II. PENDAPAT RESPONDEN TENTANG LAYANAN</h5>
                        <p class="text-muted mb-4">Silakan pilih jawaban yang paling sesuai dengan pendapat Anda.</p>

                        <?php
                        $questions = [
                            ['q' => 'q1', 'text' => '1. Bagaimana pendapat Saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya?', 'opts' => ['Tidak sesuai', 'Kurang sesuai', 'Sesuai', 'Sangat sesuai']],
                            ['q' => 'q2', 'text' => '2. Bagaimana pemahaman Saudara tentang kemudahan prosedur pelayanan di unit ini?', 'opts' => ['Tidak mudah', 'Kurang mudah', 'Mudah', 'Sangat mudah']],
                            ['q' => 'q3', 'text' => '3. Bagaimana pendapat Saudara tentang kecepatan waktu dalam memberikan pelayanan?', 'opts' => ['Tidak cepat', 'Kurang cepat', 'Cepat', 'Sangat cepat']],
                            ['q' => 'q4', 'text' => '4. Bagaimana pendapat Saudara tentang kewajaran biaya/tarif dalam pelayanan?', 'opts' => ['Sangat mahal', 'Cukup mahal', 'Murah', 'Gratis']],
                            ['q' => 'q5', 'text' => '5. Bagaimana pendapat Saudara tentang kesesuaian produk pelayanan antara yang tercantum dalam standar pelayanan dengan hasil yang diberikan?', 'opts' => ['Tidak sesuai', 'Kurang sesuai', 'Sesuai', 'Sangat sesuai']],
                            ['q' => 'q6', 'text' => '6. Bagaimana pendapat Saudara tentang kompetensi/kemampuan petugas dalam pelayanan?', 'opts' => ['Tidak kompeten', 'Kurang kompeten', 'Kompeten', 'Sangat kompeten']],
                            ['q' => 'q7', 'text' => '7. Bagaimana pendapat Saudara perilaku petugas dalam pelayanan terkait kesopanan dan keramahan?', 'opts' => ['Tidak sopan dan ramah', 'Kurang sopan dan ramah', 'Sopan dan ramah', 'Sangat sopan dan ramah']],
                            ['q' => 'q8', 'text' => '8. Bagaimana pendapat Saudara tentang kualitas sarana dan prasarana?', 'opts' => ['Buruk', 'Cukup', 'Baik', 'Sangat baik']],
                            ['q' => 'q9', 'text' => '9. Bagaimana pendapat Saudara tentang penanganan pengaduan pengguna layanan?', 'opts' => ['Tidak ada', 'Ada tetapi tidak berfungsi', 'Berfungsi kurang maksimal', 'Dikelola dengan baik']],
                        ];
                        ?>

                        <div class="row">
                        <?php foreach($questions as $index => $q): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-0 bg-light shadow-sm">
                                    <div class="card-body">
                                        <p class="fw-bold mb-3"><?= $q['text'] ?></p>
                                        <?php foreach($q['opts'] as $val_idx => $opt): 
                                            $val = $val_idx + 1;
                                            $id = $q['q'] . '_' . $val;
                                        ?>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="<?= $q['q'] ?>" id="<?= $id ?>" value="<?= $val ?>" required>
                                            <label class="form-check-label" for="<?= $id ?>" style="cursor: pointer;">
                                                <?= chr(97 + $val_idx) ?>. <?= $opt ?>
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>

                        <h5 class="border-bottom pb-2 mb-4 mt-4 text-primary fw-bold">III. SARAN & MASUKAN</h5>
                        <div class="form-group mb-4">
                            <textarea name="komentar_saran" class="form-control" rows="4" placeholder="Tuliskan saran atau masukan Anda untuk peningkatan layanan kami..."></textarea>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow" id="btn-submit" style="border-radius: 30px;">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Survei
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#survei-form').submit(function(e) {
        e.preventDefault();
        
        let btn = $('#btn-submit');
        let originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...').prop('disabled', true);

        $.ajax({
            url: '<?php echo base_url('kesmas/survei/store'); ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.href = '<?php echo base_url('kesmas/survei/view/'); ?>' + response.id;
                } else {
                    alert('Error: ' + response.message);
                    btn.html(originalText).prop('disabled', false);
                }
            },
            error: function() {
                alert('Terjadi kesalahan sistem saat mengirim survei.');
                btn.html(originalText).prop('disabled', false);
            }
        });
    });
});
</script>
