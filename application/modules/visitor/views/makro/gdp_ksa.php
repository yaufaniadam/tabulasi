<section class="content-header">
  <h1><i class="fa fa-file-pdf"></i> &nbsp; Pertumbuhan GDP Kerajaan Saudi Arabia</h1>        
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
          <?=form_open(base_url('makro/tambah_gdp_ksa'),array('id'=>'form_gdp_ksa')); ?>
         <!-- <input type="hidden" name="id" id="product_id">-->
          <div class="row">
            <div class="col-md-6"><input type="number" name="tahun" value="" placeholder="Tahun" class="form-control" id="tahun"></div>
            <div class="col-md-4"><input type="number" name="gdp_ksa" value="" placeholder="GDP KSA in USD" class="form-control" id="gdp_ksa"></div>
            <div class="col-md-2"><input type="submit" name="submit" value="Tambah Data" class="btn btn-success"></div>
          </div>
          <?=form_close(); ?>
          
        </div>
      </div>

      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Tahun</th>
            <th>GDP KSA (% growth)</th>
          
          </tr>
        </thead>
        <tbody>
          <?php foreach ($gdp_ksa as $row) { ?>
            <tr>
              <td><?=$row['tahun']; ?></td>
              <td><?=$row['gdp_ksa']; ?></td>
                 
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
  $("#makro .gdp_ksa").addClass('active');
</script>