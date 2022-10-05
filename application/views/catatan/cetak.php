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
         $tanggal = date('t M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
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
               <th>CATATAN ATAS LAPORAN KEUANGAN</th>
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
                  <td><b>KAS</b></td>
                  <td align="right"><b><?= number_format($catatan[0][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[0][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Kas PK</td>
                  <td align="right"><?= number_format($catatan[1][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[1][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>BANK</b></td>
                  <td align="right"><b><?= number_format($catatan[2][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[2][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Mandiri</td>
                  <td align="right"><?= number_format($catatan[3][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[3][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">BRI</td>
                  <td align="right"><?= number_format($catatan[4][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[4][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>KAS DAN BANK YANG DIBATASI PENGGUNAANNYA</b></td>
                  <td align="right"><b><?= number_format($catatan[5][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[5][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Kas Dan Bank Yang Dibatasi Penggunaanya</td>
                  <td align="right"><?= number_format($catatan[6][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[6][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>PIUTANG MITRA BINAAN</b></td>
                  <td align="right"><b><?= number_format($catatan[7][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[7][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Industri</td>
                  <td align="right"><?= number_format($catatan[8][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[8][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perdagangan</td>
                  <td align="right"><?= number_format($catatan[9][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[9][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Pertanian</td>
                  <td align="right"><?= number_format($catatan[10][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[10][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perkebunan</td>
                  <td align="right"><?= number_format($catatan[11][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[11][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perikanan</td>
                  <td align="right"><?= number_format($catatan[12][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[12][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Peternakan</td>
                  <td align="right"><?= number_format($catatan[13][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[13][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Jasa</td>
                  <td align="right"><?= number_format($catatan[14][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[14][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Lain-lain</td>
                  <td align="right"><?= number_format($catatan[15][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[15][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>ALOKASI PENYISIHAN PIUTANG MB</b></td>
                  <td align="right"><b><?= number_format($catatan[16][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[16][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Industri</td>
                  <td align="right"><?= number_format($catatan[17][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[17][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perdagangan</td>
                  <td align="right"><?= number_format($catatan[18][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[18][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Pertanian</td>
                  <td align="right"><?= number_format($catatan[19][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[19][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perkebunan</td>
                  <td align="right"><?= number_format($catatan[20][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[20][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perikanan</td>
                  <td align="right"><?= number_format($catatan[21][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[21][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Peternakan</td>
                  <td align="right"><?= number_format($catatan[22][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[22][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Jasa</td>
                  <td align="right"><?= number_format($catatan[23][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[23][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Lain-lain</td>
                  <td align="right"><?= number_format($catatan[24][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[24][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>PIUTANG JASA ADMINISTRASI PINJAMAN</b></td>
                  <td align="right"><b><?= number_format($catatan[25][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[25][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Piutang Jasa Administrasi Pinjaman</td>
                  <td align="right"><?= number_format($catatan[26][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[26][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>HARGA PEROLEHAN ASET TETAP</b></td>
                  <td align="right"><b><?= number_format($catatan[27][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[27][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Inventaris Kantor</td>
                  <td align="right"><?= number_format($catatan[28][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[28][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>AKUMULASI PENYUSUTAN ASET TETAP</b></td>
                  <td align="right"><b><?= number_format($catatan[29][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[29][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Inventaris Kantor</td>
                  <td align="right"><?= number_format($catatan[30][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[30][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>PIUTANG BERMASALAH</b></td>
                  <td align="right"><b><?= number_format($catatan[31][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[31][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Industri</td>
                  <td align="right"><?= number_format($catatan[32][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[32][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perdagangan</td>
                  <td align="right"><?= number_format($catatan[33][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[33][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Pertanian</td>
                  <td align="right"><?= number_format($catatan[34][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[34][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perkebunan</td>
                  <td align="right"><?= number_format($catatan[35][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[35][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perikanan</td>
                  <td align="right"><?= number_format($catatan[36][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[36][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Peternakan</td>
                  <td align="right"><?= number_format($catatan[37][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[37][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Jasa</td>
                  <td align="right"><?= number_format($catatan[38][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[38][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Lain-lain</td>
                  <td align="right"><?= number_format($catatan[39][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[39][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>ALOKASI PIUTANG BERMASALAH</b></td>
                  <td align="right"><b><?= number_format($catatan[40][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[40][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Industri</td>
                  <td align="right"><?= number_format($catatan[41][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[41][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perdagangan</td>
                  <td align="right"><?= number_format($catatan[42][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[42][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Pertanian</td>
                  <td align="right"><?= number_format($catatan[43][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[43][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perkebunan</td>
                  <td align="right"><?= number_format($catatan[44][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[44][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perikanan</td>
                  <td align="right"><?= number_format($catatan[45][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[45][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Peternakan</td>
                  <td align="right"><?= number_format($catatan[46][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[46][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Jasa</td>
                  <td align="right"><?= number_format($catatan[47][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[47][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Lain-lain</td>
                  <td align="right"><?= number_format($catatan[48][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[48][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>PROGRAM KEMITRAAN</b></td>
                  <td align="right"><b><?= number_format($catatan[49][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[49][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Kelebihan Pembayaran Angsuran</td>
                  <td align="right"><?= number_format($catatan[50][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[50][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Angsuran Belum Teridentifikasi</td>
                  <td align="right"><?= number_format($catatan[51][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[51][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>AKTIVA BERSIH AWAL PERIODA</b></td>
                  <td align="right"><b><?= number_format($catatan[52][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[52][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Aktiva Bersih Awal Perioda</td>
                  <td align="right"><?= number_format($catatan[53][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[53][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>PENDAPATAN</b></td>
                  <td align="right"><b><?= number_format($catatan[54][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[54][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Jasa Administrasi Pinjaman</td>
                  <td align="right"><?= number_format($catatan[55][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[55][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Jasa Giro PK</td>
                  <td align="right"><?= number_format($catatan[56][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[56][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Pendapatan Lain-lain, Piutang Hapus Buku</td>
                  <td align="right"><?= number_format($catatan[57][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[57][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Pendapatan Lain-lain, Penyesuaian Alokasi Penyisihan</td>
                  <td align="right"><?= number_format($catatan[58][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[58][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Pendapatan Lain-lain, Lain-lain</td>
                  <td align="right"><?= number_format($catatan[59][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[59][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>BEBAS UMUM</b></td>
                  <td align="right"><b><?= number_format($catatan[60][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[60][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Beban Adm dan Umum</td>
                  <td align="right"><?= number_format($catatan[61][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[61][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Beban Adm dan Umum BL</td>
                  <td align="right"><?= number_format($catatan[62][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[62][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>BEBAN PENYISIHAN PIUTANG</b></td>
                  <td align="right"><b><?= number_format($catatan[63][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[63][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Industri</td>
                  <td align="right"><?= number_format($catatan[64][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[64][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perdagangan</td>
                  <td align="right"><?= number_format($catatan[65][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[65][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Pertanian</td>
                  <td align="right"><?= number_format($catatan[66][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[66][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perkebunan</td>
                  <td align="right"><?= number_format($catatan[67][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[67][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Perikanan</td>
                  <td align="right"><?= number_format($catatan[68][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[68][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Peternakan</td>
                  <td align="right"><?= number_format($catatan[69][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[69][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Jasa</td>
                  <td align="right"><?= number_format($catatan[70][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[70][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Sektor Lain-lain</td>
                  <td align="right"><?= number_format($catatan[71][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[71][$akhirtahun]) ?></td>
               </tr>
               <tr>
                  <td><b>BEBAN LAIN-LAIN</b></td>
                  <td align="right"><b><?= number_format($catatan[72][$perioda]) ?></b></td>
                  <td align="right"><b><?= number_format($catatan[72][$akhirtahun]) ?></b></td>
               </tr>
               <tr>
                  <td style="padding-left: 25px;">Lain-lain</td>
                  <td align="right"><?= number_format($catatan[73][$perioda]) ?></td>
                  <td align="right"><?= number_format($catatan[73][$akhirtahun]) ?></td>
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