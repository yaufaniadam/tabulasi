<section class="content-header">
  <h1><i class="fa fa-file-pdf"></i> &nbsp; Tambah Dokumen</h1>        
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body my-form-body">
          <?php if(isset($msg) || validation_errors() !== ''): ?>
              <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                  <?= validation_errors();?>
                  <?= isset($msg)? $msg: ''; ?>
              </div>
            <?php endif; ?>
           
 
            <?php echo form_open(base_url('nonkeuanganbpkh/tambah_dokumen_video'), 'class="form-horizontal"');  ?> 
              <div class="form-group">
                <label class="col-sm-3">Nama Dokumen</label>
                <div class="col-sm-9">
                  <input type="text" name="nama_dokumen" class="form-control" id="nama_dokumen" placeholder="Nama Dokumen">
                </div>
              </div>              
                            
             

              <div class="form-group">
               <label class="col-sm-3">URL Video</label>
                <div class="col-sm-9">
                  <span class="help-block">Paste URL Video Youtube di sini </span>
                  <input type="url" name="url_video" class="form-control" id="url_video" placeholder="Contoh: http://youtube.com/watch=24512">
                </div>
              </div>     
          
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Simpan" class="btn btn-info pull-right">
                </div>
              </div>


            <?php echo form_close( ); ?>

         
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>  
</section> 


<script>
    $("#dokumen").addClass('active');
</script>



  