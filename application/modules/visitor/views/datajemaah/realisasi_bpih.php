<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Laporan Realisasi BPIH </h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			
			<?php if ($realisasi_bpih) { ?>

			<div class="box">

				<div class="box-body my-form-body">
				<table id="table1" class="table table-striped table-bordered">


				<tr>
					<th style="width:50%;">Tahun</th>
					<th class="text-center">Aksi</th>
				</tr>
				<?php foreach ($realisasi_bpih as $row) { ?>
				<tr>
					<td><?= $row['tahun']; ?></td>
					<td class="text-center">

						<a style="color:#fff;" title="Lihat Detail" class="btn btn-xs btn-info"
							href="<?= base_url('visitor/' . $this->router->fetch_class() . '/detail_realisasi_bpih/' .$row['tahun']); ?>">
							<i class="fa fa-eye"></i></a>
							<a href="<?= base_url('visitor/datajemaah/export_realisasi_bpih/' . $row['tahun']); ?>" class="btn btn-success btn-xs"><i
				class="fas fa-file-excel"></i>&nbsp; Export Data ke Excel</a>
					</td>
				</tr>
				<?php } ?>
			</table>

				</div>
			</div>

			
			<?php } ?>
		</div>
	</div>
</section>

<script>
	$("#datajemaah").addClass('active');
	$("#datajemaah .bpih").addClass('active');
</script>
