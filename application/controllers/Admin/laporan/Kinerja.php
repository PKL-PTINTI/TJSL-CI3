<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kinerja extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('KinerjaModel', 'kinerja_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Data Laporan Kinerja',
            'header' => 'Management Data Laporan Kinerja'
		];

        $periode = date('Y-m-d', strtotime('-1 days', strtotime(date('01-m-Y', strtotime(date('Y-m-d'))))));
		
		$this->template->load('kinerja/index', $data);
    }

}
