<div class="container my-4">
    <h2><?php echo $title; ?></h2>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo base_url('kesmas/survei/update/' . $item['id']); ?>" method="POST">
                
                <div class="form-group">
                    <label><strong>Permintaan ID:</strong> <?php echo $item['permintaan_id']; ?></label>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Skor Pelayanan (1-5) *</label>
                        <select name="skor_pelayanan" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="1" <?php echo $item['skor_pelayanan'] == 1 ? 'selected' : ''; ?>>1 ⭐</option>
                            <option value="2" <?php echo $item['skor_pelayanan'] == 2 ? 'selected' : ''; ?>>2 ⭐⭐</option>
                            <option value="3" <?php echo $item['skor_pelayanan'] == 3 ? 'selected' : ''; ?>>3 ⭐⭐⭐</option>
                            <option value="4" <?php echo $item['skor_pelayanan'] == 4 ? 'selected' : ''; ?>>4 ⭐⭐⭐⭐</option>
                            <option value="5" <?php echo $item['skor_pelayanan'] == 5 ? 'selected' : ''; ?>>5 ⭐⭐⭐⭐⭐</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Skor Fasilitas (1-5) *</label>
                        <select name="skor_fasilitas" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="1" <?php echo $item['skor_fasilitas'] == 1 ? 'selected' : ''; ?>>1 ⭐</option>
                            <option value="2" <?php echo $item['skor_fasilitas'] == 2 ? 'selected' : ''; ?>>2 ⭐⭐</option>
                            <option value="3" <?php echo $item['skor_fasilitas'] == 3 ? 'selected' : ''; ?>>3 ⭐⭐⭐</option>
                            <option value="4" <?php echo $item['skor_fasilitas'] == 4 ? 'selected' : ''; ?>>4 ⭐⭐⭐⭐</option>
                            <option value="5" <?php echo $item['skor_fasilitas'] == 5 ? 'selected' : ''; ?>>5 ⭐⭐⭐⭐⭐</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Komentar / Saran</label>
                    <textarea name="komentar_saran" class="form-control" rows="4"><?php echo $item['komentar_saran'] ?? ''; ?></textarea>
                </div>

                <hr>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="<?php echo base_url('kesmas/survei'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
