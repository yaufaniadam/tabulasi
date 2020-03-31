<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Laporan Operasional Akumulasi 

		<a href="<?=base_url('laporankeuangan/tambah_lap_akumulasi'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp;  Tambah Data</a>

		<a href="<?=base_url('laporankeuangan/export_lap_akumulasi/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>

	</h1>

</section>


<section class="content"> 	
  	<div class="row no-gutters" style="" >
		  <?php breadcrumb('',$tahun, $thn); ?> 
		  
		  <?php if($lap_akumulasi) {
		  ?>
  		<div class="well well-sm pre-scrollable" style="overflow-x: scroll; min-height:500px;">
			<table id="table1" class="table table-striped table-bordered" style="width:<?=count($lap_akumulasi)*200; ?>px;min-width: 100%;">
				
				<tr>
					<td><strong>BULAN</strong></td>
					<?php foreach($lap_akumulasi as $row ) { ?>
					<th style="text-align: right"><?=$row['bulan']; ?> &nbsp;
						
						<a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('laporankeuangan/hapus_lap_akumulasi/'.$row['id']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>

					</td>
					<?php } ?>
				</tr>	

  				
  				<tr>
					<td>
						Pendapatan setoran jemaah berangkat 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['pendapatan_setoran_jemaah_berangkat'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Beban transfer BPIH ke Kementerian Agama 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['beban_transfer_bpih_ke_kemenag'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Surplus/(Defisit) Biaya Penyelenggaraan Ibadah Haji (BPIH) 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['surplus_defisit_bpih'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Pendapatan nilai manfaat 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['pendapatan_nilai_manfaat'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						- Nilai Manfaat Penempatan - bersih 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['nilai_manfaat_penempatan_bersih'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						- Nilai Manfaat Investasi - bersih 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['nilai_manfaat_investasi_bersih'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Beban operasional BPKH 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['beban_operasional_bpkh'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Surplus/(Defisit) Operasional BPKH 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['surplus_defisit_operasional_bpkh'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Penyaluran untuk rekening virtual 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['penyaluran_untuk_rekening_virtual'];?></td>		
					<?php } ?>	
				</tr>	
				<tr>
					<td>
						Penyaluran program kemaslahatan 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['penyaluran_program_kemaslahatan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Surplus/(Defisit) BPKH 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['surplus_defisit_bpkh'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Penggunaan nilai manfaat akumulasi tahun sebelumnya 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['nilai_manfaat_akumulasi_sebelumnya'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Total Surplus/(Defisit) 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['total_surplus_defisit'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Penghasilan/(Beban) komprehensif lain 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['penghasilan_beban_komprehensif_lain'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Total Surplus Komprehensif 
					</td>	
					<?php foreach($lap_akumulasi as $row ) { ?>
						<td style="text-align: right;"><?=$row['total_surplus_komprehensif'];?></td>		
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
    $("#operasional").addClass('active');
     $("#operasional .lap_akumulasi").addClass('active');
</script>





