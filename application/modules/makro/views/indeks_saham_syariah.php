<section class="content-header">
  <h1><i class="fa fa-file-pdf"></i> &nbsp; Indeks Saham Syariah Indonesia

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
          <?=form_open(base_url('makro/tambah_indeks_saham_syariah'),array('id'=>'form_indeks_saham_syariah')); ?>
         <!-- <input type="hidden" name="id" id="product_id">-->
          <div class="row">
            <div class="col-md-6"><input type="number" name="tahun" value="" placeholder="Tahun" class="form-control" id="tahun"></div>
            <div class="col-md-4"><input type="number" name="indeks_saham_syariah" value="" placeholder="Indeks Saham Syariah Indonesia" class="form-control" id="indeks_saham_syariah"></div>
            <div class="col-md-2"><input type="submit" name="submit" value="Tambah Data" class="btn btn-success"></div>
          </div>
          <?=form_close(); ?>
          
        </div>
      </div>

      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Tahun</th>
            <th>Indeks Saham Syariah</th>
            <th style="width:125px;text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($indeks_saham_syariah as $row) { ?>
            <tr>
              <td><?=$row['tahun']; ?></td>
              <td><?=$row['indeks_saham_syariah']; ?></td>
              <td class="text-center"><a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('makro/hapus_indeks_saham_syariah/'.$row['id']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a></td>
             
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
  if ($("#form_indeks_saham_syariah").length > 0) {
    $("#form_indeks_saham_syariah").validate( {
      rules: {
        tahun: {
          required: true,
          minlength: 2
        },
        indeks_saham_syariah: {
          required: true,
        }
      },
      messages: {
        tahun: {
          required: "Tahun wajib diisi",
          minlength: jQuery.validator.format("At least {0} characters required!")
        },
        indeks_saham_syariah: {
          required: "GDP Indonesia wajib diisi",
        }
      },
      submitHandler: function(form) {
        $.ajax({
          url: SITEURL + "makro/tambah_indeks_saham_syariah",
          data: $('#form_indeks_saham_syariah').serialize(),
          type:"post",
          dataType: 'json',
          success: function(res){
             var indeks_saham_syariah = '<tr id="id_' + res.data.id + '"><td>' + res.data.tahun + '</td><td>' + res.data.indeks_saham_syariah + '</td><td class="text-center"><a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="' + SITEURL + '/makro/hapus_indeks_saham_syariah/' + res.data.id + '" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a></td>';


              $('#table').prepend(indeks_saham_syariah);          
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
  $("#makro .indeks_saham_syariah").addClass('active');
</script>