<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ArusKas extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('ArusKasModel', 'aruskas_model');

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

			$this->data['link_active'] = 'admin/laporan/aruskas';

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
		$this->data['title'] = 'Laporan Arus Kas';
        $this->data['header'] = 'Management Laporan Arus Kas';
        $this->data['aruskas'] = $this->aruskas_model->getArusKas();		

		$this->data['bulan'] =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$this->data['perioda'] = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));	

		$this->template->load('arus_kas/index', $this->data);
    }

	public function createExcel() {
		$fileName = 'aruskas-keuangan-' . date('Y') .'.xlsx';  

		$aruskas = $this->aruskas_model->getArusKas();
		$spreadsheet = new Spreadsheet();
		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m"), date("d"), date("Y"))));

        $sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(42);
		$sheet->getColumnDimension('B')->setWidth(25);
		$sheet->getColumnDimension('C')->setWidth(25);
		$sheet->getColumnDimension('D')->setWidth(25);
		$sheet->getColumnDimension('E')->setWidth(25);

		$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'be123c')
			)
		);

		$sheet->getStyle('A4')->applyFromArray($styleArray);
		$sheet->getStyle('A5')->applyFromArray($styleArray);
		$sheet->getStyle('A11')->applyFromArray($styleArray);
		$sheet->getStyle('A21')->applyFromArray($styleArray);
		$sheet->getStyle('A22')->applyFromArray($styleArray);

		$sheet->mergeCells('A2:E2');
		$sheet->getStyle('A2:E2')->getFont()->setBold(true);
		$sheet->getStyle('A3:E3')->getFont()->setBold(true);
		$sheet->getStyle('A2:E2')->getAlignment()->setHorizontal('center');

		$sheet->setCellValue('A2', 'LAPORAN ARUS KAS');

       	$sheet->setCellValue('A3', 'KETERANGAN');
        $sheet->setCellValue('B3', 'DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))));
        $sheet->setCellValue('C3', 'SD DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))));
        $sheet->setCellValue('D3', $bulan);
        $sheet->setCellValue('E3', 'SD ' . $bulan);

		$sheet->setCellValue('A4', 'I. AKTIVITAS OPERASI');
		$sheet->setCellValue('A5', 'KAS DITERIMA DARI ');
		$sheet->setCellValue('A6', '1. Pengembalian Pinjaman Mitra Binaan');
		$sheet->setCellValue('A7', '2. Angsuran Belum Teridentifikasi');
		$sheet->setCellValue('A8', '3. Pendapatan Jasa Administrasi Pinjaman');
		$sheet->setCellValue('A9', '4. Pendapatan Jasa Giro/Bunga Deposito');
		$sheet->setCellValue('A10', '5. Pendapatan lain-lain');
		$sheet->setCellValue('A11', 'KAS DIKELUARKAN UNTUK ');
		$sheet->setCellValue('A12', '1. Penyaluran Pinjaman Kemitraan');
		$sheet->setCellValue('A13', '2. Dana Pembinaan Kemitraan');
		$sheet->setCellValue('A14', '3. Dana Bina Lingkungan');
		$sheet->setCellValue('A15', '4. Beban Pembinaan');
		$sheet->setCellValue('A16', '5. Beban Upah Tenaga Harian');
		$sheet->setCellValue('A17', '6. Beban Administrasi dan Umum');
		$sheet->setCellValue('A18', '7. Pembayaran Beban Pemeliharaan');
		$sheet->setCellValue('A19', '8. Pembayaran Kelebihan Angsuran');
		$sheet->setCellValue('A20', 'KAS NETTO DITERIMA(DIGUNAKAN) UNTUK AKTIVITAS OPERASI');
		$sheet->setCellValue('A21', 'II. AKTIVITAS INVESTASI ');
		$sheet->setCellValue('A22', 'KAS DIKELUARKAN UNTUK ');
		$sheet->setCellValue('A23', '1. Pembelian Aktiva Tetap');
		$sheet->setCellValue('A24', 'KAS NETTO DITERIMA (DIGUNAKAN) UNTUK AKTIVITAS INVESTASI');
		$sheet->setCellValue('A25', 'KENAIKAN (PENURUNAN) NETTO DALAM KAS/SETARA KAS');
		$sheet->setCellValue('A26', 'KAS DAN SETARA KAS PADA AWAL TAHUN');
		$sheet->setCellValue('A27', 'KAS DAN SETARA KAS PADA AKHIR TAHUN');

		$row = 6;
        foreach ($aruskas as $val){
			$row = ($row == 11) ? $row += 1 : $row;
			$row = ($row == 21) ? $row += 2 : $row;
			$sheet->setCellValue('B' . $row, number_format($val['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]));
			$sheet->setCellValue('C' . $row, number_format($val['sddes' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]));
			$sheet->setCellValue('D' . $row, number_format($val[$perioda]));
			$sheet->setCellValue('E' . $row, number_format($val['sd' . $perioda]));
			$row++;
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save("storage/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/storage/".$fileName);         
    }

	public function cetak(){
		$data = [
			'aruskas' => $this->aruskas_model->getArusKas(),
		];

		$data['perioda'] = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

		$this->load->view('arus_kas/cetak', $data);
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