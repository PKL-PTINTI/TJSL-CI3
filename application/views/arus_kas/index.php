<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Laporan Arus Kas</h1>
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
                        <h4><?= $header; ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No ID</th>
                                        <th>Keterangan</th>
                                        <th>Desember 2021</th>
                                        <th>Sd Desember 2021</th>
                                        <th>Juni 2022</th>
                                        <th>Sd Juni 2022</th>
                                        <th>RKA Juni 2022(1)</th>
                                        <th>RKA-Juni 2022(2)</th>
                                        <th>Realisasi Juni 2022(3)</th>
                                        <th>Realisasi Juni 2022(4)</th>
                                        <th>RKA Juni 2021(5)</th>
                                        <th>RKA-Juni 2021(6)</th>
                                        <th>(3:1)% RKA Juni 2022</th>
                                        <th>(4:2)% RKA-Juni 2022</th>
                                        <th></th>
                                        </tr>
                                </thead>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>