<section class="content-header">
	<h1><i class="fa fa-file-pdf"></i> &nbsp; Laporan Industri Keuangan Syariah</h1>
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


					<?php echo form_open_multipart(base_url('makro/tambah_laporan_industri_keuangan_syariah'), 'class="form-horizontal"');  ?>
					<div class="form-group">
						<label class="col-sm-3">Nama Dokumen</label>
						<div class="col-sm-9">
							<input type="text" name="nama_laporan_industri_keuangan_syariah" class="form-control"
								id="nama_laporan_industri_keuangan_syariah" placeholder="Nama Dokumen">
						</div>
					</div>



					<div class="form-group">
						<label class="col-sm-3">File Dokumen</label>
						<div class="col-sm-9">
							<span class="help-block">Jenis file yang didukung : pdf, ppt, pptx, doc, docx, xls, xlsx
							</span>
							<input type="file" name="file_laporan_industri_keuangan_syariah" class="form-control"
								id="file_laporan_industri_keuangan_syariah">
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
	$("#nilai_manfaat").addClass('active');
	$("#nilai_manfaat .produk").addClass('active');

</script>
