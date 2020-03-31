<?php //get las URI
    $last = $this->uri->total_segments();
	$record_num = $this->uri->segment($last);	 
?>
<section class="content-header">
  <h1><i class="fa fa-file-pdf"></i> &nbsp; Tambah Dokumen <?php if($record_num == 'kemaslahatan') { echo "Regulasi Kemaslahatan"; } ?></h1>        
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
           
 
            <?php echo form_open_multipart(base_url('nonkeuanganbpkh/tambah_dokumen'), 'class="form-horizontal"');  ?> 
              <div class="form-group">
                <label class="col-sm-3">Nama Dokumen</label>
                <div class="col-sm-9">
                  <input type="text" name="nama_dokumen" class="form-control" id="nama_dokumen" placeholder="Nama Dokumen">
                </div>
              </div>              
              
              <?php if($record_num == 'kemaslahatan') { ?>
               <input  name="jenis_dokumen" type="hidden" value="regulasi_kemaslahatan">
              <?php } else { ?>

                <div class="form-group">               
                <label class="col-sm-3">Jenis Dokumen</label>
                <div class="col-sm-9">
                    <select name="jenis_dokumen" class="form-control">   
                      <option value=""> ------- Pilih Jenis Dokumen -------- </option>
                      <option value="regulasi"> Regulasi </option>    
                      <option value="sdm"> SDM </option>   
                      <option value="aset_nontunai"> Aset Non Tunai </option>   
                      <option value="survey"> Survey </option> 
                      <option value="kajian"> Kajian </option>  
                      <option value="laporan_kinerja"> Laporan Kinerja </option> 
                      <option value="materi_video_dan_paparan"> Materi Video dan Paparan </option> 
                    </select>
                </div>            
           
              </div> 

              <?php } ?>

              <div class="form-group">
               <label class="col-sm-3">File Dokumen</label>
                <div class="col-sm-9">
                  <span class="help-block">Jenis file yang didukung : pdf, ppt, pptx, doc, docx, xls, xlsx </span>
                  <input type="file" name="file_dokumen" class="form-control" id="file_dokumen">
                </div>
              </div>     
          
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Tambah Dokumen" class="btn btn-info pull-right">
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



  