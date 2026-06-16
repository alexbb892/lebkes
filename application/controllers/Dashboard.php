<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function index()
    {
        $this->load->model('Kesmas_model');
        $this->load->model('Activity_logs_model');
        $this->load->helper(['security', 'kesmas_audit']);
        
        // Define all sample categories
        $categories = ['Air Minum', 'Air Bersih', 'Makanan', 'Lingkungan'];
        
        // Get chart data: count by jenis_sampel
        $this->db->select('jenis_sampel, COUNT(id) as total');
        $this->db->group_by('jenis_sampel');
        $query = $this->db->get('kesmas_permintaan');
        $chart_data = $query->result_array();
        
        // Create associative array for easy lookup
        $data_map = [];
        foreach ($chart_data as $row) {
            $data_map[$row['jenis_sampel']] = (int)$row['total'];
        }
        
        // Build arrays ensuring all categories are included
        $labels = [];
        $totals = [];
        $colors = [
            'Air Minum' => 'rgba(13, 110, 253, 0.8)',      // Blue
            'Air Bersih' => 'rgba(6, 182, 212, 0.8)',      // Cyan
            'Makanan' => 'rgba(245, 158, 11, 0.8)',        // Amber
            'Lingkungan' => 'rgba(34, 197, 94, 0.8)'       // Green
        ];
        $border_colors = [
            'Air Minum' => 'rgba(13, 110, 253, 1)',
            'Air Bersih' => 'rgba(6, 182, 212, 1)',
            'Makanan' => 'rgba(245, 158, 11, 1)',
            'Lingkungan' => 'rgba(34, 197, 94, 1)'
        ];
        
        $bg_colors = [];
        $border_color_array = [];
        foreach ($categories as $cat) {
            $labels[] = $cat;
            $totals[] = isset($data_map[$cat]) ? $data_map[$cat] : 0;
            $bg_colors[] = $colors[$cat];
            $border_color_array[] = $border_colors[$cat];
        }
        
        // Overall statistics
        $total_permintaan = $this->db->count_all('kesmas_permintaan');
        $total_diterima = $this->db->where('is_diterima', 1)->count_all_results('kesmas_permintaan');
        $total_pending = $this->db->where('is_diterima', 0)->count_all_results('kesmas_permintaan');

        // Count completed reports from laporan result records, falling back safely if the legacy table is not present.
        $this->db->select('COUNT(DISTINCT permintaan_id) AS total');
        $this->db->where('tgl_jam_lapor IS NOT NULL', null, false);
        $laporan_row = $this->db->get('kesmas_hasil')->row_array();
        $total_laporan = isset($laporan_row['total']) ? (int)$laporan_row['total'] : 0;

        // Get recent activities
        $recent_activities = get_recent_activities(5);

        // Get recent permintaan
        $this->db->select('p.id, p.no_registrasi, p.nama_sampel, p.created_at, u.nama as user_nama');
        $this->db->from('kesmas_permintaan p');
        $this->db->join('user_kesmas u', 'p.created_by = u.id', 'left');
        $this->db->order_by('p.id', 'DESC');
        $this->db->limit(5);
        $recent_permintaan = $this->db->get()->result_array();

        $data = array(
            'title' => 'Dashboard',
            'chart_labels' => json_encode($labels),
            'chart_totals' => json_encode($totals),
            'chart_bg_colors' => json_encode($bg_colors),
            'chart_border_colors' => json_encode($border_color_array),
            'total_permintaan' => $total_permintaan,
            'total_diterima' => $total_diterima,
            'total_pending' => $total_pending,
            'total_laporan' => $total_laporan,
            'lingkungan_count' => isset($data_map['Lingkungan']) ? $data_map['Lingkungan'] : 0,
            'air_minum_count' => isset($data_map['Air Minum']) ? $data_map['Air Minum'] : 0,
            'air_bersih_count' => isset($data_map['Air Bersih']) ? $data_map['Air Bersih'] : 0,
            'makanan_count' => isset($data_map['Makanan']) ? $data_map['Makanan'] : 0,
            'recent_activities' => $recent_activities,
            'recent_permintaan' => $recent_permintaan,
        );
        $this->render('dashboard', $data);
    }
}
