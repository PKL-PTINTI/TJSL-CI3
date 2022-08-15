<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   </head>
   <font size="2">
      <?php
         $tanggal = date('t M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
         $akhirtahun = 'sddes' . date('y', mktime(0, 0, 0, 0,0 , date("Y")));
         
         ?>
      <div class="mx-auto" style="width: 750px;">
         <p class="fs-6">
         <div class="d-flex bd-highlight mb-5">
            <div class="p-2 bd-highlight"></div>
            <div class="p-2 bd-highlight"></div>
            <div class="p-2 bd-highlight"> <img src='<?= base_url('assets/img/INTI.png') ?>' width='75' height='75' class="img-thumbnail" /></div>
            <div class="p-2 bd-highlight">
               <th><b>Tanggung Jawab Sosial Lingkungan (TJSL) </th>
               <br>
               <th> LAPORAN ARUS KAS</th>
               <br>
               <b>   PER  <?= $tanggal ?> </b>
            </div>
         </div>
         <table class="table table-sm">
            <thead>
               <tr>
                  <td><b> U R A I A N</b></td>
                  <td align="right"><b> <?= $tanggal; ?></b></td>
                  <td align="right">SD <b> <?= $tanggal; ?></b></td>
                  <td align="right"><b>31 <?= 'DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))) ?></b></td>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td><b>I. AKTIVITAS OPERASI</b></td>
                  <td>
                     <div class="invisible"></div>
                  </td>
                  <td>
                     <div class="invisible"></div>
                  </td>
                  <td>
                     <div class="invisible"></div>
                  </td>
               </tr>
               <tr>
                  <td><b>KAS DITERIMA DARI</b></td>
                  <td>
                     <div class="invisible"></div>
                  </td>
                  <td>
                     <div class="invisible"></div>
                  </td>
                  <td>
                     <div class="invisible"></div>
                  </td>
               </tr>
               <tr>
                  <td>1. Pengembalian Pinjaman Mitra Binaan</td>
                  <td align="right"><?= number_format($aruskas[0][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[0]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[0][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>2. Angsuran Belum Teridentifikasi</td>
                  <td align="right"><?= number_format($aruskas[1][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[1]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[1][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>3. Pendapatan Jasa Administrasi Pinjaman</td>
                  <td align="right"><?= number_format($aruskas[2][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[2]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[2][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>4. Pendapatan Jasa Giro/Bunga Deposito</b></td>
                  <td align="right"><?= number_format($aruskas[3][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[3]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[3][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>5. Pendapatan lain-lain</td>
                  <td align="right"><?= number_format($aruskas[4][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[4]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[4][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>KAS DIKELUARKAN UNTUK </b></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td>1. Penyaluran Pinjaman Kemitraan</td>
                  <td align="right"><?= number_format($aruskas[5][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[5]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[5][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>2. Dana Pembinaan Kemitraan</td>
                  <td align="right"><?= number_format($aruskas[6][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[6]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[6][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>3. Dana Bina Lingkungan</td>
                  <td align="right"><?= number_format($aruskas[7][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[7]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[7][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>4. Beban Pembinaan</td>
                  <td align="right"><?= number_format($aruskas[8][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[8]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[8][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>5. Beban Upah Tenaga Harian</td>
                  <td align="right"><?= number_format($aruskas[9][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[9]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[9][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>6. Beban Administrasi dan Umum</td>
                  <td align="right"><?= number_format($aruskas[10][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[10]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[10][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>7. Pembayaran Beban Pemeliharaan</td>
                  <td align="right"><?= number_format($aruskas[11][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[11]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[11][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>8. Pembayaran Kelebihan Angsuran</td>
                  <td align="right"><?= number_format($aruskas[12][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[12]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[12][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>KAS NETTO DITERIMA(DIGUNAKAN) UNTUK AKTIVITAS OPERASI</td>
                  <td align="right"><?= number_format($aruskas[13][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[13]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[13][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>II. AKTIVITAS INVESTASI</b> </td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td> <b>KAS DIKELUARKAN  UNTUK</b>      </td>
                  <td>       </td>
                  <td>       </td>
                  <td></td>
               </tr>
               <tr>
                  <td>1. Pembelian Aktiva Tetap</td>
                  <td align="right"><?= number_format($aruskas[14][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[14]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[14][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>KAS NETTO DITERIMA (DIGUNAKAN) UNTUK AKTIVITAS INVESTASI</td>
                  <td align="right"><?= number_format($aruskas[15][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[15]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[15][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>KENAIKAN (PENURUNAN) NETTO DALAM KAS/SETARA KAS</td>
                  <td align="right"><?= number_format($aruskas[16][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[16]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[16][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>KAS DAN SETARA KAS PADA AWAL TAHUN</td>
                  <td align="right"><?= number_format($aruskas[17][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[17]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[17][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>KAS DAN SETARA KAS PADA AKHIR TAHUN</td>
                  <td align="right"><?= number_format($aruskas[18][$perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[18]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aruskas[18][$akhirtahun]) ?></td>
               </tr>
            </tbody>
         </table>
         </p>
   </font>
   <!--
      <script>
      		window.print();
      	</script>
      -->
   </div>   
   </p>
   </div>
   </body>
</html>