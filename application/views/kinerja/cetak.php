<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <!-- BOOTSTRAP STYLES-->
      <!--
         <link href="assets/css/bootstrap.css" rel="stylesheet" />
         -->
      <!-- FONTAWESOME STYLES-->
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
      <!-- MORRIS CHART STYLES-->
      <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
      <!-- CUSTOM STYLES-->
      <link href="assets/css/custom.css" rel="stylesheet" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <!-- GOOGLE FONTS-->
      <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   </head>
   <font size="1">
      <div class="mx-auto" style="width: 750px;">
      <p class="fs-6">
      <div class="d-flex bd-highlight mb-5">
         <div class="p-2 bd-highlight"></div>
         <div class="p-2 bd-highlight"></div>
         <div class="p-2 bd-highlight"> <img src='<?= base_url('assets/img/INTI.png') ?>' width='75' height='75' class="img-thumbnail" /></div>
         <div class="p-2 bd-highlight">
            <th>
               <b>
                  Tanggung Jawab Sosial Lingkungan (TJSL) 
            </th>
            <br>
            <th> LAPORAN KINERJA</th> <br>
            <b>     per <?= date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))) ?> </b>
         </div>
         <div class="p-2 bd-highlight">   </div>
      </div>
      <h6><b>1. Tingkat Pengembalian Pinjaman Mitra Binaan</b></h6>
      <br>
      <table class="table table-sm">
      <thead>
      <tr>
      <th scope="col">No.</th>       
      <th >KOLEKTIBILITAS</th>
      <td align="right"><b> SALDO </b></td>
      <td align="right"><b> PROSENTASE</b></td>
      <td  align="right">TIMBANG</td> 
      </tr>
      </thead>
      <tbody>
      <tr>
      <th scope="row">1. </th>
      <td>Lancar</td>
      <td align="right"><?= number_format($tingkatPengembalianHasil[0][$perioda]) ?></td>
      <td align="right">  100%   </td>
      <td align="right"><?= number_format($tingkatPengembalianHasil[0]['timbang'.$perioda]) ?></td>
      </tr>
      <tr>
      <th scope="row">2. </th>
      <td>Kurang Lancar</td>
      <td align="right"><?= number_format($tingkatPengembalianHasil[1][$perioda]) ?></td>
      <td align="right">  75%   </td>
      <td align="right"><?= number_format($tingkatPengembalianHasil[1]['timbang'.$perioda]) ?></td>
      </tr>
      <tr>
      <th scope="row">3. </th>
      <td>Diragukan</td>
      <td align="right"><?= number_format($tingkatPengembalianHasil[2][$perioda]) ?></td>
      <td align="right">  25%   </td>
      <td align="right"><?= number_format($tingkatPengembalianHasil[2]['timbang'.$perioda]) ?></td>
      </tr>
      <tr>
      <th scope="row">4. </th>
      <td>Macet</td>
      <td align="right"><?= number_format($tingkatPengembalianHasil[3][$perioda]) ?></td>
      <td align="right">  0%   </td>
      <td align="right"><?= number_format($tingkatPengembalianHasil[3]['timbang'.$perioda]) ?></td>
      </tr>
      <tr>
      <th scope="row">5. </th>
      <td>TOTAL</td>
      <td align="right"><?= number_format($tingkatPengembalianHasil[4][$perioda]) ?></td>
      <td>    </td>
      <td align="right"><?= number_format($tingkatPengembalianHasil[4]['timbang'.$perioda]) ?></td>
      </tr>
      <!--
         <tr> 
           <th scope="row"></th>
          <td></td>
          <td></td>
          <td></td>
          <td>  <div class="invisible"> SPASI</div>     </td>
         </tr>
         -->
      </tbody>
      </table>
      <h6><b> Kolektibilitas = Total Timbang/ Total Saldo </b></h6>
      <?= number_format($tingkatPengembalianHasil[4]['timbang'.$perioda]) ?>  <br>
      -----------------------   =   <?= number_format($tingkatPengembalianHasil[5][$perioda]) ?>  % = skor =
      <?= number_format($tingkatPengembalianHasil[6][$perioda]) ?>  <br>
      <!--
         <h6><b> Kolektibilitas =
         2,133,522,840 / 4,342,256,513 = 2 %  = skor 0.00-->
      <?= number_format($tingkatPengembalianHasil[4][$perioda]) ?>
      </b>
      </h6>
      <br>
      <br>
      <h6><b>2. Efektivitas Penyaluran Dana</b></h6>
      <br>
      <h6><b>2.1 Dana yang disalurkan</b></h6>
      <br>
      <table class="table table-sm">
         <tbody>
            <tr>
               <th scope="row">1. </th>
               <td><b> Penyaluran Pinjaman</b></td>
               <td align="right"><b><?= number_format($danaYangDisalurkan[0][$perioda]) ?></b></td>
            </tr>
            <tr>
               <th scope="row">2. </th>
               <td><b> Dana Pembinaan Kemitraan</b></td>
               <td align="right"><b><?= number_format($danaYangDisalurkan[1][$perioda]) ?></b></td>
            </tr>
            <tr>
               <th scope="row">3. </th>
               <td><b> JUMLAH DANA YG DISALURKAN</b></td>
               <td align="right"><b><?= number_format($danaYangDisalurkan[2][$perioda]) ?></b></td>
            </tr>
         </tbody>
      </table>
      <br>
      <h6><b> 2.2 Dana tersedia</b></h6>
      <table class="table table-sm">
         <tbody>
            <tr>
               <th scope="row">1. </th>
               <td><b> Saldo Awal</b></td>
               <td align="right"><b><?= number_format($danatersedia[0][$perioda]) ?></b></td>
            </tr>
            <tr>
               <th scope="row">2. </th>
               <td><b> Jasa Administrasi Pinjaman</b></td>
               <td align="right"><b><?= number_format($danatersedia[1][$perioda]) ?></b></td>
            </tr>
            <tr>
               <th scope="row">3. </th>
               <td><b> Jasa Giro</b></td>
               <td align="right"><b><?= number_format($danatersedia[2][$perioda]) ?></b></td>
            </tr>
            <tr>
               <th scope="row">4. </th>
               <td><b> Pendapatan Lain</b></td>
               <td align="right"><b><?= number_format($danatersedia[3][$perioda]) ?></b></td>
            </tr>
            <tr>
               <th scope="row">5. </th>
               <td><b> Pengembalian Pinjaman Pokok</b></td>
               <td align="right"><b><?= number_format($danatersedia[4][$perioda]) ?></b></td>
            </tr>
            <tr>
               <th scope="row">6. </th>
               <td><b> JUMLAH DANA TERSEDIA
                  </b>
               </td>
               <td align="right"><b><?= number_format($danatersedia[5][$perioda]) ?></b></td>
            </tr>
            <!--    <tr>
               <th scope="row">7. </th>
               
               <td>EFEKTIVITAS PENYALURAN DANA
               (%)= JUMLAH DANA YG DISALURKAN / JUMLAH DANA TERSEDIA
               </td>
               <td align="right">40</td>
               
               </tr>
               -->
            <!--  
               <tr>
                   <th scope="row">8. </th>
                 
                  <td>EFEKTIVITAS PENYALURAN DANA
               (%)= JUMLAH DANA YG DISALURKAN / JUMLAH DANA TERSEDIA
               </td>
                  <td align="right">40</td>
                  
                </tr>
               -->
         </tbody>
      </table>
      <h6><b> Efektifitas Penyaluran = Jumlah dana disalurkan / Jumlah dana tersedia</b></h6>
      <b>
      <?= number_format($danaYangDisalurkan[2][$perioda]) ?>  <br>
      -----------------------   =   <?= number_format($danatersedia[6][$perioda]) ?>  % = skor = <?= number_format($danatersedia[7][$perioda]) ?>  <br>  
      <?= number_format($danatersedia[5][$perioda]) ?></b>
   </font>