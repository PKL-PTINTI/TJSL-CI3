<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('SaldoModel', 'saldo_model');
		$this->load->model('JurnalModel', 'jurnal_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Data Saldo Kas Dan Bank',
            'header' => 'Data Saldo',
			'saldokasbank' => $this->saldo_model->getSaldo(),
		];
		
		$this->template->load('saldo/index', $data);
    }

	public function update($akun){
		if ($akun == 'kas') {	
			$id_akun = '101010101';	
			$saldoawal= 4687041;
			$url = 'kas';
		} elseif ($akun == 'mandiri') {
			$id_akun = '101010201';
			$saldoawal = 213381864.81;
			$url = 'mandiri';
		} elseif ($akun == 'bri') {
			$id_akun = '101010204';
			$saldoawal = 108631624;
			$url = 'bri';
		}

		$opex = $this->saldo_model->getJurnalByAkun($id_akun);
		$saldo = $opex[0]->saldo + $saldoawal;

		if ($akun == 'kas') {	
			$this->db->set('kaskecil', $saldo);
			$this->db->where('perioda', date("M Y", mktime(0, 0, 0, date('m'), 0, date('Y'))));	
			$this->db->update('saldokasbank');
		} elseif ($akun == 'mandiri') {
			$this->db->set('mandiri', $saldo);
			$this->db->where('perioda', date("M Y", mktime(0, 0, 0, date('m'), 0, date('Y'))));
			$this->db->update('saldokasbank');
		} elseif ($akun == 'bri') {
			$this->db->set('bri', $saldo);
			$this->db->where('perioda', date("M Y", mktime(0, 0, 0, date('m'), 0, date('Y'))));
			$this->db->update('saldokasbank');
		}	

		redirect(base_url('Admin/Saldo/Jurnal/' . $url));
	}
	
	public function jurnal($bank)
	{
		$data = [
			'title' => 'Data Saldo Kas',
			'header' => 'Data Saldo ' . ucfirst($bank), 
		];

		if ($bank == 'kas') {	
			$data['jurnal'] = $this->saldo_model->getKas();
			$data['saldoawal'] = 4687041;
			$data['id_akun'] = '101010101';	
		} elseif ($bank == 'mandiri') {
			$data['jurnal'] = $this->saldo_model->getMandiri();
			$data['saldoawal'] = 213381864.81;
			$data['id_akun'] = '101010201';
		} elseif ($bank == 'bri') {
			$data['jurnal'] = $this->saldo_model->getBri();
			$data['saldoawal'] = 108631624;
			$data['id_akun'] = '101010204';
		}

		$this->template->load('saldo/kas', $data);
	}

	public function KartuPerkiraan(){
		$id_akun = $this->input->get('id_akun') ?? '';
		
		$this->template->load('saldo/kartu_perkiraan', [
			'title' => 'Kartu Perkiraan',
			'header' => 'Kartu Perkiraan',
			'id_akun' => $id_akun,
		]);
	}

	public function kartu_perkiraan_data(){
		$tanggal_awal = $this->input->post('tanggal_awal');
		$tanggal_akhir = $this->input->post('tanggal_akhir');
		$id_akun = $this->input->post('korek');

		$opex = $this->db->query("SELECT SUM(pemasukan) as pemasukan, SUM(pengeluaran) as pengeluaran, `tanggal`, `id_akun`, `id_opex`, SUM(pemasukan - pengeluaran) as saldo FROM opex WHERE tanggal >= '" . $tanggal_awal . "' AND tanggal < '" . $tanggal_akhir . "' AND id_akun = '" . $id_akun . "'  GROUP BY DATE_FORMAT(`tanggal`, '%Y-%m-%d') ORDER BY tanggal ASC")->result();
		$json = [];
		$no = 1;
		$pemasukan = 0;
		$pengeluaran = 0;
		$saldo = 0;
		foreach($opex as $key => $value){
			$no++;
			$data = [];
			$data['no'] = $no;
			$data['id_opex'] = $value->id_opex;
			$data['tanggal'] = $value->tanggal;
			$data['pemasukan'] = $value->pemasukan;
			$data['pengeluaran'] = $value->pengeluaran;
			$data['saldo'] = $value->saldo;
			$data['keterangan'] = ($no == 1) ? "DATA AWAL PERIODA" : "DATA PERKIRAAN";
			$json[] = $data;
			$pemasukan += $value->pemasukan;
			$pengeluaran += $value->pengeluaran;
			$saldo += $value->saldo;
		}

		$json['pengeluaran'] = $pengeluaran;
		$json['pemasukan'] = $pemasukan;
		$json['saldo'] = $saldo;

		$result = [
			'data' => $json,
		];

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}
}
