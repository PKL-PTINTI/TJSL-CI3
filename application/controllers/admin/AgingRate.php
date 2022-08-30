<?php
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

		echo ' CEK DATA :'; echo nl2br("\n");
		echo 'totLancar   ='; echo number_format($totLancartdkbermasalah) ; echo nl2br("\n");
		echo 'totKrgLancar='; echo number_format($totKurangLancartdkbermasalah) ; echo nl2br("\n");
		echo 'totDiragukan='; echo number_format($totDiragukantdkbermasalah) ; echo nl2br("\n");
		echo 'totMacet    ='; echo number_format($totMacettdkbermasalah) ; echo nl2br("\n");
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

