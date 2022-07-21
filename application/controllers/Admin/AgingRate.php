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
		$ldate = date('Y-m-d');
		$no = 1;

		foreach($mitra as $m){
			if ($m->saldopokok > '0' AND ($m->tdkbermasalah == 'normal' OR $m->tdkbermasalah == 'Normal' OR $m->tdkbermasalah == 'NORMAL')) {
				if($ldate>='2022-02-01' AND $ldate<'2022-03-01'){
					$piutangtdkbermasalah='piutangtdkbermasalahjan22';
				}
				if($ldate>='2022-03-01' AND $ldate<'2022-04-01'){
					$piutangtdkbermasalah='piutangtdkbermasalahfeb22';
				}
				if($ldate>='2022-04-01' AND $ldate<'2022-05-01'){
					$piutangtdkbermasalah='piutangtdkbermasalahmar22';
				}
         		if($ldate>='2022-05-01' AND $ldate<'2022-06-01'){
                	$piutangtdkbermasalah='piutangtdkbermasalahapr22';
            	}
         		if($ldate>='2022-06-01' AND $ldate<'2022-07-01'){
              		$piutangtdkbermasalah='piutangtdkbermasalahmei22';  
            	}
         		if($ldate>='2022-07-01' AND $ldate<'2022-08-01'){
                 	$piutangtdkbermasalah='piutangtdkbermasalahjun22';
            	}
         		if($ldate>='2022-08-01' AND $ldate<'2022-09-01'){
                    $piutangtdkbermasalah='piutangtdkbermasalahjul22';
            	}
         		if($ldate>='2022-09-01' AND $ldate<'2022-10-01'){
                    $piutangtdkbermasalah='piutangtdkbermasalahags22';
            	}
         		if($ldate>='2022-10-01' AND $ldate<'2022-11-01'){
             		$piutangtdkbermasalah='piutangtdkbermasalahsep22';
            	}
         		if($ldate>='2022-11-01' AND $ldate<'2022-12-01'){
                	$piutangtdkbermasalah='piutangtdkbermasalahokt22'; 
            	}
         		if($ldate>='2022-12-01' AND $ldate<'2023-01-01'){
                	$piutangtdkbermasalah='piutangtdkbermasalahnop22';
            	}
         		if($ldate>='2023-01-01' AND $ldate<'2023-02-01'){
                	$piutangtdkbermasalah='piutangtdkbermasalahdes22';
            	}
             	if($ldate>='2023-02-01' AND $ldate<'2023-03-01'){
                	$piutangtdkbermasalah='piutangtdkbermasalahjan23';
            	}

				// $this->agingrate_model->storeAging($piutangtdkbermasalah, [
				// 	'nokontrak' => $m->nokontrak,
				// 	'sisapinjaman' => $m->saldopokok,
				// 	'status' => $m->kolektibilitas,
				// 	'tgl' => $ldate,
				// 	'alokasisisih' => '0',
				// 	'sektor' => $m->sektorUsaha,
				// ]);
				$no++;
			}

			if($m->saldopokok > '0' AND ($m->tdkbermasalah == 'masalah' OR $m->tdkbermasalah == 'Masalah' OR $m->tdkbermasalah == 'MASALAH')){
				if($ldate>='2022-02-01' AND $ldate<'2022-03-01'){
                	$piutangbermasalah='piutangbermasalahjan22';
            	}
				if($ldate>='2022-03-01' AND $ldate<'2022-04-01'){
					$piutangbermasalah='piutangbermasalahfeb22';
				}
				if($ldate>='2022-04-01' AND $ldate<'2022-05-01'){
					$piutangbermasalah='piutangbermasalahmar22';
				}
				if($ldate>='2022-05-01' AND $ldate<'2022-06-01'){
					$piutangbermasalah='piutangbermasalahapr22';
				}
				if($ldate>='2022-06-01' AND $ldate<'2022-07-01'){
					$piutangbermasalah='piutangbermasalahmei22';
				}
				if($ldate>='2022-07-01' AND $ldate<'2022-08-01'){
					$piutangbermasalah='piutangbermasalahjun22';
				}
				if($ldate>='2022-08-01' AND $ldate<'2022-09-01'){
					$piutangbermasalah='piutangbermasalahjul22';
				}
				if($ldate>='2022-09-01' AND $ldate<'2022-10-01'){
					$piutangbermasalah='piutangbermasalahags22';
				}
				if($ldate>='2022-10-01' AND $ldate<'2022-11-01'){
					$piutangbermasalah='piutangbermasalahsep22';
				}
				if($ldate>='2022-11-01' AND $ldate<'2022-12-01'){
					$piutangbermasalah='piutangbermasalahokt22';
				}
				if($ldate>='2022-12-01' AND $ldate<'2023-01-01'){
					$piutangbermasalah='piutangbermasalahnop22';
				}
				if($ldate>='2023-01-01' AND $ldate<'2023-02-01'){
					$piutangbermasalah='piutangbermasalahdes22';
				}
				if($ldate>='2023-02-01' AND $ldate<'2023-03-01'){
					$piutangbermasalah='piutangbermasalahjan23';
				}

				// $this->agingrate_model->storeAgingMasalah($piutangbermasalah, [
				// 	'nokontrak' => $m->nokontrak,
				// 	'sisapinjaman' => $m->saldopokok,
				// 	'status' => $m->kolektibilitas,
				// 	'tgl' => $ldate,
				// ]);
			}
		}

		$totalMB = $totLancartdkbermasalah + $totKurangLancartdkbermasalah + $totDiragukantdkbermasalah + $totMacettdkbermasalah; 

		echo ' CEK DATA :'; echo nl2br("\n");
		echo 'totLancar   ='; echo number_format($totLancartdkbermasalah) ; echo nl2br("\n");
		echo 'totKrgLancar='; echo number_format($totKurangLancartdkbermasalah) ; echo nl2br("\n");
		echo 'totDiragukan='; echo number_format($totDiragukantdkbermasalah) ; echo nl2br("\n");
		echo 'totMacet    ='; echo number_format($totMacettdkbermasalah) ; echo nl2br("\n");
		echo '$total MB    ='; echo number_format($totalMB) ; echo nl2br("\n");

		
		// var_dump([
		// 	'totalLancarNormal' => $totalLancarNormal,
		// 	'totalKurangLancarNormal' => $totalKurangLancarNormal,
		// 	'totalDiragukanNormal' => $totalDiragukanNormal,
		// 	'totalMacetNormal' => $totalMacetNormal
		// ]);
	}
}
																																												