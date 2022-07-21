<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgingRate extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('AgingRateModel', 'agingrate_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Data Aging Rate',
            'header' => 'Aging Rate',
			'agingrate' => $this->agingrate_model->getAgingRate(),
		];
		
		$this->template->load('aging_rate/index', $data);
    }

	public function add()
	{
		$data = [
			'title' => 'Tambah Data Aging Rate',
			'header' => 'Tambah Data Aging Rate',
		];
		
		$this->template->load('aging_rate/add', $data);
	}

	public function edit($id)
	{
		$data = [
			'title' => 'Edit Data Aging Rate',
			'header' => 'Edit Data Aging Rate',
			'agingrate' => $this->agingrate_model->getAgingRateById($id),
		];
		
		$this->template->load('aging_rate/edit', $data);
	}

	public function save()
	{
		$this->form_validation->set_rules('aging_rate', 'Aging Rate', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->add();
		} else {
			$data = [
				'aging_rate' => $this->input->post('aging_rate'),
				'description' => $this->input->post('description'),
			];
			
			$this->agingrate_model->save($data);
			$this->session->set_flashdata('success', 'Data berhasil disimpan');
			redirect('aging_rate');
		}
	}

	
	public function update($id)
	{
		$this->form_validation->set_rules('aging_rate', 'Aging Rate', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->edit($id);
		} else {
			$data = [
				'aging_rate' => $this->input->post('aging_rate'),
				'description' => $this->input->post('description'),
			];
			
			$this->agingrate_model->update($id, $data);
			$this->session->set_flashdata('success', 'Data berhasil diubah');
			redirect('aging_rate');
		}
	}
}
