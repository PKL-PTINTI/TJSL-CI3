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
		$tanggalakhir = date('Y-m-01');

		$KasBankYgDiBatasiPenggunaannyaa = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '103070000'")->row()->saldoopex;
		$JasaAdmPinjaman = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '403010100'")->row()->saldoopex;
		$AktivaTetapHargaPerolehan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '102010101' OR id_akun = '102010201')")->row()->saldoopex;
		$PengembalianKelebihanAngsuran = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '412020500'")->row()->saldoopex;
		$BebanUpahTenagakerja = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '406010000'")->row()->saldoopex;
		$BebanPembinaan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '405010100' OR id_akun = '405020100' OR id_akun = '405030100')")->row()->saldoopex;

		$pengembalianPinjamanMB = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '101060201' OR id_akun = '101060202' OR id_akun = '101060203' OR id_akun = '101060204' OR id_akun = '101060205'OR id_akun = '101060206' OR id_akun = '101060207' OR id_akun = '101060208')")->row()->saldoopex;
		$PiutangMitraBinaanPinjaman = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '101060101' OR id_akun = '101060102' OR id_akun = '101060103' OR id_akun = '101060104' OR id_akun = '101060105'OR id_akun = '101060106' OR id_akun = '101060107' OR id_akun = '101060108')")->row()->saldoopex;
		
		$PiutangMitraBinaanPinjamanindustri = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '101060101'")->row()->saldoopex;
		$PiutangMitraBinaanPinjamanPerdagangan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '101060102'")->row()->saldoopex;
		$PiutangMitraBinaanPinjamanPertanian = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '101060103'")->row()->saldoopex;
		$PiutangMitraBinaanPinjamanPerkebunan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '101060104'")->row()->saldoopex;
		$PiutangMitraBinaanPinjamanPerikanan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '101060105'")->row()->saldoopex;
		$PiutangMitraBinaanPinjamanPeternakan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '101060106'")->row()->saldoopex;
		$PiutangMitraBinaanPinjamanJasa = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '101060107'")->row()->saldoopex;
		$PiutangMitraBinaanPinjamanLain = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '101060108'")->row()->saldoopex;
		
		$PendapatanJasaAdministrasiPinjamanProgramKemitraan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '403010100'")->row()->saldoopex;
		$AktivaLancarPiutangBunga = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '403020100'")->row()->saldoopex;
		$PendapatanJasaGiroBL = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '403020101'")->row()->saldoopex;
		$PendapatanJasaGiroBUMNPeduli = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '403020102'")->row()->saldoopex;
		
		$PendapatanJasaGiro = ($PendapatanJasaGiroBL + $PendapatanJasaGiroBUMNPeduli + $AktivaLancarPiutangBunga);
		$PendapatanLainlain = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '403030100' OR id_akun = '403030200' OR id_akun = '403030300' OR id_akun = '403030400')")->row()->saldoopex;
		$PendapatanLainPiutangHapusBuku = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '403030100'")->row()->saldoopex;
		$PendapatanLainPenyisihanPiutang = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '403030200'")->row()->saldoopex;
		$PendapatanLainLainSelisihKasBankLain = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '403030300' OR id_akun = '403030400')")->row()->saldoopex;
		
		$PenyisihanAlokasiDanaBUMNPeduli = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '401030000'")->row()->saldoopex;
		$PenyisihanANTTBerakhirPemenuhanProgram = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '401010000'")->row()->saldoopex;
		$penyisihanANTTberakhirwaktu = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND id_akun = '401020000'")->row()->saldoopex;

		$DanaPembinaanKemitraan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun =  '404010101' OR id_akun =  '404010102' OR id_akun =  '404010103' OR id_akun =  '404010104' OR id_akun =  '404010105' OR id_akun =  '404010106' OR id_akun =  '404010107' OR id_akun =  '404010108' OR id_akun =  '404010201' OR id_akun =  '404010202' OR id_akun =  '404010203' OR id_akun =  '404010204' OR id_akun =  '404010205' OR id_akun =  '404010206' OR id_akun =  '404010207' OR id_akun =  '404010208' OR id_akun =  '404010301' OR id_akun =  '404010302' OR id_akun =  '404010303' OR id_akun =  '404010304' OR id_akun =  '404010305' OR id_akun =  '404010306' OR id_akun =  '404010307' OR id_akun =  '404010308')")->row()->saldoopex;
		$DanaBinaLingkungan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '404020100' OR id_akun =  '404020200' OR id_akun =  '404020300' OR id_akun =  '404020400' OR id_akun =  '404020500' OR id_akun =  '404020600' OR id_akun =  '404020700' OR id_akun =  '404020800' OR id_akun =  '404020900' OR id_akun =  '404021000')")->row()->saldoopex;
		
		$BebanAdmdanUmum = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '407010000' OR id_akun = '407020000' OR id_akun = '407030000')")->row()->saldoopex;
		$BebanAdmDanUmumBL = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '407020000' OR id_akun = '407030000')")->row()->saldoopex;

		$BebanPenyusutanAktivaTetapProgramKemitraan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '410010000')")->row()->saldoopex;
		$BebanPemeliharaanProgramKemitraan = $this->db->query("SELECT SUM(pengeluaran - pemasukan) AS saldoopex FROM opex WHERE (tanggal >= '$tanggalawal' AND tanggal < '$tanggalakhir') AND (id_akun = '408010000')")->row()->saldoopex;
		// var_dump([$pengembalianPinjamanMB]);
	}
}
