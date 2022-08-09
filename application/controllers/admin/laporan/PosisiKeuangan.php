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

		if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
		$data['bulan'] =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		
		$this->template->load('posisi_keuangan/index', $data);
    }

	public function getPosisiKeuangan()
	{
		
	}



}
