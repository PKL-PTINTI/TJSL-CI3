<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PosisiKeuangan extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('PosisiKeuanganModel', 'posisikeuangan_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Data Posisi Keuangan',
            'header' => 'Management Data Posisi Keuangan'
		];
		
		$this->template->load('posisi_keuangan/index', $data);
    }

}
