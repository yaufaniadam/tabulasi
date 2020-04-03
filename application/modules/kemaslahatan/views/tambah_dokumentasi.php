<?php //get las URI
    $last = $this->uri->total_segments();
	$id = $this->uri->segment($last);	 
?>
<section class="content-header">
	<h1><i class="fa fa-file-pdf"></i> &nbsp; Tambah Dokumentasi</h1>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body smy-form-body">
					<?php if(isset($msg) || validation_errors() !== ''): ?>
					<div class="alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-warning"></i> Alert!</h4>
						<?= validation_errors();?>
						<?= isset($msg)? $msg: ''; ?>
					</div>
					<?php endif; ?>

					<?php echo form_open_multipart(base_url('kemaslahatan/tambah_dokumentasi/'. $id), 'class="form-horizontal"');  ?>
					<div class="form-group">
						<label class="col-sm-3">Judul Foto</label>
						<div class="col-sm-9">
							<input type="text" name="judul_foto" class="form-control" id="judul_foto"
								placeholder="Judul Foto">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3">File Dokumen</label>
						<div class="col-sm-9">
							<span class="help-block">Jenis file yang didukung : jpg, jpeg </span>
							<input type="file" name="file_foto" class="form-control" id="file_foto">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12">
							<input type="submit" name="submit" value="Tambah Dokumentasi"
								class="btn btn-info pull-right">
						</div>
					</div>
					<?php echo form_close( ); ?>
				</div>
				<!-- /.box-body -->


			</div>
			<div class="box">
				<div class="box-header with-border">
                    <h4>Dokumentasi Kegiatan Kemaslahatan pada  <?php echo $nama_penerima['nama_penerima']; ?></h4>
				</div>
				<div class="box-body smy-form-body">
                    <div class="row">
                    <?php if($dokumentasi) { ?>
                        <?php foreach($dokumentasi as $dok) { ?>  
                            <div class="col-md-4">
                            <img src="<?=base_url($dok['foto']);?>" alt="<?=$dok['judul_foto']; ?>" class="img-thumbnail">
                            </div>
                        <?php }?>
                    <?php } else {  echo "Belum ada dokumentasi.";  }?>
                    </div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$("#kemaslahatan").addClass('active');

</script>
