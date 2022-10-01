<section class="section">
    <div class="section-header">
        <h1>Input Data Mitra Baru</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('admin/Mitra') ?>">Mitra</a></div>
            <div class="breadcrumb-item">Input Data Mitra Baru</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Mitra Baru</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/mitra/store') ?>" method="post">
                            <div class="form-group">
                                <label>Nomor Kontrak</label>
                                <input type="text" class="form-control" placeholder="Nomor Kontrak"
                                    name="nomor_kontrak">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Kontrak</label>
                                <input type="text" class="form-control datepicker" name="tanggal_kontrak">
                            </div>
                            <div class="form-group">
                                <label>Nama Mitra</label>
                                <input type="text" class="form-control" placeholder="Nama Mitra" name="nama_mitra">
                            </div>
                            <div class="form-group">
                                <label>Alamat Rumah</label>
                                <input type="text" class="form-control" placeholder="Alamat Rumah" name="alamat_rumah">
                            </div>
                            <div class="form-group">
                                <label>Alamat Usaha</label>
                                <input type="text" class="form-control" placeholder="Alamat Usaha" name="alamat_usaha">
                            </div>
                            <div class="form-group">
                                <label>Lokasi Usaha</label>
                                <select class="form-control select2" name="lokasi_usaha">
                                    <option>Pilih Lokasi Usaha</option>
                                    <?php foreach ($lokasi as $lok): ?>
                                    <option value="<?= $lok->lokasi ?>"><?= $lok->kodekabupaten ?> - <?= $lok->lokasi ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Nama Perusahaan</label>
                                <input type="text" class="form-control" placeholder="Nama Perusahaan"
                                    name="nama_perusahaan">
                            </div>
                            <div class="form-group">
                                <label>No Handphone</label>
                                <input type="text" class="form-control" placeholder="No Handphone" name="no_handphone">
                            </div>

                            <div class="form-group">
                                <label>Status Mitra</label>
                                <select class="form-control select2" name="status_mitra">
                                    <option>Pilih Status Mitra</option>
                                    <?php foreach ($statusmitra as $status): ?>
                                    <option value="<?= $status->status ?>"><?= $status->id ?> -
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
                                    <option value="<?= $sktr->sektor ?>"><?= $sktr->id ?> -
                                        <?= ucfirst($sktr->sektor) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nomor KTP Mitra</label>
                                <input type="text" class="form-control" placeholder="Nomor KTP Mitra" name="nomor_ktp">
                            </div>

                            <div class="form-group">
                                <label>No Rekening Bank Mitra</label>
                                <input type="text" class="form-control" placeholder="No Rekening Bank Mitra"
                                    name="norek_mitra">
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
                                <input type="text" class="form-control datepicker" name="tanggal_pengajuan">
                            </div>

                            <div class="form-group">
                                <label>Tanggal Survey Lokasi</label>
                                <input type="text" class="form-control datepicker" name="tanggal_survey">
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
                                    name="jaminan">
                            </div>

                            <div class="form-group">
                                <label>Nilai Pinjaman</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency amount" name="nilai_pinjaman">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Lama Pinjaman</label>
                                <input type="number" class="form-control" placeholder="Lama Pinjaman (Bulan)"
                                    name="lama_pinjaman">
                            </div>

                            <div class="form-group">
                                <label>Jasa (%) Per Tahun</label>
                                <input type="text" class="form-control amount" placeholder="Jasa (%) Per Tahun" name="jasa">
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
                                <label>Keterangan Jurnal</label>
                                <input type="text" class="form-control" placeholder="Keterangan Jurnal"
                                    name="keterangan">
                                <p class="text-primary">Keterangan untuk di JURNAL, tuliskan nama dan ambil dari bank
                                    mana</p>
                            </div>

                            <div class="form-group">
                                <label>No VA (Virtual Account Bank BRI)</label>
                                <input type="text" class="form-control" placeholder="No VA (Virtual Account Bank BRI)"
                                    name="no_va">
                            </div>

                            <div class="form-group">
                                <label>Lokasi Google Maps</label>
                                <input type="text" class="form-control" placeholder="Lokasi Google Maps"
                                    name="lokasi_google_maps">
                            </div>

                            <div class="form-group">
                                <label>Nilai Aset</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency amount" name="nilai_aset">
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
                                    <input type="text" class="form-control currency amount" name="nilai_omset">
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
                                <input type="text" class="form-control" placeholder="Sumber Dana" name="sumber_dana">
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
                                <input type="text" class="form-control" placeholder="Jumlah SDM" name="jumlah_sdm">
                            </div>

                            <div class="form-group">
                                <label>Sub Sektor</label>
                                <input type="text" class="form-control" placeholder="Sub Sektor" name="sub_sektor">
                            </div>

                            <div class="form-group">
                                <label>Nama Produk/Jasa</label>
                                <input type="text" class="form-control" placeholder="Nama Produk/Jasa"
                                    name="nama_produkjasa">
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
