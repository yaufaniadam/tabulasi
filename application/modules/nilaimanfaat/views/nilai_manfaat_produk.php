<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Produk Penempatan
		<a href="<?=base_url('nilaimanfaat/tambah_nilai_manfaat_produk'); ?>" class="btn btn-warning btn-sm"><i
				class="fas fa-plus"></i>&nbsp; Tambah Data</a>

		<a href="<?=base_url('nilaimanfaat/export_nilai_manfaat_produk/'.$thn); ?>"
			class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp; Export Data ke Excel</a>

	</h1>

</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">

			<div class="btn-group" role="group" style="margin-bottom: 20px;">

				<a href="<?=base_url('nilaimanfaat/produk'); ?>" class="btn disabled btn-md btn-success">Dana Haji yang
					Ditempatkan</a>
				<a href="<?= base_url('nilaimanfaat/penempatan_di_bpsbpih'); ?>"
					class="btn btn-md btn-default">Penempatan Dana Kelolaan di BPS BPIH</a>
			</div> <br>

			<?php breadcrumb('',$tahun, $thn); ?>

			<?php if($nilai_manfaat_produk) { ?>
			<div class="box-body smy-form-body box-keuangan">
				<table id="table1" class="keuangan table table-striped table-bordered">
					<thead>

						<tr class="text-center">
							<th style="width:200px !important;">Bulan</th>
							<th>Giro</th>
							<th>Tabungan</th>
							<th>Deposito</th>
							<th><strong>Jumlah</strong></th>
							<th> &nbsp;</th>
						</tr>

					</thead>
					<tbody>

						<?php foreach($nilai_manfaat_produk as $produk ) { ?>
						<tr>
							<td><?= konversiBulanAngkaKeNama($produk['bulan']);?></td>
							<td style="text-align: right;"><?=$produk['giro'];?></td>
							<td style="text-align: right;"><?=$produk['tabungan'];?></td>
							<td style="text-align: right;"><?=$produk['deposito'];?></td>
							<td style="text-align: right;"><?=$produk['jumlah'];?></td>
							<td style="text-align: center;"> <a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger"
									data-href="<?=base_url('nilaimanfaat/hapus_produk/'.$produk['id']); ?>"
									data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php } else { echo '<p class="alert alert-success"> Pilih tahun</p>';} ?>
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
	$("#nilai_manfaat").addClass('active');
	$("#nilai_manfaat .produk").addClass('active');

</script>
