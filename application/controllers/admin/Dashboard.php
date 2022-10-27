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
		$this->_initAwalTahun();
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

		$this->data['countLancar'] = $this->db->query("SELECT COUNT(kolektibilitas) as count FROM mitra WHERE (kolektibilitas = 'lancar' OR kolektibilitas = 'Lancar' OR kolektibilitas = 'LANCAR') AND (tdkbermasalah = 'normal' OR tdkbermasalah = 'Normal' OR tdkbermasalah = 'NORMAL') AND saldopokok > 0")->row();
		$this->data['countKurangLancar'] = $this->db->query("SELECT COUNT(kolektibilitas) as count FROM mitra WHERE (kolektibilitas = 'kurang lancar' OR kolektibilitas = 'Kurang Lancar' OR kolektibilitas = 'KURANG LANCAR') AND (tdkbermasalah = 'normal' OR tdkbermasalah = 'Normal' OR tdkbermasalah = 'NORMAL') AND saldopokok > 0")->row();
		$this->data['countDiragukan'] = $this->db->query("SELECT COUNT(kolektibilitas) as count FROM mitra WHERE (kolektibilitas = 'diragukan' OR kolektibilitas = 'Diragukan' OR kolektibilitas = 'DIRAGUKAN') AND (tdkbermasalah = 'normal' OR tdkbermasalah = 'Normal' OR tdkbermasalah = 'NORMAL') AND saldopokok > 0")->row();
		$this->data['countMacet'] = $this->db->query("SELECT COUNT(kolektibilitas) as count FROM mitra WHERE (kolektibilitas = 'macet' OR kolektibilitas = 'Macet' OR kolektibilitas = 'MACET') AND (tdkbermasalah = 'normal' OR tdkbermasalah = 'Normal' OR tdkbermasalah = 'NORMAL') AND saldopokok > 0")->row();

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

		$this->data['data_piutang_mb'] = $this->_get_data_chart_piutang();

		$this->template->load('dashboard/index', $this->data);
	}

	private function _initAwalTahun(){
		$tahun = date('y');
		$tahunlalu = $tahun - 1;

		$saldoPerioda = array (
			1 =>   'Jan ' . date('Y'),
			'Feb ' . date('Y'),
			'Mar ' . date('Y'),
			'Apr ' . date('Y'),
			'May ' . date('Y'),
			'Jun ' . date('Y'),
			'Jul ' . date('Y'),
			'Aug ' . date('Y'),
			'Sep ' . date('Y'),
			'Oct ' . date('Y'),
			'Nov ' . date('Y'),
			'Dec ' . date('Y')
		);

		if(date('m' == '01') AND ($this->db->table_exists('neraca_'. $tahunlalu))){
			for ($i=1; $i <= count($saldoPerioda); $i++) { 
				$this->db->query("INSERT INTO `saldokasbank` (`id`, `mandiri`, `bri`, `kaskecil`, `perioda`, `updated`, `updated_at`) VALUES (NULL, '0', '0', '0', '" . $saldoPerioda[$i] ."', 'admin', CURRENT_TIMESTAMP)");
			}

			$this->createTableNeraca();
			$this->createTableAktivitas();
			$this->createTableArusKas();
			$this->createTableTingkatPengembalianHasil();
			$this->createTableDanaYangDisalurkan();
			$this->createTableDanaTersedia();
			$this->createTableCatatanAtasLapKeu();
			$this->createTableNeracaSaldo();
			$this->createTableTransposeAgingrate();

		}
	}

	private function createTableNeraca(){
		$tahun = date('y');
		$tahunlalu = $tahun - 1;
		$tahunberikutnya = $tahun + 1;
		$destahunlalu = 'des' . $tahunlalu;
		$deskripsiNeraca = $this->db->query("SELECT `nama` FROM deskripsi_laporan WHERE laporan = 'neraca'")->result_array();
		
		if($this->db->table_exists('neraca_'. $tahunlalu)){
			echo "table neraca_". $tahunlalu ." sudah ada";
		}else{
			$this->db->query("ALTER TABLE `neraca` RENAME TO `neraca_$tahunlalu`");
			$this->db->query("CREATE TABLE `neraca` (
				`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				`id_akun` int(11) NOT NULL,
				`nama_akun` varchar(255) NOT NULL,
				`$destahunlalu` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`jan$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`feb$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`mar$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`apr$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`mei$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`jun$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`jul$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`ags$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`sep$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`okt$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`nop$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`des$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`rkajan$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`rkasdjan$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`realjan$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`realsdjan$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`rkajan$tahunlalu` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`rkasdjan$tahunlalu` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosenjan$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosenfeb$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosenmar$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosenapr$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosenmei$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosenjun$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosenjul$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosenags$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensep$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosenokt$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosennop$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosendes$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdjan$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdfeb$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdmar$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdapr$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdmei$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdjun$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdjul$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdags$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdsep$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdokt$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensdnop$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`prosensddes$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`realmar$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`realsdmar$tahun` decimal(20, 2) NOT NULL DEFAULT '0.00',
				`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

			$neracaDesTahunLalu = $this->db->query("SELECT `$destahunlalu` FROM neraca_" . $tahunlalu)->result_array();
			foreach ($deskripsiNeraca as $key => $desNeraca) {
				$this->db->query("INSERT INTO `neraca` (`id`, `id_akun`, `nama_akun`, `$destahunlalu`) VALUES (NULL, '0', '". $desNeraca['nama'] ."', '" . $neracaDesTahunLalu[$key][$destahunlalu] ."');");
			}
		}
	}

	private function createTableAktivitas(){
		$tahun = date('y');
		$tahunlalu = $tahun - 1;
		$tahunberikutnya = $tahun + 1;
		$destahunlalu = 'des' . $tahunlalu;
		$deskripsiAktivitas = $this->db->query("SELECT `nama` FROM deskripsi_laporan WHERE laporan = 'aktivitas'")->result_array();

		// aktivitas
		if($this->db->table_exists('perubahanasetnetotidakterikat_' . $tahunlalu)){
			// echo "table neraca_". $tahunlalu ." sudah ada";
		} else {
			$this->db->query("ALTER TABLE `perubahanasetnetotidakterikat` RENAME TO `perubahanasetnetotidakterikat_$tahunlalu`");
			$this->db->query(
				"CREATE TABLE `perubahanasetnetotidakterikat` (
					`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					`keterangan` text NOT NULL,
					`nop$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdnop$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`des$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sddes$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`jan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`feb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`mar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`apr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`mei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`jun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`jul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`ags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`okt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`nop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sdnop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`des$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sddes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`rkajan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`rkasdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`realjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`realsdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`rkajan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`rkasdjan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosennop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdnop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosendes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensddes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00'
				  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
			);
			$aktivitasTahunLalu = $this->db->query("SELECT `nop$tahunlalu`, `sdnop$tahunlalu`, `des$tahunlalu` , `sddes$tahunlalu` FROM perubahanasetnetotidakterikat_" . $tahunlalu)->result_array();
			foreach ($deskripsiAktivitas as $key => $desAktivitas) {
				$this->db->query("INSERT INTO `perubahanasetnetotidakterikat` (
					`id`, 
					`keterangan`, 
					`nop$tahunlalu`, 
					`sdnop$tahunlalu`, 
					`des$tahunlalu`, 
					`sddes$tahunlalu`
				) VALUES (
					NULL, 
					'" . $desAktivitas['nama'] ."', 
					'" . $aktivitasTahunLalu[$key]['nop' . $tahunlalu] ."', 
					'" . $aktivitasTahunLalu[$key]['sdnop' . $tahunlalu] ."', 
					'" . $aktivitasTahunLalu[$key]['des' . $tahunlalu] ."', 
					'" . $aktivitasTahunLalu[$key]['sddes' . $tahunlalu] ."'
				);");
			}
		}
	}

	private function createTableArusKas(){
		$tahun = date('y');
		$tahunlalu = $tahun - 1;
		$tahunberikutnya = $tahun + 1;
		$destahunlalu = 'des' . $tahunlalu;
		$deskripsiAruskas = $this->db->query("SELECT `nama` FROM deskripsi_laporan WHERE laporan = 'aruskas'")->result_array();

		if($this->db->table_exists('aktivitasoperasikasditerima_' . $tahunlalu)){
			// echo "table aktivitasoperasikasditerima_". $tahunlalu ." sudah ada";
		} else {
			$this->db->query("ALTER TABLE `aktivitasoperasikasditerima` RENAME TO `aktivitasoperasikasditerima_$tahunlalu`");
			$this->db->query(
			"CREATE TABLE `aktivitasoperasikasditerima` (
				`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				`keterangan` text NOT NULL,
				`nop$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`des$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`feb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`mar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`apr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`mei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`ags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`okt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`nop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`des$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdnop$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sddes$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdnop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sddes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jan$tahunberikutnya` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sdjan$tahunberikutnya` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkajan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkasdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`realjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`realsdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkajan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkasdjan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosennop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdnop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosendes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensddes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00'
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
			);
			$aruskasTahunLalu = $this->db->query("SELECT `nop$tahunlalu`, `des$tahunlalu`, `sdnop$tahunlalu`, `sddes$tahunlalu`, `rkajan$tahunlalu`, `rkasdjan$tahunlalu` FROM aktivitasoperasikasditerima_" . $tahunlalu)->result_array();
			foreach ($deskripsiAruskas as $key => $desAruskas) {
				$this->db->query("INSERT INTO `aktivitasoperasikasditerima` (
					`id`, 
					`keterangan`, 
					`nop$tahunlalu`, 
					`des$tahunlalu`, 
					`sdnop$tahunlalu`, 
					`sddes$tahunlalu`, 
					`rkajan$tahunlalu`, 
					`rkasdjan$tahunlalu`
				) VALUES (
					NULL, 
					'" . $desAruskas['nama'] ."', 
					'" . $aruskasTahunLalu[$key]['nop' . $tahunlalu] ."', 
					'" . $aruskasTahunLalu[$key]['des' . $tahunlalu] ."', 
					'" . $aruskasTahunLalu[$key]['sdnop' . $tahunlalu] ."', 
					'" . $aruskasTahunLalu[$key]['sddes' . $tahunlalu] ."',
					'" . $aruskasTahunLalu[$key]['rkajan' . $tahunlalu] ."', 
					'" . $aruskasTahunLalu[$key]['rkasdjan' . $tahunlalu] ."'
				);");
			}
		}
	}

	private function createTableTingkatPengembalianHasil(){
		$tahun = date('y');
		$tahunlalu = $tahun - 1;
		$tahunberikutnya = $tahun + 1;
		$destahunlalu = 'des' . $tahunlalu;
		$deskripsiTingkatpengembalianHasil = $this->db->query("SELECT `nama` FROM deskripsi_laporan WHERE laporan = 'tingkatpengembalianhasil'")->result_array();

		if($this->db->table_exists('tingkatpengembalianhasil_' . $tahunlalu)){
			// echo "table tingkatpengembalianhasil_". $tahunlalu ." sudah ada";
		} else {
			$this->db->query("ALTER TABLE `tingkatpengembalianhasil` RENAME TO `tingkatpengembalianhasil_$tahunlalu`");
			$this->db->query(
				"CREATE TABLE `tingkatpengembalianhasil` (
				`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				`sektor` text NOT NULL,
				`jan$tahunlalu` int(11) NOT NULL DEFAULT '0.00',
				`prosenjan$tahunlalu` int(11) NOT NULL DEFAULT '0.00',
				`prosensdjan$tahunlalu` int(11) NOT NULL DEFAULT '0.00',
				`okt$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`nop$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`des$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`feb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`mar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`apr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`mei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`ags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`okt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`nop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`des$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosen` int(11) NOT NULL DEFAULT '0.00',
				`timbangjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangdes$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangnop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`timbangdes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkajan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkasdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`realjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`realsdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkajan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkasdjan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosennop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdnop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosendes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensddes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00'
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			");

			$kinerjaTahunLalu = $this->db->query("SELECT `jan$tahunlalu`, `prosenjan$tahunlalu`, `prosensdjan$tahunlalu`, `okt$tahunlalu`, `nop$tahunlalu`, `des$tahunlalu`, `timbangdes$tahunlalu`, `rkajan$tahunlalu`, `rkasdjan$tahunlalu` FROM tingkatpengembalianhasil_" . $tahunlalu)->result_array();
			foreach ($deskripsiTingkatpengembalianHasil as $key => $desKinerja) {
				$this->db->query("INSERT INTO `tingkatpengembalianhasil` (
					`id`, 
					`sektor`, 
					`jan$tahunlalu`, 
					`prosenjan$tahunlalu`, 
					`prosensdjan$tahunlalu`, 
					`okt$tahunlalu`, 
					`nop$tahunlalu`, 
					`des$tahunlalu`, 
					`timbangdes$tahunlalu`, 
					`rkajan$tahunlalu`, 
					`rkasdjan$tahunlalu`
				) VALUES (
					NULL, 
					'" . $desKinerja['nama'] ."', 
					'" . $kinerjaTahunLalu[$key]['jan' . $tahunlalu] ."', 
					'" . $kinerjaTahunLalu[$key]['prosenjan' . $tahunlalu] ."', 
					'" . $kinerjaTahunLalu[$key]['prosensdjan' . $tahunlalu] ."', 
					'" . $kinerjaTahunLalu[$key]['okt' . $tahunlalu] ."',
					'" . $kinerjaTahunLalu[$key]['nop' . $tahunlalu] ."', 
					'" . $kinerjaTahunLalu[$key]['des' . $tahunlalu] ."',
					'" . $kinerjaTahunLalu[$key]['timbangdes' . $tahunlalu] ."',
					'" . $kinerjaTahunLalu[$key]['rkajan' . $tahunlalu] ."',
					'" . $kinerjaTahunLalu[$key]['rkasdjan' . $tahunlalu] ."'
				);");
			}
		}
	}

	private function createTableDanaYangDisalurkan(){
		$tahun = date('y');
		$tahunlalu = $tahun - 1;
		$tahunberikutnya = $tahun + 1;
		$destahunlalu = 'des' . $tahunlalu;
		$deskripsiDanaYangDisalurkan = $this->db->query("SELECT `nama` FROM deskripsi_laporan WHERE laporan = 'danayangdisalurkan'")->result_array();

		if($this->db->table_exists('danayangdisalurkan_' . $tahunlalu)){
			// echo "Table 'danayangdisalurkan_" . $tahun . "' already exists";
		} else {
			$this->db->query("ALTER TABLE `danayangdisalurkan` RENAME TO `danayangdisalurkan_$tahunlalu`");
			$this->db->query(
				"CREATE TABLE `danayangdisalurkan` (
				`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				`sektor` text NOT NULL,
				`rka` decimal(20,2) NOT NULL DEFAULT '0.00',
				`nop$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`des$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jan$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`feb$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`mar$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`apr$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`mei$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`jun$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`jul$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`ags$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`sep$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`okt$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`nop$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`des$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`rkajan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkasdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`realjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`realsdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkajan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkasdjan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjan$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`prosensdjan$tahun` decimal(10,0) NOT NULL DEFAULT '0.00',
				`prosenfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosennop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdnop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosendes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensddes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00'
			  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
			");
			$kinerjaTahunLalu = $this->db->query("SELECT `nop$tahunlalu`, `des$tahunlalu`, `rkajan$tahunlalu`, `rkasdjan$tahunlalu` FROM danayangdisalurkan_" . $tahunlalu)->result_array();
			foreach ($deskripsiDanaYangDisalurkan as $key => $desKinerja) {
				$this->db->query("INSERT INTO `danayangdisalurkan` (
					`id`, 
					`sektor`, 
					`nop$tahunlalu`, 
					`des$tahunlalu`, 
					`rkajan$tahunlalu`, 
					`rkasdjan$tahunlalu`
				) VALUES (
					NULL, 
					'" . $desKinerja['nama'] ."', 
					'" . $kinerjaTahunLalu[$key]['nop' . $tahunlalu] ."', 
					'" . $kinerjaTahunLalu[$key]['des' . $tahunlalu] ."', 
					'" . $kinerjaTahunLalu[$key]['rkajan' . $tahunlalu] ."', 
					'" . $kinerjaTahunLalu[$key]['rkasdjan' . $tahunlalu] ."'
				);");
			}

		}
	}

	private function createTableDanaTersedia(){
		$tahun = date('y');
		$tahunlalu = $tahun - 1;
		$tahunberikutnya = $tahun + 1;
		$destahunlalu = 'des' . $tahunlalu;
		$deskripsiDanaTersedia = $this->db->query("SELECT `nama` FROM deskripsi_laporan WHERE laporan = 'danatersedia'")->result_array();

		if($this->db->table_exists('danatersedia_' . $tahunlalu)){
			// echo "Table 'danatersedia_" . $tahunlalu . "' already exists.<br>";
		} else {
			$this->db->query("ALTER TABLE `danatersedia` RENAME TO `danatersedia_$tahunlalu`");
			$this->db->query(
				"CREATE TABLE `danatersedia` (
				`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				`sektor` text NOT NULL,
				`jan$tahunlalu` int(11) NOT NULL DEFAULT '0.00',
				`nop$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`des$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`feb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`mar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`apr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`mei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`jul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`ags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`sep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`okt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`nop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`des$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkajan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkasdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`realjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`realsdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkajan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`rkasdjan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosensdsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosenokt$tahun` int(11) NOT NULL DEFAULT '0.00',
				`prosensdokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
				`prosennop$tahun` int(11) NOT NULL DEFAULT '0.00',
				`prosensdnop$tahun` int(11) NOT NULL DEFAULT '0.00',
				`prosendes$tahun` int(11) NOT NULL DEFAULT '0.00',
				`prosensddes$tahun` int(11) NOT NULL DEFAULT '0.00'
			  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
			");
			$danaTersediaTahunLalu = $this->db->query("SELECT `jan$tahunlalu`, `nop$tahunlalu`, `des$tahunlalu`, `rkajan$tahunlalu`, `rkasdjan$tahunlalu` FROM danatersedia_" . $tahunlalu)->result_array();
			foreach ($deskripsiDanaTersedia as $key => $desKinerja) {
				$this->db->query("INSERT INTO `danatersedia` (
					`id`, 
					`sektor`, 
					`jan$tahunlalu`, 
					`nop$tahunlalu`, 
					`des$tahunlalu`, 
					`rkajan$tahunlalu`, 
					`rkasdjan$tahunlalu`
				) VALUES (
					NULL, 
					'" . $desKinerja['nama'] ."', 
					'" . $danaTersediaTahunLalu[$key]['jan' . $tahunlalu] ."', 
					'" . $danaTersediaTahunLalu[$key]['nop' . $tahunlalu] ."', 
					'" . $danaTersediaTahunLalu[$key]['des' . $tahunlalu] ."', 
					'" . $danaTersediaTahunLalu[$key]['rkajan' . $tahunlalu] ."', 
					'" . $danaTersediaTahunLalu[$key]['rkasdjan' . $tahunlalu] ."'
				);");
			}
		}
	}

	private function createTableCatatanAtasLapKeu(){
		$tahun = date('y');
		$tahunlalu = $tahun - 1;
		$tahunberikutnya = $tahun + 1;
		$destahunlalu = 'des' . $tahunlalu;
		$deskripsiCatatan = $this->db->query("SELECT `nama` FROM deskripsi_laporan WHERE laporan = 'catatan'")->result_array();

		if($this->db->table_exists('catatanataslapkeu_' . $tahunlalu)){
			// echo "catatanataslapkeu_" . $tahunlalu . " sudah ada"; 
		} else {
			$this->db->query("ALTER TABLE `catatanataslapkeu` RENAME TO `catatanataslapkeu_$tahunlalu`");
			$this->db->query(
				"CREATE TABLE `catatanataslapkeu` (
					`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					`keterangan` text NOT NULL,
					`nop$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`des$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`jan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`feb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`mar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`apr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`mei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`jun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`jul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`ags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`sep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`okt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`nop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`des$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`rkajan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`rkasdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`realjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`realsdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`rkajan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`rkasdjan$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosenokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosennop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensdnop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosendes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`prosensddes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00'
				  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
			");
			$catatanTahunLalu = $this->db->query("SELECT `nop$tahunlalu`, `des$tahunlalu`, `rkajan$tahunlalu`, `rkasdjan$tahunlalu` FROM catatanataslapkeu_" . $tahunlalu)->result_array();
			foreach ($deskripsiCatatan as $key => $desCatatan) {
				$this->db->query("INSERT INTO `catatanataslapkeu` (
					`id`, 
					`keterangan`, 
					`nop$tahunlalu`,
					`des$tahunlalu`,
					`rkajan$tahunlalu`,
					`rkasdjan$tahunlalu`
				) VALUES (
					NULL, 
					'" . $desCatatan['nama'] ."', 
					'" . $catatanTahunLalu[$key]['nop' . $tahunlalu] ."', 
					'" . $catatanTahunLalu[$key]['des' . $tahunlalu] ."', 
					'" . $catatanTahunLalu[$key]['rkajan' . $tahunlalu] ."', 
					'" . $catatanTahunLalu[$key]['rkasdjan' . $tahunlalu] ."'
				);");
			}
		}
	}

	private function createTableNeracaSaldo(){
		$tahun = date('y');
		$tahunlalu = $tahun - 1;
		$tahunberikutnya = $tahun + 1;
		$destahunlalu = 'des' . $tahunlalu;

		if($this->db->table_exists('neracasaldo_' . $tahunlalu)){
			// echo "neracasaldo_" . $tahunlalu . " sudah ada";
		} else {
			$this->db->query("ALTER TABLE `neracasaldo` RENAME TO `neracasaldo_$tahunlalu`");
			$this->db->query(
				"CREATE TABLE `neracasaldo` (
					`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					`id_akun` int(11) NOT NULL,
					`nama_akun` text NOT NULL,
					`des$tahunlalu` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`kreditjan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`saldojan$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`kreditfeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`saldofeb$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`kreditmar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`saldomar$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`kreditapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`saldoapr$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`kreditmei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`saldomei$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`kreditjun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`saldojun$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`kreditjul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`saldojul$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`kreditags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`saldoags$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`kreditsep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`saldosep$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetokt$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetnop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`kreditnop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`saldonop$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`debetdes$tahun` decimal(20,2) NOT NULL DEFAULT '0.00',
					`tglUpdate` date NOT NULL,
					`selisih` int(11) NOT NULL DEFAULT '0.00'
				  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
			");

			$neracasaldoTahunLalu = $this->db->query("SELECT `id_akun`, `nama_akun`, `saldodes$tahunlalu` FROM neracasaldo_" . $tahunlalu)->result_array();
			foreach ($neracasaldoTahunLalu as $key => $saldo) {
				$this->db->query("INSERT INTO `catatanataslapkeu` (
					`id`, 
					`id_akun`, 
					`nama_akun`,
					`des$tahunlalu`,
				) VALUES (
					NULL, 
					'" . $saldo['id_akun'] ."', 
					'" . $saldo['nama_akun'] ."', 
					'" . $saldo['saldodes' . $tahunlalu] ."',
				);");
			}
		}
	}

	private function createTableTransposeAgingrate(){
		$tahun = date('y');
		$tahunlalu = $tahun - 1;
		$tahunberikutnya = $tahun + 1;
		$destahunlalu = 'des' . $tahunlalu;

		if($this->db->table_exists('transposeagingrate_' . $tahunlalu)){
			// echo "Table transposeagingrate_" . $tahunlalu . " already exists";
		} else {
			$this->db->query("ALTER TABLE `transposeagingrate` RENAME TO `transposeagingrate_$tahunlalu`");
			$this->db->query(
				"CREATE TABLE `transposeagingrate` (
					`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					`bulan` date NOT NULL,
					`lancar` decimal(12,2) NOT NULL,
					`kuranglancar` decimal(12,2) NOT NULL,
					`diragukan` decimal(12,2) NOT NULL,
					`macet` decimal(12,2) NOT NULL,
					`selisih` decimal(12,2) NOT NULL,
					`jumlah` decimal(12,2) NOT NULL,
					`lankekrglan` decimal(12,10) NOT NULL,
					`krglankediragu` decimal(12,10) NOT NULL,
					`diragukemacet` decimal(12,10) NOT NULL,
					`prodeflancar` decimal(12,10) NOT NULL,
					`prodefkuranglancar` decimal(12,10) NOT NULL
				  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			");
			$no = 1;
			$transposeAgingRateTahunLalu = $this->db->query("SELECT * FROM transposeagingrate_" . $tahunlalu)->result_array();
			foreach ($transposeAgingRateTahunLalu as $key => $agingrate) {
				if($no > 12){
					$bulan = $agingrate['bulan'];
					$lancar = $agingrate['lancar'];
					$kuranglancar = $agingrate['kuranglancar'];
					$diragukan = $agingrate['diragukan'];
					$macet = $agingrate['macet'];

					if($no == 13) {
						$selisih=0;
					} else {
						$selisih=$agingrate['selisih'];  
					}
					
					$jumlah = $agingrate['jumlah'];
					$lankekrglan = $agingrate['lankekrglan'];
					$krglankediragu = $agingrate['krglankediragu'];
					$diragukemacet = $agingrate['diragukemacet'];
					$prodeflancar = $agingrate['prodeflancar'];
					$prodefkuranglancar = $agingrate['prodefkuranglancar'];
					$noid = $no-12;

					$this->db->query("INSERT INTO `transposeagingrate`(`id`, `bulan`, `lancar`, `kuranglancar`, `diragukan`, `macet`, `selisih`, `jumlah`, `lankekrglan`, `krglankediragu`, `diragukemacet`, `prodeflancar`, `prodefkuranglancar`) 
					VALUES ('$noid','$bulan','$lancar','$kuranglancar','$diragukan','$macet','$selisih','$jumlah','$lankekrglan','$krglankediragu','$diragukemacet','$prodeflancar','$prodefkuranglancar')");
				}

				$no++;
			}

			$no = 1;

			foreach ($transposeAgingRateTahunLalu as $key => $agingrate) {
				if($no > 12){
					if($no==13) {
						$hari_ini = date("Y-m-d");
						//  $tglawal = date('Y-m-01', strtotime($hari_ini));
						$tglakhir = date('Y-m-t', strtotime($hari_ini));
					} else {
						$hari_ini= date('Y-m-d', strtotime('+1 days', strtotime($tglakhir))); 
						$tglakhir= date('Y-m-t', strtotime($hari_ini)); 
					}

					$bulan=$tglakhir;
					$lancar=0;
					$kuranglancar=0;
					$diragukan=0;
					$macet=0;
					$selisih=0;
					
					$jumlah=0;
					$lankekrglan=0;
					$krglankediragu=0;
					$diragukemacet=0;
					$prodeflancar=0;
					$prodefkuranglancar=0;

					$noid=$no;

					$this->db->query("INSERT INTO `transposeagingrate`(`id`, `bulan`, `lancar`, `kuranglancar`, `diragukan`, `macet`, `selisih`, `jumlah`, `lankekrglan`, `krglankediragu`, `diragukemacet`, `prodeflancar`, `prodefkuranglancar`) 
					VALUES ('$noid','$bulan','$lancar','$kuranglancar','$diragukan','$macet','$selisih','$jumlah','$lankekrglan','$krglankediragu','$diragukemacet','$prodeflancar','$prodefkuranglancar')");
				}

				$no++;
			}
		}
	}

	private function _get_data_chart_piutang(){
		$bulan = array (
			1 =>   'jan' . date('y'),
			'feb' . date('y'),
			'mar' . date('y'),
			'apr' . date('y'),
			'mei' . date('y'),
			'jun' . date('y'),
			'jul' . date('y'),
			'ags' . date('y'),
			'sep' . date('y'),
			'okt' . date('y'),
			'nov' . date('y'),
			'des' . date('y')
		);

		$bulan_ini = [];
		for ($i=1; $i <= (int)ltrim(date('m', mktime(0, 0, 0, date('m'), 0, 0)), '0'); $i++) { 
			$bulan_ini[] = $bulan[$i];
		}

		$piutangMB = [];
		$piutangMBLancar = [];
		$piutangMBKurangLancar = [];
		$piutangMBDiragukan = [];
		$piutangMBMacet = [];

		for ($i=0; $i < count($bulan_ini); $i++) {
			$piutangMB[$i + 1] = $this->db->query("SELECT `$bulan_ini[$i]` as piutangMB FROM `neraca` WHERE `id`='3'")->row()->piutangMB;
			$piutangMBLancar[$i + 1] = $this->db->query("SELECT `$bulan_ini[$i]` as piutangMBLancar FROM `tingkatpengembalianhasil` WHERE `id`='1'")->row()->piutangMBLancar;
			$piutangMBKurangLancar[$i + 1] = $this->db->query("SELECT `$bulan_ini[$i]` as piutangMBKurangLancar FROM `tingkatpengembalianhasil` WHERE `id`='2'")->row()->piutangMBKurangLancar;
			$piutangMBDiragukan[$i + 1] = $this->db->query("SELECT `$bulan_ini[$i]` as piutangMBDiragukan FROM `tingkatpengembalianhasil` WHERE `id`='3'")->row()->piutangMBDiragukan;
			$piutangMBMacet[$i + 1] = $this->db->query("SELECT `$bulan_ini[$i]` as piutangMBMacet FROM `tingkatpengembalianhasil` WHERE `id`='4'")->row()->piutangMBMacet;
		}

		return ['piutangMB' => $piutangMB,
		'piutangMBLancar' => $piutangMBLancar,
		'piutangMBKurangLancar' => $piutangMBKurangLancar,
		'piutangMBDiragukan' => $piutangMBDiragukan,
		'piutangMBMacet' => $piutangMBMacet];
	}
}
