
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
                        <h4> KARTU PIUTANG MITRA BINAAN </h4>
                        <p>Data per Agustus 2022</p>
                        </div>
                        <div class="invoice-number"><div class="pb-2 bd-highlight"> <img src='<?= base_url('assets/img/INTI.png') ?>' width='75' height='75' class="img-thumbnail" /></div>
                    </div>
                    </div>
                    <hr>
                    <div class="row justify-content-beetwen">
                        <div class="col-md-3">
                            <detail>
                            No. ID<br>
                            NAMA PERUSAHAAN<br>
                            NAMA PEMILIK<br>
                            ALAMAT<br>
                            STATUS BINAAN<br>
                            TELEPHONE<br>
                            JAMINAN<br>
                            </detail>
                        </div>
                        <div class="col-md-3">
                            <detail>
                            :   data<br>
                            :   data<br>
                            :   data<br>
                            :   data<br>
                            :   data<br>
                            :   data<br>
                            :   data<br>
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
                            :   data<br>
                            :   data<br>
                            :   data<br>
                            :   data<br>
                            :   data<br>
                            :   data<br>
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
                          <th data-width="40">NO</th>
                          <th>TANGGAL</th>
                          <th class="text-center">KETERANGAN</th>
                          <th class="text-center">POKOK</th>
                          <th class="text-right">JASA</th>
                          <th class="text-right">JUMLAH</th>
                          <th class="text-right">SALDO</th>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>Mouse Wireless</td>
                          <td class="text-center">$10.99</td>
                          <td class="text-center">1</td>
                          <td class="text-right">$10.99</td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Keyboard Wireless</td>
                          <td class="text-center">$20.00</td>
                          <td class="text-center">3</td>
                          <td class="text-right">$60.00</td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Headphone Blitz TDR-3000</td>
                          <td class="text-center">$600.00</td>
                          <td class="text-center">1</td>
                          <td class="text-right">$600.00</td>
                        </tr>
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title">Payment Method</div>
                        <p class="section-lead">The payment method that we provide is to make it easier for you to pay invoices.</p>
                        <div class="images">
                          <img src="assets/img/visa.png" alt="visa">
                          <img src="assets/img/jcb.png" alt="jcb">
                          <img src="assets/img/mastercard.png" alt="mastercard">
                          <img src="assets/img/paypal.png" alt="paypal">
                        </div>
                      </div>
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Subtotal</div>
                          <div class="invoice-detail-value">$670.99</div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Shipping</div>
                          <div class="invoice-detail-value">$15</div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value invoice-detail-value-lg">$685.99</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">
                  <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process Payment</button>
                  <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button>
                </div>
                <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <!-- <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script> -->
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <!-- <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script> -->
</body>
</html>