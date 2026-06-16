<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!isset($grouped_rows) || !is_array($grouped_rows)) $grouped_rows = [];
if (!isset($bulan)) $bulan = date('Y-m');

// Detect whether the provided data is grouped by month (keys like YYYY-MM)
$month_grouped = false;
foreach ($grouped_rows as $k => $v) {
    if (is_string($k) && preg_match('/^\d{4}-\d{2}$/', $k)) { $month_grouped = true; break; }
}
// Read current GET values for the filter form
$q_val = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';
$dari_val = isset($_GET['dari']) ? htmlspecialchars($_GET['dari']) : '';
$sampai_val = isset($_GET['sampai']) ? htmlspecialchars($_GET['sampai']) : '';

// Build current page URL for form action
$current_action = site_url('kesmas/laporan_uji_kesmas/parameter');
?>

<div class="report-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Laporan Parameter</h3>
            <div class="small-muted">Ringkasan MS / TMS per parameter</div>
        </div>
        <div>
            <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="fa fa-download"></i> Export CSV</a>
            <a href="#" class="btn btn-outline-secondary btn-sm"><i class="fa fa-file-pdf"></i> Export PDF</a>
        </div>
    </div>

    <form method="get" action="<?= $current_action ?>" class="row g-2 mb-3 align-items-end">
    <div class="col-auto">
        <label class="form-label small">Cari Parameter</label>
        <input type="text" name="q" value="<?= $q_val ?>" class="form-control form-control-sm" placeholder="Nama pemeriksaan...">
    </div>
    <div class="col-auto">
        <label class="form-label small">Dari (bulan)</label>
        <input type="month" name="dari" value="<?= $dari_val ?>" class="form-control form-control-sm">
    </div>
    <div class="col-auto">
        <label class="form-label small">Sampai (bulan)</label>
        <input type="month" name="sampai" value="<?= $sampai_val ?>" class="form-control form-control-sm">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>
        <a href="<?= $current_action ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
    </div>
</form>

<!-- Modern UI styles for laporan parameter -->
<style>
:root{--accent:#4f46e5;--accent-2:#06b6d4;--ms:#16a34a;--tms:#dc2626;--muted:#6b7280}
.modern-summary{border-radius:12px;padding:18px;color:#2d3748;background:linear-gradient(135deg,var(--accent),#7c3aed);box-shadow:0 6px 18px rgba(15,23,42,0.08)}
.summary-row .card{border-radius:12px}
.summary-value{font-size:28px;font-weight:700}
.parameter-card{border-radius:10px;box-shadow:0 6px 14px rgba(15,23,42,0.04);overflow:hidden;border:1px solid rgba(15,23,42,0.04)}
.parameter-card .card-header{background:linear-gradient(90deg,rgba(15,23,42,0.02),transparent);display:flex;align-items:center;justify-content:space-between;padding:12px 16px}
.parameter-card .parameter-title{font-weight:700;margin:0}
.badge-ms{background:var(--ms);color:#fff}
.badge-tms{background:var(--tms);color:#fff}
.progress-bar-track{height:8px;background:#f3f4f6;border-radius:999px;overflow:hidden;width:140px}
.progress-bar-fill{height:100%;background:linear-gradient(90deg,var(--accent-2),var(--accent));width:0%;transition:width 800ms cubic-bezier(.2,.9,.3,1)}
.month-section{margin-top:18px}
.month-title{font-size:1.05rem;font-weight:700;margin-bottom:10px}
.small-muted{color:var(--muted);font-size:0.9rem}
.parameter-link{color:inherit}

@media (max-width:768px){.progress-bar-track{width:100px}}

.report-container{max-width:1200px;margin:0 auto}
.card-table thead th{position:sticky;top:0;background:#fff;z-index:2}
.parameter-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:12px}
.parameter-card .accordion-body{background:#fff}
.modal-lg{max-width:900px}
</style>

<?php
if ($month_grouped):
    // If grouped by month, render each month's section separately
    $all_empty = true;
    foreach ($grouped_rows as $m => $groups) { if (!empty($groups)) { $all_empty = false; break; } }
    if ($all_empty):
?>
    <div class="text-center py-5">
        <i class="fa fa-info-circle fa-3x text-primary mb-3"></i>
        <h5>Data Tidak Ditemukan</h5>
        <p class="text-muted">Belum ada data hasil untuk bulan <strong><?= htmlspecialchars($bulan) ?></strong>.</p>
    </div>
<?php
    else:
        foreach ($grouped_rows as $month => $groups):
            if (empty($groups)) continue;
            // calculate totals for this month
            $grand_total_tested = 0;
            $grand_total_ms = 0;
            $grand_total_tms = 0;
            foreach ($groups as $group) {
                foreach ($group['sampel_sumber'] as $item) {
                    $grand_total_tested += $item['total_tested'];
                    $grand_total_ms += $item['ms_count'];
                    $grand_total_tms += $item['tms_count'];
                }
            }
            $accordion_id = 'laporanAccordion-' . str_replace('-', '_', $month);
?>
    <h4 class="mt-3 mb-2">Bulan: <?= htmlspecialchars($month) ?></h4>
    <div class="row mb-4 text-center summary-row">
        <div class="col-md-4 mb-2">
            <div class="card modern-summary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-start">
                            <div class="small-muted">Total Pengujian</div>
                            <div class="summary-value"><?= $grand_total_tested ?></div>
                        </div>
                        <div><i class="fa fa-vials fa-2x" style="opacity:.9"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <a href="javascript:void(0)" onclick="showSamples(0, 'Semua Parameter', '<?= htmlspecialchars($month) ?>', 'MS', '<?= htmlspecialchars($q_val) ?>')" style="text-decoration:none; display:block;">
                <div class="card" style="border-radius:12px;padding:14px;background:#ecfdf5; transition: transform 0.2s;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-start">
                            <div class="small-muted text-dark">Memenuhi Syarat (MS)</div>
                            <div class="summary-value text-success"><?= $grand_total_ms ?></div>
                        </div>
                        <div><i class="fa fa-check-circle fa-2x text-success" style="opacity:.95"></i></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-2">
            <a href="javascript:void(0)" onclick="showSamples(0, 'Semua Parameter', '<?= htmlspecialchars($month) ?>', 'TMS', '<?= htmlspecialchars($q_val) ?>')" style="text-decoration:none; display:block;">
                <div class="card" style="border-radius:12px;padding:14px;background:#fff7f7; transition: transform 0.2s;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-start">
                            <div class="small-muted text-dark">Tidak Memenuhi Syarat (TMS)</div>
                            <div class="summary-value text-danger"><?= $grand_total_tms ?></div>
                        </div>
                        <div><i class="fa fa-times-circle fa-2x text-danger" style="opacity:.95"></i></div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="accordion" id="<?= $accordion_id ?>">
    <div class="parameter-grid">
    <?php $i = 0; foreach ($groups as $group): $i++; ?>
        <?php
            $total_group_tests = ($group['total_ms'] ?? 0) + ($group['total_tms'] ?? 0);
            $ms_percentage = $total_group_tests > 0 ? (($group['total_ms'] ?? 0) / $total_group_tests) * 100 : 0;
            $safe_month = str_replace('-', '_', $month);
        ?>
        <div class="accordion-item mb-2 parameter-card">
            <h2 class="accordion-header" id="heading-<?= $safe_month ?>-<?= $i ?>">
                <button class="accordion-button collapsed d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $safe_month ?>-<?= $i ?>" aria-expanded="false" aria-controls="collapse-<?= $safe_month ?>-<?= $i ?>">
                    <div style="display:flex;gap:12px;align-items:center;width:100%">
                        <div class="flex-grow-1 text-start">
                            <a href="#" class="parameter-link" data-master-id="<?= (int)($group['master_id'] ?? 0) ?>" data-bulan="<?= htmlspecialchars($month) ?>" style="text-decoration:none;color:inherit"><h5 class="parameter-title mb-0"><?= htmlspecialchars($group['nama_pemeriksaan']) ?></h5></a>
                            <div class="small-muted">Satuan: <?= htmlspecialchars($group['satuan'] ?: '-') ?> &middot; Baku: <?= htmlspecialchars($group['baku_mutu'] ?: '-') ?></div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-ms me-1 px-2 py-1"><?= (int)($group['total_ms'] ?? 0) ?> MS</span>
                            <span class="badge badge-tms me-2 px-2 py-1"><?= (int)($group['total_tms'] ?? 0) ?> TMS</span>
                            <div class="progress-bar-track" title="<?= round($ms_percentage) ?>% MS"><div class="progress-bar-fill" data-percent="<?= $ms_percentage ?>"></div></div>
                        </div>
                    </div>
                </button>
            </h2>
            <div id="collapse-<?= $safe_month ?>-<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $safe_month ?>-<?= $i ?>" data-bs-parent="#<?= $accordion_id ?>">
                <div class="accordion-body">
                    <p class="mb-2">
                        <small class="text-muted">
                            <strong>Satuan:</strong> <?= htmlspecialchars($group['satuan'] ?: '-') ?> &nbsp;&nbsp;&middot;&nbsp;&nbsp; 
                            <strong>Baku Mutu:</strong> <?= htmlspecialchars($group['baku_mutu'] ?: '-') ?>
                        </small>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sumber Sampel</th>
                                    <th class="text-center">Total Diuji</th>
                                    <th class="text-center">MS</th>
                                    <th class="text-center">TMS</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($group['sampel_sumber'] as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['jenis_sampel']) ?></td>
                                    <td class="text-center"><?= (int)($item['total_tested'] ?? 0) ?></td>
                                    <td class="text-center fw-bold">
                                        <?php if(($item['ms_count'] ?? 0) > 0): ?>
                                            <a href="javascript:void(0)" onclick="showSamples(<?= (int)($group['master_id'] ?? 0) ?>, '<?= htmlspecialchars(addslashes($group['nama_pemeriksaan'])) ?>', '<?= htmlspecialchars($month) ?>', 'MS')" class="text-success text-decoration-underline"><?= (int)$item['ms_count'] ?></a>
                                        <?php else: ?>
                                            <span class="text-muted">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center fw-bold">
                                        <?php if(($item['tms_count'] ?? 0) > 0): ?>
                                            <a href="javascript:void(0)" onclick="showSamples(<?= (int)($group['master_id'] ?? 0) ?>, '<?= htmlspecialchars(addslashes($group['nama_pemeriksaan'])) ?>', '<?= htmlspecialchars($month) ?>', 'TMS')" class="text-danger text-decoration-underline"><?= (int)$item['tms_count'] ?></a>
                                        <?php else: ?>
                                            <span class="text-muted">0</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
    </div>
    <?php
        endforeach; // months
    endif;
else:
    // Not grouped by month: compute totals across provided groups and render as before
    $grand_total_tested = 0;
    $grand_total_ms = 0;
    $grand_total_tms = 0;
    foreach ($grouped_rows as $group) {
        foreach ($group['sampel_sumber'] as $item) {
            $grand_total_tested += $item['total_tested'];
            $grand_total_ms += $item['ms_count'];
            $grand_total_tms += $item['tms_count'];
        }
    }
?>
    <div class="row mb-4 text-center">
        <div class="col-md-4">
            <div class="summary-box bg-total">
                <h3><?= $grand_total_tested ?></h3>
                <p><i class="fa fa-vials"></i> Total Pengujian</p>
            </div>
        </div>
        <div class="col-md-4">
            <a href="javascript:void(0)" onclick="showSamples(0, 'Semua Parameter', '<?= htmlspecialchars($bulan) ?>', 'MS', '<?= htmlspecialchars($q_val) ?>')" style="text-decoration:none; display:block;">
                <div class="summary-box bg-ms" style="transition: transform 0.2s;">
                    <h3 class="text-dark"><?= $grand_total_ms ?></h3>
                    <p class="text-dark"><i class="fa fa-check-circle text-success"></i> Memenuhi Syarat (MS)</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="javascript:void(0)" onclick="showSamples(0, 'Semua Parameter', '<?= htmlspecialchars($bulan) ?>', 'TMS', '<?= htmlspecialchars($q_val) ?>')" style="text-decoration:none; display:block;">
                <div class="summary-box bg-tms" style="transition: transform 0.2s;">
                    <h3 class="text-dark"><?= $grand_total_tms ?></h3>
                    <p class="text-dark"><i class="fa fa-times-circle text-danger"></i> Tidak Memenuhi Syarat (TMS)</p>
                </div>
            </a>
        </div>
    </div>

    <div class="accordion" id="laporanAccordion">
    <?php $i = 0; foreach ($grouped_rows as $group): $i++; ?>
        <?php
            $total_group_tests = ($group['total_ms'] ?? 0) + ($group['total_tms'] ?? 0);
            $ms_percentage = $total_group_tests > 0 ? (($group['total_ms'] ?? 0) / $total_group_tests) * 100 : 0;
        ?>
        <div class="accordion-item mb-2 parameter-card">
            <h2 class="accordion-header" id="heading-<?= $i ?>">
                <button class="accordion-button collapsed d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $i ?>" aria-expanded="false" aria-controls="collapse-<?= $i ?>">
                    <div style="display:flex;gap:12px;align-items:center;width:100%">
                        <div class="flex-grow-1 text-start">
                            <a href="#" class="parameter-link" data-master-id="<?= (int)($group['master_id'] ?? 0) ?>" style="text-decoration:none;color:inherit"><h5 class="parameter-title mb-0"><?= htmlspecialchars($group['nama_pemeriksaan']) ?></h5></a>
                            <div class="small-muted">Satuan: <?= htmlspecialchars($group['satuan'] ?: '-') ?> &middot; Baku: <?= htmlspecialchars($group['baku_mutu'] ?: '-') ?></div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-ms me-1 px-2 py-1"><?= (int)($group['total_ms'] ?? 0) ?> MS</span>
                            <span class="badge badge-tms me-2 px-2 py-1"><?= (int)($group['total_tms'] ?? 0) ?> TMS</span>
                            <div class="progress-bar-track" title="<?= round($ms_percentage) ?>% MS"><div class="progress-bar-fill" data-percent="<?= $ms_percentage ?>"></div></div>
                        </div>
                    </div>
                </button>
            </h2>
            <div id="collapse-<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $i ?>" data-bs-parent="#laporanAccordion">
                <div class="accordion-body">
                    <p class="mb-2">
                        <small class="text-muted">
                            <strong>Satuan:</strong> <?= htmlspecialchars($group['satuan'] ?: '-') ?> &nbsp;&nbsp;&middot;&nbsp;&nbsp; 
                            <strong>Baku Mutu:</strong> <?= htmlspecialchars($group['baku_mutu'] ?: '-') ?>
                        </small>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sumber Sampel</th>
                                    <th class="text-center">Total Diuji</th>
                                    <th class="text-center">MS</th>
                                    <th class="text-center">TMS</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($group['sampel_sumber'] as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['jenis_sampel']) ?></td>
                                    <td class="text-center"><?= (int)($item['total_tested'] ?? 0) ?></td>
                                    <td class="text-center fw-bold">
                                        <?php if(($item['ms_count'] ?? 0) > 0): ?>
                                            <a href="javascript:void(0)" onclick="showSamples(<?= (int)($group['master_id'] ?? 0) ?>, '<?= htmlspecialchars(addslashes($group['nama_pemeriksaan'])) ?>', '<?= htmlspecialchars($bulan) ?>', 'MS')" class="text-success text-decoration-underline"><?= (int)$item['ms_count'] ?></a>
                                        <?php else: ?>
                                            <span class="text-muted">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center fw-bold">
                                        <?php if(($item['tms_count'] ?? 0) > 0): ?>
                                            <a href="javascript:void(0)" onclick="showSamples(<?= (int)($group['master_id'] ?? 0) ?>, '<?= htmlspecialchars(addslashes($group['nama_pemeriksaan'])) ?>', '<?= htmlspecialchars($bulan) ?>', 'TMS')" class="text-danger text-decoration-underline"><?= (int)$item['tms_count'] ?></a>
                                        <?php else: ?>
                                            <span class="text-muted">0</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Modal: daftar sampel per parameter -->
<div class="modal fade" id="parameterSamplesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold" id="parameterSamplesModalLabel">Daftar Sampel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="p-3 bg-white border-bottom">
                    <p id="parameterSamplesTitle" class="mb-0 text-muted"></p>
                </div>
                <div id="parameterSamplesList" class="p-3">Memuat...</div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentMasterId = 0;
let currentNama = '';
let currentBulan = '';
let currentStatus = '';
let currentQuery = '';

function showSamples(masterId, nama, bulan, status, query) {
    currentMasterId = masterId;
    currentNama = nama;
    currentBulan = bulan;
    currentStatus = status || '';
    currentQuery = query || '';

    let badge = '';
    if (status === 'MS') badge = '<span class="badge bg-success ms-2">MS</span>';
    else if (status === 'TMS') badge = '<span class="badge bg-danger ms-2">TMS</span>';

    document.getElementById('parameterSamplesModalLabel').innerHTML = 'Daftar Sampel ' + badge;
    document.getElementById('parameterSamplesTitle').innerHTML = '<i class="bi bi-info-circle me-1"></i> <strong>' + nama + '</strong> &mdash; Periode: ' + bulan;
    document.getElementById('parameterSamplesList').innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><div class="mt-2 text-muted">Memuat data...</div></div>';
    
    var modal = new bootstrap.Modal(document.getElementById('parameterSamplesModal'));
    modal.show();

    fetchSamplesPage(1);
}

function fetchSamplesPage(page) {
    let per_page = 50;
    var url = '<?= site_url('kesmas/laporan_uji_kesmas/parameter_samples') ?>' + 
              '?master_id=' + encodeURIComponent(currentMasterId) + 
              '&bulan=' + encodeURIComponent(currentBulan) + 
              '&status=' + encodeURIComponent(currentStatus) + 
              '&q=' + encodeURIComponent(currentQuery) + 
              '&page=' + page + 
              '&per_page=' + per_page;

    document.getElementById('parameterSamplesList').innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><div class="mt-2 text-muted">Memuat halaman ' + page + '...</div></div>';

    fetch(url, {credentials: 'same-origin'})
        .then(function(r){ return r.json(); })
        .then(function(json){
            if (!json.ok) {
                document.getElementById('parameterSamplesList').innerHTML = '<div class="alert alert-warning m-3">'+(json.message || 'Tidak dapat mengambil data')+'</div>';
                return;
            }
            if (!json.rows || json.rows.length === 0) {
                document.getElementById('parameterSamplesList').innerHTML = '<div class="text-center py-5 text-muted"><i class="fa fa-inbox fa-3x d-block mb-3"></i>Tidak ada data sampel.</div>';
                return;
            }

            var container = document.createElement('div');
            container.className = 'table-responsive';
            var table = document.createElement('table');
            table.className = 'table table-hover table-bordered mb-0';
            var thead = document.createElement('thead');
            thead.className = 'table-light';
            thead.innerHTML = '<tr><th width="20%">No. Registrasi</th><th width="35%">Parameter</th><th width="20%">Jenis Sampel</th><th width="15%">Tanggal</th><th width="10%" class="text-center">Status</th></tr>';
            table.appendChild(thead);
            var tbody = document.createElement('tbody');
            
            json.rows.forEach(function(r){
                var tr = document.createElement('tr');
                
                var td1 = document.createElement('td');
                td1.className = 'fw-bold';
                var a = document.createElement('a');
                a.href = '<?= site_url('kesmas/laporan_uji_kesmas/detail/') ?>' + r.id;
                a.target = '_blank';
                a.className = 'text-decoration-none';
                a.textContent = r.no_registrasi;
                td1.appendChild(a);
                
                var td2 = document.createElement('td');
                td2.textContent = r.nama_pemeriksaan || '-';

                var td3 = document.createElement('td');
                td3.textContent = r.jenis_sampel || '-';
                
                var td4 = document.createElement('td');
                td4.textContent = r.tgl_permintaan ? r.tgl_permintaan.split(' ')[0] : '-';
                
                var td5 = document.createElement('td');
                td5.className = 'text-center';
                var st = (r.status || '').toUpperCase();
                if (st === 'MS') {
                    td5.innerHTML = '<span class="badge bg-success px-2 py-1">MS</span>';
                } else if (st === 'TMS') {
                    td5.innerHTML = '<span class="badge bg-danger px-2 py-1">TMS</span>';
                } else {
                    td5.innerHTML = '<span class="text-muted">-</span>';
                }
                
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tr.appendChild(td5);
                tbody.appendChild(tr);
            });
            table.appendChild(tbody);
            container.appendChild(table);

            var listDiv = document.getElementById('parameterSamplesList');
            listDiv.innerHTML = '';
            listDiv.appendChild(container);

            // Pagination
            var total = json.total || 0;
            var totalPages = Math.max(1, Math.ceil(total / per_page));
            
            if (totalPages > 1) {
                var pagination = document.createElement('nav');
                pagination.className = 'mt-3 d-flex justify-content-center';
                var ulp = document.createElement('ul');
                ulp.className = 'pagination mb-0';

                function makePageItem(p, label, disabled){
                    var li = document.createElement('li');
                    li.className = 'page-item' + (disabled ? ' disabled' : '');
                    var a = document.createElement('a');
                    a.className = 'page-link';
                    a.href = '#';
                    a.innerHTML = label;
                    a.addEventListener('click', function(ev){ ev.preventDefault(); if(!disabled) fetchSamplesPage(p); });
                    li.appendChild(a);
                    return li;
                }

                ulp.appendChild(makePageItem(page-1, '&laquo;', page<=1));
                var start = Math.max(1, page-2);
                var end = Math.min(totalPages, page+2);
                for(var pi=start; pi<=end; pi++){
                    var li = makePageItem(pi, pi, false);
                    if(pi === page) li.classList.add('active');
                    ulp.appendChild(li);
                }
                ulp.appendChild(makePageItem(page+1, '&raquo;', page>=totalPages));
                pagination.appendChild(ulp);
                listDiv.appendChild(pagination);
            }
        })
        .catch(function(err){
            document.getElementById('parameterSamplesList').innerHTML = '<div class="alert alert-danger m-3">Terjadi kesalahan saat mengambil data.</div>';
            console.error(err);
        });
}

document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.parameter-link').forEach(function(el){
        el.addEventListener('click', function(ev){
            ev.preventDefault();
            var masterId = el.getAttribute('data-master-id');
            var nama = el.textContent.trim();
            var bulan = el.getAttribute('data-bulan') || (document.getElementById('bulan') ? document.getElementById('bulan').value : '') || '<?= htmlspecialchars($bulan) ?>';
            showSamples(masterId, nama, bulan, '');
        });
    });
    
    // Animate progress bars
        document.querySelectorAll('.progress-bar-fill').forEach(function(el){
            var p = parseFloat(el.getAttribute('data-percent')) || 0;
            // small delay for nicer effect
            setTimeout(function(){ el.style.width = Math.max(0, Math.min(100, p)) + '%'; }, 120);
        });
});
</script>
