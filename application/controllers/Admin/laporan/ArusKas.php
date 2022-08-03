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

	public function get_data_arus_kas()
	{
		$list = $this->aruskas_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field->id_arus_kas;
			$row[] = $field->id_kas;
			$row[] = $field->id_akun;
			$row[] = $field->tanggal;
			$row[] = $field->keterangan;
			$row[] = $field->nominal;
			$row[] = $field->id_user;
			$row[] = '<a href="' . base_url('admin/arus_kas/edit/' . $field->id_arus_kas) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
					  <a href="' . base_url('admin/arus_kas/delete/' . $field->id_arus_kas) . '" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->aruskas_model->count_all(),
			"recordsFiltered" => $this->aruskas_model->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_data_arus_kas_by_id($id)
	{
		$data = $this->aruskas_model->getArusKas($id);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_id_kas($id)
	{
		$data = $this->aruskas_model->getArusKasByKas($id);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_id_akun($id)
	{
		$data = $this->aruskas_model->getArusKasByAkun($id);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_id_user($id)
	{
		$data = $this->aruskas_model->getArusKasByUser($id);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal($tanggal)
	{
		$data = $this->aruskas_model->getArusKasByTanggal($tanggal);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas($tanggal, $id_kas)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKas($tanggal, $id_kas);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_akun($tanggal, $id_akun)
	{
		$data = $this->aruskas_model->getArusKasByTanggalAkun($tanggal, $id_akun);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_user($tanggal, $id_user)
	{
		$data = $this->aruskas_model->getArusKasByTanggalUser($tanggal, $id_user);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun($tanggal, $id_kas, $id_akun)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkun($tanggal, $id_kas, $id_akun);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_user($tanggal, $id_kas, $id_user)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasUser($tanggal, $id_kas, $id_user);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_akun_user($tanggal, $id_akun, $id_user)
	{
		$data = $this->aruskas_model->getArusKasByTanggalAkunUser($tanggal, $id_akun, $id_user);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun_user($tanggal, $id_kas, $id_akun, $id_user)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkunUser($tanggal, $id_kas, $id_akun, $id_user);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun_user_keterangan($tanggal, $id_kas, $id_akun, $id_user, $keterangan)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkunUserKeterangan($tanggal, $id_kas, $id_akun, $id_user, $keterangan);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun_user_keterangan_nominal($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkunUserKeteranganNominal($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun_user_keterangan_nominal_id($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkunUserKeteranganNominalId($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun_user_keterangan_nominal_id_status($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkunUserKeteranganNominalIdStatus($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun_user_keterangan_nominal_id_status_keterangan($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status, $keterangan_status)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkunUserKeteranganNominalIdStatusKeterangan($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status, $keterangan_status);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun_user_keterangan_nominal_id_status_keterangan_nominal($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status, $keterangan_status, $nominal_status)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkunUserKeteranganNominalIdStatusKeteranganNominal($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status, $keterangan_status, $nominal_status);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun_user_keterangan_nominal_id_status_keterangan_nominal_id($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status, $keterangan_status, $nominal_status, $id_status)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkunUserKeteranganNominalIdStatusKeteranganNominalId($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status, $keterangan_status, $nominal_status, $id_status);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun_user_keterangan_nominal_id_status_keterangan_nominal_id_status($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status, $keterangan_status, $nominal_status, $id_status, $status_status)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkunUserKeteranganNominalIdStatusKeteranganNominalIdStatus($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status, $keterangan_status, $nominal_status, $id_status, $status_status);
		echo json_encode($data);
	}

	public function get_data_arus_kas_by_tanggal_kas_akun_user_keterangan_nominal_id_status_keterangan_nominal_id_status_keterangan($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status, $keterangan_status, $nominal_status, $id_status, $status_status, $keterangan_status_status)
	{
		$data = $this->aruskas_model->getArusKasByTanggalKasAkunUserKeteranganNominalIdStatusKeteranganNominalIdStatusKeterangan($tanggal, $id_kas, $id_akun, $id_user, $keterangan, $nominal, $id, $status, $keterangan_status, $nominal_status, $id_status, $status_status, $keterangan_status_status);
		echo json_encode($data);
	}


}