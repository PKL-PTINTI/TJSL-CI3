<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   </head>
   <font size="1">
      <?php
         $tanggal = month_name(periode_to_month($perioda)) . ' ' . date('Y');
         $akhirtahun = 'des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")));
         
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
               <th> LAPORAN POSISI KEUANGAN</th>
               <br>
               <b>   PER  <?= $tanggal ?> </b>
            </div>
         </div>
         <table class="table table-sm">
            <thead>
               <tr>
                  <td><b> U R A I A N</b></td>
                  <td align="right"><b> <?= $tanggal; ?></b></td>
                  <td align="right"><b>31 <?= 'DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))) ?></b></td>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td><b>ASET</b></td>
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
                  <td><b>ASET LANCAR</b></td>
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
                  <td style="padding-left: 25px;">1. Kas</td>
                  <td align="right"><?= number_format($neraca[0][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[0][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">2. Bank</td>
                  <td align="right"><?= number_format($neraca[1][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[1][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">3. Piutang Pinjaman Mitra Binaan</td>
                  <td align="right"><?= number_format($neraca[2][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[2][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">4. Alokasi Penyisihan Piutang Pinjaman Mitra Binaan</td>
                  <td align="right"><?= number_format($neraca[3][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[3][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>JUMLAH ASET LANCAR</b></td>
                  <td align="right"><b><?= number_format($neraca[4][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($neraca[4][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td><b>ASET TETAP BERSIH</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">1. Inventaris dan Peralatan</td>
                  <td align="right"><?= number_format($neraca[5][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[5][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">2. Akumulasi Penyusutan Inventaris dan Peralatan</td>
                  <td align="right"><?= number_format($neraca[6][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[6][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>JUMLAH ASET TETAP BERSIH</b></td>
                  <td align="right"><b><?= number_format($neraca[7][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($neraca[7][$akhirtahun]) ?></b></td>
               </tr>    
               <tr>
                  <td><b>ASET LAIN LAIN</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
                  <td style="padding-left: 25px;">1. Piutang Bermasalah</td>
                  <td align="right"><?= number_format($neraca[8][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[8][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">2. Alokasi Penyisihan Piutang Bermasalah</td>
                  <td align="right"><?= number_format($neraca[9][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[9][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>JUMLAH ASET LAIN-LAIN</b></td>
                  <td align="right"><b><?= number_format($neraca[10][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($neraca[10][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td><b>JUMLAH ASET</b></td>
                  <td align="right"><b><?= number_format($neraca[11][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($neraca[11][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td><b>LIABILITAS DAN ASET NETO</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td><b>LIABILITAS</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td><b>Liabilitas Jangka Pendek</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">1. Kelebihan Pembayaran Angsuran</td>
                  <td align="right"><?= number_format($neraca[12][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[12][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">2. Angsuran Belum Teridentifikasi</td>
                  <td align="right"><?= number_format($neraca[13][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[13][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>Liabilitas Jangka Panjang</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">1. Kewajiban Jangka Panjang</td>
                  <td align="right"><?= number_format($neraca[14][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[14][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>JUMLAH LIABILITAS</b></td>
                  <td align="right"><b><?= number_format($neraca[15][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($neraca[15][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td><b>ASET NETO</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">1. Aset Neto Terikat</td>
                  <td align="right"><?= number_format($neraca[16][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[16][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">2. Aset Neto Tidak Terikat</td>
                  <td align="right"><?= number_format($neraca[17][$perioda]) ?></td>
                  <td align="right"><?= number_format($neraca[17][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>JUMLAH ASET NETO</b></td>
                  <td align="right"><b><?= number_format($neraca[18][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($neraca[18][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td><b>JUMLAH LIABILITAS DAN ASET NETO</b></td>
                  <td align="right"><b><?= number_format($neraca[19][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($neraca[19][$akhirtahun]) ?></b></td>
               </tr>                      
            </tbody>
         </table>
</p>
   </font>
   
      <script>
      		window.print();
      	</script>
     
   </div>   
   </p>
   </div>
   </body>
</html>