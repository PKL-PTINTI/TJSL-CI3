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
                            <div class="colom col d-flex justify-content-right">
                                <div class="sektor-kolek dropdown pr-2">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Kolektibilitas Mitra
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 29px, 0px);">

                                        <a class="dropdown-item"
                                        onclick="
                                        changeUrlMitra('Admin/mitra/get_data_mitra/kolektibilitas/lancar', 'Lancar'
                                        )" href="#">Mitra Lancar</a>
                                        <a class="dropdown-item"
                                        onclick="
                                        changeUrlMitra('Admin/mitra/get_data_mitra/kolektibilitas/kuranglancar', 'Kurang Lancar'
                                        )" href="#">Mitra Kurang Lancar</a>
                                        <a class="dropdown-item"
                                        onclick="
                                        changeUrlMitra('Admin/mitra/get_data_mitra/kolektibilitas/diragukan', 'Diragukan'
                                        )" href="#">Mitra Diragukan</a>
                                        <a class="dropdown-item"
                                        onclick="
                                        changeUrlMitra('Admin/mitra/get_data_mitra/kolektibilitas/macet', 'Macet'
                                        )" href="#">Mitra Macet</a>
                                    </div>
                                </div>
                                <div class="mitra dropdown pr-2">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Status Mitra
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 29px, 0px);">

                                        <a class="dropdown-item"
                                        onclick="
                                        changeUrlMitraMasalah('Admin/mitra/get_data_mitra/bermasalah/normal', 'Normal'
                                        )" href="#">Mitra Normal</a>
                                        <a class="dropdown-item"
                                        onclick="
                                        changeUrlMitraMasalah('Admin/mitra/get_data_mitra/bermasalah/masalah', 'Bermasalah'
                                        )" href="#">Mitra Bermasalah</a>
                                        <a class="dropdown-item"
                                        onclick="
                                        changeUrlMitraMasalah('Admin/mitra/get_data_mitra/bermasalah/khusus', 'Khusus'
                                        )" href="#">Mitra Khusus</a>
                                        <a class="dropdown-item"
                                        onclick="
                                        changeUrlMitraMasalah('Admin/mitra/get_data_mitra/bermasalah/wo', 'Wipe Out'
                                        )" href="#">Mitra WO</a>
                                    </div>
                                </div>
                                <div class="sektor-masalah dropdown pr-2 d-none">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Sektor Masalah
                                    </button>
                                    <div class="dropdown-menu menu-masalah" x-placement="bottom-start"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 29px, 0px);">

                                        <a class="dropdown-item"
                                            data-sektor="industri"
                                            href="#">Sektor
                                            Industri</a>
                                        <a class="dropdown-item"
                                            data-sektor="perdagangan"
                                            href="#">Sektor
                                            Perdagangan</a>
                                        <a class="dropdown-item"
                                            data-sektor="pertanian"
                                            href="#">Sektor
                                            Pertanian</a>
                                        <a class="dropdown-item"
                                            data-sektor="perkebunan"
                                            href="#">Sektor
                                            Perkebunan</a>
                                        <a class="dropdown-item"
                                            data-sektor="perikanan"
                                            href="#">Sektor
                                            Perikanan</a>
                                        <a class="dropdown-item"
                                            data-sektor="peternakan"
                                            href="#">Sektor
                                            Peternakan</a>
                                        <a class="dropdown-item"
                                            data-sektor="jasa"
                                            href="#">Sektor
                                            Jasa</a>
                                        <a class="dropdown-item"
                                            data-sektor="jasa"
                                            href="#">Sektor Lain-lain</a>
                                    </div>
                                </div>
                                <div class="sektor-kolek dropdown pr-2 d-none">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Sektor Kolektabilitas
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
                                <a class="btn btn-primary mb-3 " href="<?= base_url('Admin/mitra/create') ?>">Tambah Data Mitra</a>
                            </div>
                        </div>
                        <div>
                            <table class="table table-striped" id="table-mitra">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Nama Mitra</th>
                                        <th>No Kontrak</th>
                                        <th>Lokasi Usaha</th>
                                        <th>Mulai Cicil</th>
                                        <th>kolektibilitas</th>

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
                                        <th>Kota</th>
                                        <th>Sektor Usaha</th>
                                        <th>No Identitas</th>
                                        <th>Tanggal Awal Pendanaan</th>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <th>Tanggal Penerimaan Terakhir</th>
                                        <th>Status</th> 
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
