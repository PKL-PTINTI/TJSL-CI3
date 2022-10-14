
<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class NeracaSaldo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('NeracaSaldoModel', 'neracasaldo_model');

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

			$this->data['link_active'] = 'Admin/neracasaldo';

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
		$this->data['title'] = 'Data Neraca Saldo';
		$this->data['header'] = 'Management Data Neraca Saldo';
		$this->data['neracasaldo'] = $this->neracasaldo_model->getNeracaSaldo();

		$this->data['bulan'] =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));

		$this->data['perioda'] = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		
		$this->template->load('neraca_saldo/index', $this->data);
    }

    public function createExcel() {
		$fileName = 'neraca-saldo-' . date('Y') .'.xlsx';  

		$neracasaldo = $this->neracasaldo_model->getNeracaSaldo();
		$spreadsheet = new Spreadsheet();
		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

        $sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(15);
		$sheet->getColumnDimension('C')->setWidth(40);
		$sheet->getColumnDimension('D')->setWidth(15);
		$sheet->getColumnDimension('E')->setWidth(15);
		$sheet->getColumnDimension('F')->setWidth(15);
		$sheet->getColumnDimension('G')->setWidth(15);
		$sheet->getColumnDimension('H')->setWidth(10);

		$sheet->mergeCells('A2:H2');
		$sheet->getStyle('A2:H2')->getFont()->setBold(true);
		$sheet->getStyle('A2:H2')->getAlignment()->setHorizontal('center');

		$sheet->setCellValue('A2', 'DATA NERACA SALDO');

        $sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Kode Rekening');
       	$sheet->setCellValue('C3', 'URAIAN');
        $sheet->setCellValue('D3', 'DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))));
        $sheet->setCellValue('E3', 'Debet ' . $bulan);
        $sheet->setCellValue('F3', 'Kredit ' . $bulan);
        $sheet->setCellValue('G3', 'Saldo ' . $bulan);
		$sheet->setCellValue('H3', 'Selisih');

        $sheet->setCellValue('A4', 'Pendapatan Lain-lain, Penyesuaian ');
		$sheet->setCellValue('A5', 'ASET');
		$sheet->setCellValue('A6', 'ASET LANCAR');
		$sheet->setCellValue('A7', 'KAS & SETARA KAS');
		$sheet->setCellValue('A8', 'Kas PKP');
		$sheet->setCellValue('A9', 'Mandiri');
		$sheet->setCellValue('A10', 'Bank BL ');
		$sheet->setCellValue('A11', 'BRI');
		$sheet->setCellValue('A12', 'Kas Bank Yang Dibatasi Penggunaanya');
		$sheet->setCellValue('A13', 'Kas Bank Yang Dibatasi Penggunaanya');
		$sheet->setCellValue('A14', 'Piutang Mitra Binaan Bersih');
		$sheet->setCellValue('A15', 'Piutang Mitra Binaan');
		$sheet->setCellValue('A16', 'Sektor Industri');
		$sheet->setCellValue('A17', 'Sektor Perdagangan');
		$sheet->setCellValue('A18', 'Sektor Pertanian');
		$sheet->setCellValue('A19', 'Sektor Perkebunan');
		$sheet->setCellValue('A20', 'Sektor Perikanan');
		$sheet->setCellValue('A21', 'Sektor Peternakan');
		$sheet->setCellValue('A22', 'Sektor Jasa');
		$sheet->setCellValue('A23', 'Sektor Lain-lain');
		$sheet->setCellValue('A24', 'Alokasi Penyisihan Piutang Mitra Binaan');
		$sheet->setCellValue('A25', 'Sektor Industri');
		$sheet->setCellValue('A26', 'Sektor Perdagangan');
		$sheet->setCellValue('A27', 'Sektor Pertanian');
		$sheet->setCellValue('A28', 'Sektor Perkebunan');
		$sheet->setCellValue('A29', 'Sektor Perikanan');
		$sheet->setCellValue('A30', 'Sektor Peternakan');
		$sheet->setCellValue('A31', 'Sektor Jasa');
		$sheet->setCellValue('A32', 'Sektor Lain-lain');
		$sheet->setCellValue('A33', 'Piutang Jasa Administrasi Pinjaman');
		$sheet->setCellValue('A34', 'Piutang Jasa Administrasi Pinjaman');
		$sheet->setCellValue('A35', 'Harga Perolehan Aset Tetap');
		$sheet->setCellValue('A36', 'Inventaris Kantor');
		$sheet->setCellValue('A37', 'Akumulasi Penyusutan Aset Tetap');
		$sheet->setCellValue('A38', 'Inventaris Kantor');
		$sheet->setCellValue('A39', 'Liabilitas Dan Aset Neto');
		$sheet->setCellValue('A40', 'Liabilitas');
		$sheet->setCellValue('A41', 'Liabilitas Jangka Pendek');
		$sheet->setCellValue('A42', '1. Kelebihan Pembayaran Angsuran');
		$sheet->setCellValue('A43', '2. Angsuran Belum Teridentifikasi');
		$sheet->setCellValue('A44', 'Aset Netto');
		$sheet->setCellValue('A45', 'Aktiva Bersih Awal Periode');
		$sheet->setCellValue('A46', 'Pendapatan');
    	$sheet->setCellValue('A47', 'Jasa Administrasi Pinjaman');
		$sheet->setCellValue('A48', 'Jasa Giro PK');
		$sheet->setCellValue('A49', 'Pendapatan Lain-lain, Piutang Hapus Buku');
		$sheet->setCellValue('A50', 'Pendapatan Lain-lain, Penyesuaian Alokasi Penyisihan');
		$sheet->setCellValue('A51', 'Pendapatan Lain-lain, Lain-lain');
		$sheet->setCellValue('A52', 'Beban Umum');
		$sheet->setCellValue('A53', 'Beban Adm dan Umum');
		$sheet->setCellValue('A54', 'Beban Penyisihan Utang');
		$sheet->setCellValue('A55', 'Sektor Industri');
		$sheet->setCellValue('A56', 'Sektor Perdagangan');
		$sheet->setCellValue('A57', 'Sektor Pertanian');
		$sheet->setCellValue('A58', 'Sektor Perkebunan');
		$sheet->setCellValue('A59', 'Sektor Perikanan');
		$sheet->setCellValue('A60', 'Sektor Peternakan');
		$sheet->setCellValue('A61', 'Sektor Jasa');
		$sheet->setCellValue('A62', 'Sektor Lain-lain');
		$sheet->setCellValue('A63', 'Beban Lain-lain');
		$sheet->setCellValue('A64', 'Lain-lain');


		$row = 4;
        foreach ($neracasaldo as $val){
			$sheet->setCellValue('A' . $row, ($val['id']));
			$sheet->setCellValue('B' . $row, ($val['id_akun'] == 0 ? '' : $val['id_akun']));
			$sheet->setCellValue('C' . $row, ($val['nama_akun']));
			$sheet->setCellValue('D' . $row, number_format($val['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]));
			$sheet->setCellValue('E' . $row, number_format($val['debet' . $perioda]));
            $sheet->setCellValue('F' . $row, number_format($val['kredit' . $perioda]));
            $sheet->setCellValue('G' . $row, number_format($val['saldo' . $perioda]));
			$sheet->setCellValue('H' . $row, ($val['selisih']));
			$row++;
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save("storage/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/storage/".$fileName);         
    }

	public function hitungNeracaSaldo(){
		ini_set('memory_limit','512M');
		$tanggalAwalTahun = date('Y-01-01');
		$tanggalBulanTerkahir = date('Y-m-t', strtotime('-1 month'));
		$desTahunLalu = 'des' . date('y', strtotime('-1 year'));
		$desTahunLaluNeracaSaldo = $this->neracasaldo_model->getDesTahunLaluNeracaSaldo();
		$catatanAtasLapKeuDesTahunLalu = $this->neracasaldo_model->getCatatanAtasLapKeu();
		$catatanAtasLapKeu = $this->neracasaldo_model->getCatatanAtasLapKeuBulan();

		echo '$tglawal = '; echo $tanggalAwalTahun;
		echo '$tglakhir = '; echo $tanggalBulanTerkahir;echo nl2br("\n");

		$asetlancardesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neraca WHERE id='5'")->result_array()[0][$desTahunLalu];
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($asetlancardesTahunLalu, '2');

		$piutangMBdesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '8')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($piutangMBdesTahunLalu, '11');

		$sektorIndustridesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '9')[$desTahunLalu];;   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($sektorIndustridesTahunLalu, '12');  

		$aloksektorIndustridesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '18')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($aloksektorIndustridesTahunLalu, '21');  

		$alokasiSisihMBdesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '17')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($alokasiSisihMBdesTahunLalu, '20');  

		$LiabilitasJangkaPendekdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neraca WHERE id='20'")->result_array()[0][$desTahunLalu];//liabilitas   

		$kelebihanAngsurandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neraca WHERE id='17'")->result_array()[0][$desTahunLalu];//17. kelebihan angsuran   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($kelebihanAngsurandesTahunLalu, '56');  

		$jasaGirosddesTahunLalu = $this->db->query("SELECT sd$desTahunLalu FROM  perubahanasetnetotidakterikat WHERE id='2'")->result_array()[0]['sd' . $desTahunLalu];   
		// $this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($jasaGirosddesTahunLalu, '62');  

		$pendapatanLainlainpiutangsddesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '59')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($pendapatanLainlainpiutangsddesTahunLalu, '63');  

		$pendapatanLainlainPenyesuaiandesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '60')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($pendapatanLainlainPenyesuaiandesTahunLalu, '64');  

		$pendapatanLainlainLaindesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '61')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($pendapatanLainlainLaindesTahunLalu, '65');  


		$BebanUmumAdmdesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '65')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($BebanUmumAdmdesTahunLalu, '66');  
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($BebanUmumAdmdesTahunLalu, '67');  

		$sektorIndustridesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '68')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($sektorIndustridesTahunLalu, '69');  

		$sektorPerdagangandesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '69')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($sektorPerdagangandesTahunLalu, '70');  

		$sektorPertaniandesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '70')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($sektorPertaniandesTahunLalu, '71');  

		$sektorPerkebunandesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '71')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($sektorPerkebunandesTahunLalu, '72');  

		$sektorPerikanandesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '72')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($sektorPerikanandesTahunLalu, '73');  

		$sektorPeternakandesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '73')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($sektorPeternakandesTahunLalu, '74');  

		$sektorJasadesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '74')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($sektorJasadesTahunLalu, '75');  

		$sektorLainlaindesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '75')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($sektorLainlaindesTahunLalu, '76');  

		$bebanLainlaindesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '76')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($bebanLainlaindesTahunLalu, '77');  
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($bebanLainlaindesTahunLalu, '78');  

		$aloksektorJasabermasalahdesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '49')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($aloksektorJasabermasalahdesTahunLalu, '45');  

		$AngsuranBelumTeridentifikasidesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neraca WHERE id='18'")->result_array()[0][$desTahunLalu];//18. angsuran  blum teridentifikasi

		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($AngsuranBelumTeridentifikasidesTahunLalu, '57');  
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($LiabilitasJangkaPendekdesTahunLalu, '54');  
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($LiabilitasJangkaPendekdesTahunLalu, '55');  


		$pendapatansddesTahunLalu = $this->db->query("SELECT sd$desTahunLalu FROM  perubahanasetnetotidakterikat WHERE id='4'")->result_array()[0]['sd' . $desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($pendapatansddesTahunLalu, '60');  

		$jasaAdmPinjamansddesTahunLalu = $this->db->query("SELECT sd$desTahunLalu FROM  perubahanasetnetotidakterikat WHERE id='1'")->result_array()[0]['sd' . $desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($jasaAdmPinjamansddesTahunLalu, '61');  

		$asetNetodesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neraca WHERE id='24'")->result_array()[0][$desTahunLalu];//aset neto   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($asetNetodesTahunLalu, '58'); 

		$nomor=1;
		$totPiutangMitraBinaanDebet=$totPiutangMitraBinaanKredit=0;
		$selisihkreditaloksektorperkebunan=$selisihkreditaloksektorperikanan=$selisihkreditaloksektorpeternakan=$selisihkreditaloksektorjasa=$selisihdebetaloksektorindustri=$selisihdebetaloksektorperdagangan=$selisihdebetaloksektorpertanian=$totpemasukanjasaPendapatanLainlainPiutangHapusBuku=0;

		$totpengeluaranBebanPenyisihanJasa=$totpemasukanBebanPenyisihanJasa=0;$totpengeluaranBebanPenyisihanPeternakan =$totpemasukanBebanPenyisihanPeternakan=0;$totpengeluaranBebanPenyisihanPerikanan= $totpemasukanBebanPenyisihanPerikanan=0;
		$totpengeluaranBebanPenyisihanPerkebunan= $totpemasukanBebanPenyisihanPerkebunan=0;$totpengeluaranBebanPenyisihanPertanian=  $totpemasukanBebanPenyisihanPertanian=0;

		$id_akhir=$saldomandiriberikut=$saldo_akhir=$totpemasukan=$totpengeluaran=$saldo=0;$totpengeluarankas=$totpemasukankas=$totpemasukanmandiri =$totpengeluaranmandiri =0;$totpengeluaranbri= $totpemasukanbri=$totpengeluaranindustribermasalah=$totpemasukanindustribermasalah=0;$totpengeluaranperdaganganbermasalah= $totpemasukanperdaganganbermasalah=0;
		$totpengeluaranpertanianbermasalah=  $totpemasukanpertanianbermasalah=0;$totpengeluaranperkebunanbermasalah=  $totpemasukanperkebunanbermasalah=0;$totpengeluaranperikananbermasalah= $totpemasukanperikananbermasalah=0;$totpengeluaranpeternakanbermasalah=  $totpemasukanpeternakanbermasalah=0;$totpengeluaranjasabermasalah= $totpemasukanjasabermasalah=0;
		$totpengeluaranLainlainbermasalah= $totpemasukanLainlainbermasalah=0;$aloktotpengeluaranindustri=$aloktotpemasukanindustri=0;$aloktotpengeluaranperdagangan=$aloktotpemasukanperdagangan=0;$aloktotpengeluaranpertanian=$aloktotpemasukanpertanian=0;$aloktotpengeluaranperkebunan=$aloktotpemasukanperkebunan=0;$aloktotpengeluaranpeternakan=$aloktotpemasukanpeternakan=0;
		$aloktotpengeluaranperikanan=$aloktotpemasukanperikanan=0;$aloktotpengeluaranjasa=$aloktotpemasukanjasa=0;$aloktotpengeluaranLainlain=$aloktotpemasukanLainlain=0;$totpengeluaranperdagangan= $totpemasukanperdagangan=0;  $totpengeluaranKelebihanPembayaranAngs= $totpemasukanKelebihanPembayaranAngs=0;
		
		$totpengeluaranindustri=$totpemasukanindustri=0;$totpengeluaranperdagangan=$totpemasukanperdagangan=0;$totpengeluaranpertanian=  $totpemasukanpertanian=0;$totpengeluaranperkebunan=  $totpemasukanperkebunan=0;
		$totpengeluaranperikanan= $totpemasukanperikanan=0;$totpengeluaranpeternakan=  $totpemasukanpeternakan=0;$totpengeluaranjasa= $totpemasukanjasa=0;$totpengeluaranLainlain= $totpemasukanLainlain=0;
		$totpengeluaranAngsuranBelumTeridentifikasi= $totpemasukanAngsuranBelumTeridentifikasi=0; $totpengeluaranAktivaBersihAwalPerioda= $totpemasukanAktivaBersihAwalPerioda=0; $totpengeluaranJasaAdmPinjaman= $totpemasukanJasaAdmPinjaman=0;   $totpengeluaranPendapatanLainlainPiutangHapusBuku= $totpemasukanPendapatanLainlainPiutangHapusBuku=0; 
		$totpengeluaranPendapatanLainlainLainlain= $totpemasukanPendapatanLainlainLainlain=0;$totpengeluaranBebanUmum= $totpemasukanBebanUmum=0;$totpengeluaranBebanUmum= $totpemasukanBebanUmum=0;$totpemasukanBebanPenyisihanPiutangIndustri=$totpengeluaranBebanPenyisihanPiutangIndustri=0;   
		$totpengeluaranBebanPenyisihanPiutangPertanian= $totpemasukanBebanPenyisihanPiutangPertanian=0;      $totpengeluaranBebanPenyisihanPiutangPerkebunan= $totpemasukanBebanPenyisihanPiutangPerkebunan=0;    $totpengeluaranBebanPenyisihanPiutangPerikanan= $totpemasukanBebanPenyisihanPiutangPerikanan=0;     $totpengeluaranBebanPenyisihanPiutangPeternakan= $totpemasukanBebanPenyisihanPiutangPeternakan=0;
		$totpengeluaranBebanPenyisihanPiutangJasa= $totpemasukanBebanPenyisihanPiutangJasa=0;$totpengeluaranBebanPenyisihanPiutangLainlain= $totpemasukanBebanPenyisihanPiutangLainlain=0;$totpengeluaranBebanAdmdanUmum=$totpemasukanBebanAdmdanUmum=0;$totpengeluaranPiutangJasaAdmPinjaman=$totpemasukanPiutangJasaAdmPinjaman=0; $totpengeluaranKelebihanPembayaranAngs=$totpemasukanKelebihanPembayaranAngs=0;$totpengeluaranAngsBelumTeridentifikasi=$totpemasukanAngsBelumTeridentifikasi=0;
		$totpengeluaranJasaAdmPinjaman=$totpemasukanJasaAdmPinjaman=0;$totpengeluaranJasaGiroPK=$totpemasukanJasaGiroPK=0; 

		$totpengeluaranPendapatanLainlainLainlain=$totpemasukanPendapatanLainlainLainlain=0;$totpengeluaranBebanAdmdanUmum=$totpemasukanBebanAdmdanUmum=$selisihAlokPenyisihanPiutangtdkbermasalahIndustri=0;$totpengeluaranBebanPenyisihanIndustri=$totpemasukanBebanPenyisihanIndustri=0;$totpengeluaranBebanPenyisihanPerdagangan=$totpemasukanBebanPenyisihanPerdagangan=0;
		$totpengeluaranBebanPenyisihanPerkebunan=$totpemasukanBebanPenyisihanPerkebunan=0;$totpengeluaranBebanPenyisihanPerikanan=$totpemasukanBebanPenyisihanPerikanan=0;$totpengeluaranBebanPenyisihanPeternakan=$totpemasukanBebanPenyisihanPeternakan=0;$totpengeluaranBebanPenyisihanJasa=$totpemasukanBebanPenyisihanJasa=0;
		$totpengeluaranBebanPenyisihanLainlain= $totpemasukanBebanPenyisihanLainlain=0;$totpengeluaranBebanLainlain=$totpemasukanBebanLainlain=0;$totpengeluaranAlokbermasalahindustri=$totpemasukanAlokbermasalahindustri=0;     $totpengeluaranBebanPenyisihanPiutangPerdagangan= $totpemasukanBebanPenyisihanPiutangPerdagangan=0;

		$opexdata = $this->db->query("SELECT * FROM opex ORDER BY tanggal ASC ")->result_array();
		foreach($opexdata as $opex){
			if($opex["tanggal"] >= "$tanggalAwalTahun" AND $opex["tanggal"] <= "$tanggalBulanTerkahir" AND  $opex['tampil'] == 0 ){
				if($opex['id_akun'] == '0101010101' ){
					$totpengeluarankas += $opex['pengeluaran']; 
					$totpemasukankas += $opex['pemasukan'];
				}

				if($opex['id_akun'] == '0101010201' ){
					$totpengeluaranmandiri += $opex['pengeluaran']; 
					$totpemasukanmandiri += $opex['pemasukan'];
				}

				if($opex['id_akun'] == '0101010204' ){
					$totpengeluaranbri += $opex['pengeluaran']; 
					$totpemasukanbri += $opex['pemasukan'];
				}

				if($opex['id_akun'] == '411010100'){
					$aloktotpengeluaranindustri += $opex['pengeluaran']; 
					$aloktotpemasukanindustri += $opex['pemasukan'];             
				}
	
				if($opex['id_akun'] == '411020200' ){
					$aloktotpengeluaranperdagangan += $opex['pengeluaran']; 
					$aloktotpemasukanperdagangan += $opex['pemasukan'];
				}
				
				if($opex['id_akun'] == '411030300' ){   
					$aloktotpengeluaranpertanian += $opex['pengeluaran']; 
					$aloktotpemasukanpertanian += $opex['pemasukan'];
				}
				
				if($opex['id_akun'] == '411040400' ){
					$aloktotpengeluaranperkebunan += $opex['pengeluaran']; 
					$aloktotpemasukanperkebunan += $opex['pemasukan'];            
				}
				
				if($opex['id_akun'] == '411050500' ){ 
					$aloktotpengeluaranperikanan += $opex['pengeluaran']; 
					$aloktotpemasukanperikanan += $opex['pemasukan']; 
				}
				
				if($opex['id_akun'] == '411060600' ){
					$aloktotpengeluaranpeternakan += $opex['pengeluaran']; 
					$aloktotpemasukanpeternakan += $opex['pemasukan']; 
				}
				
				if($opex['id_akun'] == '411070700'){
					$aloktotpengeluaranjasa += $opex['pengeluaran']; 
					$aloktotpemasukanjasa += $opex['pemasukan']; 
				}
				
				if($opex['id_akun'] == '411080800' ){     
					$aloktotpengeluaranLainlain += $opex['pengeluaran']; 
					$aloktotpemasukanLainlain += $opex['pemasukan'];        
				}
	
				if($opex['id_akun'] == '0101060201'){
					$totpengeluaranindustri += $opex['pengeluaran']; 
					$totpemasukanindustri += $opex['pemasukan'];
				}
		
				if($opex['id_akun'] == '0101060101' ){
					$totpengeluaranindustri += $opex['pengeluaran']; 
					$totpemasukanindustri += $opex['pemasukan'];
				}
		
				if($opex['id_akun'] == '0101060202' ){
					$totpengeluaranperdagangan += $opex['pengeluaran']; 
					$totpemasukanperdagangan += $opex['pemasukan'];
				}
		
				if($opex['id_akun'] == '0101060102' ){
					$totpengeluaranperdagangan += $opex['pengeluaran']; 
					$totpemasukanperdagangan += $opex['pemasukan'];
				}
	
		
				if($opex['id_akun'] == '0101060203' ){           
					$totpengeluaranpertanian += $opex['pengeluaran']; 
					$totpemasukanpertanian += $opex['pemasukan'];    
				}
	
	
				if($opex['id_akun'] == '0101060103' ){
					$totpengeluaranpertanian += $opex['pengeluaran']; 
					$totpemasukanpertanian += $opex['pemasukan'];
				}

				if($opex['id_akun'] == '0101060204' ){
					$totpengeluaranperkebunan += $opex['pengeluaran']; 
					$totpemasukanperkebunan += $opex['pemasukan'];
				}

				if($opex['id_akun'] == '0101060104' ){           
					$totpengeluaranperkebunan += $opex['pengeluaran']; 
					$totpemasukanperkebunan += $opex['pemasukan'];
				}

				if($opex['id_akun'] == '0101060205' ){
					$totpengeluaranperikanan += $opex['pengeluaran']; 
					$totpemasukanperikanan += $opex['pemasukan'];    
				} 

				if($opex['id_akun'] == '0101060105' ){      
					$totpengeluaranperikanan += $opex['pengeluaran']; 
					$totpemasukanperikanan += $opex['pemasukan'];
				} 

				if($opex['id_akun'] == '0101060206' ){
					$totpengeluaranpeternakan += $opex['pengeluaran']; 
					$totpemasukanpeternakan += $opex['pemasukan'];     
				} 
	
				if($opex['id_akun'] == '0101060106' ){
					$totpengeluaranpeternakan += $opex['pengeluaran']; 
					$totpemasukanpeternakan += $opex['pemasukan'];
				}
	
				if($opex['id_akun'] == '0101060207' ){
					$totpengeluaranjasa += $opex['pengeluaran']; 
					$totpemasukanjasa += $opex['pemasukan'];
				}
				
				if($opex['id_akun'] == '0101060107' ){
					$totpengeluaranjasa += $opex['pengeluaran']; 
					$totpemasukanjasa += $opex['pemasukan'];
				
				} 
	
				if($opex['id_akun'] == '0101060208' ){           
					$totpengeluaranLainlain += $opex['pengeluaran']; 
					$totpemasukanLainlain += $opex['pemasukan'];       
				} 
				
				if($opex['id_akun'] == '0101060108' ){
					$totpengeluaranLainlain += $opex['pengeluaran']; 
					$totpemasukanLainlain += $opex['pemasukan'];
				
				}

				if($opex['id_akun'] == '0201040000' ){
					$totpengeluaranKelebihanPembayaranAngs += $opex['pengeluaran']; 
					$totpemasukanKelebihanPembayaranAngs += $opex['pemasukan'];
				} 
	
				if($opex['id_akun'] == '0201050000' ){
					$totpengeluaranAngsuranBelumTeridentifikasi += $opex['pengeluaran']; 
					$totpemasukanAngsuranBelumTeridentifikasi += $opex['pemasukan'];     
				}
				
				if($opex['id_akun'] == '0403010100' ){
					$totpengeluaranJasaAdmPinjaman += $opex['pengeluaran']; 
					$totpemasukanJasaAdmPinjaman += $opex['pemasukan'];         
				}
	
				if($opex['id_akun'] == '0403020100' ){
					$totpengeluaranJasaGiroPK += $opex['pengeluaran']; 
					$totpemasukanJasaGiroPK += $opex['pemasukan'];
				} 

				if($opex['id_akun'] == '0403030100' ){
					$totpengeluaranPendapatanLainlainPiutangHapusBuku += $opex['pengeluaran']; 
					$totpemasukanPendapatanLainlainPiutangHapusBuku += $opex['pemasukan'];
				}

				if($opex['id_akun'] == '0403030200' ){
					$totpengeluaranPendapatanLainlainPenyesuaian += $opex['pengeluaran']; 
					$totpemasukanPendapatanLainlainPenyesuaian += $opex['pemasukan']; 
				} 

				if($opex['id_akun'] == '0403030400' ){
					$totpengeluaranPendapatanLainlainLainlain += $opex['pengeluaran']; 
					$totpemasukanPendapatanLainlainLainlain += $opex['pemasukan'];
				} 

				if($opex['id_akun'] == '0407010000'){
					$totpengeluaranBebanUmum += $opex['pengeluaran']; 
					$totpemasukanBebanUmum += $opex['pemasukan'];         
				} 

				if($opex['id_akun'] == '411010100' ){            
					$totpengeluaranBebanPenyisihanPiutangIndustri += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPiutangIndustri += $opex['pemasukan'];
				} 

				if($opex['id_akun'] == '411020200' ){            
					$totpengeluaranBebanPenyisihanPiutangPerdagangan += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPiutangPerdagangan += $opex['pemasukan'];      
				} 

				if($opex['id_akun'] == '411030300' ){
					$totpengeluaranBebanPenyisihanPiutangPertanian += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPiutangPertanian += $opex['pemasukan'];    
				} 
				 
				if($opex['id_akun'] == '411040400' ){
					$totpengeluaranBebanPenyisihanPiutangPerkebunan += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPiutangPerkebunan += $opex['pemasukan'];          
				} 
	
				if($opex['id_akun'] == '411050500' ){
					$totpengeluaranBebanPenyisihanPiutangPerikanan += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPiutangPerikanan += $opex['pemasukan'];           
				} 
		
				if($opex['id_akun'] == '411060600'){        
					$totpengeluaranBebanPenyisihanPiutangPeternakan += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPiutangPeternakan += $opex['pemasukan'];    
				} 
	
				if($opex['id_akun'] == '411070700' ){
					$totpengeluaranBebanPenyisihanPiutangJasa += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPiutangJasa += $opex['pemasukan'];       
				} 
		
				if($opex['id_akun'] == '411080800' ){            
					$totpengeluaranBebanPenyisihanPiutangLainlain += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPiutangLainlain += $opex['pemasukan'];
				} 

				if($opex['id_akun'] == '0407010000' ){            
					$totpengeluaranBebanAdmdanUmum += $opex['pengeluaran']; 
					$totpemasukanBebanAdmdanUmum += $opex['pemasukan'];    
				}
	
				if($opex['id_akun'] == '0101080000' ){
					$totpengeluaranPiutangJasaAdmPinjaman += $opex['pengeluaran']; 
					$totpemasukanPiutangJasaAdmPinjaman += $opex['pemasukan'];    
				} 

				if($opex['id_akun'] == '0201050000' ){       
					$totpengeluaranAngsBelumTeridentifikasi += $opex['pengeluaran']; 
					$totpemasukanAngsBelumTeridentifikasi += $opex['pemasukan'];    
				} 

				if($opex['id_akun'] == '411010100' ){      
					$totpengeluaranBebanPenyisihanIndustri += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanIndustri += $opex['pemasukan'];
				}

				if($opex['id_akun'] == '411020200' ){
					$totpengeluaranBebanPenyisihanPerdagangan += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPerdagangan += $opex['pemasukan'];
				} 
	

				if($opex['id_akun'] == '411030300' ){
					$totpengeluaranBebanPenyisihanPertanian += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPertanian += $opex['pemasukan'];
				} 

				if($opex['id_akun'] == '411040400' ){
					$totpengeluaranBebanPenyisihanPerkebunan += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPerkebunan += $opex['pemasukan'];           
				} 

				if($opex['id_akun'] == '411050500' ){  
					$totpengeluaranBebanPenyisihanPerikanan += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPerikanan += $opex['pemasukan'];
				} 
	
				if($opex['id_akun'] == '411060600' ){
					$totpengeluaranBebanPenyisihanPeternakan += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanPeternakan += $opex['pemasukan'];
				} 
	

				if($opex['id_akun'] == '411070700' ){
					$totpengeluaranBebanPenyisihanJasa += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanJasa += $opex['pemasukan'];
				} 
	
				if($opex['id_akun'] == '411080800' ){
					$totpengeluaranBebanPenyisihanLainlain += $opex['pengeluaran']; 
					$totpemasukanBebanPenyisihanLainlain += $opex['pemasukan'];
				}  

				if($opex['id_akun'] == '103040201' ){
					$totpengeluaranAlokbermasalahindustri += $opex['pengeluaran']; 
					$totpemasukanAlokbermasalahindustri += $opex['pemasukan'];    
				} 

				if($opex['id_akun'] == '103040201' ){
					$totpengeluaranindustribermasalah += $opex['pengeluaran']; 
					$totpemasukanindustribermasalah += $opex['pemasukan'];             
				} 

				if($opex['id_akun'] == '103040202' ){
					$totpengeluaranperdaganganbermasalah += $opex['pengeluaran']; 
					$totpemasukanperdaganganbermasalah += $opex['pemasukan']; 
				} 

				if($opex['id_akun'] == '103040203' ){
					$totpengeluaranpertanianbermasalah += $opex['pengeluaran']; 
					$totpemasukanpertanianbermasalah += $opex['pemasukan'];         
				} 

				if($opex['id_akun'] == '103040204' ){
					$totpengeluaranperkebunanbermasalah += $opex['pengeluaran']; 
					$totpemasukanperkebunanbermasalah += $opex['pemasukan'];
				} 

				if($opex['id_akun'] == '103040205' ){
					$totpengeluaranperikananbermasalah += $opex['pengeluaran']; 
					$totpemasukanperikananbermasalah += $opex['pemasukan'];    
				} 

				if($opex['id_akun'] == '103040206' ){
					$totpengeluaranpeternakanbermasalah += $opex['pengeluaran']; 
					$totpemasukanpeternakanbermasalah += $opex['pemasukan'];     
				}  

				if($opex['id_akun'] == '103040207' ){
					$totpengeluaranjasabermasalah += $opex['pengeluaran']; 
					$totpemasukanjasabermasalah += $opex['pemasukan'];
				} 
				    
				if($opex['id_akun'] == '103040208' ){
					$totpengeluaranLainlainbermasalah += $opex['pengeluaran']; 
					$totpemasukanLainlainbermasalah += $opex['pemasukan'];            
				} 

				if($opex['id_akun'] == '412020400' ){            
					$totpengeluaranBebanLainlain += $opex['pengeluaran']; 
					$totpemasukanBebanLainlain += $opex['pemasukan'];
				}
			}
		}

		$totpemasukanBebanPenyisihanIndustri = round($totpemasukanBebanPenyisihanIndustri);
		$totpemasukanBebanPenyisihanPerdagangan = round($totpemasukanBebanPenyisihanPerdagangan);
		$totpemasukanBebanPenyisihanPertanian = round($totpemasukanBebanPenyisihanPertanian);
		$totpemasukanBebanPenyisihanPerkebunan = round($totpemasukanBebanPenyisihanPerkebunan);
		$totpemasukanBebanPenyisihanPerikanan = round($totpemasukanBebanPenyisihanPerikanan);
		$totpemasukanBebanPenyisihanPeternakan = round($totpemasukanBebanPenyisihanPeternakan);
		$totpemasukanBebanPenyisihanJasa = round($totpemasukanBebanPenyisihanJasa);
		$totpemasukanBebanPenyisihanLainlain = round($totpemasukanBebanPenyisihanLainlain);

		$totpengeluaranBebanPenyisihanIndustri = round($totpengeluaranBebanPenyisihanIndustri);
		$totpengeluaranBebanPenyisihanPerdagangan = round($totpengeluaranBebanPenyisihanPerdagangan);
		$totpengeluaranBebanPenyisihanPertanian = round($totpengeluaranBebanPenyisihanPertanian);
		$totpengeluaranBebanPenyisihanPerkebunan = round($totpengeluaranBebanPenyisihanPerkebunan);
		$totpengeluaranBebanPenyisihanPerikanan = round($totpengeluaranBebanPenyisihanPerikanan);
		$totpengeluaranBebanPenyisihanPeternakan = round($totpengeluaranBebanPenyisihanPeternakan);
		$totpengeluaranBebanPenyisihanJasa = round($totpengeluaranBebanPenyisihanJasa);
		$totpengeluaranBebanPenyisihanLainlain = round($totpengeluaranBebanPenyisihanLainlain);

		$totpengeluaranBebanAdmdanUmum = round($totpengeluaranBebanAdmdanUmum); 
		$totpemasukanBebanAdmdanUmum = round($totpemasukanBebanAdmdanUmum);    
		$totpengeluaranBebanLainlain = round($totpengeluaranBebanLainlain); 
		$totpemasukanBebanLainlain = round($totpemasukanBebanLainlain);

		//SETELAH DILAKUKAN LOOP PERHITUNGAN PER AKUN, maka disimpan di tabel neracasaldo dan di lakukan perhitungan
		$bulansekarang = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		$bulansebelumnya = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-2, date("d"), date("Y"))));
		
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukankas, '4'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluarankas, '4');

		$saldokasPKdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '4')[$desTahunLalu];//baca kas PK desTahunLalu
		$saldoKasPK=$saldokasPKdesTahunLalu+$totpemasukankas-$totpengeluarankas;
		$this->neracasaldo_model->updateNeracaSaldo($saldoKasPK, '4');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanmandiri, '5'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranmandiri, '5');
		$SaldoMandiridesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '5')[$desTahunLalu];   
		$saldoMandiriJurnal=$SaldoMandiridesTahunLalu+$totpemasukanmandiri-$totpengeluaranmandiri;    
		$this->neracasaldo_model->updateNeracaSaldo($saldoMandiriJurnal, '5');//  

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanbri, '7'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranbri, '7');

		$SaldoBRIdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '7')[$desTahunLalu];   
		$saldoBRIJurnal=$SaldoBRIdesTahunLalu+$totpemasukanbri-$totpengeluaranbri;    

		$this->neracasaldo_model->updateNeracaSaldo($saldoBRIJurnal, '7');//  

		$debetno3=$totpemasukankas+$totpemasukanmandiri+$totpemasukanbri;
		$kreditno3=$totpengeluarankas+$totpengeluaranmandiri+$totpengeluaranbri;

		$this->neracasaldo_model->updateNeracaSaldoDebet($debetno3, '3'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($kreditno3, '3');

		$SaldoKasSetaraKasdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '3')[$desTahunLalu];   

		$SaldoKasSetaraKas= $SaldoKasSetaraKasdesTahunLalu+$debetno3-$kreditno3;
		$this->neracasaldo_model->updateNeracaSaldo($SaldoKasSetaraKas, '3');//  

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanindustribermasalah, '30'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranindustribermasalah, '30');

		$aloktotpemasukanindustribermasalah=$totpemasukanindustribermasalah;
		$aloktotpengeluaranindustribermasalah=$totpengeluaranindustribermasalah;

		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanindustribermasalah, '39'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranindustribermasalah, '39');

		$sektorindustriBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '30')[$desTahunLalu];   

		$sektorindustriBermasalah= $sektorindustriBermasalahdesTahunLalu+$totpemasukanindustribermasalah-$totpengeluaranindustribermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($sektorindustriBermasalah, '30');//  

		$aloksektorindustriBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '39')[$desTahunLalu];   

		$aloksektorindustriBermasalah= $aloksektorindustriBermasalahdesTahunLalu-$aloktotpemasukanindustribermasalah+$aloktotpengeluaranindustribermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($aloksektorindustriBermasalah, '39');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanperdaganganbermasalah, '31'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranperdaganganbermasalah, '31');
		$aloktotpemasukanperdaganganbermasalah=$totpemasukanperdaganganbermasalah;
		$aloktotpengeluaranperdaganganbermasalah=$totpengeluaranperdaganganbermasalah;

		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanperdaganganbermasalah, '40'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranperdaganganbermasalah, '40');

		$sektorperdaganganBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '31')[$desTahunLalu];   

		$sektorperdaganganBermasalah= $sektorperdaganganBermasalahdesTahunLalu+$totpemasukanperdaganganbermasalah-$totpengeluaranperdaganganbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($sektorperdaganganBermasalah, '31');//  
		$aloksektorperdaganganBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '40')[$desTahunLalu];   

		$aloksektorperdaganganBermasalah= $aloksektorperdaganganBermasalahdesTahunLalu-$aloktotpemasukanperdaganganbermasalah+$aloktotpengeluaranperdaganganbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($aloksektorperdaganganBermasalah, '40');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanpertanianbermasalah, '32'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranpertanianbermasalah, '32');
		$aloktotpemasukanpertanianbermasalah=$totpemasukanpertanianbermasalah;
		$aloktotpengeluaranpertanianbermasalah=$totpengeluaranpertanianbermasalah;

		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanpertanianbermasalah, '41'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranpertanianbermasalah, '41');

		$sektorpertanianBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '32')[$desTahunLalu];   

		$sektorpertanianBermasalah= $sektorpertanianBermasalahdesTahunLalu+$totpemasukanpertanianbermasalah-$totpengeluaranpertanianbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($sektorpertanianBermasalah, '32');//  
		$aloksektorpertanianBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '41')[$desTahunLalu];   

		$aloksektorpertanianBermasalah= $aloksektorpertanianBermasalahdesTahunLalu-$totpemasukanpertanianbermasalah+$totpengeluaranpertanianbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($aloksektorpertanianBermasalah, '41');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanperkebunanbermasalah, '33'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranperkebunanbermasalah, '33');

		$aloktotpemasukanperkebunanbermasalah=$totpemasukanperkebunanbermasalah;
		$aloktotpengeluaranperkebunanbermasalah=$totpengeluaranperkebunanbermasalah;

		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanperkebunanbermasalah, '42'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranperkebunanbermasalah, '42');


		$sektorperkebunanBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '33')[$desTahunLalu];   

		$sektorperkebunanBermasalah= $sektorperkebunanBermasalahdesTahunLalu+$totpemasukanperkebunanbermasalah-$totpengeluaranperkebunanbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($sektorperkebunanBermasalah, '33');//  
		$aloksektorperkebunanBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '42')[$desTahunLalu];   

		$aloksektorperkebunanBermasalah= $aloksektorperkebunanBermasalahdesTahunLalu-$aloktotpemasukanperkebunanbermasalah+$aloktotpengeluaranperkebunanbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($aloksektorperkebunanBermasalah, '42');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanperikananbermasalah, '34'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranperikananbermasalah, '34');

		$aloktotpemasukanperikananbermasalah=$totpemasukanperikananbermasalah;
		$aloktotpengeluaranperikananbermasalah=$totpengeluaranperikananbermasalah;

		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanperikananbermasalah, '43'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranperikananbermasalah, '43');

		$sektorperikananBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '34')[$desTahunLalu];   

		$sektorperikananBermasalah= $sektorperikananBermasalahdesTahunLalu+$totpemasukanperikananbermasalah-$totpengeluaranperikananbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($sektorperikananBermasalah, '34');//  

		$aloksektorperikananBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '43')[$desTahunLalu];   

		$aloksektorperikananBermasalah= $aloksektorperikananBermasalahdesTahunLalu-$aloktotpemasukanperikananbermasalah+$aloktotpengeluaranperikananbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($aloksektorperikananBermasalah, '43');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanpeternakanbermasalah, '35'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranpeternakanbermasalah, '35');
		$aloktotpemasukanpeternakanbermasalah=$totpemasukanpeternakanbermasalah;
		$aloktotpengeluaranpeternakanbermasalah=$totpengeluaranpeternakanbermasalah;

		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanpeternakanbermasalah, '44'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranpeternakanbermasalah, '44');
		

		$sektorpeternakanBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '35')[$desTahunLalu];   

		$sektorpeternakanBermasalah= $sektorpeternakanBermasalahdesTahunLalu+$totpemasukanpeternakanbermasalah-$totpengeluaranpeternakanbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($sektorpeternakanBermasalah, '35');//  

		$aloksektorpeternakanBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '44')[$desTahunLalu];   

		$aloksektorpeternakanBermasalah= $aloksektorpeternakanBermasalahdesTahunLalu-$aloktotpemasukanpeternakanbermasalah+$aloktotpengeluaranpeternakanbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($aloksektorpeternakanBermasalah, '44');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanjasabermasalah, '36'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranjasabermasalah, '36');

		$aloktotpemasukanjasabermasalah=$totpemasukanjasabermasalah;
		$aloktotpengeluaranjasabermasalah=$totpengeluaranjasabermasalah;
		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanjasabermasalah, '45'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranjasabermasalah, '45');

		$sektorjasaBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '36')[$desTahunLalu];   

		$sektorjasaBermasalah= $sektorjasaBermasalahdesTahunLalu+$aloktotpemasukanjasabermasalah-$aloktotpengeluaranjasabermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($sektorjasaBermasalah, '36');//  

		$aloksektorjasaBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '45')[$desTahunLalu];   

		$aloksektorjasaBermasalah= $aloksektorjasaBermasalahdesTahunLalu-$aloktotpemasukanjasabermasalah+$aloktotpengeluaranjasabermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($aloksektorjasaBermasalah, '45');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanLainlainbermasalah, '37'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranLainlainbermasalah, '37');
		$aloktotpemasukanLainlainbermasalah=$totpemasukanLainlainbermasalah;
		$aloktotpengeluaranLainlainbermasalah=$totpengeluaranLainlainbermasalah;

		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanLainlainbermasalah, '46'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranLainlainbermasalah, '46');

		$sektorLainlainBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '37')[$desTahunLalu];   

		$sektorLainlainBermasalah= $sektorLainlainBermasalahdesTahunLalu+$totpemasukanLainlainbermasalah-$totpengeluaranLainlainbermasalah;
		$this->neracasaldo_model->updateNeracaSaldo($sektorLainlainBermasalah, '37');//  

		$aloksektorLainlainBermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '46')[$desTahunLalu];   

		$aloksektorLainlainBermasalah= $aloksektorLainlainBermasalahdesTahunLalu-$aloktotpemasukanLainlainbermasalah+$aloktotpengeluaranLainlainbermasalah;

		$this->neracasaldo_model->updateNeracaSaldo($aloksektorLainlainBermasalah, '46');

		$aloktotpemasukanindustri1= round($aloktotpemasukanindustri-$aloktotpemasukanindustribermasalah);//(21-39)
		$aloktotpengeluaranindustri1=round($aloktotpengeluaranindustri-$aloktotpengeluaranindustribermasalah);

		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranindustri1, '21');
		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanindustri1, '21'); 

		$aloksektorIndustridesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '21')[$desTahunLalu];   
		$aloksektorIndustri=$aloksektorIndustridesTahunLalu+$aloktotpengeluaranindustri1-$aloktotpemasukanindustri1;
		$this->neracasaldo_model->updateNeracaSaldo($aloksektorIndustri, '21');  

		$aloktotpemasukanperdagangan1= round($aloktotpemasukanperdagangan-$aloktotpemasukanperdaganganbermasalah);//(22-40)
		$aloktotpengeluaranperdagangan1= round ($aloktotpengeluaranperdagangan-$aloktotpengeluaranperdaganganbermasalah);
		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanperdagangan1, '22'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranperdagangan1, '22');

		$aloksektorperdagangandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '22')[$desTahunLalu];   
		$aloksektorperdagangan=$aloksektorperdagangandesTahunLalu+$aloktotpengeluaranperdagangan1-$aloktotpemasukanperdagangan1;
		$this->neracasaldo_model->updateNeracaSaldo($aloksektorperdagangan, '22');  

		$aloktotpemasukanpertanian1= round($aloktotpemasukanpertanian-$aloktotpemasukanpertanianbermasalah);//(23-41)
		$aloktotpengeluaranpertanian1= round ($aloktotpengeluaranpertanian-$aloktotpengeluaranpertanianbermasalah);
		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanpertanian1, '23'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranpertanian1, '23');

		$aloksektorpertaniandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '23')[$desTahunLalu];   
		$aloksektorpertanian=$aloksektorpertaniandesTahunLalu+$aloktotpengeluaranpertanian1-$aloktotpemasukanpertanian1;
		$this->neracasaldo_model->updateNeracaSaldo($aloksektorpertanian, '23');  

		$aloktotpemasukanperkebunan1= round($aloktotpemasukanperkebunan-$aloktotpemasukanperkebunanbermasalah);//(24-42)
		$aloktotpengeluaranperkebunan1=round($aloktotpengeluaranperkebunan-$aloktotpengeluaranperkebunanbermasalah);
		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanperkebunan1, '24'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranperkebunan1, '24');

		$aloksektorperkebunandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '24')[$desTahunLalu];   
		$aloksektorperkebunan=$aloksektorperkebunandesTahunLalu+$aloktotpengeluaranperkebunan1-$aloktotpemasukanperkebunan1;
		$this->neracasaldo_model->updateNeracaSaldo($aloksektorperkebunan, '24');  

		$aloktotpemasukanperikanan1= round($aloktotpemasukanperikanan-$aloktotpemasukanperikananbermasalah);//(25-43)
		$aloktotpengeluaranperikanan1= round($aloktotpengeluaranperikanan-$aloktotpengeluaranperikananbermasalah);
		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanperikanan1, '25'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranperikanan1, '25');

		$aloksektorperikanandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '25')[$desTahunLalu];   
		$aloksektorperikanan=$aloksektorperikanandesTahunLalu+$aloktotpengeluaranperikanan1-$aloktotpemasukanperikanan1;
		$this->neracasaldo_model->updateNeracaSaldo($aloksektorperikanan, '25');  

		$aloktotpemasukanpeternakan1= round($aloktotpemasukanpeternakan-$aloktotpemasukanpeternakanbermasalah) ; //(26-44)
		$aloktotpengeluaranpeternakan1= round($aloktotpengeluaranpeternakan-$aloktotpengeluaranpeternakanbermasalah);
		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanpeternakan1, '26'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranpeternakan1, '26');

		$aloksektorpeternakandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '26')[$desTahunLalu];   
		$aloksektorpeternakan=$aloksektorpeternakandesTahunLalu+$aloktotpengeluaranpeternakan1-$aloktotpemasukanpeternakan1;
		$this->neracasaldo_model->updateNeracaSaldo($aloksektorpeternakan, '26');  

		$aloktotpemasukanjasa1= round($aloktotpemasukanjasa-$aloktotpemasukanjasabermasalah);//27-45 $totpemasukanjasabermasalah
		$aloktotpengeluaranjasa1=round( $aloktotpengeluaranjasa-$aloktotpengeluaranjasabermasalah);
		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanjasa1, '27'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranjasa1, '27');

		$aloksektorjasadesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '27')[$desTahunLalu];   
		$aloksektorjasa=$aloksektorjasadesTahunLalu+$aloktotpengeluaranjasa1-$aloktotpemasukanjasa1;
		$this->neracasaldo_model->updateNeracaSaldo($aloksektorjasa, '27');  

		$aloktotpemasukanLainlain1= round($aloktotpemasukanLainlain-$aloktotpemasukanLainlainbermasalah);//28-46
		$aloktotpengeluaranLainlain1= round($aloktotpengeluaranLainlain-$aloktotpengeluaranLainlainbermasalah);
		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotpemasukanLainlain1, '28'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotpengeluaranLainlain1, '28');

		$aloksektorLainlaindesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '28')[$desTahunLalu];   
		$aloksektorLainlain=$aloksektorLainlaindesTahunLalu+$aloktotpengeluaranLainlain1-$aloktotpemasukanLainlain1;
		
		$this->neracasaldo_model->updateNeracaSaldo($aloksektorLainlain, '28');  
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanindustri, '12'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranindustri, '12');

		$totpiutangindustridesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '12')[$desTahunLalu];    

		$totpiutangindustri=$totpiutangindustridesTahunLalu+$totpemasukanindustri-$totpengeluaranindustri;

		$this->neracasaldo_model->updateNeracaSaldo($totpiutangindustri, '12');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanperdagangan, '13'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranperdagangan, '13');

		$totpiutangperdagangandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '13')[$desTahunLalu];    

		$totpiutangperdagangan=$totpiutangperdagangandesTahunLalu+$totpemasukanperdagangan-$totpengeluaranperdagangan;

		$this->neracasaldo_model->updateNeracaSaldo($totpiutangperdagangan, '13');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanpertanian, '14'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranpertanian, '14');

		$totpiutangpertaniandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '14')[$desTahunLalu];    

		$totpiutangpertanian=$totpiutangpertaniandesTahunLalu+$totpemasukanpertanian-$totpengeluaranpertanian;

		$this->neracasaldo_model->updateNeracaSaldo($totpiutangpertanian, '14');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanperkebunan, '15'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranperkebunan, '15');

		$totpiutangperkebunandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '15')[$desTahunLalu];    

		$totpiutangperkebunan=$totpiutangperkebunandesTahunLalu+$totpemasukanperkebunan-$totpengeluaranperkebunan;

		$this->neracasaldo_model->updateNeracaSaldo($totpiutangperkebunan, '15');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanperikanan, '16'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranperikanan, '16');

		$totpiutangperikanandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '16')[$desTahunLalu];    

		$totpiutangperikanan=$totpiutangperikanandesTahunLalu+$totpemasukanperikanan-$totpengeluaranperikanan;

		$this->neracasaldo_model->updateNeracaSaldo($totpiutangperikanan, '16');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanpeternakan, '17'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranpeternakan, '17');

		$totpiutangpeternakandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '17')[$desTahunLalu];    

		$totpiutangpeternakan=$totpiutangpeternakandesTahunLalu+$totpemasukanpeternakan-$totpengeluaranpeternakan;

		$this->neracasaldo_model->updateNeracaSaldo($totpiutangpeternakan, '17');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanjasa, '18'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranjasa, '18');

		$totpiutangjasadesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '18')[$desTahunLalu];    
		
		$totpiutangjasa=$totpiutangjasadesTahunLalu+$totpemasukanjasa-$totpengeluaranjasa;

		$this->neracasaldo_model->updateNeracaSaldo($totpiutangjasa, '18');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanLainlain, '19'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranLainlain, '19');

		$totpiutangLainlaindesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '19')[$desTahunLalu];    

		$totpiutangLainlain=$totpiutangLainlaindesTahunLalu+$totpemasukanLainlain-$totpengeluaranLainlain;

		$this->neracasaldo_model->updateNeracaSaldo($totpiutangLainlain, '19');

		$lapkasPK = $this->getElementData($catatanAtasLapKeu, '1')[$bulansekarang];   

		$saldomandiri = $this->getElementData($catatanAtasLapKeu, '4')[$bulansekarang];   

		$mandiri = $this->getElementData($catatanAtasLapKeu, '4')[$bulansekarang];   

		$saldobri = $this->getElementData($catatanAtasLapKeu, '5')[$bulansekarang];   

		if( round($saldoKasPK)!= round($lapkasPK) ){
			echo ' false no 4 $saldoKasPK (lap vs jurnal)';
			echo ' $saldoKasPK$bulansekarang='; echo $saldoKasPK;
			echo ' $lapKasPK$bulansekarang='; echo $lapkasPK;
			$selisih=$saldoKasPK-$lapKasPK;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '4');
		}else{
			echo ' true no 4 $saldoKasPK (lap vs jurnal)'; 
			echo ' $saldoKasPK$bulansekarang='; echo $saldoKasPK;
			echo ' $lapKasPK$bulansekarang='; echo $lapkasPK;
			$selisih=$saldoKasPK-$lapkasPK;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '4');
		} 
		echo nl2br("\n");

		if(round ($saldomandiri) != round($saldoMandiriJurnal)){
			echo ' false no 5 $saldomandiri (lap vs jurnal) '; 
			echo ' $saldomandiri$bulansekarang='; echo $saldomandiri; echo ' VS ';
			echo ' $saldoMandiriJurnal$bulansekarang='; echo $saldoMandiriJurnal;
			echo ' selisih='; echo $selisih; 
			$selisih=$saldomandiri-$saldoMandiriJurnal;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '5');
		}else{
			echo 'true no 5 $saldomandiri'; 
			echo ' $saldomandiri$bulansekarang='; echo $saldomandiri; echo ' VS ';
			echo ' $saldoMandiriJurnal$bulansekarang='; echo $saldoMandiriJurnal;
			$selisih=$saldomandiri-$saldoMandiriJurnal;
			echo ' selisih='; echo $selisih;  
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '5');
		} 
		echo nl2br("\n");

		if( round($saldobri)!= round($saldoBRIJurnal)){ 
			echo 'false no 7 $saldobri (lap vs jurnal)';  
			echo ' $saldobri$bulansekarang='; echo $saldobri;
			echo ' $saldoBRIJurnal$bulansekarang='; echo $saldoBRIJurnal;     
			$selisih=$saldobri-$saldoBRIJurnal;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '7'); 
		}else{
			echo 'true no 7 $saldobri (lap vs jurnal)';  
			echo ' $saldobri$bulansekarang='; echo $saldobri;
			echo ' $saldoBRIJurnal$bulansekarang='; echo $saldoBRIJurnal;
			$selisih=$saldobri-$saldoBRIJurnal;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '7');
		} 
		echo nl2br("\n");

		$totPiutangMitraBinaanbermasalahDebet=
		+$totpemasukanindustribermasalah+$totpemasukanperdaganganbermasalah+$totpemasukanpertanianbermasalah+$totpemasukanperkebunanbermasalah
		+$totpemasukanperikananbermasalah+$totpemasukanpeternakanbermasalah+$totpemasukanjasabermasalah+$totpemasukanLainlainbermasalah;

		$totPiutangMitraBinaanbermasalahKredit=
		$totpengeluaranindustribermasalah+$totpengeluaranperdaganganbermasalah+$totpengeluaranpertanianbermasalah+$totpengeluaranperkebunanbermasalah
		+$totpengeluaranperikananbermasalah+$totpengeluaranpeternakanbermasalah+$totpengeluaranjasabermasalah+$totpengeluaranLainlainbermasalah;

		$debetAlokasiPenyisihanPiutangBermasalah=$totPiutangMitraBinaanbermasalahKredit;
		$kreditAlokasiPenyisihanPiutangBermasalah=$totPiutangMitraBinaanbermasalahDebet;

		$aloktotDebetAlokPenyisihanPiutang=
		$aloktotpemasukanindustri1+$aloktotpemasukanperdagangan1+$aloktotpemasukanpertanian1+$aloktotpemasukanperkebunan1+$aloktotpemasukanperikanan1+$aloktotpemasukanpeternakan1+$aloktotpemasukanjasa1+$aloktotpemasukanLainlain1;

		$this->neracasaldo_model->updateNeracaSaldoKredit($aloktotDebetAlokPenyisihanPiutang, '20');  //$selisihkreditaloksektorindustri

		$aloktotKreditAlokPenyisihanPiutang=
		$aloktotpengeluaranindustri1+$aloktotpengeluaranperdagangan1+$aloktotpengeluaranpertanian1+$aloktotpengeluaranperkebunan1+$aloktotpengeluaranperikanan1+$aloktotpengeluaranpeternakan1+$aloktotpengeluaranjasa1+$aloktotpengeluaranLainlain1;

		$this->neracasaldo_model->updateNeracaSaldoDebet($aloktotKreditAlokPenyisihanPiutang, '20');  

		$aloktotSaldoAlokPenyisihanPiutangdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '20')[$desTahunLalu];   

		$aloktotSaldoAlokPenyisihanPiutang= $aloktotSaldoAlokPenyisihanPiutangdesTahunLalu-$aloktotDebetAlokPenyisihanPiutang+$aloktotKreditAlokPenyisihanPiutang;

		$this->neracasaldo_model->updateNeracaSaldo($aloktotSaldoAlokPenyisihanPiutang, '20');  

		$piutangMBbersih=$piutangMBdesTahunLalu+$alokasiSisihMBdesTahunLalu;

		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($piutangMBbersih, '10');  

		$totPiutangMitraBinaanDebet=
		$totpemasukanindustri+$totpemasukanperdagangan+$totpemasukanpertanian+$totpemasukanperkebunan
		+$totpemasukanperikanan+$totpemasukanpeternakan+$totpemasukanjasa+$totpemasukanLainlain;

		$debetPiutangMBbersih=$debetAlokasiPenyisihanPiutangBermasalah+$totPiutangMitraBinaanbermasalahDebet+
		$aloktotKreditAlokPenyisihanPiutang+$totPiutangMitraBinaanDebet;

		$this->neracasaldo_model->updateNeracaSaldoDebet($debetPiutangMBbersih, '10');

		echo nl2br("\n");

		$totPiutangMitraBinaanKredit=
		$totpengeluaranindustri+$totpengeluaranperdagangan+$totpengeluaranpertanian+$totpengeluaranperkebunan
		+$totpengeluaranperikanan+$totpengeluaranpeternakan+$totpengeluaranjasa+$totpengeluaranLainlain;

		$kreditPiutangMBbersih=$kreditAlokasiPenyisihanPiutangBermasalah+$totPiutangMitraBinaanbermasalahKredit+$aloktotDebetAlokPenyisihanPiutang+$totPiutangMitraBinaanKredit;

		$this->neracasaldo_model->updateNeracaSaldoKredit($kreditPiutangMBbersih, '10');

		$PiutangMBbersihdesTahunLalu=$piutangMBbersih;
		$PiutangMBbersih=$PiutangMBbersihdesTahunLalu+$debetPiutangMBbersih-$kreditPiutangMBbersih;

		$this->neracasaldo_model->updateNeracaSaldo($PiutangMBbersih, '10');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanPiutangJasaAdmPinjaman, '47'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranPiutangJasaAdmPinjaman, '47');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanPiutangJasaAdmPinjaman, '48'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranPiutangJasaAdmPinjaman, '48');

		$this->neracasaldo_model->updateNeracaSaldoDebet(0, '49'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit(0, '49');
		$this->neracasaldo_model->updateNeracaSaldoDebet(0, '50'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit(0, '50');

		$this->neracasaldo_model->updateNeracaSaldoDebet(0, '51'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit(0, '51');
		$this->neracasaldo_model->updateNeracaSaldoDebet(0, '52'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit(0, '52');

		$totPiutangMitraBinaanDebet=
		$totpemasukanindustri+$totpemasukanperdagangan+$totpemasukanpertanian+$totpemasukanperkebunan
		+$totpemasukanperikanan+$totpemasukanpeternakan+$totpemasukanjasa+$totpemasukanLainlain;

		$this->neracasaldo_model->updateNeracaSaldoDebet($totPiutangMitraBinaanDebet, '11'); 

		$totPiutangMitraBinaanKredit=
		$totpengeluaranindustri+$totpengeluaranperdagangan+$totpengeluaranpertanian+$totpengeluaranperkebunan
		+$totpengeluaranperikanan+$totpengeluaranpeternakan+$totpengeluaranjasa+$totpengeluaranLainlain;

		$this->neracasaldo_model->updateNeracaSaldoKredit($totPiutangMitraBinaanKredit, '11'); 

		$piutangMitraBinaandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '11')[$desTahunLalu];   

		$piutangMitraBinaan=$piutangMitraBinaandesTahunLalu+$totPiutangMitraBinaanDebet-$totPiutangMitraBinaanKredit;         

		$this->neracasaldo_model->updateNeracaSaldo($piutangMitraBinaan, '11');  

		$totLiabilitasDebet=$totpemasukanAngsBelumTeridentifikasi+$totpemasukanKelebihanPembayaranAngs;
		$totLiabilitasKredit=$totpengeluaranAngsBelumTeridentifikasi+$totpengeluaranKelebihanPembayaranAngs;

		$this->neracasaldo_model->updateNeracaSaldoDebet($totLiabilitasDebet, '54'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totLiabilitasKredit, '54');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totLiabilitasDebet, '55'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totLiabilitasKredit, '55');

		$LiabilitasdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '54')[$desTahunLalu];   

		$totLiabilitasSaldo=$LiabilitasdesTahunLalu+$totLiabilitasKredit-$totLiabilitasDebet;

		$this->neracasaldo_model->updateNeracaSaldo($totLiabilitasSaldo, '54');//
		$this->neracasaldo_model->updateNeracaSaldo($totLiabilitasSaldo, '55');//

		$totpemasukanBebanAdmdanUmum=round($totpemasukanBebanAdmdanUmum);
		$bebanAdmdanUmumdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '65')[$desTahunLalu];   

		$bebanAdmdanUmum=$totpengeluaranBebanAdmdanUmum-$totpemasukanBebanAdmdanUmum;

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanAdmdanUmum, '66'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanAdmdanUmum, '66');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanAdmdanUmum, '67'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanAdmdanUmum, '67');
			
		$this->neracasaldo_model->updateNeracaSaldo($bebanAdmdanUmum, '66');
		$this->neracasaldo_model->updateNeracaSaldo($bebanAdmdanUmum, '67');

		$jumBebanPenyisihanIndustri= 0-( $totpemasukanBebanPenyisihanIndustri-$totpengeluaranBebanPenyisihanIndustri);

		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanPenyisihanIndustri, '69');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanPenyisihanIndustri, '69');
		$this->neracasaldo_model->updateNeracaSaldo($jumBebanPenyisihanIndustri, '69');

		$jumBebanPenyisihanPerdagangan= 0-( $totpemasukanBebanPenyisihanPerdagangan-$totpengeluaranBebanPenyisihanPerdagangan);

		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanPenyisihanPerdagangan, '70');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanPenyisihanPerdagangan, '70');
		$this->neracasaldo_model->updateNeracaSaldo($jumBebanPenyisihanPerdagangan, '70');

		$jumBebanPenyisihanPertanian= 0-( $totpemasukanBebanPenyisihanPertanian-$totpengeluaranBebanPenyisihanPertanian);

		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanPenyisihanPertanian, '71');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanPenyisihanPertanian, '71');
		$this->neracasaldo_model->updateNeracaSaldo($jumBebanPenyisihanPertanian, '71');

		$jumBebanPenyisihanPerkebunan= 0-( $totpemasukanBebanPenyisihanPerkebunan-$totpengeluaranBebanPenyisihanPerkebunan);

		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanPenyisihanPerkebunan, '72');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanPenyisihanPerkebunan, '72');
		$this->neracasaldo_model->updateNeracaSaldo($jumBebanPenyisihanPerkebunan, '72');

		$jumBebanPenyisihanPerikanan=  0-($totpemasukanBebanPenyisihanPerikanan-$totpengeluaranBebanPenyisihanPerikanan);

		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanPenyisihanPerikanan, '73');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanPenyisihanPerikanan, '73');
		$this->neracasaldo_model->updateNeracaSaldo($jumBebanPenyisihanPerikanan, '73');

		$jumBebanPenyisihanPeternakan=0-( $totpemasukanBebanPenyisihanPeternakan-$totpengeluaranBebanPenyisihanPeternakan);

		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanPenyisihanPeternakan, '74');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanPenyisihanPeternakan, '74');
		$this->neracasaldo_model->updateNeracaSaldo($jumBebanPenyisihanPeternakan, '74');

		$jumBebanPenyisihanJasa=0-( $totpemasukanBebanPenyisihanJasa-$totpengeluaranBebanPenyisihanJasa);

		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanPenyisihanJasa, '75');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanPenyisihanJasa, '75');
		$this->neracasaldo_model->updateNeracaSaldo($jumBebanPenyisihanJasa, '75');

		$jumBebanPenyisihanLainlain= $sektorLainlaindesTahunLalu+ $totpemasukanBebanPenyisihanLainlain-$totpengeluaranBebanPenyisihanLainlain;

		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanPenyisihanLainlain, '76');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanPenyisihanLainlain, '76');
		$this->neracasaldo_model->updateNeracaSaldo($jumBebanPenyisihanLainlain, '76');


		$totDebetBebanPenyisihan=
			$totpemasukanBebanPenyisihanIndustri
			+$totpemasukanBebanPenyisihanPerdagangan
			+$totpemasukanBebanPenyisihanPertanian
			+$totpemasukanBebanPenyisihanPerkebunan
			+$totpemasukanBebanPenyisihanPerikanan
			+$totpemasukanBebanPenyisihanPeternakan
			+$totpemasukanBebanPenyisihanJasa
			+$totpemasukanBebanPenyisihanLainlain;

		$this->neracasaldo_model->updateNeracaSaldoDebet($totDebetBebanPenyisihan, '68');

		$totKreditBebanPenyisihan=
			$totpengeluaranBebanPenyisihanIndustri
			+$totpengeluaranBebanPenyisihanPerdagangan
			+$totpengeluaranBebanPenyisihanPertanian
			+$totpengeluaranBebanPenyisihanPerkebunan
			+$totpengeluaranBebanPenyisihanPerikanan
			+$totpengeluaranBebanPenyisihanPeternakan
			+$totpengeluaranBebanPenyisihanJasa
			+$totpengeluaranBebanPenyisihanLainlain;

		$this->neracasaldo_model->updateNeracaSaldoKredit($totKreditBebanPenyisihan, '68');

		$totBebanPenyisihandesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '68')[$desTahunLalu];   
		$totBebanPenyisihan=$totKreditBebanPenyisihan-$totDebetBebanPenyisihan;

		$this->neracasaldo_model->updateNeracaSaldo($totBebanPenyisihan, '68');

		$totpemasukanBebanLainlain=$totpemasukanBebanLainlain-2;
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanLainlain, '77'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanLainlain, '77');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanLainlain, '78'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanLainlain, '78');

		$BebanLainlaindesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '77')[$desTahunLalu];   

		$BebanLainlain=   $totpengeluaranBebanLainlain-$totpemasukanBebanLainlain;

		$this->neracasaldo_model->updateNeracaSaldo($BebanLainlain, '77');

		$this->neracasaldo_model->updateNeracaSaldo($BebanLainlain, '78');

		$totPiutangMitraBinaanbermasalahDebet=
			$totpemasukanindustribermasalah
			+$totpemasukanperdaganganbermasalah
			+$totpemasukanpertanianbermasalah
			+$totpemasukanperkebunanbermasalah
			+$totpemasukanperikananbermasalah
			+$totpemasukanpeternakanbermasalah    
			+$totpemasukanjasabermasalah
			+$totpemasukanLainlainbermasalah;

		$this->neracasaldo_model->updateNeracaSaldoKredit($totPiutangMitraBinaanbermasalahDebet, '38');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totPiutangMitraBinaanbermasalahDebet, '29');  
		$totPiutangMitraBinaanbermasalahKredit=
			$totpengeluaranindustribermasalah
			+$totpengeluaranperdaganganbermasalah
			+$totpengeluaranpertanianbermasalah
			+$totpengeluaranperkebunanbermasalah
			+$totpengeluaranperikananbermasalah
			+$totpengeluaranpeternakanbermasalah
			+$totpengeluaranjasabermasalah
			+$totpengeluaranLainlainbermasalah;

		$this->neracasaldo_model->updateNeracaSaldoKredit($totPiutangMitraBinaanbermasalahKredit, '29'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($totPiutangMitraBinaanbermasalahKredit, '38'); //Alokasi Penyisihan Piutang Bermasalah


			$totPiutangMitraBinaanbermasalahdesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '29')[$desTahunLalu]; 


		$totPiutangMitraBinaanbermasalah=$totPiutangMitraBinaanbermasalahdesTahunLalu+$totPiutangMitraBinaanbermasalahDebet-$totPiutangMitraBinaanbermasalahKredit;

		$this->neracasaldo_model->updateNeracaSaldo($totPiutangMitraBinaanbermasalah, '29'); 
		$aloktotPiutangMitraBinaanbermasalah=0-$totPiutangMitraBinaanbermasalah;
		$this->neracasaldo_model->updateNeracaSaldo($aloktotPiutangMitraBinaanbermasalah, '38'); //Alokasi Penyisihan Piutang Bermasalah

		$DebetLiabilitasJangkaPendek=$totpemasukanAngsuranBelumTeridentifikasi+$totpemasukanKelebihanPembayaranAngs;
		$this->neracasaldo_model->updateNeracaSaldoDebet($DebetLiabilitasJangkaPendek, '54'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($DebetLiabilitasJangkaPendek, '55'); 

		$KreditLiabilitasJangkaPendek=$totpengeluaranAngsuranBelumTeridentifikasi+$totpengeluaranKelebihanPembayaranAngs;
		$this->neracasaldo_model->updateNeracaSaldoKredit($KreditLiabilitasJangkaPendek, '54');
		$this->neracasaldo_model->updateNeracaSaldoKredit($KreditLiabilitasJangkaPendek, '55');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanKelebihanPembayaranAngs, '56'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranKelebihanPembayaranAngs, '56');

		$totpengeluaranKelebihanPembayaranAngsdesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '52')[$desTahunLalu];   

		$totpengeluaranKelebihanPembayaranAngs=$totpengeluaranKelebihanPembayaranAngsdesTahunLalu-
		$totpemasukanKelebihanPembayaranAngs+$totpengeluaranKelebihanPembayaranAngs;

		$this->neracasaldo_model->updateNeracaSaldo($totpengeluaranKelebihanPembayaranAngs, '56');
		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanAngsuranBelumTeridentifikasi, '57'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranAngsuranBelumTeridentifikasi, '57');

		$angsBelumTeridentifikasidesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '53')[$desTahunLalu];   

		$angsBelumTeridentifikasi=$angsBelumTeridentifikasidesTahunLalu+$totpemasukanAngsuranBelumTeridentifikasi-$totpengeluaranAngsuranBelumTeridentifikasi;

		$this->neracasaldo_model->updateNeracaSaldo($angsBelumTeridentifikasi, '57');  

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanJasaAdmPinjaman, '61'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranJasaAdmPinjaman, '61');

		$saldoJasaAdmPinjaman=$totpengeluaranJasaAdmPinjaman-$totpemasukanJasaAdmPinjaman;
		$this->neracasaldo_model->updateNeracaSaldo($saldoJasaAdmPinjaman, '61');

		$totDebetBebanPenyisihanPiutang=round(
			$totpemasukanBebanPenyisihanPiutangIndustri
			+$totpemasukanBebanPenyisihanPiutangPerdagangan
			+$totpemasukanBebanPenyisihanPiutangPertanian
			+$totpemasukanBebanPenyisihanPiutangPerkebunan
			+$totpemasukanBebanPenyisihanPiutangPerikanan
			+$totpemasukanBebanPenyisihanPiutangPeternakan
			+$totpemasukanBebanPenyisihanPiutangJasa
			+$totpemasukanBebanPenyisihanPiutangLainlain);
		$this->neracasaldo_model->updateNeracaSaldoDebet($totDebetBebanPenyisihanPiutang, '68');


		$totKreditBebanPenyisihanPiutang=round(
			$totpengeluaranBebanPenyisihanPiutangIndustri
			+$totpengeluaranBebanPenyisihanPiutangPerdagangan
			+$totpengeluaranBebanPenyisihanPiutangPertanian
			+$totpengeluaranBebanPenyisihanPiutangPerkebunan
			+$totpengeluaranBebanPenyisihanPiutangPerikanan
			+$totpengeluaranBebanPenyisihanPiutangPeternakan
			+$totpengeluaranBebanPenyisihanPiutangJasa
			+$totpengeluaranBebanPenyisihanPiutangLainlain);

		$this->neracasaldo_model->updateNeracaSaldoKredit($totKreditBebanPenyisihanPiutang, '68');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanJasaGiroPK, '62'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranJasaGiroPK, '62');

		$saldoJasaGiroPK=$totpengeluaranJasaGiroPK-$totpemasukanJasaGiroPK;
		$this->neracasaldo_model->updateNeracaSaldo($saldoJasaGiroPK, '62');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanPendapatanLainlainPiutangHapusBuku, '63'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranPendapatanLainlainPiutangHapusBuku, '63');

		$PendapatanLainlainPiutangHapusBuku=$totpengeluaranPendapatanLainlainPiutangHapusBuku-$totpemasukanPendapatanLainlainPiutangHapusBuku;

		$this->neracasaldo_model->updateNeracaSaldo($PendapatanLainlainPiutangHapusBuku, '63');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanPendapatanLainlainLainlain, '65'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranPendapatanLainlainLainlain, '65');

		$pendapatanLainlainLainsddesTahunLalu = $this->getElementData($catatanAtasLapKeuDesTahunLalu, '61')[$desTahunLalu];   
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($pendapatanLainlainLainsddesTahunLalu, '65');  

		$pendapatanLainlainLains=$totpemasukanPendapatanLainlainLainlain-$totpengeluaranPendapatanLainlainLainlain;

		$this->neracasaldo_model->updateNeracaSaldo($pendapatanLainlainLains, '65');

		$PendapatanDebet=round(
			$totpemasukanJasaAdmPinjaman+
			$totpemasukanJasaGiroPK+
			$totpemasukanPendapatanLainlainPiutangHapusBuku+
			$totpemasukanPendapatanLainlainLainlain);
		$this->neracasaldo_model->updateNeracaSaldoDebet($PendapatanDebet, '60');

		$PendapatanKredit= round(
			$totpengeluaranJasaAdmPinjaman+
			$totpengeluaranJasaGiroPK+
			$totpengeluaranPendapatanLainlainPiutangHapusBuku+
			$totpengeluaranPendapatanLainlainLainlain);
			$this->neracasaldo_model->updateNeracaSaldoKredit($PendapatanKredit, '60');

		$Pendapatan=$PendapatanKredit-$PendapatanDebet;
		$this->neracasaldo_model->updateNeracaSaldo($Pendapatan, '60');
			
		$aktivabersihawalperiodaSDdesTahunLalu = $this->db->query("SELECT sd$desTahunLalu FROM  perubahanasetnetotidakterikat WHERE id='29'")->result_array()[0]['sd' . $desTahunLalu];
		$this->neracasaldo_model->updateNeracaSaldoDesTahunLalu($aktivabersihawalperiodaSDdesTahunLalu, '59');  

		$totpemasukanAktivaBersihAwalPerioda=$PendapatanDebet-$totpemasukanBebanAdmdanUmum-$totDebetBebanPenyisihanPiutang-$totpemasukanBebanLainlain;

		$totpengeluaranAktivaBersihAwalPerioda=$PendapatanKredit-$totpengeluaranBebanAdmdanUmum-$totKreditBebanPenyisihanPiutang-$totpengeluaranBebanLainlain;

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanAktivaBersihAwalPerioda, '59'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranAktivaBersihAwalPerioda, '59');

		$AktivaBersihAwalPerioda=$aktivabersihawalperiodaSDdesTahunLalu+$totpemasukanAktivaBersihAwalPerioda-$totpengeluaranAktivaBersihAwalPerioda;

		$this->neracasaldo_model->updateNeracaSaldo($AktivaBersihAwalPerioda, '59');

		$this->neracasaldo_model->updateNeracaSaldoDebet($totpemasukanBebanPenyisihanPiutangLainlain, '76'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($totpengeluaranBebanPenyisihanPiutangLainlain, '76');

		$totpemasukanBebanAdmdanUmum=round($totpemasukanBebanAdmdanUmum);

		$AsetNetoDebet=
		$PendapatanDebet+$totpemasukanBebanAdmdanUmum+$totDebetBebanPenyisihanPiutang+$totpemasukanBebanLainlain;

		$AsetNetoKredit=
		$PendapatanKredit+$totpengeluaranBebanAdmdanUmum+$totKreditBebanPenyisihanPiutang+$totpengeluaranBebanLainlain;

		$this->neracasaldo_model->updateNeracaSaldoDebet($AsetNetoDebet, '58'); 
		$this->neracasaldo_model->updateNeracaSaldoKredit($AsetNetoKredit, '58');

		$asetNeto=$asetNetodesTahunLalu-$AsetNetoDebet+$AsetNetoKredit;

		$this->neracasaldo_model->updateNeracaSaldo($asetNeto, '58');

		$liabilitasDanAsetNetodDebet=$DebetLiabilitasJangkaPendek+$AsetNetoDebet;
		$this->neracasaldo_model->updateNeracaSaldoDebet($liabilitasDanAsetNetodDebet, '53');  

		$liabilitasDanAsetNetodkredit=$AsetNetoKredit+$KreditLiabilitasJangkaPendek;

		$this->neracasaldo_model->updateNeracaSaldoKredit($liabilitasDanAsetNetodkredit, '53');

		$liabilitasDanAsetNetodesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '53')[$desTahunLalu];   

		$liabilitasDanAsetNeto=$liabilitasDanAsetNetodesTahunLalu+$liabilitasDanAsetNetodkredit-$liabilitasDanAsetNetodDebet;
		$this->neracasaldo_model->updateNeracaSaldo($liabilitasDanAsetNeto, '53');

		$asetLancarDebet=$debetno3+$debetPiutangMBbersih;

		$this->neracasaldo_model->updateNeracaSaldoDebet($asetLancarDebet, '2'); 
		$this->neracasaldo_model->updateNeracaSaldoDebet($asetLancarDebet, '1'); 

		$asetLancarKredit=$kreditno3+$kreditPiutangMBbersih;

		$this->neracasaldo_model->updateNeracaSaldoKredit($asetLancarKredit, '2');
		$this->neracasaldo_model->updateNeracaSaldoKredit($asetLancarKredit, '1');

		$asetLancardesTahunLalu = $this->getElementData($desTahunLaluNeracaSaldo, '2')[$desTahunLalu];   

		$asetLancar= $asetLancardesTahunLalu+$asetLancarDebet-$asetLancarKredit;

		$this->neracasaldo_model->updateNeracaSaldo($asetLancar, '2');//  
		$this->neracasaldo_model->updateNeracaSaldo($asetLancar, '1');//  

		$lapCALKid8totpiutangMB = $this->getElementData($catatanAtasLapKeu, '8')[$bulansekarang];   

		if($piutangMitraBinaan== $lapCALKid8totpiutangMB){
			echo ' true'; 
			echo ' neracasaldo id 11';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '11');   
		}else{
			echo ' false'; 
			echo ' neracasaldo id 11';
			$selisih= $piutangMitraBinaan-$lapCALKid8totpiutangMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '11');    
		}
		echo nl2br("\n");

		$lapCALKid9industri = $this->getElementData($catatanAtasLapKeu, '9')[$bulansekarang];   

		if($totpiutangindustri== $lapCALKid9industri){
			echo ' true'; 
			echo ' neracasaldo id 12';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '12'); 
		}else{
			echo ' false'; 
			echo ' neracasaldo id 12';
			$selisih= $totpiutangindustri-$lapCALKid9industri;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '12');    
		}
		echo nl2br("\n");

		$lapCALKid10perdagangan = $this->getElementData($catatanAtasLapKeu, '10')[$bulansekarang]; 
		var_dump($lapCALKid10perdagangan);
		var_dump($totpiutangperdagangan);
		die;

		if($totpiutangperdagangan== $lapCALKid10perdagangan){
			echo ' true'; 
			echo ' neracasaldo id 13';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '13');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 13';
			$selisih= $totpiutangperdagangan-$lapCALKid10perdagangan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '13');    
		}
		echo nl2br("\n");

	
		$lapCALKid10pertanian = $this->getElementData($catatanAtasLapKeu, '11')[$bulansekarang];  

		if($totpiutangpertanian== $lapCALKid10pertanian){
			echo ' true'; 
			echo ' neracasaldo id 14';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '14');  
		}else{
			echo ' false'; 
			echo ' neracasaldo id 14';
			$selisih= $totpiutangpertanian-$lapCALKid10pertanian;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '14');    
		}
		echo nl2br("\n");
		$lapCALKid10perkebunan = $this->getElementData($catatanAtasLapKeu, '12')[$bulansekarang];   

		if($totpiutangperkebunan== $lapCALKid10perkebunan){
			echo ' true'; 
			echo ' neracasaldo id 15';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '15'); 
		}else{
			echo ' false'; 
			echo ' neracasaldo id 15';
			$selisih= $totpiutangperkebunan-$lapCALKid10perkebunan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '15');    
		}
		echo nl2br("\n");
		$lapCALKid10perikanan = $this->getElementData($catatanAtasLapKeu, '13')[$bulansekarang];   

		if($totpiutangperikanan== $lapCALKid10perikanan){
			echo ' true'; 
			echo ' neracasaldo id 16';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '16');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 16';
			$selisih= $totpiutangperikanan-$lapCALKid10perikanan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '16');    
		}
		echo nl2br("\n");
		$lapCALKid10peternakan = $this->getElementData($catatanAtasLapKeu, '14')[$bulansekarang];   

		if($totpiutangpeternakan== $lapCALKid10peternakan){
			echo ' true'; 
			echo ' neracasaldo id 17';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '17'); 
		}else{
			echo ' false'; 
			echo ' neracasaldo id 17';
			$selisih= $totpiutangpeternakan-$lapCALKid10peternakan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '17');    
		}
		echo nl2br("\n");
		$lapCALKid10jasa = $this->getElementData($catatanAtasLapKeu, '15')[$bulansekarang];   

		if($totpiutangjasa== $lapCALKid10jasa){
			echo ' true'; 
			echo ' neracasaldo id 18';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '18');  
		}else{
			echo ' false'; 
			echo ' neracasaldo id 18';
			$selisih= $totpiutangjasa-$lapCALKid10jasa;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '18');    
		}
		echo nl2br("\n");
		$lapCALKid10Lainlain = $this->getElementData($catatanAtasLapKeu, '16')[$bulansekarang];   

		if($totpiutangLainlain== $lapCALKid10Lainlain){
			echo ' true'; 
			echo ' neracasaldo id 19';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '19');
		}else{
			echo ' false'; 
			echo ' neracasaldo id 19';
			$selisih= $totpiutangLainlain-$lapCALKid10Lainlain;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '19');    
		}
		echo nl2br("\n");
		$lapCALKid17alokpiutangMB = $this->getElementData($catatanAtasLapKeu, '17')[$bulansekarang];   

		if($aloktotSaldoAlokPenyisihanPiutang== $lapCALKid17alokpiutangMB){
			echo ' true'; 
			echo ' neracasaldo id 20';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '20');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 20'; echo number_format($aloktotSaldoAlokPenyisihanPiutang); 
			echo ' vs ';
			echo number_format($lapCALKid17alokpiutangMB);
			$selisih= $aloktotSaldoAlokPenyisihanPiutang-$lapCALKid17alokpiutangMB;
			echo ' selisih='; echo number_format($selisih);
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '20');    
		}
		echo nl2br("\n");
		$lapCALKid18alokindustriMB = $this->getElementData($catatanAtasLapKeu, '18')[$bulansekarang];   

		if( round($aloksektorIndustri)== round($lapCALKid18alokindustriMB)){
			echo ' true'; 
			echo ' neracasaldo id 21';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '21');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 21'; echo $aloksektorIndustri; 
			echo ' vs ';
			echo $lapCALKid18alokindustriMB;
			$selisih= $aloksektorIndustri-$lapCALKid18alokindustriMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '21');    
		}
		echo nl2br("\n");
		$lapCALKid19alokperdaganganMB = $this->getElementData($catatanAtasLapKeu, '19')[$bulansekarang];   

		if( round($aloksektorperdagangan)== round($lapCALKid19alokperdaganganMB)){
			echo ' true'; 
			echo ' neracasaldo id 22';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '22');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 22'; echo $aloksektorperdagangan; 
			echo ' vs ';
			echo $lapCALKid19alokperdaganganMB;
			$selisih= $aloksektorperdagangan-$lapCALKid19alokperdaganganMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '22');    
		}
		echo nl2br("\n");

		$lapCALKid20alokpertanianMB = $this->getElementData($catatanAtasLapKeu, '20')[$bulansekarang];   

		if(round($aloksektorpertanian)== round($lapCALKid20alokpertanianMB)){
			echo ' true'; 
			echo ' neracasaldo id 23';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '23');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 23'; echo $aloksektorpertanian; 
			echo ' vs ';
			echo $lapCALKid20alokpertanianMB;
			$selisih= $aloksektorpertanian-$lapCALKid20alokpertanianMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '23');    
		}
		echo nl2br("\n");
		$lapCALKid21alokperkebunanMB = $this->getElementData($catatanAtasLapKeu, '21')[$bulansekarang];   

		if( round($aloksektorperkebunan)== round($lapCALKid21alokperkebunanMB)){
			echo ' true'; 
			echo ' neracasaldo id 24';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '24');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 24'; echo $aloksektorperkebunan; 
			echo ' vs ';
			echo $lapCALKid21alokperkebunanMB;
			$selisih= $aloksektorperkebunan-$lapCALKid21alokperkebunanMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '24');    
		}
		echo nl2br("\n");
		$lapCALKid22alokperikananMB = $this->getElementData($catatanAtasLapKeu, '22')[$bulansekarang];   

		if( round($aloksektorperikanan)== round($lapCALKid22alokperikananMB)){
			echo ' true';  echo ' neracasaldo id 25';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '25');    
		}else{
			echo ' false'; echo ' neracasaldo id 25 :: '; echo number_format($aloksektorperikanan); 
			echo ' vs ::CALKid_22= '; echo number_format($lapCALKid22alokperikananMB);
			$selisih= $aloksektorperikanan-$lapCALKid22alokperikananMB;
			echo ' selisih='; echo number_format($selisih);
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '25');    
		}
		echo nl2br("\n");
		$lapCALKid23alokpeternakanMB = $this->getElementData($catatanAtasLapKeu, '23')[$bulansekarang];   

		if( round($aloksektorpeternakan)== round($lapCALKid23alokpeternakanMB)){
			echo ' true'; 
			echo ' neracasaldo id 26';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '26');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 26'; echo $aloksektorpeternakan; 
			echo ' vs ';
			echo $lapCALKid23alokpeternakanMB;
			$selisih= $aloksektorpeternakan-$lapCALKid23alokpeternakanMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '26');    
		}
		echo nl2br("\n");
		$lapCALKid24alokjasaMB = $this->getElementData($catatanAtasLapKeu, '24')[$bulansekarang];   

		if(round($aloksektorjasa)== round($lapCALKid24alokjasaMB)){
			echo ' true'; 
			echo ' neracasaldo id 27';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '27');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 27'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid24alokjasaMB;
			$selisih= $aloksektorjasa-$lapCALKid24alokjasaMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '27');    
		}
		echo nl2br("\n");

		$lapCALKid25alokLainlainMB = $this->getElementData($catatanAtasLapKeu, '25')[$bulansekarang];   

		if(round($aloksektorLainlain)== round($lapCALKid25alokLainlainMB)){
			echo ' true'; 
			echo ' neracasaldo id 28';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '28');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 28'; echo $aloksektorLainlain; 
			echo ' vs ';
			echo $lapCALKid25alokLainlainMB;
			$selisih= $aloksektorLainlain-$lapCALKid25alokLainlainMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '28');    
		}
		echo nl2br("\n");

		$lapCALKid32totpiutangmitrabermasalahMB = $this->getElementData($catatanAtasLapKeu, '32')[$bulansekarang];   

		if($totPiutangMitraBinaanbermasalah== $lapCALKid32totpiutangmitrabermasalahMB){
			echo ' true'; 
			echo ' neracasaldo id 29';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '29');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 29'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid32totpiutangmitrabermasalahMB;
			$selisih= $totPiutangMitraBinaanbermasalah-$lapCALKid32totpiutangmitrabermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '29');    
		}
		echo nl2br("\n");

		$lapCALKid33sektorindustribermasalahMB = $this->getElementData($catatanAtasLapKeu, '33')[$bulansekarang];   

		if($sektorindustriBermasalah== $lapCALKid33sektorindustribermasalahMB){
			echo ' true'; 
			echo ' neracasaldo id 30';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '30');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 30'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid33sektorindustribermasalahMB;
			$selisih= $sektorindustriBermasalah-$lapCALKid33sektorindustribermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '30');    
		}
		echo nl2br("\n");

		$lapCALKid34sektorperdaganganbermasalahMB = $this->getElementData($catatanAtasLapKeu, '34')[$bulansekarang];   

		if($sektorperdaganganBermasalah== $lapCALKid34sektorperdaganganbermasalahMB){
			echo ' true'; 
			echo ' neracasaldo id 31';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '31');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 31'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid34sektorperdaganganbermasalahMB;
			$selisih= $sektorperdaganganBermasalah-$lapCALKid34sektorperdaganganbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '31');    
		}
		echo nl2br("\n");

		$lapCALKid35sektorpertanianbermasalahMB = $this->getElementData($catatanAtasLapKeu, '35')[$bulansekarang];   

		if($sektorpertanianBermasalah== $lapCALKid35sektorpertanianbermasalahMB){
			echo ' true'; 
			echo ' neracasaldo id 32';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '32');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 32'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid35sektorpertanianbermasalahMB;
			$selisih= $sektorpertanianBermasalah-$lapCALKid35sektorpertanianbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '32');    
		}
		echo nl2br("\n");

		$lapCALKid36sektorperkebunanbermasalahMB = $this->getElementData($catatanAtasLapKeu, '36')[$bulansekarang];   

		if($sektorperkebunanBermasalah== $lapCALKid36sektorperkebunanbermasalahMB){
			echo ' true'; 
			echo ' neracasaldo id 33';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '33');    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 33'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid36sektorperkebunanbermasalahMB;
			$selisih= $sektorperkebunanBermasalah-$lapCALKid36sektorperkebunanbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '33');    
		}
		echo nl2br("\n");

		$lapCALKid37sektorperikananbermasalahMB = $this->getElementData($catatanAtasLapKeu, '37')[$bulansekarang];   

		if($sektorperikananBermasalah== $lapCALKid37sektorperikananbermasalahMB){
			echo ' true';     echo ' neracasaldo id 34';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '34');    
		}else{
			echo ' false';     echo ' neracasaldo id 34'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid37sektorperikananbermasalahMB;
			$selisih= $sektorperikananBermasalah-$lapCALKid37sektorperikananbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '34');    
		}
		echo nl2br("\n");

		$lapCALKid38sektorpeternakanbermasalahMB = $this->getElementData($catatanAtasLapKeu, '38')[$bulansekarang];   

		if($sektorpeternakanBermasalah== $lapCALKid38sektorpeternakanbermasalahMB){
			echo ' true';     echo ' neracasaldo id 35';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '35');    
		}else{
			echo ' false';     echo ' neracasaldo id 35'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid38sektorpeternakanbermasalahMB;
			$selisih= $sektorpeternakanBermasalah-$lapCALKid38sektorpeternakanbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '35');    
		}
		echo nl2br("\n");

		$lapCALKid39sektorjasabermasalahMB = $this->getElementData($catatanAtasLapKeu, '39')[$bulansekarang];   

		if($sektorjasaBermasalah== $lapCALKid39sektorjasabermasalahMB){
			echo ' true';     echo ' neracasaldo id 36';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '36');    
		}else{
			echo ' false';     echo ' neracasaldo id 36'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid39sektorjasabermasalahMB;
			$selisih= $sektorjasaBermasalah-$lapCALKid39sektorjasabermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '36');    
		}
		echo nl2br("\n");

		$lapCALKid40sektorLainlainbermasalahMB = $this->getElementData($catatanAtasLapKeu, '40')[$bulansekarang];   

		if($sektorLainlainBermasalah== $lapCALKid40sektorLainlainbermasalahMB){
			echo ' true';     echo ' neracasaldo id 37';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '37');    
		}else{
			echo ' false';     echo ' neracasaldo id 37'; echo $aloksektorLainlain; 
			echo ' vs ';
			echo $lapCALKid40sektorLainlainbermasalahMB;
			$selisih= $sektorLainlainBermasalah-$lapCALKid40sektorLainlainbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '37');    
		}
		echo nl2br("\n");

		$lapCALKid42aloktotPiutangMitraBinaanbermasalah = $this->getElementData($catatanAtasLapKeu, '42')[$bulansekarang];   

		if($aloktotPiutangMitraBinaanbermasalah== $lapCALKid42aloktotPiutangMitraBinaanbermasalah){
			echo ' true';     echo ' neracasaldo id 38';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '38');    
		}else{
			echo ' false';     echo ' neracasaldo id 38'; echo $aloktotPiutangMitraBinaanbermasalah; 
			echo ' vs ';
			echo $lapCALKid42aloktotPiutangMitraBinaanbermasalah;
			$selisih= $aloktotPiutangMitraBinaanbermasalah-$lapCALKid42aloktotPiutangMitraBinaanbermasalah;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '38');    
		}
		echo nl2br("\n");

		$lapCALKid43aloksektorindustriBermasalah = $this->getElementData($catatanAtasLapKeu, '43')[$bulansekarang];   

		if($aloksektorindustriBermasalah== $lapCALKid43aloksektorindustriBermasalah){
			echo ' true';     echo ' neracasaldo id 39';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '39');    
		}else{
			echo ' false';     echo ' neracasaldo id 39'; echo $aloksektorindustriBermasalah; 
			echo ' vs ';
			echo $lapCALKid43aloksektorindustriBermasalah;
			$selisih= $aloksektorindustriBermasalah-$lapCALKid43aloksektorindustriBermasalah;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '39');    
		}
		echo nl2br("\n");

		$lapCALKid44aloksektorperdaganganBermasalah = $this->getElementData($catatanAtasLapKeu, '44')[$bulansekarang];   

		if($aloksektorperdaganganBermasalah== $lapCALKid44aloksektorperdaganganBermasalah){
			echo ' true';     echo ' neracasaldo id 40';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '40');    
		}else{
			echo ' false';     echo ' neracasaldo id 40'; echo $aloksektorperdaganganBermasalah; 
			echo ' vs ';
			echo $lapCALKid44aloksektorperdaganganBermasalah;
			$selisih= $aloksektorperdaganganBermasalah-$lapCALKid44aloksektorperdaganganBermasalah;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '40');    
		}
		echo nl2br("\n");

		$lapCALKid45aloksektorpertanianBermasalah = $this->getElementData($catatanAtasLapKeu, '45')[$bulansekarang];   

		if($aloksektorpertanianBermasalah== $lapCALKid45aloksektorpertanianBermasalah){
			echo ' true';     echo ' neracasaldo id 41';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '41');    
		}else{
			echo ' false';     echo ' neracasaldo id 41'; echo $aloksektorpertanianBermasalah; 
			echo ' vs ';
			echo $lapCALKid45aloksektorpertanianBermasalah;
			$selisih= $aloksektorpertanianBermasalah-$lapCALKid45aloksektorpertanianBermasalah;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '41');    
		}
		echo nl2br("\n");

		$lapCALKid46aloksektorperkebunanBermasalah = $this->getElementData($catatanAtasLapKeu, '46')[$bulansekarang];   

		if($aloksektorperkebunanBermasalah== $lapCALKid46aloksektorperkebunanBermasalah){
			echo ' true';     echo ' neracasaldo id 42';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '42');    
		}else{
			echo ' false';     echo ' neracasaldo id 42'; echo $aloksektorperkebunanBermasalah; 
			echo ' vs ';
			echo $lapCALKid46aloksektorperkebunanBermasalah;
			$selisih= $aloksektorperkebunanBermasalah-$lapCALKid46aloksektorperkebunanBermasalah;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '42');    
		}
		echo nl2br("\n");

		$lapCALKid47aloksektorperikananBermasalah = $this->getElementData($catatanAtasLapKeu, '47')[$bulansekarang];   

		if($aloksektorperikananBermasalah== $lapCALKid47aloksektorperikananBermasalah){
			echo ' true';     echo ' neracasaldo id 43';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '43');    
		}else{
			echo ' false';     echo ' neracasaldo id 43'; echo $aloksektorperikananBermasalah; 
			echo ' vs ';
			echo $lapCALKid47aloksektorperikananBermasalah;
			$selisih= $aloksektorperikananBermasalah-$lapCALKid47aloksektorperikananBermasalah;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '43');    
		}
		echo nl2br("\n");

		$lapCALKid48aloksektorpeternakanBermasalah = $this->getElementData($catatanAtasLapKeu, '48')[$bulansekarang];   

		if($aloksektorpeternakanBermasalah== $lapCALKid48aloksektorpeternakanBermasalah){
			echo ' true';     echo ' neracasaldo id 44';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '44');    
		}else{
			echo ' false';     echo ' neracasaldo id 44'; echo $aloksektorpeternakanBermasalah; 
			echo ' vs ';
			echo $lapCALKid48aloksektorpeternakanBermasalah;
			$selisih= $aloksektorpeternakanBermasalah-$lapCALKid48aloksektorpeternakanBermasalah;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '44');    
		}
		echo nl2br("\n");

		$lapCALKid49aloksektorjasaBermasalah = $this->getElementData($catatanAtasLapKeu, '49')[$bulansekarang];   

		if($aloksektorjasaBermasalah== $lapCALKid49aloksektorjasaBermasalah){
			echo ' true';     echo ' neracasaldo id 45';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '45');    
		}else{
			echo ' false';     echo ' neracasaldo id 45'; echo $aloksektorjasaBermasalah; 
			echo ' vs ';
			echo $lapCALKid49aloksektorjasaBermasalah;
			$selisih= $aloksektorjasaBermasalah-$lapCALKid49aloksektorjasaBermasalah;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '45');    
		}
		echo nl2br("\n");

		$lapCALKid50aloksektorLainlainBermasalah = $this->getElementData($catatanAtasLapKeu, '50')[$bulansekarang];   

		if($aloksektorLainlainBermasalah== $lapCALKid50aloksektorLainlainBermasalah){
			echo ' true';     echo ' neracasaldo id 46';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '46');    
		}else{
			echo ' false';     echo ' neracasaldo id 46'; echo $aloksektorLainlainBermasalah; 
			echo ' vs ';
			echo $lapCALKid50aloksektorLainlainBermasalah;
			$selisih= $aloksektorLainlainBermasalah-$lapCALKid50aloksektorLainlainBermasalah;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '46');    
		}
		echo nl2br("\n");

	
				$lapCALKid52kelebihanAngs = $this->getElementData($catatanAtasLapKeu, '52')[$bulansekarang];  

		if($totpengeluaranKelebihanPembayaranAngs== $lapCALKid52kelebihanAngs){
			echo ' true';     echo ' neracasaldo id 56';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '56');    
		}else{
			echo ' false';     echo ' neracasaldo id 56'; echo $totpengeluaranKelebihanPembayaranAngs; 
			echo ' vs ';
			echo $lapCALKid52kelebihanAngs;
			$selisih= $totpengeluaranKelebihanPembayaranAngs-$lapCALKid52kelebihanAngs;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '56');    
		}
		echo nl2br("\n");

		$lapCALKid53angsBelumTeridentifikasi = $this->getElementData($catatanAtasLapKeu, '53')[$bulansekarang];   

		if($angsBelumTeridentifikasi== $lapCALKid53angsBelumTeridentifikasi){
			echo ' true';     echo ' neracasaldo id 57';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '57');    
		}else{
			echo ' false';     echo ' neracasaldo id 57'; echo $angsBelumTeridentifikasi; 
			echo ' vs ';
			echo $lapCALKid53angsBelumTeridentifikasi;
			$selisih= $angsBelumTeridentifikasi-$lapCALKid53angsBelumTeridentifikasi;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '57');    
		}
		echo nl2br("\n");

		$lapneraca24angsBelumTeridentifikasi = $this->db->query("SELECT $bulansekarang FROM neraca WHERE id='24'")->result_array()[0][$bulansekarang];   

		if($asetNeto== $lapneraca24angsBelumTeridentifikasi){
			echo ' true';     echo ' neracasaldo id 58';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '58');    
		}else{
			echo ' false';     echo ' neracasaldo id 58';echo nl2br("\n");
			echo $asetNeto; 
			echo ' vs ';
			echo $lapneraca24angsBelumTeridentifikasi;
			$selisih= $asetNeto-$lapneraca24angsBelumTeridentifikasi;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '58');    
		}
		echo nl2br("\n");
		
		$lapCALK56pendapatan = $this->getElementData($catatanAtasLapKeu, '56')[$bulansekarang];   

		if( round($Pendapatan)== round( $lapCALK56pendapatan)){
			echo ' true';     echo ' neracasaldo id 60';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '60');    
		}else{	
			echo ' false';     echo ' neracasaldo id 60';echo nl2br("\n");
			echo $Pendapatan; 
			echo ' vs ';
			echo $lapCALK56pendapatan;
			$selisih= $Pendapatan-$lapCALK56pendapatan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '60');    
		}
		echo nl2br("\n");

		$lapCALK57jasaAdmPinjaman = $this->getElementData($catatanAtasLapKeu, '57')[$bulansekarang];   

		if($saldoJasaAdmPinjaman== $lapCALK57jasaAdmPinjaman){
			echo ' true';     echo ' neracasaldo id 61';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '61');    
		}else{	
			echo ' false';     echo ' neracasaldo id 61';echo nl2br("\n");
			echo $saldoJasaAdmPinjaman; 
			echo ' vs ';
			echo $lapCALK57jasaAdmPinjaman;
			$selisih= $saldoJasaAdmPinjaman-$lapCALK57jasaAdmPinjaman;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '61');    
		}
		echo nl2br("\n");

		$lapCALK58saldoJasaGiroPK = $this->getElementData($catatanAtasLapKeu, '58')[$bulansekarang];   

		if(round($saldoJasaGiroPK)== round($lapCALK58saldoJasaGiroPK)){
			echo ' true';     echo ' neracasaldo id 62';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '62');    
		}else{
			echo ' false';     echo ' neracasaldo id 62';echo nl2br("\n");
			echo $saldoJasaGiroPK; 
			echo ' vs ';
			echo $lapCALK58saldoJasaGiroPK;
			$selisih= $saldoJasaGiroPK-$lapCALK58saldoJasaGiroPK;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '62');    
		}
		echo nl2br("\n");

		$lapCALK59PendapatanLainlainPiutangHapusBuku = $this->getElementData($catatanAtasLapKeu, '59')[$bulansekarang];   

		if(round($PendapatanLainlainPiutangHapusBuku)== round($lapCALK59PendapatanLainlainPiutangHapusBuku)){
			echo ' true';     echo ' neracasaldo id 63';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '63');    
		}else{
			echo ' false';     echo ' neracasaldo id 63';echo nl2br("\n");
			echo $PendapatanLainlainPiutangHapusBuku; 
			echo ' vs ';
			echo $lapCALK59PendapatanLainlainPiutangHapusBuku;
			$selisih= $PendapatanLainlainPiutangHapusBuku-$lapCALK59PendapatanLainlainPiutangHapusBuku;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '63');    
		}
		echo nl2br("\n");

		$lapCALK59PendapatanLainlainPiutangHapusBuku = $this->getElementData($catatanAtasLapKeu, '59')[$bulansekarang];   

		if(round($PendapatanLainlainPiutangHapusBuku)== round($lapCALK59PendapatanLainlainPiutangHapusBuku)){
			echo ' true';     echo ' neracasaldo id 63';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '63');    
		}else{
			echo ' false';     echo ' neracasaldo id 63';echo nl2br("\n");
			echo $PendapatanLainlainPiutangHapusBuku; 
			echo ' vs ';
			echo $lapCALK59PendapatanLainlainPiutangHapusBuku;
			$selisih= $PendapatanLainlainPiutangHapusBuku-$lapCALK59PendapatanLainlainPiutangHapusBuku;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '63');    
		}
		echo nl2br("\n");
		$pendapatanLainlainPenyesuaian=0;
		$lapCALK61pendapatanLainlainPenyesuaian = $this->getElementData($catatanAtasLapKeu, '60')[$bulansekarang];   

		if(round($pendapatanLainlainPenyesuaian)== round($lapCALK61pendapatanLainlainPenyesuaian)){
			echo ' true';     echo ' neracasaldo id 64';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '64');    
		}else{
			echo ' false';     echo ' neracasaldo id 64';echo nl2br("\n");
			echo $pendapatanLainlainPenyesuaian; 
			echo ' vs ';
			echo $lapCALK61pendapatanLainlainPenyesuaian;
			$selisih= $pendapatanLainlainPenyesuaian-$lapCALK61pendapatanLainlainPenyesuaian;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '64');    
		}
		echo nl2br("\n");

	
		$lapCALK61pendapatanLainlainLains = $this->getElementData($catatanAtasLapKeu, '61')[$bulansekarang];  

		if(round($pendapatanLainlainLains)== round($lapCALK61pendapatanLainlainLains)){
			echo ' true';     echo ' neracasaldo id 65';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '65');    
		}else{
			echo ' false';     echo ' neracasaldo id 65';echo nl2br("\n");
			echo $pendapatanLainlainLains; 
			echo ' vs ';
			echo $lapCALK61pendapatanLainlainLains;
			$selisih= $pendapatanLainlainLains-$lapCALK61pendapatanLainlainLains;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '65');    
		}
		echo nl2br("\n");

		$lapCALK62bebanAdmdanUmum = $this->getElementData($catatanAtasLapKeu, '62')[$bulansekarang];   

		if(round($bebanAdmdanUmum)== round($lapCALK62bebanAdmdanUmum)){
			echo ' true';     echo ' neracasaldo id 66';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '66');    
		}else{
			echo ' false';     echo ' neracasaldo id 66';echo nl2br("\n");
			echo $bebanAdmdanUmum; 
			echo ' vs ';
			echo $lapCALK62bebanAdmdanUmum;
			$selisih= $bebanAdmdanUmum-$lapCALK62bebanAdmdanUmum;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '66');    
		}
		echo nl2br("\n");

		$lapCALK67totBebanPenyisihan = $this->getElementData($catatanAtasLapKeu, '67')[$bulansekarang];   

		if(round($totBebanPenyisihan)== round($lapCALK67totBebanPenyisihan)){
			echo ' true';     echo ' neracasaldo id 67';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '67');    
		}else{
			echo ' false';     echo ' neracasaldo id 67';echo nl2br("\n");
			echo $totBebanPenyisihan; 
			echo ' vs ';
			echo $lapCALK67totBebanPenyisihan;
			$selisih= $totBebanPenyisihan-$lapCALK67totBebanPenyisihan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '67');    
		}
		echo nl2br("\n");

		$lapCALK68totBebanPenyisihan = $this->getElementData($catatanAtasLapKeu, '68')[$bulansekarang];   

		if(round($jumBebanPenyisihanIndustri)== round($lapCALK68totBebanPenyisihan)){
			echo ' true';     echo ' neracasaldo id 68';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '68');    
		}else{
			echo ' false';     echo ' neracasaldo id 68';echo nl2br("\n");
			echo $jumBebanPenyisihanIndustri; 
			echo ' vs ';
			echo $lapCALK68totBebanPenyisihan;
			$selisih= $jumBebanPenyisihanIndustri-$lapCALK68totBebanPenyisihan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '68');    
		}
		echo nl2br("\n");

		$lapCALK69jumBebanPenyisihanPerdagangan = $this->getElementData($catatanAtasLapKeu, '69')[$bulansekarang];   

		if(round($jumBebanPenyisihanPerdagangan)== round($lapCALK69jumBebanPenyisihanPerdagangan)){
			echo ' true';     echo ' neracasaldo id 69';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '69');    
		}else{
			echo ' false';     echo ' neracasaldo id 69';echo nl2br("\n");
			echo $jumBebanPenyisihanPerdagangan; 
			echo ' vs ';
			echo $lapCALK69jumBebanPenyisihanPerdagangan;
			$selisih= $jumBebanPenyisihanPerdagangan-$lapCALK69jumBebanPenyisihanPerdagangan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '69');    
		}
		echo nl2br("\n");

		$lapCALK70jumBebanPenyisihanPertanian = $this->getElementData($catatanAtasLapKeu, '70')[$bulansekarang];   

		if(round($jumBebanPenyisihanPertanian)== round($lapCALK70jumBebanPenyisihanPertanian)){
			echo ' true';     echo ' neracasaldo id 70';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '70');    
		}else{
			echo ' false';     echo ' neracasaldo id 70';echo nl2br("\n");
			echo $jumBebanPenyisihanPertanian; 
			echo ' vs ';
			echo $lapCALK70jumBebanPenyisihanPertanian;
			$selisih= $jumBebanPenyisihanPertanian-$lapCALK70jumBebanPenyisihanPertanian;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '70');    
		}
		echo nl2br("\n");

		$lapCALK71jumBebanPenyisihanPerkebunan = $this->getElementData($catatanAtasLapKeu, '71')[$bulansekarang];   

		if(round($jumBebanPenyisihanPerkebunan)== round($lapCALK71jumBebanPenyisihanPerkebunan)){
			echo ' true';     echo ' neracasaldo id 71';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '71');    
		}else{
			echo ' false';     echo ' neracasaldo id 71';echo nl2br("\n");
			echo $jumBebanPenyisihanPerkebunan; 
			echo ' vs ';
			echo $lapCALK71jumBebanPenyisihanPerkebunan;
			$selisih= $jumBebanPenyisihanPerkebunan-$lapCALK71jumBebanPenyisihanPerkebunan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '71');    
		}
		echo nl2br("\n");

		$lapCALK72jumBebanPenyisihanPerikanan = $this->getElementData($catatanAtasLapKeu, '72')[$bulansekarang];   

		if(round($jumBebanPenyisihanPerikanan)== round($lapCALK72jumBebanPenyisihanPerikanan)){
			echo ' true';     echo ' neracasaldo id 72';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '72');    
		}else{
			echo ' false';     echo ' neracasaldo id 72';echo nl2br("\n");
			echo $jumBebanPenyisihanPerikanan; 
			echo ' vs ';
			echo $lapCALK72jumBebanPenyisihanPerikanan;
			$selisih= $jumBebanPenyisihanPerikanan-$lapCALK72jumBebanPenyisihanPerikanan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '72');    
		}
		echo nl2br("\n");

		$lapCALK73jumBebanPenyisihanPeternakan = $this->getElementData($catatanAtasLapKeu, '73')[$bulansekarang];   

		if(round($jumBebanPenyisihanPeternakan)== round($lapCALK73jumBebanPenyisihanPeternakan)){
			echo ' true';     echo ' neracasaldo id 73';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '73');    
		}else{
			echo ' false';     echo ' neracasaldo id 73';echo nl2br("\n");
			echo $jumBebanPenyisihanPeternakan; 
			echo ' vs ';
			echo $lapCALK73jumBebanPenyisihanPeternakan;
			$selisih= $jumBebanPenyisihanPeternakan-$lapCALK73jumBebanPenyisihanPeternakan;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '73');    
		}
		echo nl2br("\n");

		$lapCALK74jumBebanPenyisihanJasa = $this->getElementData($catatanAtasLapKeu, '74')[$bulansekarang];   

		if(round($jumBebanPenyisihanJasa)== round($lapCALK74jumBebanPenyisihanJasa)){
			echo ' true';     echo ' neracasaldo id 74';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '74');    
		}else{
			echo ' false';     echo ' neracasaldo id 74';echo nl2br("\n");
			echo $jumBebanPenyisihanJasa; 
			echo ' vs ';
			echo $lapCALK74jumBebanPenyisihanJasa;
			$selisih= $jumBebanPenyisihanJasa-$lapCALK74jumBebanPenyisihanJasa;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '74');    
		}
		echo nl2br("\n");

		$lapCALK75jumBebanPenyisihanLainlain = $this->getElementData($catatanAtasLapKeu, '75')[$bulansekarang];   

		if(round($jumBebanPenyisihanLainlain)== round($lapCALK75jumBebanPenyisihanLainlain)){
			echo ' true';     echo ' neracasaldo id 75';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '75');    
		}else{
			echo ' false';     echo ' neracasaldo id 75';echo nl2br("\n");
			echo $jumBebanPenyisihanLainlain; 
			echo ' vs ';
			echo $lapCALK75jumBebanPenyisihanLainlain;
			$selisih= $jumBebanPenyisihanLainlain-$lapCALK75jumBebanPenyisihanLainlain;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '75');    
		}
		echo nl2br("\n");

		$lapCALK75jumBebanLainlain = $this->getElementData($catatanAtasLapKeu, '75')[$bulansekarang];   

		if(round($jumBebanPenyisihanLainlain)== round($lapCALK75jumBebanLainlain)){
			echo ' true';     echo ' neracasaldo id 76';
			$this->neracasaldo_model->updateNeracaSaldoSelisih(0, '76');    
		}else{
			echo ' false';     echo ' neracasaldo id 76';echo nl2br("\n");
			echo $jumBebanPenyisihanLainlain; 
			echo ' vs ';
			echo $lapCALK75jumBebanLainlain;
			$selisih= $jumBebanPenyisihanLainlain-$lapCALK75jumBebanLainlain;
			echo ' selisih='; echo $selisih;
			$this->neracasaldo_model->updateNeracaSaldoSelisih($selisih, '76');    
		}
		echo nl2br("\n");

		// var_dump(memory_get_usage(), memory_get_usage()/1024);
		// return redirect(base_url('Admin/neracaSaldo'));
	}

	private function getElementData($array, $id){
		$desTahunLalu = 'des' . date('y', strtotime('-1 year'));
		$index = array_search($id, array_column($array, 'id'));

		return $array[$index];
	}

	public function cetakNeracaSaldo(){
		$neracasaldo = $this->neracasaldo_model->getNeracaSaldo();

		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

		$data = array(
			'neracasaldo' => $neracasaldo,
			'bulan' => $bulan,
			'perioda' => $perioda
		);

		$this->load->view('neraca_saldo/cetak', $data);
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