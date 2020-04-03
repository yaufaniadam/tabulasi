<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> &nbsp; Nilai Manfaat Hasil Penempatan di BPS BPIH

		<a href="<?= base_url('keuanganhaji/nilaimanfaat/tambah_nilai_manfaat_penempatan_di_bpsbpih'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp; Tambah Data</a>
		<a href="<?= base_url('keuanganhaji/nilaimanfaat/export_nilai_manfaat_penempatan_di_bpsbpih/' . $thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp; Export Data ke Excel</a>
	</h1>

</section>
<section class="content">

	<div class="row">
		<div class="col-md-12">

			<div class="btn-group" role="group" style="margin-bottom: 20px;">

				<a href="<?= base_url('keuanganhaji/nilaimanfaat/produk'); ?>" class="btn btn-md btn-default">Dana Haji
					yang
					Ditempatkan</a>
				<a href="" class="btn btn-md btn-success disabled">Penempatan Dana Kelolaan di BPS BPIH</a>
			</div> <br>

			<?php breadcrumb('keuanganhaji', $tahun, $thn); ?>

			<div class="box-body smy-form-body box-keuangan">
				

				<table class="keuangan table table-striped table-bordered" style="width:2200px;min-width: 100%;">
					<thead>
						<tr class="text-center">
							<th>BPS BPIH</th>
							<th>Januari							
							
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/januari/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
							
							</th>
							<th>Februari
						
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/februari/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
							
							</th>
							<th>Maret
							
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/maret/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
								
							</th>
							<th>April
						
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/april/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
								
							</th>
							<th>Mei
							
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/mei/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
							
							</th>
							<th>Juni
							
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/juni/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
							
							</th>
							<th>Juli
							
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/juli/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
							
							</th>
							<th>Agustus
							
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/agustus/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
								
							</th>
							<th>September
							
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/september/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
								
							</th>
							<th>Oktober
							
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/oktober/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
								
							</th>
							<th>November
							
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/november/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
								
							</th>
							<th>Desember
						
								<a class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_nilai_manfaat_penempatan_di_bpsbpih/desember/' . $thn) ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
								
							</th>
						</tr>
					</thead>
					<?php foreach ($nilai_manfaat_penempatan_di_bpsbpih as $row) {

						if ($row['bps_bpih'] == "TOTAL") { ?>
							<tfoot>
								<tr class="total">
									<td><?= $row['bps_bpih']; ?></td>
									<td style="text-align: right;"><?= $row['januari']; ?></td>
									<td style="text-align: right;"><?= $row['februari']; ?></td>
									<td style="text-align: right;"><?= $row['maret']; ?></td>
									<td style="text-align: right;"><?= $row['april']; ?></td>
									<td style="text-align: right;"><?= $row['mei']; ?></td>
									<td style="text-align: right;"><?= $row['juni']; ?></td>
									<td style="text-align: right;"><?= $row['juli']; ?></td>
									<td style="text-align: right;"><?= $row['agustus']; ?></td>
									<td style="text-align: right;"><?= $row['september']; ?></td>
									<td style="text-align: right;"><?= $row['oktober']; ?></td>
									<td style="text-align: right;"><?= $row['november']; ?></td>
									<td style="text-align: right;"><?= $row['desember']; ?></td>
								</tr>
							</tfoot>
						<?php } else { ?>
							<tr>
								<td><?= $row['bps_bpih']; ?></td>
								<td style="text-align: right;"><?= $row['januari']; ?></td>
								<td style="text-align: right;"><?= $row['februari']; ?></td>
								<td style="text-align: right;"><?= $row['maret']; ?></td>
								<td style="text-align: right;"><?= $row['april']; ?></td>
								<td style="text-align: right;"><?= $row['mei']; ?></td>
								<td style="text-align: right;"><?= $row['juni']; ?></td>
								<td style="text-align: right;"><?= $row['juli']; ?></td>
								<td style="text-align: right;"><?= $row['agustus']; ?></td>
								<td style="text-align: right;"><?= $row['september']; ?></td>
								<td style="text-align: right;"><?= $row['oktober']; ?></td>
								<td style="text-align: right;"><?= $row['november']; ?></td>
								<td style="text-align: right;"><?= $row['desember']; ?></td>
							</tr>
					<?php } // endif

					} //endforeach get bps bpih 
					?>

				</table>

			</div>
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
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});
</script>

<script>
	$("#nilai_manfaat").addClass('active');
	$("#nilai_manfaat .produk").addClass('active');
</script>