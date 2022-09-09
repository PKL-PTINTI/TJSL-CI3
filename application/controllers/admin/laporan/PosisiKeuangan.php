<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PosisiKeuangan extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('PosisiKeuanganModel', 'posisikeuangan_model');

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

			$this->data['link_active'] = 'Dashboard';

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
		$this->data['title'] = 'Data Laporan Posisi Keuangan';
		$this->data['header'] = 'Management Data Laporan Posisi Keuangan';

		$this->data['bulan'] =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));

		$this->data['perioda'] = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

		$this->data['neraca'] = $this->posisikeuangan_model->getData();
		
		$this->template->load('posisi_keuangan/index', $this->data);
	}

	public function createExcel() {
		$fileName = 'laporan-posisi-keuangan-' . date('Y') .'.xlsx';  

		$neraca = $this->posisikeuangan_model->getData();
		$spreadsheet = new Spreadsheet();
		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

        $sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(25);
		$sheet->getColumnDimension('B')->setWidth(40);
		$sheet->getColumnDimension('C')->setWidth(25);
		$sheet->getColumnDimension('D')->setWidth(25);

		$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '15803d')
			)
		);

		$sheet->getStyle('B')->applyFromArray($styleArray);
		$sheet->getStyle('A4')->applyFromArray($styleArray);

		$sheet->mergeCells('A3:B3');
		$sheet->mergeCells('A2:D2');
		$sheet->getStyle('A3:B3')->getFont()->setBold(true);
		$sheet->getStyle('A3:B3')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A2:D2')->getAlignment()->setHorizontal('center');

		$sheet->setCellValue('A2', 'LAPORAN POSISI KEUANGAN');

       	$sheet->setCellValue('A3', 'U R A I A N');
        $sheet->setCellValue('C3', 'DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))));
        $sheet->setCellValue('D3', $bulan);

		$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'be123c')
			)
		);

		$sheet->getStyle('A20')->applyFromArray($styleArray);

		$sheet->setCellValue('A4', 'ASET');
		$sheet->setCellValue('A5', 'ASET LANCAR');
		$sheet->setCellValue('B6', '1. Kas');
		$sheet->setCellValue('B7', '1. Bank');
		$sheet->setCellValue('B8', 'Piutang Pinjaman Mitra Binaan');
		$sheet->setCellValue('B9', 'Alokasi Penyisihan Piutang Pinjaman Mitra Binaan');
		$sheet->setCellValue('B10', 'JUMLAH ASET LANCAR');
		$sheet->setCellValue('A11', 'Aset Tetap Bersih');
		$sheet->setCellValue('B12', 'Inventaris dan Peralatan');
		$sheet->setCellValue('B13', 'Akumulasi Penyusutan Inventaris dan Peralatan');
		$sheet->setCellValue('B14', 'JUMLAH ASET TETAP BERSIH');
		$sheet->setCellValue('A15', 'Aset Lain-lain');
		$sheet->setCellValue('B16', 'Piutang Bermasalah');
		$sheet->setCellValue('B17', 'Alokasi Penyisihan Piutang Bermasalah');
		$sheet->setCellValue('B18', 'JUMLAH ASET LALI-LAIN');
		$sheet->setCellValue('B19', 'JUMLAH ASET');
		$sheet->setCellValue('A20', 'LIABILITAS DAN ASET NETO');
		$sheet->setCellValue('A21', 'LIABILITAS');
		$sheet->setCellValue('A22', 'Liabilitas Jangka Pendek');
		$sheet->setCellValue('B23', 'Kelebihan Pembayaran Angsuran');
		$sheet->setCellValue('B24', 'Angsuran Belum Teridentifikasi');
		$sheet->setCellValue('A25', 'Liabilitas Jangka Panjang');
		$sheet->setCellValue('B26', 'Kewajiban Jangka Panjang');
		$sheet->setCellValue('B27', 'JUMLAH LIABILITAS');
		$sheet->setCellValue('A28', 'ASET NETO');
		$sheet->setCellValue('B29', 'Aset Neto Terikat');
		$sheet->setCellValue('B30', 'Aset Neto Tidak Terikat');
		$sheet->setCellValue('B31', 'JUMLAH ASET NETO');
		$sheet->setCellValue('B32', 'JUMLAH LIABILITAS DAN ASET NETO');

		$row = 6;
        foreach ($neraca as $val){
			if($row == 11 || $row == 15 || $row == 25 || $row == 28){
				$row += 1;
			}
			if($row == 20){
				$row += 3;
			}
			$sheet->setCellValue('C' . $row, number_format($val['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]));
			$sheet->setCellValue('D' . $row, number_format($val[$perioda]));
			$row++;			
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save("storage/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/storage/".$fileName);         
    }

	public function cetak(){
		$neraca = $this->posisikeuangan_model->getData();

		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

		$data = array(
			'neraca' => $neraca,
			'bulan' => $bulan,
			'perioda' => $perioda
		);

		$this->load->view('posisi_keuangan/cetak', $data);
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
