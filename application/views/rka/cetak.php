<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <!-- GOOGLE FONTS-->
      <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> -->
      <link href='http://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css' />
   </head>
   <font size="2">
      <div class="mx-auto" style="width: 750px;">
         <p class="fs-6">
         <div class="d-flex bd-highlight mb-5">
            <div class="p-2 bd-highlight">
               <img src='<?= base_url('assets/img/INTI.png') ?>' width='75' height='75' class="img-thumbnail">
            </div>
            <div class="p-2 bd-highlight">
               <th>
                  <b>
                     Tanggung Jawab Sosial Lingkungan (TJSL) 
               </th>
               <br>
               <th> LAPORAN POSISI KEUANGAN</th> <br>
               <b>     Per <?= $bulan ?> </b>
            </div>
            <div class="p-2 bd-highlight">   </div>
         </div>
         <table class="table table-sm">
         <thead>
         <tr>
         <th scope="row"></th>
         <td>  </td>
         <td>U R A I A N</td>  
         <td align="right"><b> 31 <?= $bulan ?></b></td>
         <td align="right"><b>31 Des <?= date('Y', mktime(0, 0, 0, 0,0 , date("Y"))) ?></b></td>
         </tr>
         </thead>
         <tbody>
         <tr>
         <th scope="row"></th>
         <td></td>
         <td><font color="red">  <b>A S E T</b></font>     </td>
         <td></td>
         <td></td>
         </tr>
         <tr>
         <th scope="row"></th> 
         <td></td>
         <td> <font color="green"> <b>ASET  LANCAR</b></font>     </td>
         <td>  <div class="invisible"></div>     </td>
         <td></td>
         </tr>
         <tr>
         <th scope="row"></th>
         <td></td>
         <td>1. Kas</td>
         <td align="right"><?= number_format($neraca[0][$perioda]) ?></td>
         <td align="right"><?= number_format($neraca[0]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
         </tr>
         <tr> 
         <th scope="row"></th>
         <td></td>
         <td>2. Bank</td>
         <td align="right"><?= number_format($neraca[1][$perioda]) ?></td>
         <td align="right"><?= number_format($neraca[1]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
         <td>  <div class="invisible"></div>     </td>
         </tr>
         <tr> 
         <th scope="row"></th>
         <td></td>
         <td>3. Piutang Pinjaman Mitra Binaan</td>
         <td align="right"><?= number_format($neraca[2][$perioda]) ?></td>
         <td align="right"><?= number_format($neraca[2]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td>
         <td>  <div class="invisible"></div>     </td>
         </tr>
         <tr> 
         <th scope="row"></th>
         <td></td>
         <td>4. Alokasi Penyisihan Piutang Pinjaman Mitra Binaan</td>
         <td align="right"><?= number_format($neraca[3][$perioda]) ?></td>
         <td align="right"><?= number_format($neraca[3]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></td>
         <td>  <div class="invisible"></div>     </td>
         </tr>
         <tr>
         <th scope="row"></th>
         <td></td>      
         <td><b>JUMLAH ASET LANCAR</b></td>
         <td align="right"><b><?= number_format($neraca[4][$perioda]) ?></b></td>
         <td align="right"><b><?= number_format($neraca[4]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></b></td>
         <td>  <div class="invisible">.</div>     </td> 
         </tr>
         <tr>     
         <th scope="row"></th> 
         <td>
   </font>
   </td>
   <td><b><font color="green">ASET TETAP BERSIH</b></td>
   <td>  <div class="invisible"></div>   </td>
   <td></td>
   </tr>
   <tr>      
   <th scope="row"></th>
   <td></td>
   <td>1. Inventaris dan Peralatan</td>
   <td align="right"><?= number_format($neraca[5][$perioda]) ?></td>
   <td align="right"><?= number_format($neraca[5]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></td>
   <td></td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td>2. Akumulasi Penyusutan Inventaris dan Peralatan</td>
   <td align="right"><?= number_format($neraca[6][$perioda]) ?></td>
   <td align="right"><?= number_format($neraca[6]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></td>
   <td></td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td><b>JUMLAH ASET TETAP BERSIH</b></td>
   <td align="right"><b><?= number_format($neraca[7][$perioda]) ?></b></td>
   <td align="right"><b><?= number_format($neraca[7]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></b></td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>      
   <th scope="row"></th>
   <td></td>
   <td><font color="green"><b> ASET LAIN LAIN</b></font></td>
   <td></td>
   <td></td>
   </tr>
   <tr>      
   <th scope="row"></th>
   <td></td>
   <td>1. Piutang Bermasalah</td>
   <td align="right"><?= number_format($neraca[8][$perioda]) ?></td>
   <td align="right"><?= number_format($neraca[8]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></td>
   <td></td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td>2. Alokasi Penyisihan Piutang Bermasalah</td>
   <td align="right"><?= number_format($neraca[9][$perioda]) ?></td>
   <td align="right"><?= number_format($neraca[9]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></td>
   <td></td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td><b>JUMLAH ASET LAIN-LAIN</b></td>
   <td align="right"><b><?= number_format($neraca[10][$perioda]) ?></b></td>
   <td align="right"><b><?= number_format($neraca[10]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></b></td>
   <td >  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td><b>JUMLAH ASET</b></td>
   <td align="right"><b><?= number_format($neraca[11][$perioda]) ?></b></td>
   <td align="right"><b><?= number_format($neraca[11]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></b></td>
   <td >  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"> </th>
   <td></td>
   <td>  <font color="red"><b>LIABILITAS DAN ASET NETO</b></font>    </td>
   <td>  <div class="invisible"></div>     </td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th> 
   <td></td>
   <td>  <font color="green"><b>LIABILITAS</b></font>   </td>
   <td>  <div class="invisible"></div>     </td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th> 
   <td>  <div class="invisible"></div>     </td>
   <td><font color="green"><b>Liabilitas Jangka Pendek</b></font></td> 
   <td>  <div class="invisible"></div>     </td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td>1. Kelebihan Pembayaran Angsuran</td>
   <td align="right"><?= number_format($neraca[12][$perioda]) ?></td>
   <td align="right"><?= number_format($neraca[12]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td>2. Angsuran Belum Teridentifikasi</td>
   <td align="right"><?= number_format($neraca[13][$perioda]) ?></td>
   <td align="right"><?= number_format($neraca[13]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th> 
   <td>  <div class="invisible"></div>     </td>
   <td><font color="green"><b>Liabilitas Jangka Panjang</b></font></td>
   <td>  <div class="invisible"></div>     </td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td>1. Kewajiban Jangka Panjang</td>
   <td align="right"><?= number_format($neraca[14][$perioda]) ?></td>
   <td align="right"><?= number_format($neraca[14]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td><b>JUMLAH LIABILITAS</b></td>
   <td align="right"><b><?= number_format($neraca[15][$perioda]) ?></b></td>
   <td align="right"><b><?= number_format($neraca[15]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></b></td>
   <td >  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th> 
   <td>  <div class="invisible"></div>     </td>
   <td><font color="green"><b>ASET NETO</b></font></td>
   <td>  <div class="invisible"></div>     </td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td>1. Aset Neto Terikat</td>
   <td align="right"><?= number_format($neraca[16][$perioda]) ?></td>
   <td align="right"><?= number_format($neraca[16]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td>2. Aset Neto Tidak Terikat</td>
   <td align="right"><?= number_format($neraca[17][$perioda]) ?></td>
   <td align="right"><?= number_format($neraca[17]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></b></td></td>
   <td>  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td><b>JUMLAH ASET NETO</b></td>
   <td align="right"><b><?= number_format($neraca[18][$perioda]) ?></b></td>
   <td align="right"><b><?= number_format($neraca[18]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></b></td></b></td>
   <td >  <div class="invisible"></div>     </td>
   </tr>
   <tr>
   <th scope="row"></th>
   <td></td>
   <td><b>JUMLAH LIABILITAS DAN ASET NETO</b></td>
   <td align="right"><b><?= number_format($neraca[19][$perioda]) ?></b></td>
   <td align="right"><b><?= number_format($neraca[19]['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td></td></b></td></b></td>
   <td >  <div class="invisible"></div>     </td>
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
</html>