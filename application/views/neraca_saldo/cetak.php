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
               <th> LAPORAN Neraca Saldo</th>
               <br>
               <b>   PER  <?= $tanggal ?> </b>
            </div>
         </div>
         <table class="table table-sm">
            <thead>
               <tr>
                  <td align="center"><b>KODE REKENING</b></td>
                  <td><b> U R A I A N</b></td>
                  <td align="right"><b> DES <?= date('Y', mktime(0, 0, 0, 0, 0, date("Y"))) ?></b></td>
                  <td align="right"><b>DEBIT</b></td>
                  <td align="right"><b>KREDIT</b></td>
                  <td align="right"><b>SALDO</b></td>
                  <td align="right"><b>SELISIH</b></td>
               </tr>
            </thead>
            <tbody>
                <?php foreach ($neracasaldo as $n): ?>
                <tr>
                    <td align="center"><?= $n['id_akun'] == 0 ? '' : $n['id_akun'] ?></td>
                    <td><?= $n['nama_akun'] ?></td>
                    <td align="right"><?= number_format($n['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                    <td align="right"><?= number_format($n['debet' . $perioda]) ?></td>
                    <td align="right"><?= number_format($n['kredit' . $perioda]) ?></td>
                    <td align="right"><?= number_format($n['saldo' . $perioda]) ?></td>
                    <td align="right"><?= number_format($n['selisih']) ?></td>
                </tr>
                <?php endforeach; ?>                
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