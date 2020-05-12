<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Laporan Operasional Bulanan</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php breadcrumb('visitor', $tahun, $thn); ?>
			<?php if ($lap_bulanan) { ?>

			<div class="box">

				<div class="box-body my-form-body">
				<table id="table1" class="table table-striped table-bordered">


				<tr>
					<th style="width:60%;">Bulan</th>
					<th class="text-center">Aksi</th>
				</tr>
				<?php foreach ($lap_bulanan as $row) { ?>
				<tr>
					<td><?=konversiBulanAngkaKeNama($row['bulan']); ?></td>
					<td class="text-center">

						<a style="color:#fff;" title="Lihat Detail" class="btn btn-xs btn-info"
							href="<?= base_url('visitor/' . $this->router->fetch_class() . '/detail_lap_bulanan/' . $row['bulan'] .'/' .$row['tahun']); ?>">
							<i class="fa fa-eye"></i></a>

					
							<a href="<?= base_url('visitor/laporankeuangan/export_lap_bulanan/'. $row['bulan'] .'/' . $thn); ?>" class="btn btn-success btn-xs"><i
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



<script>
	$("#operasional").addClass('active');
	$("#operasional .lap_bulanan").addClass('active');
</script>
