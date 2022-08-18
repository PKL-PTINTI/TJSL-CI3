<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Aktivitas extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('AktivitasModel', 'aktivitas_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Laporan Aktivitas',
            'header' => 'Management Laporan Aktivitas',
            'aktivitas' => $this->aktivitas_model->getAktivitas(),
		];

		if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
			$data['bulan'] =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		}

		if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
			$data['perioda'] = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		}	

		$this->template->load('aktivitas/index', $data);
    }

	public function createExcel() {
		$fileName = 'laporan-aktivitas' . date('Y') .'.xlsx';
		$aktivitas = $this->aktivitas_model->getAktivitas();
		$spreadsheet = new Spreadsheet();
		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m"), date("d"), date("Y"))));

        $sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(50);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setWidth(20);
		$sheet->getColumnDimension('D')->setWidth(20);
		$sheet->getColumnDimension('E')->setWidth(20);

       	$sheet->setCellValue('A3', 'URAIAN');
        $sheet->setCellValue('B3', 'DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))));
        $sheet->setCellValue('C3', 'SD DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))));
        $sheet->setCellValue('D3', $bulan);
        $sheet->setCellValue('E3', 'SD ' . $bulan);

		$sheet->setCellValue('A4', 'PERUBAHAN ASET NETO TIDAK TERIKAT');
		$sheet->setCellValue('A5', 'PENDAPATAN');
		$sheet->setCellValue('A6', '1. Jasa Administrasi Pinjaman');
		$sheet->setCellValue('A7', '2. Pendapatan Bunga');
		$sheet->setCellValue('A8', '3. Pendapatan Lain-lain');
		$sheet->setCellValue('A9', 'JUMLAH 1');
		$sheet->setCellValue('A10', 'ALOKASI BUMN PEDULI DAN ASET NETO YANG BERAKHIR ');
		$sheet->setCellValue('A11', '1. Alokasi Dana BUMN Peduli');
		$sheet->setCellValue('A12', '2. ANTT Berakhir Pemenuhan Program');
		$sheet->setCellValue('A13', '3. ANTT Berakhir Waktu');
		$sheet->setCellValue('A14', 'JUMLAH 2');
		$sheet->setCellValue('A15', 'JUMLAH PENDAPATAN');
		$sheet->setCellValue('A16', 'BEBAN');
		$sheet->setCellValue('A17', '1. Dana Pembinaan Kemitraan');
		$sheet->setCellValue('A18', '2. Dana Bina Lingkungan');
		$sheet->setCellValue('A19', '3. Beban Administrasi dan Umum');
		$sheet->setCellValue('A20', '4. Beban Penyusutan Aktiva Tetap');
		$sheet->setCellValue('A21', '5. Beban Pemeliharaan');
		$sheet->setCellValue('A22', '6. Beban Penyisihan Piutang');
		$sheet->setCellValue('A23', '7. Beban dan Pengeluaran lainnya');
		$sheet->setCellValue('A24', 'JUMLAH BEBAN');
		$sheet->setCellValue('A25', 'KENAIKAN(PENURUNAN) ASET NETO TIDAK TERIKAT');
		$sheet->setCellValue('A26', 'PERUBAHAN ASET NETO TERIKAT TEMPORER ');
		$sheet->setCellValue('A27', '1. ANTT Terbebaskan');
		$sheet->setCellValue('A28', '2. ANTT Penyisihan BUMN Peduli');
		$sheet->setCellValue('A29', 'KENAIKAN(PENURUNAN) ASET NETO TERIKAT TEMPORER');
		$sheet->setCellValue('A30', 'PERUBAHAN ASET NETO TERIKAT PERMANEN');
		$sheet->setCellValue('A31', '1. Sumbangan Terikat');
		$sheet->setCellValue('A32', 'KENAIKAN(PENURUNAN) ASET NETO TERIKAT PERMANEN');
		$sheet->setCellValue('A33', 'KENAIKAN/(PENURUNAN) ASET NETO');
		$sheet->setCellValue('A34', 'ASET NETO AWAL TAHUN');
		$sheet->setCellValue('A35', 'ASET NETO AKHIR TAHUN');

		$row = 6;
        foreach ($aktivitas as $val){
			$row = ($row == 10) ? $row += 1 : $row;
			$row = ($row == 16) ? $row += 1 : $row;
			$row = ($row == 26) ? $row += 1 : $row;
			$row = ($row == 30) ? $row += 1 : $row;
			$sheet->setCellValue('B' . $row, $val['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]);
			$sheet->setCellValue('C' . $row, $val['sddes' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]);
			$sheet->setCellValue('D' . $row, $val[$perioda]);
			$sheet->setCellValue('E' . $row, $val['sd' . $perioda]);
			$row++;
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