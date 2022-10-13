<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) . "/laporan/PerhitunganLaporan.php");

class Dashboard extends PerhitunganLaporan {

	public function __construct(){
		parent::__construct();

		$this->load->model('SaldoModel', 'saldo_model');
		$this->load->model('PerhitunganModel', 'perhitungan_model');
		$this->load->model('MitraModel', 'mitra_model');
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

			$this->data['link_active'] = 'Admin/dashboard';

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
		$this->data['title'] = 'Dashboard';
		$this->data['countMitra'] = $this->db->count_all('mitra');
		$this->data['countMitraNormal'] = $this->db->where('tdkbermasalah', 'normal', 'Normal', 'NORMAL')->count_all_results('mitra');
		$this->data['countMitraBermasalah'] = $this->db->where('tdkbermasalah', 'masalah', 'Masalah', 'MASALAH')->count_all_results('mitra');
		$this->data['countMitraKhusus'] = $this->db->where('tdkbermasalah', 'khusus', 'Khusus', 'KHUSUS')->count_all_results('mitra');
		$this->data['countMitraWo'] = $this->db->where('tdkbermasalah', 'wo', 'Wo', 'WO')->count_all_results('mitra');
		$this->data['saldokasbank'] = $this->saldo_model->getSaldo();
		$this->data['data_chart_opex'] = $this->db->query("SELECT SUM(pengeluaran) as pengeluaran, SUM(pemasukan) as pemasukan, Month(tanggal) as month, `tanggal` FROM opex GROUP BY DATE_FORMAT(`tanggal`, '%Y-%m') ORDER BY tanggal ASC")->result();
		$this->data['pemasukan_bulanan'] = 0;
		$this->data['pengeluaran_bulanan'] = 0;

		$pemasukanBulanIni = $this->db->query("SELECT SUM(pemasukan) as pemasukan FROM opex WHERE DATE_FORMAT(`tanggal`, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')")->row()->pemasukan == null ? 0 : $this->db->query("SELECT SUM(pemasukan) as pemasukan FROM opex WHERE DATE_FORMAT(`tanggal`, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')")->row()->pemasukan;
		$pemasukanBulanKemarin = intval($this->db->query("SELECT SUM(pemasukan) as pemasukan FROM opex WHERE DATE_FORMAT(`tanggal`, '%Y-%m') = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%Y-%m')")->row()->pemasukan);

		if($pemasukanBulanIni == 0){
			$this->data['persentase_pemasukan'] = 0;
		}else{
			$this->data['persentase_pemasukan'] = ($pemasukanBulanIni / $pemasukanBulanKemarin) * 100;
		}

		foreach ($this->data['data_chart_opex'] as $key => $value) {
			preg_match('/(\d{1,4}\d{1})/', $this->data['data_chart_opex'][$key]->tanggal, $output_array);
			if ($output_array[0] == date('Y')) {
				$this->data['data_chart_opex'][$key]->pengeluaran = intval($value->pengeluaran);
				$this->data['data_chart_opex'][$key]->pemasukan = intval($value->pemasukan);
				$this->data['pemasukan_bulanan'] += $value->pemasukan;
				$this->data['pengeluaran_bulanan'] += $value->pengeluaran;
			} else {
				unset($this->data['data_chart_opex'][$key]);
			}
		}
		
		if (date('d') == '01') {
			$this->execute();
		}

		$this->template->load('dashboard/index', $this->data);
	}
}
