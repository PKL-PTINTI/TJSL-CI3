<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
defined('BASEPATH') OR exit('No direct script access allowed');

class Kinerja extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('KinerjaModel', 'kinerja_model');

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

			$this->data['link_active'] = 'Admin/laporan/kinerja';

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
		$this->data['title'] = 'Data Laporan Kinerja';
		$this->data['header'] = 'Management Data Laporan Kinerja';

        if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
			$this->data['bulan'] =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
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

		$this->data['dataRow'] = $dataRow;
		$this->data['timbang'] = $timbang;
		$this->data['totsaldo'] = $totsaldo;
		$this->data['kolex'] = $kolex;
		$this->data['skor'] = $skor;

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

		$this->data['dana'] = $dana;

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

		$this->data['danatersedia'] = $danatersediaRow;
		$this->data['JumlahDanaYgDisalurkan'] = $JumlahDanaYgDisalurkan;
		$this->data['jumlahDanaTersedia'] = $jumlahDanaTersedia;
		$this->data['prosenDanaDisalurkan'] = $prosenDanaDisalurkan;

		$this->template->load('kinerja/index', $this->data);
    }

	public function createExcel() {
		$fileName = 'laporan-kinerja-' . date('Y') .'.xlsx';  

		$tingkatPengembalianHasil = $this->kinerja_model->getData();
		$danaYangDisalurkan = $this->kinerja_model->getDanaYangDisalurkan();
		$danatersedia = $this->kinerja_model->getDanaTersedia();

		$spreadsheet = new Spreadsheet();
		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$perioda = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

        $sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(28);
		$sheet->getColumnDimension('C')->setWidth(25);
		$sheet->getColumnDimension('D')->setWidth(25);
		$sheet->getColumnDimension('E')->setWidth(25);

		$sheet->mergeCells('A2:E2');
		$sheet->getStyle('A2:E2')->getFont()->setBold(true);
		$sheet->getStyle('A2:E2')->getAlignment()->setHorizontal('center');

		$sheet->setCellValue('A2', 'LAPORAN KINERJA');

		$sheet->setCellValue('A3', '1. TINGKAT PENGEMBALIAN PINJAMAN MITRA BINAAN');
		$sheet->setCellValue('A4', 'Skor : 100-70=>3, 70-40=>2, 40-10=>1, 10-0=>0');
		$sheet->setCellValue('A6', 'No');
		$sheet->setCellValue('A7', '1');
		$sheet->setCellValue('A8', '2');
		$sheet->setCellValue('A9', '3');
		$sheet->setCellValue('A10', '4');
		$sheet->setCellValue('A11', '5');
		$sheet->setCellValue('B6', 'Kolektibilitas');
		$sheet->setCellValue('B7', 'Lancar');
		$sheet->setCellValue('B8', 'Kurang Lancar');
		$sheet->setCellValue('B9', 'Diragukan');
		$sheet->setCellValue('B10', 'Macet');
		$sheet->setCellValue('B11', 'TOTAL');
		$sheet->setCellValue('C6', $bulan);
		$sheet->setCellValue('D6', 'Prosen (%)');
		$sheet->setCellValue('E6', 'Timbang (Rp)');
		$sheet->setCellValue('A16', '2. EFFEKTIVITAS PENYALURAN DANA');
		$sheet->setCellValue('A17', '2.1 DANA YANG DISALURKAN ');
		$sheet->setCellValue('A19', 'No');
		$sheet->setCellValue('A20', '1');
		$sheet->setCellValue('A21', '2');
		$sheet->setCellValue('A22', '3');
		$sheet->setCellValue('B19', 'Keterangan');
		$sheet->setCellValue('B20', 'Penyaluran Pinjaman');
		$sheet->setCellValue('B21', 'Dana Pembinaan Kemitraan');
		$sheet->setCellValue('B22', 'JUMLAH DANA YG DISALURKAN');
		$sheet->setCellValue('C19', date('M Y', mktime(0, 0, 0, date("m"), date("d"), date("Y"))));
		$sheet->setCellValue('A24', 'Skor : 100-90 => 3 , 90-85 => 2, 85-80 => 1 ');
		$sheet->setCellValue('A26', 'No');
		$sheet->setCellValue('A27', '1');
		$sheet->setCellValue('A28', '2');
		$sheet->setCellValue('A29', '3');
		$sheet->setCellValue('A30', '4');
		$sheet->setCellValue('A31', '5');
		$sheet->setCellValue('A32', '6');
		$sheet->setCellValue('B26', 'Keterangan');
		$sheet->setCellValue('B27', 'Saldo Awal');
		$sheet->setCellValue('B28', 'Jasa Administrasi Pinjaman');
		$sheet->setCellValue('B29', 'Jasa Giro');
		$sheet->setCellValue('B30', 'Pendapatan Lain');
		$sheet->setCellValue('B31', 'Pengembalian Pinjaman Pokok');
		$sheet->setCellValue('B32', 'JUMLAH DANA TERSEDIA ');
		$sheet->setCellValue('C26', 'Jul 2022');
		
		$sheet->setCellValue('C7', number_format($tingkatPengembalianHasil[0][$perioda]));
		$sheet->setCellValue('D7', number_format($tingkatPengembalianHasil[0]['prosen']));
		$sheet->setCellValue('E7', number_format($tingkatPengembalianHasil[0]['timbang' . $perioda]));

		$sheet->setCellValue('C8', number_format($tingkatPengembalianHasil[1][$perioda]));
		$sheet->setCellValue('D8', number_format($tingkatPengembalianHasil[1]['prosen']));
		$sheet->setCellValue('E8', number_format($tingkatPengembalianHasil[1]['timbang' . $perioda]));

		$sheet->setCellValue('C9', number_format($tingkatPengembalianHasil[2][$perioda]));
		$sheet->setCellValue('D9', number_format($tingkatPengembalianHasil[2]['prosen']));
		$sheet->setCellValue('E9', number_format($tingkatPengembalianHasil[2]['timbang' . $perioda]));

		$sheet->setCellValue('C10', number_format($tingkatPengembalianHasil[3][$perioda]));
		$sheet->setCellValue('D10', number_format($tingkatPengembalianHasil[3]['prosen']));
		$sheet->setCellValue('E10', number_format($tingkatPengembalianHasil[3]['timbang' . $perioda]));

		$sheet->setCellValue('C11', number_format($tingkatPengembalianHasil[4][$perioda]));
		$sheet->setCellValue('D11', number_format($tingkatPengembalianHasil[4]['prosen']));
		$sheet->setCellValue('E11', number_format($tingkatPengembalianHasil[4]['timbang' . $perioda]));

		$sheet->setCellValue('A13', 'Kolektibilitas = ' . number_format($tingkatPengembalianHasil[4][$perioda]) . ' / ' . 
							$tingkatPengembalianHasil[4]['timbang' . $perioda] . ' = ' . $tingkatPengembalianHasil[5][$perioda] . ' %');
		$sheet->setCellValue('A14', 'SKOR -> ' . $tingkatPengembalianHasil[6][$perioda]);
		$totPinjPokok = 0;
		$date = date('y')-1;

		$sheet->setCellValue('C20', number_format($danaYangDisalurkan[0][$perioda]));
		$sheet->setCellValue('C21', number_format($danaYangDisalurkan[1][$perioda]));
		$sheet->setCellValue('C22', number_format($danaYangDisalurkan[2][$perioda]));

		$sheet->setCellValue('C27', number_format($danatersedia[0][$perioda]));
		$sheet->setCellValue('C28', number_format($danatersedia[1][$perioda]));
		$sheet->setCellValue('C29', number_format($danatersedia[2][$perioda]));
		$sheet->setCellValue('C30', number_format($danatersedia[3][$perioda]));
		$sheet->setCellValue('C31', number_format($danatersedia[4][$perioda]));
		$sheet->setCellValue('C32', number_format($danatersedia[5][$perioda]));

		$sheet->setCellValue('A34', 'Jumlah Dana Yg Disalurkan/Jumlah Dana Tersedia= ' . $danatersedia[5][$perioda] . ' / ' . 
							$danatersedia[5]['des' . $date] . ' = ' . $danatersedia[6][$perioda] . ' %');
		$sheet->setCellValue('A35', 'SKOR -> ' . $danatersedia[7][$perioda]);
		$JumlahDanaYgDisalurkan = 0;
		$date = date('y')-1;

		$writer = new Xlsx($spreadsheet);
		$writer->save("storage/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/storage/".$fileName);         
    }

	public function cetak(){
		$data = [
			'tingkatPengembalianHasil' => $this->kinerja_model->getData(),
			'danaYangDisalurkan' => $this->kinerja_model->getDanaYangDisalurkan(),
			'danatersedia' => $this->kinerja_model->getDanaTersedia(),
		];

		$data['perioda'] = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));

		$this->load->view('kinerja/cetak', $data);
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
