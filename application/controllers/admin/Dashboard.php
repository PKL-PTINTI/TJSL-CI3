<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;
use GuzzleHttp\Client;

class Dashboard extends CI_Controller {

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

			$this->data['link_active'] = 'Admin/Dashboard';

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
		
		$this->template->load('dashboard/index', $this->data);
	}

	public function HitungLaporanData(){
		$mitra = $this->mitra_model->getMitra();
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		$periodabln = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-2, date("d"), date("Y"))));
		$no = 1;

		$totnilsaldopokok_bermasalah = 0; $totsektorindustribermasalah = 0; $totsektorindustribermasalah = 0; $totsektorperdaganganbermasalah = 0; $totsektorpertanianbermasalah = 0; $totsektorperkebunanbermasalah = 0; $totsektorperikananbermasalah = 0; $totsektorpeternakanbermasalah = 0; $totsektorjasabermasalah = 0; $totsektorlainlainbermasalah = 0;
		
		foreach ($mitra as $key => $value) {
			if(($value->tdkbermasalah == 'masalah' || $value->tdkbermasalah == 'Masalah' || $value->tdkbermasalah == 'MASALAH') AND $value->saldopokok > '0'){
				$totnilsaldopokok_bermasalah += $value->saldopokok;
				$no++;

				if($value->sektorUsaha == 'Sektor Industri'){
					$totsektorindustribermasalah += $value->saldopokok;
				}
				if($value->sektorUsaha == 'Sektor Perdagangan'){
					$totsektorperdaganganbermasalah += $value->saldopokok;
				}
				if($value->sektorUsaha == 'Sektor Pertanian'){
					$totsektorpertanianbermasalah += $value->saldopokok;
				}
				if($value->sektorUsaha == 'Sektor Perkebunan'){
					$totsektorperkebunanbermasalah += $value->saldopokok;
				}
				if($value->sektorUsaha == 'Sektor Perikanan'){
					$totsektorperikananbermasalah += $value->saldopokok;
				}
				if($value->sektorUsaha == 'Sektor Peternakan'){
					$totsektorpeternakanbermasalah += $value->saldopokok;
				}
				if($value->sektorUsaha == 'Sektor Jasa'){
					$totsektorjasabermasalah += $value->saldopokok;
				}
				if($value->sektorUsaha == 'Sektor Lain-lain'){
					$totsektorlainlainbermasalah += $value->saldopokok;
				}
			}
		}

		$this->db->query("UPDATE neraca SET $perioda='$totnilsaldopokok_bermasalah' WHERE id='11'");
		$alokPenyisihanPiutangbermasalah = 0 - $totnilsaldopokok_bermasalah;
		$this->db->query("UPDATE neraca SET $perioda='$alokPenyisihanPiutangbermasalah' WHERE id='12'");

		$nox = 1;
		$KelebihanPembayaranAngsuranMitra = 0; $pengembalianPinjamanMB = 0; $totnilsaldopokoktdkbermasalah = 0; $totallancar = 0; $totalkuranglancar = 0; $totaldiragukan = 0; $totalmacet = 0;
		$totsektorindustri = 0; $totindustriLancar = 0; $totindustriKurangLancar = 0; $totindustriDiragukan = 0; $totindustriMacet = 0;
		$totsektorperdagangan = 0; $totperdaganganLancar = 0; $totperdaganganKurangLancar = 0; $totperdaganganDiragukan = 0; $totperdaganganMacet = 0;
		$totsektorpertanian = 0; $totpertanianLancar = 0; $totpertanianKurangLancar = 0; $totpertanianDiragukan = 0; $totpertanianMacet = 0;
		$totsektorperkebunan = 0; $totperkebunanLancar = 0; $totperkebunanKurangLancar = 0; $totperkebunanDiragukan = 0; $totperkebunanMacet = 0;
		$totsektorperikanan = 0; $totperikananLancar = 0; $totperikananKurangLancar = 0; $totperikananDiragukan = 0; $totperikananMacet = 0;
		$totsektorpeternakan = 0; $totpeternakanLancar = 0; $totpeternakanKurangLancar = 0; $totpeternakanDiragukan = 0; $totpeternakanMacet = 0;
		$totsektorjasa = 0; $totjasaLancar = 0; $totjasaKurangLancar = 0; $totjasaDiragukan = 0; $totjasaMacet = 0;
		$totsektorlainlain = 0; $totlainlainLancar = 0; $totlainlainKurangLancar = 0; $totlainlainDiragukan = 0; $totlainlainMacet = 0;

		$AktivaTetapHargaPerolehanInventarisKantor=40478000;  //fixed  
		$akumPenyusutanInvPeralatan=-40478000;//fixed
		$JumlahAsetTetapBersih=$BebanAdmdanUmumBL=0; //fixed

		$KasBankYgDiBatasiPenggunaannyaklr = 0; $KasBankYgDiBatasiPenggunaannyamsk = 0; $KasBankYgDiBatasiPenggunaannya = 0; $JasaAdmPinjamanklr = 0; $JasaAdmPinjamanmsk = 0; $JasaAdmPinjaman = 0; $AktivaTetapHargaPerolehanklr = 0; $AktivaTetapHargaPerolehanmsk = 0; $AktivaTetapHargaPerolehan = 0; $PengembalianKelebihanAngsuranklr = 0; $PengembalianKelebihanAngsuranmsk = 0; $PengembalianKelebihanAngsuran = 0; $BebanUpahTenagakerjaklr = 0; $BebanUpahTenagakerjamsk = 0;
		$BebanUpahTenagakerja = 0; $BebanPembinaanmsk = 0; $BebanPembinaanklr = 0; $BebanPembinaan = 0; $pengembalianPinjamanMBklr = 0; $pengembalianPinjamanMBmsk = 0; $pengembalianPinjamanMB = 0; $pengembalianPinjamanMBbermasalahklr = 0; $pengembalianPinjamanMBbermasalahmsk = 0; $pengembalianPinjamanMBbermasalah = 0; $PiutangMitraBinaanPinjamanmsk = 0; $PiutangMitraBinaanPinjamanklr = 0; $PiutangMitraBinaanPinjaman = 0; $PiutangMitraBinaanPinjamanindustrimsk = 0;
		$PiutangMitraBinaanPinjamanindustriklr = 0; $PiutangMitraBinaanPinjamanindustri = 0; $PiutangMitraBinaanPinjamanPerdaganganmsk = 0; $PiutangMitraBinaanPinjamanPerdaganganklr = 0; $PiutangMitraBinaanPinjamanPerdagangan = 0; $PiutangMitraBinaanPinjamanPertanianmsk = 0; $PiutangMitraBinaanPinjamanPertanianklr = 0; $PiutangMitraBinaanPinjamanPertanian = 0; $PiutangMitraBinaanPinjamanPerkebunanmsk = 0; $PiutangMitraBinaanPinjamanPerkebunanklr = 0; $PiutangMitraBinaanPinjamanPerkebunan = 0; $PiutangMitraBinaanPinjamanPerikananmsk = 0;
		$PiutangMitraBinaanPinjamanPerikananklr = 0; $PiutangMitraBinaanPinjamanPerikanan = 0; $PiutangMitraBinaanPinjamanPeternakanmsk = 0; $PiutangMitraBinaanPinjamanPeternakanklr = 0; $PiutangMitraBinaanPinjamanPeternakan = 0; $PiutangMitraBinaanPinjamanJasamsk = 0; $PiutangMitraBinaanPinjamanJasaklr = 0; $PiutangMitraBinaanPinjamanJasa = 0; $PiutangMitraBinaanPinjamanLainmsk = 0; $PiutangMitraBinaanPinjamanLainklr = 0; $PiutangMitraBinaanPinjamanLain = 0;
		$PendapatanJasaAdministrasiPinjamanProgramKemitraanklr = 0; $PendapatanJasaAdministrasiPinjamanProgramKemitraanmsk = 0; $PendapatanJasaAdministrasiPinjamanProgramKemitraan = 0; $AktivaLancarPiutangBungaklr = 0; $AktivaLancarPiutangBungamsk = 0; $AktivaLancarPiutangBunga = 0; $PendapatanJasaGiroBLklr = 0; $PendapatanJasaGiroBLmsk = 0; $PendapatanJasaGiroBL = 0; $PendapatanJasaGiroBUMNPeduliklr = 0; $PendapatanJasaGiroBUMNPedulimsk = 0; $PendapatanJasaGiroBUMNPeduli = 0; $PendapatanJasaGiro = 0;
		$PendapatanLainlainklr = 0; $PendapatanLainlainmsk = 0; $PendapatanLainlain = 0; $PendapatanLainPiutangHapusBukuklr = 0; $PendapatanLainPiutangHapusBukumsk = 0; $PendapatanLainPiutangHapusBuku = 0; $PendapatanLainPenyisihanPiutangklr = 0; $PendapatanLainPenyisihanPiutangmsk = 0; $PendapatanLainPenyisihanPiutang = 0; $PendapatanLainLainSelisihKasBankLainklr = 0; $PendapatanLainLainSelisihKasBankLainmsk = 0; $PendapatanLainLainSelisihKasBankLain = 0; $PendapatanLainLainLainklr = 0; $PendapatanLainLainLainmsk = 0; $PendapatanLainLainLain = 0; $PenyisihanAlokasiDanaBUMNPeduliklr = 0;
		$PenyisihanAlokasiDanaBUMNPedulimsk = 0; $PenyisihanAlokasiDanaBUMNPeduli = 0; $PenyisihanANTTBerakhirPemenuhanProgramklr = 0; $PenyisihanANTTBerakhirPemenuhanProgrammsk = 0; $PenyisihanANTTBerakhirPemenuhanProgram = 0; $penyisihanANTTberakhirwaktuklr = 0; $penyisihanANTTberakhirwaktumsk = 0; $penyisihanANTTberakhirwaktu = 0; $DanaPembinaanKemitraanklr = 0; $DanaPembinaanKemitraanmsk = 0; $DanaPembinaanKemitraan = 0; $DanaBinaLingkunganklr = 0; $DanaBinaLingkunganmsk = 0;
		$DanaBinaLingkungan = 0; $BebanAdmDanUmumklr = 0; $BebanAdmDanUmummsk = 0; $BebanAdmDanUmum = 0; $BebanAdmDanUmumPKklr = 0; $BebanAdmDanUmumPKmsk = 0; $BebanAdmDanUmumPK = 0; $BebanAdmDanUmumBLklr = 0; $BebanAdmDanUmumBLmsk = 0; $BebanAdmDanUmumBL = 0; $BebanAdmDanUmumBPeduliklr = 0; $BebanAdmDanUmumBPedulimsk = 0; $BebanAdmDanUmumBPeduli = 0; $BebanPenyusutanAktivaTetapProgramKemitraanklr = 0; $BebanPenyusutanAktivaTetapProgramKemitraanmsk = 0;
		$BebanPenyusutanAktivaTetapProgramKemitraan = 0; $BebanPemeliharaanProgramKemitraanklr = 0; $BebanPemeliharaanProgramKemitraanmsk = 0; $BebanPemeliharaanProgramKemitraan = 0; $BebanPenyisihanPiutangSektorindustriSektorindustriklr = 0; $BebanPenyisihanPiutangSektorindustriSektorindustrimsk = 0; $BebanPenyisihanPiutangSektorindustriSektorindustri = 0; $BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganklr = 0; $BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganmsk = 0; $BebanPenyisihanPiutangSektorPerdaganganSektorPerdagangan = 0; $BebanPenyisihanPiutangSektorPertanianSektorPertanianklr = 0; $BebanPenyisihanPiutangSektorPertanianSektorPertanianmsk = 0; $BebanPenyisihanPiutangSektorPertanianSektorPertanian = 0; $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanklr = 0; $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanmsk = 0;
		$BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunan = 0; $BebanPenyisihanPiutangSektorPerikananSektorPerikananklr = 0; $BebanPenyisihanPiutangSektorPerikananSektorPerikananmsk = 0; $BebanPenyisihanPiutangSektorPerikananSektorPerikanan = 0; $BebanPenyisihanPiutangSektorPeternakanSektorPeternakanklr = 0; $BebanPenyisihanPiutangSektorPeternakanSektorPeternakanmsk = 0; $BebanPenyisihanPiutangSektorPeternakanSektorPeternakan = 0; $BebanPenyisihanPiutangSektorJasaSektorJasaklr = 0; $BebanPenyisihanPiutangSektorJasaSektorJasamsk = 0; $BebanPenyisihanPiutangSektorJasaSektorJasa = 0; $BebanPenyisihanPiutangSektorLainlainSektorLainlainklr = 0; $BebanPenyisihanPiutangSektorLainlainSektorLainlainmsk = 0; $BebanPenyisihanPiutangSektorLainlainSektorLainlain = 0; $BebanLainlainProgramKemitraanklr = 0;
		$BebanLainlainProgramKemitraanmsk = 0; $BebanLainlainProgramKemitraan = 0; $ANTterbebaskanmsk = 0; $ANTterbebaskanklr = 0; $ANTterbebaskan = 0; $ANTPenyisihanBUMNPedulimsk = 0; $ANTPenyisihanBUMNPeduliklr = 0; $ANTPenyisihanBUMNPeduli = 0; $AktivaLancarAlokasiPenyisihanPiutangMitraBinaanmsk = 0; $AktivaLancarAlokasiPenyisihanPiutangMitraBinaanklr = 0; $AktivaLancarAlokasiPenyisihanPiutangMitraBinaan = 0; $AktivaTetapAkumulasiPenyusutanInventarisKant = 0; $KelebihanPembayaranAngsuranklr = 0; $KelebihanPembayaranAngsuranmsk = 0; $KelebihanPembayaranAngsuran = 0; $PengembaliankelebihanAngsuranklr = 0; $PengembaliankelebihanAngsuranmsk = 0; $selisihPengembaliankelebihanAngsuran = 0;
		$AngsuranBelumTeridentifikasimsk = 0; $AngsuranBelumTeridentifikasiklr = 0; $AngsuranBelumTeridentifikasi = 0; $PendapatanPendapatanLainlainLainlainklr = 0; $PendapatanPendapatanLainlainLainlainmsk = 0; $PendapatanPendapatanLainlainLainlain = 0; $KewajibanjangkaPanjangProgramKemitraanmsk = 0; $KewajibanjangkaPanjangProgramKemitraanklr = 0; $KewajibanjangkaPanjangProgramKemitraan = 0; $AktivaLancarPersediaanProgramKemitraanklr = 0; $AktivaLancarPersediaanProgramKemitraanmsk = 0; $AktivaLancarPersediaanProgramKemitraan = 0; $ANTterbebaskanmsk = 0;
		$ANTterbebaskanklr = 0; $ANTterbebaskan = 0; $PenyisihanANTTBerakhirPemenuhanProgrammsk = 0; $PenyisihanANTTBerakhirPemenuhanProgramklr = 0; $PenyisihanANTTBerakhirPemenuhanProgram = 0; $ANTTerbebaskanklr = 0; $ANTTerbebaskanmsk = 0; $ANTTerbebaskan = 0;

		foreach ($mitra as $key => $value) {
			if($value->saldojumlah < '0'){
				$KelebihanPembayaranAngsuranMitra += $value->saldojumlah;
				$pengembalianPinjamanMB += $value->saldojumlah;

				$nox++;
			}

			if(($value->tdkbermasalah == 'normal' || $value->tdkbermasalah == 'Normal' || $value->tdkbermasalah == 'NORMAL') AND $value->saldopokok > '0'){
				$totnilsaldopokoktdkbermasalah += $value->saldopokok;
				
				if($value->kolektibilitas == 'lancar' || $value->kolektibilitas == 'Lancar' || $value->kolektibilitas == 'LANCAR'){
					$totallancar += $value->saldopokok;
				}
				if($value->kolektibilitas == 'kurang lancar' || $value->kolektibilitas == 'Kurang Lancar' || $value->kolektibilitas == 'KURANG LANCAR'){
					$totalkuranglancar += $value->saldopokok;
				}
				if($value->kolektibilitas == 'diragukan' || $value->kolektibilitas == 'Diragukan' || $value->kolektibilitas == 'DIRAGUKAN'){
					$totaldiragukan += $value->saldopokok;
				}
				if($value->kolektibilitas == 'macet' || $value->kolektibilitas == 'Macet' || $value->kolektibilitas == 'MACET'){
					$totalmacet += $value->saldopokok;
				}
			}

			if(($value->tdkbermasalah == 'normal' || $value->tdkbermasalah == 'Normal' || $value->tdkbermasalah == 'NORMAL') AND $value->saldopokok > '0' AND ($value->sektorUsaha == 'Sektor Industri' || $value->sektorUsaha == 'sektor industri')){
				$totsektorindustri += $value->saldopokok;
				// lancar 
				if($value->kolektibilitas == 'lancar' || $value->kolektibilitas == 'Lancar' || $value->kolektibilitas == 'LANCAR'){
					$totindustriLancar += $value->saldopokok;
				}
				// kurang lancar
				if($value->kolektibilitas == 'kurang lancar' || $value->kolektibilitas == 'Kurang Lancar' || $value->kolektibilitas == 'KURANG LANCAR'){
					$totindustriKurangLancar += $value->saldojumlah;
				}

				// diragukan
				if($value->kolektibilitas == 'diragukan' || $value->kolektibilitas == 'Diragukan' || $value->kolektibilitas == 'DIRAGUKAN'){
					$totindustriDiragukan += $value->saldojumlah;
				}

				// macet
				if($value->kolektibilitas == 'macet' || $value->kolektibilitas == 'Macet' || $value->kolektibilitas == 'MACET'){
					$totindustriMacet += $value->saldojumlah;
				}
				
			}

			// Sektor Perdagangan
			if(($value->tdkbermasalah == 'normal' || $value->tdkbermasalah == 'Normal' || $value->tdkbermasalah == 'NORMAL') AND $value->saldopokok > '0' AND ($value->sektorUsaha == 'Sektor Perdagangan' || $value->sektorUsaha == 'sektor perdagangan')){
				$totsektorperdagangan += $value->saldopokok;
				// lancar 
				if($value->kolektibilitas == 'lancar' || $value->kolektibilitas == 'Lancar' || $value->kolektibilitas == 'LANCAR'){
					$totperdaganganLancar += $value->saldojumlah;
				}

				// kurang lancar
				if($value->kolektibilitas == 'kurang lancar' || $value->kolektibilitas == 'Kurang Lancar' || $value->kolektibilitas == 'KURANG LANCAR'){
					$totperdaganganKurangLancar += $value->saldojumlah;
				}

				// diragukan
				if($value->kolektibilitas == 'diragukan' || $value->kolektibilitas == 'Diragukan' || $value->kolektibilitas == 'DIRAGUKAN'){
					$totperdaganganDiragukan += $value->saldojumlah;
				}
				// macet
				if($value->kolektibilitas == 'macet' || $value->kolektibilitas == 'Macet' || $value->kolektibilitas == 'MACET'){
					$totperdaganganMacet += $value->saldojumlah;
				}
			}

			// Sektor Pertanian
			if(($value->tdkbermasalah == 'normal' || $value->tdkbermasalah == 'Normal' || $value->tdkbermasalah == 'NORMAL') AND $value->saldopokok > '0' AND ($value->sektorUsaha == 'Sektor Pertanian' || $value->sektorUsaha == 'sektor pertanian')){
				$totsektorpertanian += $value->saldopokok;
				// lancar 
				if($value->kolektibilitas == 'lancar' || $value->kolektibilitas == 'Lancar' || $value->kolektibilitas == 'LANCAR'){
					$totpertanianLancar += $value->saldojumlah;
				}

				// kurang lancar
				if($value->kolektibilitas == 'kurang lancar' || $value->kolektibilitas == 'Kurang Lancar' || $value->kolektibilitas == 'KURANG LANCAR'){
					$totpertanianKurangLancar += $value->saldojumlah;
				}
				// diragukan
				if($value->kolektibilitas == 'diragukan' || $value->kolektibilitas == 'Diragukan' || $value->kolektibilitas == 'DIRAGUKAN'){
					$totpertanianDiragukan += $value->saldojumlah;
				}
				// macet
				if($value->kolektibilitas == 'macet' || $value->kolektibilitas == 'Macet' || $value->kolektibilitas == 'MACET'){
					$totpertanianMacet += $value->saldojumlah;
				}
			}

			// Sektor Perkebunan
			if(($value->tdkbermasalah == 'normal' || $value->tdkbermasalah == 'Normal' || $value->tdkbermasalah == 'NORMAL') AND $value->saldopokok > '0' AND ($value->sektorUsaha == 'Sektor Perkebunan' || $value->sektorUsaha == 'sektor perkebunan')){
				$totsektorperkebunan += $value->saldopokok;
				// lancar 
				if($value->kolektibilitas == 'lancar' || $value->kolektibilitas == 'Lancar' || $value->kolektibilitas == 'LANCAR'){
					$totperkebunanlancar += $value->saldopokok;
				}
				// kurang lancar
				if($value->kolektibilitas == 'kurang lancar' || $value->kolektibilitas == 'Kurang Lancar' || $value->kolektibilitas == 'KURANG LANCAR'){
					$totperkebunanKurangLancar += $value->saldojumlah;
				}

				// diragukan
				if($value->kolektibilitas == 'diragukan' || $value->kolektibilitas == 'Diragukan' || $value->kolektibilitas == 'DIRAGUKAN'){
					$totperkebunanDiragukan += $value->saldojumlah;
				}

				// macet
				if($value->kolektibilitas == 'macet' || $value->kolektibilitas == 'Macet' || $value->kolektibilitas == 'MACET'){
					$totperkebunanMacet += $value->saldojumlah;
				}
			}

			// Sektor Perikanan
			if(($value->tdkbermasalah == 'normal' || $value->tdkbermasalah == 'Normal' || $value->tdkbermasalah == 'NORMAL') AND $value->saldopokok > '0' AND ($value->sektorUsaha == 'Sektor Perikanan' || $value->sektorUsaha == 'sektor perikanan')){
				$totsektorperikanan += $value->saldopokok;
				// lancar 
				if($value->kolektibilitas == 'lancar' || $value->kolektibilitas == 'Lancar' || $value->kolektibilitas == 'LANCAR'){
					$totperikananLancar += $value->saldojumlah;
				}
				// kurang lancar
				if($value->kolektibilitas == 'kurang lancar' || $value->kolektibilitas == 'Kurang Lancar' || $value->kolektibilitas == 'KURANG LANCAR'){
					$totperikananKurangLancar += $value->saldojumlah;
				}
				// diragukan
				if($value->kolektibilitas == 'diragukan' || $value->kolektibilitas == 'Diragukan' || $value->kolektibilitas == 'DIRAGUKAN'){
					$totperikananDiragukan += $value->saldojumlah;
				}
				// macet
				if($value->kolektibilitas == 'macet' || $value->kolektibilitas == 'Macet' || $value->kolektibilitas == 'MACET'){
					$totperikananMacet += $value->saldojumlah;
				}
			}

			// Sektor Peternakan
			if(($value->tdkbermasalah == 'normal' || $value->tdkbermasalah == 'Normal' || $value->tdkbermasalah == 'NORMAL') AND $value->saldopokok > '0' AND ($value->sektorUsaha == 'Sektor Peternakan' || $value->sektorUsaha == 'sektor peternakan')){
				$totsektorpeternakan += $value->saldopokok;
				// lancar 
				if($value->kolektibilitas == 'lancar' || $value->kolektibilitas == 'Lancar' || $value->kolektibilitas == 'LANCAR'){
					$totpeternakanLancar += $value->saldojumlah;
				}
				// kurang lancar
				if($value->kolektibilitas == 'kurang lancar' || $value->kolektibilitas == 'Kurang Lancar' || $value->kolektibilitas == 'KURANG LANCAR'){
					$totpeternakanKurangLancar += $value->saldojumlah;
				}
				// diragukan
				if($value->kolektibilitas == 'diragukan' || $value->kolektibilitas == 'Diragukan' || $value->kolektibilitas == 'DIRAGUKAN'){
					$totpeternakanDiragukan += $value->saldojumlah;
				}
				// macet
				if($value->kolektibilitas == 'macet' || $value->kolektibilitas == 'Macet' || $value->kolektibilitas == 'MACET'){
					$totpeternakanMacet += $value->saldojumlah;
				}
			}

			// Sektor Jasa
			if(($value->tdkbermasalah == 'normal' || $value->tdkbermasalah == 'Normal' || $value->tdkbermasalah == 'NORMAL') AND $value->saldopokok > '0' AND ($value->sektorUsaha == 'Sektor Jasa' || $value->sektorUsaha == 'sektor jasa')){
				$totsektorjasa += $value->saldopokok;
				// lancar 
				if($value->kolektibilitas == 'lancar' || $value->kolektibilitas == 'Lancar' || $value->kolektibilitas == 'LANCAR'){
					$totjasaLancar += $value->saldojumlah;
				}
				// kurang lancar
				if($value->kolektibilitas == 'kurang lancar' || $value->kolektibilitas == 'Kurang Lancar' || $value->kolektibilitas == 'KURANG LANCAR'){
					$totjasaKurangLancar += $value->saldojumlah;
				}
				// diragukan
				if($value->kolektibilitas == 'diragukan' || $value->kolektibilitas == 'Diragukan' || $value->kolektibilitas == 'DIRAGUKAN'){
					$totjasaDiragukan += $value->saldojumlah;
				}
				// macet
				if($value->kolektibilitas == 'macet' || $value->kolektibilitas == 'Macet' || $value->kolektibilitas == 'MACET'){
					$totjasaMacet += $value->saldojumlah;
				}
			}

			// Sektor Lain-lain
			if(($value->tdkbermasalah == 'normal' || $value->tdkbermasalah == 'Normal' || $value->tdkbermasalah == 'NORMAL') AND $value->saldopokok > '0' AND ($value->sektorUsaha == 'Sektor Lain-lain' || $value->sektorUsaha == 'sektor lain-lain')){
				$totsektorlainlain += $value->saldopokok;
				// lancar 
				if($value->kolektibilitas == 'lancar' || $value->kolektibilitas == 'Lancar' || $value->kolektibilitas == 'LANCAR'){
					$totlainlainLancar += $value->saldojumlah;
				}
				// kurang lancar
				if($value->kolektibilitas == 'kurang lancar' || $value->kolektibilitas == 'Kurang Lancar' || $value->kolektibilitas == 'KURANG LANCAR'){
					$totlainlainKurangLancar += $value->saldojumlah;
				}
				// diragukan
				if($value->kolektibilitas == 'diragukan' || $value->kolektibilitas == 'Diragukan' || $value->kolektibilitas == 'DIRAGUKAN'){
					$totlainlainDiragukan += $value->saldojumlah;
				}
				// macet
				if($value->kolektibilitas == 'macet' || $value->kolektibilitas == 'Macet' || $value->kolektibilitas == 'MACET'){
					$totlainlainMacet += $value->saldojumlah;
				}
			}
		
		}

		$KelebihanPembayaranAngsuranMitra = 0 - $KelebihanPembayaranAngsuranMitra;
		$tingkatpengembalianpinjamanMBLancar = $totallancar;
		$tingkatpengembalianpinjamanMBKurangLancar = $totalkuranglancar;
		$tingkatpengembalianpinjamanMBDiragukan = $totaldiragukan;
		$tingkatpengembalianpinjamanMBMacet = $totalmacet;

		$jurnal = $this->jurnal_model->get_jurnal_all();

		$tglawal = date('Y-m-01', strtotime(date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-01', strtotime(date("d-m-Y"))))))));
		$tglakhir = date('Y-m-01', strtotime(date("d-m-Y")));

		foreach ($jurnal as $key => $value) {
			if($value->tanggal >= $tglawal AND $value->tanggal < $tglakhir AND $value->tampil == '0'){
				// 103070000   Aktiva Lain-lain/Kas Bank Yang Dibatasi Pengunaanya 
				if($value->id_akun == '103070000'){
					$KasBankYgDiBatasiPenggunaannyaklr += $value->pengeluaran; 
					$KasBankYgDiBatasiPenggunaannyamsk += $value->pemasukan; 
					$KasBankYgDiBatasiPenggunaannya = $KasBankYgDiBatasiPenggunaannyaklr - $KasBankYgDiBatasiPenggunaannyamsk;
				}

				// 0403010100   Pendapatan/Jasa Administrasi Pinjaman/Program Kemitraan
				if($value->id_akun == '0403010100'){
					$JasaAdmPinjamanklr += $value->pengeluaran; 
					$JasaAdmPinjamanmsk += $value->pemasukan; 
					$JasaAdmPinjaman = $JasaAdmPinjamanklr - $JasaAdmPinjamanmsk;
				}

				// 102010101   Aktiva Tetap/Harga Perolehan/Kendaraan 
				// 102010201   Aktiva Tetap/Harga Perolehan/Inventaris Kantor
				if($value->id_akun == '102010101' OR $value->id_akun == '102010201'){
					$AktivaTetapHargaPerolehanklr += $value->pengeluaran; 
					$AktivaTetapHargaPerolehanmsk += $value->pemasukan; 
					$AktivaTetapHargaPerolehan = $AktivaTetapHargaPerolehanklr - $AktivaTetapHargaPerolehanmsk;
				}

				//0412020500   Pengembalian kelebihan Angsuran 
				if($value->id_akun == '412020500'){ 
					$PengembalianKelebihanAngsuranklr+=$value->pengeluaran; 
					$PengembalianKelebihanAngsuranmsk+=$value->pemasukan; 
					$PengembalianKelebihanAngsuran=$PengembalianKelebihanAngsuranklr - $PengembalianKelebihanAngsuranmsk;
				}

				//0406010000   Beban Upah Tenaga kerja/Honorer/Program Kemitraan 
				if($value->id_akun == '406010000')//
				{ 
					$BebanUpahTenagakerjaklr+= $value->pengeluaran;
					$BebanUpahTenagakerjamsk+=$value->pemasukan; 
					$BebanUpahTenagakerja=$BebanUpahTenagakerjaklr-$BebanUpahTenagakerjamsk;
				}

				//0405010100   Beban Pembinaan/Beban Survey/Program Kemitraan 
				//0405020100   Beban Pembinaan/Beban Monitoring/Program Kemitraan 
				//0405030100   Beban Pembinaan/Beban Penagihan Pinjaman/Program Kemitraan 
				if($value->id_akun == '405010100' OR $value->id_akun == '405020100' OR $value->id_akun == '405030100')
				{ 
					$BebanPembinaanmsk+=$value->pemasukan; 
					$BebanPembinaanklr+=$value->pengeluaran;             
					$BebanPembinaan=$BebanPembinaanklr-$BebanPembinaanmsk;
				}

				// 101060201   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor industri 
				// 101060202   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Perdagangan 
				// 101060203   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Pertanian 
				// 101060204   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Perkebunan 
				// 101060205   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Perikanan 
				// 101060206   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Peternakan 
				// 101060207   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Jasa 
				// 101060208   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Lain-lain 

				// 103040201   Aktiva Lain-lain/Piutang Bermasalah/Angsuran/Sektor Industri
				// 103040202   Aktiva Lain-lain/Piutang Bermasalah/Angsuran/Sektor Perdagangan
				// 103040203   Aktiva Lain-lain/Piutang Bermasalah/Angsuran/Sektor Pertanian
				// 103040204   Aktiva Lain-lain/Piutang Bermasalah/Angsuran/Sektor Perkebunan
				// 103040205   Aktiva Lain-lain/Piutang Bermasalah/Angsuran/Sektor Perikanan
				// 103040206   Aktiva Lain-lain/Piutang Bermasalah/Angsuran/Sektor Peternakan
				// 103040207  Aktiva Lain-lain/Piutang Bermasalah/Angsuran/Sektor Jasa

				// 103040208   Aktiva Lain-lain/Piutang Bermasalah/Angsuran/Lain-lain

				//pengembalian pinjaman pokok !
				if($value->id_akun == '101060201' OR $value->id_akun == '101060202' OR $value->id_akun == '101060203' OR $value->id_akun == '101060204'
				OR $value->id_akun == '101060205' OR $value->id_akun == '101060206' OR $value->id_akun == '101060207' OR $value->id_akun == '101060208' 
				OR $value->id_akun == '103040201' OR $value->id_akun == '103040202' OR $value->id_akun == '103040203'
				OR $value->id_akun == '103040204' OR $value->id_akun == '103040205' OR $value->id_akun == '103040206'
				OR $value->id_akun == '103040207' OR $value->id_akun == '103040208'
				){ 
					$pengembalianPinjamanMBklr+=$value->pengeluaran; 
					$pengembalianPinjamanMBmsk+=$value->pemasukan; 
					$pengembalianPinjamanMB=$pengembalianPinjamanMBklr-$pengembalianPinjamanMBmsk;      
				}

				if($value->id_akun == '103040201' OR $value->id_akun == '103040202' OR $value->id_akun == '103040203'
				OR $value->id_akun == '103040204' OR $value->id_akun == '103040205' OR $value->id_akun == '103040206'
				OR $value->id_akun == '103040207' OR $value->id_akun == '103040208'
				){ 
					$pengembalianPinjamanMBbermasalahklr+=$value->pengeluaran; 
					$pengembalianPinjamanMBbermasalahmsk+=$value->pemasukan; 
					$pengembalianPinjamanMBbermasalah=$pengembalianPinjamanMBbermasalahklr-$pengembalianPinjamanMBbermasalahmsk;      
				}

				//0101060101   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor industri 
				//0101060102   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Perdagangan 
				//0101060103   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Pertanian 
				//0101060104   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Perkebunan 
				//0101060105   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Perikanan 
				//0101060106   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Peternakan 
				//0101060107   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Jasa 
				//0101060108   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Lain-lain 

				if($value->id_akun == '101060101' OR $value->id_akun == '101060102' OR $value->id_akun == '101060103' OR $value->id_akun == '101060104'
				OR $value->id_akun == '101060105' OR $value->id_akun == '101060106' OR $value->id_akun == '101060107' OR $value->id_akun == '101060108'
				){ 
					$PiutangMitraBinaanPinjamanmsk+=$value->pemasukan; 
					$PiutangMitraBinaanPinjamanklr+=$value->pengeluaran;
					$PiutangMitraBinaanPinjaman=$PiutangMitraBinaanPinjamanklr-$PiutangMitraBinaanPinjamanmsk;         
				}

				if($value->id_akun == '101060101'){ 
					$PiutangMitraBinaanPinjamanindustrimsk+=$value->pemasukan;
					$PiutangMitraBinaanPinjamanindustriklr+=$value->pengeluaran;  
					$PiutangMitraBinaanPinjamanindustri=$PiutangMitraBinaanPinjamanindustriklr-$PiutangMitraBinaanPinjamanindustrimsk;       
				}
				if($value->id_akun == '101060102'){ 
					$PiutangMitraBinaanPinjamanPerdaganganmsk+=$value->pemasukan;         
					$PiutangMitraBinaanPinjamanPerdaganganklr+=$value->pengeluaran;         
					$PiutangMitraBinaanPinjamanPerdagangan=$PiutangMitraBinaanPinjamanPerdaganganklr-$PiutangMitraBinaanPinjamanPerdaganganmsk;       
				
				}
				if($value->id_akun == '101060103'){ 
					$PiutangMitraBinaanPinjamanPertanianmsk+=$value->pemasukan;  
					$PiutangMitraBinaanPinjamanPertanianklr+=$value->pengeluaran;         
					$PiutangMitraBinaanPinjamanPertanian=$PiutangMitraBinaanPinjamanPertanianklr-$PiutangMitraBinaanPinjamanPertanianmsk;
				}
				if($value->id_akun == '101060104'){ 
					$PiutangMitraBinaanPinjamanPerkebunanmsk+=$value->pemasukan; 
					$PiutangMitraBinaanPinjamanPerkebunanklr+=$value->pengeluaran; 
					$PiutangMitraBinaanPinjamanPerkebunan=
					$PiutangMitraBinaanPinjamanPerkebunanklr-
					$PiutangMitraBinaanPinjamanPerkebunanmsk;        
				}
				if($value->id_akun == '101060105'){ 
					$PiutangMitraBinaanPinjamanPerikananmsk+=$value->pemasukan;
					$PiutangMitraBinaanPinjamanPerikananklr+=$value->pengeluaran;         
					$PiutangMitraBinaanPinjamanPerikanan=$PiutangMitraBinaanPinjamanPerikananklr-$PiutangMitraBinaanPinjamanPerikananmsk;
				}
				if($value->id_akun == '101060106'){ 
					$PiutangMitraBinaanPinjamanPeternakanmsk+=$value->pemasukan;
					$PiutangMitraBinaanPinjamanPeternakanklr+=$value->pengeluaran;         
					$PiutangMitraBinaanPinjamanPeternakan=
					$PiutangMitraBinaanPinjamanPeternakanklr-$PiutangMitraBinaanPinjamanPeternakanmsk;
				}
				if($value->id_akun == '101060107'){ 
					$PiutangMitraBinaanPinjamanJasamsk+=$value->pemasukan;
					$PiutangMitraBinaanPinjamanJasaklr+=$value->pengeluaran;
					$PiutangMitraBinaanPinjamanJasa=$PiutangMitraBinaanPinjamanJasaklr-$PiutangMitraBinaanPinjamanJasamsk;         
				}
				if($value->id_akun == '101060108'){ 
					$PiutangMitraBinaanPinjamanLainmsk+=$value->pemasukan;
					$PiutangMitraBinaanPinjamanLainklr+=$value->pengeluaran;
					$PiutangMitraBinaanPinjamanLain=$PiutangMitraBinaanPinjamanLainklr-$PiutangMitraBinaanPinjamanLainmsk;         
				}

				//403010100 Pendapatan/Jasa Administrasi Pinjaman/Program Kemitraan
				if($value->id_akun == '403010100'){
					$PendapatanJasaAdministrasiPinjamanProgramKemitraanklr+=$value->pengeluaran; 
					$PendapatanJasaAdministrasiPinjamanProgramKemitraanmsk+=$value->pemasukan; 
					$PendapatanJasaAdministrasiPinjamanProgramKemitraan=$PendapatanJasaAdministrasiPinjamanProgramKemitraanklr-$PendapatanJasaAdministrasiPinjamanProgramKemitraanmsk;
				}

				//403020100 pendapatan /jasa giro/ program kemitraan
				if($value->id_akun == '403020100')//pendapatan /jasa giro/ program kemitraan
				{
					$AktivaLancarPiutangBungaklr+=$value->pengeluaran; 
					$AktivaLancarPiutangBungamsk+=$value->pemasukan; 
					$AktivaLancarPiutangBunga=$AktivaLancarPiutangBungaklr-$AktivaLancarPiutangBungamsk;
				}

				//403020101 Pendapatan/Jasa Giro/BL
				if($value->id_akun == '403020101')////403020101 Pendapatan/Jasa Giro/BL
				{
					$PendapatanJasaGiroBLklr+=$value->pengeluaran; 
					$PendapatanJasaGiroBLmsk+=$value->pemasukan; 
					$PendapatanJasaGiroBL=$PendapatanJasaGiroBLklr-$PendapatanJasaGiroBLmsk;

				}
				//403020102 Pendapatan/Jasa Giro/BUMN Peduli 403020100???
				if($value->id_akun == '403020102')//403020102 Pendapatan/Jasa Giro/BUMN Peduli
				{
					$PendapatanJasaGiroBUMNPeduliklr+=$value->pengeluaran;
					$PendapatanJasaGiroBUMNPedulimsk+=$value->pemasukan; 
					$PendapatanJasaGiroBUMNPeduli=$PendapatanJasaGiroBUMNPeduliklr-$PendapatanJasaGiroBUMNPedulimsk;
				}

				$PendapatanJasaGiro=($PendapatanJasaGiroBL+$PendapatanJasaGiroBUMNPeduli+$AktivaLancarPiutangBunga);// lap aktivitas


				//0403030100     Pendapatan/Pendapatan Lain-lain/Piutang Hapus Buku 
				//0403030200     Pendapatan/Pendapatan Lain-lain/Penyesuaian Alokasi Penyisihan Piutang 
				//0403030300     Pendapatan/Pendapatan Lain-lain/Selisih Kas & Bank (GAK ADA!)
				//0403030400     Pendapatan/Pendapatan Lain-lain/Lain-lain 
				if($value->id_akun == '403030100' OR $value->id_akun == '403030200' OR $value->id_akun == '403030300' OR $value->id_akun == '403030400')//Aktiva Lancar/Piutang Bunga 
				{
					$PendapatanLainlainklr+=$value->pengeluaran;
					$PendapatanLainlainmsk+=$value->pemasukan; 
					$PendapatanLainlain=$PendapatanLainlainklr-$PendapatanLainlainmsk;

					if($value->id_akun == '403030100'){ 
						$PendapatanLainPiutangHapusBukuklr+=$value->pengeluaran; 
						$PendapatanLainPiutangHapusBukumsk+=$value->pemasukan; 
						$PendapatanLainPiutangHapusBuku=$PendapatanLainPiutangHapusBukuklr-$PendapatanLainPiutangHapusBukumsk;
					}
					if($value->id_akun == '403030200'){ 
						$PendapatanLainPenyisihanPiutangklr+=$value->pengeluaran;
						$PendapatanLainPenyisihanPiutangmsk+=$value->pemasukan; 
						$PendapatanLainPenyisihanPiutang=$PendapatanLainPenyisihanPiutangklr-$PendapatanLainPenyisihanPiutangmsk;
					}
					if($value->id_akun == '403030300' ){ 
						$PendapatanLainLainSelisihKasBankLainklr+=$value->pengeluaran;
						$PendapatanLainLainSelisihKasBankLainmsk+=$value->pemasukan; 
						$PendapatanLainLainSelisihKasBankLain=$PendapatanLainLainSelisihKasBankLainklr-$PendapatanLainLainSelisihKasBankLainmsk;
					}

					if($value->id_akun == '403030400'){ 
						$PendapatanLainLainLainklr+=$value->pengeluaran;
						$PendapatanLainLainLainmsk+=$value->pemasukan; 
						$PendapatanLainLainLain=$PendapatanLainLainLainklr-$PendapatanLainLainLainmsk;
					}

				}

				// 0401030000    Penyisihan/Alokasi Dana BUMN Peduli 
				if($value->id_akun == '401030000'){
					$PenyisihanAlokasiDanaBUMNPeduliklr+=$value->pengeluaran; 
					$PenyisihanAlokasiDanaBUMNPedulimsk+=$value->pemasukan; 
					$PenyisihanAlokasiDanaBUMNPeduli=$PenyisihanAlokasiDanaBUMNPeduliklr-$PenyisihanAlokasiDanaBUMNPedulimsk;
				}

				//401,010,000   Penyisihan/ANTT Berakhir Pemenuhan Program
				if($value->id_akun == '401010000'){ 
					$PenyisihanANTTBerakhirPemenuhanProgramklr+=$value->pengeluaran;
					$PenyisihanANTTBerakhirPemenuhanProgrammsk+=$value->pemasukan;
					$PenyisihanANTTBerakhirPemenuhanProgram=$PenyisihanANTTBerakhirPemenuhanProgramklr-$PenyisihanANTTBerakhirPemenuhanProgrammsk;                        
				}

				if($value->id_akun == '401020000'){
					$penyisihanANTTberakhirwaktuklr+=$value->pengeluaran; 
					$penyisihanANTTberakhirwaktumsk+=$value->pemasukan;
					$penyisihanANTTberakhirwaktu=$penyisihanANTTberakhirwaktuklr-$penyisihanANTTberakhirwaktumsk; 
				}

				//404010101     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor industri 
				//404010102     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Perdagangan 
				//404010103     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Pertanian 
				//404010104     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Perkebunan 
				//404010105     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Perikanan 
				//404010106     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Peternakan 
				//404010107     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Jasa 
				//404010108     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Lain-lain 
				//404010201     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor industri 
				//404010202     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Perdagangan 
				//404010203     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Pertanian 
				//404010204     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Perkebunan 
				//404010205     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Perikanan 
				//404010206     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Peternakan 
				//404010207     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Jasa 
				//404010208     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Lain-lain 
				//404010301     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor industri 
				//404010302     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Perdagangan 
				//404010303     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Pertanian 
				//404010304     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Perkebunan 
				//404010305     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Perikanan 
				//404010306     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Peternakan 
				//404010307     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Jasa 
				//404010308     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Lain-lain 

				if($value->id_akun == '404010101' OR $value->id_akun == '404010102' OR $value->id_akun == '404010103' OR $value->id_akun == '404010104'
				OR $value->id_akun == '404010105' OR $value->id_akun == '404010106' OR $value->id_akun == '404010107' OR $value->id_akun == '404010108' OR
				$value->id_akun == '404010201' OR $value->id_akun == '404010202' OR $value->id_akun == '404010203' OR $value->id_akun == '404010204'
				OR $value->id_akun == '404010205' OR $value->id_akun == '404010206' OR $value->id_akun == '404010207' OR $value->id_akun == '404010208' OR
				$value->id_akun == '0404010301' OR $value->id_akun == '0404010302' OR $value->id_akun == '0404010303' OR $value->id_akun == '0404010304' 
				OR $value->id_akun == '0404010305' OR $value->id_akun == '0404010306' OR $value->id_akun == '0404010307' OR $value->id_akun == '0404010308'

				){ 
					$DanaPembinaanKemitraanklr+=$value->pengeluaran;
					$DanaPembinaanKemitraanmsk+=$value->pemasukan;
					$DanaPembinaanKemitraan= $DanaPembinaanKemitraanklr- $DanaPembinaanKemitraanmsk;                           
				}

				// 404020100     Penyaluran/Dana Bina Lingkungan/Bencana Alam 
				// 404020200     Penyaluran/Dana Bina Lingkungan/Pendidikan & Pelatihan 
				// 404020300     Penyaluran/Dana Bina Lingkungan/Peningkatan Kesehatan 
				// 404020400     Penyaluran/Dana Bina Lingkungan/Sarana dan Prasana Umum 
				// 404020500     Penyaluran/Dana Bina Lingkungan/Sarana Ibadah 
				// 404020600     Penyaluran/Dana Bina Lingkungan/Pelestarian Alam 
				// 404020700     Penyaluran/Dana Bina Lingkungan/BUMN Peduli 
				// 404020800     Pelimpahan Dana Ke Unit PKBL Lain 
				// 404020900     Penyaluran/Dana Bina Lingkungan/Diklat MB PK 
				// 404021000     Penyaluran/Dana Bina Lingkungan/Pengentasan kemiskinan 

				if($value->id_akun == '404020100' OR $value->id_akun == '404020200' OR $value->id_akun == '404020300' OR $value->id_akun == '404020400'
				OR $value->id_akun == '404020500' OR $value->id_akun == '404020600' OR $value->id_akun == '404020700' OR $value->id_akun == '404020800' OR
				$value->id_akun == '404020900' OR $value->id_akun == '404021000' ){ 
					$DanaBinaLingkunganklr+=$value->pengeluaran;  
					$DanaBinaLingkunganmsk+=$value->pemasukan;  
					$DanaBinaLingkungan=$DanaBinaLingkunganklr-$DanaBinaLingkunganmsk;                  
				}

				// 407010000     Beban Adm dan Umum/Program Kemitraan 
				// 407020000     Beban Adm dan Umum/Bina Lingkungan 
				// 407030000     Beban Adm dan Umum/BUMN Peduli 

				if($value->id_akun == '407010000' OR $value->id_akun == '407020000' OR $value->id_akun == '407030000'){ 
					$BebanAdmDanUmumklr=$value->pengeluaran; 
					$BebanAdmDanUmummsk=$value->pemasukan; 
					$BebanAdmDanUmum+=$BebanAdmDanUmummsk-$BebanAdmDanUmumklr;

					if($value->id_akun == '407010000')//
					{ 
						$BebanAdmDanUmumPKklr+=$value->pengeluaran; 
						$BebanAdmDanUmumPKmsk+=$value->pemasukan; 
						$BebanAdmDanUmumPK=$BebanAdmDanUmumPKmsk-$BebanAdmDanUmumPKklr;
					}
					if($value->id_akun == '407020000' )//
					{ 
						$BebanAdmDanUmumBLklr+=$value->pengeluaran; 
						$BebanAdmDanUmumBLmsk+=$value->pemasukan; 
						$BebanAdmDanUmumBL=$BebanAdmDanUmumBLmsk-$BebanAdmDanUmumBLklr;
					}
					if($value->id_akun == '407030000')
					{ 
						$BebanAdmDanUmumBPeduliklr+=$value->pengeluaran; 
						$BebanAdmDanUmumBPedulimsk+=$value->pemasukan; 
						$BebanAdmDanUmumBPeduli=$BebanAdmDanUmumBPedulimsk-$BebanAdmDanUmumBPeduliklr;
					}

				}

				//410,010,000   Beban Penyusutan Aktiva Tetap/Program Kemitraan
				if($value->id_akun == '410010000')//410,010,000 Beban Penyusutan Aktiva Tetap/Program Kemitraan
				{ 
					$BebanPenyusutanAktivaTetapProgramKemitraanklr+=$value->pengeluaran; 
					$BebanPenyusutanAktivaTetapProgramKemitraanmsk+=$value->pemasukan; 
					$BebanPenyusutanAktivaTetapProgramKemitraan=$BebanPenyusutanAktivaTetapProgramKemitraanklr-$BebanPenyusutanAktivaTetapProgramKemitraanmsk;
				}

				if($value->id_akun == '408010000')//408,010,000 Beban Pemeliharaan/Program Kemitraan 
				{ 
					$BebanPemeliharaanProgramKemitraanklr+=$value->pengeluaran; 
					$BebanPemeliharaanProgramKemitraanmsk+=$value->pemasukan; 
					$BebanPemeliharaanProgramKemitraan=$BebanPemeliharaanProgramKemitraanklr-$BebanPemeliharaanProgramKemitraanmsk;
				}

				// 411010100     Beban Penyisihan Piutang/Sektor industri/Sektor industri 
				// 411020200     Beban Penyisihan Piutang/Sektor Perdagangan/Sektor Perdagangan 
				// 411030300     Beban Penyisihan Piutang/Sektor Pertanian/Sektor Pertanian 
				// 411040400     Beban Penyisihan Piutang/Sektor Perkebunan/Sektor Perkebunan 
				// 411050500     Beban Penyisihan Piutang/Sektor Perikanan/Sektor Perikanan 
				// 411060600     Beban Penyisihan Piutang/Sektor Peternakan/Sektor Peternakan 
				// 411070700     Beban Penyisihan Piutang/Sektor Jasa/Sektor Jasa 
				// 411080800     Beban Penyisihan Piutang/Lain-lain/Lain-lain 

				//411010100 Beban Penyisihan Piutang/Sektor industri/Sektor industri
				if($value->id_akun == '411010100'){ 
					$BebanPenyisihanPiutangSektorindustriSektorindustriklr+=$value->pengeluaran; //OK udah benar !
					$BebanPenyisihanPiutangSektorindustriSektorindustrimsk+=$value->pemasukan;
					$BebanPenyisihanPiutangSektorindustriSektorindustri=$BebanPenyisihanPiutangSektorindustriSektorindustriklr-$BebanPenyisihanPiutangSektorindustriSektorindustrimsk;
					}
				//411020200 Beban Penyisihan Piutang/SektorPerdagangan/SektorPerdagangan
				if($value->id_akun == '411020200'){ 
					$BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganklr+=$value->pengeluaran; //OK udah benar !
					$BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganmsk+=$value->pemasukan;
					$BebanPenyisihanPiutangSektorPerdaganganSektorPerdagangan=$BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganklr-$BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganmsk;
				}
				//411030300 Beban Penyisihan Piutang/SektorPertanian/SektorPertanian
				if($value->id_akun == '411030300'){ 
					$BebanPenyisihanPiutangSektorPertanianSektorPertanianklr+=$value->pengeluaran; //OK udah benar !
					$BebanPenyisihanPiutangSektorPertanianSektorPertanianmsk+=$value->pemasukan; 
					$BebanPenyisihanPiutangSektorPertanianSektorPertanian=$BebanPenyisihanPiutangSektorPertanianSektorPertanianklr-$BebanPenyisihanPiutangSektorPertanianSektorPertanianmsk;
				}
				//411040400 Beban Penyisihan Piutang/SektorPerkebunan/SektorPerkebunan
				if($value->id_akun == '411040400'){ 
					$BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanklr+=$value->pengeluaran; //OK udah benar !
					$BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanmsk+=$value->pemasukan;
					$BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunan=$BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanklr-$BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanmsk;
				}
				//411050500 Beban Penyisihan Piutang/SektorPerikanan/SektorPerikanan
				if($value->id_akun == '411050500'){ 
					$BebanPenyisihanPiutangSektorPerikananSektorPerikananklr+=$value->pengeluaran; //OK udah benar !
					$BebanPenyisihanPiutangSektorPerikananSektorPerikananmsk+=$value->pemasukan; 
					$BebanPenyisihanPiutangSektorPerikananSektorPerikanan=$BebanPenyisihanPiutangSektorPerikananSektorPerikananklr-$BebanPenyisihanPiutangSektorPerikananSektorPerikananmsk;
				}
				//411060600 Beban Penyisihan Piutang/SektorPeternakan/SektorPeternakan
				if($value->id_akun == '411060600'){ 
					$BebanPenyisihanPiutangSektorPeternakanSektorPeternakanklr+=$value->pengeluaran; //OK udah benar !
					$BebanPenyisihanPiutangSektorPeternakanSektorPeternakanmsk+=$value->pemasukan; 
					$BebanPenyisihanPiutangSektorPeternakanSektorPeternakan=$BebanPenyisihanPiutangSektorPeternakanSektorPeternakanklr-$BebanPenyisihanPiutangSektorPeternakanSektorPeternakanmsk;
				}
				//411070700 Beban Penyisihan Piutang/SektorJasa/SektorJasa
				if($value->id_akun == '411070700'){ 
					$BebanPenyisihanPiutangSektorJasaSektorJasaklr+=$value->pengeluaran; //OK udah benar !
					$BebanPenyisihanPiutangSektorJasaSektorJasamsk+=$value->pemasukan;
					$BebanPenyisihanPiutangSektorJasaSektorJasa=$BebanPenyisihanPiutangSektorJasaSektorJasaklr-$BebanPenyisihanPiutangSektorJasaSektorJasamsk;
				}
				//411080800 Beban Penyisihan Piutang/SektorLainlain/SektorLainlain
				if($value->id_akun == '411080800'){ 
					$BebanPenyisihanPiutangSektorLainlainSektorLainlainklr+=$value->pengeluaran; //OK udah benar !
					$BebanPenyisihanPiutangSektorLainlainSektorLainlainmsk+=$value->pemasukan;
					$BebanPenyisihanPiutangSektorLainlainSektorLainlain=$BebanPenyisihanPiutangSektorLainlainSektorLainlainklr-$BebanPenyisihanPiutangSektorLainlainSektorLainlainmsk;
				}

				// BEBAN PENYISIHAN PIUTANG BISA DIBACA DARI CALK LANGSUNG TANPA DARI JURNAL

				//CEK BEBAN LAIN

				//0405010100   Beban Pembinaan/Beban Survey/Program Kemitraan 
				//0405020100   Beban Pembinaan/Beban Monitoring/Program Kemitraan 
				//0405030100   Beban Pembinaan/Beban Penagihan Pinjaman/Program Kemitraan 
				//0406010000   Beban Upah Tenaga kerja/Honorer/Program Kemitraan 
				//0407010000   Beban Adm dan Umum/Program Kemitraan 
				//0407020000   Beban Adm dan Umum/Bina Lingkungan 
				//0407030000   Beban Adm dan Umum/BUMN Peduli 
				//0408010000   Beban Pemeliharaan/Program Kemitraan 
				//0409010000   Beban Sewa/Program Kemitraan 
				//0410010000   Beban Penyusutan Aktiva Tetap/Program Kemitraan 
				//0411010100   Beban Penyisihan Piutang/Sektor industri/Sektor industri 
				//0411020200   Beban Penyisihan Piutang/Sektor Perdagangan/Sektor Perdagangan 
				//0411030300   Beban Penyisihan Piutang/Sektor Pertanian/Sektor Pertanian 
				//0411040400   Beban Penyisihan Piutang/Sektor Perkebunan/Sektor Perkebunan 
				//0411050500   Beban Penyisihan Piutang/Sektor Perikanan/Sektor Perikanan 
				//0411060600   Beban Penyisihan Piutang/Sektor Peternakan/Sektor Peternakan 
				//0411070700   Beban Penyisihan Piutang/Sektor Jasa/Sektor Jasa 
				//0411080800   Beban Penyisihan Piutang/Lain-lain/Lain-lain 
				//0412010100   Beban Pajak/PPh 21/PPh 21 
				//0412010101   Beban Pajak/PPh 21/PPh 21/BUMN Peduli 
				//0412020200   Beban Pajak/PPh 23/26/PPh 23/26 
				//0412020300   Beban Pajak/PPh 25/29/PPh 25/29 
				//0412020400   Beban Lain-lain/Program Kemitraan 


				//412020400 Beban Lainlain/Program Kemitraan
				if($value->id_akun == '412020400'){ 
					$BebanLainlainProgramKemitraanklr=$value->pengeluaran; 
					$BebanLainlainProgramKemitraanmsk=$value->pemasukan;
					$BebanLainlainProgramKemitraan=$BebanLainlainProgramKemitraanmsk-$BebanLainlainProgramKemitraanklr;
				}

				//415020000 ANT terbebaskan ANT= Aset Neto Terikat
				if($value->id_akun == '415020000'){ 
					$ANTterbebaskanmsk+=$value->pemasukan;
					$ANTterbebaskanklr+=$value->pengeluaran;
					$ANTterbebaskan=$ANTterbebaskanklr-$ANTterbebaskanmsk;
				}

				//415010000 ANT Penyisihan BUMN Peduli ANT=Aset Neto terikat
				if($value->id_akun == '415010000'){
					$ANTPenyisihanBUMNPedulimsk+=$value->pemasukan; 
					$ANTPenyisihanBUMNPeduliklr+=$value->pengeluaran;
					$ANTPenyisihanBUMNPeduli=$ANTPenyisihanBUMNPeduliklr-$ANTPenyisihanBUMNPedulimsk;
				}

				//Alokasi penyisihan piutang MB start
				//0101070100     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor industri 
				//0101070200     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Perdagangan 
				//0101070300     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Pertanian 
				//0101070400     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Perkebunan 
				//0101070500     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Perikanan 
				//0101070600     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Peternakan 
				//0101070700     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Jasa 
				//0101070800     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Lain-lain 

				if( $value->id_akun == '0101070100' OR  $value->id_akun == '0101070200' OR
				$value->id_akun == '0101070300' OR  $value->id_akun == '0101070400' OR
				$value->id_akun == '0101070500' OR  $value->id_akun == '0101070600' OR
				$value->id_akun == '0101070700' OR  $value->id_akun == '0101070800'){
					$AktivaLancarAlokasiPenyisihanPiutangMitraBinaanmsk+=$value->pemasukan; //OK udah benar !
					$AktivaLancarAlokasiPenyisihanPiutangMitraBinaanklr+=$value->pengeluaran;
					$AktivaLancarAlokasiPenyisihanPiutangMitraBinaan=$AktivaLancarAlokasiPenyisihanPiutangMitraBinaanklr-$AktivaLancarAlokasiPenyisihanPiutangMitraBinaanmsk;
				}
					
				if($value->id_akun == '102020201'){
					$AktivaTetapAkumulasiPenyusutanInventarisKant=0-40478000;//
				}
						
				if($value->id_akun == '201040000'){
					$KelebihanPembayaranAngsuranklr+=$value->pengeluaran;
					$KelebihanPembayaranAngsuranmsk+=$value->pemasukan;
					$KelebihanPembayaranAngsuran=$KelebihanPembayaranAngsuranklr-$KelebihanPembayaranAngsuranmsk; 
				}

				if($value->id_akun == '412020500'){
					$PengembaliankelebihanAngsuranklr+=$value->pengeluaran; //
					$PengembaliankelebihanAngsuranmsk+=$value->pemasukan; //
					$selisihPengembaliankelebihanAngsuran=$PengembaliankelebihanAngsuranklr+$PengembaliankelebihanAngsuranmsk;//laposkeu
				}

				if($value->id_akun == '201050000'){
					$AngsuranBelumTeridentifikasimsk+=$value->pemasukan;
					$AngsuranBelumTeridentifikasiklr+=$value->pengeluaran;
					$AngsuranBelumTeridentifikasi=$AngsuranBelumTeridentifikasiklr-$AngsuranBelumTeridentifikasimsk;
				}

				if($value->id_akun == '403030400')//balance 18  Pendapatan/Pendapatan Lain-lain/Lain-lain
				{
					$PendapatanPendapatanLainlainLainlainklr+=$value->pengeluaran;
					$PendapatanPendapatanLainlainLainlainmsk+=$value->pemasukan;
					$PendapatanPendapatanLainlainLainlain= $PendapatanPendapatanLainlainLainlainklr- $PendapatanPendapatanLainlainLainlainmsk;
				}

				if($value->id_akun == '202010000')//19 Kewajiban jangka Panjang/Program Kemitraan
				{
					$KewajibanjangkaPanjangProgramKemitraanmsk+=$value->pemasukan;
					$KewajibanjangkaPanjangProgramKemitraanklr+=$value->pengeluaran; 
					$KewajibanjangkaPanjangProgramKemitraan= $KewajibanjangkaPanjangProgramKemitraanklr- $KewajibanjangkaPanjangProgramKemitraanmsk;
				}

				if($value->id_akun == '101020100')//balance 19  Aktiva Lancar/Persediaan/Program Kemitraan
				{
					$AktivaLancarPersediaanProgramKemitraanklr+=$value->pengeluaran; //OK udah benar !
					$AktivaLancarPersediaanProgramKemitraanmsk+=$value->pemasukan;
					$AktivaLancarPersediaanProgramKemitraan= $AktivaLancarPersediaanProgramKemitraanklr- $AktivaLancarPersediaanProgramKemitraanmsk;
				}

				if($value->id_akun == '415020000')//22 415020000 ANT terbebaskan 
				{
					$ANTterbebaskanmsk+=$value->pemasukan;
					$ANTterbebaskanklr+=$value->pengeluaran;
					$ANTterbebaskan=$ANTterbebaskanklr-$ANTterbebaskanmsk; 
				}
				

				if($value->id_akun == '412020400')//23 Penyisihan/LAIN LAIN ?????? tanya Wagi
				{
					$PenyisihanANTTBerakhirPemenuhanProgrammsk+=$value->pemasukan;
					$PenyisihanANTTBerakhirPemenuhanProgramklr+=$value->pengeluaran; 
					$PenyisihanANTTBerakhirPemenuhanProgram=$PenyisihanANTTBerakhirPemenuhanProgramklr-$PenyisihanANTTBerakhirPemenuhanProgrammsk;
				}

				if($value->id_akun == '415020000')//balance 23  ANT Terbebaskan ???? balance korek ???
				{
					$ANTTerbebaskanklr+=$value->pengeluaran; 
					$ANTTerbebaskanmsk+=$value->pemasukan;
					$ANTTerbebaskan=$ANTTerbebaskanklr-$ANTTerbebaskanmsk;
				}
			}
		}

		$PiutangMitraBinaanPinjamanindustrisejakAwal = $totsektorindustri;	

		$PiutangMitraBinaanPinjamanPerdagangansejakAwal = $PiutangMitraBinaanPinjamanPerdagangan + $totsektorperdagangan;
		$PiutangMitraBinaanPinjamanPertaniansejakAwal = $PiutangMitraBinaanPinjamanPertanian + $totsektorpertanian;
		$PiutangMitraBinaanPinjamanPerkebunansejakAwal = $PiutangMitraBinaanPinjamanPerkebunan + $totsektorperkebunan;
		$PiutangMitraBinaanPinjamanPerikanansejakAwal = $PiutangMitraBinaanPinjamanPerikanan + $totsektorperikanan;
		$PiutangMitraBinaanPinjamanPeternakansejakAwal = $PiutangMitraBinaanPinjamanPeternakan + $totsektorpeternakan;
		$PiutangMitraBinaanPinjamanJasasejakAwal = $PiutangMitraBinaanPinjamanJasa + $totsektorjasa;
		$PiutangMitraBinaanPinjamanLainsejakAwal = $PiutangMitraBinaanPinjamanLain + $totsektorlainlain;

		$tingkatpengembalianpinjamanMBtotalsejakAwal = $PiutangMitraBinaanPinjamanindustrisejakAwal + 
														$PiutangMitraBinaanPinjamanPerdagangansejakAwal + 
														$PiutangMitraBinaanPinjamanPertaniansejakAwal + 
														$PiutangMitraBinaanPinjamanPerkebunansejakAwal+ 
														$PiutangMitraBinaanPinjamanPerikanansejakAwal + 
														$PiutangMitraBinaanPinjamanPeternakansejakAwal + 
														$PiutangMitraBinaanPinjamanJasasejakAwal +
														$PiutangMitraBinaanPinjamanLainsejakAwal;
		
		$this->_updateSaldo('mandiri');
		$this->_updateSaldo('bri');
		$this->_updateSaldo('kas');

		$saldomandiri = $this->saldo_model->getSaldo()[0]->mandiri;
		$saldobri = $this->saldo_model->getSaldo()[0]->bri;
		$saldokas = $this->saldo_model->getSaldo()[0]->kaskecil;

		$saldoTotBank = $saldomandiri + $saldobri;
		$totKasDanBank = $saldokas + $saldoTotBank;
		
		$this->db->query("UPDATE neraca SET $perioda='$saldokas' WHERE id='1'");
		$this->db->query("UPDATE neraca SET $perioda='$saldoTotBank' WHERE id='2'");

		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$saldokas'  WHERE id='1'"); //kas 
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$saldokas'  WHERE id='2'"); //kas PK 
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$saldoTotBank'  WHERE id='3'");//bank  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$saldomandiri'  WHERE id='4'"); //mandiri 
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$saldobri'  WHERE id='5'");  //BRI
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$KasBankYgDiBatasiPenggunaannya'  WHERE id='6'");  //kas yg dibatasi penggunaan
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$KasBankYgDiBatasiPenggunaannya'  WHERE id='7'");  //kas yg dibatasi penggunaan
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PiutangMitraBinaanPinjamanindustrisejakAwal'  WHERE id='9'"); //industri 
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totsektorperdagangan'  WHERE id='10'"); //perdag
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PiutangMitraBinaanPinjamanPertaniansejakAwal'  WHERE id='11'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PiutangMitraBinaanPinjamanPerkebunansejakAwal'  WHERE id='12'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PiutangMitraBinaanPinjamanPerikanansejakAwal'  WHERE id='13'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PiutangMitraBinaanPinjamanPeternakansejakAwal'  WHERE id='14'");
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totsektorjasa'  WHERE id='15'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PiutangMitraBinaanPinjamanLainsejakAwal'  WHERE id='16'");  //lainlain
		
		$totPiutangMB = $PiutangMitraBinaanPinjamanLainsejakAwal+
						$totsektorjasa+
						$PiutangMitraBinaanPinjamanPeternakansejakAwal+
						$PiutangMitraBinaanPinjamanPerikanansejakAwal+
						$PiutangMitraBinaanPinjamanPerkebunansejakAwal+
						$PiutangMitraBinaanPinjamanPertaniansejakAwal+
						$totsektorperdagangan+
						$PiutangMitraBinaanPinjamanindustrisejakAwal;

		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totPiutangMB'  WHERE id='8'");

		$alokasiPenyisihanPiutangPinjMB = $this->db->query("SELECT $perioda FROM neraca WHERE id='4'")->result_array()[0][$perioda];
		$alokasiPenyisihanPiutangMitraIndustriTdkBermasalah = $this->db->query("SELECT $perioda FROM catatanataslapkeu WHERE id='18'")->result_array()[0][$perioda];
		$alokasiPenyisihanPiutangMitraPerdaganganTdkBermasalah = $this->db->query("SELECT $perioda FROM catatanataslapkeu WHERE id='19'")->result_array()[0][$perioda];
		$alokasiPenyisihanPiutangMitraPertanianTdkBermasalah = $this->db->query("SELECT $perioda FROM catatanataslapkeu WHERE id='20'")->result_array()[0][$perioda];

		$PiutangJasaAdministrasiPinjaman = 0;

		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PiutangJasaAdministrasiPinjaman'  WHERE id='26'");
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PiutangJasaAdministrasiPinjaman'  WHERE id='27'");
		$AktivaTetapHargaPerolehan = 40478000;// selalu fixed !
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$AktivaTetapHargaPerolehan'  WHERE id='28'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$AktivaTetapHargaPerolehan'  WHERE id='29'");  
		$AktivaTetapAkumulasiPenyusutanInventarisKant = 0 - 40478000;
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$AktivaTetapAkumulasiPenyusutanInventarisKant'  WHERE id='30'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$AktivaTetapAkumulasiPenyusutanInventarisKant'  WHERE id='31'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totnilsaldopokok_bermasalah'  WHERE id='32'");
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totsektorindustribermasalah'  WHERE id='33'"); 
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totsektorperdaganganbermasalah'  WHERE id='34'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totsektorpertanianbermasalah'  WHERE id='35'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totsektorperkebunanbermasalah'  WHERE id='36'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totsektorperikananbermasalah'  WHERE id='37'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totsektorpeternakanbermasalah'  WHERE id='38'");
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totsektorjasabermasalah'  WHERE id='39'"); 
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$totsektorlainlainbermasalah'  WHERE id='40'");

		$alok_totnilsaldopokok_bermasalah = 0 - $totnilsaldopokok_bermasalah;
		$alok_totsektorindustribermasalah = 0 - $totsektorindustribermasalah;
		$alok_totsektorperdaganganbermasalah = 0 - $totsektorperdaganganbermasalah;
		$alok_totsektorpertanianbermasalah = 0 - $totsektorpertanianbermasalah;
		$alok_totsektorperkebunanbermasalah = 0 - $totsektorperkebunanbermasalah;
		$alok_totsektorperikananbermasalah = 0 - $totsektorperikananbermasalah;
		$alok_totsektorpeternakanbermasalah = 0 - $totsektorpeternakanbermasalah;
		$alok_totsektorjasabermasalah = 0 - $totsektorjasabermasalah;
		$alok_totsektorlainlainbermasalah = 0 - $totsektorlainlainbermasalah;
		
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$alok_totnilsaldopokok_bermasalah'  WHERE id='42'"); //alok penyisihan piutang bermasalah
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$alok_totsektorindustribermasalah'  WHERE id='43'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$alok_totsektorperdaganganbermasalah'  WHERE id='44'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$alok_totsektorpertanianbermasalah'  WHERE id='45'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$alok_totsektorperkebunanbermasalah'  WHERE id='46'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$alok_totsektorperikananbermasalah'  WHERE id='47'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$alok_totsektorpeternakanbermasalah'  WHERE id='48'");//piutangJasaAdm  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$alok_totsektorjasabermasalah'  WHERE id='49'"); //
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$alok_totsektorlainlainbermasalah'  WHERE id='50'");//lain2

		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$KelebihanPembayaranAngsuranMitra'  WHERE id='52'");

		$AngsuranBelumTeridentifikasijun = $this->db->query("SELECT $periodabln FROM catatanataslapkeu WHERE id='53'")->result_array()[0][$periodabln];
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$AngsuranBelumTeridentifikasijun'  WHERE id='53'");
		$ProgramKemitraan = $AngsuranBelumTeridentifikasijun + $KelebihanPembayaranAngsuranMitra;
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$ProgramKemitraan'  WHERE id='51'");
		$date = strval(date('y') - 1);
		$AktivaBersihAwalPerioda = $this->db->query("SELECT sddes$date FROM perubahanasetnetotidakterikat WHERE id='30'")->result_array()[0]['sddes'.$date];
		
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$AktivaBersihAwalPerioda'  WHERE id='54'");  
    	$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$AktivaBersihAwalPerioda'  WHERE id='55'");

		$Pendapatan = $PendapatanJasaAdministrasiPinjamanProgramKemitraan + 
						$PendapatanJasaGiro+$PendapatanLainPiutangHapusBuku + 
						$PendapatanLainPenyisihanPiutang + 
						$PendapatanLainlain;

		$PendapatanJasaAdministrasiPinjamanProgramKemitraansd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='1'")->result_array()[0]['sd'.$periodabln] + $PendapatanJasaAdministrasiPinjamanProgramKemitraan;
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PendapatanJasaAdministrasiPinjamanProgramKemitraansd'  WHERE id='57'");

		$PendapatanBungasd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='2'")->result_array()[0]['sd'.$periodabln] + $PendapatanJasaGiro;
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PendapatanBungasd'  WHERE id='58'");//  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PendapatanLainPenyisihanPiutang'  WHERE id='60'");//
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PendapatanLainLainLain'  WHERE id='61'");//PK
	
		$BebanAdmDanUmum = 0 - $BebanAdmDanUmum;
		$BebanUmum = $BebanAdmDanUmumBL + $BebanAdmDanUmum;

		$BebanAdmdanUmumsd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='14'")->result_array()[0]['sd'.$periodabln] + $BebanAdmDanUmum;
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda=' $BebanAdmdanUmumsd'  WHERE id='65'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanAdmDanUmumBL'  WHERE id='66'");  
		$BebanUmum = $BebanAdmdanUmumsd + $BebanAdmDanUmumBL;

		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanUmum'  WHERE id='62'");

		$alok_totsektorindustribermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='43'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutangindustriBermasalah = $alok_totsektorindustribermasalah - $alok_totsektorindustribermasalahdes;

		$alokasiPenyisihanMitraindustriTdkBermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='18'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutangindustriTdkBermasalah = $alokasiPenyisihanPiutangMitraIndustriTdkBermasalah - $alokasiPenyisihanMitraindustriTdkBermasalahdes;

		$BebanPenyisihanPiutangindustri = $BebanPenyisihanPiutangindustriBermasalah + $BebanPenyisihanPiutangindustriTdkBermasalah;

		$alok_totsektorperdaganganbermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='44'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutangPerdaganganBermasalah = $alok_totsektorperdaganganbermasalah - $alok_totsektorperdaganganbermasalahdes;

		$alokasiPenyisihanMitraPerdaganganTdkBermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='19'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutangPerdaganganTdkBermasalah = $alokasiPenyisihanPiutangMitraPerdaganganTdkBermasalah - $alokasiPenyisihanMitraPerdaganganTdkBermasalahdes;
		$BebanPenyisihanPiutangperdaganganma22 = $BebanPenyisihanPiutangPerdaganganBermasalah + $BebanPenyisihanPiutangPerdaganganTdkBermasalah;

		$alok_totsektorpertanianbermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='45'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutangpertanianBermasalah = $alok_totsektorpertanianbermasalah - $alok_totsektorpertanianbermasalahdes;

		$alokasiPenyisihanMitrapertanianTdkBermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='20'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutangpertanianTdkBermasalah = $alokasiPenyisihanPiutangMitraPertanianTdkBermasalah - $alokasiPenyisihanMitrapertanianTdkBermasalahdes;
		$BebanPenyisihanPiutangpertanian = $BebanPenyisihanPiutangpertanianBermasalah + $BebanPenyisihanPiutangpertanianTdkBermasalah;

		$alok_totsektorperkebunanbermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='46'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutangperkebunanBermasalah = $alok_totsektorperkebunanbermasalah - $alok_totsektorperkebunanbermasalahdes;

		$alokasiPenyisihanMitraperkebunanTdkBermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='21'")->result_array()[0]['des'.$date];
		$alokasiPenyisihanPiutangMitraPerkebunanTdkBermasalah = $this->db->query("SELECT $perioda FROM catatanataslapkeu WHERE id='21'")->result_array()[0][$perioda];
		$BebanPenyisihanPiutangperkebunanTdkBermasalah = $alokasiPenyisihanPiutangMitraPerkebunanTdkBermasalah - $alokasiPenyisihanMitraperkebunanTdkBermasalahdes;
		$BebanPenyisihanPiutangperkebunan = $BebanPenyisihanPiutangperkebunanBermasalah + $BebanPenyisihanPiutangperkebunanTdkBermasalah;

		$alok_totsektorperikananbermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='47'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutangperikananBermasalah = $alok_totsektorperikananbermasalah - $alok_totsektorperikananbermasalahdes;

		$alokasiPenyisihanMitraperikananTdkBermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='22'")->result_array()[0]['des'.$date];
		$alokasiPenyisihanPiutangMitraPerikananTdkBermasalah = $this->db->query("SELECT $perioda FROM catatanataslapkeu WHERE id='22'")->result_array()[0][$perioda];
		$BebanPenyisihanPiutangperikananTdkBermasalah = $alokasiPenyisihanPiutangMitraPerikananTdkBermasalah - $alokasiPenyisihanMitraperikananTdkBermasalahdes;
		$BebanPenyisihanPiutangperikanan = $BebanPenyisihanPiutangperikananBermasalah + $BebanPenyisihanPiutangperikananTdkBermasalah;

		$alok_totsektorpeternakanbermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='48'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutangpeternakanBermasalah = $alok_totsektorpeternakanbermasalah - $alok_totsektorpeternakanbermasalahdes;

		$alokasiPenyisihanMitrapeternakanTdkBermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='23'")->result_array()[0]['des'.$date];
		$alokasiPenyisihanPiutangMitraPeternakanTdkBermasalah = $this->db->query("SELECT $perioda FROM catatanataslapkeu WHERE id='23'")->result_array()[0][$perioda];
		$BebanPenyisihanPiutangpeternakanTdkBermasalah = $alokasiPenyisihanPiutangMitraPeternakanTdkBermasalah - $alokasiPenyisihanMitrapeternakanTdkBermasalahdes;
		$BebanPenyisihanPiutangpeternakan = $BebanPenyisihanPiutangpeternakanBermasalah + $BebanPenyisihanPiutangpeternakanTdkBermasalah;

		$alok_totsektorjasabermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='49'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutangjasaBermasalah = $alok_totsektorjasabermasalah - $alok_totsektorjasabermasalahdes;

		$alokasiPenyisihanMitrajasaTdkBermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='24'")->result_array()[0]['des'.$date];
		$alokasiPenyisihanPiutangMitraJasaTdkBermasalah = $this->db->query("SELECT $perioda FROM catatanataslapkeu WHERE id='24'")->result_array()[0][$perioda];
		$BebanPenyisihanPiutangjasaTdkBermasalah = $alokasiPenyisihanPiutangMitraJasaTdkBermasalah - $alokasiPenyisihanMitrajasaTdkBermasalahdes;
		$BebanPenyisihanPiutangjasa = $BebanPenyisihanPiutangjasaBermasalah + $BebanPenyisihanPiutangjasaTdkBermasalah;
		$alok_totsektorlainbermasalah = 0;
		$alok_totsektorlainbermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='50'")->result_array()[0]['des'.$date];
		$BebanPenyisihanPiutanglainBermasalah = $alok_totsektorlainbermasalah - $alok_totsektorlainbermasalahdes;
		
		$alokasiPenyisihanMitralainTdkBermasalahdes = $this->db->query("SELECT des$date FROM catatanataslapkeu WHERE id='25'")->result_array()[0]['des'.$date];
		$alokasiPenyisihanPiutangMitraLainTdkBermasalah = $this->db->query("SELECT $perioda FROM catatanataslapkeu WHERE id='25'")->result_array()[0][$perioda];
		$BebanPenyisihanPiutanglainTdkBermasalah = $alokasiPenyisihanPiutangMitraLainTdkBermasalah - $alokasiPenyisihanMitralainTdkBermasalahdes;
		$BebanPenyisihanPiutanglain = $BebanPenyisihanPiutanglainBermasalah + $BebanPenyisihanPiutanglainTdkBermasalah;

		$BebanPenyisihanPiutang = $BebanPenyisihanPiutangindustri+$BebanPenyisihanPiutangperdaganganma22+$BebanPenyisihanPiutangpertanian+$BebanPenyisihanPiutangperkebunan+$BebanPenyisihanPiutangperikanan+$BebanPenyisihanPiutangpeternakan+$BebanPenyisihanPiutangjasa+$BebanPenyisihanPiutanglain; //disimpan ke lap aktivitas juga

		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanPenyisihanPiutang'  WHERE id='67'");//total BebanPenyisihanPiutang  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanPenyisihanPiutangindustri'  WHERE id='68'"); //industri
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanPenyisihanPiutangperdaganganma22'  WHERE id='69'");//
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanPenyisihanPiutangpertanian'  WHERE id='70'"); //
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanPenyisihanPiutangperkebunan'  WHERE id='71'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanPenyisihanPiutangperikanan'  WHERE id='72'");  
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanPenyisihanPiutangpeternakan'  WHERE id='73'");//
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanPenyisihanPiutangjasa'  WHERE id='74'"); //
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanPenyisihanPiutanglain'  WHERE id='75'"); 

		$BebanLainlainProgramKemitraansdjun = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='18'")->result_array()[0]['sd' . $periodabln];
		$BebanPengeluaranLainnyasd=$BebanLainlainProgramKemitraansdjun+$BebanLainlainProgramKemitraan;
        
		$BebanLainlainProgramKemitraanxxx = $BebanPengeluaranLainnyasd;
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanLainlainProgramKemitraanxxx'  WHERE id='76'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $perioda='$BebanLainlainProgramKemitraanxxx'  WHERE id='77'");  
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$PendapatanJasaAdministrasiPinjamanProgramKemitraan'  WHERE id='1'");
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$PendapatanJasaGiro'  WHERE id='2'");
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$PendapatanLainlain'  WHERE id='3'");
		$Jumlah1=$PendapatanJasaAdministrasiPinjamanProgramKemitraan+$PendapatanJasaGiro+$PendapatanLainlain;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$Jumlah1'  WHERE id='4'");
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$PenyisihanAlokasiDanaBUMNPeduli'  WHERE id='6'");
		$PenyisihanANTTBerakhirPemenuhanProgram=0; // CEK APAKAH SELALU NOL ?
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$PenyisihanANTTBerakhirPemenuhanProgram'  WHERE id='7'");
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$penyisihanANTTberakhirwaktu'  WHERE id='8'");
		$Jumlah2=$PenyisihanAlokasiDanaBUMNPeduli+$PenyisihanANTTBerakhirPemenuhanProgram+$penyisihanANTTberakhirwaktu;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$Jumlah2'  WHERE id='9'");
		$JumlahPendapatan=$Jumlah1+$Jumlah2;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$JumlahPendapatan'  WHERE id='10'");
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$DanaPembinaanKemitraan'  WHERE id='12'");
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$DanaBinaLingkungan'  WHERE id='13'");
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$BebanAdmDanUmum'  WHERE id='14'");
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$BebanPenyusutanAktivaTetapProgramKemitraan'  WHERE id='15'");
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$BebanPemeliharaanProgramKemitraan'  WHERE id='16'");
		$bebanpenyisihanpiutangjun = $this->db->query("SELECT $periodabln FROM catatanataslapkeu WHERE id='18'")->result_array()[0][$periodabln];
		$selisihbebanpenyisihan = $bebanpenyisihanpiutangjun-$BebanPenyisihanPiutang;
        $selisihbebanpenyisihan = 0 - $selisihbebanpenyisihan;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$selisihbebanpenyisihan'  WHERE id='17'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$BebanLainlainProgramKemitraan'  WHERE id='18'");
		$JumlahBeban=$DanaPembinaanKemitraan+$DanaBinaLingkungan+$BebanAdmDanUmum+$BebanPenyusutanAktivaTetapProgramKemitraan+
                            $BebanPemeliharaanProgramKemitraan+ $selisihbebanpenyisihan+$BebanLainlainProgramKemitraan;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$JumlahBeban'  WHERE id='19'");
        $KenaikanPenurunanAsetNetoTidakTerikat = $JumlahPendapatan + $JumlahBeban;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$KenaikanPenurunanAsetNetoTidakTerikat'  WHERE id='20'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$ANTterbebaskan'  WHERE id='22'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$ANTPenyisihanBUMNPeduli'  WHERE id='23'");
        $KenaikanPenurunanAsetNetoTerikatTemporer=$ANTterbebaskan+$ANTPenyisihanBUMNPeduli; 
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$KenaikanPenurunanAsetNetoTerikatTemporer'  WHERE id='24'");
        $Sumbanganterikat=0;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$Sumbanganterikat'  WHERE id='26'");
        $KenaikanPenurunanAsetNetoTerikatPermanen=$Sumbanganterikat;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$KenaikanPenurunanAsetNetoTerikatPermanen'  WHERE id='27'");
        $KenaikanPenurunanAsetNeto=$KenaikanPenurunanAsetNetoTidakTerikat +$KenaikanPenurunanAsetNetoTerikatTemporer+
                    $KenaikanPenurunanAsetNetoTerikatPermanen;  
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET $perioda='$KenaikanPenurunanAsetNeto'  WHERE id='28'");

		$AsetNetoAkhirTahunjun = $this->db->query("SELECT $periodabln FROM perubahanasetnetotidakterikat WHERE id='30'")->result_array()[0][$periodabln];

		$AsetNetoAwalTahun = $AsetNetoAkhirTahunjun;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET $perioda='$AsetNetoAwalTahun'  WHERE id='29'");
        $AsetNetoAkhirTahun=$AsetNetoAwalTahun+$KenaikanPenurunanAsetNeto;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET $perioda='$AsetNetoAkhirTahun'  WHERE id='30'");

		$PendapatanJasaAdministrasiPinjamanProgramKemitraansd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='1'")->result_array()[0]['sd'.$periodabln] + $PendapatanJasaAdministrasiPinjamanProgramKemitraan;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$PendapatanJasaAdministrasiPinjamanProgramKemitraansd'  WHERE id='1'");

		$PendapatanBungasd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='2'")->result_array()[0]['sd'.$periodabln] + $PendapatanJasaGiro;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$PendapatanBungasd'  WHERE id='2'");

		$PendapatanLainlainsd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='3'")->result_array()[0]['sd'.$periodabln] + $PendapatanLainlain;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$PendapatanLainlainsd'  WHERE id='3'");

		$Jumlah1sd = $PendapatanJasaAdministrasiPinjamanProgramKemitraansd + $PendapatanBungasd + $PendapatanLainlainsd;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$Jumlah1sd'  WHERE id='4'");

		$PenyisihanAlokasiDanaBUMNPedulisd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='6'")->result_array()[0]['sd'.$periodabln] + $PenyisihanAlokasiDanaBUMNPeduli;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$PenyisihanAlokasiDanaBUMNPedulisd'  WHERE id='6'");

		$PenyisihanANTTBerakhirPemenuhanProgramsd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='7'")->result_array()[0]['sd'.$periodabln] + $PenyisihanANTTBerakhirPemenuhanProgram;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$PenyisihanANTTBerakhirPemenuhanProgramsd'  WHERE id='7'");

		$penyisihanANTTberakhirwaktusd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='8'")->result_array()[0]['sd'.$periodabln] + $penyisihanANTTberakhirwaktu;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$penyisihanANTTberakhirwaktusd'  WHERE id='8'");

		$jumlah2sd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='9'")->result_array()[0]['sd'.$periodabln] + $Jumlah2;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$jumlah2sd'  WHERE id='9'");

		$JumlahPendapatansd = $jumlah2sd+$Jumlah1sd;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$JumlahPendapatansd'  WHERE id='10'");

		$DanaPembinaanKemitraansd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='12'")->result_array()[0]['sd'.$periodabln] + $DanaPembinaanKemitraan;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$DanaPembinaanKemitraansd'  WHERE id='12'");

		$DanaBinaLingkungansd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='13'")->result_array()[0]['sd'.$periodabln] + $DanaBinaLingkungan;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$DanaBinaLingkungansd'  WHERE id='13'");

		$BebanAdmdanUmumsd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='14'")->result_array()[0]['sd'.$periodabln] + $BebanAdmDanUmum;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$BebanAdmdanUmumsd'  WHERE id='14'");

		$BebanPenyusutanAktivaTetapProgramKemitraansd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='15'")->result_array()[0]['sd'.$periodabln] + $BebanPenyusutanAktivaTetapProgramKemitraan;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$BebanPenyusutanAktivaTetapProgramKemitraansd'  WHERE id='15'");

		$BebanPemeliharaanProgramKemitraansd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='16'")->result_array()[0]['sd'.$periodabln] + $BebanPemeliharaanProgramKemitraan;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$BebanPemeliharaanProgramKemitraansd'  WHERE id='16'");

		$BebanPenyisihanPiutangsd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='17'")->result_array()[0]['sd'.$periodabln] + $BebanPenyisihanPiutang;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$BebanPenyisihanPiutangsd'  WHERE id='17'");

		$BebanPengeluaranLainnyasd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='18'")->result_array()[0]['sd'.$periodabln] + $BebanLainlainProgramKemitraan;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$BebanPengeluaranLainnyasd'  WHERE id='18'");

		$JumlahBebansd=$BebanPengeluaranLainnyasd+$BebanPenyisihanPiutangsd+$BebanPemeliharaanProgramKemitraansd+$BebanPenyusutanAktivaTetapProgramKemitraansd+$BebanAdmdanUmumsd+$DanaPembinaanKemitraansd+$DanaBinaLingkungansd;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$JumlahBebansd'  WHERE id='19'");

		$JumlahBebansd=round($JumlahBebansd);
		$JumlahPendapatansd=round($JumlahPendapatansd);
		$KenaikanPenurunanAsetNetoTidakTerikatsd=($JumlahBebansd)+ ($JumlahPendapatansd);
            
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$KenaikanPenurunanAsetNetoTidakTerikatsd'  WHERE id='20'");

		$ANTterbebaskansd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='22'")->result_array()[0]['sd'.$periodabln] + $ANTterbebaskan;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$ANTterbebaskansd'  WHERE id='22'");

		$ANTPenyisihanBUMNPedulisd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='23'")->result_array()[0]['sd'.$periodabln] + $ANTPenyisihanBUMNPeduli;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$ANTPenyisihanBUMNPedulisd'  WHERE id='23'");

		$KenaikanPenurunanAsetNetoTerikatTemporersd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='24'")->result_array()[0]['sd'.$periodabln] + $KenaikanPenurunanAsetNetoTerikatTemporer;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$KenaikanPenurunanAsetNetoTerikatTemporersd'  WHERE id='24'");

		$Sumbanganterikatsd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='26'")->result_array()[0]['sd'.$periodabln] + $Sumbanganterikat;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$Sumbanganterikatsd'  WHERE id='26'");

		$KenaikanPenurunanAsetNetoTerikatPermanensd = $this->db->query("SELECT sd$periodabln FROM perubahanasetnetotidakterikat WHERE id='27'")->result_array()[0]['sd'.$periodabln] + $KenaikanPenurunanAsetNetoTerikatPermanen;
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$KenaikanPenurunanAsetNetoTerikatPermanensd'  WHERE id='27'");

		$KenaikanPenurunanAsetNetosd=$KenaikanPenurunanAsetNetoTidakTerikatsd+$KenaikanPenurunanAsetNetoTerikatPermanensd+$KenaikanPenurunanAsetNetoTerikatTemporersd;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET sd$perioda='$KenaikanPenurunanAsetNetosd'  WHERE id='28'");

		$AsetNetoAkhirTahunsd = $this->db->query("SELECT $periodabln FROM perubahanasetnetotidakterikat WHERE id='30'")->result_array()[0][$periodabln];
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  $perioda='$AsetNetoAkhirTahunsd'  WHERE id='29'");

		$AsetNetoAwalTahunsd = $this->db->query("SELECT des$date FROM perubahanasetnetotidakterikat WHERE id='30'")->result_array()[0]['des'.$date];
		$this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$perioda='$AsetNetoAwalTahunsd'  WHERE id='29'");

		$AsetNetoAkhirTahunsd=$AsetNetoAwalTahunsd+$KenaikanPenurunanAsetNetosd;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET sd$perioda='$AsetNetoAkhirTahunsd'  WHERE id='30'");
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda=$pengembalianPinjamanMB  WHERE id='2'");
        
		$pengembalianPinjamanMBsd = $this->db->query("SELECT $periodabln FROM aktivitasoperasikasditerima WHERE id='2'")->result_array()[0][$periodabln] + $pengembalianPinjamanMB;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$pengembalianPinjamanMBsd'  WHERE id='2'");

		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda=$AngsuranBelumTeridentifikasi  WHERE id='3'");

		$AngsuranBelumTeridentifikasisd = $this->db->query("SELECT $periodabln FROM aktivitasoperasikasditerima WHERE id='3'")->result_array()[0][$periodabln] + $AngsuranBelumTeridentifikasi;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$AngsuranBelumTeridentifikasisd'  WHERE id='3'");

		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda=$PendapatanJasaAdministrasiPinjamanProgramKemitraan  WHERE id='4'");
		$PendapatanJasaAdministrasiPinjamanProgramKemitraansd = $this->db->query("SELECT $periodabln FROM aktivitasoperasikasditerima WHERE id='3'")->result_array()[0][$periodabln] + $PendapatanJasaAdministrasiPinjamanProgramKemitraan;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$PendapatanJasaAdministrasiPinjamanProgramKemitraansd'  WHERE id='4'");
		
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$PendapatanJasaGiro'  WHERE id='5'");//Jasa Giro
		$PendapatanJasaGirosd = $this->db->query("SELECT $periodabln FROM aktivitasoperasikasditerima WHERE id='5'")->result_array()[0][$periodabln] + $PendapatanJasaGiro;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$PendapatanJasaGirosd'  WHERE id='5'");

		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$PendapatanLainlain'  WHERE id='6'");
		$PendapatanLainlainsd = $this->db->query("SELECT $periodabln FROM aktivitasoperasikasditerima WHERE id='6'")->result_array()[0][$periodabln] + $PendapatanLainlain;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$PendapatanLainlainsd'  WHERE id='6'");

		$PendapatanLainPiutangHapusBuku = $PendapatanLainlainsd;
		$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$PendapatanLainPiutangHapusBuku'  WHERE id='59'"); //

		$Pendapatan=$PendapatanLainlainsd+$PendapatanLainPenyisihanPiutang+$PendapatanBungasd+$PendapatanJasaAdministrasiPinjamanProgramKemitraansd;
    	$this->db->query("UPDATE catatanataslapkeu SET  $perioda='$Pendapatan'  WHERE id='56'");  //pendapatan


		$PiutangMitraBinaanPinjamansd = $this->db->query("SELECT $periodabln FROM aktivitasoperasikasditerima WHERE id='9'")->result_array()[0][$periodabln] + $PiutangMitraBinaanPinjaman;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$PiutangMitraBinaanPinjamansd' WHERE id='9'");

		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$DanaPembinaanKemitraan'  WHERE id='10'");
		$DanaPembinaanKemitraansd = $this->db->query("SELECT sd$periodabln FROM aktivitasoperasikasditerima WHERE id='10'")->result_array()[0]['sd'.$periodabln] + $DanaPembinaanKemitraan;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$DanaPembinaanKemitraansd' WHERE id='10'");

		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$DanaBinaLingkungan'  WHERE id='11'");
		$DanaBinaLingkungansd = $this->db->query("SELECT sd$periodabln FROM aktivitasoperasikasditerima WHERE id='11'")->result_array()[0]['sd'.$periodabln] + $DanaBinaLingkungan;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$DanaBinaLingkungansd' WHERE id='11'");

		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$BebanPembinaan'  WHERE id='12'");
		$BebanPembinaansd = $this->db->query("SELECT sd$periodabln FROM aktivitasoperasikasditerima WHERE id='12'")->result_array()[0]['sd'.$periodabln] + $BebanPembinaan;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$BebanPembinaansd' WHERE id='12'");

		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$BebanUpahTenagakerja'  WHERE id='13'");
		$BebanUpahTenagakerjasd = $this->db->query("SELECT sd$periodabln FROM aktivitasoperasikasditerima WHERE id='13'")->result_array()[0]['sd'.$periodabln] + $BebanUpahTenagakerja;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$BebanUpahTenagakerjasd' WHERE id='13'");

		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$BebanAdmDanUmum'  WHERE id='14'");
		$BebanAdmDanUmumsd = $this->db->query("SELECT sd$periodabln FROM aktivitasoperasikasditerima WHERE id='14'")->result_array()[0]['sd'.$periodabln] + $BebanAdmDanUmum;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$BebanAdmDanUmumsd' WHERE id='14'");

		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$BebanPemeliharaanProgramKemitraan'  WHERE id='15'");
		$BebanPemeliharaanProgramKemitraansd = $this->db->query("SELECT sd$periodabln FROM aktivitasoperasikasditerima WHERE id='15'")->result_array()[0]['sd'.$periodabln] + $BebanPemeliharaanProgramKemitraan;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$BebanPemeliharaanProgramKemitraansd' WHERE id='15'");

		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$PengembalianKelebihanAngsuran'  WHERE id='16'");
		$PengembalianKelebihanAngsuransd = $this->db->query("SELECT sd$periodabln FROM aktivitasoperasikasditerima WHERE id='16'")->result_array()[0]['sd'.$periodabln] + $PengembalianKelebihanAngsuran;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$PengembalianKelebihanAngsuransd' WHERE id='16'");

		$kasNetoDiterimaDigunakanUtkAktivitasOps=$PengembalianKelebihanAngsuran+$BebanPemeliharaanProgramKemitraan+$BebanAdmDanUmum+$BebanUpahTenagakerja+$DanaPembinaanKemitraan+$BebanPembinaan+$DanaBinaLingkungan+$pengembalianPinjamanMB+$AngsuranBelumTeridentifikasi+$PendapatanJasaAdministrasiPinjamanProgramKemitraan+$PendapatanJasaGiro+$PendapatanLainlain+$PiutangMitraBinaanPinjaman+$DanaPembinaanKemitraan;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$kasNetoDiterimaDigunakanUtkAktivitasOps'  WHERE id='17'");

		$kasNetoDiterimaDigunakanUtkAktivitasOpssd=$pengembalianPinjamanMBsd+$AngsuranBelumTeridentifikasisd+$PendapatanJasaAdministrasiPinjamanProgramKemitraansd+$PendapatanJasaGirosd+$PendapatanLainlainsd+$PiutangMitraBinaanPinjamansd+$DanaPembinaanKemitraansd+$DanaBinaLingkungansd+$BebanPembinaansd+$BebanUpahTenagakerjasd+$BebanAdmdanUmumsd+$BebanPemeliharaanProgramKemitraansd+$PengembalianKelebihanAngsuransd;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda=
			'$kasNetoDiterimaDigunakanUtkAktivitasOpssd' WHERE id='17'");
            
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$AktivaTetapHargaPerolehan'  WHERE id='20'");
		$AktivaTetapHargaPerolehansd = $this->db->query("SELECT sd$periodabln FROM aktivitasoperasikasditerima WHERE id='20'")->result_array()[0]['sd'.$periodabln] + $AktivaTetapHargaPerolehan;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$AktivaTetapHargaPerolehansd' WHERE id='20'");

		$KasNetoDiterimaDigunakanUntukAktivitasInvestasi=$AktivaTetapHargaPerolehan;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$KasNetoDiterimaDigunakanUntukAktivitasInvestasi'  WHERE id='21'");
		$KasNetoDiterimaDigunakanUntukAktivitasInvestasisd = $this->db->query("SELECT sd$periodabln FROM aktivitasoperasikasditerima WHERE id='21'")->result_array()[0]['sd'.$periodabln] + $KasNetoDiterimaDigunakanUntukAktivitasInvestasi;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$KasNetoDiterimaDigunakanUntukAktivitasInvestasisd' WHERE id='21'");

		$KenaikanPenurunanAsetNetoDalamKas=$KasNetoDiterimaDigunakanUntukAktivitasInvestasi+$kasNetoDiterimaDigunakanUtkAktivitasOps;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$KenaikanPenurunanAsetNetoDalamKas'  WHERE id='22'");

		$KenaikanPenurunanAsetNetoDalamKassd = $this->db->query("SELECT sd$periodabln FROM aktivitasoperasikasditerima WHERE id='22'")->result_array()[0]['sd'.$periodabln] + $KenaikanPenurunanAsetNetoDalamKas;
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$perioda='$KenaikanPenurunanAsetNetoDalamKassd' WHERE id='22'");

		$kasDanSetaraKasPadaAkhirTahun = $this->db->query("SELECT $periodabln FROM aktivitasoperasikasditerima WHERE id='24'")->result_array()[0][$periodabln];
		$this->db->query("UPDATE aktivitasoperasikasditerima SET  $perioda='$kasDanSetaraKasPadaAkhirTahun'  WHERE id='23'");
		// 2805

		// $SaldoAwal = $this->db->query("SELECT $periodabln FROM aktivitasoperasikasditerima WHERE id='24'")->result_array()[0][$periodabln];
	}

	private function _updateSaldo($akun){
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
	}

	private function _tanggal($tanggal){
		$bulan = array (
			1 =>   'jan',
			'feb',
			'mar',
			'apr',
			'mei',
			'jun',
			'jul',
			'ags',
			'sep',
			'okt',
			'nov',
			'des'
		);
		$pecahkan = explode('-', $tanggal);
	 
		return $bulan[(int)$pecahkan[1]] . $pecahkan[0];
	}
}
