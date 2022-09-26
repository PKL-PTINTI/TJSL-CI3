
<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;

class AgingRate extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('AgingRateModel', 'agingrate_model');
		$this->load->model('MitraModel', 'mitra_model');

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

			$this->data['link_active'] = 'Dashboard';

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
		$this->data['title'] = 'Data Aging Rate';
		$this->data['header'] = 'Aging Rate';
		$this->data['agingrate'] = $this->agingrate_model->getAgingRate();
		
		$this->template->load('aging_rate/index', $this->data);
    }

	public function hitungAgingRate(){
		$mitra = $this->mitra_model->getMitra();
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		$date = date('Y-m-d');
		$month = strval(date('M', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

		$totLancartdkbermasalah = 0;
		$totKurangLancartdkbermasalah = 0;
		$totDiragukantdkbermasalah = 0;
		$totMacettdkbermasalah = 0;
		$totnilsaldopokok_tdkbermasalah = 0;

		foreach($mitra as $m){
			if($m->saldopokok > '0' AND ($m->tdkbermasalah == 'normal' OR $m->tdkbermasalah == 'Normal' OR $m->tdkbermasalah == 'NORMAL')){
				if($m->kolektibilitas=='lancar' OR $m->kolektibilitas=='Lancar' OR  $m->kolektibilitas=='LANCAR'){
					$totLancartdkbermasalah+=$m->saldopokok;
				}
				if($m->kolektibilitas=='kurang lancar' OR $m->kolektibilitas=='Kurang Lancar' OR $m->kolektibilitas=='KURANG LANCAR'){
					$totKurangLancartdkbermasalah+=$m->saldopokok;
				}
				if($m->kolektibilitas=='diragukan' OR $m->kolektibilitas=='Diragukan' OR $m->kolektibilitas=='DIRAGUKAN'){
					$totDiragukantdkbermasalah+=$m->saldopokok;
				}
				if($m->kolektibilitas=='macet' OR $m->kolektibilitas=='Macet' OR $m->kolektibilitas=='MACET'){
					$totMacettdkbermasalah+=$m->saldopokok;
				}

				if($mitra = $this->agingrate_model->getMitraKontrak($m->nokontrak) != NULL){
					$this->db->query("UPDATE `piutangmitra` SET `sisapinjaman` = $m->saldopokok, `masalah` = 'tdkbermasalah', `status` ='$m->kolektibilitas' WHERE `nokontrak` = '$m->nokontrak'");
				} else {
					$this->db->query("INSERT INTO `piutangmitra` (`id`, `nokontrak`, `sisapinjaman`, `status`, `tanggal`, `alokasisisih`, `sektor`, `perioda`, `masalah`) VALUES
					(NULL, '$m->nokontrak', $m->saldopokok, '$m->kolektibilitas', '$date', 0, '$m->sektorUsaha', '$month', 'tdkbermasalah')");
				}

				$totnilsaldopokok_tdkbermasalah += $m->saldopokok;
			}

			if($m->saldopokok > '0' AND ($m->tdkbermasalah == 'masalah' OR $m->tdkbermasalah == 'Masalah' OR $m->tdkbermasalah == 'MASALAH')){
				if($mitra = $this->agingrate_model->getMitraKontrak($m->nokontrak) != NULL){
					$this->db->query("UPDATE `piutangmitra` SET `sisapinjaman` = $m->saldopokok, `masalah` = 'bermasalah', `status` = '$m->kolektibilitas'  WHERE `nokontrak` = '$m->nokontrak'");
				} else {
					$this->db->query("INSERT INTO `piutangmitra` (`id`, `nokontrak`, `sisapinjaman`, `status`, `tanggal`, `alokasisisih`, `sektor`, `perioda`, `masalah`) VALUES
					(NULL, '$m->nokontrak', $m->saldopokok, '$m->kolektibilitas', '$date', 0, '$m->sektorUsaha', '$month', 'bermasalah')");
				}
			}

		}      
		
		$totalMB=$totLancartdkbermasalah+$totKurangLancartdkbermasalah+$totDiragukantdkbermasalah+$totMacettdkbermasalah; 
		$selisih = $totMacettdkbermasalah - $this->agingrate_model->getTotalMacetBulanLalu()[0]->macet;

		$this->data['totLancartdkbermasalah'] = $totLancartdkbermasalah;
		$this->data['totKurangLancartdkbermasalah'] = $totKurangLancartdkbermasalah;
		$this->data['totDiragukantdkbermasalah'] = $totDiragukantdkbermasalah;
		$this->data['totMacettdkbermasalah'] = $totMacettdkbermasalah;
		$this->data['selisih'] = $selisih;
		$this->data['totalMB'] = $totalMB;

		$agingrate = $this->agingrate_model->getAgingRate();
		$idkosong = 0;
		foreach ($agingrate as $key => $value) {
			if ($value->lancar == '0' AND $idkosong == '0'){
				$idkosong = $value->id;
				$bulankosong = $value->bulan;
			}
		}

		$this->data['idkosong'] = $idkosong; 
		$this->data['bulankosong'] = $bulankosong ;

		$selisih = 0 - $totMacettdkbermasalah;

		$this->db->query("UPDATE `transposeagingrate` SET `lancar` = $totLancartdkbermasalah, `kuranglancar` = $totKurangLancartdkbermasalah, `diragukan` = $totDiragukantdkbermasalah, `macet` = $totMacettdkbermasalah, `jumlah` = $totalMB WHERE `transposeagingrate`.`id` = $idkosong - 1");
		$this->db->query("UPDATE `transposeagingrate` SET `selisih` = '$selisih'  WHERE `transposeagingrate`.`id` = $idkosong");

		$agingrate = $this->agingrate_model->getAgingRateHitung();
		$lancarkekuranglancar = [];
		$kuranglancarkediragukan = [];
		$diragukankemacet = [];

		for ($i=0; $i < count($agingrate); $i++) { 
			if($agingrate[$i]['lancar'] != '0' AND $agingrate[$i]['kuranglancar'] != '0'){
				$saldolancar = $agingrate[$i]['lancar'];
				$saldokuranglancar = $agingrate[$i + 1]['kuranglancar'];
				// echo 'lancar ke kurang lancar => '; echo $saldolancar; echo ' / '; echo $saldokuranglancar; echo nl2br("\n");
				$lancarkekuranglancar[] = ($saldokuranglancar / $saldolancar) * 100;
			} else {
				$lancarkekuranglancar[] = 100;
			}

			if($agingrate[$i]['kuranglancar'] != '0' AND $agingrate[$i]['diragukan'] != '0'){
				$saldokuranglancar = $agingrate[$i]['kuranglancar'];
				if($i == 19){
					$saldodiragukan = 0;
				} else {
					$saldodiragukan = $agingrate[$i + 5]['diragukan'];
				}
				// echo 'kuranglancar ke diragukan => '; echo $saldokuranglancar; echo ' / '; echo $saldodiragukan; echo nl2br("\n");
				$kuranglancarkediragukan[] = ($saldodiragukan / $saldokuranglancar) * 100;
			}
		}
		
		for ($i=0; $i < count($agingrate); $i++) { 
			$saldodiragukan = $agingrate[$i]['diragukan'];
			$saldoselisih = $i < 21 ? $agingrate[$i + 3]['selisih'] : 0.00;
			// echo 'Diragukan ke macet => '; echo $saldoselisih; echo ' / '; echo $saldodiragukan; echo nl2br("\n");
			if ($saldodiragukan == 0) {
				$diragukankemacet[] = ($saldoselisih) * 100;
			} else {
				if(($saldoselisih / $saldodiragukan) * 100 < 0){
					$diragukankemacet[] = 0;
				} else if(($saldoselisih / $saldodiragukan) * 100 > 100){
					$diragukankemacet[] = 1;
				} else {
					$diragukankemacet[] = ($saldoselisih / $saldodiragukan) * 100;
				}
			}

		
		}

		array_pop($lancarkekuranglancar);
		$avaregelancarkekuranglancar = array_sum($lancarkekuranglancar) / count($lancarkekuranglancar);
		$lancarkekuranglancar[] = $avaregelancarkekuranglancar;

		array_pop($kuranglancarkediragukan);	
		$avaregekuranglancarkediragukan = array_sum($kuranglancarkediragukan) / count($kuranglancarkediragukan);
		$kuranglancarkediragukan[] = $avaregekuranglancarkediragukan;

		array_pop($diragukankemacet);
		array_pop($diragukankemacet);
		array_pop($diragukankemacet);

		$avaregediragukankemacet = array_sum($diragukankemacet) / count($diragukankemacet);
		$diragukankemacet[] = $avaregediragukankemacet;

		$this->data['lancarkekuranglancar'] = $lancarkekuranglancar;
		$this->data['kuranglancarkediragukan'] = $kuranglancarkediragukan;
		$this->data['diragukankemacet'] = $diragukankemacet;

		$pdlancar = round(($avaregelancarkekuranglancar * $avaregekuranglancarkediragukan * $avaregediragukankemacet) / 10000, 8);
		$pdkuranglancar = ($avaregekuranglancarkediragukan * $avaregediragukankemacet) / 100;
		$pddiragukan = $avaregediragukankemacet;
		$pdmacet = 100;

		$this->data['pdlancar'] = $pdlancar;
		$this->data['pdkuranglancar'] = $pdkuranglancar;
		$this->data['pddiragukan'] = $pddiragukan;
		$this->data['pdmacet'] = $pdmacet;

		$tplancar = $pdlancar * 100;
		$tpkuranglancar = $pdkuranglancar * 100;
		$tpdiragukan = $pddiragukan * 100;
		$tpmacet = $pdmacet * 100;

		$this->data['tplancar'] = $tplancar;
		$this->data['tpkuranglancar'] = $tpkuranglancar;
		$this->data['tpdiragukan'] = $tpdiragukan;
		$this->data['tpmacet'] = $tpmacet;

		$this->data['avaregelancarkekuranglancar'] = $avaregelancarkekuranglancar;
		$this->data['avaregekuranglancarkediragukan'] = $avaregekuranglancarkediragukan;
		$this->data['avaregediragukankemacet'] = $avaregediragukankemacet;

		$this->db->query("UPDATE transposeagingrate SET lankekrglan='$avaregelancarkekuranglancar' WHERE id=$idkosong");     
		$this->db->query("UPDATE transposeagingrate SET krglankediragu='$avaregekuranglancarkediragukan' WHERE id=$idkosong");
		$this->db->query("UPDATE transposeagingrate SET diragukemacet='$avaregediragukankemacet' WHERE id=$idkosong");

		$aloklancar      =0-round($pdlancar      *$totLancartdkbermasalah /100); 
		$alokkuranglancar=0-round($pdkuranglancar*$totKurangLancartdkbermasalah/100);
		$alokdiragukan   =0-round($pddiragukan   *$totDiragukantdkbermasalah/100);
		$alokmacet       =0-$totMacettdkbermasalah;

		$this->data['aloklancar'] = $aloklancar;
		$this->data['alokkuranglancar'] = $alokkuranglancar;
		$this->data['alokdiragukan'] = $alokdiragukan;
		$this->data['alokmacet'] = $alokmacet;

		$totalokindustri = 0;
		$totalokperdagangan = 0;
		$totalokpertanian = 0;
		$totalokperkebunan = 0;
		$totalokperikanan = 0;
		$totalokpeternakan = 0;
		$totalokjasa = 0;
		$totaloklainlain = 0;
		$piutangmitra = $this->db->query("SELECT * FROM piutangmitra WHERE masalah='tdkbermasalah'")->result_array();
		foreach ($piutangmitra as $key => $piutang) {
			$id=$piutang['id'];
			if($piutang['status']=='lancar' ) {
				$alokasisisih= ($pdlancar * $piutang['sisapinjaman'])/100 ;
			}
			if($piutang['status']=='kurang lancar' ){
				$alokasisisih= ($pdkuranglancar * $piutang['sisapinjaman'])/100;
			}
			if($piutang['status']=='diragukan' ){
				$alokasisisih= ($pddiragukan * $piutang['sisapinjaman'])/100;
			}
			if($piutang['status']=='macet' ) {
				$alokasisisih= $piutang['sisapinjaman'];
			}

			$this->db->query("UPDATE piutangmitra SET alokasisisih='$alokasisisih' WHERE id=$id");

			if($piutang['sektor']=='Sektor Industri')
			{   $totalokindustri-=$alokasisisih;                }
				if($piutang['sektor']=='Sektor Perdagangan')
			{   $totalokperdagangan-=$alokasisisih;             }
				if($piutang['sektor']=='Sektor Pertanian')
			{  $totalokpertanian-=$alokasisisih;                }
				if($piutang['sektor']=='Sektor Perkebunan')
			{    $totalokperkebunan-=$alokasisisih;             }
				if($piutang['sektor']=='Sektor Perikanan')
			{    $totalokperikanan-=$alokasisisih;              }
				if($piutang['sektor']=='Sektor Peternakan')
			{   $totalokpeternakan-=$alokasisisih;              }
				if($piutang['sektor']=='Sektor Jasa')
			{   $totalokjasa-=$alokasisisih;                    }
				if($piutang['sektor']=='Sektor Lain-lain')
			{   $totaloklainlain-=$alokasisisih;               }
		}

		$this->data['totalokindustri'] = $totalokindustri;
        $this->data['totalokperdagangan'] = $totalokperdagangan;
		$this->data['totalokpertanian'] = $totalokpertanian;
		$this->data['totalokperkebunan'] = $totalokperkebunan;
		$this->data['totalokperikanan'] = $totalokperikanan;
		$this->data['totalokpeternakan'] = $totalokpeternakan;
		$this->data['totalokjasa'] = $totalokjasa;
		$this->data['totaloklainlain'] = $totaloklainlain;

		$this->db->query("UPDATE transposeagingrate SET prodeflancar='$pdlancar' WHERE id=$idkosong");//
		$this->db->query("UPDATE transposeagingrate SET prodefkuranglancar='$pdkuranglancar' WHERE id=$idkosong");

		$this->data['title'] = 'Aging Rate';

		$this->template->load('aging_rate/detail', $this->data);
	}

	public function CreateExcel() {
		$fileName = 'aging-rate-' . date('Y') .'.xlsx';  

		$agingrate = $this->agingrate_model->getAgingRate();
		
		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		
		$inputFileType = 'Xlsx';
		$inputFileName = 'storage\AgingRate.xlsx';

		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$sheet = $spreadsheet->getActiveSheet();

		$stylebold = array(
			'font'  => array(
				'bold'  => true,
				'size'  => 11,
			));

		// for alpabet A-Z
		$alphabet = range('A', 'Z');
		$alphabet = array_merge($alphabet, range('A', 'Z'));
		
		$_back = strval(date('Y') - 1);
		$_now = date('M Y', mktime(0, 0, 0, date("m"), 0, date("Y")));
		$sheet->setCellValue('B2', "STEP #1 isi angka kualitas AR dari bulan Januari $_back  -  $_now");
		$sheet->getStyle('B2')->applyFromArray($stylebold);

		$month = array();
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
		for ($i=1; $i <= 12; $i++) { 
			$month[] = ucfirst($bulan[$i]) . ' ' . date('y', mktime(0, 0, 0, date("m"), date("d"), date("Y")- 1));
		}
		for ($i=1; $i <= 12; $i++) { 
			$month[] = ucfirst($bulan[$i]) . ' ' . date('y', mktime(0, 0, 0, date("m"), date("d"), date("Y")));
		}
		
		$averagelnkekrglan = 0;

		foreach ($agingrate as $key => $value) {
			$sheet->setCellValue($alphabet[$key + 2].'3', $month[$key]);
			$sheet->setCellValue($alphabet[$key + 2].'4', $agingrate[$key]->lancar);
			$sheet->setCellValue($alphabet[$key + 2].'5', $agingrate[$key]->kuranglancar);
			$sheet->setCellValue($alphabet[$key + 2].'6', $agingrate[$key]->diragukan);
			$sheet->setCellValue($alphabet[$key + 2].'7', $agingrate[$key]->macet);
			$sheet->setCellValue($alphabet[$key + 3].'8', $agingrate[$key + 1]->selisih);
			$sheet->setCellValue($alphabet[$key + 2].'9', $agingrate[$key]->jumlah);

			$sheet->setCellValue($alphabet[$key + 2].'13', $agingrate[$key]->lankekrglan);
			$sheet->setCellValue($alphabet[$key + 2].'14', $agingrate[$key]->krglankediragu);
			$sheet->setCellValue($alphabet[$key + 2].'15', $agingrate[$key]->diragukemacet);			
		}

		$prodef = $this->agingrate_model->getProdef();
		$sheet->setCellValue('D19', $prodef[0]->prodeflancar);
		$sheet->setCellValue('D20', $prodef[0]->prodefkuranglancar);
		$sheet->setCellValue('D21', $prodef[0]->prodefdiragukan);

		$writer = new Xlsx($spreadsheet);
		$writer->save("storage/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/storage/".$fileName);   
	
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

