<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Rincian Laproran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="<?= base_url('Mitra') ?>">Mitra</a></div>
            <div class="breadcrumb-item"><?= $header ?></div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4><?= $header; ?> Jurnal</h4>
                        <div>
                            <a class="btn btn-primary" href="<?= base_url('mitra/tambahtriwulan') ?>">Buat laporan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-cicilan-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>No Kontrak</th>
                                        <th>Tanggal</th>
                                        <th>Laporan Laba Rugi</th>
                                        <th>Omset</th>
                                        <th>HPP</th>
                                        <th>Laba Kotor</th>
                                        <th>Beban Penjualan</th>
                                        <th>Beban ADM Umum</th>
                                        <th>Total Beban OPS</th>
                                        <th>Laba OPS</th>
                                        <th>Pendapatan Lain</th>
                                        <th>Beban Lain</th>
                                        <th>Laba Sebelum Pajak</th>
                                        <th>Pajak</th>
                                        <th>Laba Bersih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1;
                                    foreach ($laporan as $l) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $l['nokontrak']; ?></td>
                                            <td><?= $l['tgl']; ?></td>
                                            <td><?= $l['laplabarugi']; ?></td>
                                            <td><?= $l['omset']; ?></td>
                                            <td><?= $l['hpp']; ?></td>
                                            <td><?= $l['labakotor']; ?></td>
                                            <td><?= $l['bebanpenjualan']; ?></td>
                                            <td><?= $l['bebanadmumum']; ?></td>
                                            <td><?= $l['totalbebanops']; ?></td>
                                            <td><?= $l['labaops']; ?></td>
                                            <td><?= $l['pendptanlain']; ?></td>
                                            <td><?= $l['bebanlain']; ?></td>
                                            <td><?= $l['labasblmpajak']; ?></td>
                                            <td><?= $l['pajak']; ?></td>
                                            <td><?= $l['lababersih']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-cicilan-3">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>LAPORAN POSISI KEU</th>
                                        <th>Aset Lancar</th>
                                        <th>Kas Dan Bank</th>
                                        <th>Piuang</th>
                                        <th>Persediaan</th>
                                        <th>Uang Muka</th>
                                        <th>Aset Tetap</th>
                                        <th>Jumlah Aset</th>
                                        <th>Liabilitas Dan Ekuitas</th>
                                        <th>Liabilitas</th>
                                        <th>Hutang Usaha</th>
                                        <th>Hutang Bank</th>
                                        <th>Jumlah Liabilitas</th>
                                        <th>Ekuitas</th>
                                        <th>Jumlah Liabilitas dan ekuitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($laporan as $l) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $l['laposkeu']; ?></td>
                                            <td><?= $l['asetlancar']; ?></td>
                                            <td><?= $l['kasdanbank']; ?></td>
                                            <td><?= $l['piutang']; ?></td>
                                            <td><?= $l['persediaan']; ?></td>
                                            <td><?= $l['uangmuka']; ?></td>
                                            <td><?= $l['asettetap']; ?></td>
                                            <td><?= $l['jumlahaset']; ?></td>
                                            <td><?= $l['liabilitasdanekuitas']; ?></td>
                                            <td><?= $l['liabilitas']; ?></td>
                                            <td><?= $l['hutangusaha']; ?></td>
                                            <td><?= $l['hutangbank']; ?></td>
                                            <td><?= $l['jumlahliabilitas']; ?></td>
                                            <td><?= $l['ekuitas']; ?></td>
                                            <td><?= $l['jumlahliabilitasdanekuitas']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-cicilan-2">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Laporan Arus Kas</th>
                                        <th>Arus kas dari akt OPS</th>
                                        <th>Bertambah OPS</th>
                                        <th>Berkurang OPS</th>
                                        <th>Arus kas bersih akt OPS</th>
                                        <th>Arus kas dari akt ivestasi</th>
                                        <th>Bertambah investasi</th>
                                        <th>Berkurang investasi</th>
                                        <th>Arus kas bersih akt investasi</th>
                                        <th>Arus kas dari akt pendanaan</th>
                                        <th>Bertambah pendanaan</th>
                                        <th>Berkurang pendanaan</th>
                                        <th>Arus kas bersih akt pendanaan</th>
                                        <th>Total Arus Kas</th>
                                        <th>Kas awal perioda</th>
                                        <th>Kas akhir perioda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($laporan as $l) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $l['laparuskas']; ?></td>
                                            <td><?= $l['aruskasdariaktops']; ?></td>
                                            <td><?= $l['bertambahops']; ?></td>
                                            <td><?= $l['berkurangops']; ?></td>
                                            <td><?= $l['aruskasbersihaktops']; ?></td>
                                            <td><?= $l['aruskasbersihaktinvest']; ?></td>
                                            <td><?= $l['bertambahinvest']; ?></td>
                                            <td><?= $l['berkuranginvest']; ?></td>
                                            <td><?= $l['aruskasbersihaktinvest']; ?></td>
                                            <td><?= $l['aruskasdraktpendanaan']; ?></td>
                                            <td><?= $l['bertambahpendanaan']; ?></td>
                                            <td><?= $l['berkurangpendanaan']; ?></td>
                                            <td><?= $l['aruskasbersihdrpendanaan']; ?></td>
                                            <td><?= $l['totalaruskas']; ?></td>
                                            <td><?= $l['kasawalperioda']; ?></td>
                                            <td><?= $l['kasakhirperioda']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-cicilan-4">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Masalah</th>
                                        <th>Solusi</th>
                                        <th>Support</th>
                                        <th>Tanggal Update</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($laporan as $l) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $l['masalah']; ?></td>
                                            <td><?= $l['solusi']; ?></td>
                                            <td><?= $l['support']; ?></td>
                                            <td><?= $l['tglupdate']; ?></td>
                                            <td>
                                                <a href="<?= base_url('laporan/edit/' . $l['id']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                <a href="<?= base_url('laporan/hapus/' . $l['id']); ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>