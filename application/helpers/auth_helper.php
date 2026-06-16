<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Get client IP address
 */
function get_client_ip(): string {
    $ip = '';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        // Pecah berdasar koma jika melewati Load Balancer, dan ambil IP asli (pertama)
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ips[0]);
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

/**
 * Check if user is logged in AND session is valid
 * Validasi session dari database: IP, User-Agent, expiration
 */
function is_logged_in(): bool {
    $CI =& get_instance();
    $user_id = $CI->session->userdata('user_id');
    
    if (!$user_id) {
        return false;
    }
    
    // Validasi session terhadap database
    return validate_session_record($user_id);
}

/**
 * Validasi session dari database
 * Check: IP address, user-agent, session expiration
 */
function validate_session_record(int $user_id): bool {
    $CI =& get_instance();
    
    // Skip validation jika database tidak tersedia
    if (!$CI->db || !$CI->db->table_exists('active_sessions')) {
        return true; // Fallback: izinkan jika table belum ada
    }
    
    try {
        $session_id = session_id();
        $current_ip = get_client_ip();
        $current_agent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
        
        // Cari session record di database
        $session_record = $CI->db->where([
            'session_id' => $session_id,
            'user_id' => $user_id,
            'is_valid' => true
        ])->get('active_sessions')->row_array();
        
        if (!$session_record) {
            // Session tidak ditemukan atau sudah invalid
            $CI->session->sess_destroy();
            return false;
        }
        
        // Validasi expiration
        if (strtotime($session_record['expires_at']) < time()) {
            // Session expired
            $CI->db->update('active_sessions', ['is_valid' => false], ['id' => $session_record['id']]);
            $CI->session->sess_destroy();
            return false;
        }
        
        // Validasi IP dan User-Agent (anti-hijacking)
        if ($session_record['ip_address'] !== $current_ip || 
            $session_record['user_agent'] !== $current_agent) {
            // IP atau User-Agent berubah = potential session hijacking
            $CI->db->update('active_sessions', ['is_valid' => false], ['id' => $session_record['id']]);
            $CI->session->sess_destroy();
            return false;
        }
        
        return true;
    } catch (Exception $e) {
        // Jika error, fallback ke base validation
        return (bool) $CI->session->userdata('user_id');
    }
}

function require_login(): void {
    $CI =& get_instance();
    if (!is_logged_in()) {
        redirect('petugaslogin');
        exit;
    }
}

function current_user(): array {
    $CI =& get_instance();
    return array(
        'user_id' => $CI->session->userdata('user_id'),
        'username' => $CI->session->userdata('username'),
        'nama' => $CI->session->userdata('nama'),
        'role' => $CI->session->userdata('role'),
    );
}

function is_admin(): bool {
    $u = current_user();
    return isset($u['role']) && $u['role'] === 'admin';
}
