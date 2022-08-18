<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

		$danaYangDisalurkan = $this->kinerja_model->getDanaYangDisalurkan();

		$dana = [];
		foreach ($danaYangDisalurkan as $value) {
			if($value['id'] == 3){
				$totPinjPokok = $value['des21'] + $value['jan22'] + $value['feb22'] + $value['mar22'] + $value['apr22'] + $value['mei22'] + $value['jun22'] + $value['jul22'] + $value['ags22'] + $value['sep22'] + $value['okt22'] + $value['nop22'] + $value['des22'];
			
			}	

			$rowData = [];
			$rowData[] = $value['sektor'];
			$rowData[] = $value["$perioda"];
			$rowData[] = $value["rkajan22"];
			$rowData[] = $value["rkasdjan22"];
			$rowData[] = $value["$perioda"];
			$rowData[] = $value["$perioda"];
			$rowData[] = $value["rkajan21"];
			$rowData[] = $value["rkasdjan21"];
			$rowData[] = $value["prosen" . $perioda];
			$rowData[] = $value["prosensd" . $perioda];

			$dana[] = $rowData;
		}

		$data['dana'] = $dana;

		$danatersedia = $this->kinerja_model->getDanaTersedia();

		$counter = 0;
		$danatersediaRow = [];

		foreach ($danatersedia as $values) {
			$counter++;

			if ($counter <= 6) {

				$rowData = [];
				$rowData[] = $values['sektor'];
				$rowData[] = $values["$perioda"];
				$rowData[] = $values["$perioda"];
				$rowData[] = $values["rkasdjan22"];
				$rowData[] = $values["jan22"];
				$rowData[] = $values["jan22"];
				$rowData[] = $values["rkajan21"];
				$rowData[] = $values["rkasdjan21"];
				$rowData[] = $values["prosen" . $perioda];
				$rowData[] = $values["prosensd" . $perioda];

				$danatersediaRow[] = $rowData;
				$jumlahDanaTersedia = $values["$perioda"];
			} else {
				if($count == 7){
					$prosenDanaDisalurkan = $values["$perioda"];
				} elseif($count == 7){
					$skor = $values["$perioda"];
				}

				$JumlahDanaYgDisalurkan = $this->db->query("SELECT $perioda FROM danayangdisalurkan WHERE id='3' ")->row()->$perioda;
			}
		}

		$data['danatersedia'] = $danatersediaRow;
		$data['JumlahDanaYgDisalurkan'] = $JumlahDanaYgDisalurkan;
		$data['jumlahDanaTersedia'] = $jumlahDanaTersedia;
		$data['prosenDanaDisalurkan'] = $prosenDanaDisalurkan;

		$this->template->load('kinerja/index', $data);
    }

	public function createExcel() {
		$fileName = 'laporan-kinerja' . date('Y') .'.xlsx';  

		$kinerja = $this->kinerja_model->getData();
		$spreadsheet = new Spreadsheet();
		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

        $sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(28);
		$sheet->getColumnDimension('C')->setWidth(25);
		$sheet->getColumnDimension('D')->setWidth(25);

		$sheet->setCellValue('A5', '1. TINGKAT PENGEMBALIAN PINJAMAN MITRA BINAAN');
		$sheet->setCellValue('A6', 'Skor : 100-70=>3, 70-40=>2, 40-10=>1, 10-0=>0');
		$sheet->setCellValue('A9', 'No');
		$sheet->setCellValue('A10', '1');
		$sheet->setCellValue('A11', '2');
		$sheet->setCellValue('A12', '3');
		$sheet->setCellValue('A13', '4');
		$sheet->setCellValue('A14', '5');
		$sheet->setCellValue('B9', 'Kolektibilitas');
		$sheet->setCellValue('B10', 'Lancar');
		$sheet->setCellValue('B11', 'Kurang Lancar');
		$sheet->setCellValue('B12', 'Diragukan');
		$sheet->setCellValue('B13', 'Macet');
		$sheet->setCellValue('B14', 'TOTAL');
		$sheet->setCellValue('C9', 'Jul 2022 (Rp)');
		$sheet->setCellValue('D9', 'Prosen (%)');
		$sheet->setCellValue('E9', 'Timbang (Rp)');
		$sheet->setCellValue('A16', '2. EFFEKTIVITAS PENYALURAN DANA');
		$sheet->setCellValue('A17', '2.1 DANA YANG DISALURKAN ');
		$sheet->setCellValue('A22', 'No');
		$sheet->setCellValue('A23', '1');
		$sheet->setCellValue('A24', '2');
		$sheet->setCellValue('A25', '3');
		$sheet->setCellValue('B22', 'Keterangan');
		$sheet->setCellValue('B23', 'Penyaluran Pinjaman');
		$sheet->setCellValue('B24', 'Dana Pembinaan Kemitraan');
		$sheet->setCellValue('B25', 'JUMLAH DANA YG DISALURKAN');
		$sheet->setCellValue('C22', 'Ags 2022');
		$sheet->setCellValue('A27', 'Skor : 100-90 => 3 , 90-85 => 2, 85-80 => 1 ');
		$sheet->setCellValue('A29', 'No');
		$sheet->setCellValue('A30', '1');
		$sheet->setCellValue('A31', '2');
		$sheet->setCellValue('A32', '3');
		$sheet->setCellValue('A33', '4');
		$sheet->setCellValue('A34', '5');
		$sheet->setCellValue('A35', '6');
		$sheet->setCellValue('B29', 'Keterangan');
		$sheet->setCellValue('B30', 'Saldo Awal');
		$sheet->setCellValue('B31', 'Jasa Administrasi Pinjaman');
		$sheet->setCellValue('B32', 'Jasa Giro');
		$sheet->setCellValue('B33', 'Pendapatan Lain');
		$sheet->setCellValue('B34', 'Pengembalian Pinjaman Pokok');
		$sheet->setCellValue('B35', 'JUMLAH DANA TERSEDIA ');
		$sheet->setCellValue('C29', 'Jul 2022');
		

		// $row = 6;
        // foreach ($neraca as $val){
		// 	if($row == 11 || $row == 15 || $row == 25 || $row == 28){
		// 		$row += 1;
		// 	}
		// 	if($row == 20){
		// 		$row += 3;
		// 	}
		// 	$sheet->setCellValue('C' . $row, $val['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]);
		// 	$sheet->setCellValue('D' . $row, $val[$perioda]);
		// 	$row++;			
		// }

		// die;
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
