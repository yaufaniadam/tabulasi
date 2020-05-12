<section class="content-header">
  <h1><i class="fa fa-file-pdf"></i> &nbsp; Suku Bunga LPS Indonesia</h1>        
</section>

<style>
  .error{ color:red; } 
</style>

<section class="content">
  <div class="box">
    <div class="box-header">
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">

      <div class="collapse" id="collapseExample">
        <div class="well">
          <?=form_open(base_url('makro/tambah_suku_bunga_lps'),array('id'=>'form_suku_bunga_lps')); ?>
         <!-- <input type="hidden" name="id" id="product_id">-->
          <div class="row">
            <div class="col-md-6"><input type="number" name="tahun" value="" placeholder="Tahun" class="form-control" id="tahun"></div>
            <div class="col-md-4"><input type="number" name="suku_bunga_lps" value="" placeholder="Suku Bunga LPS Indonesia" class="form-control" id="suku_bunga_lps"></div>
            <div class="col-md-2"><input type="submit" name="submit" value="Tambah Data" class="btn btn-success"></div>
          </div>
          <?=form_close(); ?>
          
        </div>
      </div>

      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Tahun</th>
            <th>Suku Bunga LPS (%)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($suku_bunga_lps as $row) { ?>
            <tr>
              <td><?=$row['tahun']; ?></td>
              <td><?=$row['suku_bunga_lps']; ?></td>
            <?php  } ?>
        </tbody>           
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  



<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
  $(function () {
    $("#table").DataTable();
  });
    
  $("#makro").addClass('active');
  $("#makro .suku_bunga_lps").addClass('active');
</script>