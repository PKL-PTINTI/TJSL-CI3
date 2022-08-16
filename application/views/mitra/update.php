<section class="section">
    <div class="section-header">
        <h1>Data Mitra <?= $mitra->nama_peminjam ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('Admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('Admin/Mitra') ?>">Mitra</a></div>
            <div class="breadcrumb-item">Update Data Mitra</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Update Data Mitra A.N <?= $mitra->nama_peminjam ?></h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Admin/Mitra/Store') ?>" method="post">
                            <div class="form-group">
                                <label>Nomor Kontrak</label>
                                <input type="text" class="form-control" placeholder="Nomor Kontrak"
                                    value="<?= $mitra->nokontrak ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Kontrak</label>
                                <input type="text" class="form-control datepicker" value="<?= $mitra->tglkontrak ?>"
                                    name="tanggal_kontrak">
                            </div>
                            <div class="form-group">
                                <label>Nama Mitra</label>
                                <input type="text" class="form-control" placeholder="Nama Mitra"
                                    value="<?= $mitra->nama_peminjam ?>" name="nama_mitra">
                            </div>
                            <div class="form-group">
                                <label>Alamat Rumah</label>
                                <input type="text" class="form-control" placeholder="Alamat Rumah"
                                    value="<?= $mitra->alamat_rumah ?>" name="alamat_rumah">
                            </div>
                            <div class="form-group">
                                <label>Alamat Usaha</label>
                                <input type="text" class="form-control" placeholder="Alamat Usaha"
                                    value="<?= $mitra->alamat_usaha ?>" name="alamat_usaha">
                            </div>
                            <div class="form-group">
                                <label>Lokasi Usaha</label>
                                <select class="form-control select2" name="lokasi_usaha">
                                    <option>Pilih Lokasi Usaha</option>
                                    <?php foreach ($lokasi as $lok): ?>
                                    <option <?= ($lok->lokasi == $mitra->lokasiUsaha) ? 'selected' : null  ?> value="<?= $lok->lokasi ?>"><?= $lok->kodekabupaten ?> - <?= $lok->lokasi ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Nama Perusahaan</label>
                                <input type="text" class="form-control" placeholder="Nama Perusahaan"
                                    value="<?= $mitra->namaPerusahaan ?>" name="nama_perusahaan">
                            </div>
                            <div class="form-group">
                                <label>No Handphone</label>
                                <input type="text" class="form-control" placeholder="No Handphone"
                                    value="<?= $mitra->hp ?>" name="no_handphone">
                            </div>

                            <div class="form-group">
                                <label>Status Mitra</label>
                                <select class="form-control select2" name="status_mitra">
                                    <option>Pilih Status Mitra</option>
                                    <?php foreach ($statusmitra as $status): ?>
                                    <option <?= ($status->status == $mitra->barulanjutan) ? 'selected' : null  ?> value="<?= $status->status ?>"><?= $status->id ?> -
                                        <?= ucfirst($status->status) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Sektor Usaha</label>
                                <select class="form-control select2" name="sektor_usaha">
                                    <option>Pilih Sektor Usaha</option>
                                    <?php foreach ($sektor as $sktr): ?>
                                    <option <?= ($status->status == $mitra->barulanjutan) ? 'selected' : null  ?> value="<?= $sktr->sektor ?>"><?= $sktr->id ?> -
                                        <?= ucfirst($sktr->sektor) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nomor KTP Mitra</label>
                                <input type="text" class="form-control" placeholder="Nomor KTP Mitra"
                                    value="<?= $mitra->ktp ?>" name="nomor_ktp">
                            </div>

                            <div class="form-group">
                                <label>No Rekening Bank Mitra</label>
                                <input type="text" class="form-control" placeholder="No Rekening Bank Mitra"
                                    value="<?= $mitra->noRekBank ?>" name="norek_mitra">
                            </div>

                            <div class="form-group">
                                <label>Nama Bank Account</label>
                                <select class="form-control select2" name="nama_bank">
                                    <option>Pilih Nama Bank Account</option>
                                    <?php foreach ($kodebank as $kode): ?>
                                    <option value="<?= $kode->bank ?>"><?= $kode->bankAccount ?> -
                                        <?= ucfirst($kode->bank) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Proposal Pengajuan</label>
                                <input type="text" class="form-control datepicker" value="<?= $mitra->tglproposal ?>"
                                    name="tanggal_pengajuan">
                            </div>

                            <div class="form-group">
                                <label>Tanggal Survey Lokasi</label>
                                <input type="text" class="form-control datepicker" value="<?= $mitra->tglSurvey ?>"
                                    name="tanggal_survey">
                            </div>

                            <div class="form-group">
                                <label>Nama Hasil Survey</label>
                                <select class="form-control select2" name="hasil_survey">
                                    <option>Pilih Hasil Survey</option>
                                    <?php foreach ($hasilevaluasi as $hasil): ?>
                                    <option value="<?= $hasil->hasil ?>"><?= $hasil->id ?> -
                                        <?= ucfirst($hasil->hasil) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Jaminan (Kolateral)</label>
                                <input type="text" class="form-control" placeholder="Jaminan (Kolateral)"
                                    value="<?= $mitra->jaminan ?>" name="jaminan">
                            </div>

                            <div class="form-group">
                                <label>Nilai Pinjaman</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="number" class="form-control currency" value="<?= $mitra->pinjaman ?>"
                                        name="nilai_pinjaman">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Lama Pinjaman</label>
                                <input type="number" class="form-control" placeholder="Lama Pinjaman (Bulan)"
                                    value="<?= $mitra->lama_pinjam ?>" name="lama_pinjaman">
                            </div>

                            <div class="form-group">
                                <label>Jasa (%) Per Tahun</label>
                                <input type="number" class="form-control" placeholder="Jasa (%) Per Tahun"
                                    value="<?= $mitra->jasa ?>" name="jasa">
                            </div>

                            <div class="form-group">
                                <label>Dana Dikeluarkan PT INTI Melalui</label>
                                <select class="form-control select2" name="dana_dikeluarkan">
                                    <option>Pilih Bank</option>
                                    <?php foreach ($kasbrimandiri as $bank): ?>
                                    <option value="<?= $bank->korek ?>"><?= $bank->korek ?> -
                                        <?= ucfirst($bank->bank) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>No VA (Virtual Account Bank BRI)</label>
                                <input type="text" class="form-control" placeholder="No VA (Virtual Account Bank BRI)"
                                    value="<?= $mitra->VA ?>" name="no_va">
                            </div>

                            <div class="form-group">
                                <label>Lokasi Google Maps</label>
                                <input type="text" class="form-control" placeholder="Lokasi Google Maps"
                                    value="<?= $mitra->googlemaps ?>" name="lokasi_google_maps">
                            </div>

                            <div class="form-group">
                                <label>Nilai Aset</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="number" class="form-control currency" value="<?= $mitra->nilaiAset ?>"
                                        name="nilai_aset">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nilai Omset</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="number" class="form-control currency" value="<?= $mitra->nilaiOmset ?>"
                                        name="nilai_omset">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Pelaksanaan Program</label>
                                <select class="form-control select2" name="pelaksana">
                                    <option>Pilih Pelaksana</option>
                                    <?php foreach ($pelaksanaanprogram as $pelaksana): ?>
                                    <option value="<?= $pelaksana->program ?>"><?= $pelaksana->id ?> -
                                        <?= ucfirst($pelaksana->program) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Sumber Dana</label>
                                <input type="text" class="form-control" placeholder="Sumber Dana"
                                    value="<?= $mitra->sumberDana ?>" name="sumber_dana">
                            </div>

                            <div class="form-group">
                                <label>Kondisi Peminjaman</label>
                                <select class="form-control select2" name="kondisi">
                                    <option>Pilih Kondisi</option>
                                    <?php foreach ($kondisipinjaman as $kondisi): ?>
                                    <option value="<?= $kondisi->sikon ?>"><?= $kondisi->id ?> -
                                        <?= ucfirst($kondisi->sikon) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Jenis Pembayaran</label>
                                <select class="form-control select2" name="jenis_pembayaran">
                                    <option>Pilih Jenis Pembayaran</option>
                                    <?php foreach ($jenispembayaran as $jenis): ?>
                                    <option value="<?= $jenis->cara ?>"><?= $jenis->id ?> -
                                        <?= ucfirst($jenis->cara) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Jumlah SDM</label>
                                <input type="text" class="form-control" placeholder="Jumlah SDM"
                                    value="<?= $mitra->jumlahSDM ?>" name="jumlah_sdm">
                            </div>

                            <div class="form-group">
                                <label>Sub Sektor</label>
                                <input type="text" class="form-control" placeholder="Sub Sektor"
                                    value="<?= $mitra->subSektor ?>" name="sub_sektor">
                            </div>

                            <div class="form-group">
                                <label>Nama Produk/Jasa</label>
                                <input type="text" class="form-control" placeholder="Nama Produk/Jasa"
                                    value="<?= $mitra->prodJasa ?>" name="nama_produkjasa">
                            </div>

                            <div class="form-group">
                                <label>Jenis Skala Usaha</label>
                                <select class="form-control select2" name="skala_usaha">
                                    <option>Pilih Jenis Skala Usaha</option>
                                    <?php foreach ($skalausaha as $skala): ?>
                                    <option value="<?= $skala->skala ?>"><?= $skala->id ?> -
                                        <?= ucfirst($skala->skala) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
