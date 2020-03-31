<section class="content-header">
  <h1>VIEW <a href="<?=base_url('keuanganhaji/form'); ?>" class="btn btn-default btn-sm">Tambah Data</a></h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body smy-form-body">   
          <pre>
        <?php print_r($siswa); ?>    
          </pre>
          <table class="table table-striped table-bordered">
            <tr>
              <th>No</th>
              <th>BPS_BPIH</th>
              <th>Jumlah</th>
              <th>Bulan</th>
              <th>Tahun</th>
            </tr>

            <?php
            if( ! empty($siswa)){ // Jika data pada database tidak sama dengan empty (alias ada datanya)
              $i=1;
              foreach($siswa as $data){ // Lakukan looping pada variabel siswa dari controller
                echo "<tr>";
                echo "<td>".$i++."</td>";
                echo "<td>".$data->bps_bpih."</td>";
                echo "<td>".$data->jumlah."</td>";
                echo "<td>".$data->bulan."</td>";
                echo "<td>".$data->tahun."</td>";
          
                echo "</tr>";
              }
            }else{ // Jika data tidak ada
              echo "<tr><td colspan='4'>Data tidak ada</td></tr>";
            }
            ?>
            </table>
                  </div>
                  <!-- /.box-body -->
                </div>
              </div>
            </div>  
          </section> 


<script>
    $("#pengelolaan_keuangan_haji").addClass('active');
    $("#pengelolaan_keuangan_haji .sebaran_dana_haji").addClass('active');
</script>

