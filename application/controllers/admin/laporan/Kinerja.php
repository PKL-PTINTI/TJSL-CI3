<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kinerja extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('KinerjaModel', 'kinerja_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Data Laporan Kinerja',
            'header' => 'Management Data Laporan Kinerja'
		];

        if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
			$data['bulan'] =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		}

		if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
			$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		}

		$tingkatPengembalianHasil = $this->kinerja_model->getData();

		$count = 0;
		$dataRow = [];
		$no = 1;
		$kolex = 0;
		$skor = 0;
		
		foreach ($tingkatPengembalianHasil as $row) {
			$count++;

			if ($count <= 5) {
				$totsaldo = $row["$perioda"];
				$timbang = $row['timbang' . $perioda];

				$rowData = [];
				$rowData['sektor'] = $row['sektor'];
				$rowData['perioda'] = $totsaldo;
				$rowData['prosen'] = $row['prosen'];
				$rowData['timbang'] = $timbang;
				$rowData['rkajan22'] = $row['rkajan22'];
				$rowData['rkasdjan22'] = $row['rkasdjan22'];
				$rowData['totsaldo'] = $totsaldo;
				$rowData['totsaldo2'] = $totsaldo;
				$rowData['rkajan21'] = $row['rkajan21'];
				$rowData['rkasdjan21'] = $row['rkasdjan21'];
				$rowData['prosen1'] = $row['prosen' . $perioda];
				$rowData['prosensd'] = $row['prosensd' . $perioda];

				$dataRow[] = $rowData;
			} else {
				if($count == 6){
					$kolex = $row["$perioda"];
				} elseif($count == 7){
					$skor = $row["$perioda"];
				}
			}
		}

		$data['dataRow'] = $dataRow;
		$data['timbang'] = $timbang;
		$data['totsaldo'] = $totsaldo;
		$data['kolex'] = $kolex;
		$data['skor'] = $skor;

		


		$this->template->load('kinerja/index', $data);
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
