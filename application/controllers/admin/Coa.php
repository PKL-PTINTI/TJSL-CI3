<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
defined('BASEPATH') OR exit('No direct script access allowed');

class COA extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('CoaModel', 'coa_model');

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

			$this->data['link_active'] = 'Admin/coa';

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
		$this->data['title'] = 'Data COA';
		$this->data['header'] = 'Management Data COA';
		$this->data['coa'] = $this->coa_model->getCoa();
		
		$this->template->load('coa/index', $this->data);
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
