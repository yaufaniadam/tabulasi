<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Laporan Realisasi Anggaran</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php breadcrumb('visitor', $tahun, $thn); ?>
			<?php if ($realisasi_anggaran) { ?>

			<div class="box">

				<div class="box-body my-form-body">
				<table id="table1" class="table table-striped table-bordered">


				<tr>
					<th style="width:50%;">Bulan</th>
					<th class="text-center">Aksi</th>
				</tr>
				<?php foreach ($realisasi_anggaran as $row) { ?>
				<tr>
					<td><?= konversiBulanAngkaKeNama($row['bulan']); ?></td>
					<td class="text-center">

						<a style="color:#fff;" title="Lihat Detail" class="btn btn-xs btn-info"
							href="<?= base_url('visitor/' . $this->router->fetch_class() . '/detail_realisasi_anggaran/' . $row['bulan'] .'/' .$row['tahun']); ?>">
							<i class="fa fa-eye"></i></a>
							<a href="<?= base_url('visitor/laporankeuangan/export_realisasi_anggaran/'. $row['bulan'] .'/' . $thn); ?>" class="btn btn-success btn-xs"><i
				class="fas fa-file-excel"></i>&nbsp; Export Data ke Excel</a>
					</td>
				</tr>
				<?php } ?>
			</table>

				</div>
			</div>

			
			<?php } else {
				echo '<p class="alert alert-success"> Pilih tahun</p>';
			} ?>
		</div>
	</div>
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

<script type="text/javascript">
	$('#confirm-delete').on('show.bs.modal', function (e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});

</script>

<script>
	$("#realisasi_anggaran").addClass('active');

</script>
