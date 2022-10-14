<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerhitunganLaporan extends CI_Controller {

    public function __construct(){
        parent::__construct();
        ini_set('memory_limit','512M');
        $this->load->model('MitraModel', 'mitra_model');
        $this->load->model('JurnalModel', 'jurnal_model');
        $this->load->model('SaldoModel', 'saldo_model');
    }

	public function exceute(){
		$mitra = $this->db->query("SELECT * FROM mitra ORDER BY tglkontrak ASC")->result_array();
		$bulansekarang = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		$bulansebelumnya = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-2, date("d"), date("Y"))));
		$desTahunLalu = 'des' . strval(date('y') - 1);

        $totnilsaldopokok_bermasalah = 0; $totsektorindustribermasalah = 0; $totsektorindustribermasalah = 0; $totsektorperdaganganbermasalah = 0; $totsektorpertanianbermasalah = 0; $totsektorperkebunanbermasalah = 0; $totsektorperikananbermasalah = 0; $totsektorpeternakanbermasalah = 0; $totsektorjasabermasalah = 0; $totsektorlainlainbermasalah = 0;

		foreach ($mitra as $key => $value) {
            if (($value['tdkbermasalah'] == 'masalah' OR $value['tdkbermasalah'] == 'MASALAH' OR $value['tdkbermasalah'] == 'Masalah') AND $value['saldopokok'] > '0') {
                $totnilsaldopokok_bermasalah += $value['saldopokok'];

                if($value['sektorUsaha']  ==  'Sektor Industri'){
                    $totsektorindustribermasalah  +=  $value['saldopokok'];
                }
                if($value['sektorUsaha']  ==  'Sektor Perdagangan'){
                    $totsektorperdaganganbermasalah  +=  $value['saldopokok'];
                }
                if($value['sektorUsaha']  ==  'Sektor Pertanian'){
                    $totsektorpertanianbermasalah  +=  $value['saldopokok'];
                }
                if($value['sektorUsaha']  ==  'Sektor Perkebunan'){
                    $totsektorperkebunanbermasalah  +=  $value['saldopokok'];
                }
                if($value['sektorUsaha']  ==  'Sektor Perikanan'){
                    $totsektorperikananbermasalah  +=  $value['saldopokok'];
                }
                if($value['sektorUsaha']  ==  'Sektor Peternakan'){
                    $totsektorpeternakanbermasalah  +=  $value['saldopokok'];
                }
                if($value['sektorUsaha']  ==  'Sektor Jasa'){
                    $totsektorjasabermasalah  +=  $value['saldopokok'];
                }
                if($value['sektorUsaha']  ==  'Sektor Lain-lain'){
                    $totsektorlainlainbermasalah  +=  $value['saldopokok'];
                }
            }
		}

        $this->db->query("UPDATE neraca SET $bulansekarang='$totnilsaldopokok_bermasalah' WHERE id='11'");
        $alokPenyisihanPiutangbermasalah = 0 - $totnilsaldopokok_bermasalah;
        $this->db->query("UPDATE neraca SET $bulansekarang='$alokPenyisihanPiutangbermasalah' WHERE id='12'");

        $totalsaldopokoktdkbermasalah = 0; $totallancar = 0; $totalkuranglancar = 0; $totaldiragukan = 0; $totalmacet = 0;
		$totsektorindustri = 0; $totindustriLancar = 0; $totindustriKurangLancar = 0; $totindustriDiragukan = 0; $totindustriMacet = 0;
		$totsektorperdagangan = 0; $totperdaganganLancar = 0; $totperdaganganKurangLancar = 0; $totperdaganganDiragukan = 0; $totperdaganganMacet = 0;
		$totsektorpertanian = 0; $totpertanianLancar = 0; $totpertanianKurangLancar = 0; $totpertanianDiragukan = 0; $totpertanianMacet = 0;
		$totsektorperkebunan = 0; $totperkebunanLancar = 0; $totperkebunanKurangLancar = 0; $totperkebunanDiragukan = 0; $totperkebunanMacet = 0;
		$totsektorperikanan = 0; $totperikananLancar = 0; $totperikananKurangLancar = 0; $totperikananDiragukan = 0; $totperikananMacet = 0;
		$totsektorpeternakan = 0; $totpeternakanLancar = 0; $totpeternakanKurangLancar = 0; $totpeternakanDiragukan = 0; $totpeternakanMacet = 0;
		$totsektorjasa = 0; $totjasaLancar = 0; $totjasaKurangLancar = 0; $totjasaDiragukan = 0; $totjasaMacet = 0;
		$totsektorlainlain = 0; $totlainlainLancar = 0; $totlainlainKurangLancar = 0; $totlainlainDiragukan = 0; $totlainlainMacet = 0;

        $AktivaTetapHargaPerolehanInventarisKantor = 40478000;  
		$akumPenyusutanInvPeralatan =- 40478000;
		$JumlahAsetTetapBersih = $BebanAdmdanUmumBL = 0; 
        $asetNetoTerikat = 0;
        $tingkatpengembalianpinjamanMBtotal = 0;
        $kasDanSetaraKasPadaAwalTahun = 0;
        $BebanAdmDanUmum = 0;
        $BebanAdmDanUmumklr = 0;
        $BebanAdmDanUmummsk = 0;
        $BebanAdmdanUmumklr = 0;

		$KasBankYgDiBatasiPenggunaannyaklr = 0; $KasBankYgDiBatasiPenggunaannyamsk = 0; $KasBankYgDiBatasiPenggunaannya = 0; $JasaAdmPinjamanklr = 0; $JasaAdmPinjamanmsk = 0; $JasaAdmPinjaman = 0; $AktivaTetapHargaPerolehanklr = 0; $AktivaTetapHargaPerolehanmsk = 0; $AktivaTetapHargaPerolehan = 0; $PengembalianKelebihanAngsuranklr = 0; $PengembalianKelebihanAngsuranmsk = 0; $PengembalianKelebihanAngsuran = 0; $BebanUpahTenagakerjaklr = 0; $BebanUpahTenagakerjamsk = 0;
		$BebanUpahTenagakerja = 0; $BebanPembinaanmsk = 0; $BebanPembinaanklr = 0; $BebanPembinaan = 0; $pengembalianPinjamanMBklr = 0; $pengembalianPinjamanMBmsk = 0; $pengembalianPinjamanMB = 0; $pengembalianPinjamanMBbermasalahklr = 0; $pengembalianPinjamanMBbermasalahmsk = 0; $pengembalianPinjamanMBbermasalah = 0; $PiutangMitraBinaanPinjamanmsk = 0; $PiutangMitraBinaanPinjamanklr = 0; $PiutangMitraBinaanPinjaman = 0; $PiutangMitraBinaanPinjamanindustrimsk = 0;
		$PiutangMitraBinaanPinjamanIndustriklr = 0; $PiutangMitraBinaanPinjamanindustri = 0; $PiutangMitraBinaanPinjamanPerdaganganmsk = 0; $PiutangMitraBinaanPinjamanPerdaganganklr = 0; $PiutangMitraBinaanPinjamanPerdagangan = 0; $PiutangMitraBinaanPinjamanPertanianmsk = 0; $PiutangMitraBinaanPinjamanPertanianklr = 0; $PiutangMitraBinaanPinjamanPertanian = 0; $PiutangMitraBinaanPinjamanPerkebunanmsk = 0; $PiutangMitraBinaanPinjamanPerkebunanklr = 0; $PiutangMitraBinaanPinjamanPerkebunan = 0; $PiutangMitraBinaanPinjamanPerikananmsk = 0;
		$PiutangMitraBinaanPinjamanPerikananklr = 0; $PiutangMitraBinaanPinjamanPerikanan = 0; $PiutangMitraBinaanPinjamanPeternakanmsk = 0; $PiutangMitraBinaanPinjamanPeternakanklr = 0; $PiutangMitraBinaanPinjamanPeternakan = 0; $PiutangMitraBinaanPinjamanJasamsk = 0; $PiutangMitraBinaanPinjamanJasaklr = 0; $PiutangMitraBinaanPinjamanJasa = 0; $PiutangMitraBinaanPinjamanLainmsk = 0; $PiutangMitraBinaanPinjamanLainklr = 0; $PiutangMitraBinaanPinjamanLain = 0;
		$PendapatanJasaAdministrasiPinjamanProgramKemitraanklr = 0; $PendapatanJasaAdministrasiPinjamanProgramKemitraanmsk = 0; $PendapatanJasaAdministrasiPinjamanProgramKemitraan = 0; $AktivaLancarPiutangBungaklr = 0; $AktivaLancarPiutangBungamsk = 0; $AktivaLancarPiutangBunga = 0; $PendapatanJasaGiroBLklr = 0; $PendapatanJasaGiroBLmsk = 0; $PendapatanJasaGiroBL = 0; $PendapatanJasaGiroBUMNPeduliklr = 0; $PendapatanJasaGiroBUMNPedulimsk = 0; $PendapatanJasaGiroBUMNPeduli = 0; $PendapatanJasaGiro = 0;
		$PendapatanLainlainklr = 0; $PendapatanLainlainmsk = 0; $PendapatanLainlain = 0; $PendapatanLainPiutangHapusBukuklr = 0; $PendapatanLainPiutangHapusBukumsk = 0; $PendapatanLainPiutangHapusBuku = 0; $PendapatanLainPenyisihanPiutangklr = 0; $PendapatanLainPenyisihanPiutangmsk = 0; $PendapatanLainPenyisihanPiutang = 0; $PendapatanLainLainSelisihKasBankLainklr = 0; $PendapatanLainLainSelisihKasBankLainmsk = 0; $PendapatanLainLainSelisihKasBankLain = 0; $PendapatanLainLainLainklr = 0; $PendapatanLainLainLainmsk = 0; $PendapatanLainLainLain = 0; $PenyisihanAlokasiDanaBUMNPeduliklr = 0;
		$PenyisihanAlokasiDanaBUMNPedulimsk = 0; $PenyisihanAlokasiDanaBUMNPeduli = 0; $PenyisihanANTTBerakhirPemenuhanProgramklr = 0; $PenyisihanANTTBerakhirPemenuhanProgrammsk = 0; $PenyisihanANTTBerakhirPemenuhanProgram = 0; $penyisihanANTTberakhirwaktuklr = 0; $penyisihanANTTberakhirwaktumsk = 0; $penyisihanANTTberakhirwaktu = 0; $DanaPembinaanKemitraanklr = 0; $DanaPembinaanKemitraanmsk = 0; $DanaPembinaanKemitraan = 0; $DanaBinaLingkunganklr = 0; $DanaBinaLingkunganmsk = 0;
		$DanaBinaLingkungan = 0; $BebanAdmDanUmumklr = 0; $BebanAdmdanUmummsk = 0; $BebanAdmDanUmum = 0; $BebanAdmDanUmumPKklr = 0; $BebanAdmDanUmumPKmsk = 0; $BebanAdmDanUmumPK = 0; $BebanAdmDanUmumBLklr = 0; $BebanAdmDanUmumBLmsk = 0; $BebanAdmDanUmumBL = 0; $BebanAdmDanUmumBPeduliklr = 0; $BebanAdmDanUmumBPedulimsk = 0; $BebanAdmDanUmumBPeduli = 0; $BebanPenyusutanAktivaTetapProgramKemitraanklr = 0; $BebanPenyusutanAktivaTetapProgramKemitraanmsk = 0;
		$BebanPenyusutanAktivaTetapProgramKemitraan = 0; $BebanPemeliharaanProgramKemitraanklr = 0; $BebanPemeliharaanProgramKemitraanmsk = 0; $BebanPemeliharaanProgramKemitraan = 0; $BebanPenyisihanPiutangSektorIndustriSektorIndustriklr = 0; $BebanPenyisihanPiutangSektorIndustriSektorIndustrimsk = 0; $BebanPenyisihanPiutangSektorIndustriSektorIndustri = 0; $BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganklr = 0; $BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganmsk = 0; $BebanPenyisihanPiutangSektorPerdaganganSektorPerdagangan = 0; $BebanPenyisihanPiutangSektorPertanianSektorPertanianklr = 0; $BebanPenyisihanPiutangSektorPertanianSektorPertanianmsk = 0; $BebanPenyisihanPiutangSektorPertanianSektorPertanian = 0; $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanklr = 0; $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanmsk = 0;
		$BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunan = 0; $BebanPenyisihanPiutangSektorPerikananSektorPerikananklr = 0; $BebanPenyisihanPiutangSektorPerikananSektorPerikananmsk = 0; $BebanPenyisihanPiutangSektorPerikananSektorPerikanan = 0; $BebanPenyisihanPiutangSektorPeternakanSektorPeternakanklr = 0; $BebanPenyisihanPiutangSektorPeternakanSektorPeternakanmsk = 0; $BebanPenyisihanPiutangSektorPeternakanSektorPeternakan = 0; $BebanPenyisihanPiutangSektorJasaSektorJasaklr = 0; $BebanPenyisihanPiutangSektorJasaSektorJasamsk = 0; $BebanPenyisihanPiutangSektorJasaSektorJasa = 0; $BebanPenyisihanPiutangSektorLainlainSektorLainlainklr = 0; $BebanPenyisihanPiutangSektorLainlainSektorLainlainmsk = 0; $BebanPenyisihanPiutangSektorLainlainSektorLainlain = 0; $BebanLainlainProgramKemitraanklr = 0;
		$BebanLainlainProgramKemitraanmsk = 0; $BebanLainlainProgramKemitraan = 0; $ANTterbebaskanmsk = 0; $ANTterbebaskanklr = 0; $ANTterbebaskan = 0; $ANTPenyisihanBUMNPedulimsk = 0; $ANTPenyisihanBUMNPeduliklr = 0; $ANTPenyisihanBUMNPeduli = 0; $AktivaLancarAlokasiPenyisihanPiutangMitraBinaanmsk = 0; $AktivaLancarAlokasiPenyisihanPiutangMitraBinaanklr = 0; $AktivaLancarAlokasiPenyisihanPiutangMitraBinaan = 0; $AktivaTetapAkumulasiPenyusutanInventarisKant = 0; $KelebihanPembayaranAngsuranklr = 0; $KelebihanPembayaranAngsuranmsk = 0; $KelebihanPembayaranAngsuran = 0; $PengembaliankelebihanAngsuranklr = 0; $PengembaliankelebihanAngsuranmsk = 0; $selisihPengembaliankelebihanAngsuran = 0;
		$AngsuranBelumTeridentifikasimsk = 0; $AngsuranBelumTeridentifikasiklr = 0; $AngsuranBelumTeridentifikasi = 0; $PendapatanPendapatanLainlainLainlainklr = 0; $PendapatanPendapatanLainlainLainlainmsk = 0; $PendapatanPendapatanLainlainLainlain = 0; $KewajibanjangkaPanjangProgramKemitraanmsk = 0; $KewajibanjangkaPanjangProgramKemitraanklr = 0; $KewajibanjangkaPanjangProgramKemitraan = 0; $AktivaLancarPersediaanProgramKemitraanklr = 0; $AktivaLancarPersediaanProgramKemitraanmsk = 0; $AktivaLancarPersediaanProgramKemitraan = 0; $ANTterbebaskanmsk = 0;
		$ANTterbebaskanklr = 0; $ANTterbebaskan = 0; $PenyisihanANTTBerakhirPemenuhanProgrammsk = 0; $PenyisihanANTTBerakhirPemenuhanProgramklr = 0; $PenyisihanANTTBerakhirPemenuhanProgram = 0; $ANTTerbebaskanklr = 0; $ANTTerbebaskanmsk = 0; $ANTTerbebaskan = 0; $KewajibanJangkaPendekAngsuranBelumTeridentifikasi = 0; $PendapatanLainLainLainlain = 0;

        foreach($mitra as $key => $value){
            if(($value['tdkbermasalah']  ==  'normal' || $value['tdkbermasalah']  ==  'Normal' || $value['tdkbermasalah']  ==  'NORMAL') AND $value['saldopokok'] > '0' AND $value['kolektibilitas']!='LUNAS'){
                $totalsaldopokoktdkbermasalah += $value['saldopokok'];
                if($value['kolektibilitas']  ==  'lancar' OR $value['kolektibilitas']  ==  'Lancar' OR $value['kolektibilitas']  ==  'LANCAR'){
                    $totallancar += $value['saldopokok'] ;
                }
                if($value['kolektibilitas']  ==  'kurang lancar' OR $value['kolektibilitas']  ==  'Kurang Lancar' OR $value['kolektibilitas']  ==  'KURANG LANCAR'){
                    $totalkuranglancar += $value['saldopokok'] ;
                }
                if($value['kolektibilitas']  ==  'diragukan' OR $value['kolektibilitas']  ==  'Diragukan' OR $value['kolektibilitas']  ==  'DIRAGUKAN'){
                    $totaldiragukan += $value['saldopokok'] ;
                }
                if($value['kolektibilitas']  ==  'macet' OR $value['kolektibilitas']  ==  'Macet' OR $value['kolektibilitas']  ==  'MACET'){
                    $totalmacet += $value['saldopokok'] ;
                }
            }

            if(($value['tdkbermasalah']  ==  'normal' OR $value['tdkbermasalah']  ==  'Normal' OR $value['tdkbermasalah']  ==  'NORMAL')
            	AND $value['saldopokok'] > '0' AND ($value['sektorUsaha']  ==  'Sektor Industri' OR $value['sektorUsaha']  ==  'sektor industri') AND $value['kolektibilitas']!='LUNAS'){
   
                $totsektorindustri += $value['saldopokok'];
                if($value['kolektibilitas']  ==  'Kurang Lancar' OR $value['kolektibilitas']  ==  'kurang lancar'){
                    $totindustriKurangLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas']  ==  'Diragukan' OR $value['kolektibilitas']  ==  'diragukan' ){
                    $totindustriDiragukan += $value['saldojumlah'];
                }
                if($value['kolektibilitas']  ==  'Macet' OR $value['kolektibilitas']  ==  'macet' ){
                    $totindustriMacet += $value['saldojumlah'];
                }       
            }

            if(($value['tdkbermasalah'] == 'normal' OR $value['tdkbermasalah'] == 'Normal' OR $value['tdkbermasalah'] == 'NORMAL')
                AND $value['saldopokok']>'0' AND ($value['sektorUsaha'] == 'Sektor Perdagangan' OR $value['sektorUsaha'] == 'sektor perdagangan') AND $value['kolektibilitas']!='LUNAS'){
                
                $totsektorperdagangan += $value['saldopokok'];
                if($value['kolektibilitas'] == 'Lancar' OR  $value['kolektibilitas'] == 'lancar'){
                    $totperdaganganLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Kurang Lancar' OR  $value['kolektibilitas'] == 'kurang lancar'){
                    $totperdaganganKurangLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Diragukan' OR  $value['kolektibilitas'] == 'diragukan'){
                    $totperdaganganDiragukan += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Macet' OR $value['kolektibilitas'] == 'macet'){
                    $totperdaganganMacet += $value['saldojumlah'];
                }   
            }

            if(($value['tdkbermasalah'] == 'normal' OR $value['tdkbermasalah'] == 'Normal' OR $value['tdkbermasalah'] == 'NORMAL' )
                AND $value['saldopokok']>'0' AND ($value['sektorUsaha'] == 'Sektor Pertanian' OR $value['sektorUsaha'] == 'sektor pertanian') AND $value['kolektibilitas']!='LUNAS' ){

                $totsektorpertanian += $value['saldopokok'];
                if($value['kolektibilitas'] == 'Lancar' OR  $value['kolektibilitas'] == 'lancar'){
                    $totpertanianLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Kurang Lancar' OR $value['kolektibilitas'] == 'kurang lancar'){
                    $totpertanianKurangLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Diragukan' OR $value['kolektibilitas'] == 'diragukan'){
                    $totpertanianDiragukan += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Macet' OR $value['kolektibilitas'] == 'macet'){
                    $totpertanianMacet += $value['saldojumlah'];
                }       
            }

            if(($value['tdkbermasalah'] == 'normal' OR $value['tdkbermasalah'] == 'Normal' OR $value['tdkbermasalah'] == 'NORMAL' )
                AND $value['saldopokok']>'0' AND ($value['sektorUsaha'] == 'Sektor Perkebunan' OR $value['sektorUsaha'] == 'sektor perkebunan') AND $value['kolektibilitas']!='LUNAS' ){
                
                $totsektorperkebunan += $value['saldopokok'];
                if($value['kolektibilitas'] == 'Lancar' OR $value['kolektibilitas'] == 'lancar'){
                    $totperkebunanLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Kurang Lancar' OR $value['kolektibilitas'] == 'kurang lancar'){
                    $totperkebunanKurangLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Diragukan' OR  $value['kolektibilitas'] == 'diragukan'){
                    $totperkebunanDiragukan += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Macet' OR $value['kolektibilitas'] == 'macet'){
                    $totperkebunanMacet += $value['saldojumlah'];
                }     
            }

            if(($value['tdkbermasalah'] == 'normal' OR $value['tdkbermasalah'] == 'Normal' OR $value['tdkbermasalah'] == 'NORMAL' )
                AND $value['saldopokok']>'0' AND ($value['sektorUsaha'] == 'Sektor Perikanan' OR $value['sektorUsaha'] == 'sektor perikanan') AND $value['kolektibilitas']!='LUNAS' ){
   
                $totsektorperikanan += $value['saldopokok'];
                if($value['kolektibilitas'] == 'Lancar' OR $value['kolektibilitas'] == 'lancar'){
                    $totperikananLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Kurang Lancar' OR $value['kolektibilitas'] == 'kurang lancar'){
                    $totperikananKurangLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Diragukan' OR $value['kolektibilitas'] == 'diragukan'){
                    $totperikananDiragukan += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Macet' OR $value['kolektibilitas'] == 'macet'){
                    $totperikananMacet += $value['saldojumlah'];
                }                        
            }

            if(($value['tdkbermasalah'] == 'normal' OR $value['tdkbermasalah'] == 'Normal' OR $value['tdkbermasalah'] == 'NORMAL' )
                AND $value['saldopokok']>'0' AND ($value['sektorUsaha'] == 'Sektor Peternakan' OR $value['sektorUsaha'] == 'sektor peternakan') AND $value['kolektibilitas']!='LUNAS' ){
   
                $totsektorpeternakan += $value['saldopokok'];
                if($value['kolektibilitas'] == 'Lancar' OR $value['kolektibilitas'] == 'lancar' ){
                    $totpeternakanLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Kurang Lancar' OR $value['kolektibilitas'] == 'kurang lancar' ){
                    $totpeternakanKurangLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Diragukan' OR $value['kolektibilitas'] == 'diragukan' ){
                    $totpeternakanDiragukan += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Macet' OR $value['kolektibilitas'] == 'macet' ){
                    $totpeternakanMacet += $value['saldojumlah'];
                }       
            }

            if( ($value['tdkbermasalah'] == 'normal' OR $value['tdkbermasalah'] == 'Normal' OR $value['tdkbermasalah'] == 'NORMAL' )
                AND $value['saldopokok']>'0' AND ($value['sektorUsaha'] == 'Sektor Jasa' OR $value['sektorUsaha'] == 'sektor jasa') AND $value['kolektibilitas']!='LUNAS' ){
   
                $totsektorjasa += $value['saldopokok'];
                if($value['kolektibilitas'] == 'Lancar' OR $value['kolektibilitas'] == 'lancar' ){
                    $totjasaLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Kurang Lancar' OR $value['kolektibilitas'] == 'kurang lancar'){
                    $totjasaKurangLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Diragukan' OR $value['kolektibilitas'] == 'diragukan' ){
                    $totjasaDiragukan += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Macet'  OR $value['kolektibilitas'] == 'macet' ){
                    $totjasaMacet += $value['saldojumlah'];
                }
                        
            }

            if( ($value['tdkbermasalah'] == 'normal' OR $value['tdkbermasalah'] == 'Normal' OR $value['tdkbermasalah'] == 'NORMAL' )
                AND $value['saldopokok']>'0' AND ($value['sektorUsaha'] == 'Sektor Lain-lain' OR $value['sektorUsaha'] == 'sektor lain-lain') AND $value['kolektibilitas']!='LUNAS' ){

                $totsektorlainlain += $value['saldopokok'];
                if($value['kolektibilitas'] == 'Lancar'  OR $value['kolektibilitas'] == 'lancar' ){
                    $totlainlainLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Kurang Lancar' OR $value['kolektibilitas'] == 'kurang lancar' ){
                    $totlainlainKurangLancar += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Diragukan' OR $value['kolektibilitas'] == 'diragukan' ){
                    $totlainlainDiragukan += $value['saldojumlah'];
                }
                if($value['kolektibilitas'] == 'Macet' OR $value['kolektibilitas'] == 'macet' ){
                    $totlainlainMacet += $value['saldojumlah'];
                }
                        
            }
        }

        $tingkatpengembalianpinjamanMBLancar = $totallancar;
        $tingkatpengembalianpinjamanMBKurangLancar = $totalkuranglancar;
        $tingkatpengembalianpinjamanMBDiragukan = $totaldiragukan;
        $tingkatpengembalianpinjamanMBMacet = $totalmacet;

        $totsektorindustrisejakAwal = $totsektorindustri;
        $jurnal = $this->db->query("SELECT * FROM opex ORDER BY tanggal ASC")->result_array();
		$tglawal = date('Y-m-01', strtotime(date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-01', strtotime(date("d-m-Y"))))))));
		$tglakhir = date('Y-m-01', strtotime(date("d-m-Y")));

        foreach ($jurnal as $key => $value) {
            if($value['tanggal'] >= $tglawal AND $value['tanggal'] < $tglakhir AND $value['tampil'] == '0'){
            
                //0103070000   Aktiva Lain-lain/Kas Bank Yang Dibatasi Pengunaanya 
                if($value['id_akun'] == '103070000'){ 
                    $KasBankYgDiBatasiPenggunaannyaklr += $value['pengeluaran']; 
                    $KasBankYgDiBatasiPenggunaannyamsk += $value['pemasukan']; 
                    $KasBankYgDiBatasiPenggunaannya = $KasBankYgDiBatasiPenggunaannyaklr - $KasBankYgDiBatasiPenggunaannyamsk;
                }  
                
                //0403010100   Pendapatan/Jasa Administrasi Pinjaman/Program Kemitraan 
                if($value['id_akun'] == '403010100'){ 
                    $JasaAdmPinjamanklr += $value['pengeluaran']; 
                    $JasaAdmPinjamanmsk += $value['pemasukan']; 
                    $JasaAdmPinjaman = $JasaAdmPinjamanklr - $JasaAdmPinjamanmsk;
                } 
                
                //0102010101   Aktiva Tetap/Harga Perolehan/Kendaraan 
                //0102010201   Aktiva Tetap/Harga Perolehan/Inventaris Kantor 
                if($value['id_akun'] == '102010101' OR $value['id_akun'] == '102010201'){ 
                    $AktivaTetapHargaPerolehanmsk += $value['pemasukan'];
                    $AktivaTetapHargaPerolehanklr += $value['pengeluaran'];
                    $AktivaTetapHargaPerolehan = $AktivaTetapHargaPerolehanklr - $AktivaTetapHargaPerolehanmsk;             
                }
                
                //0412020500   Pengembalian kelebihan Angsuran 
                if($value['id_akun'] == '412020500'){ 
                    $PengembalianKelebihanAngsuranklr += $value['pengeluaran']; 
                    $PengembalianKelebihanAngsuranmsk += $value['pemasukan']; 
                    $PengembalianKelebihanAngsuran = $PengembalianKelebihanAngsuranklr - $PengembalianKelebihanAngsuranmsk;
                }
                
                //0406010000   Beban Upah Tenaga kerja/Honorer/Program Kemitraan 
                if($value['id_akun'] == '406010000'){
                    $BebanUpahTenagakerjaklr += $value['pengeluaran'];
                    $BebanUpahTenagakerjamsk += $value['pemasukan']; 
                    $BebanUpahTenagakerja = $BebanUpahTenagakerjaklr - $BebanUpahTenagakerjamsk;
                }
                
                //0405010100   Beban Pembinaan/Beban Survey/Program Kemitraan 
                //0405020100   Beban Pembinaan/Beban Monitoring/Program Kemitraan 
                //0405030100   Beban Pembinaan/Beban Penagihan Pinjaman/Program Kemitraan 
                if($value['id_akun'] == '405010100' OR $value['id_akun'] == '405020100' OR $value['id_akun'] == '405030100'){ 
                    $BebanPembinaanmsk += $value['pemasukan']; 
                    $BebanPembinaanklr += $value['pengeluaran'];             
                    $BebanPembinaan = $BebanPembinaanklr - $BebanPembinaanmsk;
                }
                
                //lap arus kas start
                //0101060201   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Industri 
                //0101060202   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Perdagangan 
                //0101060203   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Pertanian 
                //0101060204   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Perkebunan 
                //0101060205   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Perikanan 
                //0101060206   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Peternakan 
                //0101060207   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Sektor Jasa 
                //0101060208   Aktiva Lancar/Piutang Mitra Binaan/Angsuran/Lain-lain 
                
                //pengembalian pinjaman pokok !
                if($value['id_akun'] == '101060201' OR $value['id_akun'] == '101060202' OR $value['id_akun'] == '101060203' OR $value['id_akun'] == '101060204'
                    OR $value['id_akun'] == '101060205' OR $value['id_akun'] == '101060206' OR $value['id_akun'] == '101060207' OR $value['id_akun'] == '101060208'){ 
                    $pengembalianPinjamanMBklr += $value['pengeluaran']; 
                    $pengembalianPinjamanMBmsk += $value['pemasukan']; 
                    $pengembalianPinjamanMB = $pengembalianPinjamanMBklr - $pengembalianPinjamanMBmsk;             
                }
                //lap arus kas end
                
                //dana yang disalurkan start
                //0101060101   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Industri 
                //0101060102   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Perdagangan 
                //0101060103   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Pertanian 
                //0101060104   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Perkebunan 
                //0101060105   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Perikanan 
                //0101060106   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Peternakan 
                //0101060107   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Sektor Jasa 
                //0101060108   Aktiva Lancar/Piutang Mitra Binaan/Pinjaman/Lain-lain 
                if($value['id_akun'] == '101060101' OR $value['id_akun'] == '101060102' OR $value['id_akun'] == '101060103' OR $value['id_akun'] == '101060104'
                    OR $value['id_akun'] == '101060105' OR $value['id_akun'] == '101060106' OR $value['id_akun'] == '101060107' OR $value['id_akun'] == '101060108')
                { 
                $PiutangMitraBinaanPinjamanmsk += $value['pemasukan']; 
                $PiutangMitraBinaanPinjamanklr += $value['pengeluaran'];
                $PiutangMitraBinaanPinjaman = $PiutangMitraBinaanPinjamanklr - $PiutangMitraBinaanPinjamanmsk;         
                }
                
                if($value['id_akun'] == '101060101')//industri
                { 
                    $PiutangMitraBinaanPinjamanindustrimsk += $value['pemasukan'];
                    $PiutangMitraBinaanPinjamanIndustriklr += $value['pengeluaran'];  
                    $PiutangMitraBinaanPinjamanIndustrijul = $PiutangMitraBinaanPinjamanIndustriklr - $PiutangMitraBinaanPinjamanindustrimsk;       
                }
                if($value['id_akun'] == '101060102')//perdagangan
                { 
                    $PiutangMitraBinaanPinjamanPerdaganganmsk += $value['pemasukan'];         
                    $PiutangMitraBinaanPinjamanPerdaganganklr += $value['pengeluaran'];         
                    $PiutangMitraBinaanPinjamanPerdagangan = $PiutangMitraBinaanPinjamanPerdaganganklr - $PiutangMitraBinaanPinjamanPerdaganganmsk;       
                }
                if($value['id_akun'] == '101060103')//pertanian
                { 
                    $PiutangMitraBinaanPinjamanPertanianmsk += $value['pemasukan'];  
                    $PiutangMitraBinaanPinjamanPertanianklr += $value['pengeluaran'];         
                    $PiutangMitraBinaanPinjamanPertanian = $PiutangMitraBinaanPinjamanPertanianklr - $PiutangMitraBinaanPinjamanPertanianmsk;
                }
                if($value['id_akun'] == '101060104')//perkebunan
                { 
                    $PiutangMitraBinaanPinjamanPerkebunanmsk += $value['pemasukan']; 
                    $PiutangMitraBinaanPinjamanPerkebunanklr += $value['pengeluaran']; 
                    $PiutangMitraBinaanPinjamanPerkebunan = $PiutangMitraBinaanPinjamanPerkebunanklr - $PiutangMitraBinaanPinjamanPerkebunanmsk;        
                }
                if($value['id_akun'] == '101060105')//perikanan
                { 
                    $PiutangMitraBinaanPinjamanPerikananmsk += $value['pemasukan'];
                    $PiutangMitraBinaanPinjamanPerikananklr += $value['pengeluaran'];         
                    $PiutangMitraBinaanPinjamanPerikanan = $PiutangMitraBinaanPinjamanPerikananklr - $PiutangMitraBinaanPinjamanPerikananmsk;
                }
                if($value['id_akun'] == '101060106')//peternakan
                { 
                    $PiutangMitraBinaanPinjamanPeternakanmsk += $value['pemasukan'];
                    $PiutangMitraBinaanPinjamanPeternakanklr += $value['pengeluaran'];         
                    $PiutangMitraBinaanPinjamanPeternakan=
                    $PiutangMitraBinaanPinjamanPeternakanklr - $PiutangMitraBinaanPinjamanPeternakanmsk;
                }
                if($value['id_akun'] == '101060107')//Jasa
                { 
                    $PiutangMitraBinaanPinjamanJasamsk += $value['pemasukan'];
                    $PiutangMitraBinaanPinjamanJasaklr += $value['pengeluaran'];
                    $PiutangMitraBinaanPinjamanJasa = $PiutangMitraBinaanPinjamanJasaklr - $PiutangMitraBinaanPinjamanJasamsk;         
                }
                if($value['id_akun'] == '101060108')//Lain
                { 
                    $PiutangMitraBinaanPinjamanLainmsk += $value['pemasukan'];
                    $PiutangMitraBinaanPinjamanLainklr += $value['pengeluaran'];
                    $PiutangMitraBinaanPinjamanLain = $PiutangMitraBinaanPinjamanLainklr - $PiutangMitraBinaanPinjamanLainmsk;         
                }
                
                //dana yang disalurkan end

                //laporan aktivitas start
                
                //403020100 pendapatan /jasa giro/ program kemitraan
                if($value['id_akun'] == '403020100')//pendapatan /jasa giro/ program kemitraan
                {
                    $AktivaLancarPiutangBungaklr += $value['pengeluaran']; 
                    $AktivaLancarPiutangBungamsk += $value['pemasukan']; 
                    $AktivaLancarPiutangBunga = $AktivaLancarPiutangBungaklr - $AktivaLancarPiutangBungamsk;
                }
        
                //403020101 Pendapatan/Jasa Giro/BL
                if($value['id_akun'] == '403020101')////403020101 Pendapatan/Jasa Giro/BL
                {
                    $PendapatanJasaGiroBLklr += $value['pengeluaran']; 
                    $PendapatanJasaGiroBLmsk += $value['pemasukan']; 
                    $PendapatanJasaGiroBL = $PendapatanJasaGiroBLklr - $PendapatanJasaGiroBLmsk;
        
                }
                //403020102 Pendapatan/Jasa Giro/BUMN Peduli 403020100???
                if($value['id_akun'] == '403020102')//403020102 Pendapatan/Jasa Giro/BUMN Peduli
                {
                    $PendapatanJasaGiroBUMNPeduliklr += $value['pengeluaran'];
                    $PendapatanJasaGiroBUMNPedulimsk += $value['pemasukan']; 
                    $PendapatanJasaGiroBUMNPeduli = $PendapatanJasaGiroBUMNPeduliklr - $PendapatanJasaGiroBUMNPedulimsk;
                }
                
                $PendapatanJasaGiro=($PendapatanJasaGiroBL+$PendapatanJasaGiroBUMNPeduli+$AktivaLancarPiutangBunga);// lap aktivitas
                
                
                //0403030100     Pendapatan/Pendapatan Lain-lain/Piutang Hapus Buku 
                //0403030200     Pendapatan/Pendapatan Lain-lain/Penyesuaian Alokasi Penyisihan Piutang 
                //0403030300     Pendapatan/Pendapatan Lain-lain/Selisih Kas & Bank 
                //0403030400     Pendapatan/Pendapatan Lain-lain/Lain-lain 
                if($value['id_akun'] == '403030100' OR $value['id_akun'] == '403030200' OR $value['id_akun'] == '403030300' OR $value['id_akun'] == '403030400'){
                    $PendapatanLainlainklr += $value['pengeluaran'];
                    $PendapatanLainlainmsk += $value['pemasukan']; 
                    $PendapatanLainlain = $PendapatanLainlainklr - $PendapatanLainlainmsk;

                    if($value['id_akun'] == '403030100'){ 
                        $PendapatanLainPiutangHapusBukuklr += $value['pengeluaran']; 
                        $PendapatanLainPiutangHapusBukumsk += $value['pemasukan']; 
                        $PendapatanLainPiutangHapusBuku = $PendapatanLainPiutangHapusBukuklr - $PendapatanLainPiutangHapusBukumsk;
                    }
                    if($value['id_akun'] == '403030200'){ 
                        $PendapatanLainPenyisihanPiutangklr += $value['pengeluaran'];
                        $PendapatanLainPenyisihanPiutangmsk += $value['pemasukan']; 
                        $PendapatanLainPenyisihanPiutang = $PendapatanLainPenyisihanPiutangklr - $PendapatanLainPenyisihanPiutangmsk;
                    }
                    if($value['id_akun'] == '403030300'){ 
                        $PendapatanLainLainSelisihKasBankLainklr += $value['pengeluaran'];
                        $PendapatanLainLainSelisihKasBankLainmsk += $value['pemasukan']; 
                        $PendapatanLainLainSelisihKasBankLain = $PendapatanLainLainSelisihKasBankLainklr - $PendapatanLainLainSelisihKasBankLainmsk;
                    }
                    if($value['id_akun'] == '403030400' ){ 
                        $PendapatanLainLainLainlainklr += $value['pengeluaran'];
                        $PendapatanLainLainLainlainmsk += $value['pemasukan']; 
                        $PendapatanLainLainLainlain = $PendapatanLainLainLainlainklr - $PendapatanLainLainLainlainmsk;
                    }
                }
                
                // 040103000    Penyisihan/Alokasi Dana BUMN Peduli 
                if($value['id_akun'] == '401030000')
                {
                    $PenyisihanAlokasiDanaBUMNPeduliklr += $value['pengeluaran']; 
                    $PenyisihanAlokasiDanaBUMNPedulimsk += $value['pemasukan']; 
                    $PenyisihanAlokasiDanaBUMNPeduli = $PenyisihanAlokasiDanaBUMNPeduliklr - $PenyisihanAlokasiDanaBUMNPedulimsk;
                }
                
                // 401010000   Penyisihan/ANTT Berakhir Pemenuhan Program
                if($value['id_akun'] == '401010000')
                { 
                    $PenyisihanANTTBerakhirPemenuhanProgramklr += $value['pengeluaran'];
                    $PenyisihanANTTBerakhirPemenuhanProgrammsk += $value['pemasukan'];
                    $PenyisihanANTTBerakhirPemenuhanProgram = $PenyisihanANTTBerakhirPemenuhanProgramklr - $PenyisihanANTTBerakhirPemenuhanProgrammsk;                        
                }
                
                // 401020000 penyisihan ANTT berakhir waktu
                if($value['id_akun'] == '401020000')
                {
                    $penyisihanANTTberakhirwaktuklr += $value['pengeluaran']; 
                    $penyisihanANTTberakhirwaktumsk += $value['pemasukan'];
                    $penyisihanANTTberakhirwaktu = $penyisihanANTTberakhirwaktuklr - $penyisihanANTTberakhirwaktumsk; 
                }
                
                //0404010101     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Industri 
                //0404010102     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Perdagangan 
                //0404010103     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Pertanian 
                //0404010104     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Perkebunan 
                //0404010105     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Perikanan 
                //0404010106     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Peternakan 
                //0404010107     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Sektor Jasa 
                //0404010108     Penyaluran/Dana Pembinaan Kemitraan/Pelatihan/Lain-lain 
                //0404010201     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Industri 
                //0404010202     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Perdagangan 
                //0404010203     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Pertanian 
                //0404010204     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Perkebunan 
                //0404010205     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Perikanan 
                //0404010206     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Peternakan 
                //0404010207     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Sektor Jasa 
                //0404010208     Penyaluran/Dana Pembinaan Kemitraan/Promosi /Lain-lain 
                //0404010301     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Industri 
                //0404010302     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Perdagangan 
                //0404010303     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Pertanian 
                //0404010304     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Perkebunan 
                //0404010305     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Perikanan 
                //0404010306     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Peternakan 
                //0404010307     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Sektor Jasa 
                //0404010308     Penyaluran/Dana Pembinaan Kemitraan/Pemagangan/Lain-lain 
                
                if($value['id_akun'] == '404010101' OR $value['id_akun'] == '404010102' OR $value['id_akun'] == '404010103' OR $value['id_akun'] == '404010104'
                OR $value['id_akun'] == '404010105' OR $value['id_akun'] == '404010106' OR $value['id_akun'] == '404010107' OR $value['id_akun'] == '404010108' OR
                $value['id_akun'] == '404010201' OR $value['id_akun'] == '404010202' OR $value['id_akun'] == '404010203' OR $value['id_akun'] == '404010204'
                OR $value['id_akun'] == '404010205' OR $value['id_akun'] == '404010206' OR $value['id_akun'] == '404010207' OR $value['id_akun'] == '404010208' OR
                $value['id_akun'] == '0404010301' OR $value['id_akun'] == '0404010302' OR $value['id_akun'] == '0404010303' OR $value['id_akun'] == '0404010304' 
                OR $value['id_akun'] == '0404010305' OR $value['id_akun'] == '0404010306' OR $value['id_akun'] == '0404010307' OR $value['id_akun'] == '0404010308'){ 
                    $DanaPembinaanKemitraanklr += $value['pengeluaran'];
                    $DanaPembinaanKemitraanmsk += $value['pemasukan'];
                    $DanaPembinaanKemitraan= $DanaPembinaanKemitraanklr - $DanaPembinaanKemitraanmsk;                           
                }
                
                //0404020100     Penyaluran/Dana Bina Lingkungan/Bencana Alam 
                //0404020200     Penyaluran/Dana Bina Lingkungan/Pendidikan & Pelatihan 
                //0404020300     Penyaluran/Dana Bina Lingkungan/Peningkatan Kesehatan 
                //0404020400     Penyaluran/Dana Bina Lingkungan/Sarana dan Prasana Umum 
                //0404020500     Penyaluran/Dana Bina Lingkungan/Sarana Ibadah 
                //0404020600     Penyaluran/Dana Bina Lingkungan/Pelestarian Alam 
                //0404020700     Penyaluran/Dana Bina Lingkungan/BUMN Peduli 
                //0404020800     Pelimpahan Dana Ke Unit PKBL Lain 
                //0404020900     Penyaluran/Dana Bina Lingkungan/Diklat MB PK 
                //0404021000     Penyaluran/Dana Bina Lingkungan/Pengentasan kemiskinan 
                                    
                if($value['id_akun'] == '404020100' OR $value['id_akun'] == '404020200' OR $value['id_akun'] == '404020300' OR $value['id_akun'] == '404020400'
                OR $value['id_akun'] == '404020500' OR $value['id_akun'] == '404020600' OR $value['id_akun'] == '404020700' OR $value['id_akun'] == '404020800' OR
                $value['id_akun'] == '404020900' OR $value['id_akun'] == '404021000' ){ 
                    $DanaBinaLingkunganklr += $value['pengeluaran'];  
                    $DanaBinaLingkunganmsk += $value['pemasukan'];  
                    $DanaBinaLingkungan = $DanaBinaLingkunganklr - $DanaBinaLingkunganmsk;                  
                }
                
                //0407010000     Beban Adm dan Umum/Program Kemitraan 
                //0407020000     Beban Adm dan Umum/Bina Lingkungan 
                //0407030000     Beban Adm dan Umum/BUMN Peduli 
                
                if($value['id_akun'] == '407010000' OR $value['id_akun'] == '407020000' OR $value['id_akun'] == '407030000'){ 
                    $BebanAdmdanUmumklr += $value['pengeluaran']; 
                    $BebanAdmdanUmummsk += $value['pemasukan']; 
                    $BebanAdmdanUmum = $BebanAdmdanUmumklr - $BebanAdmdanUmummsk;

                    if($value['id_akun'] == '407010000'){ 
                        $BebanAdmDanUmumklr += $value['pengeluaran']; 
                        $BebanAdmDanUmummsk += $value['pemasukan']; 
                        $BebanAdmDanUmum = $BebanAdmDanUmumklr - $BebanAdmDanUmummsk;
                    }
                    if($value['id_akun'] == '407020000' OR $value['id_akun'] == '407030000'){ 
                        $BebanAdmDanUmumBLklr += $value['pengeluaran']; 
                        $BebanAdmDanUmumBLmsk += $value['pemasukan']; 
                        $BebanAdmDanUmumBL = $BebanAdmDanUmumBLklr - $BebanAdmDanUmumBLmsk;
                    }
                }
                
                //410010000   Beban Penyusutan Aktiva Tetap/Program Kemitraan
                if($value['id_akun'] == '410010000'){ 
                    $BebanPenyusutanAktivaTetapProgramKemitraanklr += $value['pengeluaran']; 
                    $BebanPenyusutanAktivaTetapProgramKemitraanmsk += $value['pemasukan']; 
                    $BebanPenyusutanAktivaTetapProgramKemitraan = $BebanPenyusutanAktivaTetapProgramKemitraanklr - $BebanPenyusutanAktivaTetapProgramKemitraanmsk;
                }

                //408010000 Beban Pemeliharaan/Program Kemitraan
                if($value['id_akun'] == '408010000') { 
                    $BebanPemeliharaanProgramKemitraanklr += $value['pengeluaran']; 
                    $BebanPemeliharaanProgramKemitraanmsk += $value['pemasukan']; 
                    $BebanPemeliharaanProgramKemitraan = $BebanPemeliharaanProgramKemitraanklr - $BebanPemeliharaanProgramKemitraanmsk;
                }
                
                //0411010100     Beban Penyisihan Piutang/Sektor Industri/Sektor Industri 
                //0411020200     Beban Penyisihan Piutang/Sektor Perdagangan/Sektor Perdagangan 
                //0411030300     Beban Penyisihan Piutang/Sektor Pertanian/Sektor Pertanian 
                //0411040400     Beban Penyisihan Piutang/Sektor Perkebunan/Sektor Perkebunan 
                //0411050500     Beban Penyisihan Piutang/Sektor Perikanan/Sektor Perikanan 
                //0411060600     Beban Penyisihan Piutang/Sektor Peternakan/Sektor Peternakan 
                //0411070700     Beban Penyisihan Piutang/Sektor Jasa/Sektor Jasa 
                //0411080800     Beban Penyisihan Piutang/Lain-lain/Lain-lain 
                                        
                //411010100 Beban Penyisihan Piutang/Sektor Industri/Sektor Industri
                if($value['id_akun'] == '411010100'){ 
                    $BebanPenyisihanPiutangSektorIndustriSektorIndustriklr += $value['pengeluaran'];
                    $BebanPenyisihanPiutangSektorIndustriSektorIndustrimsk += $value['pemasukan'];
                    $BebanPenyisihanPiutangSektorIndustriSektorIndustri = $BebanPenyisihanPiutangSektorIndustriSektorIndustriklr - $BebanPenyisihanPiutangSektorIndustriSektorIndustrimsk;
                }

                //411020200 Beban Penyisihan Piutang/SektorPerdagangan/SektorPerdagangan
                if($value['id_akun'] == '411020200'){ 
                    $BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganklr += $value['pengeluaran'];
                    $BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganmsk += $value['pemasukan'];
                    $BebanPenyisihanPiutangSektorPerdaganganSektorPerdagangan = $BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganklr - $BebanPenyisihanPiutangSektorPerdaganganSektorPerdaganganmsk;
                }

                //411030300 Beban Penyisihan Piutang/SektorPertanian/SektorPertanian
                if($value['id_akun'] == '411030300'){ 
                    $BebanPenyisihanPiutangSektorPertanianSektorPertanianklr += $value['pengeluaran'];
                    $BebanPenyisihanPiutangSektorPertanianSektorPertanianmsk += $value['pemasukan']; 
                    $BebanPenyisihanPiutangSektorPertanianSektorPertanian = $BebanPenyisihanPiutangSektorPertanianSektorPertanianklr - $BebanPenyisihanPiutangSektorPertanianSektorPertanianmsk;
                }

                //411040400 Beban Penyisihan Piutang/SektorPerkebunan/SektorPerkebunan
                if($value['id_akun'] == '411040400'){ 
                    $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanklr += $value['pengeluaran'];
                    $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanmsk += $value['pemasukan'];
                    $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunan = $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanklr - $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunanmsk;
                }

                //411050500 Beban Penyisihan Piutang/SektorPerikanan/SektorPerikanan
                if($value['id_akun'] == '411050500'){ 
                    $BebanPenyisihanPiutangSektorPerikananSektorPerikananklr += $value['pengeluaran'];
                    $BebanPenyisihanPiutangSektorPerikananSektorPerikananmsk += $value['pemasukan']; 
                    $BebanPenyisihanPiutangSektorPerikananSektorPerikanan = $BebanPenyisihanPiutangSektorPerikananSektorPerikananklr - $BebanPenyisihanPiutangSektorPerikananSektorPerikananmsk;
                }
                //411060600 Beban Penyisihan Piutang/SektorPeternakan/SektorPeternakan
                if($value['id_akun'] == '411060600'){ 
                    $BebanPenyisihanPiutangSektorPeternakanSektorPeternakanklr += $value['pengeluaran'];
                    $BebanPenyisihanPiutangSektorPeternakanSektorPeternakanmsk += $value['pemasukan']; 
                    $BebanPenyisihanPiutangSektorPeternakanSektorPeternakan = $BebanPenyisihanPiutangSektorPeternakanSektorPeternakanklr - $BebanPenyisihanPiutangSektorPeternakanSektorPeternakanmsk;
                }

                //411070700 Beban Penyisihan Piutang/SektorJasa/SektorJasa
                if($value['id_akun'] == '411070700'){ 
                    $BebanPenyisihanPiutangSektorJasaSektorJasaklr += $value['pengeluaran'];
                    $BebanPenyisihanPiutangSektorJasaSektorJasamsk += $value['pemasukan'];
                    $BebanPenyisihanPiutangSektorJasaSektorJasa = $BebanPenyisihanPiutangSektorJasaSektorJasaklr - $BebanPenyisihanPiutangSektorJasaSektorJasamsk;
                }
                //411080800 Beban Penyisihan Piutang/SektorLainlain/SektorLainlain
                if($value['id_akun'] == '411080800'){ 
                    $BebanPenyisihanPiutangSektorLainlainSektorLainlainklr += $value['pengeluaran'];
                    $BebanPenyisihanPiutangSektorLainlainSektorLainlainmsk += $value['pemasukan'];
                    $BebanPenyisihanPiutangSektorLainlainSektorLainlain = $BebanPenyisihanPiutangSektorLainlainSektorLainlainklr - $BebanPenyisihanPiutangSektorLainlainSektorLainlainmsk;
                }

                // BEBAN PENYISIHAN PIUTANG BISA DIBACA DARI CALK LANGSUNG TANPA DARI JURNAL
                
                //CEK BEBAN LAIN
                
                //0405010100   Beban Pembinaan/Beban Survey/Program Kemitraan 
                //0405020100   Beban Pembinaan/Beban Monitoring/Program Kemitraan 
                //0405030100   Beban Pembinaan/Beban Penagihan Pinjaman/Program Kemitraan 
                //0406010000   Beban Upah Tenaga kerja/Honorer/Program Kemitraan 
                //0407010000   Beban Adm dan Umum/Program Kemitraan 
                //0407020000   Beban Adm dan Umum/Bina Lingkungan 
                //0407030000   Beban Adm dan Umum/BUMN Peduli 
                //0408010000   Beban Pemeliharaan/Program Kemitraan 
                //0409010000   Beban Sewa/Program Kemitraan 
                //0410010000   Beban Penyusutan Aktiva Tetap/Program Kemitraan 
                //0411010100   Beban Penyisihan Piutang/Sektor Industri/Sektor Industri 
                //0411020200   Beban Penyisihan Piutang/Sektor Perdagangan/Sektor Perdagangan 
                //0411030300   Beban Penyisihan Piutang/Sektor Pertanian/Sektor Pertanian 
                //0411040400   Beban Penyisihan Piutang/Sektor Perkebunan/Sektor Perkebunan 
                //0411050500   Beban Penyisihan Piutang/Sektor Perikanan/Sektor Perikanan 
                //0411060600   Beban Penyisihan Piutang/Sektor Peternakan/Sektor Peternakan 
                //0411070700   Beban Penyisihan Piutang/Sektor Jasa/Sektor Jasa 
                //0411080800   Beban Penyisihan Piutang/Lain-lain/Lain-lain 
                //0412010100   Beban Pajak/PPh 21/PPh 21 
                //0412010101   Beban Pajak/PPh 21/PPh 21/BUMN Peduli 
                //0412020200   Beban Pajak/PPh 23/26/PPh 23/26 
                //0412020300   Beban Pajak/PPh 25/29/PPh 25/29 
                //0412020400   Beban Lain-lain/Program Kemitraan 
                
                
                //412020400 Beban Lainlain/Program Kemitraan
                if($value['id_akun'] == '412020400')
                { 
                    $BebanLainlainProgramKemitraanklr += $value['pengeluaran']; 
                    $BebanLainlainProgramKemitraanmsk += $value['pemasukan'];
                    $BebanLainlainProgramKemitraan = $BebanLainlainProgramKemitraanklr - $BebanLainlainProgramKemitraanmsk;
                }
                
                //415020000 ANT terbebaskan ANT= Aset Neto Terikat
                if($value['id_akun'] == '415020000')
                { 
                    $ANTterbebaskanmsk += $value['pemasukan'];
                    $ANTterbebaskanklr += $value['pengeluaran'];
                    $ANTterbebaskan = $ANTterbebaskanklr - $ANTterbebaskanmsk;
                }
                
                //415010000 ANT Penyisihan BUMN Peduli ANT=Aset Neto terikat
                if($value['id_akun'] == '415010000')
                {
                    $ANTPenyisihanBUMNPedulimsk += $value['pemasukan']; 
                    $ANTPenyisihanBUMNPeduliklr += $value['pengeluaran'];
                    $ANTPenyisihanBUMNPeduli = $ANTPenyisihanBUMNPeduliklr-$ANTPenyisihanBUMNPedulimsk;
                }
                
                //laporan aktivitas end
                                    
                //Alokasi penyisihan piutang MB start
                //0101070100     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Industri 
                //0101070200     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Perdagangan 
                //0101070300     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Pertanian 
                //0101070400     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Perkebunan 
                //0101070500     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Perikanan 
                //0101070600     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Peternakan 
                //0101070700     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Jasa 
                //0101070800     Aktiva Lancar/Alokasi Penyisihan Piutang Mitra Binaan/Sektor Lain-lain 
            
                if( $value['id_akun'] == '0101070100' OR  $value['id_akun'] == '0101070200' OR
                    $value['id_akun'] == '0101070300' OR  $value['id_akun'] == '0101070400' OR
                    $value['id_akun'] == '0101070500' OR  $value['id_akun'] == '0101070600' OR
                    $value['id_akun'] == '0101070700' OR  $value['id_akun'] == '0101070800')
                {
                    $AktivaLancarAlokasiPenyisihanPiutangMitraBinaanmsk += $value['pemasukan'];
                    $AktivaLancarAlokasiPenyisihanPiutangMitraBinaanklr += $value['pengeluaran'];
                    $AktivaLancarAlokasiPenyisihanPiutangMitraBinaan = $AktivaLancarAlokasiPenyisihanPiutangMitraBinaanklr - $AktivaLancarAlokasiPenyisihanPiutangMitraBinaanmsk;
                }
                                                    
                if($value['id_akun'] == '102020201')
                {
                    $AktivaTetapAkumulasiPenyusutanInventarisKant=0-40478000;
                }
                                                        
                if($value['id_akun'] == '201040000')//17  Kewajiban julgka Pendek/Kelebihan Pembayaran Angsuran
                {
                    $KelebihanPembayaranAngsuranklr += $value['pengeluaran'];
                    $KelebihanPembayaranAngsuranmsk += $value['pemasukan'];
                    $KelebihanPembayaranAngsuran = $KelebihanPembayaranAngsuranklr - $KelebihanPembayaranAngsuranmsk; 
                }
            
                if($value['id_akun'] == '412020500')// Pengembalian kelebihan Angsuran 
                {
                    $PengembaliankelebihanAngsuranklr += $value['pengeluaran']; //
                    $PengembaliankelebihanAngsuranmsk += $value['pemasukan']; //
                    $selisihPengembaliankelebihanAngsuran = $PengembaliankelebihanAngsuranklr+$PengembaliankelebihanAngsuranmsk;//laposkeu
                }
            
                if($value['id_akun'] == '201050000')//18  Kewajiban jangka Pendek/Angsuran Belum Teridentifikasi
                {
                    $KewajibanJangkaPendekAngsuranBelumTeridentifikasimsk += $value['pemasukan'];
                    $KewajibanJangkaPendekAngsuranBelumTeridentifikasiklr += $value['pengeluaran'];
                    $KewajibanJangkaPendekAngsuranBelumTeridentifikasi = $KewajibanJangkaPendekAngsuranBelumTeridentifikasiklr - $KewajibanJangkaPendekAngsuranBelumTeridentifikasimsk;
                }
            
                if($value['id_akun'] == '403030400')//balance 18  Pendapatan/Pendapatan Lain-lain/Lain-lain
                {
                    $PendapatanPendapatanLainlainLainlainklr += $value['pengeluaran'];
                    $PendapatanPendapatanLainlainLainlainmsk += $value['pemasukan'];
                    $PendapatanPendapatanLainlainLainlain= $PendapatanPendapatanLainlainLainlainklr- $PendapatanPendapatanLainlainLainlainmsk;
                }
            
                if($value['id_akun'] == '202010000')//19 Kewajiban julgka Panjulg/Program Kemitraan
                {
                    $KewajibanjulgkaPanjulgProgramKemitraanmsk += $value['pemasukan'];
                    $KewajibanjulgkaPanjulgProgramKemitraanklr += $value['pengeluaran']; 
                    $KewajibanjulgkaPanjulgProgramKemitraan= $KewajibanjulgkaPanjulgProgramKemitraanklr- $KewajibanjulgkaPanjulgProgramKemitraanmsk;
                }
            
                if($value['id_akun'] == '101020100')//balance 19  Aktiva Lancar/Persediaan/Program Kemitraan
                {
                    $AktivaLancarPersediaanProgramKemitraanklr += $value['pengeluaran']; //OK udah benar !
                    $AktivaLancarPersediaanProgramKemitraanmsk += $value['pemasukan'];
                    $AktivaLancarPersediaanProgramKemitraan= $AktivaLancarPersediaanProgramKemitraanklr- $AktivaLancarPersediaanProgramKemitraanmsk;
                }
            
                if($value['id_akun'] == '415020000')//22 415020000 ANT terbebaskan 
                {
                    $ANTterbebaskanmsk += $value['pemasukan'];
                    $ANTterbebaskanklr += $value['pengeluaran'];
                    $ANTterbebaskan = $ANTterbebaskanklr - $ANTterbebaskanmsk; 
            
                }
                if($value['id_akun'] == '412020400')//23 Penyisihan/LAIN LAIN ?????? tanya Wagi
                {
                    $PenyisihanANTTBerakhirPemenuhanProgrammsk += $value['pemasukan'];
                    $PenyisihanANTTBerakhirPemenuhanProgramklr += $value['pengeluaran']; 
                    $PenyisihanANTTBerakhirPemenuhanProgram = $PenyisihanANTTBerakhirPemenuhanProgramklr - $PenyisihanANTTBerakhirPemenuhanProgrammsk;
                }
                if($value['id_akun'] == '415020000')//balance 23  ANT Terbebaskan ???? balance korek ???
                {
                    $ANTTerbebaskanklr += $value['pengeluaran']; 
                    $ANTTerbebaskanmsk += $value['pemasukan'];
                    $ANTTerbebaskan = $ANTTerbebaskanklr - $ANTTerbebaskanmsk;
                }
            }
        }

        $BebanPenyisihanPiutang = $BebanPenyisihanPiutangSektorIndustriSektorIndustri+$BebanPenyisihanPiutangSektorPerdaganganSektorPerdagangan+$BebanPenyisihanPiutangSektorPertanianSektorPertanian+
            $BebanPenyisihanPiutangSektorPerkebunanSektorPerkebunan+$BebanPenyisihanPiutangSektorPerikananSektorPerikanan+
            $BebanPenyisihanPiutangSektorPeternakanSektorPeternakan+
            $BebanPenyisihanPiutangSektorJasaSektorJasa+
            $BebanPenyisihanPiutangSektorLainlainSektorLainlain;

        $PiutangMitraBinaanPinjamanBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM danayangdisalurkan WHERE id='1'")->result_array()[0][$bulansebelumnya];
        $PiutangMitraBinaanPinjaman = 0 - $PiutangMitraBinaanPinjaman;
        $PiutangMitraBinaanPinjamansejakAwal = $PiutangMitraBinaanPinjaman + $PiutangMitraBinaanPinjamanBulanSebelumnya;

        $JasaAdmPinjamansejakAwal = $this->db->query("SELECT sd$bulansekarang FROM aktivitasoperasikasditerima WHERE id='4'")->result_array()[0]['sd' . $bulansekarang];
        $PendapatanJasaGirosejakAwal = $this->db->query("SELECT sd$bulansekarang FROM aktivitasoperasikasditerima WHERE id='5'")->result_array()[0]['sd'. $bulansekarang];
        $PendapatanLainPiutangHapusBukusejakAwal = $this->db->query("SELECT sd$bulansekarang FROM aktivitasoperasikasditerima WHERE id='6'")->result_array()[0]['sd' . $bulansekarang];

        $PendapatanLainlainsejakAwal=$PendapatanLainlain;
        $pengembalianPinjamanMBsejakAwal=$pengembalianPinjamanMB;
        $PiutangMitraBinaanPinjamanIndustrisejakAwal= $totsektorindustri;
        $PiutangMitraBinaanPinjamanPerdagangansejakAwal=$totsektorperdagangan;
        $PiutangMitraBinaanPinjamanPertaniansejakAwal=$totsektorpertanian;
        $PiutangMitraBinaanPinjamanPerkebunansejakAwal=$totsektorperkebunan;
        $PiutangMitraBinaanPinjamanPerikanansejakAwal=$totsektorperikanan;
        $PiutangMitraBinaanPinjamanPeternakansejakAwal=$totsektorpeternakan;
        $PiutangMitraBinaanPinjamanJasasejakAwal=$totsektorjasa;
        $PiutangMitraBinaanPinjamanLainsejakAwal=$totsektorlainlain;

        $tingkatpengembalianpinjamanMBtotalsejakAwal=$PiutangMitraBinaanPinjamanIndustrisejakAwal+$PiutangMitraBinaanPinjamanPerdagangansejakAwal+$PiutangMitraBinaanPinjamanPertaniansejakAwal+$PiutangMitraBinaanPinjamanPerkebunansejakAwal+$PiutangMitraBinaanPinjamanPerikanansejakAwal+$PiutangMitraBinaanPinjamanPeternakansejakAwal+
$PiutangMitraBinaanPinjamanJasasejakAwal+$PiutangMitraBinaanPinjamanLainsejakAwal;
        
        $perioda = date('M Y', strtotime($bulansekarang));
        $saldomandiri = $this->db->query("SELECT mandiri FROM saldokasbank WHERE perioda='$perioda'")->result_array()[0]['mandiri'];	
        $saldobri = $this->db->query("SELECT bri FROM saldokasbank WHERE perioda='$perioda'")->result_array()[0]['bri'];
        $saldokas = $this->db->query("SELECT kaskecil FROM saldokasbank WHERE perioda='$perioda'")->result_array()[0]['kaskecil'];
        $totsaldobank = $saldomandiri + $saldobri;

        var_dump($PiutangMitraBinaanPinjamanPerdagangansejakAwal);
        die;

        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$saldokas'  WHERE id='1'"); //kas 
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$saldokas'  WHERE id='2'"); //kas PK 
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$totsaldobank'  WHERE id='3'");//bank  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$saldomandiri'  WHERE id='4'"); //mandiri 
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$saldobri'  WHERE id='5'");  //BRI
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$KasBankYgDiBatasiPenggunaannya'  WHERE id='6'");  //kas yg dibatasi penggunaan
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$KasBankYgDiBatasiPenggunaannya'  WHERE id='7'");  //kas yg dibatasi penggunaan
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$tingkatpengembalianpinjamanMBtotalsejakAwal'  WHERE id='8'");//piutang mitra binaan sudah benar !   
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PiutangMitraBinaanPinjamanIndustrisejakAwal'  WHERE id='9'"); //industri 
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PiutangMitraBinaanPinjamanPerdagangansejakAwal'  WHERE id='10'"); //perdag
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PiutangMitraBinaanPinjamanPertaniansejakAwal'  WHERE id='11'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PiutangMitraBinaanPinjamanPerkebunansejakAwal'  WHERE id='12'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PiutangMitraBinaanPinjamanPerikanansejakAwal'  WHERE id='13'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PiutangMitraBinaanPinjamanPeternakansejakAwal'  WHERE id='14'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PiutangMitraBinaanPinjamanJasasejakAwal'  WHERE id='15'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PiutangMitraBinaanPinjamanLainsejakAwal'  WHERE id='16'");  //lainlain

        $alokasiPenyisihanPiutangMitraIndustriTdkBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='18'")->result_array()[0][$bulansekarang];   //industri
        $alokasiPenyisihanPiutangMitraPerdaganganTdkBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='19'")->result_array()[0][$bulansekarang];   //perdagangan
        $alokasiPenyisihanPiutangMitraPertanianTdkBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='20'")->result_array()[0][$bulansekarang];   //pertanian
        $alokasiPenyisihanPiutangMitraPerkebunanTdkBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='21'")->result_array()[0][$bulansekarang];   //perkebunan
        $alokasiPenyisihanPiutangMitraPerikananTdkBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='22'")->result_array()[0][$bulansekarang];   //perikanan
        $alokasiPenyisihanPiutangMitraPeternakanTdkBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='23'")->result_array()[0][$bulansekarang];   //peternakan
        $alokasiPenyisihanPiutangMitraJasaTdkBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='24'")->result_array()[0][$bulansekarang];   //jasa
        $alokasiPenyisihanPiutangMitraLainTdkBermasalah = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='25'")->result_array()[0][$bulansekarang];   //lainlain

        $PiutangJasaAdministrasiPinjaman = 0;
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PiutangJasaAdministrasiPinjaman'  WHERE id='26'");  //piutangJasaAdmPinjaman
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PiutangJasaAdministrasiPinjaman'  WHERE id='27'");//piutangJasaAdm  
    
        $AktivaTetapHargaPerolehanX=40478000;// selalu fixed !
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$AktivaTetapHargaPerolehanX'  WHERE id='28'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$AktivaTetapHargaPerolehanX'  WHERE id='29'");  
    
        $AktivaTetapAkumulasiPenyusutanInventarisKant=0-40478000;
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$AktivaTetapAkumulasiPenyusutanInventarisKant'  WHERE id='30'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$AktivaTetapAkumulasiPenyusutanInventarisKant'  WHERE id='31'");  
    
        //-----------PIUTANG BERMASALAH--------------------------
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$totnilsaldopokok_bermasalah'  WHERE id='32'");  //piutang bermasalah total
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$totsektorindustribermasalah'  WHERE id='33'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$totsektorperdaganganbermasalah'  WHERE id='34'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$totsektorpertanianbermasalah'  WHERE id='35'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$totsektorperkebunanbermasalah'  WHERE id='36'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$totsektorperikananbermasalah'  WHERE id='37'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$totsektorpeternakanbermasalah'  WHERE id='38'");
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$totsektorjasabermasalah'  WHERE id='39'"); //jasa 
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$totsektorlainlainbermasalah'  WHERE id='40'");//lain2
    
        //------------ALOKASI PENYISIHAN PIUTANG BERMASALAH------------
        $alok_totnilsaldopokok_bermasalah = 0 - $totnilsaldopokok_bermasalah;
        $alok_totsektorindustribermasalah = 0 - $totsektorindustribermasalah;
        $alok_totsektorperdaganganbermasalah = 0 - $totsektorperdaganganbermasalah;
        $alok_totsektorpertanianbermasalah = 0 - $totsektorpertanianbermasalah;
        $alok_totsektorperkebunanbermasalah = 0 - $totsektorperkebunanbermasalah;
        $alok_totsektorperikananbermasalah = 0 - $totsektorperikananbermasalah;
        $alok_totsektorpeternakanbermasalah = 0 - $totsektorpeternakanbermasalah;
        $alok_totsektorjasabermasalah = 0 - $totsektorjasabermasalah;
        $alok_totsektorlainlainbermasalah = 0 - $totsektorlainlainbermasalah; 

        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$alok_totnilsaldopokok_bermasalah'  WHERE id='42'"); //alok penyisihan piutang bermasalah
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$alok_totsektorindustribermasalah'  WHERE id='43'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$alok_totsektorperdaganganbermasalah'  WHERE id='44'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$alok_totsektorpertanianbermasalah'  WHERE id='45'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$alok_totsektorperkebunanbermasalah'  WHERE id='46'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$alok_totsektorperikananbermasalah'  WHERE id='47'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$alok_totsektorpeternakanbermasalah'  WHERE id='48'");//piutangJasaAdm  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$alok_totsektorjasabermasalah'  WHERE id='49'"); //
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$alok_totsektorlainlainbermasalah'  WHERE id='50'");//lain2  
        
        $KelebihanPembayaranAngsuranBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM neraca WHERE id='17'")->result_array()[0][$bulansebelumnya];
        $KelebihanPembayaranAngsuran = $KelebihanPembayaranAngsuranBulanSebelumnya + $PengembalianKelebihanAngsuran;
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$KelebihanPembayaranAngsuran'  WHERE id='52'"); //kelebihan

        $KewajibanJangkaPendekAngsuranBelumTeridentifikasiDesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='53'")->result_array()[0][$desTahunLalu];
        $KewajibanJangkaPendekAngsuranBelumTeridentifikasisejakAwal = $KewajibanJangkaPendekAngsuranBelumTeridentifikasiDesTahunLalu + $KewajibanJangkaPendekAngsuranBelumTeridentifikasi;
        $this->db->query("UPDATE catatanataslapkeu SET  $desTahunLalu='$KewajibanJangkaPendekAngsuranBelumTeridentifikasisejakAwal'  WHERE id='53'");//angsuran blm tridentif

        $ProgramKemitraan = $KelebihanPembayaranAngsuran + $KewajibanJangkaPendekAngsuranBelumTeridentifikasisejakAwal;
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$ProgramKemitraan'  WHERE id='51'");//Program Kemitraan

        $AktivaBersihAwalPeriodaBulanSebelumnya = $this->db->query("SELECT sd$bulansekarang FROM perubahanasetnetotidakterikat WHERE id='29'")->result_array()[0]['sd' . $bulansekarang];
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$AktivaBersihAwalPeriodaBulanSebelumnya'  WHERE id='54'"); // AktivaBersihAwalPeriode ambil dari lap-aktivitas 31des2021 (th sebelumnya) aset neto akhir tahun (trbwh)  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$AktivaBersihAwalPeriodaBulanSebelumnya'  WHERE id='55'"); //pendapatan

        //----PENDAPATAN----------------------------
        $Pendapatan = $JasaAdmPinjamansejakAwal + $PendapatanJasaGirosejakAwal + $PendapatanLainPiutangHapusBukusejakAwal + $PendapatanLainPenyisihanPiutang + $PendapatanLainLainLainlain;

        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$Pendapatan'  WHERE id='56'");  //pendapatan
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$JasaAdmPinjamansejakAwal'  WHERE id='57'");  //jasa adm pinj
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PendapatanJasaGirosejakAwal'  WHERE id='58'");//  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PendapatanLainPiutangHapusBukusejakAwal'  WHERE id='59'"); //
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PendapatanLainPenyisihanPiutang'  WHERE id='60'");//
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$PendapatanLainLainLainlain'  WHERE id='61'");//PK

        $BebanAdmDanUmum = $this->db->query("SELECT sd$bulansekarang FROM aktivitasoperasikasditerima WHERE id='14'")->result_array()[0]['sd' . $bulansekarang];
        $BebanUmum = $BebanAdmDanUmumBL + $BebanAdmDanUmum;
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanUmum'  WHERE id='62'");//BEBAN UMUM
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanAdmDanUmum'  WHERE id='65'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanAdmDanUmumBL'  WHERE id='66'"); 
        
        $alok_totsektorindustriBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='43'")->result_array()[0][$bulansebelumnya];
        $alok_totsektorindustri = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='43'")->result_array()[0][$bulansekarang];
        $BebanPenyisihanPiutangIndustriBermasalah = $alok_totsektorindustriBulanSebelumnya - $alok_totsektorindustri;

        $alokasiPenyisihanMitraIndustriBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='18'")->result_array()[0][$bulansebelumnya];
        $alokasiPenyisihanPiutangMitraIndustri = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='18'")->result_array()[0][$bulansekarang];
        $BebanPenyisihanPiutangIndustriTdkBermasalah = $alokasiPenyisihanMitraIndustriBulanSebelumnya - $alokasiPenyisihanPiutangMitraIndustri;
        $BebanPenyisihanPiutangIndustri = $BebanPenyisihanPiutangIndustriBermasalah + $BebanPenyisihanPiutangIndustriTdkBermasalah;

        $alok_totsektorperdaganganBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='44'")->result_array()[0][$bulansebelumnya];  //perdagangan bermasalah
        $alok_totsektorperdagangan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='44'")->result_array()[0][$bulansekarang];  //perdagangan bermasalah
        $BebanPenyisihanPiutangperdaganganBermasalah= $alok_totsektorperdaganganBulanSebelumnya-$alok_totsektorperdagangan;

        $alokasiPenyisihanMitraperdaganganBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='19'")->result_array()[0][$bulansebelumnya]; //perdagangan tdk bermasalah 
        $alokasiPenyisihanPiutangMitraperdagangan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='19'")->result_array()[0][$bulansekarang]; //perdagangan tdk bermasalah 
        $BebanPenyisihanPiutangperdaganganTdkBermasalah = $alokasiPenyisihanMitraperdaganganBulanSebelumnya-$alokasiPenyisihanPiutangMitraperdagangan;
        $BebanPenyisihanPiutangperdagangan = $BebanPenyisihanPiutangperdaganganBermasalah+$BebanPenyisihanPiutangperdaganganTdkBermasalah;

        $alok_totsektorpertanianBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='45'")->result_array()[0][$bulansebelumnya];  //pertanian bermasalah
        $alok_totsektorpertanian = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='45'")->result_array()[0][$bulansekarang];  //pertanian bermasalah
        $BebanPenyisihanPiutangpertanianBermasalah= $alok_totsektorpertanian-$alok_totsektorpertanian;

        $alokasiPenyisihanMitrapertanianBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='20'")->result_array()[0][$bulansebelumnya]; //pertanian tdk bermasalah 
        $alokasiPenyisihanPiutangMitrapertanian = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='20'")->result_array()[0][$bulansekarang]; //pertanian tdk bermasalah 
        $BebanPenyisihanPiutangpertanianTdkBermasalah= $alokasiPenyisihanMitrapertanianBulanSebelumnya-$alokasiPenyisihanPiutangMitrapertanian;
        $BebanPenyisihanPiutangpertanian=$BebanPenyisihanPiutangpertanianBermasalah+$BebanPenyisihanPiutangpertanianTdkBermasalah;

        $alok_totsektorperkebunanBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='46'")->result_array()[0][$bulansebelumnya];  //perkebunan bermasalah
        $alok_totsektorperkebunan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='46'")->result_array()[0][$bulansekarang];  //perkebunan bermasalah
        $BebanPenyisihanPiutangperkebunanBermasalah= $alok_totsektorperkebunanBulanSebelumnya-$alok_totsektorperkebunan;

        $alokasiPenyisihanMitraperkebunanBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='21'")->result_array()[0][$bulansebelumnya]; //perkebunan tdk bermasalah 
        $alokasiPenyisihanPiutangMitraperkebunan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='21'")->result_array()[0][$bulansekarang]; //perkebunan tdk bermasalah 
        $BebanPenyisihanPiutangperkebunanTdkBermasalah= $alokasiPenyisihanMitraperkebunanBulanSebelumnya-$alokasiPenyisihanPiutangMitraperkebunan;
        $BebanPenyisihanPiutangperkebunan=$BebanPenyisihanPiutangperkebunanBermasalah+$BebanPenyisihanPiutangperkebunanTdkBermasalah;

        $alok_totsektorperikananBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='47'")->result_array()[0][$bulansebelumnya];  //perikanan bermasalah
        $alok_totsektorperikanan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='47'")->result_array()[0][$bulansekarang];  //perikanan bermasalah
        $BebanPenyisihanPiutangperikananBermasalah= $alok_totsektorperikananBulanSebelumnya-$alok_totsektorperikanan;

        $alokasiPenyisihanMitraperikananBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='22'")->result_array()[0][$bulansebelumnya]; //perikanan tdk bermasalah 
        $alokasiPenyisihanPiutangMitraperikanan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='22'")->result_array()[0][$bulansekarang]; //perikanan tdk bermasalah 
        $BebanPenyisihanPiutangperikananTdkBermasalah= $alokasiPenyisihanMitraperikananBulanSebelumnya-$alokasiPenyisihanPiutangMitraperikanan;
        $BebanPenyisihanPiutangperikanan=$BebanPenyisihanPiutangperikananBermasalah+$BebanPenyisihanPiutangperikananTdkBermasalah;

        $alok_totsektorpeternakanBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='48'")->result_array()[0][$bulansebelumnya];  //peternakan bermasalah
        $alok_totsektorpeternakan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='48'")->result_array()[0][$bulansekarang];  //peternakan bermasalah
        $BebanPenyisihanPiutangpeternakanBermasalah= $alok_totsektorpeternakanBulanSebelumnya-$alok_totsektorpeternakan;

        $alokasiPenyisihanMitrapeternakanBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='23'")->result_array()[0][$bulansebelumnya]; //peternakan tdk bermasalah 
        $alokasiPenyisihanPiutangMitrapeternakan = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='23'")->result_array()[0][$bulansekarang]; //peternakan tdk bermasalah 
        $BebanPenyisihanPiutangpeternakanTdkBermasalah= $alokasiPenyisihanMitrapeternakanBulanSebelumnya-$alokasiPenyisihanPiutangMitrapeternakan;
        $BebanPenyisihanPiutangpeternakan=$BebanPenyisihanPiutangpeternakanBermasalah+$BebanPenyisihanPiutangpeternakanTdkBermasalah;

        $alok_totsektorjasaBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='49'")->result_array()[0][$bulansebelumnya];  //jasa bermasalah
        $alok_totsektorjasa = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='49'")->result_array()[0][$bulansekarang];  //jasa bermasalah
        $BebanPenyisihanPiutangjasaBermasalah= $alok_totsektorjasaBulanSebelumnya-$alok_totsektorjasa;

        $alokasiPenyisihanMitrajasaBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='24'")->result_array()[0][$bulansebelumnya]; //jasa tdk bermasalah 
        $alokasiPenyisihanPiutangMitrajasa = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='24'")->result_array()[0][$bulansekarang]; //jasa tdk bermasalah 
        $BebanPenyisihanPiutangjasaTdkBermasalah= $alokasiPenyisihanMitrajasaBulanSebelumnya-$alokasiPenyisihanPiutangMitrajasa;
        $BebanPenyisihanPiutangjasa=$BebanPenyisihanPiutangjasaBermasalah+$BebanPenyisihanPiutangjasaTdkBermasalah;

        $alok_totsektorlainBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='50'")->result_array()[0][$bulansebelumnya];  //lain bermasalah
        $alok_totsektorlain = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='50'")->result_array()[0][$bulansekarang];  //lain bermasalah
        $BebanPenyisihanPiutanglainBermasalah= $alok_totsektorlainBulanSebelumnya-$alok_totsektorlain;

        $alokasiPenyisihanMitralainBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='25'")->result_array()[0][$bulansebelumnya]; //lain tdk bermasalah 
        $alokasiPenyisihanPiutangMitralain = $this->db->query("SELECT $bulansekarang FROM catatanataslapkeu WHERE id='25'")->result_array()[0][$bulansekarang]; //lain tdk bermasalah 
        $BebanPenyisihanPiutanglainTdkBermasalah= $alokasiPenyisihanMitralainBulanSebelumnya-$alokasiPenyisihanPiutangMitralain;
        $BebanPenyisihanPiutanglain=$BebanPenyisihanPiutanglainBermasalah+$BebanPenyisihanPiutanglainTdkBermasalah;

        $alok_totsektorindustribermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='43'")->result_array()[0][$desTahunLalu];//industri bermasalah
        $BebanPenyisihanPiutangindustriBermasalah= $alok_totsektorindustribermasalah-$alok_totsektorindustribermasalahdesTahunLalu;

        $alokasiPenyisihanMitraindustriTdkBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='18'")->result_array()[0][$desTahunLalu]; //industri tdk bermasalah 
        $BebanPenyisihanPiutangindustriTdkBermasalah= $alokasiPenyisihanPiutangMitraIndustriTdkBermasalah-$alokasiPenyisihanMitraindustriTdkBermasalahdesTahunLalu;
        $BebanPenyisihanPiutangindustri=$BebanPenyisihanPiutangindustriBermasalah+$BebanPenyisihanPiutangindustriTdkBermasalah;
       
        $alok_totsektorperdaganganbermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='44'")->result_array()[0][$desTahunLalu];//perdagangan bermasalah
        $BebanPenyisihanPiutangPerdaganganBermasalah= $alok_totsektorperdaganganbermasalah-$alok_totsektorperdaganganbermasalahdesTahunLalu;

        $alokasiPenyisihanMitraPerdaganganTdkBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='19'")->result_array()[0][$desTahunLalu]; //perdagangan tdk bermasalah 
        $BebanPenyisihanPiutangPerdaganganTdkBermasalah= $alokasiPenyisihanPiutangMitraPerdaganganTdkBermasalah-$alokasiPenyisihanMitraPerdaganganTdkBermasalahdesTahunLalu;
        $BebanPenyisihanPiutangperdagangan=$BebanPenyisihanPiutangPerdaganganBermasalah+$BebanPenyisihanPiutangPerdaganganTdkBermasalah;

        $alok_totsektorpertanianbermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='45'")->result_array()[0][$desTahunLalu];  //pertanian bermasalah
        $BebanPenyisihanPiutangpertanianBermasalah= $alok_totsektorpertanianbermasalah-$alok_totsektorpertanianbermasalahdesTahunLalu;

        $alokasiPenyisihanMitrapertanianTdkBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='20'")->result_array()[0][$desTahunLalu]; //pertanian tdk bermasalah 
        $BebanPenyisihanPiutangpertanianTdkBermasalah= $alokasiPenyisihanPiutangMitraPertanianTdkBermasalah-$alokasiPenyisihanMitrapertanianTdkBermasalahdesTahunLalu;
        $BebanPenyisihanPiutangpertanian=$BebanPenyisihanPiutangpertanianBermasalah+$BebanPenyisihanPiutangpertanianTdkBermasalah;

        $alok_totsektorperkebunanbermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='46'")->result_array()[0][$desTahunLalu];  //perkebunan bermasalah
        $BebanPenyisihanPiutangperkebunanBermasalah= $alok_totsektorperkebunanbermasalah-$alok_totsektorperkebunanbermasalahdesTahunLalu;

        $alokasiPenyisihanMitraperkebunanTdkBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='21'")->result_array()[0][$desTahunLalu]; //perkebunan tdk bermasalah 
        $BebanPenyisihanPiutangperkebunanTdkBermasalah= $alokasiPenyisihanPiutangMitraPerkebunanTdkBermasalah-$alokasiPenyisihanMitraperkebunanTdkBermasalahdesTahunLalu;
        $BebanPenyisihanPiutangperkebunan=$BebanPenyisihanPiutangperkebunanBermasalah+$BebanPenyisihanPiutangperkebunanTdkBermasalah;

        $alok_totsektorperikananbermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='47'")->result_array()[0][$desTahunLalu];  //perikanan bermasalah
        $BebanPenyisihanPiutangperikananBermasalah= $alok_totsektorperikananbermasalah-$alok_totsektorperikananbermasalahdesTahunLalu;

        $alokasiPenyisihanMitraperikananTdkBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='22'")->result_array()[0][$desTahunLalu]; //perikanan tdk bermasalah 
        $BebanPenyisihanPiutangperikananTdkBermasalah= $alokasiPenyisihanPiutangMitraPerikananTdkBermasalah-$alokasiPenyisihanMitraperikananTdkBermasalahdesTahunLalu;
        $BebanPenyisihanPiutangperikanan=$BebanPenyisihanPiutangperikananBermasalah+$BebanPenyisihanPiutangperikananTdkBermasalah;

        $alok_totsektorpeternakanbermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='48'")->result_array()[0][$desTahunLalu];  //peternakan bermasalah
        $BebanPenyisihanPiutangpeternakanBermasalah= $alok_totsektorpeternakanbermasalah-$alok_totsektorpeternakanbermasalahdesTahunLalu;

        $alokasiPenyisihanMitrapeternakanTdkBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='23'")->result_array()[0][$desTahunLalu]; //peternakan tdk bermasalah 
        $BebanPenyisihanPiutangpeternakanTdkBermasalah= $alokasiPenyisihanPiutangMitraPeternakanTdkBermasalah-$alokasiPenyisihanMitrapeternakanTdkBermasalahdesTahunLalu;
        $BebanPenyisihanPiutangpeternakan=$BebanPenyisihanPiutangpeternakanBermasalah+$BebanPenyisihanPiutangpeternakanTdkBermasalah;
            
        $alok_totsektorjasabermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='49'")->result_array()[0][$desTahunLalu];  //jasa bermasalah
        $BebanPenyisihanPiutangjasaBermasalah= $alok_totsektorjasabermasalah-$alok_totsektorjasabermasalahdesTahunLalu;

        $alokasiPenyisihanMitrajasaTdkBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='24'")->result_array()[0][$desTahunLalu]; //jasa tdk bermasalah 
        $BebanPenyisihanPiutangjasaTdkBermasalah= $alokasiPenyisihanPiutangMitraJasaTdkBermasalah-$alokasiPenyisihanMitrajasaTdkBermasalahdesTahunLalu;
        $BebanPenyisihanPiutangjasa=$BebanPenyisihanPiutangjasaBermasalah+$BebanPenyisihanPiutangjasaTdkBermasalah;

        $alok_totsektorlainbermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='50'")->result_array()[0][$desTahunLalu];  //lain bermasalah
        $BebanPenyisihanPiutanglainBermasalah= $alok_totsektorlainlainbermasalah-$alok_totsektorlainbermasalahdesTahunLalu;

        $alokasiPenyisihanMitralainTdkBermasalahdesTahunLalu = $this->db->query("SELECT $desTahunLalu FROM catatanataslapkeu WHERE id='25'")->result_array()[0][$desTahunLalu]; //lain tdk bermasalah 
        $BebanPenyisihanPiutanglainTdkBermasalah= $alokasiPenyisihanPiutangMitraLainTdkBermasalah-$alokasiPenyisihanMitralainTdkBermasalahdesTahunLalu;
        $BebanPenyisihanPiutanglain=$BebanPenyisihanPiutanglainBermasalah+$BebanPenyisihanPiutanglainTdkBermasalah;

        $BebanPenyisihanPiutangsejakAwal = 
            $BebanPenyisihanPiutangindustri+
            $BebanPenyisihanPiutangperdagangan+
            $BebanPenyisihanPiutangpertanian+
            $BebanPenyisihanPiutangperkebunan+
            $BebanPenyisihanPiutangperikanan+
            $BebanPenyisihanPiutangpeternakan+
            $BebanPenyisihanPiutangjasa+
            $BebanPenyisihanPiutanglain; //disimpan ke lap aktivitas juga

        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanPenyisihanPiutangsejakAwal'  WHERE id='67'");//total BebanPenyisihanPiutang  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanPenyisihanPiutangindustri'  WHERE id='68'"); //industri
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanPenyisihanPiutangperdagangan'  WHERE id='69'");//
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanPenyisihanPiutangpertanian'  WHERE id='70'"); //
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanPenyisihanPiutangperkebunan'  WHERE id='71'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanPenyisihanPiutangperikanan'  WHERE id='72'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanPenyisihanPiutangpeternakan'  WHERE id='73'");//
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanPenyisihanPiutangjasa'  WHERE id='74'"); //
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanPenyisihanPiutanglain'  WHERE id='75'"); 

        // Line 2124
        $BebanLainlainProgramKemitraansejakAwal = $this->db->query("SELECT sd$bulansekarang FROM perubahanasetnetotidakterikat WHERE id='18'")->result_array()[0]['sd' . $bulansekarang];  //lain bermasalah
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanLainlainProgramKemitraansejakAwal'  WHERE id='76'");  
        $this->db->query("UPDATE catatanataslapkeu SET  $bulansekarang='$BebanLainlainProgramKemitraansejakAwal'  WHERE id='77'");  

        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$JasaAdmPinjaman'  WHERE id='1'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$PendapatanJasaGiro'  WHERE id='2'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$PendapatanLainlain'  WHERE id='3'");
        $Jumlah1=$JasaAdmPinjaman+$PendapatanJasaGiro+$PendapatanLainlain;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$Jumlah1'  WHERE id='4'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$PenyisihanAlokasiDanaBUMNPeduli'  WHERE id='6'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$PenyisihanANTTBerakhirPemenuhanProgram'  WHERE id='7'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$penyisihanANTTberakhirwaktu'  WHERE id='8'");
        $Jumlah2=$PenyisihanAlokasiDanaBUMNPeduli+$PenyisihanANTTBerakhirPemenuhanProgram+$penyisihanANTTberakhirwaktu;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$Jumlah2'  WHERE id='9'");
        $JumlahPendapatan=$Jumlah1+$Jumlah2;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$JumlahPendapatan'  WHERE id='10'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$DanaPembinaanKemitraan'  WHERE id='12'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$DanaBinaLingkungan'  WHERE id='13'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$BebanAdmdanUmum'  WHERE id='14'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$BebanPenyusutanAktivaTetapProgramKemitraan'  WHERE id='15'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$BebanPemeliharaanProgramKemitraan'  WHERE id='16'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$BebanPenyisihanPiutang'  WHERE id='17'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$BebanLainlainProgramKemitraan'  WHERE id='18'");
        $JumlahBeban=$DanaPembinaanKemitraan+$DanaBinaLingkungan+$BebanAdmdanUmum+$BebanPenyusutanAktivaTetapProgramKemitraan+
                            $BebanPemeliharaanProgramKemitraan+$BebanPenyisihanPiutang+$BebanLainlainProgramKemitraan;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$JumlahBeban'  WHERE id='19'");
        $KenaikanPenurunanAsetNetoTidakTerikat= $JumlahPendapatan+$JumlahBeban;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$KenaikanPenurunanAsetNetoTidakTerikat'  WHERE id='20'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$ANTterbebaskan'  WHERE id='22'");
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$ANTPenyisihanBUMNPeduli'  WHERE id='23'");
        $KenaikanPenurunanAsetNetoTerikatTemporer=$ANTterbebaskan+$ANTPenyisihanBUMNPeduli; 
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$KenaikanPenurunanAsetNetoTerikatTemporer'  WHERE id='24'");
        $Sumbanganterikat=0;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$Sumbanganterikat'  WHERE id='26'");
        $KenaikanPenurunanAsetNetoTerikatPermanen=$Sumbanganterikat;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  $bulansekarang='$KenaikanPenurunanAsetNetoTerikatPermanen'  WHERE id='27'");
        $KenaikanPenurunanAsetNeto=$KenaikanPenurunanAsetNetoTidakTerikat +$KenaikanPenurunanAsetNetoTerikatTemporer+
                    $KenaikanPenurunanAsetNetoTerikatPermanen;  
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET $bulansekarang='$KenaikanPenurunanAsetNeto'  WHERE id='28'");

        $AsetNetoAkhirTahunBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='30'")->result_array()[0][$bulansebelumnya];
        $AsetNetoAwalTahun = $AsetNetoAkhirTahunBulanSebelumnya;
        
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET $bulansekarang='$AsetNetoAwalTahun'  WHERE id='29'");
        $AsetNetoAkhirTahun = $AsetNetoAwalTahun + $KenaikanPenurunanAsetNeto;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET $bulansekarang='$AsetNetoAkhirTahun'  WHERE id='30'");

        // DARI SINI
        $PendapatanJasaAdministrasiPinjamanProgramKemitraansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='1'")->result_array()[0]['sd' . $bulansebelumnya];
        $PendapatanJasaAdministrasiPinjamanProgramKemitraansd = $PendapatanJasaAdministrasiPinjamanProgramKemitraansdBulanSebelumnya + $JasaAdmPinjaman;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET sd$bulansekarang='$PendapatanJasaAdministrasiPinjamanProgramKemitraansd'  WHERE id='1'");

        $PendapatanBungasdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='2'")->result_array()[0]['sd' . $bulansebelumnya];     
        $PendapatanBungasd=$PendapatanBungasdBulanSebelumnya+$PendapatanJasaGiro;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$PendapatanBungasd'  WHERE id='2'");

        $PendapatanLainlainsdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='3'")->result_array()[0]['sd' . $bulansebelumnya];
        $PendapatanLainlainsd=$PendapatanLainlainsdBulanSebelumnya+$PendapatanLainlain;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$PendapatanLainlainsd'  WHERE id='3'");

        $Jumlah1sd= $PendapatanLainlainsd+$PendapatanBungasd+$PendapatanJasaAdministrasiPinjamanProgramKemitraansd;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$Jumlah1sd'  WHERE id='4'");

        $PenyisihanAlokasiDanaBUMNPedulisdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='6'")->result_array()[0]['sd' . $bulansebelumnya];
        $PenyisihanAlokasiDanaBUMNPedulisd=$PenyisihanAlokasiDanaBUMNPedulisdBulanSebelumnya+$PenyisihanAlokasiDanaBUMNPeduli;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$PenyisihanAlokasiDanaBUMNPedulisd'  WHERE id='6'");

        $PenyisihanANTTBerakhirPemenuhanProgramsdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='7'")->result_array()[0]['sd' . $bulansebelumnya];
        $PenyisihanANTTBerakhirPemenuhanProgramsd=$PenyisihanANTTBerakhirPemenuhanProgramsdBulanSebelumnya+$PenyisihanANTTBerakhirPemenuhanProgram;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$PenyisihanANTTBerakhirPemenuhanProgramsd'  WHERE id='7'");

        $penyisihanANTTberakhirwaktusdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='8'")->result_array()[0]['sd' . $bulansebelumnya];
        $penyisihanANTTberakhirwaktusd=$penyisihanANTTberakhirwaktusdBulanSebelumnya+$penyisihanANTTberakhirwaktu;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$penyisihanANTTberakhirwaktusd'  WHERE id='8'");

        $jumlah2sdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='9'")->result_array()[0]['sd' . $bulansebelumnya];
        $jumlah2sd=$jumlah2sdBulanSebelumnya+$Jumlah2;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$jumlah2sd'  WHERE id='9'");

        $JumlahPendapatansd=$jumlah2sd+$Jumlah1sd; 
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$JumlahPendapatansd'  WHERE id='10'");

        $DanaPembinaanKemitraansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='12'")->result_array()[0]['sd' . $bulansebelumnya];
        $DanaPembinaanKemitraansd=$DanaPembinaanKemitraansdBulanSebelumnya+$DanaPembinaanKemitraan;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$DanaPembinaanKemitraansd'  WHERE id='12'");

        $DanaBinaLingkungansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='13'")->result_array()[0]['sd' . $bulansebelumnya];
        $DanaBinaLingkungansd=$DanaBinaLingkungansdBulanSebelumnya+$DanaBinaLingkungan;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$DanaBinaLingkungansd'  WHERE id='13'");

        $BebanAdmdanUmumsdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='14'")->result_array()[0]['sd' . $bulansebelumnya];
        $BebanAdmdanUmumsd=$BebanAdmdanUmumsdBulanSebelumnya+$BebanAdmdanUmum;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$BebanAdmdanUmumsd'  WHERE id='14'");

        $BebanPenyusutanAktivaTetapProgramKemitraansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='15'")->result_array()[0]['sd' . $bulansebelumnya];
        $BebanPenyusutanAktivaTetapProgramKemitraansd=$BebanPenyusutanAktivaTetapProgramKemitraansdBulanSebelumnya+$BebanPenyusutanAktivaTetapProgramKemitraan;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$BebanPenyusutanAktivaTetapProgramKemitraansd'  WHERE id='15'");

        $BebanPemeliharaanProgramKemitraansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='16'")->result_array()[0]['sd' . $bulansebelumnya];
        $BebanPemeliharaanProgramKemitraansd=$BebanPemeliharaanProgramKemitraansdBulanSebelumnya+$BebanPemeliharaanProgramKemitraan;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$BebanPemeliharaanProgramKemitraansd'  WHERE id='16'");

        $BebanPenyisihanPiutangsdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='17'")->result_array()[0]['sd' . $bulansebelumnya];
        $BebanPenyisihanPiutangsd=$BebanPenyisihanPiutangsdBulanSebelumnya+$BebanPenyisihanPiutang;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$BebanPenyisihanPiutangsd'  WHERE id='17'");

        $BebanLainlainProgramKemitraansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='18'")->result_array()[0]['sd' . $bulansebelumnya];
        $BebanDanPengeluaranLainsd=$BebanLainlainProgramKemitraansdBulanSebelumnya+$BebanLainlainProgramKemitraan;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$BebanDanPengeluaranLainsd'  WHERE id='18'");

        $JumlahBebansd=$BebanDanPengeluaranLainsd+$BebanPenyisihanPiutangsd+$BebanPemeliharaanProgramKemitraansd+$BebanPenyusutanAktivaTetapProgramKemitraansd+$BebanAdmdanUmumsd+$DanaBinaLingkungansd+$DanaPembinaanKemitraansd;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$JumlahBebansd'  WHERE id='19'");

        $KenaikanPenurunanAsetNetoTidakTerikatsd=$JumlahBebansd+$JumlahPendapatansd;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$KenaikanPenurunanAsetNetoTidakTerikatsd'  WHERE id='20'");

        $ANTterbebaskansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='22'")->result_array()[0]['sd' . $bulansebelumnya];
        $ANTterbebaskansd=$ANTterbebaskansdBulanSebelumnya+$ANTterbebaskan;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$ANTterbebaskansd'  WHERE id='22'");

        $ANTPenyisihanBUMNPedulisdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='23'")->result_array()[0]['sd' . $bulansebelumnya];
        $ANTPenyisihanBUMNPedulisd=$ANTPenyisihanBUMNPedulisdBulanSebelumnya+$ANTPenyisihanBUMNPeduli;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$ANTPenyisihanBUMNPedulisd'  WHERE id='23'");

        $KenaikanPenurunanAsetNetoTerikatTemporersdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='24'")->result_array()[0]['sd' . $bulansebelumnya];
        $KenaikanPenurunanAsetNetoTerikatTemporersd=$KenaikanPenurunanAsetNetoTerikatTemporersdBulanSebelumnya+$KenaikanPenurunanAsetNetoTerikatTemporer;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$KenaikanPenurunanAsetNetoTerikatTemporersd'  WHERE id='24'");

        $SumbanganterikatsdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='26'")->result_array()[0]['sd' . $bulansebelumnya];
        $Sumbanganterikatsd=$SumbanganterikatsdBulanSebelumnya+$Sumbanganterikat;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$Sumbanganterikatsd'  WHERE id='26'");

        $KenaikanPenurunanAsetNetoTerikatPermanensdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM perubahanasetnetotidakterikat WHERE id='27'")->result_array()[0]['sd' . $bulansebelumnya];
        $KenaikanPenurunanAsetNetoTerikatPermanensd=$KenaikanPenurunanAsetNetoTerikatPermanensdBulanSebelumnya+$KenaikanPenurunanAsetNetoTerikatPermanen;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET  sd$bulansekarang='$KenaikanPenurunanAsetNetoTerikatPermanensd'  WHERE id='27'");

        $KenaikanPenurunanAsetNetosd=$KenaikanPenurunanAsetNetoTidakTerikatsd+$KenaikanPenurunanAsetNetoTerikatPermanensd+$KenaikanPenurunanAsetNetoTerikatTemporersd;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET sd$bulansekarang='$KenaikanPenurunanAsetNetosd'  WHERE id='28'");

        $AsetNetoAkhirTahunsdDesTahunLalu = $this->db->query("SELECT sd$desTahunLalu FROM perubahanasetnetotidakterikat WHERE id='30'")->result_array()[0]['sd' . $desTahunLalu];//BACA id 30 bulan lalu, simpan ke id 29 bulan ini, AsetNetoAkhirTahunDes2021(BulanSebelumnya dipakai di jul2022->result_array()[0]['sd' . $bulansebelumnya])
        $AsetNetoAwalTahunsd= $AsetNetoAkhirTahunsdDesTahunLalu; // dari bulan lalu-ASET NETO AKHIR TAHUN(paling bwh)
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET       sd$bulansekarang='$AsetNetoAwalTahunsd'  WHERE id='29'");

        $AsetNetoAkhirTahunsd=$AsetNetoAwalTahunsd+$KenaikanPenurunanAsetNetosd;
        $this->db->query("UPDATE perubahanasetnetotidakterikat SET       sd$bulansekarang='$AsetNetoAkhirTahun'  WHERE id='30'");

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang=$pengembalianPinjamanMB  WHERE id='2'");
        $pengembalianPinjamanMBsdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='2'")->result_array()[0]['sd' . $bulansebelumnya];
        $pengembalianPinjamanMBsd=$pengembalianPinjamanMBsdBulanSebelumnya+
                                        $pengembalianPinjamanMB;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$pengembalianPinjamanMBsd'  WHERE id='2'");
        $this->db->query("UPDATE danatersedia SET  $bulansekarang=$pengembalianPinjamanMBsd  WHERE id='5'");
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang=$KewajibanJangkaPendekAngsuranBelumTeridentifikasi  WHERE id='3'");

        $KewajibanJangkaPendekAngsuranBelumTeridentifikasisdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='3'")->result_array()[0]['sd' . $bulansebelumnya];
        $KewajibanJangkaPendekAngsuranBelumTeridentifikasisd=$KewajibanJangkaPendekAngsuranBelumTeridentifikasisdBulanSebelumnya+$KewajibanJangkaPendekAngsuranBelumTeridentifikasi;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$KewajibanJangkaPendekAngsuranBelumTeridentifikasisd'  WHERE id='3'");
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang=$JasaAdmPinjaman  WHERE id='4'");

        $PendapatanJasaAdministrasiPinjamanProgramKemitraansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='4'")->result_array()[0]['sd' . $bulansebelumnya];
        $PendapatanJasaAdministrasiPinjamanProgramKemitraansd=$PendapatanJasaAdministrasiPinjamanProgramKemitraansdBulanSebelumnya+$JasaAdmPinjaman;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$PendapatanJasaAdministrasiPinjamanProgramKemitraansd' WHERE id='4'");

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$PendapatanJasaGiro'  WHERE id='5'");//Jasa Giro
        $PendapatanJasaGirosdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='5'")->result_array()[0]['sd' . $bulansebelumnya];
        $PendapatanJasaGirosd= floor($PendapatanJasaGirosdBulanSebelumnya)+ floor($PendapatanJasaGiro);

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$PendapatanJasaGirosd' WHERE id='5'");

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$PendapatanLainlain'  WHERE id='6'");
        $PendapatanLainlainsdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='6'")->result_array()[0]['sd' . $bulansebelumnya];
        $PendapatanLainlainsd=$PendapatanLainlainsdBulanSebelumnya+$PendapatanLainlain;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$PendapatanLainlainsd' WHERE id='6'");

        $PiutangMitraBinaanPinjaman=0-$PiutangMitraBinaanPinjaman;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$PiutangMitraBinaanPinjaman'  WHERE id='9'");// penyaluran pinj kemitraan=PiutangMitraBinaanPinjaman

        $PiutangMitraBinaanPinjamansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='9'")->result_array()[0]['sd' . $bulansebelumnya];
        $PiutangMitraBinaanPinjamansd=$PiutangMitraBinaanPinjamansdBulanSebelumnya+$PiutangMitraBinaanPinjaman;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$PiutangMitraBinaanPinjamansd' WHERE id='9'");
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$DanaPembinaanKemitraan'  WHERE id='10'");
        
        $DanaPembinaanKemitraansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='10'")->result_array()[0]['sd' . $bulansebelumnya];
        $DanaPembinaanKemitraansd=$DanaPembinaanKemitraansdBulanSebelumnya+$DanaPembinaanKemitraan;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$DanaPembinaanKemitraansd' WHERE id='10'");

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$DanaBinaLingkungan'  WHERE id='11'");
        $DanaBinaLingkungansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='11'")->result_array()[0]['sd' . $bulansebelumnya];
        $DanaBinaLingkungansd=$DanaBinaLingkungansdBulanSebelumnya+$DanaBinaLingkungan;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$DanaBinaLingkungansd' WHERE id='11'");

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$BebanPembinaan'  WHERE id='12'");
        $BebanPembinaansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='12'")->result_array()[0]['sd' . $bulansebelumnya];
        $BebanPembinaansd=$BebanPembinaansdBulanSebelumnya+$BebanPembinaan;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$BebanPembinaansd' WHERE id='12'");

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$BebanUpahTenagakerja'  WHERE id='13'");
        $BebanUpahTenagakerjasdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='13'")->result_array()[0]['sd' . $bulansebelumnya];
        $BebanUpahTenagakerjasd=$BebanUpahTenagakerjasdBulanSebelumnya+$BebanUpahTenagakerja;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$BebanUpahTenagakerjasd' WHERE id='13'");

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$BebanAdmdanUmum'  WHERE id='14'");
        $BebanAdmdanUmumsdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='14'")->result_array()[0]['sd' . $bulansebelumnya];
        $BebanAdmdanUmumsd=$BebanAdmdanUmumsdBulanSebelumnya+$BebanAdmdanUmum;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$BebanAdmdanUmumsd' WHERE id='14'");

        $PendapatanTotalLainlainsd=$PendapatanLainlainsd+ $BebanAdmdanUmumsd;
        $this->db->query("UPDATE danatersedia SET  $bulansekarang='$PendapatanTotalLainlainsd' WHERE id='4'");

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$BebanPemeliharaanProgramKemitraan'  WHERE id='15'");
        $BebanPemeliharaanProgramKemitraansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='15'")->result_array()[0]['sd' . $bulansebelumnya];
        $BebanPemeliharaanProgramKemitraansd=$BebanPemeliharaanProgramKemitraansdBulanSebelumnya+$BebanPemeliharaanProgramKemitraan;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$BebanPemeliharaanProgramKemitraansd' WHERE id='15'");

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$PengembalianKelebihanAngsuran'  WHERE id='16'");
        $PengembalianKelebihanAngsuransdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='16'")->result_array()[0]['sd' . $bulansebelumnya];
        $PengembalianKelebihanAngsuransd=$PengembalianKelebihanAngsuransdBulanSebelumnya+$PengembalianKelebihanAngsuran;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$PengembalianKelebihanAngsuransd' WHERE id='16'");

        $kasNetoDiterimaDigunakanUtkAktivitasOps=$PengembalianKelebihanAngsuran
            +$BebanPemeliharaanProgramKemitraan
            +$BebanAdmdanUmum+$BebanUpahTenagakerja
            +$DanaPembinaanKemitraan 
            +$BebanPembinaan
            +$DanaBinaLingkungan
            +$pengembalianPinjamanMB
            +$KewajibanJangkaPendekAngsuranBelumTeridentifikasi
            +$JasaAdmPinjaman+$PendapatanJasaGiro
            +$PendapatanLainlain
            +$PiutangMitraBinaanPinjaman
            +$DanaPembinaanKemitraan;

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$kasNetoDiterimaDigunakanUtkAktivitasOps'  WHERE id='17'");
        $kasNetoDiterimaDigunakanUtkAktivitasOpssdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='17'")->result_array()[0]['sd' . $bulansebelumnya];
        $kasNetoDiterimaDigunakanUtkAktivitasOpssd=$kasNetoDiterimaDigunakanUtkAktivitasOpssdBulanSebelumnya+$kasNetoDiterimaDigunakanUtkAktivitasOps;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$kasNetoDiterimaDigunakanUtkAktivitasOpssd' WHERE id='17'");
        
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$AktivaTetapHargaPerolehan'  WHERE id='20'");
        $AktivaTetapHargaPerolehansdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='20'")->result_array()[0]['sd' . $bulansebelumnya];

        $AktivaTetapHargaPerolehansd=$AktivaTetapHargaPerolehansdBulanSebelumnya+$AktivaTetapHargaPerolehan;

        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$AktivaTetapHargaPerolehansd' WHERE id='20'");

        $KasNetoDiterimaDigunakanUntukAktivitasInvestasi=$AktivaTetapHargaPerolehan;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$KasNetoDiterimaDigunakanUntukAktivitasInvestasi'  WHERE id='21'");
        $KasNetoDiterimaDigunakanUntukAktivitasInvestasisdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='21'")->result_array()[0]['sd' . $bulansebelumnya];
        $KasNetoDiterimaDigunakanUntukAktivitasInvestasisd=$KasNetoDiterimaDigunakanUntukAktivitasInvestasisdBulanSebelumnya+$KasNetoDiterimaDigunakanUntukAktivitasInvestasi;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$KasNetoDiterimaDigunakanUntukAktivitasInvestasisd' WHERE id='21'");
            
        $KenaikanPenurunanAsetNetoDalamKas=$KasNetoDiterimaDigunakanUntukAktivitasInvestasi+$kasNetoDiterimaDigunakanUtkAktivitasOps;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$KenaikanPenurunanAsetNetoDalamKas'  WHERE id='22'");
        $KenaikanPenurunanAsetNetoDalamKassdBulanSebelumnya = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='22'")->result_array()[0]['sd' . $bulansebelumnya];
        $KenaikanPenurunanAsetNetoDalamKassd=$KenaikanPenurunanAsetNetoDalamKassdBulanSebelumnya+$KenaikanPenurunanAsetNetoDalamKas;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$KenaikanPenurunanAsetNetoDalamKassd' WHERE id='22'");

        $kasDanSetaraKasPadaAkhirTahunBulanSebelumya = $this->db->query("SELECT $bulansebelumnya FROM aktivitasoperasikasditerima WHERE id='24'")->result_array()[0][$bulansebelumnya]; //
        $KasDanSetarasKasPadaAwalTahun=$kasDanSetaraKasPadaAkhirTahunBulanSebelumya;// dari bulan lalu, kas dan setara kas pada akhir tahun
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$KasDanSetarasKasPadaAwalTahun'  WHERE id='23'");

        $SaldoAwal22 = $this->db->query("SELECT $desTahunLalu FROM aktivitasoperasikasditerima WHERE id='24'")->result_array()[0][$desTahunLalu]; //
        $this->db->query("UPDATE danatersedia  SET  $bulansekarang='$SaldoAwal22'  WHERE id='1'");
        $KasDanSetaraKasPadaAkhirTahun=$KasDanSetarasKasPadaAwalTahun + $KenaikanPenurunanAsetNetoDalamKas;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  $bulansekarang='$KasDanSetaraKasPadaAkhirTahun' WHERE id='24'");

        $kasDanSetaraKasPadaAkhirTahunsdDesTahunLalu = $this->db->query("SELECT sd$desTahunLalu FROM aktivitasoperasikasditerima WHERE id='24'")->result_array()[0]['sd' . $desTahunLalu]; //
        $KasDanSetarasKasPadaAwalTahunsd=$kasDanSetaraKasPadaAkhirTahunsdDesTahunLalu;// dari bulan lalu, kas dan setara kas pada akhir tahun
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$KasDanSetarasKasPadaAwalTahunsd'  WHERE id='23'");
        $KasDanSetaraKasPadaAkhirTahunsd=$KasDanSetarasKasPadaAwalTahunsd + $KenaikanPenurunanAsetNetoDalamKassd;
        $this->db->query("UPDATE aktivitasoperasikasditerima SET  sd$bulansekarang='$KasDanSetaraKasPadaAkhirTahunsd' WHERE id='24'");

        // DARI SINI LAGi
        $this->db->query("UPDATE neraca SET $bulansekarang='$saldokas'     WHERE id='1'");//SIMPAN KAS 
        $this->db->query("UPDATE neraca SET $bulansekarang='$totsaldobank' WHERE id='2'");//SIMPAN BANK 
        $this->db->query("UPDATE neraca SET $bulansekarang='$totalsaldopokoktdkbermasalah' WHERE id='3'");
        // $this->db->query("UPDATE neraca SET real$bulansekarang ='$totalsaldopokoktdkbermasalah' WHERE id='3'");
        // $this->db->query("UPDATE neraca SET realsd$bulansekarang='$totalsaldopokoktdkbermasalah' WHERE id='3'");

        // TODO: Ganti Disini
        $rkajanpiutangpinjamanmitra = $this->db->query("SELECT rkajan22 FROM neraca WHERE id='3'")->result_array()[0]['rkajan22'];;   
        $prosenpiutangpinjamanmitra=($totalsaldopokoktdkbermasalah/$rkajanpiutangpinjamanmitra)*100;

        $this->db->query("UPDATE neraca SET prosen$bulansekarang='$prosenpiutangpinjamanmitra' WHERE id='3'");
        $this->db->query("UPDATE neraca SET prosensd$bulansekarang='$prosenpiutangpinjamanmitra' WHERE id='3'");        

        $alokasiPenyisihanPiutangPinjMB = $this->db->query("SELECT $bulansekarang FROM neraca WHERE id='4'")->result_array()[0][$bulansekarang];   
        $totAsetLancar = $saldokas + $totsaldobank + $totalsaldopokoktdkbermasalah + $alokasiPenyisihanPiutangPinjMB;
        $this->db->query("UPDATE neraca SET $bulansekarang='$totAsetLancar' WHERE id='5'");

        $this->db->query("UPDATE neraca SET $bulansekarang='$AktivaTetapHargaPerolehanInventarisKantor' WHERE id='7'");//fix
        $this->db->query("UPDATE neraca SET $bulansekarang='$akumPenyusutanInvPeralatan' WHERE id='8'");
        $this->db->query("UPDATE neraca SET $bulansekarang='$JumlahAsetTetapBersih' WHERE id='9'");

        $this->db->query("UPDATE neraca SET $bulansekarang='$totnilsaldopokok_bermasalah' WHERE id='11'");

        // $this->db->query("UPDATE neraca SET real$bulansekarang='$totnilsaldopokok_bermasalah' WHERE id='11'");
        // TODO: Ganti Disini
        $rkajanpiutangmitrabermasalah = $this->db->query("SELECT rkajan22 FROM neraca WHERE id='11'")->result_array()[0]['rkajan22'];   
        $prosenpiutangpinjamanmitrabermasalah=($totnilsaldopokok_bermasalah/$rkajanpiutangmitrabermasalah)*100;
        
        $this->db->query("UPDATE neraca SET prosen$bulansekarang='$prosenpiutangpinjamanmitrabermasalah' WHERE id='11'");
        $this->db->query("UPDATE neraca SET prosensd$bulansekarang='$prosenpiutangpinjamanmitrabermasalah' WHERE id='11'");   

        $alokPenyisihanPiutangbermasalah = 0 - $totnilsaldopokok_bermasalah;

        $this->db->query("UPDATE neraca SET $bulansekarang='$alokPenyisihanPiutangbermasalah' WHERE id='12'");//pinj bermasalah
        $jumlahAsetLain=$totnilsaldopokok_bermasalah+$alokPenyisihanPiutangbermasalah;//13
        $this->db->query("UPDATE neraca SET $bulansekarang='$jumlahAsetLain' WHERE id='13'");//   
        $JumlahAset=$totAsetLancar+$jumlahAsetLain;//14
        $this->db->query("UPDATE neraca SET $bulansekarang='$JumlahAset' WHERE id='14'");//   
        $this->db->query("UPDATE neraca SET $bulansekarang='$KelebihanPembayaranAngsuran' WHERE id='17'");// 
        $this->db->query("UPDATE neraca SET $bulansekarang='$KewajibanJangkaPendekAngsuranBelumTeridentifikasisejakAwal' WHERE id='18'");//
        $this->db->query("UPDATE neraca SET $bulansekarang='$KewajibanjangkaPanjangProgramKemitraan' WHERE id='19'");
        $jumlahLiabilitas = $KewajibanjangkaPanjangProgramKemitraan + $KewajibanJangkaPendekAngsuranBelumTeridentifikasisejakAwal + $KelebihanPembayaranAngsuran;
        $this->db->query("UPDATE neraca SET $bulansekarang='$jumlahLiabilitas' WHERE id='20'");// 
        $this->db->query("UPDATE neraca SET $bulansekarang='$asetNetoTerikat' WHERE id='22'");//  

        $AsetNetoTidakTerikatsd = $this->db->query("SELECT sd$bulansekarang FROM perubahanasetnetotidakterikat WHERE id='30'")->result_array()[0]['sd' . $bulansekarang];//aset neto tidak terikat pada bulan yg sama, SD ags22
    
        $this->db->query("UPDATE neraca SET $bulansekarang='$AsetNetoTidakTerikatsd' WHERE id='23'");//   
        $jumlahAsetNeto = $asetNetoTerikat + $AsetNetoTidakTerikatsd;
        $this->db->query("UPDATE neraca SET $bulansekarang='$jumlahAsetNeto' WHERE id='24'");// 

        $jumlahLiabilitasDanAsetNeto = $jumlahAsetNeto + $jumlahLiabilitas;
        $this->db->query("UPDATE neraca SET $bulansekarang='$jumlahLiabilitasDanAsetNeto' WHERE id='25'");//  

        $timbangKurangLancar= 0.75* $tingkatpengembalianpinjamanMBKurangLancar;
        $timbangDiragukan   = 0.25 * $tingkatpengembalianpinjamanMBDiragukan;
        $TotTimbang         = $tingkatpengembalianpinjamanMBLancar+$timbangKurangLancar+$timbangDiragukan;

        if ($tingkatpengembalianpinjamanMBtotal==0){
            $tingkatpengembalianpinjamanMBtotal=1;
        }

        $tingkatpengembalianpinjamanMBtotal=$totalsaldopokoktdkbermasalah;
        $kolektibilitasakhir=($TotTimbang/$tingkatpengembalianpinjamanMBtotal)*100;

        $this->db->query("UPDATE tingkatpengembalianhasil SET $bulansekarang='$tingkatpengembalianpinjamanMBLancar' WHERE id='1'"); // 
        $this->db->query("UPDATE tingkatpengembalianhasil SET timbang$bulansekarang='$tingkatpengembalianpinjamanMBLancar' WHERE id='1'"); //    
        $this->db->query("UPDATE tingkatpengembalianhasil SET $bulansekarang='$tingkatpengembalianpinjamanMBKurangLancar' WHERE id='2'");//
        $this->db->query("UPDATE tingkatpengembalianhasil SET timbang$bulansekarang='$timbangKurangLancar' WHERE id='2'");//
        $this->db->query("UPDATE tingkatpengembalianhasil SET $bulansekarang='$tingkatpengembalianpinjamanMBDiragukan' WHERE id='3'");//
        $this->db->query("UPDATE tingkatpengembalianhasil SET timbang$bulansekarang='$timbangDiragukan' WHERE id='3'");//
        $this->db->query("UPDATE tingkatpengembalianhasil SET $bulansekarang='$tingkatpengembalianpinjamanMBMacet' WHERE id='4'");//
        $this->db->query("UPDATE tingkatpengembalianhasil SET timbang$bulansekarang='0' WHERE id='4'");//selalu NOL
        $this->db->query("UPDATE tingkatpengembalianhasil SET $bulansekarang='$tingkatpengembalianpinjamanMBtotal' WHERE id='5'");//
        $this->db->query("UPDATE tingkatpengembalianhasil SET timbang$bulansekarang='$TotTimbang' WHERE id='5'");

        if($kolektibilitasakhir<=100 AND $kolektibilitasakhir>=70){
            $skor=3;
        }
        if($kolektibilitasakhir<70 AND $kolektibilitasakhir>=40){
            $skor=2;
        }
        if($kolektibilitasakhir<40 AND $kolektibilitasakhir>=10){
            $skor=1;
        }
        if($kolektibilitasakhir<10 AND $kolektibilitasakhir>=0){
            $skor=0;
        }

        $this->db->query("UPDATE tingkatpengembalianhasil SET $bulansekarang= '$kolektibilitasakhir' WHERE id='6'");
        $this->db->query("UPDATE tingkatpengembalianhasil SET $bulansekarang= '$skor' WHERE id='7'");

        $this->db->query("UPDATE danayangdisalurkan SET $bulansekarang='$PiutangMitraBinaanPinjamansejakAwal' WHERE id='1'"); //penyaluran pinjaman

        $this->db->query("UPDATE danayangdisalurkan SET $bulansekarang='$DanaPembinaanKemitraan' WHERE id='2'");//
        $JumlahDanaYgDisalurkan=$PiutangMitraBinaanPinjamansejakAwal+$DanaPembinaanKemitraan;
        $this->db->query("UPDATE danayangdisalurkan SET $bulansekarang='$JumlahDanaYgDisalurkan' WHERE id='3'");

        $KasBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='1'")->result_array()[0][$bulansebelumnya];//kas bulan sebelumnya
        $BankBulanSebelumnya = $this->db->query("SELECT $bulansebelumnya FROM catatanataslapkeu WHERE id='3'")->result_array()[0][$bulansebelumnya];//bank bulan sebelumnya

        $saldoAwal = $this->db->query("SELECT sd$bulansebelumnya FROM aktivitasoperasikasditerima WHERE id=23")->result_array()[0]['sd' . $bulansebelumnya];//KAS DAN SETARA KAS PADA AWAL TAHUN
        $saldoAwal=$kasDanSetaraKasPadaAwalTahun;

        $this->db->query("UPDATE danatersedia SET  $bulansekarang='$JasaAdmPinjamansejakAwal'  WHERE id='2'");  
        $PendapatanJasaGirosejakAwal=$PendapatanJasaGirosd;

        $this->db->query("UPDATE danatersedia SET  $bulansekarang='$PendapatanJasaGirosejakAwal'  WHERE id='3'");  

        $PendapatanLainlainsejakAwal=$PendapatanLainlainsd;
        $pengembalianPinjamanMBsejakAwal=$pengembalianPinjamanMBsd;

        $jumlahDanaTersedia=$SaldoAwal22+
                                $JasaAdmPinjamansejakAwal+
                                $PendapatanJasaGirosejakAwal+
                                $PendapatanTotalLainlainsd+
                                $pengembalianPinjamanMBsejakAwal;

        $this->db->query("UPDATE danatersedia SET  $bulansekarang='$jumlahDanaTersedia'  WHERE id='6'");  

        $prosentaseEffektivitasPenyaluranDana=($JumlahDanaYgDisalurkan/$jumlahDanaTersedia )*100;
        $this->db->query("UPDATE danatersedia SET  $bulansekarang='$prosentaseEffektivitasPenyaluranDana'  WHERE id='7'");

        if($prosentaseEffektivitasPenyaluranDana>=90 AND $prosentaseEffektivitasPenyaluranDana<=100)  
        {
            $skor=3;     
        }
        if($prosentaseEffektivitasPenyaluranDana>=85 AND $prosentaseEffektivitasPenyaluranDana<90)  
        {
            $skor=2;     
        }
        if($prosentaseEffektivitasPenyaluranDana>=80 AND $prosentaseEffektivitasPenyaluranDana<85)  
        {
            $skor=1;     
        }
        if($prosentaseEffektivitasPenyaluranDana>=0 AND $prosentaseEffektivitasPenyaluranDana<80)  
        {
            $skor=0;     
        }

        $this->db->query("UPDATE danatersedia SET  $bulansekarang='$skor'  WHERE id='8'"); 

	}

    private function _updateSaldo($akun){
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

		$opex = $this->saldo_model->getJurnalByAkun($id_akun);
		$saldo = $opex[0]->saldo + $saldoawal;

		if ($akun == 'kas') {	
			$this->db->set('kaskecil', $saldo);
			$this->db->where('perioda', date("M Y", mktime(0, 0, 0, date('m'), 0, date('Y'))));	
			$this->db->update('saldokasbank');
		} elseif ($akun == 'mandiri') {
			$this->db->set('mandiri', $saldo);
			$this->db->where('perioda', date("M Y", mktime(0, 0, 0, date('m'), 0, date('Y'))));
			$this->db->update('saldokasbank');
		} elseif ($akun == 'bri') {
			$this->db->set('bri', $saldo);
			$this->db->where('perioda', date("M Y", mktime(0, 0, 0, date('m'), 0, date('Y'))));
			$this->db->update('saldokasbank');
		}
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
