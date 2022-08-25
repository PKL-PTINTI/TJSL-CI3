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
               <th> LAPORAN AKTIVITAS</th>
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
                  <td><b>PERUBAHAN ASET NETO TIDAK TERIKAT</b></td>
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
                  <td><b>PENDAPATAN</b></td>
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
                  <td>1. Jasa Administrasi Pinjaman</td>
                  <td align="right"><?= number_format($aktivitas[0][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[0]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[0][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>2. Pendapatan Bunga</td>
                  <td align="right"><?= number_format($aktivitas[1][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[1]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[1][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>3. Pendapatan Lain-lain</td>
                  <td align="right"><?= number_format($aktivitas[2][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[2]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[2][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>ALOKASI BUMN PEDULI DAN ASET NETO YANG BERAKHIR</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td>1. Alokasi Dana BUMN Peduli</td>
                  <td align="right"><?= number_format($aktivitas[3][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[3]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[3][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>2. ANTT Berakhir Pemenuhan Program</td>
                  <td align="right"><?= number_format($aktivitas[4][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[4]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[4][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>3. ANTT Berakhir Waktu</td>
                  <td align="right"><?= number_format($aktivitas[5][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[5]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[5][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>JUMLAH 2</td>
                  <td align="right"><?= number_format($aktivitas[6][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[6]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[6][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>JUMLAH PENDAPATAN</td>
                  <td align="right"><?= number_format($aktivitas[7][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[7]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[7][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>BEBAN</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td>1. Dana Pembinaan Kemitraan</td>
                  <td align="right"><?= number_format($aktivitas[8][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[8]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[8][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>2. Dana Bina Lingkungan</td>
                  <td align="right"><?= number_format($aktivitas[9][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[9]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[9][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>3. Beban Administrasi dan Umum</td>
                  <td align="right"><?= number_format($aktivitas[10][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[10]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[10][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>4. Beban Penyusutan Aktiva Tetap</td>
                  <td align="right"><?= number_format($aktivitas[11][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[11]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[11][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>5. Beban Pemeliharaan</td>
                  <td align="right"><?= number_format($aktivitas[12][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[12]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[12][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>6. Beban Penyisihan Piutang</td>
                  <td align="right"><?= number_format($aktivitas[13][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[13]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[13][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>7. Beban dan Pengeluaran lainnya</td>
                  <td align="right"><?= number_format($aktivitas[14][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[14]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[14][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>JUMLAH BEBAN</td>
                  <td align="right"><?= number_format($aktivitas[15][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[15]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[15][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>KENAIKAN(PENURUNAN) ASET NETO TIDAK TERIKAT</td>
                  <td align="right"><?= number_format($aktivitas[16][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[16]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[16][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>PERUBAHAN ASET NETO TERIKAT TEMPORER</b> </td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td>1. ANTT Terbebaskan</td>
                  <td align="right"><?= number_format($aktivitas[17][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[17]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[17][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>2. ANTT Penyisihan BUMN Peduli</td>
                  <td align="right"><?= number_format($aktivitas[18][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[18]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[18][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>KENAIKAN(PENURUNAN) ASET NETO TERIKAT TEMPORER</td>
                  <td align="right"><?= number_format($aktivitas[19][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[19]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[19][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>PERUBAHAN ASET NETO TERIKAT PERMANEN</b> </td>
                  <td></td>
                  <td></td>
                  <td></td>
               <tr>
                  <td>1. Sumbangan Terikat</td>
                  <td align="right"><?= number_format($aktivitas[20][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[20]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[20][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>KENAIKAN(PENURUNAN) ASET NETO TERIKAT PERMANEN</td>
                  <td align="right"><?= number_format($aktivitas[21][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[21]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[21][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>KENAIKAN/(PENURUNAN) ASET NETO</td>
                  <td align="right"><?= number_format($aktivitas[22][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[22]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[22][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td>ASET NETO AWAL TAHUN</td>
                  <td align="right"><?= number_format($aktivitas[23][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[23]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[23][$akhirtahun]) ?></td>
               </tr>
               <td>ASET NETO AKHIR TAHUN</td>
                  <td align="right"><?= number_format($aktivitas[24][$perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[24]['sd' . $perioda]) ?></td>
                  <td align="right"><?= number_format($aktivitas[24][$akhirtahun]) ?></td>
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