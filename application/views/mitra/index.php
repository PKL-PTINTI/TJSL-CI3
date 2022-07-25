<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Management Data Mitra</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><?= $header ?></div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Mitra <span id="header"></span></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="colom col d-flex justify-content-between">
                                <div class="mitra">
                                    <a href="#" onclick="
                                        changeUrlMitra('http://localhost:3000/admin/mitra/get_data_mitra/masalah/normal', 'Normal'
                                        )" class="btn btn-primary">Mitra Normal</a>
                                    <a href="#" onclick="
                                        changeUrlMitra('http://localhost:3000/admin/mitra/get_data_mitra/masalah/masalah', 'Bermasalah'
                                        )" class="btn btn-primary">Mitra Bermasalah</a>
                                    <a href="#" onclick="
                                        changeUrlMitra('http://localhost:3000/admin/mitra/get_data_mitra/masalah/khusus', 'Khusus'
                                        )" class="btn btn-primary">Mitra Khusus</a>
                                    <a href="#" onclick="
                                        changeUrlMitra('http://localhost:3000/admin/mitra/get_data_mitra/masalah/wo', 'Wipe Out'
                                        )" class="btn btn-primary">Mitra
                                        WO</a>
                                </div>
                                <div class="sektor-masalah dropdown pr-4 d-none">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Sektor
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 29px, 0px);">

                                        <a class="dropdown-item"
                                            onclick="changeUrlMitra('admin/mitra/get_data_mitra/koleksektor/')"
                                            href="#">Sektor
                                            Industri</a>
                                        <a class="dropdown-item"
                                            onclick="changeUrlMitra('admin/mitra/get_data_mitra/koleksektor/')"
                                            href="#">Sektor
                                            Perdagangan</a>
                                        <a class="dropdown-item"
                                            onclick="changeUrlMitra('admin/mitra/get_data_mitra/koleksektor/')"
                                            href="#">Sektor
                                            Pertanian</a>
                                        <a class="dropdown-item"
                                            onclick="changeUrlMitra('admin/mitra/get_data_mitra/koleksektor/')"
                                            href="#">Sektor
                                            Perkebunan</a>
                                        <a class="dropdown-item"
                                            onclick="changeUrlMitra('admin/mitra/get_data_mitra/koleksektor/')"
                                            href="#">Sektor
                                            Perikanan</a>
                                        <a class="dropdown-item"
                                            onclick="changeUrlMitra('admin/mitra/get_data_mitra/koleksektor/')"
                                            href="#">Sektor
                                            Peternakan</a>
                                        <a class="dropdown-item"
                                            onclick="changeUrlMitra('admin/mitra/get_data_mitra/koleksektor/')"
                                            href="#">Sektor
                                            Jasa</a>
                                        <a class="dropdown-item"
                                            onclick="changeUrlMitra('admin/mitra/get_data_mitra/koleksektor/')"
                                            href="#">Sektor Lain-lain</a>
                                    </div>
                                </div>
                                <div class="sektor-kolek dropdown pr-4 d-none">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Sektor
                                    </button>
                                    <div class="dropdown-menu menu-kolek" x-placement="bottom-start"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 29px, 0px);">
                                        <a class="dropdown-item" data-sektor="industri" href="#">Sektor
                                            Industri</a>
                                        <a class="dropdown-item" data-sektor="perdagangan" href="#">Sektor
                                            Perdagangan</a>
                                        <a class="dropdown-item" data-sektor="pertanian" href="#">Sektor
                                            Pertanian</a>
                                        <a class="dropdown-item" data-sektor="perkebunan" href="#">Sektor
                                            Perkebunan</a>
                                        <a class="dropdown-item" data-sektor="perikanan" href="#">Sektor
                                            Perikanan</a>
                                        <a class="dropdown-item" data-sektor="peternakan" href="#">Sektor
                                            Peternakan</a>
                                        <a class="dropdown-item" data-sektor="jasa" href="#">Sektor
                                            Jasa</a>
                                        <a class="dropdown-item" data-sektor="" href="#">Sektor Lain-lain</a>
                                    </div>
                                </div>
                                <a class="btn btn-primary mb-3 " href="<?= base_url('admin/mitra/create') ?>">Tambah
                                    Data Mitra</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-mitra">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Nama Mitra</th>
                                        <th>No Kontrak</th>
                                        <th>Lokasi Usaha</th>
                                        <th>Mulai Cicil</th>
                                        <th>Kolektibilitas</th>
                                        <th>Pinjaman Pokok</th>
                                        <th>Pinjaman Jasa</th>
                                        <th>Pinjaman Jumlah</th>
                                        <th>Angsuran Pokok</th>
                                        <th>Angsuran Jasa</th>
                                        <th>Angsuran Jumlah</th>
                                        <th>Saldo Pokok</th>
                                        <th>Saldo Jasa</th>
                                        <th>Saldo Jumlah</th>
                                        <th>Nama Perusahaan</th>
                                        <th>Provinsi</th>
                                        <th>Kota</th>
                                        <th>Sektor Usaha</th>
                                        <th>Skala Usaha</th>
                                        <th>No Identitas</th>
                                        <th>Pelaksanaan Program</th>
                                        <th>Sumber Dana</th>
                                        <th>Nilai Aset (Rp)</th>
                                        <th>Nilai Omset (Rp)</th>
                                        <th>Rekondisi</th>
                                        <th>Tanggal Rekondisi</th>
                                        <th>Selisih Hari</th>
                                        <th>Kelebihan Angsuran</th>
                                        <th>Tanggal Awal Pendanaan</th>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <th>Nominal Pendanaan</th>
                                        <th>Saldo Pokok Pendanaan</th>
                                        <th>Saldo Jasa Admin Pendanaan</th>
                                        <th>Penerimaan Pokok</th>
                                        <th>Penerimaan Jasa</th>
                                        <th>Tanggal Penerimaan Terakhir</th>
                                        <th>Status</th>
                                        <th>Kondisi Pinjaman</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Bank Account</th>
                                        <th>SDM di MB</th>
                                        <th>Kelebihan Angs</th>
                                        <th>SubSektor</th>
                                        <th>Tambahan Pendanaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
