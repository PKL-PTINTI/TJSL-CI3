<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
defined('BASEPATH') OR exit('No direct script access allowed');

class Coa extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('CoaModel', 'coa_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Data COA',
            'header' => 'Management Data COA',
			'coa' => $this->coa_model->getCoa(),
		];
		
		$this->template->load('Coa/index', $data);
    }

	public function createExcel() {
		$fileName = 'data-coa.xlsx';

		$coa = $this->coa_model->getCoa();
		$spreadsheet = new Spreadsheet();

		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(15);
		$sheet->getColumnDimension('C')->setWidth(80);

		$sheet->mergeCells('A2:C2');
		$sheet->getStyle('A2:C2')->getFont()->setBold(true);
		$sheet->getStyle('A2:C2')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('C3')->getAlignment()->setHorizontal('center');

		$sheet->setCellValue('A2', 'Data COA');

		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Kode Rekening');
		$sheet->setCellValue('C3', 'Deskripsi Akun');
		
		foreach($coa as $key => $value) {
			$sheet->setCellValue('A'.($key+4), $key+1);
			$sheet->setCellValue('B'.($key+4), $value->korek);
			$sheet->setCellValue('C'.($key+4), $value->deskripsiAkun);
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save("storage/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/storage/".$fileName);
	}

}
