<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * View untuk input hasil pemeriksaan sampel
 * @var array $permintaan - Data permintaan sampel dengan fields: id, instansi, telp_pengirim, alamat_pengirim, lokasi_pengambilan, volume_ml
 * @var array $items - Array item/hasil pemeriksaan dengan fields: tgl_jam_pemeriksaan, tgl_jam_selesai, tgl_jam_lapor
 * @var array $petugas - Array petugas untuk dropdown
 */
?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <a class="btn btn-outline-secondary" href="<?= site_url('kesmas/uji') ?>"><i class="fa fa-arrow-left me-2"></i> Kembali</a>
    <h3 class="mb-0 text-center flex-grow-1">Input Hasil Pemeriksaan</h3>
    <div style="width: 100px;"></div> <!-- Spacer for alignment -->
</div>

<form method="post" action="<?= site_url('kesmas/form_permintaan_kesmas/simpan_hasil/'.$permintaan['id']) ?>" id="formInputHasil" novalidate>
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

    <div class="row">
        <!-- Card 1: IDENTITAS SAMPEL -->
        <div class="col-md-4">
            <div class="card mb-3 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Identitas Sampel</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label mb-0 fw-bold">No. Registrasi:</label>
                        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($permintaan['no_registrasi'] ?? '') ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label mb-0 fw-bold">Nama Sampel:</label>
                        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($permintaan['nama_sampel'] ?? '') ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label mb-0 fw-bold">Kategori Sampel:</label>
                        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($permintaan['kategori_sample'] ?? '-') ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label mb-0 fw-bold">Jenis Sampel:</label>
                        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($permintaan['jenis_sampel'] ?? '') ?>" readonly>
                    </div>
                    <div class="mb-0">
                        <label class="form-label mb-0 fw-bold">Tanggal Form:</label>
                        <input type="text" class="form-control form-control-sm" value="<?= !empty($permintaan['tgl_permintaan']) ? date('d-m-Y', strtotime($permintaan['tgl_permintaan'])) : '' ?>" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: IDENTITAS PENGIRIM -->
        <div class="col-md-4">
            <div class="card mb-3 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Identitas Pengirim</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label mb-0 fw-bold">Nama Pengirim:</label>
                        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($permintaan['nama_pengirim'] ?? '') ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label mb-0 fw-bold">Instansi:</label>
                        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($permintaan['instansi'] ?: '-') ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label mb-0 fw-bold">No. Telp:</label>
                        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($permintaan['telp_pengirim'] ?: '-') ?>" readonly>
                    </div>
                    <div class="mb-0">
                        <label class="form-label mb-0 fw-bold">Alamat:</label>
                        <textarea class="form-control form-control-sm" rows="3" readonly><?= htmlspecialchars($permintaan['alamat_pengirim'] ?: '-') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- CARD “DATA SAMPEL” (full width) -->
    <div class="card mb-3">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Data Sampel</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label class="form-label mb-0 fw-bold">Lokasi Pengambilan:</label>
                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($permintaan['lokasi_pengambilan'] ?: '-') ?>" readonly>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label mb-0 fw-bold">Tanggal Pengambilan:</label>
                    <input type="text" class="form-control form-control-sm" value="<?= (!empty($permintaan['tgl_pengambilan']) && !empty($permintaan['jam_pengambilan'])) ? date('d-m-Y H:i', strtotime($permintaan['tgl_pengambilan'] . ' ' . $permintaan['jam_pengambilan'])) . ' WIB' : '-' ?>" readonly>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label mb-0 fw-bold">Volume Sampel (mL):</label>
                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($permintaan['volume_ml'] ?: '-') ?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD “DAFTAR PEMERIKSAAN” (full width) -->
    <div class="card mb-3">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Daftar Pemeriksaan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama Pemeriksaan</th>
                            <th style="width: 20%;">Hasil</th>
                            <th style="width: 15%;">Satuan</th>
                            <th style="width: 15%;">Baku Mutu</th>
                            <th style="width: 25%;">Metode Pemeriksaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada item pemeriksaan dipilih</td></tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($items as $it): ?>
                                <?php $ket_class = ($it['keterangan'] === 'MS') ? 'table-success' : (($it['keterangan'] === 'TMS') ? 'table-danger' : ''); ?>
                                <tr class="<?= $ket_class ?>" data-permintaan-item-id="<?= (int)$it['permintaan_item_id'] ?>">
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars($it['nama_pemeriksaan']) ?></div>
                                    </td>
                                    <td>
                                        <input class="form-control form-control-sm" name="hasil[<?= (int)$it['permintaan_item_id'] ?>]" value="<?= htmlspecialchars($it['hasil'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>">
                                        <!-- Hidden input for keterangan as required by controller -->
                                        <input type="hidden" name="keterangan[<?= (int)$it['permintaan_item_id'] ?>]" value="<?= htmlspecialchars($it['keterangan'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($it['satuan'] ?? '-') ?>" readonly>
                                    </td>
                                    <td>
                                        <div class="default-baku fw-normal" data-default="<?= htmlspecialchars($it['baku_mutu'] ?? '') ?>"><?= htmlspecialchars($it['baku_mutu'] ?? '-') ?></div>
                                        <input type="text" class="form-control form-control-sm override-baku mt-1" value="<?= htmlspecialchars($it['baku_mutu'] ?? '') ?>" style="display:none;" placeholder="Masukkan baku mutu jika ingin override">
                                    </td>
                                    <td>
                                        <div class="default-metode fw-normal" data-default="<?= htmlspecialchars($it['metode'] ?? '') ?>"><?= htmlspecialchars($it['metode'] ?? '-') ?></div>
                                        <input type="text" class="form-control form-control-sm override-metode mt-1" value="<?= htmlspecialchars($it['metode'] ?? '') ?>" style="display:none;" placeholder="Masukkan metode jika ingin override">
                                        <div class="mt-1 btn-group btn-group-sm" role="group" aria-label="Override actions">
                                            <button type="button" class="btn btn-outline-secondary edit-override" title="Ubah"><i class="fa fa-pencil-alt"></i></button>
                                            <button type="button" class="btn btn-success save-override" title="Simpan" style="display:none"><i class="fa fa-check"></i></button>
                                            <button type="button" class="btn btn-danger cancel-override" title="Batal" style="display:none"><i class="fa fa-times"></i></button>
                                        </div>
                                        <div class="mt-1 btn-group btn-group-sm ms-2" role="group" aria-label="TMS actions">
                                            <button type="button" class="btn btn-outline-success btn-mark-ms" data-pid="<?= (int)$it['permintaan_item_id'] ?>">MS</button>
                                            <button type="button" class="btn btn-outline-danger btn-mark-tms" data-pid="<?= (int)$it['permintaan_item_id'] ?>">TMS</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Kondisi dan Kelayakan Sampel</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <label class="form-label mb-0 fw-bold">Kelayakan:</label>
                        <?php 
                            $sk = $permintaan['status_kelayakan'] ?? 'Belum Dinilai';
                            $badge_class = 'bg-secondary';
                            if ($sk === 'Layak') {
                                $badge_class = 'bg-success';
                            } elseif ($sk === 'Tidak Layak') {
                                $badge_class = 'bg-danger';
                            }
                        ?>
                        <input type="hidden" id="status_kelayakan_input_hasil_bottom" value="<?= htmlspecialchars($sk) ?>">
                        <div class="badge <?= $badge_class ?> fs-6" style="padding: 0.5em 0.7em; width: 100%; text-align: left;">
                            <?= htmlspecialchars($sk) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2" id="alasan_tidak_layak_container_bottom" style="display: <?= ($sk==='Tidak Layak') ? 'block' : 'none' ?>;">
                        <div class="alert alert-danger mb-2">
                            <strong>Sampel Tidak Layak</strong>
                            <div class="small text-muted">Sampel ini tidak memenuhi persyaratan pemeriksaan. Lihat alasan dan catatan di bawah.</div>
                        </div>
                        <label class="form-label mb-0 fw-bold">Alasan Tidak Layak:</label>
                        <?php
                            $selected_alasan = isset($permintaan['alasan_tidak_layak']) ? json_decode($permintaan['alasan_tidak_layak'], true) : [];
                            if (!is_array($selected_alasan)) {
                                $selected_alasan = [$selected_alasan];
                            }
                        ?>
                        <div class="d-flex flex-column gap-2 mt-1">
                            <?php if (empty($selected_alasan)): ?>
                                <div class="text-muted">-</div>
                            <?php else: ?>
                                <ul style="margin:0;padding-left:1.2rem;">
                                <?php foreach ($selected_alasan as $al): ?>
                                    <li><?= htmlspecialchars($al) ?></li>
                                <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label mb-1 fw-bold">Catatan Penolakan:</label>
                            <textarea class="form-control form-control-sm" rows="3" readonly><?= htmlspecialchars($permintaan['catatan'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Custom Round Checkbox Styling */
        .custom-round-checkbox {
            /* Hide default checkbox */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            /* Custom dimensions */
            width: 1.25em; /* Adjust size as needed */
            height: 1.25em; /* Adjust size as needed */
            border: 2px solid #ced4da; /* Default border color */
            border-radius: 50%; /* Make it round */
            vertical-align: middle;
            position: relative;
            cursor: pointer;
            outline: none;
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .custom-round-checkbox:checked {
            background-color: #0d6efd; /* Primary blue for checked state */
            border-color: #0d6efd; /* Primary blue border */
        }

        .custom-round-checkbox:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); /* Focus ring */
        }

        .custom-round-checkbox:checked::before {
            content: "";
            display: block;
            width: 0.6em; /* Size of the checkmark dot */
            height: 0.6em; /* Size of the checkmark dot */
            border-radius: 50%;
            background-color: #fff; /* White dot */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Adjust positioning for labels */
        .form-check-label {
            vertical-align: middle;
            margin-left: 0.5rem; /* Space between checkbox and label */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // This script section remains to handle the "alasan tidak layak" visibility
            const statusKelayakanValue = document.getElementById('status_kelayakan_input_hasil_bottom').value;
            const alasanTidakLayakContainerBottom = document.getElementById('alasan_tidak_layak_container_bottom');

            if (statusKelayakanValue === 'Tidak Layak') {
                alasanTidakLayakContainerBottom.style.display = 'block';
            } else {
                alasanTidakLayakContainerBottom.style.display = 'none';
            }

            // Compact inline editor for per-row baku_mutu / metode (front-end only)
            // Edit -> show two inputs and Save/Cancel
            document.querySelectorAll('tr[data-permintaan-item-id]').forEach(row => {
                const editBtn = row.querySelector('.edit-override');
                const saveBtn = row.querySelector('.save-override');
                const cancelBtn = row.querySelector('.cancel-override');
                const defaultBaku = row.querySelector('.default-baku');
                const defaultMetode = row.querySelector('.default-metode');
                const overrideBaku = row.querySelector('.override-baku');
                const overrideMetode = row.querySelector('.override-metode');

                function showEditor() {
                    if (overrideBaku) overrideBaku.style.display = '';
                    if (overrideMetode) overrideMetode.style.display = '';
                    if (defaultBaku) defaultBaku.style.display = 'none';
                    if (defaultMetode) defaultMetode.style.display = 'none';
                    if (editBtn) editBtn.style.display = 'none';
                    if (saveBtn) saveBtn.style.display = '';
                    if (cancelBtn) cancelBtn.style.display = '';
                }
                function hideEditor() {
                    if (overrideBaku) overrideBaku.style.display = 'none';
                    if (overrideMetode) overrideMetode.style.display = 'none';
                    if (defaultBaku) defaultBaku.style.display = '';
                    if (defaultMetode) defaultMetode.style.display = '';
                    if (editBtn) editBtn.style.display = '';
                    if (saveBtn) saveBtn.style.display = 'none';
                    if (cancelBtn) cancelBtn.style.display = 'none';
                }

                if (editBtn) editBtn.addEventListener('click', function(){
                    // prefill editor with current default text
                    if (overrideBaku && defaultBaku) overrideBaku.value = defaultBaku.textContent.trim() === '-' ? '' : defaultBaku.textContent.trim();
                    if (overrideMetode && defaultMetode) overrideMetode.value = defaultMetode.textContent.trim() === '-' ? '' : defaultMetode.textContent.trim();
                    showEditor();
                    if (overrideBaku) overrideBaku.focus();
                });

                if (saveBtn) saveBtn.addEventListener('click', function(){
                    // save values to inputs (collectOverrides will persist them)
                    collectOverrides();
                    // update visible defaults with override values if provided
                    if (overrideBaku && overrideBaku.value.trim() !== '') {
                        if (defaultBaku) defaultBaku.textContent = overrideBaku.value.trim();
                    }
                    if (overrideMetode && overrideMetode.value.trim() !== '') {
                        if (defaultMetode) defaultMetode.textContent = overrideMetode.value.trim();
                    }
                    hideEditor();
                });

                if (cancelBtn) cancelBtn.addEventListener('click', function(){
                    // revert editor inputs to previous saved values (applySavedOverrides handles this on load)
                    hideEditor();
                });

                // initial hide save/cancel
                if (saveBtn) saveBtn.style.display = 'none';
                if (cancelBtn) cancelBtn.style.display = 'none';
            });

            // Save overrides to localStorage (temporary, per-permintaan)
            function collectOverrides() {
                const permintaanId = <?= (int)$permintaan['id'] ?>;
                const overrides = {};
                document.querySelectorAll('tr[data-permintaan-item-id]').forEach(row => {
                    const pid = row.getAttribute('data-permintaan-item-id');
                    const overrideBaku = row.querySelector('.override-baku');
                    const overrideMetode = row.querySelector('.override-metode');
                    const obj = {};
                    if (overrideBaku && overrideBaku.value && overrideBaku.value.trim() !== '') obj.baku_mutu = overrideBaku.value.trim();
                    if (overrideMetode && overrideMetode.value && overrideMetode.value.trim() !== '') obj.metode = overrideMetode.value.trim();
                    if (Object.keys(obj).length > 0) overrides[pid] = obj;
                });
                if (Object.keys(overrides).length > 0) {
                    localStorage.setItem('permintaan_overrides_' + permintaanId, JSON.stringify(overrides));
                } else {
                    localStorage.removeItem('permintaan_overrides_' + permintaanId);
                }
            }

            // Save overrides before submitting the form
            const formEl = document.querySelector('form[action$="/simpan_hasil/<?= (int)$permintaan['id'] ?>"]');
            if (formEl) {
                formEl.addEventListener('submit', function(){ collectOverrides(); });
            }

            // Apply saved overrides from localStorage (if any) when loading this page
            try {
                const permintaanId = <?= (int)$permintaan['id'] ?>;
                const key = 'permintaan_overrides_' + permintaanId;
                const rawSaved = localStorage.getItem(key);
                if (rawSaved) {
                    const saved = JSON.parse(rawSaved || '{}');
                    Object.keys(saved).forEach(pid => {
                        const row = document.querySelector('tr[data-permintaan-item-id="' + pid + '"]');
                        if (!row) return;
                        const obj = saved[pid] || {};
                        if (obj.baku_mutu) {
                            const ov = row.querySelector('.override-baku');
                            const defaultBaku = row.querySelector('.default-baku');
                            if (ov) ov.value = obj.baku_mutu;
                            if (defaultBaku) defaultBaku.textContent = obj.baku_mutu;
                        }
                        if (obj.metode) {
                            const ovm = row.querySelector('.override-metode');
                            const defaultMetode = row.querySelector('.default-metode');
                            if (ovm) ovm.value = obj.metode;
                            if (defaultMetode) defaultMetode.textContent = obj.metode;
                        }
                    });
                    // applied saved overrides
                }
            } catch (err) {
                // ignore
            }

            // Save overrides when clicking the "Lihat Detail Laporan" button
            const viewBtn = document.getElementById('view_report_btn');
            if (viewBtn) {
                viewBtn.addEventListener('click', function(e){
                    collectOverrides();
                    // allow navigation
                });
            }

            // Attach MS/TMS handlers in input_hasil view (include CSRF token)
            var _csrfName = '<?= $this->security->get_csrf_token_name() ?>';
            var _csrfHash = '<?= $this->security->get_csrf_hash() ?>';

            function postStatusInput(pid, status) {
                // Segera update tampilan baris dan input tersembunyi tanpa menunggu AJAX
                // sehingga saat tombol "Simpan Hasil" diklik, nilai status pasti terkirim.
                const row = document.querySelector('tr[data-permintaan-item-id="' + pid + '"]');
                if (row) {
                    row.classList.remove('table-success','table-danger');
                    if (status === 'MS') row.classList.add('table-success');
                    if (status === 'TMS') row.classList.add('table-danger');
                    const hidden = row.querySelector('input[type="hidden"][name^="keterangan"]');
                    if (hidden) hidden.value = status;
                }

                var body = 'permintaan_item_id=' + encodeURIComponent(pid) + '&status=' + encodeURIComponent(status);
                body += '&' + encodeURIComponent(_csrfName) + '=' + encodeURIComponent(_csrfHash);
                fetch('<?= site_url('kesmas/laporan_uji_kesmas/set_status') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: body
                }).then(r => r.json()).then(js => {
                    // update CSRF hash if returned
                    try { 
                        if (js && js[_csrfName]) {
                            _csrfHash = js[_csrfName]; 
                            document.querySelectorAll('input[name="'+_csrfName+'"]').forEach(inp => inp.value = _csrfHash);
                        } 
                    } catch (e){ console.log(e); }
                }).catch((e) => console.log('AJAX save failed, fallback to Form Submit.', e));
            }

            document.querySelectorAll('.btn-mark-ms').forEach(b => b.addEventListener('click', function(e){
                const pid = this.getAttribute('data-pid');
                postStatusInput(pid, 'MS');
            }));
            document.querySelectorAll('.btn-mark-tms').forEach(b => b.addEventListener('click', function(e){
                const pid = this.getAttribute('data-pid');
                postStatusInput(pid, 'TMS');
            }));

            // No auto-uncheck needed in compact editor UI
        });
    </script>

    <!-- CARD “INFORMASI PENGAMBILAN & PEMERIKSAAN” -->
    <div class="card mb-3">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Informasi Pengambilan & Pemeriksaan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label mb-0 fw-bold">Petugas Pengambilan Spesimen:</label>
                        <select class="form-select form-select-sm" disabled>
                            <option value="">- Pilih Petugas -</option>
                            <?php foreach ($petugas as $p): ?>
                                <option value="<?= (int)$p['id'] ?>" <?= ((string)($permintaan['petugas_pengambil_id'] ?? '') === (string)$p['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="petugas_pengambilan_spesimen_id" value="<?= htmlspecialchars($permintaan['petugas_pengambil_id'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label mb-0 fw-bold">Tanggal/Jam Pengambilan (Waktu Sampel diambil):</label>
                        <input class="form-control form-control-sm" type="datetime-local" value="<?= (!empty($permintaan['tgl_pengambilan']) && !empty($permintaan['jam_pengambilan'])) ? date('Y-m-d\TH:i', strtotime($permintaan['tgl_pengambilan'] . ' ' . $permintaan['jam_pengambilan'])) : '' ?>" readonly>
                    </div>
                    <div class="mb-0">
                        <label class="form-label mb-0 fw-bold">Tanggal/Jam Pemeriksaan (Waktu mulai pemeriksaan):</label>
                        <?php
                            $tgl_jam_pemeriksaan_val = null;
                            if(!empty($permintaan['tgl_jam_pemeriksaan'])) { // Check if directly in permintaan
                                $tgl_jam_pemeriksaan_val = $permintaan['tgl_jam_pemeriksaan'];
                            } else { // Fallback to first item
                                foreach($items as $it){ if(!empty($it['tgl_jam_pemeriksaan'])){ $tgl_jam_pemeriksaan_val=$it['tgl_jam_pemeriksaan']; break; } }
                            }
                        ?>
                        <input class="form-control form-control-sm" type="datetime-local" name="tgl_jam_pemeriksaan"
                               value="<?= $tgl_jam_pemeriksaan_val ? date('Y-m-d\TH:i', strtotime($tgl_jam_pemeriksaan_val)) : '' ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label mb-0 fw-bold">Tanggal/Jam Selesai Pemeriksaan:</label>
                        <?php
                            $tgl_jam_selesai_val = null;
                            if(!empty($permintaan['tgl_jam_selesai'])) {
                                $tgl_jam_selesai_val = $permintaan['tgl_jam_selesai'];
                            }
                            else {
                                foreach($items as $it){ if(!empty($it['tgl_jam_selesai'])){ $tgl_jam_selesai_val=$it['tgl_jam_selesai']; break; } }
                            }
                        ?>
                        <input class="form-control form-control-sm" type="datetime-local" name="tgl_jam_selesai"
                               value="<?= $tgl_jam_selesai_val ? date('Y-m-d\TH:i', strtotime($tgl_jam_selesai_val)) : '' ?>">
                    </div>
                    <div class="mb-0">
                        <label class="form-label mb-0 fw-bold">Tanggal/Jam Pelaporan Hasil:</label>
                        <?php
                            $tgl_jam_lapor_val = null;
                            if(!empty($permintaan['tgl_jam_lapor'])) {
                                $tgl_jam_lapor_val = $permintaan['tgl_jam_lapor'];
                            }
                            else {
                                foreach($items as $it){ if(!empty($it['tgl_jam_lapor'])){ $tgl_jam_lapor_val=$it['tgl_jam_lapor']; break; } }
                            }
                        ?>
                        <input class="form-control form-control-sm" type="datetime-local" name="tgl_jam_lapor"
                               value="<?= $tgl_jam_lapor_val ? date('Y-m-d\TH:i', strtotime($tgl_jam_lapor_val)) : '' ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between mt-4 mb-4">
        <a href="<?= site_url('kesmas/uji') ?>" class="btn btn-secondary"><i class="fa fa-arrow-left me-2"></i> Kembali</a>
        <div>
            <button id="save_hasil_btn" type="button" class="btn btn-primary" onclick="this.innerHTML='<i class=\'fa fa-hourglass-split me-2\'></i> Menyimpan...'; this.style.pointerEvents='none'; document.getElementById('formInputHasil').submit();"><i class="fa fa-save me-2"></i> Simpan Hasil</button>
            <a id="view_report_btn" href="<?= site_url('kesmas/laporan_uji_kesmas/detail/'.$permintaan['id']) ?>" class="btn btn-success ms-2"><i class="fa fa-file-alt me-2"></i> Lihat Detail Laporan</a>
        </div>
    </div>
</form>