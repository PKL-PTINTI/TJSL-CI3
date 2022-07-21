<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();

		if(!$this->session->userdata('username')){
			redirect(base_url('auth'));
		}
	}

	public function index()
	{
		$data = [
			'title' => 'Dashboard',
			'countMitra' => $this->db->count_all('mitra'),
			'countMitraNormal' => $this->db->where('tdkbermasalah', 'normal', 'Normal', 'NORMAL')->count_all_results('mitra'),
			'countMitraBermasalah' => $this->db->where('tdkbermasalah', 'masalah', 'Masalah', 'MASALAH')->count_all_results('mitra'),
			'countMitraKhusus' => $this->db->where('tdkbermasalah', 'khusus', 'Khusus', 'KHUSUS')->count_all_results('mitra'),
			'countMitraWo' => $this->db->where('tdkbermasalah', 'wo', 'Wo', 'WO')->count_all_results('mitra'),
		];
		
		$this->template->load('dashboard/index', $data);
	}
}
