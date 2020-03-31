<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Laporan Pencapaian Output Perbidang <a href="<?=base_url('bpih/tambah_pencapaian_perbidang'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp;  Tambah Data</a>

		<a href="<?=base_url('bpih/export_pencapaian_perbidang/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>

	</h1>
	
</section>

<style type="text/css">
	table.sticky th:first-child, td:first-child {
	 	position:sticky;
	  	left:0px;
	  	width:350px !important;
	  	z-index: 1000;
	}
	
</style>

<section class="content"> 	
  	<div class="row">
  		<div class="col-md-12">
  		<?php breadcrumb('', $tahun, $thn); ?> 
  		<div class="well well-sm pre-scrollable" style="overflow-x: scroll; min-height:500px;">
			<table id="table1" class="table table-striped table-bordered" style="width:<?=count($pencapaian_perbidang)*200; ?>px;;min-width: 100%;">
				
				<tr>
					<td><strong>BULAN</strong></td>
					<?php foreach($pencapaian_perbidang as $row ) { ?>
					<td style="text-align: right"><?=$row['bulan']; ?> &nbsp;
						
						<a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('bpih/hapus_pencapaian_perbidang/'.$row['id']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>

					</td>
					<?php } ?>
				</tr>	

  				
  				<tr>
					<td>
						Pengembangan dan Kemaslahatan
					</td>	
					<?php foreach($pencapaian_perbidang as $row ) { ?>
						<td style="text-align: right;"><?=$row['pengembangan_dan_kemaslahatan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Keuangan
					</td>	
					<?php foreach($pencapaian_perbidang as $row ) { ?>
						<td style="text-align: right;"><?=$row['keuangan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Investasi
					</td>	
					<?php foreach($pencapaian_perbidang as $row ) { ?>
						<td style="text-align: right;"><?=$row['investasi'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Operasional
					</td>	
					<?php foreach($pencapaian_perbidang as $row ) { ?>
						<td style="text-align: right;"><?=$row['operasional'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Perencanaan dan Manajemen Risiko
					</td>	
					<?php foreach($pencapaian_perbidang as $row ) { ?>
						<td style="text-align: right;"><?=$row['perencanaan_dan_manajemen_risiko'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						SDM dan Pengadaan
					</td>	
					<?php foreach($pencapaian_perbidang as $row ) { ?>
						<td style="text-align: right;"><?=$row['sdm_dan_pengadaan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Hukum dan Kepatuhan
					</td>	
					<?php foreach($pencapaian_perbidang as $row ) { ?>
						<td style="text-align: right;"><?=$row['hukum_dan_kepatuhan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Audit Internal
					</td>	
					<?php foreach($pencapaian_perbidang as $row ) { ?>
						<td style="text-align: right;"><?=$row['audit_internal'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Sekban
					</td>	
					<?php foreach($pencapaian_perbidang as $row ) { ?>
						<td style="text-align: right;"><?=$row['sekban'];?></td>		
					<?php } ?>	
				</tr>	
				<tr>
					<td>
						Sekdewas
					</td>	
					<?php foreach($pencapaian_perbidang as $row ) { ?>
						<td style="text-align: right;"><?=$row['sekdewas'];?></td>		
					<?php } ?>	
				</tr>							
				
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
    $("#pencapaian_perbidang").addClass('active');
</script>





