<?php //get las URI
    $last = $this->uri->total_segments();
	$record_num = $this->uri->segment($last);	 
  ?>
<section class="content-header">
	<h1><i class="fa fa-file-pdf"></i> &nbsp; Regulasi Kemaslahatan 
		<a
			href="<?=base_url('nonkeuanganbpkh/tambah_dokumen/kemaslahatan' ); ?>" class="btn btn-warning btn-sm"><i
				class="fas fa-plus"></i>&nbsp; Tambah Dokumen</a></h1>
</section>

<section class="content">

	

	


	<div class="box">
		<div class="box-header">
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive">
			<table id="example1" class="table table-bordered table-striped ">
				<thead>
					<tr>
						<th style="width:80%">Judul Dokumen</th>
						
						
						
						<th>Tanggal</th>
						<th>Aksi</th>

					</tr>
				</thead>
				<tbody>
					<?php foreach($dokumen as $row): ?>
					<tr>
						<td>					
							<?php echo $row['nama_dokumen']; ?>					
						</td>
						
						
						<td><?= $row['date']; ?></td>
						<td class="text-center">
							<?php if($record_num !== 'materi_video_dan_paparan') { ?>
							<a style="color:#fff;" title="Download" class="delete btn btn-xs btn-success"
								href="<?=base_url($row['file']); ?>"> <i class="fa fa-download"></i></a>
							<?php } ?>
							<a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger"
								data-href="<?=base_url('nonkeuanganbpkh/hapus_dokumen/'.$row['id'].'/kemaslahatan'); ?>"
								data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
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
	$(function () {
		$("#example1").DataTable();
	});

	$('#confirm-delete').on('show.bs.modal', function (e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});

	$("#regulasi_kemaslahatan").addClass('active');

</script>
