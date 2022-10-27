<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitra extends CI_Controller {

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

			$this->data['profile_name'] = $this->tank_auth->get_username();
			$this->data['profile_foto'] = 'no_image.jpg';
			$this->data['role_id'] = 2;
			$this->data['role'] = 'Mitra';
			$this->data['full_name_role'] = 'Mitra Binaan';
			$this->load->model('MitraModel', 'mitra_model');

		}
	}

	public function index(){
        $no_kontrak = $this->tank_auth->get_user_id();
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

		$this->template->load('mitra/cicilan', $this->data);
	}

	public function laporan(){
		$this->data['title'] = 'Laporan';
		$this->data['header'] = 'Laporan';
		$this->data['mitra'] = $this->mitra_model->getMitra($this->session->userdata('id_user'));
		$this->data['laporan'] = $this->db->query("SELECT * FROM updatetriwulanmitra WHERE nokontrak=" . $this->data['user_id'])->result_array();

		$this->template->load('mitra/laporan_triwulan', $this->data);
	}

	public function cetakcicilan(){
		$nokontrak = $this->tank_auth->get_user_id();
		$mitra = $this->mitra_model->getMitraKontrak($nokontrak);
		$angsuran = $this->mitra_model->getOpexCicilanMitra($nokontrak);
		$this->load->view('mitra/cetak_cicilan', compact('mitra', 'angsuran'));
	}

    public function tambahtriwulan(){
        $this->data['title'] = 'Tambah Triwulan';
        $this->template->load('mitra/create_triwulan', $this->data);
    }

    public function storetriwulan(){
        $this->load->model('MitraModel', 'mitra_model');
        $this->mitra_model->sroreTriwulan(
            [
                "nokontrak" => $this->tank_auth->get_user_id(),
                "tgl" => $this->input->post('tgl'),
                "laplabarugi" => 'LAPORAN LABA RUGI',
                "omset" => $this->input->post('omset'),
                "hpp" => $this->input->post('hpp'),
                "labakotor" => $this->input->post('labakotor'),
                "bebanpenjualan" => $this->input->post('bebanpenjualan'),
                "bebanadmumum" => $this->input->post('bebanadmumum'),
                "totalbebanops" => $this->input->post('totalbebanops'),
                "pendptanlain" => $this->input->post('pendptanlain'),
                "bebanlain" => $this->input->post('bebanlain'),
                "labasblmpajak" => $this->input->post('labasblmpajak'),
                "pajak" => $this->input->post('pajak'),
                "lababersih" => $this->input->post('lababersih'),
                "laposkeu" => 'LAPORAN POSISI KEUANGAN',
                "asetlancar" => $this->input->post('asetlancar'),
                "asettetap" => $this->input->post('asettetap'),
                "jumlahaset" => $this->input->post('jumlahaset'),
                "liabilitasdanekuitas" => $this->input->post('liabilitasdanekuitas'),
                "liabilitas" => $this->input->post('liabilitas'),
                "hutangusaha" => $this->input->post('hutangusaha'),
                "hutangbank" => $this->input->post('hutangbank'),
                "jumlahliabilitas" => $this->input->post('jumlahliabilitas'),
                "ekuitas" => $this->input->post('ekuitas'),
                "jumlahliabilitasdanekuitas" => $this->input->post('jumlahliabilitasdanekuitas'),
                "labaops" => $this->input->post('labaops'),
                "laparuskas" => 'LAPORAN ARUS KAS',
                "aruskasdariaktops" => 'ARUS KAS DARI AKTIVITAS OPS',
                "bertambahops" => $this->input->post('bertambahops'),
                "berkurangops" => $this->input->post('berkurangops'),
                "aruskasbersihaktops" => $this->input->post('aruskasbersihaktops'),
                "aruskasdraktinvest" => 'ARUS KAS DARI AKTIVITAS INVESTASI',
                "bertambahinvest" => $this->input->post('bertambahinvest'),
                "berkuranginvest" => $this->input->post('berkuranginvest'),
                "aruskasbersihaktinvest" => $this->input->post('aruskasbersihaktinvest'),
                "aruskasdraktpendanaan" => 'ARUS KAS DARI AKTIVITAS PENDANAAN',
                "bertambahpendanaan" => $this->input->post('bertambahpendanaan'),
                "berkurangpendanaan" => $this->input->post('berkurangpendanaan'),
                "aruskasbersihdrpendanaan" => $this->input->post('aruskasbersihdrpendanaan'),
                "totalaruskas" => $this->input->post('totalaruskas'),
                "kasawalperioda" => $this->input->post('kasawalperioda'),
                "kasakhirperioda" => $this->input->post('kasakhirperioda'),
                "masalah" => $this->input->post('masalah'),
                "solusi" => $this->input->post('solusi'),
                "support" => $this->input->post('support'),
                "tglupdate" => date('Y-m-d H:i:s'),
            ]
        );

        $this->session->set_flashdata('message', 'Data berhasil ditambahkan');
        return redirect('mitra');
    }

}
