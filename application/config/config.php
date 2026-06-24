<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|-------------------------------------------------------------------
| Base Site URL
|-------------------------------------------------------------------
| Dinamis (localhost atau IP) supaya bisa diakses via wifi yang sama.
*/

$root = "http://" . $_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

// Jika diakses lewat Cloudflare (HTTPS)
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $root = "https://" . $_SERVER['HTTP_HOST'];
    $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
}

$config['base_url'] = $root;
// $config['base_url'] = ((isset($_SERVER['HTTP']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

//$config['base_url'] = 'https://' . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

$config['index_page'] = '';
$config['uri_protocol']    = 'REQUEST_URI';

$config['encryption_key'] = 'kesmasnew_change_me_123';

/*
|-------------------------------------------------------------------
| Session Variables
|-------------------------------------------------------------------
*/
$config['sess_driver'] = 'files';
$config['sess_save_path'] = APPPATH . 'cache';
$config['sess_cookie_name'] = 'kesmasnew_sess';
$config['sess_expiration'] = 7200;
$config['sess_time_to_update'] = 7200;
$config['sess_regenerate_destroy'] = FALSE;

/*
|-------------------------------------------------------------------
| Cookie Related Variables
|-------------------------------------------------------------------
*/
$config['cookie_prefix']    = '';
$config['cookie_domain']    = '';
$config['cookie_path']        = '/';      // <-- penting: jangan /kesmas_new/
$config['cookie_secure']    = FALSE;
$config['cookie_httponly']     = TRUE;

/*
|-------------------------------------------------------------------
| CSRF Protection
|-------------------------------------------------------------------
*/
$config['csrf_protection'] = TRUE;
$config['csrf_cookie_name'] = 'kesmasnew_csrf';
$config['csrf_token_name']  = 'kesmasnew_token';
$config['csrf_regenerate'] = FALSE; // <-- lebih stabil untuk login/redirect

// Exclude URI login agar tidak error "The action you have requested is not allowed."
$config['csrf_exclude_uris'] = array(
    'auth/do_login',
    'index.php/auth/do_login',
    'kesmas/public_survey/store',
    'index.php/kesmas/public_survey/store',
    'kesmas/survei/store',
    'index.php/kesmas/survei/store',
);

/*
|-------------------------------------------------------------------
| Global XSS Filtering
|-------------------------------------------------------------------
*/
$config['global_xss_filtering'] = TRUE;

$config['enable_query_strings'] = FALSE;
$config['compress_output'] = FALSE;

date_default_timezone_set('Asia/Jakarta');

/*
|-------------------------------------------------------------------
| Error Logging Threshold
|-------------------------------------------------------------------
*/
$config['log_threshold'] = 1;
$config['log_path'] = APPPATH . 'logs/';

$config['charset'] = 'UTF-8';
$config['subclass_prefix'] = 'MY_';
