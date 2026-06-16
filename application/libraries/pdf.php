<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';
use Mpdf\Mpdf;

class Pdf {

    public function generate_view($view, $data = [], $filename = 'document.pdf', $dest = 'I') {
        $CI = &get_instance();
        $html = $CI->load->view($view, $data, TRUE);

        $mpdf = new Mpdf([
            'format' => 'A4',
            'orientation' => 'P',
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, $dest); // 'I' = tampil di browser
    }
}
