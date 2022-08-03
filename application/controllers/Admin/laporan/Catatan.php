<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catatan extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('CatatanModel', 'catatan_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Catatan Atas Laporan Keuangan',
            'header' => 'Management Catatan Atas Laporan Keuangan'
		];
		
		$this->template->load('catatan/index', $data);
    }

}