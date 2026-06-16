<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property User_model $User_model
 * @property CI_DB_query_builder $db
 */
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        if (is_logged_in()) redirect('dashboard');

        $data = array('title' => 'Login');
        $this->load->view('auth/login', $data);
    }

    public function setup()
    {
        // membuat admin pertama kalau tabel users masih kosong
        $ok = $this->User_model->create_admin_if_empty();
        if ($ok) {
            $this->session->set_flashdata('success', 'Setup selesai. User admin dibuat (admin/admin123). Silakan login.');
        } else {
            $this->session->set_flashdata('info', 'Setup tidak dijalankan (user sudah ada).');
        }
        redirect('petugaslogin');
    }

    public function do_login()
    {
        if (is_logged_in()) redirect('dashboard');

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('petugaslogin');
        }

        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $user = $this->User_model->find_by_username($username);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            // Log failed login attempt
            log_login_attempt([
                'username' => $username,
                'status' => 'failed',
                'failure_reason' => 'Invalid credentials'
            ]);
            
            // Check for account lockout
            lock_account_on_failed($username, 5);
            
            $this->session->set_flashdata('error', 'Username / password salah.');
            redirect('petugaslogin');
        }

        // Log successful login
        log_login_attempt([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'status' => 'success',
        ]);

        // SECURITY: Regenerate session ID to prevent session fixation
        $this->session->sess_regenerate(false);

        $this->session->set_userdata(array(
            'user_id' => (int)$user['id'],
            'username' => $user['username'],
            'nama' => $user['nama'],
            'role' => $user['role'],
        ));

        // SECURITY: Create session record in database for validation
        if ($this->db->table_exists('active_sessions')) {
            $session_id = session_id();
            $this->db->insert('active_sessions', [
                'session_id' => $session_id,
                'user_id' => (int)$user['id'],
                'username' => $user['username'],
                'ip_address' => get_client_ip(),
                'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
                'created_at' => date('Y-m-d H:i:s'),
                'expires_at' => date('Y-m-d H:i:s', time() + 7200), // 2 hours
                'is_valid' => true
            ]);
        }

        // Log user activity
        log_activity('login', 'auth', [
            'description' => "User {$user['username']} logged in"
        ]);

        redirect('dashboard');
    }

    public function logout()
    {
        // SECURITY: Invalidate session in database
        if ($this->session->user_id) {
            if ($this->db->table_exists('active_sessions')) {
                $session_id = session_id();
                $this->db->update('active_sessions', 
                    ['is_valid' => false], 
                    ['session_id' => $session_id]
                );
            }
            
            log_activity('logout', 'auth', [
                'description' => "User {$this->session->username} logged out"
            ]);
        }

        // SECURITY: Destroy session completely
        $this->session->sess_destroy();
        redirect('petugaslogin');
    }
}
