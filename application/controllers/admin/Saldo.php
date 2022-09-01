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

		switch ($id_akun) {
			case '1':
				$id_akun = '0101010101';
				break;

			case '2':
				$id_akun = '0101010201';
				break;

			case '3':
				$id_akun = '0101010204';
				break;
		}

		$data = [];
		$nomor = 1;
		$totpengeluaran = 0;
		$totpemasukan = 0;
		$saldo_akhir = 0;
		$saldo = 0;	

		foreach ($this->saldo_model->get_jurnal_all() as $value) {
			if($value->tanggal >= $tanggal_awal AND $value->tanggal <= $tanggal_akhir){
				if($id_akun == $bank){
					$row['no'] = $nomor;
					$row['id_opex'] = $value->id_opex;
					$row['id_akun'] = $value->id_akun;
					$row['tanggal'] = $value->tanggal;
					$row['pemasukan'] = number_format($value->pemasukan);
					$row['pengeluaran'] = number_format($value->pengeluaran);
					$saldo = $saldo+($value->pemasukan - $value->pengeluaran);
					$row['saldo'] = number_format($saldo);
					$row['deskripsi'] = $value->deskripsi;
					$row['keterangan'] = $value->keterangan;
					$row['nobukti'] = $value->nobukti;
					$row['action'] = '
						<div class="dropdown">
								<a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
									aria-expanded="false">
									<i class="fas fa-ellipsis-v"></i>
								</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<a class="dropdown-item btndelete" id="button_delete_perioda" href="' . base_url('Admin/Jurnal/Destroy/' . str_replace('/', '%', $value->nobukti)) . '"><i
										class="fas fa-trash text-danger pr-2"></i> Delete </a>
								</div>
							</div>
					';

					$data[] = $row;	

					$totpengeluaran += $value->pengeluaran;
					$totpemasukan += $value->pemasukan;
					$saldo_akhir = $value->pemasukan + $value->pengeluaran;
					$selisih = $totpemasukan - $totpengeluaran;
					$nomor++;
				}
			}
		}
	}				
}
