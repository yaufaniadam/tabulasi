<section class="content-header">
  <h1><i class="fa fa-kaaba"></i> &nbsp; Tambah Alokasi Investasi </h1>        
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body my-form-body">
  
        <?php 

        if(isset($_POST['submit'])) {

           // Buat sebuah tag form untuk proses import data ke database
          echo form_open_multipart(base_url('keuanganhaji/alokasi/import_alokasi_investasi/'.$file_excel), 'class="form-horizontal"' );

          
          echo "<table class='keuangan table table-bordered table-striped'>
         
          <tr>
            <th>Uraian</th>
            <th>Jumlah</th>
            <th>Bulan</th>            
          </tr>";
          
          $numrow = 1;
          $kosong = 0;
          
          // Lakukan perulangan dari data yang ada di excel
          // $sheet adalah variabel yang dikirim dari controller
          $bulan = $sheet['1']['B'];

          foreach($sheet as $row){ 
            // Ambil data pada excel sesuai Kolom            

            $bps_bpih=$row['A']; 
            $jumlah=$row['B']; 
            $bulan = $bulan;
           
           
            if($numrow > 1){            
              
              echo "<tr>";            
              echo "<td>".$bps_bpih."</td>"; 
              echo "<td class='text-right'>".$jumlah."</td>";
              echo "<td class='text-center'>".$bulan."</td>";
            
              echo "</tr>";
            }
            
            $numrow++; // Tambah 1 setiap kali looping
          }
          
          echo "</table>";
          
          // Cek apakah variabel kosong lebih dari 0
          // Jika lebih dari 0, berarti ada data yang masih kosong
          if($kosong > 0){
          ?>  
            <script>
            $(document).ready(function(){
              // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
              $("#jumlah_kosong").html('<?php echo $kosong; ?>');
              
              $("#kosong").show(); // Munculkan alert validasi kosong
            });
            </script>
          <?php
          }else{ // Jika semua data sudah diisi
            echo "<hr>";
            
            // Buat sebuah tombol untuk mengimport data ke database
            echo "<button class='btn btn-success' type='submit' name='import'>Import</button>";
            echo "  <a class='btn btn-warning' href='".base_url("keuanganhaji/alokasi/alokasi_investasi")."'>Cancel</a>";
          }
          
          echo form_close(); 

        } else {

          echo form_open_multipart(base_url('keuanganhaji/alokasi/tambah_alokasi_investasi'), 'class="form-horizontal"' )?> 
            <div class="form-group">
              <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i><strong> Panduan Import Data</strong></p>

              <ol class="panduan-pengisian">
                <li>Ekstensi File yang didukung hanya .xlsx</li>
                <li>Data yang diimport harus mengikuti template yang sudah disediakan. <a href="<?=base_url('public/template-excel/keuanganhaji/alokasi_investasi_bpkh.xlsx'); ?>" class="btn btn-success btn-xs"><i class="fas fa-file-excel"></i> Unduh Template Excel</a></li>
                <li>Kolom Tahun wajib diisi</li>
                <li>Data yang dapat diimport hanya data satu bulan</li>
                <li>Format Tahun : 2020, dst</li>               
                <li>Format bulan  : Januari, Februari, Maret, dst</li>               
              </ol>
              <input type="file" name="file" class="form-control">
            </div>
        
            <div class="form-group">
              <input type="submit" name="submit" value="Upload" class="btn btn-default pull-right">
            </div>

          <?php echo form_close();  
        }
        ?>

         
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>  
</section> 


<script>
    $("#pos_tertentu").addClass('active');
    $("#pos_tertentu .alokasi_investasi").addClass('active');
</script>



  