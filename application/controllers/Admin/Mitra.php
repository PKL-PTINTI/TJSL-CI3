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
			'header' => 'Data Mitra',
			'mitra' => $this->mitra_model->getData(),
		];

		$this->template->load('mitra/index', $data);
	}

	public function tidakbermasalah()
	{
		$data = [
			'title' => 'Managment Data Mitra',
			'header' => 'Data Mitra Tidak Bermasalah',
			'mitra' => $this->mitra_model->getMitraTidakBermasalah(),
		];

		$this->template->load('mitra/index', $data);
	}

	public function bermasalah()
	{
		$data = [
			'title' => 'Management Data Mitra',
			'header' => 'Data Mitra Bermasalah',
			'mitra' => $this->mitra_model->getMitraBermasalah(),
		];

		$this->template->load('mitra/index', $data);
	}

	public function wipeout()
	{
		$data = [
			'title' => 'Managment Data Mitra',
			'header' => 'Data Mitra Wipe Out',
			'mitra' => $this->mitra_model->getMitraWipeOut(),
		];

		$this->template->load('mitra/index', $data);
	}
}
