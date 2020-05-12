<?php //get las URI
    $last = $this->uri->total_segments();
	$tahun = $this->uri->segment($last);	 
	$bulan = $this->uri->segment($last-1);	 
  ?>
<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Detail Sukuk Korporasi <a
			href="<?= base_url('visitor/keuanganhaji/sukuk_korporasi/'.$tahun); ?>" class="btn btn-warning btn-sm"><i
				class="fas fa-chevron-left"></i>&nbsp; Kembali</a>
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">

		<?php menu_sukuk(); ?> <br>

			<div class="box">
				<div class="box-body my-form-body">
					<?php if ($sukuk_korporasi) { ?>

					<h4>Data <?=konversiBulanAngkaKeNama($bulan); ?> <?=$tahun?></h4>
					
					<table id="table1" class="table table-striped table-bordered">
						<tr>
							<th>No.</th>
							<th>Instrumen</th>
							<th class="text-center">Maturity</th>
							<th class="text-center">Counterpart</th>
							<th class="text-center">Nominal (US Dollar)</th>
						</tr>
						<?php $i=1; foreach ($sukuk_korporasi as $row) { 
                        if( $row['instrumen']== "TOTAL") { ?>
						<tr class="success">
							<th colspan="4"><?= $row['instrumen']; ?></th>
							
							<th style="text-align: right;"><?= $row['nilai']; ?></th>
						</tr>
                        <?php } else { ?>
                        <tr>
							<td><?=$i; ?></td>
							<td><?= $row['instrumen']; ?></td>
							<td style="text-align: center;"><?= $row['maturity']; ?></td>
							<td style="text-align: center;"><?= $row['counterpart']; ?></td>
							<td style="text-align: right;"><?= $row['nilai']; ?></td>
						</tr>
                       <?php } $i++;
                     } ?>
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
	$("#alokasi_produk_investasi").addClass('active');
	$("#alokasi_produk_investasi .sukuk").addClass('active');
</script>
