<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Laporan Arus Kas

		<a href="<?=base_url('laporankeuangan/tambah_lap_arus_kas'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp; Tambah Data</a>

		<a href="<?=base_url('laporankeuangan/export_lap_arus_kas/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>

	</h1>
	
</section>



<section class="content"> 	
  	<div class="row no-gutters" style="" >
		  <?php breadcrumb('',$tahun, $thn); ?> 
		  <?php if($lap_arus_kas) {
		  ?>
  		<div class="well well-sm pre-scrollable" style="overflow-x: scroll; min-height:500px;">
			<table id="table1" class="table table-striped table-bordered" style="width:<?=count($lap_arus_kas)*200; ?>px;;min-width: 100%;">
				
				<tr>
					<td><strong>BULAN</strong></td>
					<?php foreach($lap_arus_kas as $row ) { ?>
					<th style="text-align: right"><?=konversiBulanAngkaKeNama($row['bulan']);?> &nbsp;
						
						<a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('laporankeuangan/hapus_lap_arus_kas/'.$row['id']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>

					</td>
					<?php } ?>
				</tr>	
  				
  				<tr>
					<td style="font-weight: bold">
                    Arus Kas dari Aktivitas Operasi
					</td>				
					<td style="text-align: right;"></td>						
				</tr>
  				<tr>
					<td>
					Penerimaan nilai manfaat
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['penerima_nilai_manfaat'];?></td>	
					<?php } ?>	
				</tr>
				<tr>
					<td>
					Penerimaan operasional efisiensi haji 
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['penerimaan_operasional_efisiensi'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
					Penerimaan dana jemaah tidak berangkat 
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['penerimaan_jamaah_tdk_brkt'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
					Penerimaaan lain-lain
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['penerimaan_lain'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
                    Pengeluaran transfer penyelenggaraan ibadah haji dari nilai manfaat
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['pengeluaran_transfer_pih_dari_manfaat'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
                    Pengeluaran beban pajak nilai manfaat
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['pengeluaran_pajak_manfaat'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
					Pengeluaran operasional BPKH
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['operasional_bpkh'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
					Pengeluaran kegiatan untuk kemaslahatan umat Islam
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['pengeluaran_kemaslahatan_umat'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
					Kas Bersih yang diperoleh dari Aktivitas Operasi
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['kas_bersih_aktivasi_operasi'];?></td>		
					<?php } ?>	
				</tr>	
				<tr>
					<td style="font-weight: bold">
                    Arus Kas dari Aktivitas Investasi
					</td>						
				</tr>								
				<tr>
					<td>
                    Pembelian aset tetap 
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['pembelian_aset_tetap'];?></td>		
					<?php } ?>	
				</tr>				
				<tr>
					<td>
                    Pembelian aset tak berwujud 
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['pembelian_aset_takwujud'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
                    Penempatan (net)
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['penempatan_net'];?></td>		
					<?php } ?>	
				</tr>
				<tr>
					<td>
					Investasi (net)
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['investasi_net'];?></td>		
					<?php } ?>	
				</tr>					
				<tr>
					<td style="font-weight: bold">
					Kas Bersih yang diperoleh dari Aktivitas Investasi
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['kas_bersih_aktivasi_investasi'];?></td>		
					<?php } ?>	
				</tr>					
				<tr>
					<td style="font-weight: bold">
                    Arus Kas Dari Aktivitas Pendanaan
					</td>						
                </tr>
                <tr>
					<td>
                    Penerimaan setoran jemaah
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['penerimaan_setoran_jamaah'];?></td>		
					<?php } ?>	
                </tr>
                <tr>
					<td>
                    Pengeluaran transfer penyelenggaraan ibadah haji dari setoran jamaah
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['pengeluaran_transfer_pih_dr_jamaah'];?></td>		
					<?php } ?>	
                </tr>
                <tr>
					<td>
                    Pengeluaran untuk pengembalian dan pembatalan BPIH
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['pengeluaran_pengembalian_bpih'];?></td>		
					<?php } ?>	
                </tr>
                <tr>
					<td>
                    Pengeluaran nilai manfaat yang ditangguhkan
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right;"><?=$row['pengeluaran_nilai_manfaat_ditangguhkan'];?></td>		
					<?php } ?>	
                </tr>
                <tr>
					<td style="font-weight: bold">
                    Kas Bersih yang diperoleh dari Aktivitas Pendanaan 
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right; font-weight: bold"><?=$row['kas_bersih_aktivasi_pendanaan'];?></td>		
					<?php } ?>	
				</tr>					
                <tr>
					<td style="font-weight: bold">
                    Kenaikan (penurunan) Kas dan Setara Kas 
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right; font-weight: bold"><?=$row['kenaikan_kas_setarakas'];?></td>		
					<?php } ?>	
				</tr>					
                <tr>
					<td style="font-weight: bold">
                    Kas dan Setara Kas Pada 2 tahun sebelumnya 
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="text-align: right; font-weight: bold"><?=$row['kas_setara_kas_2'];?></td>		
					<?php } ?>	
				</tr>					
                <tr>
					<td style="font-weight: bold">
                    Kas dan Setara Kas Pada 1 tahun sebelumnya 
					</td>	
					<?php foreach($lap_arus_kas as $row ) { ?>
						<td style="font-weight: bold;text-align: right;"><?=$row['kas_setara_kas_1'];?></td>		
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
    $("#lap_arus_kas").addClass('active');
</script>





