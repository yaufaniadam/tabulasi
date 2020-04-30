<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Laporan Perubahan Aset Neto

		<a href="<?=base_url('laporankeuangan/tambah_perubahan_asetneto'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp;  Tambah Data</a>

		<a href="<?=base_url('laporankeuangan/export_perubahan_asetneto/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>

	</h1>

</section>


<section class="content"> 	
  	<div class="row no-gutters" style="" >
  		
		  <?php breadcrumb('',$tahun, $thn); ?> 
		  <?php if($perubahan_asetneto) { ?>

  		<div class="well well-sm pre-scrollable" style="overflow-x: scroll; min-height:500px;">
			<table id="table1" class="table table-striped table-bordered" style="width:<?=count($perubahan_asetneto)*200; ?>px;;min-width: 100%;">
				
				<tr>
					<td><strong>BULAN</strong></td>
					<?php foreach($perubahan_asetneto as $row ) { ?>
					<th style="text-align: right"><?=konversiBulanAngkaKeNama($row['bulan']); ?> &nbsp;
						
						<a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('laporankeuangan/hapus_perubahan_asetneto/'.$row['id'].'/'.$thn); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>

					</td>
					<?php } ?>
				</tr>	

  				
  				<tr>
					<td style="font-weight: bold">
						ASET NETO TIDAK TERIKAT
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['aset_neto_tidak_terikat'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Saldo awal
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['saldo_awal1'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
					Surplus/(Defisit) tahun berjalan
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['surplus_defisit_tahun_berjalan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Saldo Akhir
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['saldo_akhir1'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Penghasilan Komprehensif Lain
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['penghasilan_komprehensif_lain'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Saldo awal
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['saldo_awal2'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Penghasilan /(Beban) komprehensif tahun berjalan
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['penghasilan_beban_komprehensif_tahun_berjalan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Koreksi aset neto tidak terikat
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['koreksi_aset_neto_tidak_terikat'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Saldo Akhir
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['saldo_akhir2'];?></td>		
					<?php } ?>	
				</tr>	
				<tr>
					<td style="font-weight: bold">
						Total Aset Neto Tidak Terikat 
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['total_aset_neto_tidak_terikat'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						ASET NETO TERIKAT TEMPORER
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['aset_neto_terikat_temporer'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Saldo awal
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['saldo_awal3'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Surplus tahun berjalan
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['surplus_tahun_berjalan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Saldo Akhir 
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['saldo_akhir3'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						ASET NETO TERIKAT PERMANEN 
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['aset_neto_terikat_permanen'];?></td>		
					<?php } ?>	
				</tr>	
				<tr>
					<td>
						Saldo awal
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['saldo_awal4'];?></td>		
					<?php } ?>	
				</tr>	
				<tr>
					<td>
						Surplus tahun berjalan
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['surplus_tahun_berjalan_permanen'];?></td>		
					<?php } ?>	
				</tr>	
				<tr>
					<td>
						Penggunaan Efisiensi Haji Tahun Sebelumnya
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['penggunaan_efisiensi_haji'];?></td>		
					<?php } ?>	
				</tr>	
				<tr>
					<td style="font-weight: bold">
						Saldo Akhir
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['saldo_akhir4'];?></td>		
					<?php } ?>	
				</tr>	
				<tr class="success">
					<td style="font-weight: bold">
						TOTAL ASET NETO
					</td>	
					<?php foreach($perubahan_asetneto as $row ) { ?>
						<td style="text-align: right;"><?=$row['total_aset_neto'];?></td>		
					<?php } ?>	
				</tr>					
				
			</table>
		</div>
		<?php } else { echo '<p class="alert alert-success"> Pilih tahun</p>';} ?> 
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
    $("#perubahan_asetneto").addClass('active');
</script>





