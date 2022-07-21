<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coa extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('CoaModel', 'coa_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Data COA',
            'header' => 'Management Data COA',
			'coa' => $this->coa_model->getCoa(),
		];
		
		$this->template->load('Coa/index', $data);
    }

}
