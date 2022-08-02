<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('SaldoModel', 'saldo_model');
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
		} elseif ($akun == 'mandiri') {
			$id_akun = '101010201';
			$saldoawal = 213381864.81;
		} elseif ($akun == 'bri') {
			$id_akun = '101010204';
			$saldoawal = 108631624;
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

		redirect(base_url('admin/saldo'));
	}

}
