<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Catatan extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('CatatanModel', 'catatan_model');

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

			$this->data['link_active'] = 'Admin/Laporan/catatan';

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
		$this->data['title'] = 'Catatan Atas Laporan Keuangan';
		$this->data['header'] = 'Management Catatan Atas Laporan Keuangan';
		$this->data['bulan'] =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		empty($this->input->get('periode')) ? $this->data['perioda'] = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))) : $this->data['perioda'] = $this->input->get('periode');
		$this->data['catatan'] = $this->catatan_model->getData();

		$this->template->load('catatan/index', $this->data);
    }

	public function createExcel() {
		$fileName = 'catatan-atas-laporan-keuangan-' . date('Y') .'.xlsx';  

		$catatan = $this->catatan_model->getData();
		$spreadsheet = new Spreadsheet();
		empty($this->input->get('periode')) ? $perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))) : $perioda = $this->input->get('periode');
		$bulan =  month_name(periode_to_month($perioda)) . ' ' . date('Y');

		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(50);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setWidth(20);

		$sheet->mergeCells('A2:C2');
		$sheet->getStyle('A2:C2')->getFont()->setBold(true);
		$sheet->getStyle('A2:C2')->getAlignment()->setHorizontal('center');

		$sheet->setCellValue('A2', 'CATATAN ATAS LAPORAN KEUANGAN');

       	$sheet->setCellValue('A3', 'URAIAN');
        $sheet->setCellValue('B3', 'DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))));
        $sheet->setCellValue('C3', 'BULAN ' . $bulan);

		$sheet->setCellValue('A4', 'KAS');
		$sheet->setCellValue('A5', '- Kas PK');
		$sheet->setCellValue('A6', 'BANK');
		$sheet->setCellValue('A7', '- Mandiri');
		$sheet->setCellValue('A8', '- BRI');
		$sheet->setCellValue('A9', 'KAS BANK YG DIBATASI PENGGUNAANNYA');
		$sheet->setCellValue('A10', '- Kas Bank yg Dibatasi Penggunaanya');
		$sheet->setCellValue('A11', 'PIUTANG MITRA BINAAN');
		$sheet->setCellValue('A12', '- Sektor Industri');
		$sheet->setCellValue('A13', '- Sektor Perdagangan');
		$sheet->setCellValue('A14', '- Sektor Pertanian');
		$sheet->setCellValue('A15', '- Sektor Perkebunan');
		$sheet->setCellValue('A16', '- Sektor Perikanan');
		$sheet->setCellValue('A17', '- Sektor Peternakan');
		$sheet->setCellValue('A18', '- Sektor Jasa');
		$sheet->setCellValue('A19', '- Sektor Lain-lain');
		$sheet->setCellValue('A20', 'ALOKASI PENYISIHAN PIUTANG MB');
		$sheet->setCellValue('A21', '- Sektor Industri');
		$sheet->setCellValue('A22', '- Sektor Perdagangan');
		$sheet->setCellValue('A23', '- Sektor Pertanian');
		$sheet->setCellValue('A24', '- Sektor Perkebunan');
		$sheet->setCellValue('A25', '- Sektor Perikanan');
		$sheet->setCellValue('A26', '- Sektor Peternakan');
		$sheet->setCellValue('A27', '- Sektor Jasa');
		$sheet->setCellValue('A28', '- Sektor Lain-lain');
		$sheet->setCellValue('A29', 'PIUTANG JASA ADMINISTRASI PINJAMAN');
		$sheet->setCellValue('A30', '- Piutang Jasa Administrasi Pinjaman');
		$sheet->setCellValue('A31', 'HARGA PEROLEHAN ASET TETAP');
		$sheet->setCellValue('A32', '- Inventaris Kantor');
		$sheet->setCellValue('A33', 'AKUMULASI PENYUSUTAN ASET TETAP ');
		$sheet->setCellValue('A34', '- Inventaris Kantor');
		$sheet->setCellValue('A35', 'PIUTANG BERMASALAH');
		$sheet->setCellValue('A36', '- Sektor Industri');
		$sheet->setCellValue('A37', '- Sektor Perdagangan');
		$sheet->setCellValue('A38', '- Sektor Pertanian');
		$sheet->setCellValue('A39', '- Sektor Perkebunan');
		$sheet->setCellValue('A40', '- Sektor Perikanan');
		$sheet->setCellValue('A41', '- Sektor Peternakan');
		$sheet->setCellValue('A42', '- Sektor Jasa');
		$sheet->setCellValue('A43', '- Sektor Lain-lain');
		$sheet->setCellValue('A44', 'ALOKASI PIUTANG BERMASALAH');
		$sheet->setCellValue('A45', '- Sektor Industri');
		$sheet->setCellValue('A46', '- Sektor Perdagangan');
		$sheet->setCellValue('A47', '- Sektor Pertanian');
		$sheet->setCellValue('A48', '- Sektor Perkebunan');
		$sheet->setCellValue('A49', '- Sektor Perikanan');
		$sheet->setCellValue('A50', '- Sektor Peternakan');
		$sheet->setCellValue('A51', '- Sektor Jasa');
		$sheet->setCellValue('A52', '- Sektor Lain-lain');
		$sheet->setCellValue('A53', 'PROGRAM KEMITRAAN');
		$sheet->setCellValue('A54', '- Kelebihan Pembayaran Angsuran');
		$sheet->setCellValue('A55', '- Angsuran Belum Teridentifikasi');
		$sheet->setCellValue('A56', 'AKTIVA BERSIH AWAL PERIODA');
		$sheet->setCellValue('A57', '- Aktiva Bersih Awal Perioda');
		$sheet->setCellValue('A58', 'PENDAPATAN');
		$sheet->setCellValue('A59', '- Jasa Administrasi Pinjaman');
		$sheet->setCellValue('A60', '- Jasa Giro PK');
		$sheet->setCellValue('A61', '- Pendapatan Lain-lain, Piutang Hapus Buku');
		$sheet->setCellValue('A62', '- Pendapatan Lain-lain, Penyesuaian Alokasi Penyisihan');
		$sheet->setCellValue('A63', 'Pendapatan Lain-lain, Lain-lain');
		$sheet->setCellValue('A64', 'BEBAN UMUM');
		$sheet->setCellValue('A65', '- Beban Adm dan Umum');
		$sheet->setCellValue('A66', '- Beban Adm dan Umum BL');
		$sheet->setCellValue('A67', 'BEBAN PENYISIHAN PIUTANG');
		$sheet->setCellValue('A68', '- Sektor Industri');
		$sheet->setCellValue('A69', '- Sektor Perdagangan');
		$sheet->setCellValue('A70', '- Sektor Pertanian');
		$sheet->setCellValue('A71', '- Sektor Perkebunan');
		$sheet->setCellValue('A72', '- Sektor Perikanan');
		$sheet->setCellValue('A73', '- Sektor Peternakan');
		$sheet->setCellValue('A74', '- Sektor Jasa');
		$sheet->setCellValue('A75', '- Sektor Lain-lain');
		$sheet->setCellValue('A76', 'BEBAN LAIN-LAIN');
		$sheet->setCellValue('A77', '- Lain-lain');

		$row = 4;
        foreach ($catatan as $val){
			$row = ($row == 1) ? $row += 1 : $row;
			$row = ($row == 2) ? $row += 1 : $row;
			$sheet->setCellValue('B' . $row, number_format($val['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]));
			$sheet->setCellValue('C' . $row, number_format($val[$perioda]));
			$row++;
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save("storage/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/storage/".$fileName);         
    }

	public function cetak(){
		$data = [
			'catatan' => $this->catatan_model->getData(),
			'perioda' => empty($this->input->get('periode')) ? $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))) : $this->input->get('periode')
		];

		$this->load->view('catatan/cetak', $data);
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