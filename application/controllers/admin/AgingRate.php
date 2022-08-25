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
		$totLancartdkbermasalah = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('normal','Normal','NORMAL') AND saldopokok > 0 AND kolektibilitas IN ('lancar', 'Lancar', 'LANCAR')")->row()->total;
		$totKurangLancartdkbermasalah = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('normal','Normal','NORMAL') AND saldopokok > 0 AND kolektibilitas IN ('kurang lancar', 'Kurang Lancar', 'KURANG LANCAR')")->row()->total;
		$totDiragukantdkbermasalah = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('normal','Normal','NORMAL') AND saldopokok > 0 AND kolektibilitas IN ('diragukan', 'Diragukan', 'DIRAGUKAN')")->row()->total;
		$totMacettdkbermasalah = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('normal','Normal','NORMAL') AND saldopokok > 0 AND kolektibilitas IN ('macet', 'Macet', 'MACET')")->row()->total;
		
		$totnilsaldopokok_tdkbermasalah = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('normal','Normal','NORMAL') AND saldopokok > 0")->row()->total;
		$totnilsaldopokok_bermasalah = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('masalah','Masalah','MASALAH') AND saldopokok > 0")->row()->total;
		
		$totmitrabermasalahindustri = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('masalah','Masalah','MASALAH') AND saldopokok > 0 AND sektorUsaha='Sektor Industri' ")->row()->total;
		$totmitrabermasalahperdagangan = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('masalah','Masalah','MASALAH') AND saldopokok > 0 AND sektorUsaha='Sektor Perdagangan' ")->row()->total;
		$totmitrabermasalahpertanian = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('masalah','Masalah','MASALAH') AND saldopokok > 0 AND sektorUsaha='Sektor Pertanian' ")->row()->total;
		$totmitrabermasalahperkebunan = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('masalah','Masalah','MASALAH') AND saldopokok > 0 AND sektorUsaha='Sektor Perkebunan' ")->row()->total;
		$totmitrabermasalahperikanan = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('masalah','Masalah','MASALAH') AND saldopokok > 0 AND sektorUsaha='Sektor Perikanan' ")->row()->total;
		$totmitrabermasalahpeternakan = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('masalah','Masalah','MASALAH') AND saldopokok > 0 AND sektorUsaha='Sektor Peternakan' ")->row()->total;
		$totmitrabermasalahjasa = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('masalah','Masalah','MASALAH') AND saldopokok > 0 AND sektorUsaha='Sektor Jasa' ")->row()->total;
		$totmitrabermasalahlainlain = $this->db->query("SELECT SUM(saldopokok) AS total FROM mitra WHERE  tdkbermasalah IN ('masalah','Masalah','MASALAH') AND saldopokok > 0 AND sektorUsaha='Sektor Lain-lain' ")->row()->total;
		
		$mitra = $this->mitra_model->getMitra();
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		$ldate = date('Y-m-d');
		$no = 1;
		$nomor = 0;

		foreach($mitra as $m){
			if($m->saldopokok > '0' AND ($m->tdkbermasalah == 'normal' OR $m->tdkbermasalah == 'Normal' OR $m->tdkbermasalah == 'NORMAL')){
				$nomor++;
				// $this->db->query("INSERT INTO `piutangtdkbermasalah$perioda`(`id`, `nokontrak`, `sisapinjaman`, `status`, `tgl`, `alokasisisih`, `sektor`)  VALUES ('$no','$m->nokontrak','$m->saldopokok','$m->kolektibilitas','$ldate', '0','$m->sektorUsaha')");
				$no++;
			}

			if($m->saldopokok > '0' AND ($m->tdkbermasalah == 'masalah' OR $m->tdkbermasalah == 'Masalah' OR $m->tdkbermasalah == 'MASALAH')){
				$nomor++;
				$this->db->query("INSERT INTO `piutangbermasalah$perioda`(`id`, `nokontrak`, `sisapinjaman`, `status`,tgl) VALUES ('$no','$m->nokontrak','$m->saldopokok','$m->kolektibilitas','$ldate')");
				$no++;
			}
		}

		$totalMB = $totLancartdkbermasalah + $totKurangLancartdkbermasalah + $totDiragukantdkbermasalah + $totMacettdkbermasalah; 

		echo ' CEK DATA :'; echo nl2br("\n");
		echo 'totLancar   ='; echo number_format($totLancartdkbermasalah) ; echo nl2br("\n");
		echo 'totKrgLancar='; echo number_format($totKurangLancartdkbermasalah) ; echo nl2br("\n");
		echo 'totDiragukan='; echo number_format($totDiragukantdkbermasalah) ; echo nl2br("\n");
		echo 'totMacet    ='; echo number_format($totMacettdkbermasalah) ; echo nl2br("\n");
		echo '$total MB    ='; echo number_format($totalMB) ; echo nl2br("\n");

		$transpose = $this->agingrate_model->getTransposeAgingRate();
		$maxID = $transpose[0]->id;        
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

