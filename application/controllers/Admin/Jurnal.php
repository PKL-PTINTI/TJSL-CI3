<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('JurnalModel', 'jurnal_model');

		if(!$this->session->userdata('username')){
			redirect(base_url('auth'));
		}
	}

	public function index()
	{
		$data = [
			'title' => 'Management Data Jurnal',
			'header' => 'Data Jurnal',
		];

		$this->template->load('jurnal/index', $data);
	}

	public function get_jurnal(){
		$list = $this->jurnal_model->get_datatables();
		$jurnal = $this->jurnal_model->get_jurnal();
        $data = array();
        $no = $this->input->post('start');
		$total_pemasukan = 0;
		$total_pengeluaran = 0;

		$tgl_pertama = date('Y-m-01', strtotime(date( 'Y-m-d H:i:s', time () )));
		if($tgl_pertama >= '2022-01-01' AND $tgl_pertama < '2023-01-01'){
			$awaltahunlalu='2022-01-01';
		}
		if($tgl_pertama >= '2023-01-01' AND $tgl_pertama < '2024-01-01'){
			$awaltahunlalu='2023-01-01';
		}
		if($tgl_pertama >= '2024-01-01' AND $tgl_pertama < '2025-01-01'){
			$awaltahunlalu='2024-01-01';
		}
		if($tgl_pertama >= '2025-01-01' AND $tgl_pertama < '2026-01-01'){
			$awaltahunlalu='2025-01-01';
		}

		foreach($jurnal as $jrnl){
			$total_pemasukan += $jrnl->pemasukan;
			$total_pengeluaran += $jrnl->pengeluaran;
		}

        foreach ($list as $data_jurnal) {
            $no++;
            $row = array();
			$row[] = $no;
            $row[] = $data_jurnal->id_opex;
            $row[] = $data_jurnal->id_akun;
            $row[] = $data_jurnal->tanggal;
			$row[] = $data_jurnal->pemasukan;
			$row[] = $data_jurnal->pengeluaran;
			$row[] = $data_jurnal->deskripsi;
			$row[] = $data_jurnal->keterangan;
			$row[] = $data_jurnal->nobukti;
			$row[] = $data_jurnal->tot_pemasukan;
			$row[] = $data_jurnal->tot_pengeluaran;
			$row[] = $data_jurnal->tampil;
			$row[] = $data_jurnal->updated;
			$row[] = $data_jurnal->tglUpdate;

			$row[] =  '<a class="btn btn-success btn-sm"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-danger btn-sm "><i class="fa fa-trash"></i> </a>';
            $data[] = $row;
        }

		$hasil = [
			'Total',
			'',
			'',
			'',
			$total_pemasukan,
			$total_pengeluaran,
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
		];

		$data[] = $hasil;

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->jurnal_model->count_all(),
            "recordsFiltered" => $this->jurnal_model->count_filtered(),
            "data" => $data,
        );
		
        echo json_encode($output);
	}

	public function jurnalBank($bank)
	{
		$list = $this->jurnal_model->get_datatables_bank($bank);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $data_jurnal) {
            $no++;
            $row = array();
			$row[] = $no;
            $row[] = $data_jurnal->id_opex;
            $row[] = $data_jurnal->id_akun;
            $row[] = $data_jurnal->tanggal;
			$row[] = $data_jurnal->pemasukan;
			$row[] = $data_jurnal->pengeluaran;
			$row[] = $data_jurnal->deskripsi;
			$row[] = $data_jurnal->keterangan;
			$row[] = $data_jurnal->nobukti;
			$row[] = $data_jurnal->tot_pemasukan;
			$row[] = $data_jurnal->tot_pengeluaran;
			$row[] = $data_jurnal->tampil;
			$row[] = $data_jurnal->updated;
			$row[] = $data_jurnal->tglUpdate;

			$row[] =  '<a class="btn btn-success btn-sm"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-danger btn-sm "><i class="fa fa-trash"></i> </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->jurnal_model->count_all_bank(),
            "recordsFiltered" => $this->jurnal_model->count_filtered_bank($bank),
            "data" => $data,
        );
		
        echo json_encode($output);
	}

	public function create(){
		$data = [
			'title' => 'Tambah Data Transaksi Jurnal',
			'header' => 'Tambah Data Transaksi Jurnal',
			'korek' => $this->jurnal_model->getKodeRekening(),
		];

		$this->template->load('jurnal/create', $data);
	}

	public function store(){
		$nomor_bukti = $this->input->post('nomor_bukti');
		$tanggal_transaksi = $this->input->post('tanggal_transaksi');
		$korek = $this->input->post('korek');
		$jumlah_pemasukan = $this->input->post('jumlah_pemasukan');
		$keterangan = $this->input->post('keterangan');
		$korekPasangan = $this->input->post('korekPasangan');

		$deskripsi = $this->jurnal_model->getDeskripsiAkun($korek)->deskripsiAkun;
		
	}

	public function voucher(){
		$data = [
			'title' => 'Tambah Data Transaksi Voucher',
			'header' => 'Tambah Data Transaksi Voucher',
			'korek' => $this->jurnal_model->getKodeRekening(),
		];

		$this->template->load('jurnal/voucher', $data);
	}

	public function addVoucher(){
		$nomor_bukti = $this->input->post('nomor_bukti');
		$tanggal_transaksi = $this->input->post('tanggal_transaksi');
		$korek = $this->input->post('korek');
		$keterangan = $this->input->post('keterangan');
		$jumlah_pemasukan = $this->input->post('jumlah_pemasukan');
		$korekPasangan = $this->input->post('korekPasangan');

		$deskripsi = $this->jurnal_model->getDeskripsiAkun($korek)->deskripsiAkun;
		
	}

	

}
