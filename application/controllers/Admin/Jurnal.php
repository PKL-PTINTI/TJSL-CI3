<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Jurnal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('JurnalModel', 'jurnal_model');

		if(!$this->session->userdata('username')){
			redirect(base_url('auth'));
		}
	}

	public function index()
	{
		$data = [
			'title' => 'Management Data Jurnal',
			'header' => 'Data Jurnal',
		];

		$this->template->load('jurnal/index', $data);
	}

	public function get_jurnal(){
		$list = $this->jurnal_model->get_datatables();
		if(date('Y-m-01', strtotime(date('Y-m-d H:i:s', time()))) >= date('Y') . '-01-01' AND date('Y-m-01', strtotime(date( 'Y-m-d H:i:s', time () ))) < mktime(0, 0, 0, '01',   '01',   date("Y")+1)){
			$tahun = date('Y') . '-01-01';
		}
		$jurnal = $this->db->query("SELECT SUM(pemasukan) AS pemasukan, 
									SUM(pengeluaran) AS pengeluaran 
									FROM opex WHERE tanggal >= '$tahun' 
									AND tanggal <= '".date('Y-m-d H:i:s', time())."' 
									AND tampil = '0'")->result(); 
        $data = array();
        $no = $this->input->post('start');
		$total_pemasukan = $jurnal['0']->pemasukan;
		$total_pengeluaran = $jurnal['0']->pengeluaran;

		$tot_pengeluaran = 0;
		$tot_pemasukan = 0;

        foreach ($list as $data_jurnal) {
            $no++;
			$saldo = number_format($data_jurnal->pemasukan - $data_jurnal->pengeluaran, 2);
			$tot_pengeluaran += $data_jurnal->pengeluaran;
			$tot_pemasukan += $data_jurnal->pemasukan;

            $row = array();
			$row[] = $no;
            $row[] = $data_jurnal->id_opex;
            $row[] = $data_jurnal->id_akun;
            $row[] = $data_jurnal->tanggal;
			$row[] = number_format($data_jurnal->pemasukan);
			$row[] = number_format($data_jurnal->pengeluaran);
			$row[] = ($saldo < 0) ? number_format(0, 2) : $saldo;
			$row[] = ($tot_pengeluaran == $tot_pemasukan) ? '<div class="badge badge-success">MATCH</div>' : null;
			$row[] = $data_jurnal->deskripsi;
			$row[] = $data_jurnal->keterangan;
			$row[] = $data_jurnal->nobukti;
			$row[] = number_format($data_jurnal->tot_pemasukan);
			$row[] = number_format($data_jurnal->tot_pengeluaran);
			$row[] = $data_jurnal->tampil;
			$row[] = $data_jurnal->updated;
			$row[] = $data_jurnal->tglUpdate;

			$row[] =  '
				<div class="dropdown">
					<a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false">
						<i class="fas fa-ellipsis-v"></i>
					</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item btndelete" id="button_delete" href="' . base_url('admin/jurnal/destroy/' . str_replace('/', '%', $data_jurnal->nobukti)) . '"><i
								class="fas fa-trash text-danger pr-2"></i> Delete </a>
					</div>
				</div>
			';
            $data[] = $row;
        }

		$hasil = [
			'Total',
			'',
			'',
			'',
			number_format($total_pemasukan),
			number_format($total_pengeluaran),
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
		];

		$data[] = $hasil;

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->jurnal_model->count_all(),
            "recordsFiltered" => $this->jurnal_model->count_filtered(),
            "data" => $data,
        );
		
        echo json_encode($output);
	}

	public function jurnalBank($bank)
	{
		$list = $this->jurnal_model->get_datatables_bank($bank);
        $data = array();
        $no = $this->input->post('start');

		if($bank == 'kas'){
			$id_akun = '101010101';
		} elseif ($bank == 'bri') {
			$id_akun = '101010204';
		} elseif ($bank == 'mandiri') {
			$id_akun = '101010201';
		} elseif ($bank == 'bank') {
			$id_akun = "101010201' AND '101010204";
		}

		if(date('Y-m-01', strtotime(date('Y-m-d H:i:s', time()))) >= date('Y') . '-01-01' AND date('Y-m-01', strtotime(date( 'Y-m-d H:i:s', time () ))) < mktime(0, 0, 0, '01',   '01',   date("Y")+1)){
			$tahun = date('Y') . '-01-01';
		}
		$jurnal = $this->db->query("SELECT SUM(pemasukan) AS pemasukan, 
									SUM(pengeluaran) AS pengeluaran 
									FROM opex WHERE id_akun = '$id_akun' AND tanggal >= '$tahun' 
									AND tanggal <= '".date('Y-m-d H:i:s', time())."' 
									AND tampil = '0'")->result();

		$total_pemasukan = $jurnal['0']->pemasukan;
		$total_pengeluaran = $jurnal['0']->pengeluaran;

		$tot_pengeluaran = 0;
		$tot_pemasukan = 0;
		
        foreach ($list as $data_jurnal) {
            $no++;
			$saldo = number_format($data_jurnal->pemasukan - $data_jurnal->pengeluaran, 2);
			$tot_pengeluaran += $data_jurnal->pengeluaran;
			$tot_pemasukan += $data_jurnal->pemasukan;
			
            $row = array();
			$row[] = $no;
            $row[] = $data_jurnal->id_opex;
            $row[] = $data_jurnal->id_akun;
            $row[] = $data_jurnal->tanggal;
			$row[] = $data_jurnal->pemasukan;
			$row[] = $data_jurnal->pengeluaran;
			$row[] = ($saldo < 0) ? number_format(0, 2) : $saldo;
			$row[] = ($tot_pengeluaran == $tot_pemasukan) ? "MATCH" : null;
			$row[] = $data_jurnal->deskripsi;
			$row[] = $data_jurnal->keterangan;
			$row[] = $data_jurnal->nobukti;
			$row[] = $data_jurnal->tot_pemasukan;
			$row[] = $data_jurnal->tot_pengeluaran;
			$row[] = $data_jurnal->tampil;
			$row[] = $data_jurnal->updated;
			$row[] = $data_jurnal->tglUpdate;

			$row[] =  '
				<div class="dropdown">
					<a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false">
						<i class="fas fa-ellipsis-v"></i>
					</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item btndelete" id="button_delete" href="' . base_url('admin/jurnal/destroy/' . str_replace('/', '%', $data_jurnal->nobukti)) . '"><i
							class="fas fa-trash text-danger pr-2"></i> Delete </a>
					</div>
			</div>
			';
            $data[] = $row;

        }

		$hasil = [
			'Total',
			'',
			'',
			'',
			number_format($total_pemasukan),
			number_format($total_pengeluaran),
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
		];

		$data[] = $hasil;

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->jurnal_model->count_all_bank(),
            "recordsFiltered" => $this->jurnal_model->count_filtered_bank($bank),
            "data" => $data,
        );
		
        echo json_encode($output);
	}

	public function create(){
		$data = [
			'title' => 'Tambah Data Transaksi Jurnal',
			'header' => 'Tambah Data Transaksi Jurnal',
			'korek' => $this->jurnal_model->getKodeRekening(),
		];

		$this->template->load('jurnal/create', $data);
	}

	public function store(){
		$nomor_bukti = $this->input->post('nomor_bukti');
		$tanggal_transaksi = $this->input->post('tanggal_transaksi');
		$korek = $this->input->post('korek');
		$jumlah_pemasukan = str_replace(',', '', $this->input->post('jumlah_pemasukan'));
		$keterangan = $this->input->post('keterangan');
		$korekPasangan = $this->input->post('korekPasangan');

		$deskripsiKorek = $this->jurnal_model->getDeskripsiAkun($korek)['0']->deskripsiAkun;
		$deskripsiKorekPasangan = $this->jurnal_model->getDeskripsiAkun($korekPasangan)['0']->deskripsiAkun;
		$time = time();

		if($nomor_bukti=='') {
				$nomor_bukti = $tanggal_transaksi.'/'.$time.'/'.'tjsl';		
		} else {
				$nomor_bukti = $nomor_bukti.'/tjsl/'.$tanggal_transaksi.'/'.$time;		
		}
		
		$this->jurnal_model->insert([
			'id_akun' => $korek,
			'tanggal' => $tanggal_transaksi,
			'pemasukan' => $jumlah_pemasukan,
			'pengeluaran' => '0',
			'deskripsi' => $deskripsiKorek,
			'keterangan' => $keterangan,
			'updated' => $this->session->userdata('username'),
			'tglUpdate' => date('Y-m-d H:i:s'),
			'nobukti' => $nomor_bukti,
			'tot_pemasukan' => '0',
			'tot_pengeluaran' => '0',
			'tampil' => '0',
			
		]);

	//Pemasukan

		if($korek == '0101010101' OR $korek == '0101010102'){
			$kaskecil = $this->jurnal_model->getKasKecil();
			$saldo = ($kaskecil) ? $kaskecil['0']->saldokaskecil + $jumlah_pemasukan : 0;

			$this->jurnal_model->insertKasKecil([
				'korek' => $korek,
				'pemasukankaskecil' => $jumlah_pemasukan,
				'pengeluarankaskecil' => '0',
				'tanggal' => $tanggal_transaksi,
				'saldokaskecil' => $saldo,
				'ketkaskecil' => $keterangan,
				'nobukti' => $nomor_bukti,
			]);
			
		}

		if($korek == '0101010204'){
			$kasbri = $this->jurnal_model->getKasBri();
			$saldo = ($kasbri) ? $kasbri['0']->saldobri + $jumlah_pemasukan : 0;

			$this->jurnal_model->insertKasBri([
				'korek' => $korek,
				'pemasukanbri' => $jumlah_pemasukan,
				'pengeluaranbri' => '0',
				'tanggal' => $tanggal_transaksi,
				'saldobri' => $saldo,
				'ketbri' => $keterangan,
				'nobukti' => $nomor_bukti,
			]);
			
		}

		if($korek == '0101010201'){
			$kasmandiri = $this->jurnal_model->getKasMandiri();
			$saldo = ($kasmandiri) ? $kasmandiri['0']->saldomandiri + $jumlah_pemasukan : 0;

			$this->jurnal_model->insertKasMandiri([
				'korek' => $korek,
				'pemasukanmandiri' => $jumlah_pemasukan,
				'pengeluaranmandiri' => '0',
				'tanggal' => $tanggal_transaksi,
				'saldomandiri' => $saldo,
				'ketmandiri' => $keterangan,
				'nobukti' => $nomor_bukti,
			]);	
		}

		$this->jurnal_model->insert([
			'id_akun' => $korekPasangan,
			'tanggal' => $tanggal_transaksi,
			'pemasukan' => '0',
			'pengeluaran' => $jumlah_pemasukan,
			'deskripsi' => $deskripsiKorekPasangan,
			'keterangan' => $keterangan,
			'updated' => $this->session->userdata('username'),
			'tglUpdate' => date('Y-m-d H:i:s'),
			'nobukti' => $nomor_bukti,
			'tot_pemasukan' => '0',
			'tot_pengeluaran' => '0',
			'tampil' => '0',
		]);

	//End Pemasukan

	//Pengeluaran

		if($korekPasangan == '0101010101' OR $korek == '0101010102'){
			$kaskecil = $this->jurnal_model->getKasKecil();
			$saldo = ($kaskecil) ? $kaskecil['0']->saldokaskecil - $jumlah_pemasukan : 0;

			$this->jurnal_model->insertKasKecil([
				'korek' => $korekPasangan,
				'pemasukankaskecil' => '0',
				'pengeluarankaskecil' => $jumlah_pemasukan,
				'tanggal' => $tanggal_transaksi,
				'saldokaskecil' => $saldo,
				'ketkaskecil' => $keterangan,
				'nobukti' => $nomor_bukti,
			]);
			
		}

		if($korekPasangan == '0101010204'){
			$kasbri = $this->jurnal_model->getKasBri();
			$saldo = ($kasbri) ? $kasbri['0']->saldobri - $jumlah_pemasukan : 0;

			$this->jurnal_model->insertKasBri([
				'korek' => $korek,
				'pemasukanbri' => '0',
				'pengeluaranbri' => $jumlah_pemasukan,
				'tanggal' => $tanggal_transaksi,
				'saldobri' => $saldo,
				'ketbri' => $keterangan,
				'nobukti' => $nomor_bukti,
			]);
			
		}

		if($korekPasangan == '0101010201'){
			$kasmandiri = $this->jurnal_model->getKasMandiri();
			$saldo = ($kasmandiri) ? $kasmandiri['0']->saldomandiri - $jumlah_pemasukan : 0;

			$this->jurnal_model->insertKasMandiri([
				'korek' => $korek,
				'pemasukanmandiri' => '0',
				'pengeluaranmandiri' => $jumlah_pemasukan,
				'tanggal' => $tanggal_transaksi,
				'saldomandiri' => $saldo,
				'ketmandiri' => $keterangan,
				'nobukti' => $nomor_bukti,
			]);
		}

	//End Pengeluaran

	$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Jurnal Berhasil Ditambahkan\',position: \'bottomRight\'});</script>');
	redirect(base_url('admin/jurnal'));
	}

	public function destroy($nobukti){
		$base = str_replace('%', '/', $nobukti);
		$this->jurnal_model->destroy($base);
		$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Jurnal Berhasil Dihapus\',position: \'bottomRight\'});</script>');
		// redirect(base_url('admin/jurnal'));
		// $referred_from = $this->session->userdata('referred_from');
		// redirect($referred_from, 'refresh');
		redirect($_SERVER['HTTP_REFERER']);
	}

	//Voucher 

	public function voucher(){
		$data = [
			'title' => 'Tambah Data Transaksi Voucher',
			'header' => 'Tambah Data Transaksi Voucher',
			'korek' => $this->jurnal_model->getKodeRekening(),
		];

		$this->template->load('jurnal/voucher', $data);
	}

	public function addVoucher(){
		$nomor_bukti = $this->input->post('nomor_bukti');
		$tanggal_transaksi = $this->input->post('tanggal_transaksi');

		$korek = $this->input->post('korek');
		$keterangan = $this->input->post('keterangan');
		$jumlah_pemasukan = str_replace(',', '', $this->input->post('jumlah_pemasukan'));

		$korekPasangan1 = $this->input->post('korekPasangan1');
		$keterangan1 = $this->input->post('keterangan1');
		$jumlah_pengeluaran1 = str_replace('.', '', $this->input->post('jumlah_pengeluaran1'));

		$korekPasangan2 = $this->input->post('korekPasangan2');
		$keterangan2 = $this->input->post('keterangan2');
		$jumlah_pengeluaran2 = str_replace('.', '', $this->input->post('jumlah_pengeluaran2'));

		$korekPasangan3 = $this->input->post('korekPasangan3');
		$keterangan3 = $this->input->post('keterangan3');
		$jumlah_pengeluaran3 = str_replace('.', '', $this->input->post('jumlah_pengeluaran3'));

		$korekPasangan4 = $this->input->post('korekPasangan4');
		$keterangan4 = $this->input->post('keterangan4');
		$jumlah_pengeluaran4 = str_replace('.', '', $this->input->post('jumlah_pengeluaran4'));

		$korekPasangan5 = $this->input->post('korekPasangan5');
		$keterangan5 = $this->input->post('keterangan5');
		$jumlah_pengeluaran5 = str_replace('.', '', $this->input->post('jumlah_pengeluaran5'));

		$korekPasangan6 = $this->input->post('korekPasangan6');
		$keterangan6 = $this->input->post('keterangan6');
		$jumlah_pengeluaran6 = str_replace('.', '', $this->input->post('jumlah_pengeluaran6'));

		$korekPasangan7 = $this->input->post('korekPasangan7');
		$keterangan7 = $this->input->post('keterangan7');
		$jumlah_pengeluaran7 = str_replace('.', '', $this->input->post('jumlah_pengeluaran7'));

		$deskripsiAkun = $this->jurnal_model->getDeskripsiAkun($korek)['0']->deskripsiAkun;
		$deskripsiAkun1 = $this->jurnal_model->getDeskripsiAkun($korekPasangan1)['0']->deskripsiAkun;
		$deskripsiAkun2 = $this->jurnal_model->getDeskripsiAkun($korekPasangan2)['0']->deskripsiAkun ?? '';
		$deskripsiAkun3 = $this->jurnal_model->getDeskripsiAkun($korekPasangan3)['0']->deskripsiAkun ?? '';
		$deskripsiAkun4 = $this->jurnal_model->getDeskripsiAkun($korekPasangan4)['0']->deskripsiAkun ?? '';
		$deskripsiAkun5 = $this->jurnal_model->getDeskripsiAkun($korekPasangan5)['0']->deskripsiAkun ?? '';
		$deskripsiAkun6 = $this->jurnal_model->getDeskripsiAkun($korekPasangan6)['0']->deskripsiAkun ?? '';
		$deskripsiAkun7 = $this->jurnal_model->getDeskripsiAkun($korekPasangan7)['0']->deskripsiAkun ?? '';
		
		if($nomor_bukti=='') {
			$nomor_bukti = $tanggal_transaksi.'/'.time().'/'.'klr';		
		}

		$this->jurnal_model->insert([
			'id_akun' => $korek,
			'tanggal' => $tanggal_transaksi,
			'pemasukan' => $jumlah_pemasukan,
			'pengeluaran' => '0',
			'deskripsi' => $deskripsiAkun,
			'keterangan' => $keterangan,
			'updated' => $this->session->userdata('username'),
			'tglUpdate' => date('Y-m-d H:i:s'),
			'nobukti' => $nomor_bukti,
			'tot_pemasukan' => '0',
			'tot_pengeluaran' => '0',
			'tampil' => '0',
			
		]);

		switch ($korek) {
			// Mandiri
			case '0101010201':
				$kasmandiri = $this->jurnal_model->getKasMandiri();
				$saldo = ($kasmandiri) ? $kasmandiri['0']->saldomandiri - $jumlah_pemasukan : 0;

				$this->jurnal_model->insertKasMandiri([
					'korek' => $korek,
					'pemasukanmandiri' => '0',
					'pengeluaranmandiri' => $jumlah_pemasukan,
					'tanggal' => $tanggal_transaksi,
					'saldomandiri' => $saldo,
					'ketmandiri' => $keterangan,
					'nobukti' => $nomor_bukti,
				]);
				break;

			case '0101010204':
				$kasbri = $this->jurnal_model->getKasBri();
				$saldo = ($kasbri) ? $kasbri['0']->saldobri - $jumlah_pemasukan : 0;

				$this->jurnal_model->insertKasBri([
					'korek' => $korek,
					'pemasukanbri' => '0',
					'pengeluaranbri' => $jumlah_pemasukan,
					'tanggal' => $tanggal_transaksi,
					'saldobri' => $saldo,
					'ketbri' => $keterangan,
					'nobukti' => $nomor_bukti,
				]);
				break;

			case '0101010401' OR '0101010402':
				$kaskecil = $this->jurnal_model->getKasKecil();
				$saldo = ($kaskecil) ? $kaskecil['0']->saldokaskecil - $jumlah_pemasukan : 0;

				$this->jurnal_model->insertKasKecil([
					'korek' => $korek,
					'pemasukankaskecil' => '0',
					'pengeluarankaskecil' => $jumlah_pemasukan,
					'tanggal' => $tanggal_transaksi,
					'saldokaskecil' => $saldo,
					'ketkaskecil' => $keterangan,
					'nobukti' => $nomor_bukti,
				]);
				break;

		}

		$this->jurnal_model->insert([
			'id_akun' => $korekPasangan1,
			'tanggal' => $tanggal_transaksi,
			'pemasukan' => '0',
			'pengeluaran' => $jumlah_pengeluaran1,
			'deskripsi' => $deskripsiAkun1,
			'keterangan' => $keterangan1,
			'updated' => $this->session->userdata('username'),
			'tglUpdate' => date('Y-m-d H:i:s'),
			'nobukti' => $nomor_bukti,
			'tot_pemasukan' => '0',
			'tot_pengeluaran' => '0',
			'tampil' => '0',
		]);

		if($keterangan2 != '') {
			$this->jurnal_model->insert([
				'id_akun' => $korekPasangan2,
				'tanggal' => $tanggal_transaksi,
				'pemasukan' => '0',
				'pengeluaran' => $jumlah_pengeluaran2,
				'deskripsi' => $deskripsiAkun2,
				'keterangan' => $keterangan2,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $nomor_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => '0',
			]);
		}

		if($keterangan3 != '') {
			$this->jurnal_model->insert([
				'id_akun' => $korekPasangan3,
				'tanggal' => $tanggal_transaksi,
				'pemasukan' => '0',
				'pengeluaran' => $jumlah_pengeluaran3,
				'deskripsi' => $deskripsiAkun3,
				'keterangan' => $keterangan3,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $nomor_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => '0',
			]);
		}

		if($keterangan4 != '') {
			$this->jurnal_model->insert([
				'id_akun' => $korekPasangan4,
				'tanggal' => $tanggal_transaksi,
				'pemasukan' => '0',
				'pengeluaran' => $jumlah_pengeluaran4,
				'deskripsi' => $deskripsiAkun4,
				'keterangan' => $keterangan4,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $nomor_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => '0',
			]);
		}

		if($keterangan5 != '') {
			$this->jurnal_model->insert([
				'id_akun' => $korekPasangan5,
				'tanggal' => $tanggal_transaksi,
				'pemasukan' => '0',
				'pengeluaran' => $jumlah_pengeluaran5,
				'deskripsi' => $deskripsiAkun5,
				'keterangan' => $keterangan5,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $nomor_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => '0',
			]);
		}

		if($keterangan6 != '') {
			$this->jurnal_model->insert([
				'id_akun' => $korekPasangan6,
				'tanggal' => $tanggal_transaksi,
				'pemasukan' => '0',
				'pengeluaran' => $jumlah_pengeluaran6,
				'deskripsi' => $deskripsiAkun6,
				'keterangan' => $keterangan6,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $nomor_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => '0',
			]);
		}

		if($keterangan7 != '') {
			$this->jurnal_model->insert([
				'id_akun' => $korekPasangan7,
				'tanggal' => $tanggal_transaksi,
				'pemasukan' => '0',
				'pengeluaran' => $jumlah_pengeluaran7,
				'deskripsi' => $deskripsiAkun7,
				'keterangan' => $keterangan7,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $nomor_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => '0',
			]);
		}

		$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Voucher Berhasil Ditambahkan\',position: \'bottomRight\'});</script>');
		redirect(base_url('admin/jurnal'));	
	}

	public function createExcel() {
		$fileName = 'jurnal-opex-' . date('Y') .'.xlsx';  
		$opex = $this->jurnal_model->get_jurnal();
		$spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'No ID');
        $sheet->setCellValue('B1', 'No Akun');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Pemasukan');
		$sheet->setCellValue('E1', 'Pengeluaran');
        $sheet->setCellValue('F1', 'Saldo'); 
        $sheet->setCellValue('G1', 'Status Balance'); 
        $sheet->setCellValue('H1', 'Deskripsi'); 
        $sheet->setCellValue('I1', 'Keterangan'); 
        $sheet->setCellValue('J1', 'No bukti'); 
        $sheet->setCellValue('K1', 'Total Pemasukan'); 
        $sheet->setCellValue('L1', 'Total Pengeluaran'); 
        $sheet->setCellValue('M1', 'Updated'); 
        $sheet->setCellValue('N1', 'Tanggal Updated'); 
		      
        $rows = 2;
		$tot_pengeluaran=0;
		$tot_pemasukan=0;

        foreach ($opex as $val){
			$tot_pengeluaran += $val->pengeluaran;
			$tot_pemasukan += $val->pemasukan;

            $sheet->setCellValue('A' . $rows, $val->id_opex);
            $sheet->setCellValue('B' . $rows, $val->id_akun);
            $sheet->setCellValue('C' . $rows, $val->tanggal);
            $sheet->setCellValue('D' . $rows, $val->pemasukan);
	    	$sheet->setCellValue('E' . $rows, $val->pengeluaran);
            $sheet->setCellValue('F' . $rows, (($val->pemasukan - $val->pengeluaran < 0) ? '0' : ($val->pemasukan - $val->pengeluaran)));
			$sheet->setCellValue('G' . $rows, ($tot_pengeluaran == $tot_pemasukan) ? "MATCH" : null);
            $sheet->setCellValue('H' . $rows, $val->deskripsi);
            $sheet->setCellValue('I' . $rows, $val->keterangan);
            $sheet->setCellValue('J' . $rows, $val->nobukti);
	    	$sheet->setCellValue('K' . $rows, $val->tot_pemasukan);
            $sheet->setCellValue('L' . $rows, $val->tot_pengeluaran);
			$sheet->setCellValue('M' . $rows, $val->updated);
            $sheet->setCellValue('N' . $rows, $val->tglUpdate);
            $rows++;
        }

        $writer = new Xlsx($spreadsheet);
		$writer->save("storage/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/storage/".$fileName);         
    }
	
	public function periodaopex(){
		$id_akun = $this->input->get('id_akun') ?? '';	
		$type = $this->input->get('type') ?? '';

		$this->template->load('jurnal/perioda', [
			'title' => 'Perioda Opex',
			'header' => 'Perioda Opex',
			'id_akun' => $id_akun,
			'type' => $type,
		]);
	}

	public function perioda_data(){
		$tanggal_awal = $this->input->post('tanggal_awal');
		$tanggal_akhir = $this->input->post('tanggal_akhir');
		$id_akun = $this->input->post('korek');

		switch ($id_akun) {
			case '1':
				$id_akun = '0101010101';
				break;

			case '2':
				$id_akun = '0101010201';
				break;

			case '3':
				$id_akun = '0101010204';
				break;
		}

		$data = [];
		$nomor = 1;
		$totpengeluaran = 0;
		$totpemasukan = 0;
		$saldo_akhir = 0;
		$saldo = 0;

		foreach ($this->jurnal_model->get_jurnal_all() as $value) {
			if($value->tanggal >= $tanggal_awal AND $value->tanggal <= $tanggal_akhir){
				if($id_akun == '0'){
					$row['no'] = $nomor;
					$row['id_opex'] = $value->id_opex;
					$row['id_akun'] = $value->id_akun;
					$row['tanggal'] = $value->tanggal;
					$row['pemasukan'] = number_format($value->pemasukan);
					$row['pengeluaran'] = number_format($value->pengeluaran);
					$saldo = $saldo+($value->pemasukan - $value->pengeluaran);
					$row['saldo'] = number_format($saldo);
					$row['deskripsi'] = $value->deskripsi;
					$row['keterangan'] = $value->keterangan;
					$row['nobukti'] = $value->nobukti;
					$row['action'] = '
						<div class="dropdown">
								<a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
									aria-expanded="false">
									<i class="fas fa-ellipsis-v"></i>
								</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<a class="dropdown-item btndelete" id="button_delete_perioda" href="' . base_url('admin/jurnal/destroy/' . str_replace('/', '%', $value->nobukti)) . '"><i
										class="fas fa-trash text-danger pr-2"></i> Delete </a>
								</div>
							</div>
					';

					$data[] = $row;

					$totpengeluaran += $value->pengeluaran;
					$totpemasukan += $value->pemasukan;
					$saldo_akhir = $value->pemasukan + $value->pengeluaran;
					$nomor++;
				} else {
					if($value->id_akun == $id_akun){
						$row['no'] = $nomor;
						$row['id_opex'] = $value->id_opex;
						$row['id_akun'] = $value->id_akun;
						$row['tanggal'] = $value->tanggal;
						$row['pemasukan'] = number_format($value->pemasukan);
						$row['pengeluaran'] = number_format($value->pengeluaran);
						$saldo = $saldo+($value->pemasukan - $value->pengeluaran);
						$row['saldo'] = number_format($saldo);
						$row['deskripsi'] = $value->deskripsi;
						$row['keterangan'] = $value->keterangan;
						$row['nobukti'] = $value->nobukti;
						$row['action'] = '
							<div class="dropdown">
								<a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
									aria-expanded="false">
									<i class="fas fa-ellipsis-v"></i>
								</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<a class="dropdown-item btndelete" id="button_delete_perioda" href="' . base_url('admin/jurnal/destroy/' . str_replace('/', '%', $value->nobukti)) . '"><i
										class="fas fa-trash text-danger pr-2"></i> Delete </a>
								</div>
							</div>
						';

						$data[] = $row;

						$totpengeluaran += $value->pengeluaran;
						$totpemasukan += $value->pemasukan;
						$saldo_akhir = $value->pemasukan + $value->pengeluaran;
						$nomor++;
					}
				}
			}
		}
				
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('data' => $data, 'totpengeluaran' => $totpengeluaran, 'totpemasukan' => $totpemasukan, 'saldo_akhir' => $saldo_akhir)));
	}
	
	public function bank($akun){

		if ($akun == 'kas') {	
			$id_akun = '101010101';	
			$saldoawal= 4687041;
		} elseif ($akun == 'mandiri') {
			$id_akun = '101010201';
			$saldoawal = 213381864.81;
		} elseif ($akun == 'bri') {
			$id_akun = '101010204';
			$saldoawal = 108631624;
		}

		$opex = $this->jurnal_model->getJurnalByAkun($id_akun);

		$this->template->load('jurnal/bank', [
			'title' => 'Jurnal Opex ' . ucfirst($akun),
			'header' => 'Jurnal Opex Bank ' . ucfirst($akun),
			'saldoawal' => $saldoawal,
			'opex' => $opex,
			'id_akun' => $id_akun,	
		]);
	}

}
