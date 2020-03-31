 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">  

 <section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-body">
        <div class="col-md-6">
          <h4><i class="fa fas fa-building"></i> &nbsp; Jenis Penempatan</h4>
        </div>
        <div class="col-md-6 text-right">
          
        </div>
        
      </div>
    </div>
  </div>


   <div class="box">
    <div class="box-header">
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="lembaga" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Jenis Penempatan</th>
          <th>Keterangan</th>
          
          <th style="width:100px;text-align:center;">Aksi</th>
       
          
        </tr>
        </thead>
        <tbody>
          <?php  foreach($all_jenis_penempatan as $row): ?>
          <tr>
            <td><?= $row['jenis_penempatan']; ?></td>
            <td><?= $row['keterangan']; ?></td>
           
            <td style="width:100px;text-align:center;">              
            
               <a title="Edit" class="update btn btn-sm btn-success" href="<?php echo base_url('admin/lembaga/edit/' . $row['id']); ?>"> <i class="fa fas fa-pencil-alt"></i></a> 
              <!--<a title="Edit" class="delete btn btn-sm btn-danger" data-toggle="modal" data-target="#confirm-delete" data-href="<?php echo base_url('admin/lembaga/del/' . $row['id'].'/lembaga'); ?>"> <i class="fa fa-trash-o"></i></a>-->
            </td>            
		  </tr>
          <?php endforeach;?>
        </tbody>
       
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  


<!-- Modal -->
<div id="add_unit" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Lembaga</h4>
      </div>
      <div class="modal-body">
        
         <?php echo form_open(base_url('admin/unit/tambah_unit'), 'class="form-horizontal"');  ?> 
              <div class="form-group">
                <div class="col-sm-12">
                  <input type="text" name="nama_unit" class="form-control" id="nama_unit" placeholder="Nama Unit Kerja">
                </div>
              </div>
             
         
          
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Tambah Unit Kerja" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>

      </div>
    </div>

  </div>
</div>

<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  //datatable
  var table =$("#lembaga").DataTable(
  {
    order: [[ 1, "asc" ]],
      language: {
        searchPlaceholder: "Cari data"
      }
    }
  );
  
  //for nav
  $("#jenis_Penempatan").addClass('active');
  $("#jenis_Penempatan .submenu_jenis_Penempatan").addClass('active');

  //modal
  $('#confirm-delete').on('show.bs.modal', function(e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
</script>
