<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Mitra extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MitraModel', 'mitra_model');
		date_default_timezone_set("Asia/Jakarta");

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

			$this->data['link_active'] = 'admin/mitra';

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

	public function index(){
		$this->data['title'] = 'Management Data Mitra';
		$this->data['header'] =	 'Data Mitra';

		$this->template->load('mitra/index', $this->data);
	}

	public function get_data_mitra($param1 = NULL, $param2 = NULL){
		$list = $this->mitra_model->get_data_mitra($param1, $param2);
        $data = array();
        $no = $this->input->post('start');

		$total = $this->_countAllAmount($param1, $param2);

        foreach ($list as $mitra) {
            $no++;
            $row = array();
			$row[] = $no;
            $row[] = $mitra->nama_peminjam;
            $row[] = $mitra->nokontrak;
            $row[] = $mitra->lokasiUsaha;
            $row[] = $mitra->startcicil;
            $row[] = ($mitra->kolektibilitas == 'lancar' OR $mitra->kolektibilitas == 'Lancar' OR $mitra->kolektibilitas == 'LANCAR') 
					? '<div class="badge badge-primary">Lancar</div>' : 
					(($mitra->kolektibilitas == 'kurang lancar' OR $mitra->kolektibilitas == 'Kurang Lancar' OR $mitra->kolektibilitas == 'KURANG LANCAR') 
					? '<div class="badge badge-success">Kurang Lancar</div>' : 
					(($mitra->kolektibilitas == 'macet' OR $mitra->kolektibilitas == 'Macet' OR $mitra->kolektibilitas == 'MACET') 
					? '<div class="badge badge-danger">Macet</div>' : 
					(($mitra->kolektibilitas == 'diragukan' OR $mitra->kolektibilitas == 'Diragukan' OR $mitra->kolektibilitas == 'DIRAGUKAN') 
					? '<div class="badge badge-warning">Diragukan</div>' : '<div class="badge badge-secondary">Tidak Ada</div>')));

            $row[] = number_format($mitra->pinjpokok);
            $row[] = number_format($mitra->pinjjasa);
			$row[] = number_format($mitra->pinjpokok + $mitra->pinjjasa);
            $row[] = number_format($mitra->angpokok);
            $row[] = number_format($mitra->angjasa);
            $row[] = number_format($mitra->angjumlah);
            $row[] = number_format($mitra->saldopokok);
            $row[] = number_format($mitra->saldojasa);
            $row[] = number_format($mitra->saldojumlah);

            $row[] = $mitra->namaPerusahaan;
            $row[] = $mitra->lokasiUsaha;
            $row[] = $mitra->sektorUsaha;	
            $row[] = $mitra->ktp;
            $row[] = $mitra->tglkontrak;
            $row[] = $mitra->tgljatuhtempo;
            $row[] = $mitra->tglcicilanterakhir;
            $row[] = ($mitra->tdkbermasalah == 'normal' OR $mitra->tdkbermasalah == 'Normal' OR $mitra->tdkbermasalah == 'NORMAL') 
					? '<div class="badge badge-primary">Normal</div>' : 
					(($mitra->tdkbermasalah == 'bermasalah' OR $mitra->tdkbermasalah == 'Bermasalah' OR $mitra->tdkbermasalah == 'BERMASALAH') 
					? '<div class="badge badge-success">Bermasalah</div>' : 
					(($mitra->tdkbermasalah == 'khusus' OR $mitra->tdkbermasalah == 'Khusus' OR $mitra->tdkbermasalah == 'KHUSUS') 
					? '<div class="badge badge-danger">Khusus</div>' : 
					(($mitra->tdkbermasalah == 'wo' OR $mitra->tdkbermasalah == 'Wo' OR $mitra->tdkbermasalah == 'WO') 
					? '<div class="badge badge-warning">WO</div>' : '<div class="badge badge-secondary">Tidak Ada</div>')));

			if($mitra->kolektibilitas == 'macet' OR $mitra->kolektibilitas == 'Macet' OR $mitra->kolektibilitas == 'MACET'){
				$row[] =  '
					<div class="dropdown">
						<a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
							aria-expanded="false">
							<i class="fas fa-ellipsis-v"></i>
						</a>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="' . base_url('admin/mitra/detail/' . $mitra->nokontrak) . '"><i class="fas fa-eye text-primary pr-2"></i> Detail </a>
							<a class="dropdown-item" href="' . base_url('admin/mitra/update/' . $mitra->nokontrak) . '"><i class="fas fa-edit text-warning pr-2"></i> Update </a>
							<a class="dropdown-item" href="' . base_url('admin/mitra/cetak_surat/' . $mitra->nokontrak) . '"><i class="fas fa-print pr-2"></i></i> Cetak Surat peringatan </a>
							<a class="dropdown-item" href="' . base_url('admin/mitra/cicilan/' . $mitra->nokontrak) . '"><i class="fas fa-money-bill-transfer text-primary pr-2"></i></i> Cicilan </a>
							<a class="dropdown-item" href="' . base_url('admin/mitra/destroy/' . $mitra->id) . '"><i class="fas fa-trash text-danger pr-2"></i> Delete </a>
						</div>
					</div>
				';
			} else {
				$row[] =  '
					<div class="dropdown">
						<a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
							aria-expanded="false">
							<i class="fas fa-ellipsis-v"></i>
						</a>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="' . base_url('admin/mitra/detail/' . $mitra->nokontrak) . '"><i class="fas fa-eye text-primary pr-2"></i> Detail </a>
							<a class="dropdown-item" href="' . base_url('admin/mitra/update/' . $mitra->nokontrak) . '"><i class="fas fa-edit text-warning pr-2"></i> Update </a>
							<a class="dropdown-item" href="' . base_url('admin/mitra/cicilan/' . $mitra->nokontrak) . '"><i class="fas fa-money-bill-transfer text-primary pr-2"></i></i> Cicilan </a>
							<a class="dropdown-item" href="' . base_url('admin/mitra/destroy/' . $mitra->id) . '"><i class="fas fa-trash text-danger pr-2"></i> Delete </a>
						</div>
					</div>
				';
			}
            $data[] = $row;
        }

		$hasil = [
			'', '', '', '', '', 'TOTAL :',
			number_format($total['pinjpokok']),
			number_format($total['pinjjasa']),
			number_format($total['pinjjumlah']),
			number_format($total['angpokok']),
			number_format($total['angjasa']),
			number_format($total['angjumlah']),
			number_format($total['saldopokok']),
			number_format($total['saldojasa']),
			number_format($total['saldojumlah']),
			'', '', '', '', '', '', '', '', ''
		];

		$data[] = $hasil;

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->mitra_model->count_all_mitra($param1, $param2),
            "recordsFiltered" => $this->mitra_model->count_filtered_mitra($param1, $param2),
            "data" => $data,
        );
		
        echo json_encode($output);
	}

	private function _countAllAmount($param1, $param2){
		$this->db->select('pinjpokok');
		$this->db->select('pinjjasa');
		$this->db->select('pinjjumlah');
		$this->db->select('angpokok');
		$this->db->select('angjasa');
		$this->db->select('angjumlah');
		$this->db->select('saldopokok');
		$this->db->select('saldojasa');
		$this->db->select('saldojumlah');
		$this->db->from('mitra');

		$this->db->where('tdkbermasalah', 'normal', 'Normal', 'NORMAL');
		$this->db->where('saldopokok >', 0);

		if($param1 == 'lancar' || $param1 == 'diragukan' || $param1 == 'macet'){
			$this->db->where('kolektibilitas', $param1, ucfirst($param1), strtoupper($param1));
			// $this->db->or_where('saldopokok > ', 0);
			if ($param2) {
				$this->db->where('sektorUsaha', 'sektor ' . $param2, 'Sektor ' . ucfirst($param2), 'SEKTOR ' . strtoupper($param2));
				// $this->db->or_where('saldopokok > ', 0);
			}
		}

		if($param1 == 'kuranglancar'){
			$this->db->where('kolektibilitas', 'kurang lancar', 'Kurang Lancar', 'KURANG LANCAR');
			// $this->db->or_where('saldopokok > ', 0);
			if ($param2) {
				$this->db->where('sektorUsaha', 'sektor ' . $param2, 'Sektor ' . ucfirst($param2), 'SEKTOR ' . strtoupper($param2));
				// $this->db->or_where('saldopokok > ', 0);
			}
		}

		// TDK Bermasalah
		if($param1 == 'normal' || $param1 == 'masalah' || $param1 == 'khusus' || $param1 == 'wo'){
			$this->db->where('tdkbermasalah', $param1, ucfirst($param1), strtoupper($param1));
			// $this->db->or_where('saldopokok > ', 0);
			if ($param2) {
				$this->db->where('sektorUsaha', 'sektor ' . $param2, 'Sektor ' . ucfirst($param2), 'SEKTOR ' . strtoupper($param2));
				// $this->db->or_where('saldopokok > ', 0);
			}
		}

		$query = $this->db->get();
		$result = $query->result_array();
		$pinjpokok = 0;
		$pinjjasa = 0;
		$pinjjumlah = 0;
		$angpokok = 0;
		$angjasa = 0;
		$angjumlah = 0;
		$saldopokok = 0;
		$saldojasa = 0;
		$saldojumlah = 0;

		foreach ($result as $value) {
			$pinjpokok += $value['pinjpokok'];
			$pinjjasa += $value['pinjjasa'];
			$pinjjumlah += $value['pinjjumlah'];
			$angpokok += $value['angpokok'];
			$angjasa += $value['angjasa'];
			$angjumlah += $value['angjumlah'];
			$saldopokok += $value['saldopokok'];
			$saldojasa += $value['saldojasa'];
			$saldojumlah += $value['saldojumlah'];
		}

		return [
			'pinjpokok' => $pinjpokok,
			'pinjjasa' => $pinjjasa,
			'pinjjumlah' => $pinjjumlah,
			'angpokok' => $angpokok,
			'angjasa' => $angjasa,
			'angjumlah' => $angjumlah,
			'saldopokok' => $saldopokok,
			'saldojasa' => $saldojasa,
			'saldojumlah' => $saldojumlah,
		];
	}	

	public function create(){
		$this->data['title'] = 'Tambah Data Mitra';
		$this->data['header'] = 'Tambah Data Mitra';
		$this->data['lokasi'] = $this->mitra_model->getLokasi();
		$this->data['statusmitra'] = $this->mitra_model->getStatusMitra();
		$this->data['sektor'] = $this->mitra_model->getSektorUsaha();
		$this->data['kodebank'] = $this->mitra_model->getKodeBank();
		$this->data['hasilevaluasi'] = $this->mitra_model->getHasilEvaluasi();
		$this->data['kasbrimandiri'] = $this->mitra_model->getKasBank();
		$this->data['pelaksanaanprogram'] = $this->mitra_model->getPelaksanaanProgram();
		$this->data['kondisipinjaman'] = $this->mitra_model->getKondisiPinjaman();
		$this->data['jenispembayaran'] = $this->mitra_model->getJenisPembayaran();
		$this->data['skalausaha'] = $this->mitra_model->getSkalaUsaha();

		$this->template->load('mitra/create', $this->data);
	}

	public function store(){
		$nomor_kontrak = $this->input->post('nomor_kontrak');
		$tanggal_kontrak = $this->input->post('tanggal_kontrak');
		$nama_mitra = $this->input->post('nama_mitra');
		$alamat_rumah = $this->input->post('alamat_rumah');
		$alamat_usaha = $this->input->post('alamat_usaha');
		$lokasi_usaha = $this->input->post('lokasi_usaha');
		$nama_perusahaan = $this->input->post('nama_perusahaan');
		$no_handphone = $this->input->post('no_handphone');
		$status_mitra = $this->input->post('status_mitra');
		$sektor_usaha = $this->input->post('sektor_usaha');
		$nomor_ktp = $this->input->post('nomor_ktp');
		$norek_mitra = $this->input->post('norek_mitra');
		$nama_bank = $this->input->post('nama_bank');
		$tanggal_pengajuan = $this->input->post('tanggal_pengajuan');
		$tanggal_survey = $this->input->post('tanggal_survey');
		$hasil_survey = $this->input->post('hasil_survey');
		$jaminan = $this->input->post('jaminan');
		$nilai_pinjaman = str_replace('.', '', $this->input->post('nilai_pinjaman'));
		$lama_pinjaman = $this->input->post('lama_pinjaman');
		$jasa = $this->input->post('jasa');
		$dana_dikeluarkan = $this->input->post('dana_dikeluarkan');
		$no_va = $this->input->post('no_va');
		$lokasi_google_maps = $this->input->post('lokasi_google_maps');
		$nilai_aset = str_replace('.', '', $this->input->post('nilai_aset'));
		$nilai_omset = str_replace('.', '', $this->input->post('nilai_omset'));
		$pelaksana = $this->input->post('pelaksana');
		$sumber_dana = $this->input->post('sumber_dana');
		$kondisi = $this->input->post('kondisi');
		$jenis_pembayaran = $this->input->post('jenis_pembayaran');
		$jumlah_sdm = $this->input->post('jumlah_sdm');
		$sub_sektor = $this->input->post('sub_sektor');
		$nama_produkjasa = $this->input->post('nama_produkjasa');
		$skala_usaha = $this->input->post('skala_usaha');
		$keterangan = $this->input->post('keterangan');

		$pinjaman_jasa = ($jasa / 100) * $nilai_pinjaman * ($lama_pinjaman / 12);
		$pinjaman_jumlah = $pinjaman_jasa + $nilai_pinjaman;
		$cicilan_bulan = $pinjaman_jumlah / $lama_pinjaman;

		$startcicil = date('Y-m-d', strtotime('+60 days', strtotime($tanggal_kontrak)));

		switch ($lama_pinjaman) {
			case 12:
				$jatuh_tempo = date('Y-m-d', strtotime('+420 days', strtotime($tanggal_kontrak)));
				break;

			case 24:
				$jatuh_tempo = date('Y-m-d', strtotime('+780 days', strtotime($tanggal_kontrak)));
				break;

			case 36:
				$jatuh_tempo = date('Y-m-d', strtotime('+1140 days', strtotime($tanggal_kontak)));
				break;
			
			default:
				$jatuh_tempo = date('Y-m-d', strtotime('0 days', strtotime($tanggal_kontak)));
				break;
		}

		$kolektibilitas = 'Lancar';
		$saldo_pokok = $nilai_pinjaman;
		$saldo_jasa = $pinjaman_jasa;
		$saldo_jumlah = $pinjaman_jumlah;

		$username = $nomor_kontrak;
		$password = $sektor_usaha;

		$statusBermasalah = 'Normal';

		$this->mitra_model->insert([
			'nokontrak' => $nomor_kontrak,
			'tglkontrak' => $tanggal_kontrak,
			'tglkontrak' => $tanggal_kontrak,
			'nama_peminjam' => $nama_mitra,
			'alamat_rumah' => $alamat_rumah,
			'alamat_usaha' => $alamat_usaha,
			'lokasiUsaha' => $lokasi_usaha,
			'namaPerusahaan' => $nama_perusahaan,
			'hp' => $no_handphone,
			'barulanjutan' => $status_mitra,
			'sektorUsaha' => $sektor_usaha,
			'ktp' => $nomor_ktp,
			'noRekBank' => $norek_mitra,
			'bankAccount' => $nama_bank,
			'tglproposal' => $tanggal_pengajuan,
			'tglSurvey' => $tanggal_survey,
			'hasil' => $hasil_survey,
			'jaminan' => $jaminan,
			'pinjpokok' => $nilai_pinjaman,
			'lama_pinjam' => $lama_pinjaman,
			'jasa' => $jasa,
			'korek' => $dana_dikeluarkan,
			'VA' => $no_va,
			'googlemaps' => $lokasi_google_maps,
			'nilaiAset' => $nilai_aset,
			'nilaiOmset' => $nilai_omset,
			'pinjaman' => $nilai_pinjaman,
			'pelaksanaanProgram' => $pelaksana,
			'sumberDana' => $sumber_dana,
			'jenisPembayaran' => $jenis_pembayaran,
			'jumlahSDM' => $jumlah_sdm,
			'subSektor' => $sub_sektor,
			'prodJasa' => $nama_produkjasa,
			'skalaUsaha' => $skala_usaha,
			'tambahanDana' => '2',
			'kelebihanAngsuran' => '0',
			'kondisiPinjaman' => '1',
			'pinjjasa' => $pinjaman_jasa,
			'pinjjumlah' => $pinjaman_jumlah,
			'cicilanperbln' => $cicilan_bulan,
			'tdkbermasalah' => $statusBermasalah,
			'startcicil' => $startcicil,
			'tgljatuhtempo' => $jatuh_tempo,
			'tglmonitor' => date('Y-m-d'),
			'kolektibilitas' => $kolektibilitas,
			'saldopokok' => $saldo_pokok,
			'saldojasa' => $saldo_jasa,
			'saldojumlah' => $saldo_jumlah,
			'updated' => $this->session->userdata('username'),
			'tglpenagihan' => date('Y-m-d'),
			'tglUpdate' => date('Y-m-d'),
			'tglcicilanterakhir' => $tanggal_kontrak,
			'bankAccount' => $nama_bank,
			'username' => $username,
			'password' => $password,
			'provinsi' => '2',
			'angpokok' => '0',
			'angjasa' => '0',
			'angjumlah' => '0',
			'rekondisi' => '0',
			'tgl_rekondisi' => '0000-00-00',
			'selisihHari' => '0',
		]);

		switch ($sektor_usaha) {
			// 0101060101 Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Industri
			case 'Sektor Industri':
				$kode_rekening = '101060101';
				break;

			// 0101060102 Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Perdagangan
			case 'Sektor Perdagangan':
				$kode_rekening = '101060102';
				break;

			// 0101060103 Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Pertanian
			case 'Sektor Pertanian':
				$kode_rekening = '101060103';
				break;

			// 0101060104 Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Perkebunan
			case 'Sektor Perkebunan':
				$kode_rekening = '101060104';
				break;

			// 0101060105 Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Perikanan
			case 'Sektor Perikanan':
				$kode_rekening = '101060105';
				break;

			// 0101060106 Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Peternakan
			case 'Sektor Peternakan':
				$kode_rekening = '101060106';
				break;

			// 0101060107 Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Jasa
			case 'Sektor Jasa':
				$kode_rekening = '101060107';
				break;

			// 0101060108 Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Lain-lain
			case 'Sektor Lain-lain':
				$kode_rekening = '101060108';
				break;
			
			default:
				$kode_rekening = '';
				break;
		}

		$this->mitra_model->insertOpex([
			'id_akun' => $kode_rekening,
			'tanggal' => date('Y-m-d'),
			'pemasukan' => $nilai_pinjaman,
			'pengeluaran' => '0',
			'deskripsi' => $keterangan,
			'keterangan' => $nama_mitra,
			'updated' => $this->session->userdata('username'),
			'tglUpdate' => date('Y-m-d'),
		]);

		// 101010204 Aktiva Lancar/Kas & Setara Kas/Bank/BRI
 		// 101010201 Aktiva Lancar/Kas & Setara Kas/Bank/Mandiri

		switch ($dana_dikeluarkan) {
			// 101010204 Aktiva Lancar/Kas & Setara Kas/Bank/BRI
			case '101010204':
				$this->mitra_model->insertOpex([
					'id_akun' => '101010204',
					'tanggal' => date('Y-m-d'),
					'pemasukan' => '0',
					'pengeluaran' => $nilai_pinjaman,
					'deskripsi' => $keterangan,
					'keterangan' => $nama_mitra,
					'updated' => $this->session->userdata('username'),
					'tglUpdate' => date('Y-m-d'),
				]);

				$bank_bri = $this->mitra_model->getKasBRI();

				$saldo_bri = $bank_bri->saldobri;
				$saldo_bri -= $nilai_pinjaman;

				$this->mitra_model->insertKasBRI([
					'korek' => '101010204',
					'pemasukanbri' => '0',
					'pengeluaranbri' => $nilai_pinjaman,
					'tanggal' => $tanggal_kontrak,
					'saldobri' => $saldo_bri,
					'ketbri' => $keterangan,
				]);

				// TODO: UPDATE KASBANK by BRI
				break;

			// 101010201 Aktiva Lancar/Kas & Setara Kas/Bank/Mandiri
			case '101010201':
				$this->mitra_model->insertOpex([
					'id_akun' => '101010201',
					'tanggal' => date('Y-m-d'),
					'pemasukan' => '0',
					'pengeluaran' => $nilai_pinjaman,
					'deskripsi' => $keterangan,
					'keterangan' => $nama_mitra,
					'updated' => $this->session->userdata('username'),
					'tglUpdate' => date('Y-m-d'),
				]);

				$bank_mandiri = $this->mitra_model->getKasMandiri();

				$saldo_mandiri = $bank_mandiri->saldomandiri;
				$saldo_mandiri -= $nilai_pinjaman;

				$this->mitra_model->insertKasMandiri([
					'korek' => '101010204',
					'pemasukanmandiri' => '0',
					'pengeluaranmandiri' => $nilai_pinjaman,
					'tanggal' => $tanggal_kontrak,
					'saldomandiri' => $saldo_bri,
					'ketmandiri' => $keterangan,
				]);

				// TODO: UPDATE KASBANK by BRI
				break;
			
			default:
				$this->mitra_model->insertOpex([
					'id_akun' => $sumber_dana,
					'tanggal' => date('Y-m-d'),
					'pemasukan' => '0',
					'pengeluaran' => $nilai_pinjaman,
					'deskripsi' => $keterangan,
					'keterangan' => $nama_mitra,
					'updated' => $this->session->userdata('username'),
					'tglUpdate' => date('Y-m-d'),
				]);
				break;
		}

		$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Mitra Baru Berhasil Ditambahkan\',position: \'bottomRight\'});</script>');
		redirect(base_url('admin/mitra'));
	}

	public function storeUpdate(){
		$nokontrak = $this->input->post('nokontrak');
		$nama_peminjam = $this->input->post('nama_peminjam');
		$sektorUsaha = $this->input->post('sektorUsaha');
		$pinjpokok = $this->input->post('pinjpokok');
		$pinjjasa = $this->input->post('pinjjasa');
		$hp = $this->input->post('hp');
		$ktp = $this->input->post('ktp');
		$noRekBank = $this->input->post('noRekBank');
		$tdkbermasalah = $this->input->post('tdkbermasalah');
		$namaPerusahaan = $this->input->post('namaPerusahaan');
		$rekondisi = $this->input->post('rekondisi');
		$tgl_rekondisi = $this->input->post('tgl_rekondisi');
		$prodJasa = $this->input->post('prodJasa');
		$prodUnggul = $this->input->post('prodUnggul');

		var_dump($this->input->post());
		die;

		// $this->db->query("UPDATE `mitra` SET `nokontrak`='$nokontrak',`nama_peminjam`='$nama_peminjam',`sektorUsaha`=
		// '$sektorUsaha',`pinjpokok`='$pinjpokok',`pinjjasa`='$pinjjasa',`hp`='$hp',`ktp`='$ktp',`noRekBank`='$noRekBank',
		// `tdkbermasalah`='$tdkbermasalah',`namaPerusahaan`='$namaPerusahaan', `rekondisi`='$rekondisi', `tgl_rekondisi`='$tgl_rekondisi',
		//  `prodJasa`='$prodJasa', `googlemaps`='$prodUnggul' WHERE nokontrak='$nokontrak'");
		$this->db->update('mitra', [
			'nokontrak' => $nokontrak,
			'nama_peminjam' => $nama_peminjam,
			'sektorUsaha' => $sektorUsaha,
			'pinjpokok' => $pinjpokok,
			'pinjjasa' => $pinjjasa,
			'hp' => $hp,
			'ktp' => $ktp,
			'noRekBank' => $noRekBank,
			'tdkbermasalah' => $tdkbermasalah,
			'namaPerusahaan' => $namaPerusahaan,
			'rekondisi' => $rekondisi,
			'tgl_rekondisi' => $tgl_rekondisi,
			'prodJasa' => $prodJasa,
			// 'prodUnggul' => $prodUnggul,
		], ['nokontrak' => $nokontrak]);
		$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Mitra Berhasil Di Update\',position: \'bottomRight\'});</script>');

		return redirect(base_url('admin/mitra'));
	}

	public function update($nokontrak){
		$this->data['title'] = 'Update Data Mitra';
		$this->data['mitra'] = $this->mitra_model->getMitra($nokontrak);
		$this->data['lokasi'] = $this->mitra_model->getLokasi();
		$this->data['statusmitra'] = $this->mitra_model->getStatusMitra();
		$this->data['sektor'] = $this->mitra_model->getSektorUsaha();
		$this->data['kodebank'] = $this->mitra_model->getKodeBank();
		$this->data['hasilevaluasi'] = $this->mitra_model->getHasilEvaluasi();
		$this->data['kasbrimandiri'] = $this->mitra_model->getKasBank();
		$this->data['pelaksanaanprogram'] = $this->mitra_model->getPelaksanaanProgram();
		$this->data['kondisipinjaman'] = $this->mitra_model->getKondisiPinjaman();
		$this->data['jenispembayaran'] = $this->mitra_model->getJenisPembayaran();
		$this->data['skalausaha'] = $this->mitra_model->getSkalaUsaha();

		$this->template->load('mitra/update', $this->data);
	}

	public function destroy($id){
		$this->mitra_model->destroy($id);
		$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Mitra Berhasil Dihapus\',position: \'bottomRight\'});</script>');
		redirect(base_url('admin/mitra'));
	}

	public function rincianCicilan($no_kontrak){
		$this->data['title'] = 'Rincian Cicilan';
		$this->data['header'] = 'Rincian Cicilan No Kontrak '.$no_kontrak;
		$this->data['mitra'] = $this->mitra_model->getMitraKontrak($no_kontrak);
		$this->data['cicilan'] = $this->mitra_model->getMitraCicilan($no_kontrak);

		$totPinjamanJumlah = $this->data['mitra']->pinjpokok + $this->data['mitra']->pinjjasa;
		$counter = 1;
		$angsuranjumlah = 0;
		$saldo = 0;
		$angsuranjumlahX = 0;
		$angsuranjumlah = 0;
		$pokok = 0;
		$jasa = 0;
		$total = 0;
		$no = 1;
		$dataOpex = array();
		$cicil_pokok = 0;
		$cicil_jasa = 0;
		$jumlah = 0;
		$sisaPinjamanJumlah = 0;
		$forcekolek = 'macet';
		$angsuranjumlahpaskaRekondisi = 0;
		$totcicilanrekondisi = 0;
		$koleks = '';
		$selisihbrpkalicicilan = 0;

        if($this->data['mitra']->pinjjumlah == '0')
        {
		  	$this->mitra_model->updatePinjamanJumlah($no_kontrak, $totPinjamanJumlah);
        }
		
		foreach($this->mitra_model->getOpexCicilan() as $cicilanOpex){
			if($no_kontrak < 10){
				$no_bukti = $cicilanOpex->nobukti;
				$no_pk = substr($no_bukti, -3);
			}
			if($no_kontrak >= 10 AND $no_kontrak < 100){
				$no_bukti = $cicilanOpex->nobukti;
				$no_pk = substr($no_bukti, -4);
			}
			if($no_kontrak >= 100 AND $no_kontrak < 1000){
				$no_bukti = $cicilanOpex->nobukti;
				$no_pk = substr($no_bukti, -5);
			}
			if($no_kontrak >= 1000 AND $no_kontrak < 10000){
				$no_bukti = $cicilanOpex->nobukti;
				$no_pk = substr($no_bukti, -6);
			}

			if($no_pk == 'PK'.$no_kontrak){
				// echo nl2br("\n");   // echo 'getID='; echo $_GET[id];
				// echo ' $idOpex='; echo $cicilanOpex->id_opex;
				// echo ' noPK='; echo $no_pk;
				// echo ' $idAkun='; echo $cicilanOpex->id_akun;
				// echo ' $tgl='; echo $cicilanOpex->tanggal;

				if($cicilanOpex->id_akun == '403010100')
				{
					$cicil_jasa = $cicilanOpex->pengeluaran;
					// echo ' $jasa='; echo number_format($cicil_jasa); echo ' noBukti='; echo $cicilanOpex->nobukti;
        			// echo ' tampil='; echo $cicilanOpex->tampil;
				}

				if(($cicilanOpex->id_akun == '101060201' OR $cicilanOpex->id_akun == '101060202' OR $cicilanOpex->id_akun == '101060203' OR $cicilanOpex->id_akun == '101060204' OR $cicilanOpex->id_akun == '101060205' OR $cicilanOpex->id_akun == '101060206' OR $cicilanOpex->id_akun == '101060207' OR $cicilanOpex->id_akun == '101060208') AND $cicilanOpex->tampil = '1'){
					$cicil_pokok = $cicilanOpex->pengeluaran;
					// echo ' $pokok='; echo number_format($cicil_pokok); echo ' noBukti='; echo $cicilanOpex->nobukti;
         			// echo ' tampil='; echo $cicilanOpex->tampil;
					$jumlah = $cicil_pokok + $cicil_jasa;
					// echo ' $jumlah='; echo number_format($jumlah);

					if($counter==1){
						$sisaPinjamanJumlah = $totPinjamanJumlah - $jumlah;
					} else {
						$sisaPinjamanJumlah = $sisaPinjamanJumlah - $jumlah;
					}

					$angsuranjumlah += $jumlah;
					// echo ' tot $angsJumlah=';echo number_format($angsuranjumlah);
					$counter++;

					$tglcicilanTerakhir=$cicilanOpex->tanggal;// simpan tgl cicilan terakhir di jurnal ke mitra

					// echo ' ASLI=>$tglCicilanTerakhir='; echo $tglcicilanTerakhir; echo nl2br("\n");

					// echo 'PROSES 1: ';
					if($this->data['mitra']->rekondisi == '1'){
						$tanggal_terakhir_cicil  = strtotime($this->data['mitra']->tgl_rekondisi);
						// echo '$tglRekond='; echo $this->data['mitra']->tgl_rekondisi;

						if($this->data['mitra']->tgl_rekondisi < $cicilanOpex->tanggal){
							$tanggal_terakhir_cicil  = strtotime($cicilanOpex->tanggal);
							// echo ' REKOND 2 * CHANGE'; echo 'tglCicilanTerakhir=>'; echo $tglcicilanTerakhir;
						}
					} else {	
						$tanggal_terakhir_cicil  = strtotime($cicilanOpex->tanggal);
						// echo ' NO-REKOND 1 * ';
					}

					$awal_bulan= date('Y-m-01', strtotime(date('Y-m-d')));
					$selisih_hari = floor((strtotime($awal_bulan) - $tanggal_terakhir_cicil) / (60 * 60 * 24));

					// echo ' $selisihHari=';echo $selisih_hari; echo ' hari';

					if($selisih_hari <= 61){
						$kolektibilitasawal = 'lancar';
						// echo ' $kolektibilitasAwal='; echo $kolektibilitasawal;
					} elseif($selisih_hari > 61 AND $selisih_hari <= 183) {
						$kolektibilitasawal = 'kurang lancar';
						// echo ' $kolektibilitasAwal='; echo $kolektibilitasawal;
					} elseif($selisih_hari > 183 AND $selisih_hari <= 274){
						$kolektibilitasawal = 'diragukan';
						// echo ' $kolektibilitasAwal='; echo $kolektibilitasawal;
					} elseif($selisih_hari > 274){
						$kolektibilitasawal = 'macet';
						// echo ' $kolektibilitasAwal='; echo $kolektibilitasawal;
					}

					$kolektibilitas = $kolektibilitasawal;
					// echo 'endPROSES 1->$kolex1='; echo $kolektibilitas;

					// echo nl2br("\n");
					// echo ' PROSES 2: cek jumlah cicilan';
					
					if($this->data['mitra']->rekondisi == '1'){
						// echo ' REKOND2=' ;// echo $tanggalkontrak;
        				// echo '$TglKontrakRekond='; echo $this->data['mitra']->tgl_rekondisi;
						$tanggalkontrak = strtotime($this->data['mitra']->tgl_rekondisi);
						$tgl_pertama = strtotime(date('Y-m-01', strtotime(date('Y-m-d'))));

						$selisihHari = floor(($tgl_pertama - $tanggalkontrak) / (60 * 60 * 24));
						$selisihBulan = floor(($selisihHari / 30) - 1);

						// echo ' selisihHari='; echo number_format($selisihHari);
						// echo ' selisihBulan='; echo $selisihBulan; 
       					// echo ' cicilanPerBln='; echo number_format($this->data['mitra']->cicilanperbln);

						$jumlahuangseharusnya = $selisihBulan * $this->data['mitra']->cicilanperbln;

						// echo ' ---699 ---BACA CICILAN REKOND PASCA TGL RECOND='; echo nl2br("\n");

						if($cicilanOpex->tanggal >= $this->data['mitra']->tgl_rekondisi){
							// echo 'rekonCicilanTgl='; 
							$totcicilanrekondisi += $cicilanOpex->pengeluaran;
							$angsuranjumlahpaskaRekondisi = $totcicilanrekondisi;
							// echo ' $AngsJumlahPaskaRekond='; echo $angsuranjumlahpaskaRekondisi;
                            // echo nl2br("\n");
						}

  						// echo ' $AngsJumlahPaskaRekondisi=>'; echo $angsuranjumlahpaskaRekondisi;
						//   echo ' $jumlahUangSeharusnya'; echo number_format($jumlahuangseharusnya); 
						//   echo '<-VS->';
						//   echo ' $AngsJumlah='; echo number_format($angsuranjumlahpaskaRekondisi);

						if($angsuranjumlahpaskaRekondisi < $jumlahuangseharusnya){
							$selisihbrpkalicicilan = floor(($jumlahuangseharusnya-$angsuranjumlahpaskaRekondisi) / $this->data['mitra']->cicilanperbln);

							// echo ' selisihX_Cicilan='; echo number_format($selisihcicilan);
							// echo ' selisihBrpX_Cicilan='; echo $selisihbrpkalicicilan;
							// echo ' bln ->';

							if($selisihbrpkalicicilan >= 2 AND $selisihbrpkalicicilan <= 6){
								// echo 'turun 1 kelas';                    echo nl2br("\n");
								if($kolektibilitasawal=='lancar')
								{
									// echo 'turun jadi kurang lancar';
									$koleks='kurang lancar';
								}

								if($kolektibilitasawal=='kurang lancar')
								{
									// echo 'turun jadi diragukan';
									$koleks='diragukan';
								}

								if($kolektibilitasawal=='diragukan' OR $kolektibilitasawal=='macet')
								{
									// echo 'turun jadi macet';
									$koleks='macet';
								}
							}

							if($selisihbrpkalicicilan > 6 AND $selisihbrpkalicicilan <= 9){
								// echo 'turun 2 kelas';            echo nl2br("\n");
								if($kolektibilitasawal=='lancar')
								{
									$koleks='diragukan';
								}
								
								if($kolektibilitasawal=='kurang lancar' OR $kolektibilitasawal=='diragukan' OR $kolektibilitasawal=='macet')
								{
									$koleks='macet';
								}

							}

							if($selisihbrpkalicicilan>9 ){
								// echo 'turun 3 kelas';            echo nl2br("\n");

								$koleks='macet';
							}

							$kolektibilitas = $koleks;
						}
						// echo 'REKOND->$kolex2='; echo $kolektibilitas;
						$this->mitra_model->updateKolektibilitas($no_kontrak, $kolektibilitas);
					} else {
						$tgl_pertama = strtotime(date('Y-m-01', strtotime(date('Y-m-d'))));
						$tanggalkontraks = strtotime($this->data['mitra']->tglkontrak);
						// echo ' $tglPertama='; echo $tgl_pertama; 
						// echo ' $TglKontraks='; echo $tanggalkontraks; 
						$selisihHari = floor(($tgl_pertama - $tanggalkontraks) / (60 * 60 * 24));
						// echo ' selisihHari='; echo number_format($selisihHari);

						$jumlahbulan = floor(($selisihHari/30) - 1);
						$jumlahuangseharusnya = $jumlahbulan * $this->data['mitra']->cicilanperbln;

						// echo ' SelisihBulan='; echo $jumlahbulan; 
       					// echo ' CicilanPerBln='; echo number_format($this->data['mitra']->cicilanperbln);

						$angsuranjumlahX += $cicilanOpex->pengeluaran;

						// echo ' NO-REKOND=' ; //echo $tglkontrak; 
        				// /$TglKontrak='; echo $this->data['mitra']->tglkontrak;

						// echo ' $JumlahUangSeharusnya'; echo number_format($jumlahuangseharusnya); 
						// echo '<-VS->';
						// echo ' $AngsJumlahX='; echo number_format($angsuranjumlahX);
						if($angsuranjumlah < $jumlahuangseharusnya){
							$koleks = $kolektibilitasawal;
							$selisihcicilan = ($jumlahuangseharusnya - $angsuranjumlah);
							$selisihbrpkalicicilan = floor( $selisihcicilan / $this->data['mitra']->cicilanperbln);

							// echo ' selisihXXCicilan='; echo number_format($selisihcicilan);
             				// echo ' selisihBrpXXCicilan='; echo $selisihbrpkalicicilan;

							if($selisihbrpkalicicilan >= 2 AND $selisihbrpkalicicilan <= 6){
								// echo ' turun 1 kelas line 796 => 	' . $kolektibilitasawal; 
								// echo nl2br("\n");

								if($kolektibilitasawal=='lancar')
								{
									$koleks='kurang lancar';
								}

								if($kolektibilitasawal=='kurang lancar')
								{
									$koleks='diragukan';
								}

								if($kolektibilitasawal=='diragukan' OR $kolektibilitasawal=='macet')
								{
									$koleks='macet';
								}
							}

							if($selisihbrpkalicicilan > 6 AND $selisihbrpkalicicilan <= 9){
								// echo ' turun 2 kelas';            echo nl2br("\n");

								if($kolektibilitasawal=='lancar')
								{
									$koleks='diragukan';
								}
								
								if($kolektibilitasawal=='kurang lancar' OR $kolektibilitasawal=='diragukan' OR $kolektibilitasawal=='macet')
								{
									$koleks='macet';
								}
							}

							if($selisihbrpkalicicilan > 9 )
							{
								// echo ' turun 3 kelas';            echo nl2br("\n");

								$koleks='macet';
							}

							$kolektibilitas = $koleks;
							// echo ' $kolektibilitasZ='; echo $kolektibilitas;
							// echo nl2br("\n");

							$this->mitra_model->updateKolektibilitas($no_kontrak, $kolektibilitas);
						}

						// echo 'NO-REKOND->$kolex2='; echo $kolektibilitas;
						// echo nl2br("\n");
					}

					// echo ' SIMPAN TOTAL CICILAN PASKA REKONDISI='; echo $angsuranjumlahpaskaRekondisi;
					// echo ' SELISIH BRP X CICILAN PASKA REKONDISI='; echo $selisihbrpkalicicilan;
					// echo nl2br("\n");

				$no++;
				$row = array();
				$row['no'] = $no;
				$row['tanggal'] = $cicilanOpex->tanggal;
				$row['deskripsi'] = $cicilanOpex->deskripsi;
				$row['keterangan'] = $cicilanOpex->keterangan;
				$row['cicil_pokok'] = $cicil_pokok;
				$row['cicil_jasa'] = $cicil_jasa;
				$row['jumlah'] = $jumlah;
				$row['sisaPinjamanJumlah'] = $sisaPinjamanJumlah;
				$row['id_akun'] = $cicilanOpex->id_akun;
				$row['nobukti'] = $cicilanOpex->nobukti;
				$row['id_opex'] = $cicilanOpex->id_opex;
				$row['updated'] = $cicilanOpex->updated;
				$row['tampil'] = $cicilanOpex->tampil;
				$row['tglUpdate'] = $cicilanOpex->tglUpdate;
				$dataOpex[] = $row;

				$pokok += $cicil_pokok;
				$jasa += $cicil_jasa;	
				$total += $jumlah;

				}
			}
		}	

		// $this->mitra_model->updateKolektibilitas($no_kontrak, $kolektibilitas);

		$this->data['pokok'] = $pokok;
		$this->data['jasa'] = $jasa;
		$this->data['total'] = $total;

		$this->data['dataOpex'] = $dataOpex;

		$this->template->load('mitra/rincian_cicilan', $this->data);
	}

	public function cretaeCicilan($no_kontrak){
		$this->data['title'] = 'Buat Cicilan';
		$this->data['mitra'] = $this->mitra_model->getMitraKontrak($no_kontrak);
		$this->data['kasbrimandiri'] = $this->mitra_model->getKasBankCicilan();

		$this->template->load('mitra/create_cicilan', $this->data);
	}

	public function tambahCicilan(){
		$cicilan_pokok = str_replace('.', '', $this->input->post('cicilan_pokok'));
		$cicilan_jasa = str_replace('.', '', $this->input->post('cicilan_jasa'));

		$rekening = $this->input->post('rekening');
		$tanggal_cicilan = $this->input->post('tanggal');
		$keterangan = $this->input->post('keterangan');
		$no_kontrak = $this->input->post('no_kontrak');

		$totalcicilan = $cicilan_pokok + $cicilan_jasa;
		$timeStamp = time();

		$mitra = $this->mitra_model->getMitraKontrak($no_kontrak);

		$koderekening = '';
		switch ($mitra->sektorUsaha) {
			// 0101060201 Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Industri 
			case 'Sektor Industri':
				$koderekening = '101060201';
				break;
			
			// 0101060202 Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Perdagangan
			case 'Sektor Perdagangan':
				$koderekening = '101060202';
				break;

			// 0101060203 Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Pertanian
			case 'Sektor Pertanian':
				$koderekening = '101060203';
				break;

			// 0101060204 Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Perkebunan
			case 'Sektor Perkebunan':
				$koderekening = '101060204';
				break;

			// 0101060205 Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Perikanan
			case 'Sektor Perikanan':
				$koderekening = '101060205';
				break;

			// 0101060206 Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Peternakan
			case 'Sektor Peternakan':
				$koderekening = '101060206';
				break;

			// 0101060207 Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Jasa
			case 'Sektor Jasa':
				$koderekening = '101060207';
				break;

			// 0101060208 Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Lain-lain
			case 'Sektor Lain-lain':
				$koderekening = '101060208';
				break;

			default:
				$koderekening = '';
				break;
		}

		if($rekening == 101010101){
			$no_bukti = $tanggal_cicilan . '/' . $mitra->tdkbermasalah .'/'.$timeStamp.'/'.'M01'.'PK'.$no_kontrak;
		} elseif ($rekening == 101010201) {
			$no_bukti = $tanggal_cicilan . '/' . $mitra->tdkbermasalah .'/'.$timeStamp.'/'.'M02'.'PK'.$no_kontrak;
		} elseif ($rekening == 101010204) {
			$no_bukti = $tanggal_cicilan . '/' . $mitra->tdkbermasalah .'/'.$timeStamp.'/'.'M03'.'PK'.$no_kontrak;
		}

		if ($mitra->tdkbermasalah == 'masalah' || $mitra->tdkbermasalah == 'Masalah' || $mitra->tdkbermasalah == 'MASALAH') {
			echo 'MITRA MASALAH';
			$tampil = 1;
			$akun = $this->mitra_model->getAkunKorek($rekening);
			$deskripsi = $akun[0]->deskripsiAkun;
			$ket = $mitra->nama_peminjam.'/'.$keterangan;

			switch ($mitra->sektorUsaha) {
				// 0101060201 Aktiva Lancar/Piutang Mitra Masalah/Angsuran/Sektor Industri 
				case 'Sektor Industri':
					$koderekeningmasalah = '103040201';
					break;
				
				// 0101060202 Aktiva Lancar/Piutang Mitra Masalah/Angsuran/Sektor Perdagangan
				case 'Sektor Perdagangan':
					$koderekeningmasalah = '103040202';
					break;
	
				// 0101060203 Aktiva Lancar/Piutang Mitra Masalah/Angsuran/Sektor Pertanian
				case 'Sektor Pertanian':
					$koderekeningmasalah = '103040203';
					break;
	
				// 0101060204 Aktiva Lancar/Piutang Mitra Masalah/Angsuran/Sektor Perkebunan
				case 'Sektor Perkebunan':
					$koderekeningmasalah = '103040204';
					break;
	
				// 0101060205 Aktiva Lancar/Piutang Mitra Masalah/Angsuran/Sektor Perikanan
				case 'Sektor Perikanan':
					$koderekeningmasalah = '103040205';
					break;
	
				// 0101060206 Aktiva Lancar/Piutang Mitra Masalah/Angsuran/Sektor Peternakan
				case 'Sektor Peternakan':
					$koderekeningmasalah = '103040206';
					break;
	
				// 0101060207 Aktiva Lancar/Piutang Mitra Masalah/Angsuran/Sektor Jasa
				case 'Sektor Jasa':
					$koderekeningmasalah = '103040207';
					break;
	
				// 0101060208 Aktiva Lancar/Piutang Mitra Masalah/Angsuran/Lain-lain
				case 'Sektor Lain-lain':
					$koderekeningmasalah = '103040208';
					break;
			}

			$this->mitra_model->insertOpex([
				'id_akun' => $rekening,
				'tanggal' => $tanggal_cicilan,
				'pemasukan' => strval($totalcicilan),
				'pengeluaran' => '0',
				'deskripsi' => $deskripsi,
				'keterangan' => $ket,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $no_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => '0',
			]);

			$this->mitra_model->insertOpex([
				'id_akun' => $koderekeningmasalah,
				'tanggal' => $tanggal_cicilan,
				'pemasukan' => '0',
				'pengeluaran' => strval($totalcicilan),
				'deskripsi' => $this->mitra_model->getAkunKorek($koderekeningmasalah)[0]->deskripsiAkun,
				'keterangan' => $ket,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $no_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => '0',
			]);
		} elseif($mitra->tdkbermasalah == 'wo' || $mitra->tdkbermasalah == 'Wo' || $mitra->tdkbermasalah == 'WO'){
			echo 'MITRA WO';
			$tampil = 1;
			$akun = $this->mitra_model->getAkunKorek($rekening);
			$deskripsi = $akun[0]->deskripsiAkun;
			$ket = $mitra->nama_peminjam.'/'.$keterangan;

			$this->mitra_model->insertOpex([
				'id_akun' => $rekening,
				'tanggal' => $tanggal_cicilan,
				'pemasukan' => strval($totalcicilan),
				'pengeluaran' => '0',
				'deskripsi' => $deskripsi,
				'keterangan' => $ket,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $no_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => '0',
			]);
			$this->mitra_model->insertOpex([
				'id_akun' => '403030100',
				'tanggal' => $tanggal_cicilan,
				'pemasukan' => '0',
				'pengeluaran' => strval($totalcicilan),
				'deskripsi' => 'Pendapatan/Pendapatan Lain-lain/Piutang Hapus Buku',
				'keterangan' => $ket,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $no_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => '0',
			]);
		} else {
			$tampil = 0;
		}

		$this->mitra_model->insertOpex([
				'id_akun' => $rekening,
				'tanggal' => $tanggal_cicilan,
				'pemasukan' => strval($totalcicilan),
				'pengeluaran' => '0',
				'deskripsi' => $keterangan,
				'keterangan' => $mitra->nama_peminjam,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $no_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => $tampil,
		]);

		$this->mitra_model->insertOpex([
				'id_akun' => '403010100',
				'tanggal' => $tanggal_cicilan,
				'pemasukan' => '0',
				'pengeluaran' => $cicilan_jasa,
				'deskripsi' => $keterangan,
				'keterangan' => $mitra->nama_peminjam,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $no_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => $tampil,
		]);

		$this->mitra_model->insertOpex([
				'id_akun' => $koderekening,
				'tanggal' => $tanggal_cicilan,
				'pemasukan' => '0',
				'pengeluaran' => $cicilan_pokok,
				'deskripsi' => $keterangan,
				'keterangan' => $mitra->nama_peminjam,
				'updated' => $this->session->userdata('username'),
				'tglUpdate' => date('Y-m-d H:i:s'),
				'nobukti' => $no_bukti,
				'tot_pemasukan' => '0',
				'tot_pengeluaran' => '0',
				'tampil' => $tampil,
		]);

		$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Cicilan Berhasil Ditambahkan\',position: \'bottomRight\'});</script>');
		redirect(base_url('admin/mitra/cicilan/'.$no_kontrak));

	}

	public function copytojurnal($no_kontrak){
		$mitra = $this->mitra_model->getMitraKontrak($no_kontrak);
		$sektorUsaha = $mitra->sektorUsaha;

		$angsuran = $this->mitra_model->getMitraCicilan($no_kontrak);

		foreach ($angsuran as $angs) {
			$uniq = strtotime("now");
			if($angs->pokok != 0 OR $angs->jasa != 0){
				$tglcicilan = $angs->tgl;

				$bank = 101010101;
				if($bank==101010201){
					$nobukti = $tglcicilan.'/'.$uniq.'/'.'M01'.'/'.'PK'.$no_kontrak;
				}
			
				if($bank==101010204){
					$nobukti = $tglcicilan.'/'.$uniq.'/'.'M02'.'/'.'PK'.$no_kontrak;
				}
			
				if($bank==101010101){	
					$nobukti = $tglcicilan.'/'.$uniq.'/'.'M03'.'/'.'PK'.$no_kontrak;
				}

				$ket = $angs->ket;

				$this->mitra_model->insertOpex([
					'id_akun' => $bank,
					'tanggal' => $tglcicilan,
					'pemasukan' => ($angs->pokok + $angs->jasa),
					'pengeluaran' => '0',
					'deskripsi' => $ket,
					'keterangan' => $mitra->nama_peminjam,
					'updated' => $this->session->userdata('nama_lengkap'),
					'tglUpdate' => date( 'Y-m-d ', time () ),
					'nobukti' => $nobukti,
					'tot_pemasukan' => '0',
					'tot_pengeluaran' => '0',
				]);

				$this->mitra_model->insertOpex([
					'id_akun' => '403010100',
					'tanggal' => $tglcicilan,
					'pemasukan' => '0',
					'pengeluaran' => $angs->jasa,
					'deskripsi' => $ket,
					'keterangan' => $mitra->nama_peminjam,
					'updated' => $this->session->userdata('nama_lengkap'),
					'tglUpdate' => date( 'Y-m-d ', time () ),
					'nobukti' => $nobukti,
					'tot_pemasukan' => '0',
					'tot_pengeluaran' => '0',
				]);

				if ($sektorUsaha == 'Sektor Industri') {
					$this->mitra_model->insertOpex([
						'id_akun' => '101060201',
						'tanggal' => $tglcicilan,
						'pemasukan' => '0',
						'pengeluaran' => $angs->pokok,
						'deskripsi' => $ket,
						'keterangan' => $mitra->nama_peminjam,
						'updated' => $this->session->userdata('nama_lengkap'),
						'tglUpdate' => date( 'Y-m-d ', time () ),
						'nobukti' => $nobukti,
						'tot_pemasukan' => '0',
						'tot_pengeluaran' => '0',
					]);
				}
				if ($sektorUsaha=='Sektor Perdagangan') {
					$this->mitra_model->insertOpex([
						'id_akun' => '101060202',
						'tanggal' => $tglcicilan,
						'pemasukan' => '0',
						'pengeluaran' => $angs->pokok,
						'deskripsi' => $ket,
						'keterangan' => $mitra->nama_peminjam,
						'updated' => $this->session->userdata('nama_lengkap'),
						'tglUpdate' => date( 'Y-m-d ', time () ),
						'nobukti' => $nobukti,
						'tot_pemasukan' => '0',
						'tot_pengeluaran' => '0',
					]);
				}

				if ($sektorUsaha=='Sektor Pertanian') {
					$this->mitra_model->insertOpex([
						'id_akun' => '101060203',
						'tanggal' => $tglcicilan,
						'pemasukan' => '0',
						'pengeluaran' => $angs->pokok,
						'deskripsi' => $ket,
						'keterangan' => $mitra->nama_peminjam,
						'updated' => $this->session->userdata('nama_lengkap'),
						'tglUpdate' => date( 'Y-m-d ', time () ),
						'nobukti' => $nobukti,
						'tot_pemasukan' => '0',
						'tot_pengeluaran' => '0',
					]);
				}

				if ($sektorUsaha=='Sektor Perkebunan') {
					$this->mitra_model->insertOpex([
						'id_akun' => '101060204',
						'tanggal' => $tglcicilan,
						'pemasukan' => '0',
						'pengeluaran' => $angs->pokok,
						'deskripsi' => $ket,
						'keterangan' => $mitra->nama_peminjam,
						'updated' => $this->session->userdata('nama_lengkap'),
						'tglUpdate' => date( 'Y-m-d ', time () ),
						'nobukti' => $nobukti,
						'tot_pemasukan' => '0',
						'tot_pengeluaran' => '0',
					]);
				}

				if($sektorUsaha=='Sektor Perikanan'){
					$this->mitra_model->insertOpex([
						'id_akun' => '101060205',
						'tanggal' => $tglcicilan,
						'pemasukan' => '0',
						'pengeluaran' => $angs->pokok,
						'deskripsi' => $ket,
						'keterangan' => $mitra->nama_peminjam,
						'updated' => $this->session->userdata('nama_lengkap'),
						'tglUpdate' => date( 'Y-m-d ', time () ),
						'nobukti' => $nobukti,
						'tot_pemasukan' => '0',
						'tot_pengeluaran' => '0',
					]);
				}

				if($sektorUsaha=='Sektor Peternakan'){
					$this->mitra_model->insertOpex([
						'id_akun' => '101060206',
						'tanggal' => $tglcicilan,
						'pemasukan' => '0',
						'pengeluaran' => $angs->pokok,
						'deskripsi' => $ket,
						'keterangan' => $mitra->nama_peminjam,
						'updated' => $this->session->userdata('nama_lengkap'),
						'tglUpdate' => date( 'Y-m-d ', time () ),
						'nobukti' => $nobukti,
						'tot_pemasukan' => '0',
						'tot_pengeluaran' => '0',
					]);
				}

				if ($sektorUsaha=='Sektor Jasa') {
					$this->mitra_model->insertOpex([
						'id_akun' => '101060207',
						'tanggal' => $tglcicilan,
						'pemasukan' => '0',
						'pengeluaran' => $angs->pokok,
						'deskripsi' => $ket,
						'keterangan' => $mitra->nama_peminjam,
						'updated' => $this->session->userdata('nama_lengkap'),
						'tglUpdate' => date( 'Y-m-d ', time () ),
						'nobukti' => $nobukti,
						'tot_pemasukan' => '0',
						'tot_pengeluaran' => '0',
					]);
				}

				if ($sektorUsaha=='Sektor Lain-lain') {
					$this->mitra_model->insertOpex([
						'id_akun' => '101060208',
						'tanggal' => $tglcicilan,
						'pemasukan' => '0',
						'pengeluaran' => $angs->pokok,
						'deskripsi' => $ket,
						'keterangan' => $mitra->nama_peminjam,
						'updated' => $this->session->userdata('nama_lengkap'),
						'tglUpdate' => date( 'Y-m-d ', time () ),
						'nobukti' => $nobukti,
						'tot_pemasukan' => '0',
						'tot_pengeluaran' => '0',
					]);
				}
			}
		}

		redirect(base_url('admin/mitra/cicilan/'.$no_kontrak));
	}

	public function detail($no_kontrak){
		$mitra = $this->mitra_model->getMitraKontrak($no_kontrak);

		$this->data['title'] = 'Detail Mitra';
		$this->data['mitra'] = $mitra;

		$this->template->load('mitra/detail', $this->data);
	}

	public function cetakcicilan($nokontrak){
		$mitra = $this->mitra_model->getMitraKontrak($nokontrak);
		$angsuran = $this->mitra_model->getOpexCicilanMitra($nokontrak);
		$this->load->view('mitra/cetak_cicilan', compact('mitra', 'angsuran'));
	}

	public function createExcel() {
		$fileName = 'kartu-piutang-' . date('Y') .'.xlsx';  

		$cicilanOpex = $this->mitra_model->getOpexCicilan();
		$spreadsheet = new Spreadsheet();
		$bulan =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));

		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(15);
		$sheet->getColumnDimension('C')->setWidth(15);
		$sheet->getColumnDimension('D')->setWidth(15);
		$sheet->getColumnDimension('E')->setWidth(15);
		$sheet->getColumnDimension('F')->setWidth(15);

		$sheet->mergeCells('A2:F2');
		$sheet->getStyle('A2:F2')->getFont()->setBold(true);
		$sheet->getStyle('A2:F2')->getAlignment()->setHorizontal('center');

		$sheet->setCellValue('A2', 'KARTU PIUTANG');
		$sheet->setCellValue('B3', 'Data Per '.$bulan);

		$sheet->setCellValue('B5', 'No ID :');
		$sheet->setCellValue('B6', 'Nama :');
		$sheet->setCellValue('B7', 'Tanggal Kontrak :');
		$sheet->setCellValue('B8', 'Cicilan/Bulan :');
		$sheet->setCellValue('B9', 'Jumlah Pinjaman :');
		$sheet->setCellValue('E5', 'Kolektibilitas :');
		$sheet->setCellValue('E6', 'Jasa :');
		$sheet->setCellValue('E7', 'Jatuh Tempo :');
		$sheet->setCellValue('E8', 'Pinjaman Pokok :');
		$sheet->setCellValue('E9', 'Pinjaman Jasa :');
		$sheet->setCellValue('A11', 'No');
		$sheet->setCellValue('B11', 'Taanggal');
		$sheet->setCellValue('C11', 'Pokok');
		$sheet->setCellValue('D11', 'Jasa');
		$sheet->setCellValue('E11', 'Jumlah');
		$sheet->setCellValue('F11', 'Saldo');

		// foreach($this->mitra_model->getOpexCicilan() as $cicilanOpex){
		// 	if($no_kontrak < 10){
		// 		$no_bukti = $cicilanOpex->nobukti;
		// 		$no_pk = substr($no_bukti, -3);
		// 	}
		// 	if($no_kontrak >= 10 AND $no_kontrak < 100){
		// 		$no_bukti = $cicilanOpex->nobukti;
		// 		$no_pk = substr($no_bukti, -4);
		// 	}
		// 	if($no_kontrak >= 100 AND $no_kontrak < 1000){
		// 		$no_bukti = $cicilanOpex->nobukti;
		// 		$no_pk = substr($no_bukti, -5);
		// 	}
		// 	if($no_kontrak >= 1000 AND $no_kontrak < 10000){
		// 		$no_bukti = $cicilanOpex->nobukti;
		// 		$no_pk = substr($no_bukti, -6);
		// 	}

		// }

		$writer = new Xlsx($spreadsheet);
		$writer->save("storage/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/storage/".$fileName);         
    }

	public function cetak_surat($nokontrak){
		$document = file_get_contents("assets\media\surat_peringatan.rtf");
		$mitra = $this->mitra_model->getMitra($nokontrak);

		$document = str_replace("#NAMA", $mitra->nama_peminjam, $document);
		$document = str_replace("#TEMPAT", $mitra->alamat_rumah, $document);
		$document = str_replace("#TANGGAL", date('d-m-Y'), $document);
		$document = str_replace("#NOKONTRAK", $mitra->nokontrak, $document);
		$document = str_replace("##TGLKONTRAK", $mitra->tglkontrak, $document);
		$document = str_replace("#PINJAMAN", number_format($mitra->pinjjumlah), $document);
		$document = str_replace("#SISA", number_format($mitra->angjumlah), $document);
		$document = str_replace("#BAYAR", number_format($mitra->saldojumlah), $document);

		header("Content-type: application/msword");
        header("Content-disposition: inline; filename=surat-peringatan-" . $nokontrak . ".doc");
        header("Content-length: " . strlen($document));
        echo $document;
	}
}