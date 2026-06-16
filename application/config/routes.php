<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'public_pendaftaran';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['klinik/petugas_klinik'] = 'klinik/auth/index';
$route['klinik/petugas_klinik/login'] = 'klinik/auth/login';
$route['klinik/petugas_klinik/logout'] = 'klinik/auth/logout';
$route['klinik/dashboard'] = 'klinik/dashboard/index';

$route['petugaslogin']  = 'auth/index';
$route['logout'] = 'auth/logout';

$route['public_pendaftaran'] = 'public_pendaftaran/index';
$route['public_pendaftaran/form'] = 'public_pendaftaran/form';
$route['public_pendaftaran/store'] = 'public_pendaftaran/store';
$route['public_pendaftaran/success/(:any)'] = 'public_pendaftaran/success/$1';
$route['public_pendaftaran/print_bukti/(:any)'] = 'public_pendaftaran/print_bukti/$1';

$route['kesmas/pendaftaran'] = 'kesmas/form_permintaan_kesmas/index';
$route['kesmas/pendaftaran/create'] = 'kesmas/form_permintaan_kesmas/create';
$route['kesmas/pendaftaran/edit/(:num)'] = 'kesmas/form_permintaan_kesmas/edit/$1';
$route['kesmas/pendaftaran/detail/(:num)'] = 'kesmas/form_permintaan_kesmas/detail/$1';
$route['kesmas/pendaftaran/print/(:num)'] = 'kesmas/form_permintaan_kesmas/print/$1';
$route['kesmas/pendaftaran/delete/(:num)'] = 'kesmas/form_permintaan_kesmas/delete/$1';
$route['kesmas/pendaftaran/selesai/(:num)'] = 'kesmas/form_permintaan_kesmas/selesai/$1';

// Sample Management - Terima / Tolak Sample
$route['kesmas/permintaan_sample'] = 'kesmas/permintaan_sample/index';
$route['kesmas/permintaan_sample/verifikasi/(:num)'] = 'kesmas/permintaan_sample/verifikasi/$1';
$route['kesmas/permintaan_sample/tolak/(:num)'] = 'kesmas/permintaan_sample/tolak/$1';

$route['kesmas/kaji_ulang'] = 'kesmas/form_permintaan_kesmas/kaji_ulang';
$route['kesmas/kaji_ulang/(:num)'] = 'kesmas/form_permintaan_kesmas/kaji_ulang/$1';
$route['kesmas/kaji_ulang_detail/(:num)'] = 'kesmas/form_permintaan_kesmas/kaji_ulang_detail/$1';
$route['kesmas/kaji_ulang_edit/(:num)'] = 'kesmas/form_permintaan_kesmas/kaji_ulang_detail/$1';
$route['kesmas/kaji_ulang_update/(:num)'] = 'kesmas/form_permintaan_kesmas/kaji_ulang_update/$1';

$route['kesmas/uji'] = 'kesmas/form_permintaan_kesmas/uji_index';
$route['kesmas/uji/input/(:num)'] = 'kesmas/form_permintaan_kesmas/input_hasil/$1';

$route['kesmas/laporan'] = 'kesmas/laporan_uji_kesmas/index';
$route['kesmas/laporan/detail/(:num)'] = 'kesmas/laporan_uji_kesmas/detail/$1';
$route['kesmas/laporan/print/(:num)'] = 'kesmas/Laporan_uji_kesmas/print/$1';
// AJAX endpoint for per-parameter MS/TMS status
$route['kesmas/laporan/set_status'] = 'kesmas/laporan_uji_kesmas/set_status';

// Laporan parameter (summary MS/TMS per parameter)
$route['kesmas/laporan/parameter'] = 'kesmas/laporan_uji_kesmas/parameter';
// AJAX: return list of permintaan (samples) for a given master_pemeriksaan and month
$route['kesmas/laporan/parameter_samples'] = 'kesmas/laporan_uji_kesmas/parameter_samples';

// ===== New Features Routes =====

// Survei Kepuasan
$route['kesmas/survei'] = 'kesmas/survei/index';
$route['kesmas/survei/form'] = 'kesmas/survei/form';
$route['kesmas/survei/store'] = 'kesmas/survei/store';
$route['kesmas/survei/view/(:num)'] = 'kesmas/survei/view/$1';
$route['kesmas/survei/detail/(:num)'] = 'kesmas/survei/detail/$1';
$route['kesmas/survei/edit/(:num)'] = 'kesmas/survei/edit/$1';
$route['kesmas/survei/update/(:num)'] = 'kesmas/survei/update/$1';
$route['kesmas/survei/delete/(:num)'] = 'kesmas/survei/delete/$1';
$route['kesmas/survei/laporan'] = 'kesmas/survei/laporan';
$route['kesmas/survei/laporan_by_date'] = 'kesmas/survei/laporan_by_date';

// Security Dashboard
$route['security'] = 'security/index';
$route['security/login_logs'] = 'security/login_logs';
$route['security/activity_logs'] = 'security/activity_logs';
$route['security/activity_detail/(:num)'] = 'security/activity_detail/$1';
$route['security/pending_data'] = 'security/pending_data';
$route['security/approve_pending/(:num)'] = 'security/approve_pending/$1';
$route['security/reject_pending/(:num)'] = 'security/reject_pending/$1';
$route['security/request_revision/(:num)'] = 'security/request_revision/$1';
$route['security/cleanup/(:any)/(:num)'] = 'security/cleanup/$1/$2';
$route['security/cleanup/(:any)'] = 'security/cleanup/$1';
$route['security/export_logs/(:any)'] = 'security/export_logs/$1';

// Master Data - Tindakan Sampel Management
$route['tindakan_sampel'] = 'tindakan_sampel/index';
$route['tindakan_sampel/add'] = 'tindakan_sampel/add';
$route['tindakan_sampel/edit/(:num)'] = 'tindakan_sampel/edit/$1';
$route['tindakan_sampel/delete/(:num)'] = 'tindakan_sampel/delete/$1';

// Pembayaran module removed
