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
		$tanggalAwalTahun = date('Y-01-01');
		$tanggalBulanTerkahir = date('Y-m-t', strtotime('-1 month'));
		$desTahunLalu = 'des' . date('y', strtotime('-1 year'));

		echo '$tglawal = '; echo $tanggalAwalTahun;
		echo '$tglakhir = '; echo $tanggalBulanTerkahir;echo nl2br("\n");

		$asetlancardesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neraca WHERE id='5'")->result_array()[0][$desTahunLalu];
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$asetlancardesTahunLalu' WHERE id='2'");

		$piutangMBdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='8'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$piutangMBdesTahunLalu' WHERE id='11'");

		$sektorIndustridesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='9'")->result_array()[0][$desTahunLalu];;   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$sektorIndustridesTahunLalu' WHERE id='12'");  

		$aloksektorIndustridesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='18'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$aloksektorIndustridesTahunLalu' WHERE id='21'");  

		$alokasiSisihMBdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='17'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$alokasiSisihMBdesTahunLalu' WHERE id='20'");  

		$LiabilitasJangkaPendekdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neraca WHERE id='20'")->result_array()[0][$desTahunLalu];//liabilitas   

		$kelebihanAngsurandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neraca WHERE id='17'")->result_array()[0][$desTahunLalu];//17. kelebihan angsuran   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$kelebihanAngsurandesTahunLalu' WHERE id='56'");  

		$jasaGirosddesTahunLalu = $this->db->query("SELECT sd$desTahunLalu FROM  perubahanasetnetotidakterikat WHERE id='2'")->result_array()[0]['sd' . $desTahunLalu];   
		// $this->db->query("UPDATE neracasaldo SET $desTahunLalu='$jasaGirosddesTahunLalu' WHERE id='62'");  

		$pendapatanLainlainpiutangsddesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='59'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$pendapatanLainlainpiutangsddesTahunLalu' WHERE id='63'");  

		$pendapatanLainlainPenyesuaiandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='60'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$pendapatanLainlainPenyesuaiandesTahunLalu' WHERE id='64'");  

		$pendapatanLainlainLaindesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='61'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$pendapatanLainlainLaindesTahunLalu' WHERE id='65'");  


		$BebanUmumAdmdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='65'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$BebanUmumAdmdesTahunLalu' WHERE id='66'");  
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$BebanUmumAdmdesTahunLalu' WHERE id='67'");  

		$sektorIndustridesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='68'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$sektorIndustridesTahunLalu' WHERE id='69'");  

		$sektorPerdagangandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='69'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$sektorPerdagangandesTahunLalu' WHERE id='70'");  

		$sektorPertaniandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='70'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$sektorPertaniandesTahunLalu' WHERE id='71'");  

		$sektorPerkebunandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='71'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$sektorPerkebunandesTahunLalu' WHERE id='72'");  

		$sektorPerikanandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='72'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$sektorPerikanandesTahunLalu' WHERE id='73'");  

		$sektorPeternakandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='73'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$sektorPeternakandesTahunLalu' WHERE id='74'");  

		$sektorJasadesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='74'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$sektorJasadesTahunLalu' WHERE id='75'");  

		$sektorLainlaindesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='75'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$sektorLainlaindesTahunLalu' WHERE id='76'");  

		$bebanLainlaindesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='76'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$bebanLainlaindesTahunLalu' WHERE id='77'");  
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$bebanLainlaindesTahunLalu' WHERE id='78'");  

		$aloksektorJasabermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='49'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$aloksektorJasabermasalahdesTahunLalu' WHERE id='45'");  

		$AngsuranBelumTeridentifikasidesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neraca WHERE id='18'")->result_array()[0][$desTahunLalu];//18. angsuran  blum teridentifikasi

		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$AngsuranBelumTeridentifikasidesTahunLalu' WHERE id='57'");  
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$LiabilitasJangkaPendekdesTahunLalu' WHERE id='54'");  
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$LiabilitasJangkaPendekdesTahunLalu' WHERE id='55'");  


		$pendapatansddesTahunLalu = $this->db->query("SELECT sd$desTahunLalu FROM  perubahanasetnetotidakterikat WHERE id='4'")->result_array()[0]['sd' . $desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$pendapatansddesTahunLalu' WHERE id='60'");  

		$jasaAdmPinjamansddesTahunLalu = $this->db->query("SELECT sd$desTahunLalu FROM  perubahanasetnetotidakterikat WHERE id='1'")->result_array()[0]['sd' . $desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$jasaAdmPinjamansddesTahunLalu' WHERE id='61'");  

		$asetNetodesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neraca WHERE id='24'")->result_array()[0][$desTahunLalu];//aset neto   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$asetNetodesTahunLalu' WHERE id='58'"); 

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
		
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukankas' WHERE id='4'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluarankas' WHERE id='4'");

		$saldokasPKdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='4'")->result_array()[0][$desTahunLalu];//baca kas PK desTahunLalu
		$saldoKasPK=$saldokasPKdesTahunLalu+$totpemasukankas-$totpengeluarankas;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$saldoKasPK' WHERE id='4'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanmandiri' WHERE id='5'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranmandiri' WHERE id='5'");
		$SaldoMandiridesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='5'")->result_array()[0][$desTahunLalu];   
		$saldoMandiriJurnal=$SaldoMandiridesTahunLalu+$totpemasukanmandiri-$totpengeluaranmandiri;    
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$saldoMandiriJurnal' WHERE id='5'");//  

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanbri' WHERE id='7'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranbri' WHERE id='7'");

		$SaldoBRIdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='7'")->result_array()[0][$desTahunLalu];   
		$saldoBRIJurnal=$SaldoBRIdesTahunLalu+$totpemasukanbri-$totpengeluaranbri;    

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$saldoBRIJurnal' WHERE id='7'");//  

		$debetno3=$totpemasukankas+$totpemasukanmandiri+$totpemasukanbri;
		$kreditno3=$totpengeluarankas+$totpengeluaranmandiri+$totpengeluaranbri;

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$debetno3' WHERE id='3'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$kreditno3' WHERE id='3'");

		$SaldoKasSetaraKasdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='3'")->result_array()[0][$desTahunLalu];   

		$SaldoKasSetaraKas= $SaldoKasSetaraKasdesTahunLalu+$debetno3-$kreditno3;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$SaldoKasSetaraKas' WHERE id='3'");//  

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanindustribermasalah' WHERE id='30'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranindustribermasalah' WHERE id='30'");

		$aloktotpemasukanindustribermasalah=$totpemasukanindustribermasalah;
		$aloktotpengeluaranindustribermasalah=$totpengeluaranindustribermasalah;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanindustribermasalah' WHERE id='39'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranindustribermasalah' WHERE id='39'");

		$sektorindustriBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='30'")->result_array()[0][$desTahunLalu];   

		$sektorindustriBermasalah= $sektorindustriBermasalahdesTahunLalu+$totpemasukanindustribermasalah-$totpengeluaranindustribermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$sektorindustriBermasalah' WHERE id='30'");//  

		$aloksektorindustriBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='39'")->result_array()[0][$desTahunLalu];   

		$aloksektorindustriBermasalah= $aloksektorindustriBermasalahdesTahunLalu-$aloktotpemasukanindustribermasalah+$aloktotpengeluaranindustribermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorindustriBermasalah' WHERE id='39'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanperdaganganbermasalah' WHERE id='31'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranperdaganganbermasalah' WHERE id='31'");
		$aloktotpemasukanperdaganganbermasalah=$totpemasukanperdaganganbermasalah;
		$aloktotpengeluaranperdaganganbermasalah=$totpengeluaranperdaganganbermasalah;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanperdaganganbermasalah' WHERE id='40'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranperdaganganbermasalah' WHERE id='40'");

		$sektorperdaganganBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='31'")->result_array()[0][$desTahunLalu];   

		$sektorperdaganganBermasalah= $sektorperdaganganBermasalahdesTahunLalu+$totpemasukanperdaganganbermasalah-$totpengeluaranperdaganganbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$sektorperdaganganBermasalah' WHERE id='31'");//  
		$aloksektorperdaganganBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='40'")->result_array()[0][$desTahunLalu];   

		$aloksektorperdaganganBermasalah= $aloksektorperdaganganBermasalahdesTahunLalu-$aloktotpemasukanperdaganganbermasalah+$aloktotpengeluaranperdaganganbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorperdaganganBermasalah' WHERE id='40'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanpertanianbermasalah' WHERE id='32'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranpertanianbermasalah' WHERE id='32'");
		$aloktotpemasukanpertanianbermasalah=$totpemasukanpertanianbermasalah;
		$aloktotpengeluaranpertanianbermasalah=$totpengeluaranpertanianbermasalah;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='alok$totpemasukanpertanianbermasalah' WHERE id='41'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='alok$totpengeluaranpertanianbermasalah' WHERE id='41'");

		$sektorpertanianBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='32'")->result_array()[0][$desTahunLalu];   

		$sektorpertanianBermasalah= $sektorpertanianBermasalahdesTahunLalu+$totpemasukanpertanianbermasalah-$totpengeluaranpertanianbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$sektorpertanianBermasalah' WHERE id='32'");//  
		$aloksektorpertanianBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='41'")->result_array()[0][$desTahunLalu];   

		$aloksektorpertanianBermasalah= $aloksektorpertanianBermasalahdesTahunLalu-$totpemasukanpertanianbermasalah+$totpengeluaranpertanianbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorpertanianBermasalah' WHERE id='41'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanperkebunanbermasalah' WHERE id='33'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranperkebunanbermasalah' WHERE id='33'");

		$aloktotpemasukanperkebunanbermasalah=$totpemasukanperkebunanbermasalah;
		$aloktotpengeluaranperkebunanbermasalah=$totpengeluaranperkebunanbermasalah;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanperkebunanbermasalah' WHERE id='42'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranperkebunanbermasalah' WHERE id='42'");


		$sektorperkebunanBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='33'")->result_array()[0][$desTahunLalu];   

		$sektorperkebunanBermasalah= $sektorperkebunanBermasalahdesTahunLalu+$totpemasukanperkebunanbermasalah-$totpengeluaranperkebunanbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$sektorperkebunanBermasalah' WHERE id='33'");//  
		$aloksektorperkebunanBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='42'")->result_array()[0][$desTahunLalu];   

		$aloksektorperkebunanBermasalah= $aloksektorperkebunanBermasalahdesTahunLalu-$aloktotpemasukanperkebunanbermasalah+$aloktotpengeluaranperkebunanbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorperkebunanBermasalah' WHERE id='42'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanperikananbermasalah' WHERE id='34'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranperikananbermasalah' WHERE id='34'");

		$aloktotpemasukanperikananbermasalah=$totpemasukanperikananbermasalah;
		$aloktotpengeluaranperikananbermasalah=$totpengeluaranperikananbermasalah;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanperikananbermasalah' WHERE id='43'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranperikananbermasalah' WHERE id='43'");

		$sektorperikananBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='34'")->result_array()[0][$desTahunLalu];   

		$sektorperikananBermasalah= $sektorperikananBermasalahdesTahunLalu+$totpemasukanperikananbermasalah-$totpengeluaranperikananbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$sektorperikananBermasalah' WHERE id='34'");//  

		$aloksektorperikananBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='43'")->result_array()[0][$desTahunLalu];   

		$aloksektorperikananBermasalah= $aloksektorperikananBermasalahdesTahunLalu-$aloktotpemasukanperikananbermasalah+$aloktotpengeluaranperikananbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorperikananBermasalah' WHERE id='43'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanpeternakanbermasalah' WHERE id='35'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranpeternakanbermasalah' WHERE id='35'");
		$aloktotpemasukanpeternakanbermasalah=$totpemasukanpeternakanbermasalah;
		$aloktotpengeluaranpeternakanbermasalah=$totpengeluaranpeternakanbermasalah;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanpeternakanbermasalah' WHERE id='44'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranpeternakanbermasalah' WHERE id='44'");
		

		$sektorpeternakanBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='35'")->result_array()[0][$desTahunLalu];   

		$sektorpeternakanBermasalah= $sektorpeternakanBermasalahdesTahunLalu+$totpemasukanpeternakanbermasalah-$totpengeluaranpeternakanbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$sektorpeternakanBermasalah' WHERE id='35'");//  

		$aloksektorpeternakanBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='44'")->result_array()[0][$desTahunLalu];   

		$aloksektorpeternakanBermasalah= $aloksektorpeternakanBermasalahdesTahunLalu-$aloktotpemasukanpeternakanbermasalah+$aloktotpengeluaranpeternakanbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorpeternakanBermasalah' WHERE id='44'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanjasabermasalah' WHERE id='36'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranjasabermasalah' WHERE id='36'");

		$aloktotpemasukanjasabermasalah=$totpemasukanjasabermasalah;
		$aloktotpengeluaranjasabermasalah=$totpengeluaranjasabermasalah;
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanjasabermasalah' WHERE id='45'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranjasabermasalah' WHERE id='45'");

		$sektorjasaBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='36'")->result_array()[0][$desTahunLalu];   

		$sektorjasaBermasalah= $sektorjasaBermasalahdesTahunLalu+$aloktotpemasukanjasabermasalah-$aloktotpengeluaranjasabermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$sektorjasaBermasalah' WHERE id='36'");//  

		$aloksektorjasaBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='45'")->result_array()[0][$desTahunLalu];   

		$aloksektorjasaBermasalah= $aloksektorjasaBermasalahdesTahunLalu-$aloktotpemasukanjasabermasalah+$aloktotpengeluaranjasabermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorjasaBermasalah' WHERE id='45'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanLainlainbermasalah' WHERE id='37'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranLainlainbermasalah' WHERE id='37'");
		$aloktotpemasukanLainlainbermasalah=$totpemasukanLainlainbermasalah;
		$aloktotpengeluaranLainlainbermasalah=$totpengeluaranLainlainbermasalah;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanLainlainbermasalah' WHERE id='46'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranLainlainbermasalah' WHERE id='46'");

		$sektorLainlainBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='37'")->result_array()[0][$desTahunLalu];   

		$sektorLainlainBermasalah= $sektorLainlainBermasalahdesTahunLalu+$totpemasukanLainlainbermasalah-$totpengeluaranLainlainbermasalah;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$sektorLainlainBermasalah' WHERE id='37'");//  

		$aloksektorLainlainBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='46'")->result_array()[0][$desTahunLalu];   

		$aloksektorLainlainBermasalah= $aloksektorLainlainBermasalahdesTahunLalu-$aloktotpemasukanLainlainbermasalah+$aloktotpengeluaranLainlainbermasalah;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorLainlainBermasalah' WHERE id='46'");

		$aloktotpemasukanindustri1= round($aloktotpemasukanindustri-$aloktotpemasukanindustribermasalah);//(21-39)
		$aloktotpengeluaranindustri1=round($aloktotpengeluaranindustri-$aloktotpengeluaranindustribermasalah);

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranindustri1' WHERE id='21'");
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanindustri1' WHERE id='21'"); 

		$aloksektorIndustridesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='21'")->result_array()[0][$desTahunLalu];   
		$aloksektorIndustri=$aloksektorIndustridesTahunLalu+$aloktotpengeluaranindustri1-$aloktotpemasukanindustri1;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorIndustri' WHERE id='21'");  

		$aloktotpemasukanperdagangan1= round($aloktotpemasukanperdagangan-$aloktotpemasukanperdaganganbermasalah);//(22-40)
		$aloktotpengeluaranperdagangan1= round ($aloktotpengeluaranperdagangan-$aloktotpengeluaranperdaganganbermasalah);
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanperdagangan1' WHERE id='22'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranperdagangan1' WHERE id='22'");

		$aloksektorperdagangandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='22'")->result_array()[0][$desTahunLalu];   
		$aloksektorperdagangan=$aloksektorperdagangandesTahunLalu+$aloktotpengeluaranperdagangan1-$aloktotpemasukanperdagangan1;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorperdagangan' WHERE id='22'");  

		$aloktotpemasukanpertanian1= round($aloktotpemasukanpertanian-$aloktotpemasukanpertanianbermasalah);//(23-41)
		$aloktotpengeluaranpertanian1= round ($aloktotpengeluaranpertanian-$aloktotpengeluaranpertanianbermasalah);
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanpertanian1' WHERE id='23'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranpertanian1' WHERE id='23'");

		$aloksektorpertaniandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='23'")->result_array()[0][$desTahunLalu];   
		$aloksektorpertanian=$aloksektorpertaniandesTahunLalu+$aloktotpengeluaranpertanian1-$aloktotpemasukanpertanian1;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorpertanian' WHERE id='23'");  

		$aloktotpemasukanperkebunan1= round($aloktotpemasukanperkebunan-$aloktotpemasukanperkebunanbermasalah);//(24-42)
		$aloktotpengeluaranperkebunan1=round($aloktotpengeluaranperkebunan-$aloktotpengeluaranperkebunanbermasalah);
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanperkebunan1' WHERE id='24'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranperkebunan1' WHERE id='24'");

		$aloksektorperkebunandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='24'")->result_array()[0][$desTahunLalu];   
		$aloksektorperkebunan=$aloksektorperkebunandesTahunLalu+$aloktotpengeluaranperkebunan1-$aloktotpemasukanperkebunan1;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorperkebunan' WHERE id='24'");  

		$aloktotpemasukanperikanan1= round($aloktotpemasukanperikanan-$aloktotpemasukanperikananbermasalah);//(25-43)
		$aloktotpengeluaranperikanan1= round($aloktotpengeluaranperikanan-$aloktotpengeluaranperikananbermasalah);
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanperikanan1' WHERE id='25'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranperikanan1' WHERE id='25'");

		$aloksektorperikanandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='25'")->result_array()[0][$desTahunLalu];   
		$aloksektorperikanan=$aloksektorperikanandesTahunLalu+$aloktotpengeluaranperikanan1-$aloktotpemasukanperikanan1;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorperikanan' WHERE id='25'");  

		$aloktotpemasukanpeternakan1= round($aloktotpemasukanpeternakan-$aloktotpemasukanpeternakanbermasalah) ; //(26-44)
		$aloktotpengeluaranpeternakan1= round($aloktotpengeluaranpeternakan-$aloktotpengeluaranpeternakanbermasalah);
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanpeternakan1' WHERE id='26'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranpeternakan1' WHERE id='26'");

		$aloksektorpeternakandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='26'")->result_array()[0][$desTahunLalu];   
		$aloksektorpeternakan=$aloksektorpeternakandesTahunLalu+$aloktotpengeluaranpeternakan1-$aloktotpemasukanpeternakan1;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorpeternakan' WHERE id='26'");  

		$aloktotpemasukanjasa1= round($aloktotpemasukanjasa-$aloktotpemasukanjasabermasalah);//27-45 $totpemasukanjasabermasalah
		$aloktotpengeluaranjasa1=round( $aloktotpengeluaranjasa-$aloktotpengeluaranjasabermasalah);
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanjasa1' WHERE id='27'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranjasa1' WHERE id='27'");

		$aloksektorjasadesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='27'")->result_array()[0][$desTahunLalu];   
		$aloksektorjasa=$aloksektorjasadesTahunLalu+$aloktotpengeluaranjasa1-$aloktotpemasukanjasa1;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorjasa' WHERE id='27'");  

		$aloktotpemasukanLainlain1= round($aloktotpemasukanLainlain-$aloktotpemasukanLainlainbermasalah);//28-46
		$aloktotpengeluaranLainlain1= round($aloktotpengeluaranLainlain-$aloktotpengeluaranLainlainbermasalah);
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotpemasukanLainlain1' WHERE id='28'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotpengeluaranLainlain1' WHERE id='28'");

		$aloksektorLainlaindesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='28'")->result_array()[0][$desTahunLalu];   
		$aloksektorLainlain=$aloksektorLainlaindesTahunLalu+$aloktotpengeluaranLainlain1-$aloktotpemasukanLainlain1;
		
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloksektorLainlain' WHERE id='28'");  
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanindustri' WHERE id='12'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranindustri' WHERE id='12'");

		$totpiutangindustridesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='12'")->result_array()[0][$desTahunLalu];    

		$totpiutangindustri=$totpiutangindustridesTahunLalu+$totpemasukanindustri-$totpengeluaranindustri;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totpiutangindustri' WHERE id='12'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanperdagangan' WHERE id='13'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranperdagangan' WHERE id='13'");

		$totpiutangperdagangandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='13'")->result_array()[0][$desTahunLalu];    

		$totpiutangperdagangan=$totpiutangperdagangandesTahunLalu+$totpemasukanperdagangan-$totpengeluaranperdagangan;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totpiutangperdagangan' WHERE id='13'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanpertanian' WHERE id='14'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranpertanian' WHERE id='14'");

		$totpiutangpertaniandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='14'")->result_array()[0][$desTahunLalu];    

		$totpiutangpertanian=$totpiutangpertaniandesTahunLalu+$totpemasukanpertanian-$totpengeluaranpertanian;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totpiutangpertanian' WHERE id='14'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanperkebunan' WHERE id='15'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranperkebunan' WHERE id='15'");

		$totpiutangperkebunandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='15'")->result_array()[0][$desTahunLalu];    

		$totpiutangperkebunan=$totpiutangperkebunandesTahunLalu+$totpemasukanperkebunan-$totpengeluaranperkebunan;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totpiutangperkebunan' WHERE id='15'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanperikanan' WHERE id='16'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranperikanan' WHERE id='16'");

		$totpiutangperikanandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='16'")->result_array()[0][$desTahunLalu];    

		$totpiutangperikanan=$totpiutangperikanandesTahunLalu+$totpemasukanperikanan-$totpengeluaranperikanan;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totpiutangperikanan' WHERE id='16'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanpeternakan' WHERE id='17'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranpeternakan' WHERE id='17'");

		$totpiutangpeternakandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='17'")->result_array()[0][$desTahunLalu];    

		$totpiutangpeternakan=$totpiutangpeternakandesTahunLalu+$totpemasukanpeternakan-$totpengeluaranpeternakan;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totpiutangpeternakan' WHERE id='17'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanjasa' WHERE id='18'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranjasa' WHERE id='18'");

		$totpiutangjasadesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='18'")->result_array()[0][$desTahunLalu];    
		
		$totpiutangjasa=$totpiutangjasadesTahunLalu+$totpemasukanjasa-$totpengeluaranjasa;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totpiutangjasa' WHERE id='18'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanLainlain' WHERE id='19'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranLainlain' WHERE id='19'");

		$totpiutangLainlaindesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='19'")->result_array()[0][$desTahunLalu];    

		$totpiutangLainlain=$totpiutangLainlaindesTahunLalu+$totpemasukanLainlain-$totpengeluaranLainlain;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totpiutangLainlain' WHERE id='19'");

		$lapkasPK = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='1'")->result_array()[0][$bulansekarang];   

		$saldomandiri = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='4'")->result_array()[0][$bulansekarang];   

		$mandiri = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='4'")->result_array()[0][$bulansekarang];   

		$saldobri = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='5'")->result_array()[0][$bulansekarang];   

		if( round($saldoKasPK)!= round($lapkasPK) ){
			echo ' false no 4 $saldoKasPK (lap vs jurnal)';
			echo ' $saldoKasPK$bulansekarang='; echo $saldoKasPK;
			echo ' $lapKasPK$bulansekarang='; echo $lapkasPK;
			$selisih=$saldoKasPK-$lapKasPK;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='4'");
		}else{
			echo ' true no 4 $saldoKasPK (lap vs jurnal)'; 
			echo ' $saldoKasPK$bulansekarang='; echo $saldoKasPK;
			echo ' $lapKasPK$bulansekarang='; echo $lapkasPK;
			$selisih=$saldoKasPK-$lapkasPK;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='4'");
		} 
		echo nl2br("\n");

		if(round ($saldomandiri) != round($saldoMandiriJurnal)){
			echo ' false no 5 $saldomandiri (lap vs jurnal) '; 
			echo ' $saldomandiri$bulansekarang='; echo $saldomandiri; echo ' VS ';
			echo ' $saldoMandiriJurnal$bulansekarang='; echo $saldoMandiriJurnal;
			echo ' selisih='; echo $selisih; 
			$selisih=$saldomandiri-$saldoMandiriJurnal;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='5'");
		}else{
			echo 'true no 5 $saldomandiri'; 
			echo ' $saldomandiri$bulansekarang='; echo $saldomandiri; echo ' VS ';
			echo ' $saldoMandiriJurnal$bulansekarang='; echo $saldoMandiriJurnal;
			$selisih=$saldomandiri-$saldoMandiriJurnal;
			echo ' selisih='; echo $selisih;  
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='5'");
		} 
		echo nl2br("\n");

		if( round($saldobri)!= round($saldoBRIJurnal)){ 
			echo 'false no 7 $saldobri (lap vs jurnal)';  
			echo ' $saldobri$bulansekarang='; echo $saldobri;
			echo ' $saldoBRIJurnal$bulansekarang='; echo $saldoBRIJurnal;     
			$selisih=$saldobri-$saldoBRIJurnal;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='7'"); 
		}else{
			echo 'true no 7 $saldobri (lap vs jurnal)';  
			echo ' $saldobri$bulansekarang='; echo $saldobri;
			echo ' $saldoBRIJurnal$bulansekarang='; echo $saldoBRIJurnal;
			$selisih=$saldobri-$saldoBRIJurnal;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='7'");
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

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$aloktotDebetAlokPenyisihanPiutang' WHERE id='20'");  //$selisihkreditaloksektorindustri

		$aloktotKreditAlokPenyisihanPiutang=
		$aloktotpengeluaranindustri1+$aloktotpengeluaranperdagangan1+$aloktotpengeluaranpertanian1+$aloktotpengeluaranperkebunan1+$aloktotpengeluaranperikanan1+$aloktotpengeluaranpeternakan1+$aloktotpengeluaranjasa1+$aloktotpengeluaranLainlain1;

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$aloktotKreditAlokPenyisihanPiutang' WHERE id='20'");  

		$aloktotSaldoAlokPenyisihanPiutangdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='20'")->result_array()[0][$desTahunLalu];   

		$aloktotSaldoAlokPenyisihanPiutang= $aloktotSaldoAlokPenyisihanPiutangdesTahunLalu-$aloktotDebetAlokPenyisihanPiutang+$aloktotKreditAlokPenyisihanPiutang;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloktotSaldoAlokPenyisihanPiutang' WHERE id='20'");  

		$piutangMBbersih=$piutangMBdesTahunLalu+$alokasiSisihMBdesTahunLalu;

		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$piutangMBbersih' WHERE id='10'");  

		$totPiutangMitraBinaanDebet=
		$totpemasukanindustri+$totpemasukanperdagangan+$totpemasukanpertanian+$totpemasukanperkebunan
		+$totpemasukanperikanan+$totpemasukanpeternakan+$totpemasukanjasa+$totpemasukanLainlain;

		$debetPiutangMBbersih=$debetAlokasiPenyisihanPiutangBermasalah+$totPiutangMitraBinaanbermasalahDebet+
		$aloktotKreditAlokPenyisihanPiutang+$totPiutangMitraBinaanDebet;

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$debetPiutangMBbersih' WHERE id='10'");

		echo nl2br("\n");

		$totPiutangMitraBinaanKredit=
		$totpengeluaranindustri+$totpengeluaranperdagangan+$totpengeluaranpertanian+$totpengeluaranperkebunan
		+$totpengeluaranperikanan+$totpengeluaranpeternakan+$totpengeluaranjasa+$totpengeluaranLainlain;

		$kreditPiutangMBbersih=$kreditAlokasiPenyisihanPiutangBermasalah+$totPiutangMitraBinaanbermasalahKredit+$aloktotDebetAlokPenyisihanPiutang+$totPiutangMitraBinaanKredit;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$kreditPiutangMBbersih' WHERE id='10'");

		$PiutangMBbersihdesTahunLalu=$piutangMBbersih;
		$PiutangMBbersih=$PiutangMBbersihdesTahunLalu+$debetPiutangMBbersih-$kreditPiutangMBbersih;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$PiutangMBbersih' WHERE id='10'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanPiutangJasaAdmPinjaman' WHERE id='47'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranPiutangJasaAdmPinjaman' WHERE id='47'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanPiutangJasaAdmPinjaman' WHERE id='48'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranPiutangJasaAdmPinjaman' WHERE id='48'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='0' WHERE id='49'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='0' WHERE id='49'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='0' WHERE id='50'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='0' WHERE id='50'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='0' WHERE id='51'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='0' WHERE id='51'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='0' WHERE id='52'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='0' WHERE id='52'");

		$totPiutangMitraBinaanDebet=
		$totpemasukanindustri+$totpemasukanperdagangan+$totpemasukanpertanian+$totpemasukanperkebunan
		+$totpemasukanperikanan+$totpemasukanpeternakan+$totpemasukanjasa+$totpemasukanLainlain;

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totPiutangMitraBinaanDebet' WHERE id='11'"); 

		$totPiutangMitraBinaanKredit=
		$totpengeluaranindustri+$totpengeluaranperdagangan+$totpengeluaranpertanian+$totpengeluaranperkebunan
		+$totpengeluaranperikanan+$totpengeluaranpeternakan+$totpengeluaranjasa+$totpengeluaranLainlain;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totPiutangMitraBinaanKredit' WHERE id='11'"); 

		$piutangMitraBinaandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='11'")->result_array()[0][$desTahunLalu];   

		$piutangMitraBinaan=$piutangMitraBinaandesTahunLalu+$totPiutangMitraBinaanDebet-$totPiutangMitraBinaanKredit;         

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$piutangMitraBinaan' WHERE id='11'");  

		$totLiabilitasDebet=$totpemasukanAngsBelumTeridentifikasi+$totpemasukanKelebihanPembayaranAngs;
		$totLiabilitasKredit=$totpengeluaranAngsBelumTeridentifikasi+$totpengeluaranKelebihanPembayaranAngs;

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totLiabilitasDebet' WHERE id='54'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totLiabilitasKredit' WHERE id='54'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totLiabilitasDebet' WHERE id='55'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totLiabilitasKredit' WHERE id='55'");

		$LiabilitasdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  neracasaldo WHERE id='54'")->result_array()[0][$desTahunLalu];   

		$totLiabilitasSaldo=$LiabilitasdesTahunLalu+$totLiabilitasKredit-$totLiabilitasDebet;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totLiabilitasSaldo' WHERE id='54'");//
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totLiabilitasSaldo' WHERE id='55'");//

		$totpemasukanBebanAdmdanUmum=round($totpemasukanBebanAdmdanUmum);
		$bebanAdmdanUmumdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='65'")->result_array()[0][$desTahunLalu];   

		$bebanAdmdanUmum=$totpengeluaranBebanAdmdanUmum-$totpemasukanBebanAdmdanUmum;

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanAdmdanUmum' WHERE id='66'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanAdmdanUmum' WHERE id='66'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanAdmdanUmum' WHERE id='67'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanAdmdanUmum' WHERE id='67'");
			
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$bebanAdmdanUmum' WHERE id='66'");
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$bebanAdmdanUmum' WHERE id='67'");

		$jumBebanPenyisihanIndustri= 0-( $totpemasukanBebanPenyisihanIndustri-$totpengeluaranBebanPenyisihanIndustri);

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanPenyisihanIndustri' WHERE id='69'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanPenyisihanIndustri' WHERE id='69'");
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$jumBebanPenyisihanIndustri' WHERE id='69'");

		$jumBebanPenyisihanPerdagangan= 0-( $totpemasukanBebanPenyisihanPerdagangan-$totpengeluaranBebanPenyisihanPerdagangan);

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanPenyisihanPerdagangan' WHERE id='70'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanPenyisihanPerdagangan' WHERE id='70'");
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$jumBebanPenyisihanPerdagangan' WHERE id='70'");

		$jumBebanPenyisihanPertanian= 0-( $totpemasukanBebanPenyisihanPertanian-$totpengeluaranBebanPenyisihanPertanian);

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanPenyisihanPertanian' WHERE id='71'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanPenyisihanPertanian' WHERE id='71'");
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$jumBebanPenyisihanPertanian' WHERE id='71'");

		$jumBebanPenyisihanPerkebunan= 0-( $totpemasukanBebanPenyisihanPerkebunan-$totpengeluaranBebanPenyisihanPerkebunan);

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanPenyisihanPerkebunan' WHERE id='72'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanPenyisihanPerkebunan' WHERE id='72'");
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$jumBebanPenyisihanPerkebunan' WHERE id='72'");

		$jumBebanPenyisihanPerikanan=  0-($totpemasukanBebanPenyisihanPerikanan-$totpengeluaranBebanPenyisihanPerikanan);

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanPenyisihanPerikanan' WHERE id='73'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanPenyisihanPerikanan' WHERE id='73'");
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$jumBebanPenyisihanPerikanan' WHERE id='73'");

		$jumBebanPenyisihanPeternakan=0-( $totpemasukanBebanPenyisihanPeternakan-$totpengeluaranBebanPenyisihanPeternakan);

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanPenyisihanPeternakan' WHERE id='74'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanPenyisihanPeternakan' WHERE id='74'");
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$jumBebanPenyisihanPeternakan' WHERE id='74'");

		$jumBebanPenyisihanJasa=0-( $totpemasukanBebanPenyisihanJasa-$totpengeluaranBebanPenyisihanJasa);

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanPenyisihanJasa' WHERE id='75'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanPenyisihanJasa' WHERE id='75'");
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$jumBebanPenyisihanJasa' WHERE id='75'");

		$jumBebanPenyisihanLainlain= $sektorLainlaindesTahunLalu+ $totpemasukanBebanPenyisihanLainlain-$totpengeluaranBebanPenyisihanLainlain;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanPenyisihanLainlain' WHERE id='76'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanPenyisihanLainlain' WHERE id='76'");
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$jumBebanPenyisihanLainlain' WHERE id='76'");


		$totDebetBebanPenyisihan=
			$totpemasukanBebanPenyisihanIndustri
			+$totpemasukanBebanPenyisihanPerdagangan
			+$totpemasukanBebanPenyisihanPertanian
			+$totpemasukanBebanPenyisihanPerkebunan
			+$totpemasukanBebanPenyisihanPerikanan
			+$totpemasukanBebanPenyisihanPeternakan
			+$totpemasukanBebanPenyisihanJasa
			+$totpemasukanBebanPenyisihanLainlain;

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totDebetBebanPenyisihan' WHERE id='68'");

		$totKreditBebanPenyisihan=
			$totpengeluaranBebanPenyisihanIndustri
			+$totpengeluaranBebanPenyisihanPerdagangan
			+$totpengeluaranBebanPenyisihanPertanian
			+$totpengeluaranBebanPenyisihanPerkebunan
			+$totpengeluaranBebanPenyisihanPerikanan
			+$totpengeluaranBebanPenyisihanPeternakan
			+$totpengeluaranBebanPenyisihanJasa
			+$totpengeluaranBebanPenyisihanLainlain;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totKreditBebanPenyisihan' WHERE id='68'");

		$totBebanPenyisihandesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  neracasaldo WHERE id='68'")->result_array()[0][$desTahunLalu];   
		$totBebanPenyisihan=$totKreditBebanPenyisihan-$totDebetBebanPenyisihan;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totBebanPenyisihan' WHERE id='68'");

		$totpemasukanBebanLainlain=$totpemasukanBebanLainlain-2;
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanLainlain' WHERE id='77'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanLainlain' WHERE id='77'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanLainlain' WHERE id='78'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanLainlain' WHERE id='78'");

		$BebanLainlaindesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  neracasaldo WHERE id='77'")->result_array()[0][$desTahunLalu];   

		$BebanLainlain=   $totpengeluaranBebanLainlain-$totpemasukanBebanLainlain;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$BebanLainlain' WHERE id='77'");

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$BebanLainlain' WHERE id='78'");

		$totPiutangMitraBinaanbermasalahDebet=
			$totpemasukanindustribermasalah
			+$totpemasukanperdaganganbermasalah
			+$totpemasukanpertanianbermasalah
			+$totpemasukanperkebunanbermasalah
			+$totpemasukanperikananbermasalah
			+$totpemasukanpeternakanbermasalah    
			+$totpemasukanjasabermasalah
			+$totpemasukanLainlainbermasalah;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totPiutangMitraBinaanbermasalahDebet' WHERE id='38'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totPiutangMitraBinaanbermasalahDebet' WHERE id='29'");  
		$totPiutangMitraBinaanbermasalahKredit=
			$totpengeluaranindustribermasalah
			+$totpengeluaranperdaganganbermasalah
			+$totpengeluaranpertanianbermasalah
			+$totpengeluaranperkebunanbermasalah
			+$totpengeluaranperikananbermasalah
			+$totpengeluaranpeternakanbermasalah
			+$totpengeluaranjasabermasalah
			+$totpengeluaranLainlainbermasalah;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totPiutangMitraBinaanbermasalahKredit' WHERE id='29'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totPiutangMitraBinaanbermasalahKredit' WHERE id='38'"); //Alokasi Penyisihan Piutang Bermasalah


			$totPiutangMitraBinaanbermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  neracasaldo WHERE id='29'")->result_array()[0][$desTahunLalu]; 


		$totPiutangMitraBinaanbermasalah=$totPiutangMitraBinaanbermasalahdesTahunLalu+$totPiutangMitraBinaanbermasalahDebet-$totPiutangMitraBinaanbermasalahKredit;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totPiutangMitraBinaanbermasalah' WHERE id='29'"); 
		$aloktotPiutangMitraBinaanbermasalah=0-$totPiutangMitraBinaanbermasalah;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$aloktotPiutangMitraBinaanbermasalah' WHERE id='38'"); //Alokasi Penyisihan Piutang Bermasalah

		$DebetLiabilitasJangkaPendek=$totpemasukanAngsuranBelumTeridentifikasi+$totpemasukanKelebihanPembayaranAngs;
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$DebetLiabilitasJangkaPendek' WHERE id='54'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$DebetLiabilitasJangkaPendek' WHERE id='55'"); 

		$KreditLiabilitasJangkaPendek=$totpengeluaranAngsuranBelumTeridentifikasi+$totpengeluaranKelebihanPembayaranAngs;
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$KreditLiabilitasJangkaPendek' WHERE id='54'");
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$KreditLiabilitasJangkaPendek' WHERE id='55'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanKelebihanPembayaranAngs' WHERE id='56'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranKelebihanPembayaranAngs' WHERE id='56'");

		$totpengeluaranKelebihanPembayaranAngsdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='52'")->result_array()[0][$desTahunLalu];   

		$totpengeluaranKelebihanPembayaranAngs=$totpengeluaranKelebihanPembayaranAngsdesTahunLalu-
		$totpemasukanKelebihanPembayaranAngs+$totpengeluaranKelebihanPembayaranAngs;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$totpengeluaranKelebihanPembayaranAngs' WHERE id='56'");
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanAngsuranBelumTeridentifikasi' WHERE id='57'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranAngsuranBelumTeridentifikasi' WHERE id='57'");

		$angsBelumTeridentifikasidesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='53'")->result_array()[0][$desTahunLalu];   

		$angsBelumTeridentifikasi=$angsBelumTeridentifikasidesTahunLalu+$totpemasukanAngsuranBelumTeridentifikasi-$totpengeluaranAngsuranBelumTeridentifikasi;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$angsBelumTeridentifikasi' WHERE id='57'");  

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanJasaAdmPinjaman' WHERE id='61'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranJasaAdmPinjaman' WHERE id='61'");

		$saldoJasaAdmPinjaman=$totpengeluaranJasaAdmPinjaman-$totpemasukanJasaAdmPinjaman;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$saldoJasaAdmPinjaman' WHERE id='61'");

		$totDebetBebanPenyisihanPiutang=round(
			$totpemasukanBebanPenyisihanPiutangIndustri
			+$totpemasukanBebanPenyisihanPiutangPerdagangan
			+$totpemasukanBebanPenyisihanPiutangPertanian
			+$totpemasukanBebanPenyisihanPiutangPerkebunan
			+$totpemasukanBebanPenyisihanPiutangPerikanan
			+$totpemasukanBebanPenyisihanPiutangPeternakan
			+$totpemasukanBebanPenyisihanPiutangJasa
			+$totpemasukanBebanPenyisihanPiutangLainlain);
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totDebetBebanPenyisihanPiutang' WHERE id='68'");


		$totKreditBebanPenyisihanPiutang=round(
			$totpengeluaranBebanPenyisihanPiutangIndustri
			+$totpengeluaranBebanPenyisihanPiutangPerdagangan
			+$totpengeluaranBebanPenyisihanPiutangPertanian
			+$totpengeluaranBebanPenyisihanPiutangPerkebunan
			+$totpengeluaranBebanPenyisihanPiutangPerikanan
			+$totpengeluaranBebanPenyisihanPiutangPeternakan
			+$totpengeluaranBebanPenyisihanPiutangJasa
			+$totpengeluaranBebanPenyisihanPiutangLainlain);

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totKreditBebanPenyisihanPiutang' WHERE id='68'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanJasaGiroPK' WHERE id='62'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranJasaGiroPK' WHERE id='62'");

		$saldoJasaGiroPK=$totpengeluaranJasaGiroPK-$totpemasukanJasaGiroPK;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$saldoJasaGiroPK' WHERE id='62'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanPendapatanLainlainPiutangHapusBuku' WHERE id='63'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranPendapatanLainlainPiutangHapusBuku' WHERE id='63'");

		$PendapatanLainlainPiutangHapusBuku=$totpengeluaranPendapatanLainlainPiutangHapusBuku-$totpemasukanPendapatanLainlainPiutangHapusBuku;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$PendapatanLainlainPiutangHapusBuku' WHERE id='63'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanPendapatanLainlainLainlain' WHERE id='65'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranPendapatanLainlainLainlain' WHERE id='65'");

		$pendapatanLainlainLainsddesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM  catatanataslapkeu WHERE id='61'")->result_array()[0][$desTahunLalu];   
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$pendapatanLainlainLainsddesTahunLalu' WHERE id='65'");  

		$pendapatanLainlainLains=$totpemasukanPendapatanLainlainLainlain-$totpengeluaranPendapatanLainlainLainlain;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$pendapatanLainlainLains' WHERE id='65'");

		$PendapatanDebet=round(
			$totpemasukanJasaAdmPinjaman+
			$totpemasukanJasaGiroPK+
			$totpemasukanPendapatanLainlainPiutangHapusBuku+
			$totpemasukanPendapatanLainlainLainlain);
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$PendapatanDebet' WHERE id='60'");

		$PendapatanKredit= round(
			$totpengeluaranJasaAdmPinjaman+
			$totpengeluaranJasaGiroPK+
			$totpengeluaranPendapatanLainlainPiutangHapusBuku+
			$totpengeluaranPendapatanLainlainLainlain);
			$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$PendapatanKredit' WHERE id='60'");

		$Pendapatan=$PendapatanKredit-$PendapatanDebet;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$Pendapatan' WHERE id='60'");
			
		$aktivabersihawalperiodaSDdesTahunLalu = $this->db->query("SELECT sd$desTahunLalu FROM  perubahanasetnetotidakterikat WHERE id='29'")->result_array()[0]['sd' . $desTahunLalu];
		$this->db->query("UPDATE neracasaldo SET $desTahunLalu='$aktivabersihawalperiodaSDdesTahunLalu' WHERE id='59'");  

		$totpemasukanAktivaBersihAwalPerioda=$PendapatanDebet-$totpemasukanBebanAdmdanUmum-$totDebetBebanPenyisihanPiutang-$totpemasukanBebanLainlain;

		$totpengeluaranAktivaBersihAwalPerioda=$PendapatanKredit-$totpengeluaranBebanAdmdanUmum-$totKreditBebanPenyisihanPiutang-$totpengeluaranBebanLainlain;

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanAktivaBersihAwalPerioda' WHERE id='59'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranAktivaBersihAwalPerioda' WHERE id='59'");

		$AktivaBersihAwalPerioda=$aktivabersihawalperiodaSDdesTahunLalu+$totpemasukanAktivaBersihAwalPerioda-$totpengeluaranAktivaBersihAwalPerioda;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$AktivaBersihAwalPerioda' WHERE id='59'");

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$totpemasukanBebanPenyisihanPiutangLainlain' WHERE id='76'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$totpengeluaranBebanPenyisihanPiutangLainlain' WHERE id='76'");

		$totpemasukanBebanAdmdanUmum=round($totpemasukanBebanAdmdanUmum);

		$AsetNetoDebet=
		$PendapatanDebet+$totpemasukanBebanAdmdanUmum+$totDebetBebanPenyisihanPiutang+$totpemasukanBebanLainlain;

		$AsetNetoKredit=
		$PendapatanKredit+$totpengeluaranBebanAdmdanUmum+$totKreditBebanPenyisihanPiutang+$totpengeluaranBebanLainlain;

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$AsetNetoDebet' WHERE id='58'"); 
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$AsetNetoKredit' WHERE id='58'");

		$asetNeto=$asetNetodesTahunLalu-$AsetNetoDebet+$AsetNetoKredit;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$asetNeto' WHERE id='58'");

		$liabilitasDanAsetNetodDebet=$DebetLiabilitasJangkaPendek+$AsetNetoDebet;
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$liabilitasDanAsetNetodDebet' WHERE id='53'");  

		$liabilitasDanAsetNetodkredit=$AsetNetoKredit+$KreditLiabilitasJangkaPendek;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$liabilitasDanAsetNetodkredit' WHERE id='53'");

		$liabilitasDanAsetNetodesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='53'")->result_array()[0][$desTahunLalu];   

		$liabilitasDanAsetNeto=$liabilitasDanAsetNetodesTahunLalu+$liabilitasDanAsetNetodkredit-$liabilitasDanAsetNetodDebet;
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$liabilitasDanAsetNeto' WHERE id='53'");

		$asetLancarDebet=$debetno3+$debetPiutangMBbersih;

		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$asetLancarDebet' WHERE id='2'"); 
		$this->db->query("UPDATE neracasaldo SET debet$bulansekarang='$asetLancarDebet' WHERE id='1'"); 

		$asetLancarKredit=$kreditno3+$kreditPiutangMBbersih;

		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$asetLancarKredit' WHERE id='2'");
		$this->db->query("UPDATE neracasaldo SET kredit$bulansekarang='$asetLancarKredit' WHERE id='1'");

		$asetLancardesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM neracasaldo WHERE id='2'")->result_array()[0][$desTahunLalu];   

		$asetLancar= $asetLancardesTahunLalu+$asetLancarDebet-$asetLancarKredit;

		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$asetLancar' WHERE id='2'");//  
		$this->db->query("UPDATE neracasaldo SET saldo$bulansekarang='$asetLancar' WHERE id='1'");//  

		$lapCALKid8totpiutangMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='8'")->result_array()[0][$bulansekarang];   

		if($piutangMitraBinaan== $lapCALKid8totpiutangMB){
			echo ' true'; 
			echo ' neracasaldo id 11';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='11'");   
		}else{
			echo ' false'; 
			echo ' neracasaldo id 11';
			$selisih= $piutangMitraBinaan-$lapCALKid8totpiutangMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='11'");    
		}
		echo nl2br("\n");

		$lapCALKid9industri = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='9'")->result_array()[0][$bulansekarang];   

		if($totpiutangindustri== $lapCALKid9industri){
			echo ' true'; 
			echo ' neracasaldo id 12';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='12'"); 
		}else{
			echo ' false'; 
			echo ' neracasaldo id 12';
			$selisih= $totpiutangindustri-$lapCALKid9industri;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='12'");    
		}
		echo nl2br("\n");

		$lapCALKid10perdagangan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='10'")->result_array()[0][$bulansekarang];   

		if($totpiutangperdagangan== $lapCALKid10perdagangan){
			echo ' true'; 
			echo ' neracasaldo id 13';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='13'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 13';
			$selisih= $totpiutangperdagangan-$lapCALKid10perdagangan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='13'");    
		}
		echo nl2br("\n");

	
				$lapCALKid10pertanian = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='11'")->result_array()[0][$bulansekarang];  

		if($totpiutangpertanian== $lapCALKid10pertanian){
			echo ' true'; 
			echo ' neracasaldo id 14';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='14'");  
		}else{
			echo ' false'; 
			echo ' neracasaldo id 14';
			$selisih= $totpiutangpertanian-$lapCALKid10pertanian;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='14'");    
		}
		echo nl2br("\n");
		$lapCALKid10perkebunan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='12'")->result_array()[0][$bulansekarang];   

		if($totpiutangperkebunan== $lapCALKid10perkebunan){
			echo ' true'; 
			echo ' neracasaldo id 15';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='15'"); 
		}else{
			echo ' false'; 
			echo ' neracasaldo id 15';
			$selisih= $totpiutangperkebunan-$lapCALKid10perkebunan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='15'");    
		}
		echo nl2br("\n");
		$lapCALKid10perikanan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='13'")->result_array()[0][$bulansekarang];   

		if($totpiutangperikanan== $lapCALKid10perikanan){
			echo ' true'; 
			echo ' neracasaldo id 16';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='16'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 16';
			$selisih= $totpiutangperikanan-$lapCALKid10perikanan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='16'");    
		}
		echo nl2br("\n");
		$lapCALKid10peternakan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='14'")->result_array()[0][$bulansekarang];   

		if($totpiutangpeternakan== $lapCALKid10peternakan){
			echo ' true'; 
			echo ' neracasaldo id 17';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='17'"); 
		}else{
			echo ' false'; 
			echo ' neracasaldo id 17';
			$selisih= $totpiutangpeternakan-$lapCALKid10peternakan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='17'");    
		}
		echo nl2br("\n");
		$lapCALKid10jasa = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='15'")->result_array()[0][$bulansekarang];   

		if($totpiutangjasa== $lapCALKid10jasa){
			echo ' true'; 
			echo ' neracasaldo id 18';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='18'");  
		}else{
			echo ' false'; 
			echo ' neracasaldo id 18';
			$selisih= $totpiutangjasa-$lapCALKid10jasa;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='18'");    
		}
		echo nl2br("\n");
		$lapCALKid10Lainlain = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='16'")->result_array()[0][$bulansekarang];   

		if($totpiutangLainlain== $lapCALKid10Lainlain){
			echo ' true'; 
			echo ' neracasaldo id 19';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='19'");
		}else{
			echo ' false'; 
			echo ' neracasaldo id 19';
			$selisih= $totpiutangLainlain-$lapCALKid10Lainlain;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='19'");    
		}
		echo nl2br("\n");
		$lapCALKid17alokpiutangMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='17'")->result_array()[0][$bulansekarang];   

		if($aloktotSaldoAlokPenyisihanPiutang== $lapCALKid17alokpiutangMB){
			echo ' true'; 
			echo ' neracasaldo id 20';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='20'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 20'; echo number_format($aloktotSaldoAlokPenyisihanPiutang); 
			echo ' vs ';
			echo number_format($lapCALKid17alokpiutangMB);
			$selisih= $aloktotSaldoAlokPenyisihanPiutang-$lapCALKid17alokpiutangMB;
			echo ' selisih='; echo number_format($selisih);
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='20'");    
		}
		echo nl2br("\n");
		$lapCALKid18alokindustriMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='18'")->result_array()[0][$bulansekarang];   

		if( round($aloksektorIndustri)== round($lapCALKid18alokindustriMB)){
			echo ' true'; 
			echo ' neracasaldo id 21';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='21'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 21'; echo $aloksektorIndustri; 
			echo ' vs ';
			echo $lapCALKid18alokindustriMB;
			$selisih= $aloksektorIndustri-$lapCALKid18alokindustriMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='21'");    
		}
		echo nl2br("\n");
		$lapCALKid19alokperdaganganMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='19'")->result_array()[0][$bulansekarang];   

		if( round($aloksektorperdagangan)== round($lapCALKid19alokperdaganganMB)){
			echo ' true'; 
			echo ' neracasaldo id 22';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='22'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 22'; echo $aloksektorperdagangan; 
			echo ' vs ';
			echo $lapCALKid19alokperdaganganMB;
			$selisih= $aloksektorperdagangan-$lapCALKid19alokperdaganganMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='22'");    
		}
		echo nl2br("\n");

		$lapCALKid20alokpertanianMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='20'")->result_array()[0][$bulansekarang];   

		if(round($aloksektorpertanian)== round($lapCALKid20alokpertanianMB)){
			echo ' true'; 
			echo ' neracasaldo id 23';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='23'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 23'; echo $aloksektorpertanian; 
			echo ' vs ';
			echo $lapCALKid20alokpertanianMB;
			$selisih= $aloksektorpertanian-$lapCALKid20alokpertanianMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='23'");    
		}
		echo nl2br("\n");
		$lapCALKid21alokperkebunanMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='21'")->result_array()[0][$bulansekarang];   

		if( round($aloksektorperkebunan)== round($lapCALKid21alokperkebunanMB)){
			echo ' true'; 
			echo ' neracasaldo id 24';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='24'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 24'; echo $aloksektorperkebunan; 
			echo ' vs ';
			echo $lapCALKid21alokperkebunanMB;
			$selisih= $aloksektorperkebunan-$lapCALKid21alokperkebunanMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='24'");    
		}
		echo nl2br("\n");
		$lapCALKid22alokperikananMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='22'")->result_array()[0][$bulansekarang];   

		if( round($aloksektorperikanan)== round($lapCALKid22alokperikananMB)){
			echo ' true';  echo ' neracasaldo id 25';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='25'");    
		}else{
			echo ' false'; echo ' neracasaldo id 25 :: '; echo number_format($aloksektorperikanan); 
			echo ' vs ::CALKid_22= '; echo number_format($lapCALKid22alokperikananMB);
			$selisih= $aloksektorperikanan-$lapCALKid22alokperikananMB;
			echo ' selisih='; echo number_format($selisih);
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='25'");    
		}
		echo nl2br("\n");
		$lapCALKid23alokpeternakanMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='23'")->result_array()[0][$bulansekarang];   

		if( round($aloksektorpeternakan)== round($lapCALKid23alokpeternakanMB)){
			echo ' true'; 
			echo ' neracasaldo id 26';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='26'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 26'; echo $aloksektorpeternakan; 
			echo ' vs ';
			echo $lapCALKid23alokpeternakanMB;
			$selisih= $aloksektorpeternakan-$lapCALKid23alokpeternakanMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='26'");    
		}
		echo nl2br("\n");
		$lapCALKid24alokjasaMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='24'")->result_array()[0][$bulansekarang];   

		if(round($aloksektorjasa)== round($lapCALKid24alokjasaMB)){
			echo ' true'; 
			echo ' neracasaldo id 27';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='27'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 27'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid24alokjasaMB;
			$selisih= $aloksektorjasa-$lapCALKid24alokjasaMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='27'");    
		}
		echo nl2br("\n");

		$lapCALKid25alokLainlainMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='25'")->result_array()[0][$bulansekarang];   

		if(round($aloksektorLainlain)== round($lapCALKid25alokLainlainMB)){
			echo ' true'; 
			echo ' neracasaldo id 28';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='28'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 28'; echo $aloksektorLainlain; 
			echo ' vs ';
			echo $lapCALKid25alokLainlainMB;
			$selisih= $aloksektorLainlain-$lapCALKid25alokLainlainMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='28'");    
		}
		echo nl2br("\n");

		$lapCALKid32totpiutangmitrabermasalahMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='32'")->result_array()[0][$bulansekarang];   

		if($totPiutangMitraBinaanbermasalah== $lapCALKid32totpiutangmitrabermasalahMB){
			echo ' true'; 
			echo ' neracasaldo id 29';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='29'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 29'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid32totpiutangmitrabermasalahMB;
			$selisih= $totPiutangMitraBinaanbermasalah-$lapCALKid32totpiutangmitrabermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='29'");    
		}
		echo nl2br("\n");

		$lapCALKid33sektorindustribermasalahMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='33'")->result_array()[0][$bulansekarang];   

		if($sektorindustriBermasalah== $lapCALKid33sektorindustribermasalahMB){
			echo ' true'; 
			echo ' neracasaldo id 30';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='30'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 30'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid33sektorindustribermasalahMB;
			$selisih= $sektorindustriBermasalah-$lapCALKid33sektorindustribermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='30'");    
		}
		echo nl2br("\n");

		$lapCALKid34sektorperdaganganbermasalahMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='34'")->result_array()[0][$bulansekarang];   

		if($sektorperdaganganBermasalah== $lapCALKid34sektorperdaganganbermasalahMB){
			echo ' true'; 
			echo ' neracasaldo id 31';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='31'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 31'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid34sektorperdaganganbermasalahMB;
			$selisih= $sektorperdaganganBermasalah-$lapCALKid34sektorperdaganganbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='31'");    
		}
		echo nl2br("\n");

		$lapCALKid35sektorpertanianbermasalahMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='35'")->result_array()[0][$bulansekarang];   

		if($sektorpertanianBermasalah== $lapCALKid35sektorpertanianbermasalahMB){
			echo ' true'; 
			echo ' neracasaldo id 32';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='32'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 32'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid35sektorpertanianbermasalahMB;
			$selisih= $sektorpertanianBermasalah-$lapCALKid35sektorpertanianbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='32'");    
		}
		echo nl2br("\n");

		$lapCALKid36sektorperkebunanbermasalahMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='36'")->result_array()[0][$bulansekarang];   

		if($sektorperkebunanBermasalah== $lapCALKid36sektorperkebunanbermasalahMB){
			echo ' true'; 
			echo ' neracasaldo id 33';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='33'");    
		}else{
			echo ' false'; 
			echo ' neracasaldo id 33'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid36sektorperkebunanbermasalahMB;
			$selisih= $sektorperkebunanBermasalah-$lapCALKid36sektorperkebunanbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='33'");    
		}
		echo nl2br("\n");

		$lapCALKid37sektorperikananbermasalahMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='37'")->result_array()[0][$bulansekarang];   

		if($sektorperikananBermasalah== $lapCALKid37sektorperikananbermasalahMB){
			echo ' true';     echo ' neracasaldo id 34';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='34'");    
		}else{
			echo ' false';     echo ' neracasaldo id 34'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid37sektorperikananbermasalahMB;
			$selisih= $sektorperikananBermasalah-$lapCALKid37sektorperikananbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='34'");    
		}
		echo nl2br("\n");

		$lapCALKid38sektorpeternakanbermasalahMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='38'")->result_array()[0][$bulansekarang];   

		if($sektorpeternakanBermasalah== $lapCALKid38sektorpeternakanbermasalahMB){
			echo ' true';     echo ' neracasaldo id 35';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='35'");    
		}else{
			echo ' false';     echo ' neracasaldo id 35'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid38sektorpeternakanbermasalahMB;
			$selisih= $sektorpeternakanBermasalah-$lapCALKid38sektorpeternakanbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='35'");    
		}
		echo nl2br("\n");

		$lapCALKid39sektorjasabermasalahMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='39'")->result_array()[0][$bulansekarang];   

		if($sektorjasaBermasalah== $lapCALKid39sektorjasabermasalahMB){
			echo ' true';     echo ' neracasaldo id 36';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='36'");    
		}else{
			echo ' false';     echo ' neracasaldo id 36'; echo $aloksektorjasa; 
			echo ' vs ';
			echo $lapCALKid39sektorjasabermasalahMB;
			$selisih= $sektorjasaBermasalah-$lapCALKid39sektorjasabermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='36'");    
		}
		echo nl2br("\n");

		$lapCALKid40sektorLainlainbermasalahMB = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='40'")->result_array()[0][$bulansekarang];   

		if($sektorLainlainBermasalah== $lapCALKid40sektorLainlainbermasalahMB){
			echo ' true';     echo ' neracasaldo id 37';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='37'");    
		}else{
			echo ' false';     echo ' neracasaldo id 37'; echo $aloksektorLainlain; 
			echo ' vs ';
			echo $lapCALKid40sektorLainlainbermasalahMB;
			$selisih= $sektorLainlainBermasalah-$lapCALKid40sektorLainlainbermasalahMB;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='37'");    
		}
		echo nl2br("\n");

		$lapCALKid42aloktotPiutangMitraBinaanbermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='42'")->result_array()[0][$bulansekarang];   

		if($aloktotPiutangMitraBinaanbermasalah== $lapCALKid42aloktotPiutangMitraBinaanbermasalah){
			echo ' true';     echo ' neracasaldo id 38';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='38'");    
		}else{
			echo ' false';     echo ' neracasaldo id 38'; echo $aloktotPiutangMitraBinaanbermasalah; 
			echo ' vs ';
			echo $lapCALKid42aloktotPiutangMitraBinaanbermasalah;
			$selisih= $aloktotPiutangMitraBinaanbermasalah-$lapCALKid42aloktotPiutangMitraBinaanbermasalah;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='38'");    
		}
		echo nl2br("\n");

		$lapCALKid43aloksektorindustriBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='43'")->result_array()[0][$bulansekarang];   

		if($aloksektorindustriBermasalah== $lapCALKid43aloksektorindustriBermasalah){
			echo ' true';     echo ' neracasaldo id 39';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='39'");    
		}else{
			echo ' false';     echo ' neracasaldo id 39'; echo $aloksektorindustriBermasalah; 
			echo ' vs ';
			echo $lapCALKid43aloksektorindustriBermasalah;
			$selisih= $aloksektorindustriBermasalah-$lapCALKid43aloksektorindustriBermasalah;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='39'");    
		}
		echo nl2br("\n");

		$lapCALKid44aloksektorperdaganganBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='44'")->result_array()[0][$bulansekarang];   

		if($aloksektorperdaganganBermasalah== $lapCALKid44aloksektorperdaganganBermasalah){
			echo ' true';     echo ' neracasaldo id 40';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='40'");    
		}else{
			echo ' false';     echo ' neracasaldo id 40'; echo $aloksektorperdaganganBermasalah; 
			echo ' vs ';
			echo $lapCALKid44aloksektorperdaganganBermasalah;
			$selisih= $aloksektorperdaganganBermasalah-$lapCALKid44aloksektorperdaganganBermasalah;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='40'");    
		}
		echo nl2br("\n");

		$lapCALKid45aloksektorpertanianBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='45'")->result_array()[0][$bulansekarang];   

		if($aloksektorpertanianBermasalah== $lapCALKid45aloksektorpertanianBermasalah){
			echo ' true';     echo ' neracasaldo id 41';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='41'");    
		}else{
			echo ' false';     echo ' neracasaldo id 41'; echo $aloksektorpertanianBermasalah; 
			echo ' vs ';
			echo $lapCALKid45aloksektorpertanianBermasalah;
			$selisih= $aloksektorpertanianBermasalah-$lapCALKid45aloksektorpertanianBermasalah;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='41'");    
		}
		echo nl2br("\n");

		$lapCALKid46aloksektorperkebunanBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='46'")->result_array()[0][$bulansekarang];   

		if($aloksektorperkebunanBermasalah== $lapCALKid46aloksektorperkebunanBermasalah){
			echo ' true';     echo ' neracasaldo id 42';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='42'");    
		}else{
			echo ' false';     echo ' neracasaldo id 42'; echo $aloksektorperkebunanBermasalah; 
			echo ' vs ';
			echo $lapCALKid46aloksektorperkebunanBermasalah;
			$selisih= $aloksektorperkebunanBermasalah-$lapCALKid46aloksektorperkebunanBermasalah;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='42'");    
		}
		echo nl2br("\n");

		$lapCALKid47aloksektorperikananBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='47'")->result_array()[0][$bulansekarang];   

		if($aloksektorperikananBermasalah== $lapCALKid47aloksektorperikananBermasalah){
			echo ' true';     echo ' neracasaldo id 43';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='43'");    
		}else{
			echo ' false';     echo ' neracasaldo id 43'; echo $aloksektorperikananBermasalah; 
			echo ' vs ';
			echo $lapCALKid47aloksektorperikananBermasalah;
			$selisih= $aloksektorperikananBermasalah-$lapCALKid47aloksektorperikananBermasalah;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='43'");    
		}
		echo nl2br("\n");

		$lapCALKid48aloksektorpeternakanBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='48'")->result_array()[0][$bulansekarang];   

		if($aloksektorpeternakanBermasalah== $lapCALKid48aloksektorpeternakanBermasalah){
			echo ' true';     echo ' neracasaldo id 44';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='44'");    
		}else{
			echo ' false';     echo ' neracasaldo id 44'; echo $aloksektorpeternakanBermasalah; 
			echo ' vs ';
			echo $lapCALKid48aloksektorpeternakanBermasalah;
			$selisih= $aloksektorpeternakanBermasalah-$lapCALKid48aloksektorpeternakanBermasalah;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='44'");    
		}
		echo nl2br("\n");

		$lapCALKid49aloksektorjasaBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='49'")->result_array()[0][$bulansekarang];   

		if($aloksektorjasaBermasalah== $lapCALKid49aloksektorjasaBermasalah){
			echo ' true';     echo ' neracasaldo id 45';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='45'");    
		}else{
			echo ' false';     echo ' neracasaldo id 45'; echo $aloksektorjasaBermasalah; 
			echo ' vs ';
			echo $lapCALKid49aloksektorjasaBermasalah;
			$selisih= $aloksektorjasaBermasalah-$lapCALKid49aloksektorjasaBermasalah;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='45'");    
		}
		echo nl2br("\n");

		$lapCALKid50aloksektorLainlainBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='50'")->result_array()[0][$bulansekarang];   

		if($aloksektorLainlainBermasalah== $lapCALKid50aloksektorLainlainBermasalah){
			echo ' true';     echo ' neracasaldo id 46';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='46'");    
		}else{
			echo ' false';     echo ' neracasaldo id 46'; echo $aloksektorLainlainBermasalah; 
			echo ' vs ';
			echo $lapCALKid50aloksektorLainlainBermasalah;
			$selisih= $aloksektorLainlainBermasalah-$lapCALKid50aloksektorLainlainBermasalah;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='46'");    
		}
		echo nl2br("\n");

	
				$lapCALKid52kelebihanAngs = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='52'")->result_array()[0][$bulansekarang];  

		if($totpengeluaranKelebihanPembayaranAngs== $lapCALKid52kelebihanAngs){
			echo ' true';     echo ' neracasaldo id 56';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='56'");    
		}else{
			echo ' false';     echo ' neracasaldo id 56'; echo $totpengeluaranKelebihanPembayaranAngs; 
			echo ' vs ';
			echo $lapCALKid52kelebihanAngs;
			$selisih= $totpengeluaranKelebihanPembayaranAngs-$lapCALKid52kelebihanAngs;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='56'");    
		}
		echo nl2br("\n");

		$lapCALKid53angsBelumTeridentifikasi = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='53'")->result_array()[0][$bulansekarang];   

		if($angsBelumTeridentifikasi== $lapCALKid53angsBelumTeridentifikasi){
			echo ' true';     echo ' neracasaldo id 57';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='57'");    
		}else{
			echo ' false';     echo ' neracasaldo id 57'; echo $angsBelumTeridentifikasi; 
			echo ' vs ';
			echo $lapCALKid53angsBelumTeridentifikasi;
			$selisih= $angsBelumTeridentifikasi-$lapCALKid53angsBelumTeridentifikasi;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='57'");    
		}
		echo nl2br("\n");

		$lapneraca24angsBelumTeridentifikasi = $this->db->query("SELECT $bulansekarang FROM neraca WHERE id='24'")->result_array()[0][$bulansekarang];   

		if($asetNeto== $lapneraca24angsBelumTeridentifikasi){
			echo ' true';     echo ' neracasaldo id 58';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='58'");    
		}else{
			echo ' false';     echo ' neracasaldo id 58';echo nl2br("\n");
			echo $asetNeto; 
			echo ' vs ';
			echo $lapneraca24angsBelumTeridentifikasi;
			$selisih= $asetNeto-$lapneraca24angsBelumTeridentifikasi;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='58'");    
		}
		echo nl2br("\n");
		
		$lapCALK56pendapatan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='56'")->result_array()[0][$bulansekarang];   

		if( round($Pendapatan)== round( $lapCALK56pendapatan)){
			echo ' true';     echo ' neracasaldo id 60';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='60'");    
		}else{	
			echo ' false';     echo ' neracasaldo id 60';echo nl2br("\n");
			echo $Pendapatan; 
			echo ' vs ';
			echo $lapCALK56pendapatan;
			$selisih= $Pendapatan-$lapCALK56pendapatan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='60'");    
		}
		echo nl2br("\n");

		$lapCALK57jasaAdmPinjaman = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='57'")->result_array()[0][$bulansekarang];   

		if($saldoJasaAdmPinjaman== $lapCALK57jasaAdmPinjaman){
			echo ' true';     echo ' neracasaldo id 61';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='61'");    
		}else{	
			echo ' false';     echo ' neracasaldo id 61';echo nl2br("\n");
			echo $saldoJasaAdmPinjaman; 
			echo ' vs ';
			echo $lapCALK57jasaAdmPinjaman;
			$selisih= $saldoJasaAdmPinjaman-$lapCALK57jasaAdmPinjaman;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='61'");    
		}
		echo nl2br("\n");

		$lapCALK58saldoJasaGiroPK = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='58'")->result_array()[0][$bulansekarang];   

		if(round($saldoJasaGiroPK)== round($lapCALK58saldoJasaGiroPK)){
			echo ' true';     echo ' neracasaldo id 62';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='62'");    
		}else{
			echo ' false';     echo ' neracasaldo id 62';echo nl2br("\n");
			echo $saldoJasaGiroPK; 
			echo ' vs ';
			echo $lapCALK58saldoJasaGiroPK;
			$selisih= $saldoJasaGiroPK-$lapCALK58saldoJasaGiroPK;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='62'");    
		}
		echo nl2br("\n");

		$lapCALK59PendapatanLainlainPiutangHapusBuku = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='59'")->result_array()[0][$bulansekarang];   

		if(round($PendapatanLainlainPiutangHapusBuku)== round($lapCALK59PendapatanLainlainPiutangHapusBuku)){
			echo ' true';     echo ' neracasaldo id 63';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='63'");    
		}else{
			echo ' false';     echo ' neracasaldo id 63';echo nl2br("\n");
			echo $PendapatanLainlainPiutangHapusBuku; 
			echo ' vs ';
			echo $lapCALK59PendapatanLainlainPiutangHapusBuku;
			$selisih= $PendapatanLainlainPiutangHapusBuku-$lapCALK59PendapatanLainlainPiutangHapusBuku;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='63'");    
		}
		echo nl2br("\n");

		$lapCALK59PendapatanLainlainPiutangHapusBuku = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='59'")->result_array()[0][$bulansekarang];   

		if(round($PendapatanLainlainPiutangHapusBuku)== round($lapCALK59PendapatanLainlainPiutangHapusBuku)){
			echo ' true';     echo ' neracasaldo id 63';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='63'");    
		}else{
			echo ' false';     echo ' neracasaldo id 63';echo nl2br("\n");
			echo $PendapatanLainlainPiutangHapusBuku; 
			echo ' vs ';
			echo $lapCALK59PendapatanLainlainPiutangHapusBuku;
			$selisih= $PendapatanLainlainPiutangHapusBuku-$lapCALK59PendapatanLainlainPiutangHapusBuku;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='63'");    
		}
		echo nl2br("\n");
		$pendapatanLainlainPenyesuaian=0;
		$lapCALK61pendapatanLainlainPenyesuaian = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='60'")->result_array()[0][$bulansekarang];   

		if(round($pendapatanLainlainPenyesuaian)== round($lapCALK61pendapatanLainlainPenyesuaian)){
			echo ' true';     echo ' neracasaldo id 64';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='64'");    
		}else{
			echo ' false';     echo ' neracasaldo id 64';echo nl2br("\n");
			echo $pendapatanLainlainPenyesuaian; 
			echo ' vs ';
			echo $lapCALK61pendapatanLainlainPenyesuaian;
			$selisih= $pendapatanLainlainPenyesuaian-$lapCALK61pendapatanLainlainPenyesuaian;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='64'");    
		}
		echo nl2br("\n");

	
		$lapCALK61pendapatanLainlainLains = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='61'")->result_array()[0][$bulansekarang];  

		if(round($pendapatanLainlainLains)== round($lapCALK61pendapatanLainlainLains)){
			echo ' true';     echo ' neracasaldo id 65';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='65'");    
		}else{
			echo ' false';     echo ' neracasaldo id 65';echo nl2br("\n");
			echo $pendapatanLainlainLains; 
			echo ' vs ';
			echo $lapCALK61pendapatanLainlainLains;
			$selisih= $pendapatanLainlainLains-$lapCALK61pendapatanLainlainLains;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='65'");    
		}
		echo nl2br("\n");

		$lapCALK62bebanAdmdanUmum = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='62'")->result_array()[0][$bulansekarang];   

		if(round($bebanAdmdanUmum)== round($lapCALK62bebanAdmdanUmum)){
			echo ' true';     echo ' neracasaldo id 66';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='66'");    
		}else{
			echo ' false';     echo ' neracasaldo id 66';echo nl2br("\n");
			echo $bebanAdmdanUmum; 
			echo ' vs ';
			echo $lapCALK62bebanAdmdanUmum;
			$selisih= $bebanAdmdanUmum-$lapCALK62bebanAdmdanUmum;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='66'");    
		}
		echo nl2br("\n");

		$lapCALK67totBebanPenyisihan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='67'")->result_array()[0][$bulansekarang];   

		if(round($totBebanPenyisihan)== round($lapCALK67totBebanPenyisihan)){
			echo ' true';     echo ' neracasaldo id 67';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='67'");    
		}else{
			echo ' false';     echo ' neracasaldo id 67';echo nl2br("\n");
			echo $totBebanPenyisihan; 
			echo ' vs ';
			echo $lapCALK67totBebanPenyisihan;
			$selisih= $totBebanPenyisihan-$lapCALK67totBebanPenyisihan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='67'");    
		}
		echo nl2br("\n");

		$lapCALK68totBebanPenyisihan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='68'")->result_array()[0][$bulansekarang];   

		if(round($jumBebanPenyisihanIndustri)== round($lapCALK68totBebanPenyisihan)){
			echo ' true';     echo ' neracasaldo id 68';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='68'");    
		}else{
			echo ' false';     echo ' neracasaldo id 68';echo nl2br("\n");
			echo $jumBebanPenyisihanIndustri; 
			echo ' vs ';
			echo $lapCALK68totBebanPenyisihan;
			$selisih= $jumBebanPenyisihanIndustri-$lapCALK68totBebanPenyisihan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='68'");    
		}
		echo nl2br("\n");

		$lapCALK69jumBebanPenyisihanPerdagangan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='69'")->result_array()[0][$bulansekarang];   

		if(round($jumBebanPenyisihanPerdagangan)== round($lapCALK69jumBebanPenyisihanPerdagangan)){
			echo ' true';     echo ' neracasaldo id 69';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='69'");    
		}else{
			echo ' false';     echo ' neracasaldo id 69';echo nl2br("\n");
			echo $jumBebanPenyisihanPerdagangan; 
			echo ' vs ';
			echo $lapCALK69jumBebanPenyisihanPerdagangan;
			$selisih= $jumBebanPenyisihanPerdagangan-$lapCALK69jumBebanPenyisihanPerdagangan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='69'");    
		}
		echo nl2br("\n");

		$lapCALK70jumBebanPenyisihanPertanian = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='70'")->result_array()[0][$bulansekarang];   

		if(round($jumBebanPenyisihanPertanian)== round($lapCALK70jumBebanPenyisihanPertanian)){
			echo ' true';     echo ' neracasaldo id 70';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='70'");    
		}else{
			echo ' false';     echo ' neracasaldo id 70';echo nl2br("\n");
			echo $jumBebanPenyisihanPertanian; 
			echo ' vs ';
			echo $lapCALK70jumBebanPenyisihanPertanian;
			$selisih= $jumBebanPenyisihanPertanian-$lapCALK70jumBebanPenyisihanPertanian;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='70'");    
		}
		echo nl2br("\n");

		$lapCALK71jumBebanPenyisihanPerkebunan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='71'")->result_array()[0][$bulansekarang];   

		if(round($jumBebanPenyisihanPerkebunan)== round($lapCALK71jumBebanPenyisihanPerkebunan)){
			echo ' true';     echo ' neracasaldo id 71';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='71'");    
		}else{
			echo ' false';     echo ' neracasaldo id 71';echo nl2br("\n");
			echo $jumBebanPenyisihanPerkebunan; 
			echo ' vs ';
			echo $lapCALK71jumBebanPenyisihanPerkebunan;
			$selisih= $jumBebanPenyisihanPerkebunan-$lapCALK71jumBebanPenyisihanPerkebunan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='71'");    
		}
		echo nl2br("\n");

		$lapCALK72jumBebanPenyisihanPerikanan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='72'")->result_array()[0][$bulansekarang];   

		if(round($jumBebanPenyisihanPerikanan)== round($lapCALK72jumBebanPenyisihanPerikanan)){
			echo ' true';     echo ' neracasaldo id 72';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='72'");    
		}else{
			echo ' false';     echo ' neracasaldo id 72';echo nl2br("\n");
			echo $jumBebanPenyisihanPerikanan; 
			echo ' vs ';
			echo $lapCALK72jumBebanPenyisihanPerikanan;
			$selisih= $jumBebanPenyisihanPerikanan-$lapCALK72jumBebanPenyisihanPerikanan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='72'");    
		}
		echo nl2br("\n");

		$lapCALK73jumBebanPenyisihanPeternakan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='73'")->result_array()[0][$bulansekarang];   

		if(round($jumBebanPenyisihanPeternakan)== round($lapCALK73jumBebanPenyisihanPeternakan)){
			echo ' true';     echo ' neracasaldo id 73';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='73'");    
		}else{
			echo ' false';     echo ' neracasaldo id 73';echo nl2br("\n");
			echo $jumBebanPenyisihanPeternakan; 
			echo ' vs ';
			echo $lapCALK73jumBebanPenyisihanPeternakan;
			$selisih= $jumBebanPenyisihanPeternakan-$lapCALK73jumBebanPenyisihanPeternakan;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='73'");    
		}
		echo nl2br("\n");

		$lapCALK74jumBebanPenyisihanJasa = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='74'")->result_array()[0][$bulansekarang];   

		if(round($jumBebanPenyisihanJasa)== round($lapCALK74jumBebanPenyisihanJasa)){
			echo ' true';     echo ' neracasaldo id 74';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='74'");    
		}else{
			echo ' false';     echo ' neracasaldo id 74';echo nl2br("\n");
			echo $jumBebanPenyisihanJasa; 
			echo ' vs ';
			echo $lapCALK74jumBebanPenyisihanJasa;
			$selisih= $jumBebanPenyisihanJasa-$lapCALK74jumBebanPenyisihanJasa;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='74'");    
		}
		echo nl2br("\n");

		$lapCALK75jumBebanPenyisihanLainlain = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='75'")->result_array()[0][$bulansekarang];   

		if(round($jumBebanPenyisihanLainlain)== round($lapCALK75jumBebanPenyisihanLainlain)){
			echo ' true';     echo ' neracasaldo id 75';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='75'");    
		}else{
			echo ' false';     echo ' neracasaldo id 75';echo nl2br("\n");
			echo $jumBebanPenyisihanLainlain; 
			echo ' vs ';
			echo $lapCALK75jumBebanPenyisihanLainlain;
			$selisih= $jumBebanPenyisihanLainlain-$lapCALK75jumBebanPenyisihanLainlain;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='75'");    
		}
		echo nl2br("\n");

		$lapCALK75jumBebanLainlain = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='75'")->result_array()[0][$bulansekarang];   

		if(round($jumBebanPenyisihanLainlain)== round($lapCALK75jumBebanLainlain)){
			echo ' true';     echo ' neracasaldo id 76';
			$this->db->query("UPDATE neracasaldo SET selisih='0' WHERE id='76'");    
		}else{
			echo ' false';     echo ' neracasaldo id 76';echo nl2br("\n");
			echo $jumBebanPenyisihanLainlain; 
			echo ' vs ';
			echo $lapCALK75jumBebanLainlain;
			$selisih= $jumBebanPenyisihanLainlain-$lapCALK75jumBebanLainlain;
			echo ' selisih='; echo $selisih;
			$this->db->query("UPDATE neracasaldo SET selisih='$selisih' WHERE id='76'");    
		}
		echo nl2br("\n");

		return redirect(base_url('Admin/neracaSaldo'));
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