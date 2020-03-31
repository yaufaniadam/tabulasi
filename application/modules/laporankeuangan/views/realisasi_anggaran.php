<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Laporan Realisasi Anggaran Tahun 
		<a href="<?=base_url('bpih/tambah_realisasi_anggaran'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp;  Tambah Data</a>

		<a href="<?=base_url('bpih/export_realisasi_anggaran/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>

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
  	<div class="row" >
  		<div class="col-md-12">
		  <?php breadcrumb('',$tahun, $thn); ?> 
		  <?php if($realisasi_anggaran) { ?>
  		<div class="well well-sm pre-scrollable" style="overflow-x: scroll; min-height:500px;">
			<table id="table1" class="table table-striped table-bordered" style="width:<?=count($realisasi_anggaran)*200; ?>px;;min-width: 100%;">
				
				<tr>
					<th><strong>BULAN</strong></th>
					<?php foreach($realisasi_anggaran as $row ) { ?>
					<th style="text-align: right"><?=$row['bulan']; ?> &nbsp;
						
						<a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('laporankeuangan/hapus_realisasi_anggaran/'.$row['id']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>

					</th>
					<?php } ?>
				</tr>	

  				
  				<tr>
					<td style="font-weight: bold">
						PENERIMAAN

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['penerimaan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						Nilai Manfaat

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['nilai_manfaat'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
					Nilai manfaat - penempatan dana BPIH

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['nilai_manfaat_penempatan_dana_bpih'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Nilai manfaat - investasi dana BPIH

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['nilai_manfaat_investasi_dana_bpih'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Nilai manfaat - investasi DAU

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['nilai_manfaat_investasi_dau'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td  style="font-weight: bold">
						TOTAL PENERIMAAN

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['total_penerimaan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td  style="font-weight: bold">
						BELANJA BPIH DAN KEMASLAHATAN

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['belanja_bpih_dan_kemaslahatan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Belanja PIH - Indirect cost

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['belanja_pih_indirect_cost'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Penyaluran ke rekening virtual jemaah haji

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['penyaluran_ke_rekening_virtual_jemaah_haji'];?></td>		
					<?php } ?>	
				</tr>	
				<tr>
					<td>
						Penyaluran Program Kemaslahatan

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['penyaluran_program_kemaslahatan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						TOTAL BELANJA BPIH DAN KEMASLAHATAN

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['total_belanja_bpih_dan_kemaslahatan'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td style="font-weight: bold">
						BELANJA OPERASIONAL BPKH

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['belanja_operasional_bpkh'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Belanja Pegawai

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['belanja_pegawai'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
						Belanja Operasional Kantor

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['belanja_operasional_kantor'];?></td>		
					<?php } ?>	
				</tr>
				<tr class="success">
					<td style="font-weight: bold">
						TOTAL BELANJA PERASIONAL BPKH

					</td>	
					<?php foreach($realisasi_anggaran as $row ) { ?>
						<td style="text-align: right;"><?=$row['total_belanja_operasional_bpkh'];?></td>		
					<?php } ?>	
				</tr>	
									
				
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
    $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>

<script>
    $("#realisasi_anggaran").addClass('active');
</script>





