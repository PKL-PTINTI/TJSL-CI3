<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ArusKas extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('ArusKasModel', 'aruskas_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Data Arus Kas',
            'header' => 'Data Arus Kas',
            'aruskas' => $this->aruskas_model->getArusKas(),
		];
		
		$this->template->load('ArusKas/index', $data);
    }

}
