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

	public function mitramasalah($status)
	{
		$data = [
			'title' => 'Mitra ' . $status,
			'header' => 'Data Mitra ' . ucfirst($status),
			'mitra' => $this->mitra_model->getMitraMasalah($status),
		];

		$this->template->load('mitra/index', $data);
	}

	public function mitrakolektibilitas($kolektibilitas)
	{		
		$data = [
<<<<<<< Updated upstream
			'title' => 'Management Data Mitra',
			'header' => 'Data Mitra Bermasalah',
			'mitra' => $this->mitra_model->getMitraBermasalah(),
=======
			'title' => 'Mitra ' . $kolektibilitas,
			'header' => 'Data Mitra ' . ucfirst($kolektibilitas),
		];

		if($kolektibilitas == 'kuranglancar'){
			$data['mitra'] = $this->mitra_model->getMitraKurangLancar();
		} else {
			$data['mitra'] = $this->mitra_model->getMitraKolektibilitas($kolektibilitas);
		}

		$this->template->load('mitra/index', $data);
	}

	public function sektorlancar($sektor){
		$data = [
			'title' => 'Mitra Sektor ' . ucfirst($sektor),
			'header' => 'Data Mitra Sektor ' . ucfirst($sektor) .' Lancar',
			'mitra' => $this->mitra_model->getMitraSektorLancar($sektor),
>>>>>>> Stashed changes
		];

		$this->template->load('mitra/index', $data);
	}

	public function sektorkuranglancar($sektor){
		$data = [
			'title' => 'Mitra Sektor ' . ucfirst($sektor),
			'header' => 'Data Mitra Sektor ' . ucfirst($sektor) .' Kurang Lancar',
			'mitra' => $this->mitra_model->getMitraSektorKurangLancar($sektor),
		];

		$this->template->load('mitra/index', $data);
	}

	public function sektordiragukan($sektor){
		$data = [
			'title' => 'Mitra Sektor ' . ucfirst($sektor),
			'header' => 'Data Mitra Sektor ' . ucfirst($sektor) .' Diragukan',
			'mitra' => $this->mitra_model->getMitraSektorDiragukan($sektor),
		];

		$this->template->load('mitra/index', $data);
	}

	public function sektormacet($sektor){
		$data = [
			'title' => 'Mitra Sektor ' . ucfirst($sektor),
			'header' => 'Data Mitra Sektor ' . ucfirst($sektor) .' Macet',
			'mitra' => $this->mitra_model->getMitraSektorMacet($sektor),
		];

		$this->template->load('mitra/index', $data);
	}

	public function create(){
		$data = [
			'title' => 'Tambah Data Mitra',
			'header' => 'Tambah Data Mitra',
		];

		$this->template->load('mitra/create', $data);
	}
}