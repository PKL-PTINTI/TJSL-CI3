<?php

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
	defined('BASEPATH') OR exit('No direct script access allowed');

class NeracaSaldo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('NeracaSaldoModel', 'neracasaldo_model');
	}

	public function index()
	{
		$data = [
			'title' => 'Data Neraca Saldo',
            'header' => 'Management Data Neraca Saldo',
			'neracasaldo' => $this->neracasaldo_model->getNeracaSaldo(),
		];

        if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
			$data['bulan'] =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		}

		if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
			$data['perioda'] = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		}
		
		$this->template->load('neraca_saldo/index', $data);
    }

    public function createExcel() {
		$fileName = 'neraca-saldo-' . date('Y') .'.xlsx';  

		$neracasaldo = $this->neracasaldo_model->getNeracaSaldo();
		$spreadsheet = new Spreadsheet();
		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

        $sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(15);
		$sheet->getColumnDimension('C')->setWidth(40);
		$sheet->getColumnDimension('D')->setWidth(15);
		$sheet->getColumnDimension('E')->setWidth(15);
		$sheet->getColumnDimension('F')->setWidth(15);
		$sheet->getColumnDimension('G')->setWidth(15);
		$sheet->getColumnDimension('H')->setWidth(10);

		$sheet->mergeCells('A2:H2');
		$sheet->getStyle('A2:H2')->getFont()->setBold(true);
		$sheet->getStyle('A2:H2')->getAlignment()->setHorizontal('center');

		$sheet->setCellValue('A2', 'DATA NERACA SALDO');

        $sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Kode Rekening');
       	$sheet->setCellValue('C3', 'URAIAN');
        $sheet->setCellValue('D3', 'DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))));
        $sheet->setCellValue('E3', 'Debet ' . $bulan);
        $sheet->setCellValue('F3', 'Kredit ' . $bulan);
        $sheet->setCellValue('G3', 'Saldo ' . $bulan);
		$sheet->setCellValue('H3', 'Selisih');

        $sheet->setCellValue('A4', 'Pendapatan Lain-lain, Penyesuaian ');
		$sheet->setCellValue('A5', 'ASET');
		$sheet->setCellValue('A6', 'ASET LANCAR');
		$sheet->setCellValue('A7', 'KAS & SETARA KAS');
		$sheet->setCellValue('A8', 'Kas PKP');
		$sheet->setCellValue('A9', 'Mandiri');
		$sheet->setCellValue('A10', 'Bank BL ');
		$sheet->setCellValue('A11', 'BRI');
		$sheet->setCellValue('A12', 'Kas Bank Yang Dibatasi Penggunaanya');
		$sheet->setCellValue('A13', 'Kas Bank Yang Dibatasi Penggunaanya');
		$sheet->setCellValue('A14', 'Piutang Mitra Binaan Bersih');
		$sheet->setCellValue('A15', 'Piutang Mitra Binaan');
		$sheet->setCellValue('A16', 'Sektor Industri');
		$sheet->setCellValue('A17', 'Sektor Perdagangan');
		$sheet->setCellValue('A18', 'Sektor Pertanian');
		$sheet->setCellValue('A19', 'Sektor Perkebunan');
		$sheet->setCellValue('A20', 'Sektor Perikanan');
		$sheet->setCellValue('A21', 'Sektor Peternakan');
		$sheet->setCellValue('A22', 'Sektor Jasa');
		$sheet->setCellValue('A23', 'Sektor Lain-lain');
		$sheet->setCellValue('A24', 'Alokasi Penyisihan Piutang Mitra Binaan');
		$sheet->setCellValue('A25', 'Sektor Industri');
		$sheet->setCellValue('A26', 'Sektor Perdagangan');
		$sheet->setCellValue('A27', 'Sektor Pertanian');
		$sheet->setCellValue('A28', 'Sektor Perkebunan');
		$sheet->setCellValue('A29', 'Sektor Perikanan');
		$sheet->setCellValue('A30', 'Sektor Peternakan');
		$sheet->setCellValue('A31', 'Sektor Jasa');
		$sheet->setCellValue('A32', 'Sektor Lain-lain');
		$sheet->setCellValue('A33', 'Piutang Jasa Administrasi Pinjaman');
		$sheet->setCellValue('A34', 'Piutang Jasa Administrasi Pinjaman');
		$sheet->setCellValue('A35', 'Harga Perolehan Aset Tetap');
		$sheet->setCellValue('A36', 'Inventaris Kantor');
		$sheet->setCellValue('A37', 'Akumulasi Penyusutan Aset Tetap');
		$sheet->setCellValue('A38', 'Inventaris Kantor');
		$sheet->setCellValue('A39', 'Liabilitas Dan Aset Neto');
		$sheet->setCellValue('A40', 'Liabilitas');
		$sheet->setCellValue('A41', 'Liabilitas Jangka Pendek');
		$sheet->setCellValue('A42', '1. Kelebihan Pembayaran Angsuran');
		$sheet->setCellValue('A43', '2. Angsuran Belum Teridentifikasi');
		$sheet->setCellValue('A44', 'Aset Netto');
		$sheet->setCellValue('A45', 'Aktiva Bersih Awal Periode');
		$sheet->setCellValue('A46', 'Pendapatan');
    	$sheet->setCellValue('A47', 'Jasa Administrasi Pinjaman');
		$sheet->setCellValue('A48', 'Jasa Giro PK');
		$sheet->setCellValue('A49', 'Pendapatan Lain-lain, Piutang Hapus Buku');
		$sheet->setCellValue('A50', 'Pendapatan Lain-lain, Penyesuaian Alokasi Penyisihan');
		$sheet->setCellValue('A51', 'Pendapatan Lain-lain, Lain-lain');
		$sheet->setCellValue('A52', 'Beban Umum');
		$sheet->setCellValue('A53', 'Beban Adm dan Umum');
		$sheet->setCellValue('A54', 'Beban Penyisihan Utang');
		$sheet->setCellValue('A55', 'Sektor Industri');
		$sheet->setCellValue('A56', 'Sektor Perdagangan');
		$sheet->setCellValue('A57', 'Sektor Pertanian');
		$sheet->setCellValue('A58', 'Sektor Perkebunan');
		$sheet->setCellValue('A59', 'Sektor Perikanan');
		$sheet->setCellValue('A60', 'Sektor Peternakan');
		$sheet->setCellValue('A61', 'Sektor Jasa');
		$sheet->setCellValue('A62', 'Sektor Lain-lain');
		$sheet->setCellValue('A63', 'Beban Lain-lain');
		$sheet->setCellValue('A64', 'Lain-lain');


		$row = 4;
        foreach ($neracasaldo as $val){
			$sheet->setCellValue('A' . $row, ($val['id']));
			$sheet->setCellValue('B' . $row, ($val['id_akun']));
			$sheet->setCellValue('C' . $row, ($val['nama_akun']));
			$sheet->setCellValue('D' . $row, number_format($val['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]));
			$sheet->setCellValue('E' . $row, number_format($val['debet' . $perioda]));
            $sheet->setCellValue('F' . $row, number_format($val['kredit' . $perioda]));
            $sheet->setCellValue('G' . $row, number_format($val['saldo' . $perioda]));
			$sheet->setCellValue('H' . $row, ($val['selisih']));
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