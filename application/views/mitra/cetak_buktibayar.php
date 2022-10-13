
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Invoice &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/components.css">

  <style>
    .main-content {
    padding-left: 188px;
    padding-right: 188px;
    padding-top: 80px;
    width: 100%;
    position: relative;
    align-content: center;
}

.invoice .invoice-title .invoice-number {
    float: right;
    font-size: 20px;
    font-weight: 700;
    margin-top: -84px;
}

.invoice hr {
    margin-top: 13px;
    margin-bottom: 49px;
    border-top-color: #AFAAAA   ;
    border: none;
    height: 1px;
    /* Set the hr color */
    color: #AFAAAA  ; /* old IE */
    background-color: #AFAAAA   ; /* Modern Browsers */

}
.main-footer {
    padding: 20px 30px 20px 186px;
    margin-top: 40px;
    color: #98a6ad;
    border-top: 1px solid #e3eaef;
    display: inline-block;
    width: 100%;
}

@media print {
  .main-content {
    padding-left: 0px;
    padding-right: 0px;
    padding-top: 0px;
  }
  
  .section .section-title:before {
    display: none;
  }

  .cicilan {
    display: none;
  }

  .cicilan-lead {
    display: none;
  }

  .button-print {
    display: none;
  }
 }
  </style>
<!-- /END GA --></head>
<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

          <div class="section-body">
            <div class="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                        <div>
                        <h4> BUKTI BAYAR MITRA BINAAN </h4>
                        <p>Data per <?= date('M Y') ?></p>
                        </div>
                        <div class="invoice-number"><div class="pb-2 bd-highlight"> <img src='<?= base_url('assets/img/INTI.png') ?>' width='75' height='75' class="img-thumbnail" /></div>
                    </div>
                    </div>
                    <hr>
                    <div class="row justify-content-beetwen">
                        <div class="col-md-3">
                            <detail>
                            No. KONTRAK<br>
                            NAMA PEMINJAM<br>
                            </detail>
                        </div>
                        <div class="col-md-3">
                            <detail>
                            <span class="pr-3">:</span><?= $mitra->nokontrak ?><br>
                            <span class="pr-3">:</span><?= $mitra->nama_peminjam ?><br>
                            </detail>
                        </div>

                        <div class="col-md-3">
                        <detail>
                            MULAI CICIL<br>
                            JATUH TEMPO<br>
                            CICILAN/BULAN<br>
                            DANA BINAAN<br>
                            JASA BINAAN<br>
                            JUMLAH BINAAN<br>
                            </detail>
                        </div>
                        <div class="col-md-3">
                        <detail>
                            <span class="pr-3">:</span><?= $mitra->tglkontrak ?><br>
                            <span class="pr-3">:</span><?= $mitra->tgljatuhtempo ?><br>
                            <span class="pr-3">:</span><?= number_format($mitra->cicilanperbln  ) ?><br>
                            <span class="pr-3">:</span><?= number_format($mitra->pinjpokok) ?><br>
                            <span class="pr-3">:</span><?= number_format($mitra->pinjjasa) ?><br>
                            <span class="pr-3">:</span><?= number_format($mitra->pinjjumlah) ?><br>
                            </detail>
                        </div>
                    </div>
                    </div>
                    
                  </div>
                </div>
                
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">ANGSURAN PINJAMAN</div>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tr>
                          <th data-width="40">Angsuran</th>
                          <th>TANGGAL</th>
                          <th class="text-center">KETERANGAN</th>
                          <th class="text-center">POKOK</th>
                          <th class="text-right">JASA</th>
                          <th class="text-right">JUMLAH</th>
                          <th class="text-right">SALDO</th>
                        </tr>
                          <tr>
                            <td><?= $angsuran['dataOpex'][count($angsuran['dataOpex']) - 1]['no'] ?></td>
                            <td><?= $angsuran['dataOpex'][count($angsuran['dataOpex']) - 1]['tanggal'] ?></td>
                            <td class="text-center"><?= $angsuran['dataOpex'][count($angsuran['dataOpex']) - 1]['deskripsi'] ?></td>
                            <td class="text-center"><?= number_format($angsuran['dataOpex'][count($angsuran['dataOpex']) - 1]['cicil_pokok']) ?></td>
                            <td class="text-right"><?= number_format($angsuran['dataOpex'][count($angsuran['dataOpex']) - 1]['cicil_jasa']) ?></td>
                            <td class="text-right"><?= number_format($angsuran['dataOpex'][count($angsuran['dataOpex']) - 1]['jumlah']) ?></td>
                            <td class="text-right"><?= number_format($angsuran['dataOpex'][count($angsuran['dataOpex']) - 1]['sisaPinjamanJumlah']) ?></td>
                          </tr>
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title cicilan">Total Sisa Cicilan</div>
                        <p class="section-lead cicilan-lead">The payment method that we provide is to make it easier for you to pay invoices.</p>
                      </div>
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">SISA CICILAN</div>
                          <div class="invoice-detail-value invoice-detail-value-lg"><?= number_format(array_pop($angsuran['dataOpex'])['sisaPinjamanJumlah']) ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div>Yang Menerima</div>
                        <div>Bandung, <?= date('d M Y') ?></div>
                        <br><br><br><br>
                        <p>____________________</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-md-right button-print">
                <div class="float-lg-left mb-lg-0 pb-3">
                  <button class="btn btn-danger btn-icon icon-left" onclick="history.back()"><i class="fas fa-times"></i> Cancel</button>
                  <button class="btn btn-warning btn-icon icon-left" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div> 
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</body>
</html>