
<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

			$this->data['link_active'] = 'Admin/agingrate';

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
			if($m->saldopokok > '0' AND ($m->tdkbermasalah == 'normal' OR $m->tdkbermasalah == 'Normal' OR $m->tdkbermasalah == 'NORMAL') AND $m->kolektibilitas!='LUNAS' AND $m->kolektibilitas!='Lunas' AND $m->kolektibilitas!='lunas'){
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
		$selisihbulan = $totMacettdkbermasalah - $this->agingrate_model->getTotalMacetBulanLalu()[0]->macet;

		$this->data['totLancartdkbermasalah'] = $totLancartdkbermasalah;
		$this->data['totKurangLancartdkbermasalah'] = $totKurangLancartdkbermasalah;
		$this->data['totDiragukantdkbermasalah'] = $totDiragukantdkbermasalah;
		$this->data['totMacettdkbermasalah'] = $totMacettdkbermasalah;
		$this->data['selisih'] = $selisihbulan;
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
		$this->data['bulankosong'] = $bulankosong;

		$selisih = 0 - $totMacettdkbermasalah;

		$this->db->query("UPDATE `transposeagingrate` SET `lancar` = $totLancartdkbermasalah, `kuranglancar` = $totKurangLancartdkbermasalah, `diragukan` = $totDiragukantdkbermasalah, `macet` = $totMacettdkbermasalah, `jumlah` = $totalMB WHERE `transposeagingrate`.`id` = $idkosong - 1");
		$this->db->query("UPDATE `transposeagingrate` SET `selisih` = '$selisih'  WHERE `transposeagingrate`.`id` = $idkosong");
		$this->db->query("UPDATE `transposeagingrate` SET `selisih` = '$selisihbulan'  WHERE `transposeagingrate`.`id` = $idkosong - 1");

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
				if($i >= 19){
					$saldodiragukan = 0;
				} else {
					$saldodiragukan = $agingrate[$i + 5]['diragukan'];
				}
				// echo 'kuranglancar ke diragukan => '; echo $saldodiragukan; echo ' / '; echo $saldokuranglancar; echo nl2br("\n");
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

		$this->db->query("UPDATE transposeagingrate SET lankekrglan='$avaregelancarkekuranglancar' WHERE id=$idkosong - 2");     
		$this->db->query("UPDATE transposeagingrate SET krglankediragu='$avaregekuranglancarkediragukan' WHERE id=$idkosong - 6");
		$this->db->query("UPDATE transposeagingrate SET diragukemacet='$avaregediragukankemacet' WHERE id=$idkosong - 4");

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

		$this->db->query("UPDATE transposeagingrate SET prodeflancar='$pdlancar' WHERE id=$idkosong - 1");//
		$this->db->query("UPDATE transposeagingrate SET prodefkuranglancar='$pdkuranglancar' WHERE id=$idkosong - 1 ");

		$this->data['title'] = 'Aging Rate';

		$this->template->load('aging_rate/detail', $this->data);
	}

	public function alokasipiutang(){
		$this->data['title'] = 'Alokasi Piutang';
		$this->data['header'] = 'Alokasi Piutang';
		$perioda = date('M', strtotime('-1 month'));
		$this->data['piutangmitra'] = $this->db->query("SELECT * FROM piutangmitra WHERE masalah='tdkbermasalah' AND perioda='$perioda'")->result_array();
		$this->data['alokasisisih'] = $this->db->query("SELECT SUM(alokasisisih) as alok FROM piutangmitra WHERE masalah='tdkbermasalah' AND perioda='$perioda'")->result_array()[0]['alok'];
		$this->data['saldopiutang'] = $this->db->query("SELECT SUM(sisapinjaman) as saldopiutang FROM piutangmitra WHERE masalah='tdkbermasalah' AND perioda='$perioda'")->result_array()[0]['saldopiutang'];

		$this->template->load('aging_rate/alokasipiutang', $this->data);
	}

	public function exportAlokasiPiutang(){
		$fileName = 'Alokasi Piutang.xlsx';	
		$perioda = date('M', strtotime('-1 month'));
		$piutangmitra = $this->db->query("SELECT * FROM piutangmitra WHERE masalah='tdkbermasalah' AND perioda='$perioda'")->result_array();
		$alokasisisih = $this->db->query("SELECT SUM(alokasisisih) as alok FROM piutangmitra WHERE masalah='tdkbermasalah' AND perioda='$perioda'")->result_array()[0]['alok'];
		$saldopiutang = $this->db->query("SELECT SUM(sisapinjaman) as saldopiutang FROM piutangmitra WHERE masalah='tdkbermasalah' AND perioda='$perioda'")->result_array()[0]['saldopiutang'];

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setWidth(20);
		$sheet->getColumnDimension('D')->setWidth(20);
		$sheet->getColumnDimension('E')->setWidth(20);
		$sheet->getColumnDimension('F')->setWidth(20);
		$sheet->getColumnDimension('G')->setWidth(20);
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No kontrak');
		$sheet->setCellValue('C1', 'Sektor');
		$sheet->setCellValue('D1', 'Status');
		$sheet->setCellValue('E1', 'Sisa Pinjaman');
		$sheet->setCellValue('F1', 'Alokasi Sisa Pinjaman');
		$sheet->setCellValue('G1', 'Alokasi Sisa Pinjaman (%)');

		$no = 1;
		$x = 2;
		foreach ($piutangmitra as $piutang) {
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $piutang['nokontrak']);
			$sheet->setCellValue('C'.$x, $piutang['sektor']);
			$sheet->setCellValue('D'.$x, $piutang['status']);
			$sheet->setCellValue('E'.$x, number_format($piutang['sisapinjaman']));
			$sheet->setCellValue('F'.$x, number_format($piutang['alokasisisih']));
			$sheet->setCellValue('G'.$x, ($piutang['alokasisisih']/$saldopiutang)*100);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save("storage/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/storage/".$fileName); 
	}

	public function createExcel() {
		$fileName = 'aging-rate-' . date('Y') .'.xlsx';  
		$agingrate = $this->agingrate_model->getAgingRate();
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setWidth(20);
		$sheet->getColumnDimension('D')->setWidth(20);
		$sheet->getColumnDimension('E')->setWidth(20);
		$sheet->getColumnDimension('F')->setWidth(20);
		$sheet->getColumnDimension('G')->setWidth(20);
		$sheet->getColumnDimension('H')->setWidth(20);
		$sheet->getColumnDimension('I')->setWidth(20);
		$sheet->getColumnDimension('J')->setWidth(20);
		$sheet->getColumnDimension('K')->setWidth(20);
		$sheet->getColumnDimension('L')->setWidth(20);
		$sheet->getColumnDimension('M')->setWidth(20);

		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Bulan');
		$sheet->setCellValue('C1', 'Lancar');
		$sheet->setCellValue('D1', 'Kurang Lancar');
		$sheet->setCellValue('E1', 'Diragukan');
		$sheet->setCellValue('F1', 'Macet');
		$sheet->setCellValue('G1', 'Selisih');
		$sheet->setCellValue('H1', 'Jumlah');
		$sheet->setCellValue('I1', 'Lancar Ke Kurang Lancar');
		$sheet->setCellValue('J1', 'Kurang Lancar Ke Diragukan');
		$sheet->setCellValue('K1', 'Diragukan Ke Macet');
		$sheet->setCellValue('L1', 'Probabilitas Default Lancar');
		$sheet->setCellValue('M1', 'Probabilitas Default Kurang Lancar');
		
		foreach ($agingrate as $key => $value) {
			$sheet->setCellValue('A' . ($key + 2), $value->id);
			$sheet->setCellValue('B' . ($key + 2), $value->bulan);
			$sheet->setCellValue('C' . ($key + 2), number_format($value->lancar));
			$sheet->setCellValue('D' . ($key + 2), number_format($value->kuranglancar));
			$sheet->setCellValue('E' . ($key + 2), number_format($value->diragukan));
			$sheet->setCellValue('F' . ($key + 2), number_format($value->macet));
			$sheet->setCellValue('G' . ($key + 2), number_format($value->selisih));
			$sheet->setCellValue('H' . ($key + 2), number_format($value->jumlah));
			$sheet->setCellValue('I' . ($key + 2), round($value->lankekrglan, 2));
			$sheet->setCellValue('J' . ($key + 2), round($value->krglankediragu, 2));
			$sheet->setCellValue('K' . ($key + 2), round($value->diragukemacet, 2));
			$sheet->setCellValue('L' . ($key + 2), round($value->prodeflancar, 2));
			$sheet->setCellValue('M' . ($key + 2), round($value->prodefkuranglancar, 2));
		}

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

