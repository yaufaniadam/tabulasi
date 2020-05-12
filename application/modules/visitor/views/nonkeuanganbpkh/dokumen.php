<?php //get las URI
$last = $this->uri->total_segments();
$record_num = $this->uri->segment($last);
?>
<section class="content-header">
	<h1><i class="fa fa-file-pdf"></i> &nbsp; Dokumen</h1>
</section>

<section class="content">



	<div class="btn-group" role="group" style="margin-bottom: 20px;">
		<!--<a href="<?= base_url('visitor/' . $this->router->fetch_class() . '/dokumen'); ?>" class="btn btn-md <?= ($record_num == 'dokumen') ? "btn-success disabled" : "btn-default" ?>">Semua</a>-->
		<a href="<?= base_url('visitor/' . $this->router->fetch_class() . '/dokumen/regulasi'); ?>" class="btn btn-md <?= ($record_num == 'regulasi') ? "btn-success disabled" : "btn-default" ?>">Regulasi</a>
		<a href="<?= base_url('visitor/' . $this->router->fetch_class() . '/dokumen/sdm'); ?>" class="btn btn-md <?= ($record_num == 'sdm') ? "btn-success disabled" : "btn-default" ?>">SDM</a>
		<a href="<?= base_url('visitor/' . $this->router->fetch_class() . '/dokumen/aset_nontunai'); ?>" class="btn btn-md <?= ($record_num == 'aset_nontunai') ? "btn-success disabled" : "btn-default" ?>">Aset Non
			Tunai</a>
		<a href="<?= base_url('visitor/' . $this->router->fetch_class() . '/dokumen/survey'); ?>" class="btn btn-md <?= ($record_num == 'survey') ? "btn-success disabled" : "btn-default" ?>">Survey</a>
		<a href="<?= base_url('visitor/' . $this->router->fetch_class() . '/dokumen/kajian'); ?>" class="btn btn-md <?= ($record_num == 'kajian') ? "btn-success disabled" : "btn-default" ?>">Kajian</a>
		<a href="<?= base_url('visitor/' . $this->router->fetch_class() . '/dokumen/laporan_kinerja'); ?>" class="btn btn-md <?= ($record_num == 'laporan_kinerja') ? "btn-success disabled" : "btn-default" ?>">Laporan
			Kinerja</a>
		<a href="<?= base_url('visitor/' . $this->router->fetch_class() . '/dokumen/materi_video_dan_paparan'); ?>" class="btn btn-md <?= ($record_num == 'materi_video_dan_paparan') ? "btn-success disabled" : "btn-default" ?>">Materi
			Video dan Paparan</a>
	</div>


	<div class="box">
		<div class="box-header">
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive">
			<table id="example1" class="table table-bordered table-striped ">
				<thead>
					<tr>
						<th style="width:50%">Judul Dokumen</th>

						<?php if ($record_num == 'materi_video_dan_paparan') { ?>
							<th style="width:30%">Video Player</th>
						<?php } ?>
						<th>Tanggal</th>
						<th>Aksi</th>

					</tr>
				</thead>
				<tbody>
					<?php foreach ($dokumen as $row) : ?>
						<tr>
							<td>
								<?php echo $row['nama_dokumen']; ?>
							</td>
							<?php if ($record_num == 'materi_video_dan_paparan') {

								if (strpos($row['url_video'], '=') !== false) {
									$exp = explode('=', $row['url_video']);
									$video_url = $exp[1]; ?>
									<td>							
										<div class="embed-responsive embed-responsive-16by9">
											<iframe width="400" heigt="" class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_url; ?>" allowfullscreen></iframe>
										</div>						
									</td>
								<?php } else { ?>
									<td>							
									<i class="fa fa-exclamation-triangle"></i> Video tidak dapat diputar. URL Video tidak didukung.						
									</td>
								<?php }
							} ?>
							
							<td><?= $row['date']; ?></td>
							<td class="text-center">
								<?php if ($record_num !== 'materi_video_dan_paparan') { ?>
									<a style="color:#fff;" title="Download" class="delete btn btn-xs btn-success" href="<?= base_url($row['file']); ?>"> <i class="fa fa-download"></i></a>
								<?php } ?>
							
							</td>
						</tr>
					<?php endforeach; ?>
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a class="btn btn-danger btn-ok">Hapus</a>
			</div>
		</div>
	</div>
</div>

<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
	$(function() {
		$("#example1").DataTable();
	});

	$('#confirm-delete').on('show.bs.modal', function(e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});

	$("#dokumen").addClass('active');
	$("#dokumen .<?= $record_num; ?>").addClass('active');
</script>