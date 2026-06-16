<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_kelompok_prefix'))
{
    /**
     * Maps a given kelompok (group) name to an alphabetical prefix (A, B, C, D...).
     *
     * @param string $kategori The category of the sample (e.g., 'air_minum', 'makanan').
     * @param string $kelompok The group name (e.g., 'Fisika', 'Kimia Wajib').
     * @return string The alphabetical prefix (e.g., 'A. ', 'B. ') or an empty string if not found.
     */
    function get_kelompok_prefix(string $kategori, string $kelompok): string
    {
        $mapping = [];

        switch ($kategori) {
            case 'air_minum':
                $mapping = [
                    'Fisik' => 'A. ',
                    'Kimia' => 'B. ',
                    'Kimia Tambahan' => 'C. ',
                    'Mikrobiologi' => 'D. ',
                ];
                break;
            case 'air_bersih':
                $mapping = [
                    'Fisik' => 'A. ',
                    'Kimia' => 'B. ',
                    'Mikrobiologi' => 'C. ',
                ];
                break;
            case 'makanan':
                $mapping = [
                    'Kimia' => 'A. ',
                    'Mikrobiologi' => 'B. ',
                    'Parasitologi' => 'C. ',
                ];
                break;
            case 'lingkungan':
                $mapping = [
                    'Pemeriksaan Lingkungan' => 'A. ', // Assuming this is the main group
                    // Add other specific groups if needed for lingkungan
                ];
                break;
            default:
                // Default mapping or handle unknown categories
                break;
        }

        return $mapping[$kelompok] ?? '';
    }
}

if ( ! function_exists('e_html'))
{
    /**
     * Safely echoes a string by running it through htmlspecialchars,
     * with double encoding disabled to prevent issues with pre-escaped data.
     *
     * @param mixed $string The string to display.
     * @param string $default The default value to show if the string is null.
     * @return string The escaped HTML string.
     */
    function e_html($string, string $default = '-'): string
    {
        $string_to_display = $string ?? $default;
        return htmlspecialchars((string)$string_to_display, ENT_QUOTES, 'UTF-8', false);
    }
}
