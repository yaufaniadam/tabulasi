<section class="content-header">
  <h1><i class="fa fa-kaaba"></i> &nbsp; Reksadana Terproteksi Syariah  
  
    <a href="<?=base_url('visitor/keuanganhaji/export_reksadana_terproteksi_syariah/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>

  </h1>
  
</section>
<section class="content">
 
  <div class="row">
    <div class="col-md-12">

        <?php menu_reksadana(); ?>  <br>

        <?php breadcrumb('visitor',$tahun, $thn); ?>

        <?php if($reksadana_terproteksi_syariah) { ?>
        
        <p class="text-success">*) Dalam Miliar Rupiah</p>

        <div class="box-body smy-form-body box-keuangan">        

          <table class="keuangan table table-striped table-bordered" style="width:2200px;min-width: 100%;">
            <thead>
              <tr>
                <th>Instrumen RDTS</th>
                <th>Januari</th>
                <th>Februari</th>
                <th>Maret</th>
                <th>April</th>
                <th>Mei</th>
                <th>Juni</th>
                <th>Juli</th>
                <th>Agustus</th>
                <th>September</th>
                <th>Oktober</th>
                <th>November</th>
                <th>Desember</th> 
              </tr>
            </thead>
            <?php foreach ($reksadana_terproteksi_syariah as $row) { 

            if($row['instrumen'] == "TOTAL") { ?>
              <tfoot>
                <tr class="total">
                  <td><?=$row['instrumen']; ?></td>
                  <td style="text-align: right;"><?=$row['januari']; ?></td>
                  <td style="text-align: right;"><?=$row['februari']; ?></td>
                  <td style="text-align: right;"><?=$row['maret']; ?></td>
                  <td style="text-align: right;"><?=$row['april']; ?></td>
                  <td style="text-align: right;"><?=$row['mei']; ?></td>
                  <td style="text-align: right;"><?=$row['juni']; ?></td>
                  <td style="text-align: right;"><?=$row['juli']; ?></td>
                  <td style="text-align: right;"><?=$row['agustus']; ?></td>
                  <td style="text-align: right;"><?=$row['september']; ?></td>
                  <td style="text-align: right;"><?=$row['oktober']; ?></td>
                  <td style="text-align: right;"><?=$row['november']; ?></td>
                  <td style="text-align: right;"><?=$row['desember']; ?></td>
                </tr>
              </tfoot>
            <?php } else { ?>               
              <tr>
                <td><?=$row['instrumen']; ?></td>
                <td style="text-align: right;"><?=$row['januari']; ?></td>
                <td style="text-align: right;"><?=$row['februari']; ?></td>
                <td style="text-align: right;"><?=$row['maret']; ?></td>
                <td style="text-align: right;"><?=$row['april']; ?></td>
                <td style="text-align: right;"><?=$row['mei']; ?></td>
                <td style="text-align: right;"><?=$row['juni']; ?></td>
                <td style="text-align: right;"><?=$row['juli']; ?></td>
                <td style="text-align: right;"><?=$row['agustus']; ?></td>
                <td style="text-align: right;"><?=$row['september']; ?></td>
                <td style="text-align: right;"><?=$row['oktober']; ?></td>
                <td style="text-align: right;"><?=$row['november']; ?></td>
                <td style="text-align: right;"><?=$row['desember']; ?></td>               
              </tr>
            <?php } // endif

            } //endforeach get bps bpih ?>          
           
          </table>
          <?php } else { echo '<p class="alert alert-success"> Pilih tahun</p>';} ?> 
      </div>
    </div>
  </div>  
</section> 

<script>
    $("#alokasi_produk_investasi").addClass('active');
    $("#alokasi_produk_investasi .reksadana").addClass('active');
</script>





