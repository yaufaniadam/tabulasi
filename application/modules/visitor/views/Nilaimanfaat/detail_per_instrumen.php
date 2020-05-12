<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Nilai Manfaat Investasi <a href="<?=base_url('keuanganhaji/nilaimanfaat/tambah_per_instrumen'); ?>" class="btn btn-default btn-sm">Tambah Data</a></h1>
	
</section>

<style>
	tbody.per_instrumen td:nth-child(2) {
		text-align: right;

	}
</style>


<section class="content">
 	
  	<div class="row no-gutters">
  		<div class="col-md-12">
  			<h4 style="text-align: center; text-transform: uppercase;margin-bottom: 20px;"> Nilai Manfaat Investasi Per-Instrumen Periode <?=$per_instrumen['bulan'];?> <br><br><a href="<?=base_url('keuanganhaji/nilaimanfaat/per_instrumen'); ?>" class="btn btn-warning btn-sm"><i class="fa fa-chevron-circle-left"></i> &nbsp; Kembali</a></h4>     
        	<div class="box-body my-form-body" style="border:5px solid #ffffff; overflow: auto;padding:0;"> 


		  		<table class="keuangan table table-striped table-bordered">
					<thead>
						<tr>
							<th><strong>Nilai Manfaat</strong></th>
							<th style="text-align: right"><strong><?=$per_instrumen['bulan'];?></strong></th>				
						</tr>
					</thead>
					<tbody class="per_instrumen">						
						<tr>
							<td>DAU (SDHI & SBSN)</td>
							<td><?=$per_instrumen['dau'];?></td>
						</tr>
						<tr>
							<td>Surat Berharga</td>
							<td><?=$per_instrumen['surat_berharga'];?></td>
						</tr>
						<tr>
							<td>SDHI</td>
							<td><?=$per_instrumen['sdhi'];?></td>
						</tr>
						<tr>
							<td>SBSN</td>
							<td><?=$per_instrumen['sbsn'];?></td>
						</tr>
						<tr>
							<td>SBSN USD</td>
							<td><?=$per_instrumen['sbsn_usd'];?></td>
						</tr>
						<tr>
							<td>Sukuk Korporasi</td>
							<td><?=$per_instrumen['sukuk_korporasi'];?></td>
						</tr>
						<tr>
							<td>RD Terproteksi Syariah</td>
							<td><?=$per_instrumen['rd_terproteksi_syariah'];?></td>
						</tr>
						
						<tr>
							<td>RD Pasar Uang Syariah</td>
							<td><?=$per_instrumen['rd_pasar_uang_syariah'];?></td>
						</tr>
						<tr>
							<td>RD Penyertaan Terbatas</td>
							<td><?=$per_instrumen['rd_penyertaan_terbatas'];?></td>
						</tr>
						<tr>
							<td>Lain-lain</td>
							<td><?=$per_instrumen['lain_lain'];?></td>
						</tr>
						<tr>
							<td>Investasi Langsung</td>
							<td><?=$per_instrumen['investasi_langsung'];?></td>
						</tr>
						<tr>
							<td>Investasi Lainnya</td>
							<td><?=$per_instrumen['investasi_lainnya'];?></td>
						</tr>
						<tr>
							<td>Emas</td>
							<td><?=$per_instrumen['emas'];?></td>
						</tr>
						<tr>
							<td><strong>Total</strong></td>
							<td><strong><?=$per_instrumen['total'];?></strong></td>
						</tr>						
						<tr>
							<td><strong>Total Exclude DAU</strong></td>
							<td><strong><?=$per_instrumen['total_exclude_dau'];?></strong></td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>        
	</div>
</section>

<script>
    $("#nilai_manfaat").addClass('active');
    $("#nilai_manfaat .per_instrumen").addClass('active');
</script>
