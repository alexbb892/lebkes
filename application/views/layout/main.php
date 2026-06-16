<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('layout/sidebar'); ?>
<?php if (!empty($content)) {
    $this->load->view($content);
} ?>
<?php $this->load->view('layout/footer'); ?>