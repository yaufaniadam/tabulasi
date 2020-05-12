<section class="content-header">
  <h1><i class="fa fa-file-pdf"></i> &nbsp; Indeks Saham Syariah Indonesia</h1>        
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
            <th>Indeks Saham Syariah</th>
           
          </tr>
        </thead>
        <tbody>
          <?php foreach ($indeks_saham_syariah as $row) { ?>
            <tr>
              <td><?=$row['tahun']; ?></td>
              <td><?=$row['indeks_saham_syariah']; ?></td>
              
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
  $("#makro .indeks_saham_syariah").addClass('active');
</script>