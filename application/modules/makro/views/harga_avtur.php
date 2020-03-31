<section class="content-header">
  <h1><i class="fa fa-file-pdf"></i> &nbsp; Harga Avtur Indonesia

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
    <div class="box-body table-responsive">

      <div class="collapse" id="collapseExample">
        <div class="well">
          <?=form_open(base_url('makro/tambah_harga_avtur'),array('id'=>'form_harga_avtur')); ?>
         <!-- <input type="hidden" name="id" id="product_id">-->
          <div class="row">
            <div class="col-md-6"><input type="number" name="tahun" value="" placeholder="Tahun" class="form-control" id="tahun"></div>
            <div class="col-md-4"><input type="number" name="harga_avtur" value="" placeholder="Harga Avtur Indonesia" class="form-control" id="harga_avtur"></div>
            <div class="col-md-2"><input type="submit" name="submit" value="Tambah Data" class="btn btn-success"></div>
          </div>
          <?=form_close(); ?>
          
        </div>
      </div>

      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Tahun</th>
            <th>Harga Avtur (USD/Gallon)</th>
            <th style="width:125px;text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($harga_avtur as $row) { ?>
            <tr>
              <td><?=$row['tahun']; ?></td>
              <td><?=$row['harga_avtur']; ?></td>
              <td class="text-center"><a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('makro/hapus_harga_avtur/'.$row['id']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a></td>
             
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
  if ($("#form_harga_avtur").length > 0) {
    $("#form_harga_avtur").validate( {
      rules: {
        tahun: {
          required: true,
          minlength: 2
        },
        harga_avtur: {
          required: true,
        }
      },
      messages: {
        tahun: {
          required: "Tahun wajib diisi",
          minlength: jQuery.validator.format("At least {0} characters required!")
        },
        harga_avtur: {
          required: "GDP Indonesia wajib diisi",
        }
      },
      submitHandler: function(form) {
        $.ajax({
          url: SITEURL + "makro/tambah_harga_avtur",
          data: $('#form_harga_avtur').serialize(),
          type:"post",
          dataType: 'json',
          success: function(res){
             var harga_avtur = '<tr id="id_' + res.data.id + '"><td>' + res.data.tahun + '</td><td>' + res.data.harga_avtur + '</td><td class="text-center"><a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="' + SITEURL + '/makro/hapus_harga_avtur/' + res.data.id + '" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a></td>';


              $('#table').prepend(harga_avtur);          
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

  $("#makro").addClass('active');
  $("#makro .harga_avtur").addClass('active');
</script>