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
		$this->template->load('arus_kas/index', $data);
    }

    public function add(
		$id = null
	   ) {
		$data = [
			'title' => 'tambah data arus kas',
			'header' => 'tambah data arus kas',
			'arus kas' => $this->aruskas_model->getArusKas($id),
		];
		$this->template->load('arus_kas/add', $data);
	}

	public function edit($id)
	{
		$data = [
			' title'  => ' edit data arus kas',
			'header' => ' edit data arus kas',
			'arus kas' => $this->aruskas_model->getAruskas($id),

		];
	}

	public function delete($id)
	{
		$this->aruskas_model->deleteArusKas($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil dihapus</div>');
		redirect('admin/arus_kas');
	}

	public function save()
	{
		$data = [
			'id_arus_kas' => $this->input->post('id_arus_kas'),
			'id_kas' => $this->input->post('id_kas'),
			'id_akun' => $this->input->post('id_akun'),
			'tanggal' => $this->input->post('tanggal'),
			'keterangan' => $this->input->post('keterangan'),
			'nominal' => $this->input->post('nominal'),
			'id_user' => $this->input->post('id_user'),
		];
		$this->aruskas_model->saveArusKas($data);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambah</div>');
		redirect('admin/arus_kas');
	}

	public function update()
	{
		$data = [
			'id_arus_kas' => $this->input->post('id_arus_kas'),
			'id_kas' => $this->input->post('id_kas'),
			'id_akun' => $this->input->post('id_akun'),
			'tanggal' => $this->input->post('tanggal'),
			'keterangan' => $this->input->post('keterangan'),
			'nominal' => $this->input->post('nominal'),
			'id_user' => $this->input->post('id_user'),
		];
		$this->aruskas_model->updateArusKas($data);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diubah</div>');
		redirect('admin/arus_kas');

	}

}