<?php //get las URI
$last = $this->uri->segment($this->uri->total_segments());
?>

<section class="content-header">
  <h1><i class="fa fa-file-pdf"></i> &nbsp; <?=$judul; ?>

    <button class="btn btn-warning btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-plus"></i>&nbsp; Tambah Data
    </button>

  </h1>        
</section>

<style>
  .error{ color:red; } 
</style>

<section class="content">
  <div class="box">
    <div class="box-header">
    </div>
    <!-- /.box-header -->
    <div class="box-body  my-form-body table-responsive">

      <div class="collapse" id="collapseExample">
        <div class="well">
          <?=form_open(base_url('datajemaah/tambah/'. $kat),array('id'=>'form_datajemaah')); ?>
         <!-- <input type="hidden" name="id" id="product_id">-->
          <div class="row">
            <input type="hidden" name="kat" value="<?=$kat; ?>">
            <div class="col-md-5"><input type="number" name="tahun" value="" placeholder="Tahun" class="form-control" id="tahun" min="2000" max="2050"></div>
            <div class="col-md-4"><input type="number" name="jumlah" value="" placeholder="Jumlah" class="form-control" id="jumlah"></div>
            <div class="col-md-2"><input type="submit" name="submit" value="Tambah Data" class="btn btn-success"></div>
          </div>
          <?=form_close(); ?>
          
        </div>
      </div>

      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Tahun</th>
            <th>Jumlah</th>
            <th style="width:125px;text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($antri as $row) { ?>
            <tr>
              <td><?=$row['tahun']; ?></td>
              <td><?=$row['jumlah']; ?></td>
              <td class="text-center"><a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('datajemaah/hapus/'.$row['id'].'/'.$last); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a></td>
             
          <?php  } ?>
        </tbody>           
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  

<!-- Modal -->
<div id="confirm-delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Hapus</h4>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin menghapus data ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <a class="btn btn-danger btn-ok">Hapus</a>
      </div>
    </div>

  </div>
</div>


<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>

<script type="text/javascript">
  $(function () {
    $("#table").DataTable();
  });
    
  var SITEURL = '<?php echo base_url(); ?>';
  if ($("#form_datajemaah").length > 0) {
    $("#form_datajemaah").validate( {
      rules: {
        tahun: {
          required: true,
          minlength: 2
        },
        jumlah: {
          required: true,
        }
      },
      messages: {
        tahun: {
          required: "Tahun wajib diisi",
          minlength: jQuery.validator.format("At least {0} characters required!")
        },
        gdp_ina: {
          required: "Jumlah wajib diisi",
        }
      },
      submitHandler: function(form) {
        $.ajax({
          url: SITEURL + "datajemaah/tambah/<?=$kat; ?>",
          data: $('#form_datajemaah').serialize(),
          type:"post",
          dataType: 'json',
          success: function(res){
             var gdp_ina = '<tr id="id_' + res.data.id + '"><td>' + res.data.tahun + '</td><td>' + res.data.jumlah + '</td><td class="text-center"><a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="' + SITEURL + '/datajemaah/hapus/' + res.data.id + '" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a></td>';

              $('#table').prepend(gdp_ina);          
              $('#table tr#id_' + res.data.id).addClass("success").delay(1000).queue(function(){
                $(this).removeClass("success", 1000).dequeue();
              });
            },
           error: function (data) {
                  console.log('Error:', data);
               }
        });
      }
    });  
  } //endif

  $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });

  $("#datajemaah").addClass('active');
  $("#datajemaah .<?=$last; ?>").addClass('active');
</script>