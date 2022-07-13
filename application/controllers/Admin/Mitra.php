<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitra extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MitraModel');
		
		$this->mitra_model = new MitraModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Managment Data Mitra',
		];

		$mitra = $this->mitra_model->getData();
		$data['mitra'] = $mitra;

		$this->template->load('mitra/index', $data);
	}
}