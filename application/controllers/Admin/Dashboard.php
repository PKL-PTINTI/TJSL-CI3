<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();

		if(!$this->session->userdata('username')){
			redirect(base_url('auth'));
		}
	}

	public function index()
	{
		$data = [
			'title' => 'Dashboard',
			'countMitra' => $this->db->count_all('mitra'),
			'countMitraNormal' => $this->db->where('tdkbermasalah', 'normal', 'Normal', 'NORMAL')->count_all_results('mitra'),
			'countMitraBermasalah' => $this->db->where('tdkbermasalah', 'masalah', 'Masalah', 'MASALAH')->count_all_results('mitra'),
			'countMitraKhusus' => $this->db->where('tdkbermasalah', 'khusus', 'Khusus', 'KHUSUS')->count_all_results('mitra'),
			'countMitraWo' => $this->db->where('tdkbermasalah', 'wo', 'Wo', 'WO')->count_all_results('mitra'),
		];
		
		$this->template->load('dashboard/index', $data);
	}

	public function HitungLaporanData(){
		$AktivaTetapHargaPerolehanInventarisKantor = 40478000; //fixed  
		$akumPenyusutanInvPeralatan = -40478000; //fixed
		$JumlahAsetTetapBersih = 0; //fixed

		$totnilsaldopokok_bermasalah = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND (tdkbermasalah = 'masalah' OR tdkbermasalah = 'Masalah' OR tdkbermasalah = 'MASALAH')")->row()->saldopokok;
		$totsektorindustribermasalah = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND sektorUsaha = 'Sektor Industri' AND (tdkbermasalah = 'masalah' OR tdkbermasalah = 'Masalah' OR tdkbermasalah = 'MASALAH')")->row()->saldopokok;
		$totsektorperdaganganbermasalah = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND sektorUsaha = 'Sektor Perdagangan' AND (tdkbermasalah = 'masalah' OR tdkbermasalah = 'Masalah' OR tdkbermasalah = 'MASALAH')")->row()->saldopokok;
		$totsektorpertanianbermasalah = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND sektorUsaha = 'Sektor Pertanian' AND (tdkbermasalah = 'masalah' OR tdkbermasalah = 'Masalah' OR tdkbermasalah = 'MASALAH')")->row()->saldopokok;
		$totsektorperkebunanbermasalah = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND sektorUsaha = 'Sektor Perkebunan' AND (tdkbermasalah = 'masalah' OR tdkbermasalah = 'Masalah' OR tdkbermasalah = 'MASALAH')")->row()->saldopokok;
		$totsektorperikananbermasalah = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND sektorUsaha = 'Sektor Perikanan' AND (tdkbermasalah = 'masalah' OR tdkbermasalah = 'Masalah' OR tdkbermasalah = 'MASALAH')")->row()->saldopokok;
		$totsektorpeternakanbermasalah = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND sektorUsaha = 'Sektor Peternakan' AND (tdkbermasalah = 'masalah' OR tdkbermasalah = 'Masalah' OR tdkbermasalah = 'MASALAH')")->row()->saldopokok;
		$totsektorjasabermasalah = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND sektorUsaha = 'Sektor Jasa' AND (tdkbermasalah = 'masalah' OR tdkbermasalah = 'Masalah' OR tdkbermasalah = 'MASALAH')")->row()->saldopokok;
		$totsektorlainlainbermasalah = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND sektorUsaha = 'Sektor Lain-lain' AND (tdkbermasalah = 'masalah' OR tdkbermasalah = 'Masalah' OR tdkbermasalah = 'MASALAH')")->row()->saldopokok;


		$this->db->query("UPDATE neraca SET ags22='$totnilsaldopokok_bermasalah' WHERE id='11'");
		$alokPenyisihanPiutangbermasalah = 0 - $totnilsaldopokok_bermasalah;
		$this->db->query("UPDATE neraca SET ags22='$alokPenyisihanPiutangbermasalah' WHERE id='12'");

		$totalsaldopokoktdkbermasalah = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND (tdkbermasalah = 'normal' OR tdkbermasalah = 'Normal' OR tdkbermasalah = 'NORMAL')")->row()->saldopokok;
		$totallancar = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND (tdkbermasalah = 'normal' OR tdkbermasalah = 'Normal' OR tdkbermasalah = 'NORMAL') AND saldopokok > '0' AND (kolektibilitas = 'lancar' OR kolektibilitas = 'Lancar' OR kolektibilitas = 'LANCAR')")->row()->saldopokok;
		$totalkuranglancar = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND (tdkbermasalah = 'normal' OR tdkbermasalah = 'Normal' OR tdkbermasalah = 'NORMAL') AND saldopokok > '0' AND (kolektibilitas = 'kurang lancar' OR kolektibilitas = 'Kurang Lancar' OR kolektibilitas = 'KURANG LANCAR')")->row()->saldopokok;
		$totaldiragukan = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND (tdkbermasalah = 'normal' OR tdkbermasalah = 'Normal' OR tdkbermasalah = 'NORMAL') AND saldopokok > '0' AND (kolektibilitas = 'diragukan' OR kolektibilitas = 'Diragukan' OR kolektibilitas = 'DIRAGUKAN')")->row()->saldopokok;
		$totalmacet = $this->db->query("SELECT SUM(saldopokok) AS saldopokok FROM mitra WHERE saldopokok > '0' AND (tdkbermasalah = 'normal' OR tdkbermasalah = 'Normal' OR tdkbermasalah = 'NORMAL') AND saldopokok > '0' AND (kolektibilitas = 'macet' OR kolektibilitas = 'Macet' OR kolektibilitas = 'MACET')")->row()->saldopokok;

		$tingkatpengembalianpinjamanMBLancar = $totallancar;
		$tingkatpengembalianpinjamanMBKurangLancar = $totalkuranglancar;
		$tingkatpengembalianpinjamanMBDiragukan = $totaldiragukan;
		$tingkatpengembalianpinjamanMBMacet = $totalmacet;

		$tanggalawal = date('Y-m-01', mktime(0, 0, 0, date('m')-1, date('d'), date('y')));
		$tanggalakhir = date('Y-m-t', mktime(0, 0, 0, date('m')-1, date('d'), date('y')));

		// $KasBankYgDiBatasiPenggunaannyaa = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex WHERE tanggal >=  ")->row()->saldoopex;

		var_dump([$tanggalawal, $tanggalakhir]);
	}
}
