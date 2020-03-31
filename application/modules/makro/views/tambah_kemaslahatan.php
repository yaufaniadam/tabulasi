<section class="content-header">
  <h1><i class="fa fa-kaaba"></i> &nbsp; Tambah Kemaslahatan </h1>        
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
          echo form_open_multipart(base_url('kemaslahatan/import_kemaslahatan/'.$file_excel), 'class="form-horizontal"' );

          
          echo "<table class='table table-bordered table-striped'>
         
          <tr>
            <th>Bulan</th>
            <th>Nama Penerima</th>
            <th>Lokasi</th> 
            <th>Asnaf</th> 
            <th>Nilai</th>         
          </tr>";
          
          $numrow = 1;
          $kosong = 0;
          
          foreach($sheet as $row){ 
            // Ambil data pada excel sesuai Kolom                
           
            if($numrow > 1){            
              
              echo "<tr>";            
              echo "<td>".$row['A']."</td>"; 
              echo "<td>".$row['B']."</td>";
              echo "<td>".$row['C']."</td>";
              echo "<td>".$row['D']."</td>";
              echo "<td>".$row['E']."</td>";
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
            echo "  <a class='btn btn-warning' href='".base_url("keuanganhaji/nilaimanfaat/per_instrumen")."'>Cancel</a>";
          }
          
          echo form_close(); 

        } else {

          echo form_open_multipart(base_url('kemaslahatan/tambah_kemaslahatan'), 'class="form-horizontal"' )?> 
            <div class="form-group">
              <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> File yang diizinkan hanya yang berekstensi <strong>.xlsx</strong> dengan ukuran maksimal 2mb</p>
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
    $("#kemaslahatan").addClass('active');
</script>



  