<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;
use GuzzleHttp\Client;

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('SaldoModel', 'saldo_model');
		$this->load->model('PerhitunganModel', 'perhitungan_model');

		if(!$this->session->userdata('username')){
			redirect(base_url('auth'));
		}
	}

	public function index()
	{
		$data = [
			'title' => 'Dashboard',
			'countMitra' => $this->db->count_all('mitra'),
			'countMitraNormal' => $this->db->where('tdkbermasalah', 'normal', 'Normal', 'NORMAL')->count_all_results('mitra'),
			'countMitraBermasalah' => $this->db->where('tdkbermasalah', 'masalah', 'Masalah', 'MASALAH')->count_all_results('mitra'),
			'countMitraKhusus' => $this->db->where('tdkbermasalah', 'khusus', 'Khusus', 'KHUSUS')->count_all_results('mitra'),
			'countMitraWo' => $this->db->where('tdkbermasalah', 'wo', 'Wo', 'WO')->count_all_results('mitra'),
			'saldokasbank' => $this->saldo_model->getSaldo(),
			'data_chart_opex' => $this->db->query("SELECT SUM(pengeluaran) as pengeluaran, SUM(pemasukan) as pemasukan, Month(tanggal) as month, `tanggal` FROM opex GROUP BY DATE_FORMAT(`tanggal`, '%Y-%m') ORDER BY tanggal ASC")->result(),
			'pemasukan_bulanan' => 0,
			'pengeluaran_bulanan' => 0,
		];

		foreach ($data['data_chart_opex'] as $key => $value) {
			preg_match('/(\d{1,4}\d{1})/', $data['data_chart_opex'][$key]->tanggal, $output_array);
			if ($output_array[0] == date('Y')) {
				$data['data_chart_opex'][$key]->pengeluaran = intval($value->pengeluaran);
				$data['data_chart_opex'][$key]->pemasukan = intval($value->pemasukan);
				$data['pemasukan_bulanan'] += $value->pemasukan;
				$data['pengeluaran_bulanan'] += $value->pengeluaran;
			} else {
				unset($data['data_chart_opex'][$key]);
			}
		}
		
		$this->template->load('dashboard/index', $data);
	}

	public function HitungLaporanData(){
		// $AktivaTetapHargaPerolehanInventarisKantor = 40478000; //fixed  
		// $akumPenyusutanInvPeralatan = -40478000; //fixed
		// $JumlahAsetTetapBersih = 0; //fixed

		// $perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

		// $totnilsaldopokok_bermasalah = $this->perhitungan_model->getSaldoPokokBermasalah();
		// $totsektorindustribermasalah = $this->perhitungan_model->getSaldoPokokBermasalah('Sektor Industri');
		// $totsektorperdaganganbermasalah = $this->perhitungan_model->getSaldoPokokBermasalah('Sektor Perdagangan');
		// $totsektorpertanianbermasalah = $this->perhitungan_model->getSaldoPokokBermasalah('Sektor Pertanian');
		// $totsektorperkebunanbermasalah = $this->perhitungan_model->getSaldoPokokBermasalah('Sektor Perkebunan');
		// $totsektorperikananbermasalah = $this->perhitungan_model->getSaldoPokokBermasalah('Sektor Perikanan');
		// $totsektorpeternakanbermasalah = $this->perhitungan_model->getSaldoPokokBermasalah('Sektor Peternakan');
		// $totsektorjasabermasalah = $this->perhitungan_model->getSaldoPokokBermasalah('Sektor Jasa');
		// $totsektorlainlainbermasalah = $this->perhitungan_model->getSaldoPokokBermasalah('Sektor Lain-lain');

		// $this->db->query("UPDATE neraca SET $perioda='$totnilsaldopokok_bermasalah' WHERE id='11'");
		// $alokPenyisihanPiutangbermasalah = 0 - $totnilsaldopokok_bermasalah;
		// $this->db->query("UPDATE neraca SET $perioda='$alokPenyisihanPiutangbermasalah' WHERE id='12'");

		// $totalsaldopokoktdkbermasalah = $this->perhitungan_model->getSaldoPokokTdkBermasalah();
		// $totallancar = $this->perhitungan_model->getSaldoPokokTdkBermasalah('lancar');
		// $totalkuranglancar = $this->perhitungan_model->getSaldoPokokTdkBermasalah('kurang lancar');
		// $totaldiragukan = $this->perhitungan_model->getSaldoPokokTdkBermasalah('diragukan');
		// $totalmacet = $this->perhitungan_model->getSaldoPokokTdkBermasalah('macet');

		// $tingkatpengembalianpinjamanMBLancar = $totallancar;
		// $tingkatpengembalianpinjamanMBKurangLancar = $totalkuranglancar;
		// $tingkatpengembalianpinjamanMBDiragukan = $totaldiragukan;
		// $tingkatpengembalianpinjamanMBMacet = $totalmacet;

		// $tanggalawal = date('Y-m-01', mktime(0, 0, 0, date('m')-1, date('d'), date('y')));
		// $tanggalakhir = date('Y-m-01');

		// $KasBankYgDiBatasiPenggunaannyaa = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '103070000'");
		// $JasaAdmPinjaman = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '403010100'");
		// $AktivaTetapHargaPerolehan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '102010101' OR id_akun = '102010201')");
		// $PengembalianKelebihanAngsuran = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '412020500'");
		// $BebanUpahTenagakerja = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '406010000'");
		// $BebanPembinaan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '405010100' OR id_akun = '405020100' OR id_akun = '405030100')");
		
		// $pengembalianPinjamanMB = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '101060201' OR id_akun = '101060202' OR id_akun = '101060203' OR id_akun = '101060204' OR id_akun = '101060205'OR id_akun = '101060206' OR id_akun = '101060207' OR id_akun = '101060208')");
		// $PiutangMitraBinaanPinjaman = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '101060101' OR id_akun = '101060102' OR id_akun = '101060103' OR id_akun = '101060104' OR id_akun = '101060105'OR id_akun = '101060106' OR id_akun = '101060107' OR id_akun = '101060108')");
		
		// $PiutangMitraBinaanPinjamanindustri = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '101060101'");
		// $PiutangMitraBinaanPinjamanPerdagangan = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '101060102'");
		// $PiutangMitraBinaanPinjamanPertanian = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '101060103'");
		// $PiutangMitraBinaanPinjamanPerkebunan = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '101060104'");
		// $PiutangMitraBinaanPinjamanPerikanan = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '101060105'");
		// $PiutangMitraBinaanPinjamanPeternakan = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '101060106'");
		// $PiutangMitraBinaanPinjamanJasa = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '101060107'");
		// $PiutangMitraBinaanPinjamanLain = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '101060108'");
		
		// $PendapatanJasaAdministrasiPinjamanProgramKemitraan = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '403010100'");
		// $AktivaLancarPiutangBunga = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '403020100'");
		// $PendapatanJasaGiroBL = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '403020101'");
		// $PendapatanJasaGiroBUMNPeduli = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '403020102'");
		
		// $PendapatanJasaGiro = ($PendapatanJasaGiroBL + $PendapatanJasaGiroBUMNPeduli + $AktivaLancarPiutangBunga);
		// $PendapatanLainlain = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '403030100' OR id_akun = '403030200' OR id_akun = '403030300' OR id_akun = '403030400')");
		// $PendapatanLainPiutangHapusBuku = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '403030100'");
		// $PendapatanLainPenyisihanPiutang = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '403030200'");
		// $PendapatanLainLainSelisihKasBankLain = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '403030300' OR id_akun = '403030400')");
		
		// $PenyisihanAlokasiDanaBUMNPeduli = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '401030000'");
		// $PenyisihanANTTBerakhirPemenuhanProgram = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '401010000'");
		// $penyisihanANTTberakhirwaktu = $this->perhitungan_model->getSaldoOpexAkun("id_akun = '401020000'");

		// $DanaPembinaanKemitraan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun =  '404010101' OR id_akun =  '404010102' OR id_akun =  '404010103' OR id_akun =  '404010104' OR id_akun =  '404010105' OR id_akun =  '404010106' OR id_akun =  '404010107' OR id_akun =  '404010108' OR id_akun =  '404010201' OR id_akun =  '404010202' OR id_akun =  '404010203' OR id_akun =  '404010204' OR id_akun =  '404010205' OR id_akun =  '404010206' OR id_akun =  '404010207' OR id_akun =  '404010208' OR id_akun =  '404010301' OR id_akun =  '404010302' OR id_akun =  '404010303' OR id_akun =  '404010304' OR id_akun =  '404010305' OR id_akun =  '404010306' OR id_akun =  '404010307' OR id_akun =  '404010308')");
		// $DanaBinaLingkungan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '404020100' OR id_akun =  '404020200' OR id_akun =  '404020300' OR id_akun =  '404020400' OR id_akun =  '404020500' OR id_akun =  '404020600' OR id_akun =  '404020700' OR id_akun =  '404020800' OR id_akun =  '404020900' OR id_akun =  '404021000')");
		
		// $BebanAdmdanUmum = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '407010000' OR id_akun = '407020000' OR id_akun = '407030000')");
		// $BebanAdmDanUmumBL = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '407020000' OR id_akun = '407030000')");

		// $BebanPenyusutanAktivaTetapProgramKemitraan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '410010000')");
		// $BebanPemeliharaanProgramKemitraan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '408010000')");
		
		// $BebanPenyisihanPiutangSektorindustriSektorindustri = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '411010100')");
		// $BebanPenyisihanPiutangSektorPerdaganganSektorPerdagangan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '411020200')");
		// $BebanPenyisihanPiutangSektorPertanianSektorPertanian = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '411030300')");
		// $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '411040400')");
		// $BebanPenyisihanPiutangSektorPerikananSektorPerikanan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '411050500')");
		// $BebanPenyisihanPiutangSektorPeternakanSektorPeternakan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '411060600')");
		// $BebanPenyisihanPiutangSektorJasaSektorJasa = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '411070700')");
		// $BebanPenyisihanPiutangSektorLainlainSektorLainlain = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '411080800')");

		// $BebanLainlainProgramKemitraan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '412020400')");
		// $ANTterbebaskan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '415020000')");
		// $ANTPenyisihanBUMNPeduli = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '415010000')");

		// $AktivaLancarAlokasiPenyisihanPiutangMitraBinaan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '0101070100' OR id_akun = '0101070200' OR id_akun = '0101070300' OR id_akun = '0101070400' OR id_akun = '0101070500' OR id_akun = '0101070600' OR id_akun = '0101070700' OR id_akun = '0101070800')");
		// $KelebihanPembayaranAngsuran = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '201040000')");
		// $PengembaliankelebihanAngsuran = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '412020500')");
		// $AngsuranBelumTeridentifikasi = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '201050000')");
		// $PendapatanPendapatanLainlainLainlain = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '403030400')");
		// $KewajibanjangkaPanjangProgramKemitraan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '202010000')");
		// $AktivaLancarPersediaanProgramKemitraan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '101020100')");
		// $ANTterbebaskan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '415020000')");
		// $PenyisihanANTTBerakhirPemenuhanProgram = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '412020400')");
		// $ANTTerbebaskan = $this->perhitungan_model->getSaldoOpexAkun("(id_akun = '415020000')");

		// $AngsuranBelumTeridentifikasiBulanLalu = $this->db->query("SELECT " . $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-2, date("d"), date("Y")))) . " FROM neraca WHERE id='18'")->result_array()[0]['jun22'];
		// var_dump($AngsuranBelumTeridentifikasiBulanLalu);
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
