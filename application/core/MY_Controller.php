<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_DB_query_builder $db
 * @property CI_Config $config
 * @property CI_Security $security
 *
 * // Model-model utama
 * @property Kesmas_model $Kesmas_model
 * @property User_model $User_model
 * @property Tindakan_sampel_model $Tindakan_sampel_model
 * @property Verifikator_model $Verifikator_model
 * @property Penanggung_jawab_teknis_model $pjt_model
 * @property Survei_kepuasan_model $Survei_kepuasan_model
 *
 * // Model untuk fitur keamanan
 * @property Login_logs_model $Login_logs_model
 * @property Activity_logs_model $Activity_logs_model
 * @property Data_pending_model $Data_pending_model
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // SECURITY: Validate session on every request
        // Semua controller yang extends MY_Controller butuh login + session validation
        if (!is_logged_in()) {
            require_login();
        }
    }

    /**
     * Check if user is logged in, redirect if not
     */
    protected function require_login(): void
    {
        if (!is_logged_in()) {
            redirect('petugaslogin');
            exit;
        }
    }

    /**
     * Check if user has one of the required roles, redirect if not.
     * @param array $roles Array of allowed roles (e.g., ['admin', 'petugas'])
     */
    protected function require_role(array $roles): void
    {
        $this->require_login(); // Ensure user is logged in first
        $user_role = $this->session->userdata('role');
        
        // Allow if user has any of the specified roles
        if (!in_array($user_role, $roles)) {
            // Optional: set a flash message for better user feedback
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            redirect('dashboard'); // Redirect to a safe, default page
            exit;
        }
    }

    protected function render(string $view, array $data = [])
    {
        $data['current_user'] = current_user();
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('layout/footer', $data);
    }
}