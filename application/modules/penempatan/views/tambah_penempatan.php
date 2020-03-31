<?php
$kat = $this->uri->segment('3');
$slug = $this->uri->segment('4');

?>

<section class="content-header">
  <h1>Tambah Penempatan</h1>
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

           
            <?php if(!empty($error)):
              echo '<span class="alert alert-danger" style="display: block;">';
               foreach ($error as $item => $value):?>
                  <?php echo $item;?>: <?php echo $value;?>
            <?php endforeach; echo '</span>'; endif; ?>
      
            <?php echo form_open(base_url('penempatan/tambah/'.$kat.'/'.$slug), 'class="form-horizontal"');  ?> 

            <div class="form-group <?=form_error('keterangan')?"has-error":"" ?>">

               <div class="form-group">
                <label for="kategori" class="col-sm-2 control-label">Kategori</label>
                <div class="col-sm-9">
                  <select name="kategori" class="form-control">
                    <option value="">Pilih Kategori <?php !form_error('kategori')? $val = set_value('kategori'): $val='' ; ?></option>
                    <option value="kh" <?php if($kat == 'kh' ) { echo "selected=true"; }; ?>>Keuangan Haji</option>
                    <option value="kk" <?php if($kat == 'kk' ) { echo "selected=true"; }; ?>>Kegiatan Kemaslahatan</option>
                  </select>
                </div>
              </div>   
             
              <div class="form-group">
                <label for="jenis_investasi" class="col-sm-2 control-label">Jenis Penempatan</label>
                <div class="col-sm-9">
                  <select name="jenis_penempatan" class="form-control">
                    <option value="">Pilih Jenis Penempatan <?php  !form_error('jenis_penempatan')? $val = set_value('jenis_penempatan'): $val='' ; ?></option>
                    <?php foreach($all_jenis_penempatan as $row): ?>
                      <option value="<?= $row['id']; ?>" <?php if($row['id'] == get_jenis_penempatan_by_slug($slug) ) { echo "selected=true"; }; ?> > <?= $row['jenis_penempatan']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>      

              <div class="form-group">
                <label for="lembaga" class="col-sm-2 control-label">Lembaga</label>
                <div class="col-sm-9">
                  <select name="lembaga" class="form-control">
                    <option value="">Pilih Lembaga <?php !form_error('lembaga')? $val = set_value('lembaga'): $val='' ; ?></option>
                    <?php foreach($all_lembaga as $row): ?>
                      <option value="<?= $row['id']; ?>" <?php if($val == $row['id'] ) { echo "selected=true"; }; ?> > <?= $row['nama_lembaga']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>                 

              <div class="form-group">
               <label for="no_seri" class="col-sm-2 control-label">Nomor Seri </label>
                <div class="col-sm-9">
                  <input type="text" name="no_seri" class="form-control" id="no_seri" placeholder="" value="<?=!form_error('no_seri')?set_value('no_seri'):''?>" />
                  <span class="help-block"><?php echo form_error('no_seri'); ?></span>
                </div>
              </div>

               <div class="form-group">
               <label for="no_transaksi" class="col-sm-2 control-label">Nomor Transaksi</label>
                <div class="col-sm-9">
                  <input type="text" name="no_transaksi" class="form-control" id="no_transaksi" placeholder="" value="<?=!form_error('no_transaksi')?set_value('no_transaksi'):''?>" />
                  <span class="help-block"><?php echo form_error('no_transaksi'); ?></span>
                </div>
              </div>

              <div class="form-group">
               <label for="estimasi_return" class="col-sm-2 control-label">Estimasi Return/Bagi Hasil (%) </label>
                <div class="col-sm-9">
                  <input type="number" name="estimasi_return" class="form-control" id="estimasi_return" placeholder="" value="<?=!form_error('estimasi_return')?set_value('estimasi_return'):''?>" />
                  <span class="help-block"><?php echo form_error('estimasi_return'); ?></span>
                </div>
              </div>    

              <div class="form-group">
               <label for="pokok_penempatan" class="col-sm-2 control-label">Pokok Penempatan (Rp)</label>
                <div class="col-sm-9">
                  <input type="number" name="pokok_penempatan" class="form-control" id="pokok_penempatan" placeholder="" value="<?=!form_error('pokok_penempatan')?set_value('pokok_penempatan'):''?>" />
                  <span class="help-block"><?php echo form_error('pokok_penempatan'); ?></span>
                </div>
              </div>    

              <div class="form-group">
               <label for="tgl_transaksi" class="col-sm-2 control-label">Tanggal Transaksi</label>
                <div class="col-sm-9">
                  <input type="date" name="tgl_transaksi" class="form-control" id="tgl_transaksi" placeholder="" value="<?=!form_error('tgl_transaksi')?set_value('tgl_transaksi'):''?>" />
                  <span class="help-block"><?php echo form_error('tgl_transaksi'); ?></span>
                </div>
              </div>   

              <div class="form-group">
               <label for="tgl_jatuh_tempo" class="col-sm-2 control-label">Tanggal Jatuh Tempo</label>
                <div class="col-sm-9">
                  <input type="date" name="tgl_jatuh_tempo" class="form-control" id="tgl_jatuh_tempo" placeholder="" value="<?=!form_error('tgl_jatuh_tempo')?set_value('tgl_jatuh_tempo'):''?>" />
                  <span class="help-block"><?php echo form_error('tgl_jatuh_tempo'); ?></span>
                </div>
              </div>               

              <div class="form-group">
                <div class="col-md-11">
                  <input type="submit" name="submit" value="Tambah Penempatan" class="btn btn-info pull-right">
                </div>
              </div>

            <?php echo form_close(); ?>

            <?php if(!empty($upload_data)):
              echo '<br><h3>Uploaded File Detail: </h3>';
               foreach ($upload_data as $item => $value):?>
                <li><?php echo $item;?>: <?php echo $value;?></li>
            <?php endforeach; endif; ?>
       

          </div>
          <!-- /.box-body -->
      </div>
    </div>
  </div>  
</section> 


 <script>
    $("#borang").addClass('active');
  </script>



<script type="text/javascript">
  $('#file-borang').change(function() {
    var filepath = this.value;
    var m = filepath.match(/([^\/\\]+)$/);
    var filename = m[1];
    $('#filename').html(filename);

});
</script>