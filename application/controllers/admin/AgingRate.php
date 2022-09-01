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
	}

	public function index()
	{
		$data = [
			'title' => 'Data Aging Rate',
            'header' => 'Aging Rate',
			'agingrate' => $this->agingrate_model->getAgingRate(),
		];
		
		$this->template->load('aging_rate/index', $data);
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
					$this->db->query("UPDATE `piutangmitra` SET `sisapinjaman` = $m->saldopokok, `masalah` = 'tdkbermasalah' WHERE `nokontrak` = '$m->nokontrak'");
				} else {
					$this->db->query("INSERT INTO `piutangmitra` (`id`, `nokontrak`, `sisapinjaman`, `status`, `tanggal`, `alokasisisih`, `sektor`, `perioda`, `masalah`) VALUES
					(NULL, '$m->nokontrak', $m->saldopokok, '$m->kolektibilitas', '$date', 0, '$m->sektorUsaha', '$month', 'tdkbermasalah')");
				}

				$totnilsaldopokok_tdkbermasalah += $m->saldopokok;
			}

			if($m->saldopokok > '0' AND ($m->tdkbermasalah == 'masalah' OR $m->tdkbermasalah == 'Masalah' OR $m->tdkbermasalah == 'MASALAH')){
				if($mitra = $this->agingrate_model->getMitraKontrak($m->nokontrak) != NULL){
					$this->db->query("UPDATE `piutangmitra` SET `sisapinjaman` = $m->saldopokok, `masalah` = 'bermasalah' WHERE `nokontrak` = '$m->nokontrak'");
				} else {
					$this->db->query("INSERT INTO `piutangmitra` (`id`, `nokontrak`, `sisapinjaman`, `status`, `tanggal`, `alokasisisih`, `sektor`, `perioda`, `masalah`) VALUES
					(NULL, '$m->nokontrak', $m->saldopokok, '$m->kolektibilitas', '$date', 0, '$m->sektorUsaha', '$month', 'bermasalah')");
				}
			}

		}      
		
		$totalMB=$totLancartdkbermasalah+$totKurangLancartdkbermasalah+$totDiragukantdkbermasalah+$totMacettdkbermasalah; 
		$selisih = $totMacettdkbermasalah - $this->agingrate_model->getTotalMacetBulanLalu()[0]->macet;

		echo ' CEK DATA :'; echo nl2br("\n");
		echo 'totLancar   ='; echo number_format($totLancartdkbermasalah) ; echo nl2br("\n");
		echo 'totKrgLancar='; echo number_format($totKurangLancartdkbermasalah) ; echo nl2br("\n");
		echo 'totDiragukan='; echo number_format($totDiragukantdkbermasalah) ; echo nl2br("\n");
		echo 'totMacet    ='; echo number_format($totMacettdkbermasalah) ; echo nl2br("\n");
		echo 'Selisih    ='; echo number_format($selisih) ; echo nl2br("\n");
		echo '$total MB    ='; echo number_format($totalMB) ; echo nl2br("\n");

		$agingrate = $this->agingrate_model->getAgingRate();
		$idkosong = 0;
		foreach ($agingrate as $key => $value) {
			if ($value->lancar == '0' AND $idkosong == '0'){
				$idkosong = $value->id;
				$bulankosong = $value->bulan;

				echo '$idkosong='; echo $idkosong; 
				echo'bulan kosong';   echo $bulankosong ;
				echo nl2br("\n");
			}
		}

		echo ' cek ulang?'; echo '$idkosong='; echo $idkosong;    
		echo ' bulan di tabel =>';   echo $bulankosong ;
		echo ' ldate =>';      echo $date;      echo nl2br("\n");

		$agingrate = $this->agingrate_model->getAgingRateHitung();
		$lancarkekuranglancar = [];
		$kuranglancarkediragukan = [];
		$diragukankemacet = [];

		for ($i=0; $i < count($agingrate); $i++) { 
			if($agingrate[$i]['lancar'] != '0' AND $agingrate[$i]['kuranglancar'] != '0'){
				$saldolancar = $agingrate[$i]['lancar'];
				$saldokuranglancar = $agingrate[$i + 1]['kuranglancar'];
				echo 'lancar ke kurang lancar => '; echo $saldolancar; echo ' / '; echo $saldokuranglancar; echo nl2br("\n");
				$lancarkekuranglancar[] = ($saldokuranglancar / $saldolancar) * 100;
			} else {
				$lancarkekuranglancar[] = 100;
			}

			if($agingrate[$i]['kuranglancar'] != '0' AND $agingrate[$i]['diragukan'] != '0'){
				$saldokuranglancar = $agingrate[$i]['kuranglancar'];
				$saldodiragukan = $agingrate[$i + 5]['diragukan'];
				echo 'kuranglancar ke diragukan => '; echo $saldokuranglancar; echo ' / '; echo $saldodiragukan; echo nl2br("\n");
				$kuranglancarkediragukan[] = ($saldodiragukan / $saldokuranglancar) * 100;
			}
		}
		
		for ($i=0; $i < count($agingrate); $i++) { 
			$saldodiragukan = $agingrate[$i]['diragukan'];
			$saldoselisih = $i < 21 ? $agingrate[$i + 3]['selisih'] : 0.00;
			echo 'Diragukan ke macet => '; echo $saldoselisih; echo ' / '; echo $saldodiragukan; echo nl2br("\n");
			if ($saldodiragukan == 0) {
				$diragukankemacet[] = ($saldoselisih) * 100;
			} else {
				$diragukankemacet[] = (($saldoselisih / $saldodiragukan) * 100) < 0 ? 0 : ($saldoselisih / $saldodiragukan) * 100;
			}
		}

		array_pop($lancarkekuranglancar);
		$avaregelancarkekuranglancar = array_sum($lancarkekuranglancar) / count($lancarkekuranglancar);
		$lancarkekuranglancar[] = $avaregelancarkekuranglancar;

		// array_pop($kuranglancarkediragukan);	
		$avaregekuranglancarkediragukan = array_sum($kuranglancarkediragukan) / count($kuranglancarkediragukan);
		$kuranglancarkediragukan[] = $avaregekuranglancarkediragukan;

		array_pop($diragukankemacet);
		array_pop($diragukankemacet);
		array_pop($diragukankemacet);

		$avaregediragukankemacet = array_sum($diragukankemacet) / count($diragukankemacet);
		$diragukankemacet[] = $avaregediragukankemacet;

		foreach ($lancarkekuranglancar as $key => $value) {
			echo '$lancarkekuranglancar = '; echo $value; echo nl2br("\n");
		}
		foreach ($kuranglancarkediragukan as $key => $value) {
			echo '$kuranglancarkediragukan = '; echo $value; echo nl2br("\n");
		}
		foreach ($diragukankemacet as $key => $value) {
			echo '$diragukankemacet = '; echo $value; echo nl2br("\n");
		}

		$pdllancar = round(($avaregelancarkekuranglancar * $avaregekuranglancarkediragukan * $avaregediragukankemacet) / 10000, 8);
		$pdkuranglancar = ($avaregekuranglancarkediragukan * $avaregediragukankemacet) / 100;
		$pddiragukan = $avaregediragukankemacet;
		$pdmacet = 100;

		echo '$pdllancar = '; echo $pdllancar; echo nl2br("\n");
		echo '$pdkuranglancar = '; echo $pdkuranglancar; echo nl2br("\n");
		echo '$pddiragukan = '; echo $pddiragukan; echo nl2br("\n");
		echo '$pdmacet = '; echo $pdmacet; echo nl2br("\n");

		$tplancar = $pdllancar * 100;
		$tpkuranglancar = $pdkuranglancar * 100;
		$tpdiragukan = $pddiragukan * 100;
		$tpmacet = $pdmacet * 100;

		echo '$tplancar = '; echo $tplancar; echo nl2br("\n");
		echo '$tpkuranglancar = '; echo $tpkuranglancar; echo nl2br("\n");
		echo '$tpdiragukan = '; echo $tpdiragukan; echo nl2br("\n");
		echo '$tpmacet = '; echo $tpmacet; echo nl2br("\n");

		$this->db->query("UPDATE transposeagingrate SET lankekrglan='$avaregelancarkekuranglancar' WHERE id=$idkosong - 1");     
		$this->db->query("UPDATE transposeagingrate SET krglankediragu='$avaregekuranglancarkediragukan' WHERE id=$idkosong - 1");
		$this->db->query("UPDATE transposeagingrate SET diragukemacet='$avaregediragukankemacet' WHERE id=$idkosong - 1");

		$this->db->query("UPDATE transposeagingrate SET prodeflancar='$pdllancar' WHERE id=$idkosong - 1");//
		$this->db->query("UPDATE transposeagingrate SET prodefkuranglancar='$pdkuranglancar' WHERE id=$idkosong - 1");
		$this->db->query("UPDATE transposeagingrate SET prodefdiragukan='$pddiragukan' WHERE id=$idkosong - 1");
	}

	public function createExcel() {
		$fileName = 'aging-rate-' . date('Y') .'.xlsx';  

		$agingrate = $this->agingrate_model->getAgingRate();
		$spreadsheet = new Spreadsheet();
		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

        $sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(25);

		$sheet->mergeCells('A2:Z2');
		$sheet->getStyle('A2:Z2')->getFont()->setBold(true);
		$sheet->getStyle('A2:Z2')->getAlignment()->setHorizontal('center');

		$sheet->setCellValue('A2', 'AGING RATE');

		$sheet->setCellValue('B3', 'STEP #1');
		$sheet->setCellValue('C3', 'Isi Angka Kualitas AR Dari Bulan Jan 2020 - Sep 2021');

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

