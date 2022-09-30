<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('SaldoModel', 'saldo_model');
		$this->load->model('JurnalModel', 'jurnal_model');

		$this->load->library('tank_auth');

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$this->data['dataUser'] = $this->session->userdata('data_ldap');

			$this->data['user_id'] = $this->tank_auth->get_user_id();
			$this->data['username'] = $this->tank_auth->get_username();
			$this->data['email'] = $this->tank_auth->get_email();

			$profile = $this->tank_auth->get_user_profile($this->data['user_id']);

			$this->data['profile_name'] = $profile['name'];
			$this->data['profile_foto'] = $profile['foto'];

			foreach ($this->tank_auth->get_roles($this->data['user_id']) as $val) {
				$this->data['role_id'] = $val['role_id'];
				$this->data['role'] = $val['role'];
				$this->data['full_name_role'] = $val['full'];
			}

			$this->data['link_active'] = 'Admin/Saldo';

			//buat permission
			if (!$this->tank_auth->permit($this->data['link_active'])) {
				redirect('Home');
			}

			$this->load->model("ShowmenuModel", 'showmenu_model');
			$this->data['ShowMenu'] = $this->showmenu_model->getShowMenu();

			$OpenShowMenu = $this->showmenu_model->getOpenShowMenu($this->data);

			$this->data['openMenu'] = $this->showmenu_model->getDataOpenMenu($OpenShowMenu->id_menu_parent);
		}
	}

	public function index()
	{
		$this->data['title'] = 'Data Saldo Kas Dan Bank';
		$this->data['header'] = 'Data Saldo';
		$this->data['saldokasbank'] = $this->saldo_model->getSaldo();
		
		$this->template->load('saldo/index', $this->data);
    }

	public function updateSaldo(){
		$totpengeluaranX=0; 
		$totpemasukanX=0;
		$saldokaskecil= 4687041;
		$saldomandiri = 213381864.81;
		$saldobri = 108631624;

		$kasjurnal = $this->db->query("SELECT * FROM opex  WHERE id_akun='101010101' ORDER BY tanggal ASC ")->result_array();
		foreach($kasjurnal as $kas){
			if($kas['tanggal']>='2022-01-01' AND $kas['tampil']=='0'){
				$totpengeluaranX += $kas['pengeluaran']; 
                $totpemasukanX += $kas['pemasukan'];
                $saldokaskecil += $kas['pemasukan']-$kas['pengeluaran'];
			}
		}

		$kasmandiri = $this->db->query("SELECT * FROM opex  WHERE id_akun='101010201' ORDER BY tanggal ASC ")->result_array();
		foreach($kasmandiri as $mandiri){
			if($mandiri['tanggal']>='2022-01-01' AND $mandiri['tampil']=='0'){
				$totpengeluaranX += $mandiri['pengeluaran']; 
                $totpemasukanX += $mandiri['pemasukan'];
                $saldomandiri += $mandiri['pemasukan']-$mandiri['pengeluaran'];
			}
		}

		$kasbri = $this->db->query("SELECT * FROM opex  WHERE id_akun='101010204' ORDER BY tanggal ASC ")->result_array();
		foreach($kasbri as $bri){
			if($bri['tanggal']>='2022-01-01' AND $bri['tampil']=='0'){
				$totpengeluaranX += $bri['pengeluaran']; 
                $totpemasukanX += $bri['pemasukan'];
                $saldobri += $bri['pemasukan']-$bri['pengeluaran'];
			}
		}

		$this->db->set('kaskecil', $saldokaskecil);
		$this->db->set('mandiri', $saldomandiri);
		$this->db->set('bri', $saldobri);
		$this->db->where('perioda', date("M Y", mktime(0, 0, 0, date('m'), 0, date('Y'))));	
		$this->db->update('saldokasbank');
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

		$this->updateSaldo();

		redirect(base_url('Admin/Saldo/Jurnal/' . $url));
	}
	
	public function jurnal($bank)
	{
		$this->data['title'] = 'Data Saldo Kas';
		$this->data['header'] = 'Data Saldo ' . ucfirst($bank);

		if ($bank == 'kas') {	
			$this->data['jurnal'] = $this->saldo_model->getKas();
			$this->data['saldoawal'] = 4687041;
			$this->data['id_akun'] = '101010101';	
		} elseif ($bank == 'mandiri') {
			$this->data['jurnal'] = $this->saldo_model->getMandiri();
			$this->data['saldoawal'] = 213381864.81;
			$this->data['id_akun'] = '101010201';
		} elseif ($bank == 'bri') {
			$this->data['jurnal'] = $this->saldo_model->getBri();
			$this->data['saldoawal'] = 108631624;
			$this->data['id_akun'] = '101010204';
		}

		$this->template->load('saldo/kas', $this->data);
	}

	public function KartuPerkiraan(){
		$id_akun = $this->input->get('id_akun') ?? '';
		$this->data['title'] = 'Kartu Perkiraan';
		$this->data['header'] = 'Kartu Perkiraan';
		$this->data['id_akun'] = $id_akun;
		$this->template->load('saldo/kartu_perkiraan', $this->data);
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

		$result = [
			'data' => $json,
			'pengeluaran' => $pengeluaran,
			'pemasukan' => $pemasukan,
			'saldo' => $saldo,
		];

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}
}
