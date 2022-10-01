<section class="section">
    <div class="section-header">
        <h1>Input Data Laporan Triwulan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('Mitra') ?>">Mitra</a></div>
            <div class="breadcrumb-item">Input Data Laporan Triwulan</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Laporan Triwulan Mitra</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('mitra/storetriwulan') ?>" method="post">
                            <div class="form-group">
                                <label>Tanggal Laporan (Triwulan 1 (jan-mar), 2 (apr-jun), 3 (jul-sep), 4 (okt-des))          :</label>
                                <input type="date" class="form-control" name="tgl" >
                            </div>
                            
                            <label><h6>LABA RUGI</h6></label>

                            <div class="form-group">
                                <label>Omset Penjualan/Pendapatan (Rp)           :</label>
                                <input type="number" class="form-control" name="omset" >
                            </div>
                        
                            <div class="form-group">
                                <label>HPP (Harga Pokok Penjualan)  (Rp)          :</label>
                                <input type="number" class="form-control" name="hpp" >
                            </div> 
                            <div class="form-group">
                                <label>Laba Kotor  (Rp)          :</label>
                                <input type="number" class="form-control" name="labakotor" >
                            </div>

                            <label><h6>BEBAN OPERASIONAL</h6></label>

                            <div class="form-group">
                                <label>Beban Penjualan (Rp)           :</label>
                                <input type="number" class="form-control" name="bebanpenjualan" >
                            </div>
                        
                            <div class="form-group">
                                <label>Beban Adm & Umum  (Rp)          :</label>
                                <input type="number" class="form-control" name="bebanadmumum" >
                            </div> 
                            <div class="form-group">
                                <label>Total Beban Operasi (Rp)          :</label>
                                <input type="number" class="form-control" name="totalbebanops" >
                            </div>
                            
                            <div class="form-group">
                                <label>Laba Operasi (Rp)          :</label>
                                <input type="number" class="form-control" name="labaops" >
                            </div>

                            <label><h4> Pendapatan Beban Lain</h6></label>

                            <div class="form-group">
                                <label>Pendapatan Lain (Rp)           :</label>
                                <input type="number" class="form-control" name="pendptanlain" >
                            </div>
                        
                            <div class="form-group">
                                <label>Beban Lain  (Rp)          :</label>
                                <input type="number" class="form-control" name="bebanlain" >
                            </div> 

                            <div class="form-group">
                                <label>Laba Sebelum Pajak (Rp)          :</label>
                                <input type="number" class="form-control" name="labasblmpajak" >
                            </div>

                            <div class="form-group">
                                <label> Pajak (Rp)          :</label>
                                <input type="number" class="form-control" name="pajak" >
                            </div>

                            <div class="form-group">
                                <label>Laba Bersih (Rp)          :</label>
                                <input type="number" class="form-control" name="lababersih" >
                            </div>



                        <label><h4> LAPORAN POSISI KEUANGAN/ Neraca</h6></label>
                            <div class="form-group">
                                <label> Aset Lancar (Rp)      :</label>
                                <input type="number" class="form-control" name="asetlancar" >
                            </div>
                            <div class="form-group">
                                <label> Kas Dan Bank (Rp)      :</label>
                                <input type="number" class="form-control" name="asetlancar" >
                            </div>
                            <div class="form-group">
                                <label> Piutang (Rp)      :</label>
                                <input type="number" class="form-control" name="asetlancar" >
                            </div>
                            <div class="form-group">
                                <label> Persediaan (Rp)      :</label>
                                <input type="number" class="form-control" name="asetlancar" >
                            </div>
                            <div class="form-group">
                                <label> Uang Muka (Rp)      :</label>
                                <input type="number" class="form-control" name="asetlancar" >
                            </div>
                            <div class="form-group">
                                <label> Aset Tetap (tanah/bangunan/mobil) (Rp)          :</label>
                                <input type="number" class="form-control" name="asettetap" >
                            </div>
                            <div class="form-group">
                                <label> Jumlah Aset (Aset Lancar dan Aset Tetap) (Rp)          :</label>
                                <input type="number" class="form-control" name="jumlahaset" >
                            </div>
                        
                            <label><h4> LIABILITAS/hutang usaha DANEKUITAS/modal</h6></label>
                            <label><h4> LIABILITAS hutang usaha</h6></label>
                            <div class="form-group">
                                <label> Liabilitas dan Ekuitas            :</label>
                                <input type="text" class="form-control" name="liabilitasdanekuitas" readonly value="Liabilitas dan ekuitas">
                            </div> 
                            <div class="form-group">
                                <label> Liabilitas/hutang           :</label>
                                <input type="text" class="form-control" name="liabilitas" readonly value="Liabilitas">
                            </div> 

                            <div class="form-group">
                                <label> Hutang Usaha  (Rp)          :</label>
                                <input type="number" class="form-control" name="hutangusaha" >
                            </div> 
                            <div class="form-group">
                                <label> Hutang Bank  (Rp)          :</label>
                                <input type="number" class="form-control" name="hutangbank" >
                            </div> 

                            <div class="form-group">
                                <label> Jumlah Liabilitas  (Rp)          :</label>
                                <input type="number" class="form-control" name="jumlahliabilitas" >
                            </div> 
                            <div class="form-group">
                                <label> Ekuitas  (Rp)          :</label>
                                <input type="number" class="form-control" name="ekuitas" >
                            </div> 
                            <div class="form-group">
                                <label> Jumlah Liabilitas & Ekuitas  (Rp)          :</label>
                                <input type="number" class="form-control" name="jumlahliabilitasdanekuitas" >
                            </div> 

                            <label><h4> LaporanArus Kas</h6></label>
                            <label><h4> Arus Kas da6iAktivitas Operasi</h6></label>

                            <div class="form-group">
                                <label> Kas masuk/Bertambah Operasi (Rp)      :</label>
                                <input type="number" class="form-control" name="bertambahops" >
                            </div>
                            <div class="form-group">
                                <label> Kas Keluar/Berkurang Operasi (Rp)          :</label>
                                <input type="number" class="form-control" name="berkurangops" >
                            </div>
                        
                            <div class="form-group">
                                <label> Arus Kas Bersih dari kegiatan operasi (Rp)          :</label>
                                <input type="number" class="form-control" name="aruskasbersihaktops" >
                            </div> 

                            <label><h4> Arus Kas Aktivitas Investasi</h6></label>

                            <div class="form-group">
                                <label> Kas masuk/Bertambah Investasi (Rp)      :</label>
                                <input type="number" class="form-control" name="bertambahinvest" >
                            </div>
                            <div class="form-group">
                                <label> Kas Keluar/Berkurang Investasi (Rp)          :</label>
                                <input type="number" class="form-control" name="berkuranginvest" >
                            </div>
                        
                            <div class="form-group">
                                <label> Arus Kas Bersih dari kegiatan Investasi (Rp)          :</label>
                                <input type="number" class="form-control" name="aruskasbersihaktinvest" >
                            </div> 


                            <label><h4> Arus Kas Aktivitas Pendanaan</h6></label>

                            <div class="form-group">
                                <label> Kas masuk/Bertambah Pendanaan (Rp)      :</label>
                                <input type="number" class="form-control" name="bertambahpendanaan" >
                            </div>
                            <div class="form-group">
                                <label> Kas Keluar/Berkurang Pendanaan (Rp)          :</label>
                                <input type="number" class="form-control" name="berkurangpendanaan" >
                            </div>
                        
                            <div class="form-group">
                                <label> Arus Kas Bersih dari kegiatan Pendanaan (Rp)          :</label>
                                <input type="number" class="form-control" name="aruskasbersihdrpendanaan" >
                            </div> 


                            <div class="form-group">
                                <label> Total Arus Kas Bersih (Rp)      :</label>
                                <input type="number" class="form-control" name="totalaruskas" >
                            </div>
                            <div class="form-group">
                                <label> Kas Awal Perioda (Rp)          :</label>
                                <input type="number" class="form-control" name="kasawalperioda" >
                            </div>
                        
                            <div class="form-group">
                                <label> Kas Akhir Perioda (Rp)          :</label>
                                <input type="number" class="form-control" name="kasakhirperioda" >
                            </div> 
                        
                            <div class="form-group">
                                <label>Masalah             :</label>
                                <input type="text" class="form-control" name="masalah" >
                            </div>
                            
                            <div class="form-group">
                                <label>Solusi             :</label>
                                <input type="text" class="form-control" name="solusi" >
                            </div>
                        
                            <div class="form-group">
                                <label>Support dari TJSL INTI             :</label>
                                <input type="text" class="form-control" name="support" >
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>