<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-04-13 11:18:53 --> Query error: Expression #1 of ORDER BY clause is not in SELECT list, references column 'kesmas_new.p.tgl_permintaan' which is not in SELECT list; this is incompatible with DISTINCT - Invalid query: SELECT DISTINCT `p`.`id`, `p`.`no_registrasi`
FROM `kesmas_hasil` `h`
JOIN `kesmas_permintaan_item` `i` ON `i`.`id` = `h`.`permintaan_item_id`
JOIN `kesmas_permintaan` `p` ON `p`.`id` = `h`.`permintaan_id`
WHERE `i`.`master_pemeriksaan_id` = 17
AND DATE_FORMAT(h.tgl_jam_pemeriksaan, '%Y-%m') = '2026-04'
ORDER BY `p`.`tgl_permintaan` DESC, `p`.`id` DESC
ERROR - 2026-04-13 11:18:58 --> Query error: Expression #1 of ORDER BY clause is not in SELECT list, references column 'kesmas_new.p.tgl_permintaan' which is not in SELECT list; this is incompatible with DISTINCT - Invalid query: SELECT DISTINCT `p`.`id`, `p`.`no_registrasi`
FROM `kesmas_hasil` `h`
JOIN `kesmas_permintaan_item` `i` ON `i`.`id` = `h`.`permintaan_item_id`
JOIN `kesmas_permintaan` `p` ON `p`.`id` = `h`.`permintaan_id`
WHERE `i`.`master_pemeriksaan_id` = 17
AND DATE_FORMAT(h.tgl_jam_pemeriksaan, '%Y-%m') = '2026-04'
ORDER BY `p`.`tgl_permintaan` DESC, `p`.`id` DESC
ERROR - 2026-04-13 11:19:10 --> Query error: Expression #1 of ORDER BY clause is not in SELECT list, references column 'kesmas_new.p.tgl_permintaan' which is not in SELECT list; this is incompatible with DISTINCT - Invalid query: SELECT DISTINCT `p`.`id`, `p`.`no_registrasi`
FROM `kesmas_hasil` `h`
JOIN `kesmas_permintaan_item` `i` ON `i`.`id` = `h`.`permintaan_item_id`
JOIN `kesmas_permintaan` `p` ON `p`.`id` = `h`.`permintaan_id`
WHERE `i`.`master_pemeriksaan_id` = 4
AND DATE_FORMAT(h.tgl_jam_pemeriksaan, '%Y-%m') = '2026-04'
ORDER BY `p`.`tgl_permintaan` DESC, `p`.`id` DESC
ERROR - 2026-04-13 11:19:13 --> Query error: Expression #1 of ORDER BY clause is not in SELECT list, references column 'kesmas_new.p.tgl_permintaan' which is not in SELECT list; this is incompatible with DISTINCT - Invalid query: SELECT DISTINCT `p`.`id`, `p`.`no_registrasi`
FROM `kesmas_hasil` `h`
JOIN `kesmas_permintaan_item` `i` ON `i`.`id` = `h`.`permintaan_item_id`
JOIN `kesmas_permintaan` `p` ON `p`.`id` = `h`.`permintaan_id`
WHERE `i`.`master_pemeriksaan_id` = 31
AND DATE_FORMAT(h.tgl_jam_pemeriksaan, '%Y-%m') = '2026-04'
ORDER BY `p`.`tgl_permintaan` DESC, `p`.`id` DESC
ERROR - 2026-04-13 11:19:19 --> Query error: Expression #1 of ORDER BY clause is not in SELECT list, references column 'kesmas_new.p.tgl_permintaan' which is not in SELECT list; this is incompatible with DISTINCT - Invalid query: SELECT DISTINCT `p`.`id`, `p`.`no_registrasi`
FROM `kesmas_hasil` `h`
JOIN `kesmas_permintaan_item` `i` ON `i`.`id` = `h`.`permintaan_item_id`
JOIN `kesmas_permintaan` `p` ON `p`.`id` = `h`.`permintaan_id`
WHERE `i`.`master_pemeriksaan_id` = 22
AND DATE_FORMAT(h.tgl_jam_pemeriksaan, '%Y-%m') = '2026-04'
ORDER BY `p`.`tgl_permintaan` DESC, `p`.`id` DESC
ERROR - 2026-04-13 11:34:50 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:34:51 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:34:53 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:34:57 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:40:19 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:40:20 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:53:06 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:54:10 --> Severity: Warning --> mysqli::real_connect(): (HY000/1049): Unknown database 'kesmas_new' C:\laragon\www\kesmas_new\system\database\drivers\mysqli\mysqli_driver.php 211
ERROR - 2026-04-13 11:54:10 --> Unable to connect to the database
ERROR - 2026-04-13 11:54:11 --> Severity: Warning --> mysqli::real_connect(): (HY000/1049): Unknown database 'kesmas_new' C:\laragon\www\kesmas_new\system\database\drivers\mysqli\mysqli_driver.php 211
ERROR - 2026-04-13 11:54:11 --> Unable to connect to the database
ERROR - 2026-04-13 11:54:42 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:54:43 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:56:15 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:56:57 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:58:00 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 11:58:22 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 12:02:11 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 12:02:12 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 12:02:18 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 12:02:18 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 12:02:19 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 12:02:19 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 16:30:57 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 16:32:00 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 16:33:21 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 16:33:43 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 16:33:45 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 16:33:49 --> Severity: error --> Exception: syntax error, unexpected token "." C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 13
ERROR - 2026-04-13 16:51:03 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:03 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:03 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:51:18 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:18 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:18 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:51:22 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:22 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:22 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:51:23 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:23 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:23 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:51:25 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:25 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:25 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:51:26 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:26 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:26 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:51:27 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:27 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:27 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:51:27 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:27 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:27 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:51:28 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:28 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:28 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:51:31 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:31 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:31 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:51:33 --> Severity: Warning --> Undefined variable $grand_total_tested C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 23
ERROR - 2026-04-13 16:51:33 --> Severity: Warning --> Undefined variable $grand_total_ms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 29
ERROR - 2026-04-13 16:51:33 --> Severity: Warning --> Undefined variable $grand_total_tms C:\laragon\www\kesmas_new\application\views\kesmas\laporan_parameter.php 35
ERROR - 2026-04-13 16:56:50 --> Severity: error --> Exception: syntax error, unexpected identifier "m", expecting ")" C:\laragon\www\kesmas_new\application\controllers\kesmas\Laporan_uji_kesmas.php 268
ERROR - 2026-04-13 16:56:52 --> Severity: error --> Exception: syntax error, unexpected identifier "m", expecting ")" C:\laragon\www\kesmas_new\application\controllers\kesmas\Laporan_uji_kesmas.php 268
ERROR - 2026-04-13 16:57:27 --> Severity: error --> Exception: syntax error, unexpected identifier "m", expecting ")" C:\laragon\www\kesmas_new\application\controllers\kesmas\Laporan_uji_kesmas.php 268
ERROR - 2026-04-13 17:45:30 --> Query error: Unknown column 'is_public_submission' in 'where clause' - Invalid query: SELECT *
FROM `kesmas_permintaan`
WHERE   (
`no_registrasi` LIKE '%aq%' ESCAPE '!'
OR  `nama_sampel` LIKE '%aq%' ESCAPE '!'
OR  `jenis_sampel` LIKE '%aq%' ESCAPE '!'
OR  `nama_pengirim` LIKE '%aq%' ESCAPE '!'
OR  `instansi` LIKE '%aq%' ESCAPE '!'
 )
AND   (
`is_public_submission` = 0
OR `status_verifikasi` = 'Verified'
 )
AND `status_kelayakan` = 'Layak'
ORDER BY `id` DESC
ERROR - 2026-04-13 17:45:31 --> Query error: Unknown column 'is_public_submission' in 'where clause' - Invalid query: SELECT *
FROM `kesmas_permintaan`
WHERE   (
`no_registrasi` LIKE '%aq%' ESCAPE '!'
OR  `nama_sampel` LIKE '%aq%' ESCAPE '!'
OR  `jenis_sampel` LIKE '%aq%' ESCAPE '!'
OR  `nama_pengirim` LIKE '%aq%' ESCAPE '!'
OR  `instansi` LIKE '%aq%' ESCAPE '!'
 )
AND   (
`is_public_submission` = 0
OR `status_verifikasi` = 'Verified'
 )
AND `status_kelayakan` = 'Layak'
ORDER BY `id` DESC
ERROR - 2026-04-13 17:46:34 --> Query error: Unknown column 'is_public_submission' in 'where clause' - Invalid query: SELECT *
FROM `kesmas_permintaan`
WHERE   (
`no_registrasi` LIKE '%aq%' ESCAPE '!'
OR  `nama_sampel` LIKE '%aq%' ESCAPE '!'
OR  `jenis_sampel` LIKE '%aq%' ESCAPE '!'
OR  `nama_pengirim` LIKE '%aq%' ESCAPE '!'
OR  `instansi` LIKE '%aq%' ESCAPE '!'
 )
AND   (
`is_public_submission` = 0
OR `status_verifikasi` = 'Verified'
 )
AND `status_kelayakan` = 'Layak'
ORDER BY `id` DESC
ERROR - 2026-04-13 17:47:24 --> Query error: Unknown column 'is_public_submission' in 'where clause' - Invalid query: SELECT *
FROM `kesmas_permintaan`
WHERE   (
`no_registrasi` LIKE '%aq%' ESCAPE '!'
OR  `nama_sampel` LIKE '%aq%' ESCAPE '!'
OR  `jenis_sampel` LIKE '%aq%' ESCAPE '!'
OR  `nama_pengirim` LIKE '%aq%' ESCAPE '!'
OR  `instansi` LIKE '%aq%' ESCAPE '!'
 )
AND   (
`is_public_submission` = 0
OR `status_verifikasi` = 'Verified'
 )
AND `status_kelayakan` = 'Layak'
ORDER BY `id` DESC
ERROR - 2026-04-13 18:07:10 --> 404 Page Not Found: kesmas/Permintaan_sample/index
ERROR - 2026-04-13 18:07:12 --> 404 Page Not Found: kesmas/Permintaan_sample/index
ERROR - 2026-04-13 18:07:22 --> 404 Page Not Found: kesmas/Permintaan_sample/index
ERROR - 2026-04-13 18:07:23 --> 404 Page Not Found: kesmas/Permintaan_sample/index
ERROR - 2026-04-13 18:07:26 --> 404 Page Not Found: kesmas/Permintaan_sample/index
ERROR - 2026-04-13 18:07:27 --> 404 Page Not Found: kesmas/Permintaan_sample/index
ERROR - 2026-04-13 18:07:34 --> 404 Page Not Found: kesmas/Permintaan_sample/index
ERROR - 2026-04-13 18:07:36 --> 404 Page Not Found: kesmas/Permintaan_sample/index
ERROR - 2026-04-13 18:11:38 --> 404 Page Not Found: kesmas/Permintaan_sample/index
ERROR - 2026-04-13 18:11:40 --> 404 Page Not Found: kesmas/Permintaan_sample/index
ERROR - 2026-04-13 18:15:08 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:15:10 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:15:16 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:15:19 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:15:22 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:15:23 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:15:33 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:15:44 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:15:46 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:17:05 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:17:06 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:18:06 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:18:08 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
ERROR - 2026-04-13 18:19:12 --> Severity: error --> Exception: syntax error, unexpected token "public" C:\laragon\www\kesmas_new\application\controllers\kesmas\Form_permintaan_kesmas.php 84
