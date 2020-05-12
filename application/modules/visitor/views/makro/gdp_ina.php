<section class="content-header">
  <h1><i class="fa fa-file-pdf"></i> &nbsp; Pertumbuhan GDP Indonesia </h1>        
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

      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Tahun</th>
            <th>GDP Indonesia (% growth)</th>
           
          </tr>
        </thead>
        <tbody>
          <?php foreach ($gdp_ina as $row) { ?>
            <tr>
              <td><?=$row['tahun']; ?></td>
              <td><?=$row['gdp_ina']; ?></td>
                 
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
  $("#makro .gdp_ina").addClass('active');
</script>