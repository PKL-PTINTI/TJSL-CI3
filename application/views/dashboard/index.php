<section class="section">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-1">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="text-white fa-solid fa-money-bill-trend-up"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>KAS</h4>
                    </div>
                    <div class="card-body">
                        Rp. <?= number_format($saldokasbank[0]->kaskecil) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-1">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="text-white fa-solid fa-building-columns"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>BANK</h4>
                    </div>
                    <div class="card-body">
                    Rp. <?= number_format($saldokasbank[0]->bri + $saldokasbank[0]->mandiri) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-1">
                <div class="card-icon shadow-primary bg-primary">
                <i class="text-white fa-solid fa-money-bill-transfer"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>TOTAL SALDO</h4>
                    </div>
                    <div class="card-body">
                    Rp. <?= number_format(($saldokasbank[0]->bri + $saldokasbank[0]->mandiri) + $saldokasbank[0]->kaskecil) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12 col-12 col-sm-12">
            <div class="card">
            <div class="card-header">
                <h4>Statistics</h4>
                <div class="card-header-action">
                <div class="btn-group">
                    <a href="#" class="btn btn-primary">Month</a>
                </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="myChart2" height="182"></canvas>
                <div class="statistic-details mt-sm-4">
                <div class="statistic-details-item">
                    <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>
                    <div class="detail-value"><?= number_format($pemasukan_bulanan); ?></div>
                    <div class="detail-name">Today's Sales</div>
                </div>
                <div class="statistic-details-item">
                    <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
                    <div class="detail-value"><?= number_format($pengeluaran_bulanan); ?></div>
                    <div class="detail-name">This Week's Sales</div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-4">
        <div class="card card-statistic-2 pb-4">
                <div class="card-stats">
                    <div class="card-stats-title">
                        <div>Total Mitra Binaan</div>
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count"><?= $countMitraNormal ?></div>
                            <div class="card-stats-item-label">Normal</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count"><?= $countMitraBermasalah ?></div>
                            <div class="card-stats-item-label">Masalah</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count"><?= $countMitraWo ?></div>
                            <div class="card-stats-item-label">Wipe Out</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap mb-3">
                    <div class="card-header">
                        <h4>Total Mitra</h4>
                    </div>
                    <div class="card-body">
                        <?= $countMitra ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Top Countries</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-title mb-2">July</div>
                            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder mb-0">
                                <li class="media">
                                    <img class="img-fluid mt-1 img-shadow"
                                        src="<?= base_url() ?>node_modules/flag-icon-css/flags/4x3/id.svg" alt="image"
                                        width="40">
                                    <div class="media-body ml-3">
                                        <div class="media-title">Indonesia</div>
                                        <div class="text-small text-muted">3,282 <i
                                                class="fas fa-caret-down text-danger"></i></div>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="img-fluid mt-1 img-shadow"
                                        src="<?= base_url() ?>node_modules/flag-icon-css/flags/4x3/my.svg" alt="image"
                                        width="40">
                                    <div class="media-body ml-3">
                                        <div class="media-title">Malaysia</div>
                                        <div class="text-small text-muted">2,976 <i
                                                class="fas fa-caret-down text-danger"></i></div>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="img-fluid mt-1 img-shadow"
                                        src="<?= base_url() ?>node_modules/flag-icon-css/flags/4x3/us.svg" alt="image"
                                        width="40">
                                    <div class="media-body ml-3">
                                        <div class="media-title">United States</div>
                                        <div class="text-small text-muted">1,576 <i
                                                class="fas fa-caret-up text-success"></i></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6 mt-sm-0 mt-4">
                            <div class="text-title mb-2">August</div>
                            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder mb-0">
                                <li class="media">
                                    <img class="img-fluid mt-1 img-shadow"
                                        src="<?= base_url() ?>node_modules/flag-icon-css/flags/4x3/id.svg" alt="image"
                                        width="40">
                                    <div class="media-body ml-3">
                                        <div class="media-title">Indonesia</div>
                                        <div class="text-small text-muted">3,486 <i
                                                class="fas fa-caret-up text-success"></i></div>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="img-fluid mt-1 img-shadow"
                                        src="<?= base_url() ?>node_modules/flag-icon-css/flags/4x3/ps.svg" alt="image"
                                        width="40">
                                    <div class="media-body ml-3">
                                        <div class="media-title">Palestine</div>
                                        <div class="text-small text-muted">3,182 <i
                                                class="fas fa-caret-up text-success"></i></div>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="img-fluid mt-1 img-shadow"
                                        src="<?= base_url() ?>node_modules/flag-icon-css/flags/4x3/de.svg" alt="image"
                                        width="40">
                                    <div class="media-body ml-3">
                                        <div class="media-title">Germany</div>
                                        <div class="text-small text-muted">2,317 <i
                                                class="fas fa-caret-down text-danger"></i></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Invoices</h4>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tr>
                                <th>Invoice ID</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><a href="#">INV-87239</a></td>
                                <td class="font-weight-600">Kusnadi</td>
                                <td>
                                    <div class="badge badge-warning">Unpaid</div>
                                </td>
                                <td>July 19, 2018</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#">INV-48574</a></td>
                                <td class="font-weight-600">Hasan Basri</td>
                                <td>
                                    <div class="badge badge-success">Paid</div>
                                </td>
                                <td>July 21, 2018</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#">INV-76824</a></td>
                                <td class="font-weight-600">Muhamad Nuruzzaki</td>
                                <td>
                                    <div class="badge badge-warning">Unpaid</div>
                                </td>
                                <td>July 22, 2018</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#">INV-84990</a></td>
                                <td class="font-weight-600">Agung Ardiansyah</td>
                                <td>
                                    <div class="badge badge-warning">Unpaid</div>
                                </td>
                                <td>July 22, 2018</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#">INV-87320</a></td>
                                <td class="font-weight-600">Ardian Rahardiansyah</td>
                                <td>
                                    <div class="badge badge-success">Paid</div>
                                </td>
                                <td>July 28, 2018</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-hero">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="far fa-question-circle"></i>
                    </div>
                    <h4>14</h4>
                    <div class="card-description">Customers need help</div>
                </div>
                <div class="card-body p-0">
                    <div class="tickets-list">
                        <a href="#" class="ticket-item">
                            <div class="ticket-title">
                                <h4>My order hasn't arrived yet</h4>
                            </div>
                            <div class="ticket-info">
                                <div>Laila Tazkiah</div>
                                <div class="bullet"></div>
                                <div class="text-primary">1 min ago</div>
                            </div>
                        </a>
                        <a href="#" class="ticket-item">
                            <div class="ticket-title">
                                <h4>Please cancel my order</h4>
                            </div>
                            <div class="ticket-info">
                                <div>Rizal Fakhri</div>
                                <div class="bullet"></div>
                                <div>2 hours ago</div>
                            </div>
                        </a>
                        <a href="#" class="ticket-item">
                            <div class="ticket-title">
                                <h4>Do you see my mother?</h4>
                            </div>
                            <div class="ticket-info">
                                <div>Syahdan Ubaidillah</div>
                                <div class="bullet"></div>
                                <div>6 hours ago</div>
                            </div>
                        </a>
                        <a href="features-tickets.html" class="ticket-item ticket-more">
                            View All <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>