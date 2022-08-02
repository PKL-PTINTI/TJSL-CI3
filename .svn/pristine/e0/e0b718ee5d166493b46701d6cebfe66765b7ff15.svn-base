<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

			// $row[] =  '<a class="btn btn-success btn-sm"><i class="fa fa-edit"></i> </a>
            // <a class="btn btn-danger btn-sm" href="' . base_url('admin/jurnal/destroy/' . str_replace('/', '%', $data_jurnal->nobukti)) . '"><i class="fa fa-trash"></i> </a>';
            // $data[] = $row;

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

			$row[] =  '<a class="btn btn-success btn-sm"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-danger btn-sm "><i class="fa fa-trash"></i> </a>';
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
		$jumlah_pemasukan = $this->input->post('jumlah_pemasukan');
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

		//101010101	 Aktiva Lancar/Kas & Setara Kas/Kas/Program Kemitraan 
		//101010201	 Aktiva Lancar/Kas & Setara Kas/Bank/Mandiri 
		//101010204	 Aktiva Lancar/Kas & Setara Kas/Bank/BRI 

		//pemasukan

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

		// Pengeluaran

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


	$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Jurnal Berhasil Ditambahkan\',position: \'bottomRight\'});</script>');
	redirect(base_url('admin/jurnal'));
	}

	public function destroy($nobukti){
		$base = str_replace('%', '/', $nobukti);
		$this->jurnal_model->destroy($base);
		$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Jurnal Berhasil Dihapus\',position: \'bottomRight\'});</script>');
		redirect(base_url('admin/jurnal'));
	}

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
		$jumlah_pemasukan = $this->input->post('jumlah_pemasukan');
		$korekPasangan = $this->input->post('korekPasangan');

		$deskripsi = $this->jurnal_model->getDeskripsiAkun($korek)->deskripsiAkun;
	}
}
	


	