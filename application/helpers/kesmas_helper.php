<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_group_headers'))
{
    function get_group_headers($kategori_sampel)
    {
        $groups = [];
        switch (strtolower($kategori_sampel)) {
            case 'air minum':
                $groups = [
                    'A. Pemeriksaan Fisik',
                    'B. Pemeriksaan Kimia',
                    'C. Pemeriksaan Kimia Tambahan',
                    'D. Pemeriksaan Mikrobiologi'
                ];
                break;
            case 'air bersih':
                $groups = [
                    'A. Pemeriksaan Fisik',
                    'B. Pemeriksaan Kimia',
                    'C. Pemeriksaan Mikrobiologi'
                ];
                break;
            case 'makanan':
                $groups = [
                    'A. Pemeriksaan Kimia',
                    'B. Pemeriksaan Mikrobiologi',
                    'C. Pemeriksaan Parasitologi'
                ];
                break;
            case 'lingkungan':
                $groups = [
                    'A. Pemeriksaan Lingkungan/Pemeriksaan'
                ];
                break;
            default:
                $groups = [];
                break;
        }
        return $groups;
    }
}
