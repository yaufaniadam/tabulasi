<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Portfolio Investasi <a href="<?=base_url('keuanganhaji/postertentu/tambah_portfolio_investasi'); ?>" class="btn btn-default btn-sm">Tambah Data</a></h1>
	
</section>

<style>
	tbody.portfolio_investasi td:nth-child(2) {
		text-align: right;

	}
</style>


<section class="content">
 	
  	<div class="row no-gutters" style="" >
  		<div class="col-md-12">
  			<h4 style="text-align: center; text-transform: uppercase;margin-bottom: 20px;"> Portfolio Investasi Periode <?=konversiTanggalAngkaKeNama($portfolio_investasi['date']);?> <br><br><a href="<?=base_url('keuanganhaji/postertentu/portfolio_investasi'); ?>" class="btn btn-warning btn-sm"><i class="fa fa-chevron-circle-left"></i> &nbsp; Kembali</a></h4>     
        	<div class="box-body my-form-body" style="border:5px solid #ffffff; overflow: auto;padding:0;"> 


		  		<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th><strong>Uraian</strong></th>
							<th style="text-align: right"><strong><?=konversiTanggalAngkaKeNama($portfolio_investasi['date']);?></strong></th>				
						</tr>
					</thead>
					<tbody class="portfolio_investasi">	
						<tr>
							<td><strong>ASET</strong></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td><strong><em>Aset Lancar</em></strong></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Kas dan setara kas</td>
							<td><?=$portfolio_investasi['kasdansetarakas'];?></td>
						</tr>
						<tr>
							<td>Piutang</td>
							<td><?=$portfolio_investasi['piutang'];?></td>
						</tr>
						<tr>
							<td>Pendapatan yang masih harus diterima</td>
							<td><?=$portfolio_investasi['pendapatannilaimanfaatyangditangguhkan'];?></td>
						</tr>
						<tr>
							<td>Uang muka BPIH</td>
							<td><?=$portfolio_investasi['uangmukabpih'];?></td>
						</tr>
						<tr>
							<td>Penempatan pada bank</td>
							<td><?=$portfolio_investasi['penempatanpadabank'];?></td>
						</tr>
						<tr>
							<td>Investasi jangka pendek</td>
							<td><?=$portfolio_investasi['investasijangkapendek'];?></td>
						</tr>
						<tr>
							<td><strong>Jumlah Aset Lancar</strong></td>
							<td><strong><?=$portfolio_investasi['jumlahasetlancar'];?></strong></td>
						</tr>
						<tr>
							<td><strong><em>Aset Tidak Lancar</em></strong></td>
							
						</tr>
						<tr>
							<td>Investasijangka panjang</td>
							<td><?=$portfolio_investasi['investasijangkapanjang'];?></td>
						</tr>
						<tr>
							<td>Aset tetap - bersih</td>
							<td><?=$portfolio_investasi['asettetapbersih'];?></td>
						</tr>
						<tr>
							<td>Aset tak berwujud - bersih</td>
							<td><?=$portfolio_investasi['asettakberwujudbersih'];?></td>
						</tr>
						<tr>
							<td>Aset lain-lain</td>
							<td><?=$portfolio_investasi['asetlainlain'];?></td>
						</tr>
						<tr>
							<td><strong>Jumlah Aset Tidak Lancar</strong></td>
							<td><strong><?=$portfolio_investasi['jumlahasettidaklancar'];?></strong></td>
						</tr>
						<tr>
							<td><strong>TOTAL ASET</strong></td>
							<td><strong><?=$portfolio_investasi['totalaset'];?></strong></td>
						</tr>
						<tr>
							<td><strong>LIABILITAS</strong></td>
							<td>&nbsp;</td>	
						</tr>
						<tr>
							<td><strong><em>Liabilitas Jangka Pendek</em></strong></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Utang beban</td>
							<td><?=$portfolio_investasi['utangbeban'];?></td>
						</tr>
						<tr>
							<td>Utang setoran lunas dan tunda </td>
							<td><?=$portfolio_investasi['utangsetoranlunasdantunda'];?></td>
						</tr>
						<tr>
							<td>Utang pajak</td>
							<td><?=$portfolio_investasi['utangpajak'];?></td>
						</tr>
						<tr>
							<td>Utang lain-Lain</td>
							<td><?=$portfolio_investasi['utanglainlain'];?></td>
						</tr>
						<tr>
							<td><strong>Jumlah Liabilitas Jangka Pendek</strong></td>
							<td><strong><em><?=$portfolio_investasi['jumlahliabilitasjangkapendek'];?></em></strong></td>
						</tr>
						<tr>
							<td><strong><em>Liabilitas Jangka Panjang</em></strong></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Dana titipan jemaah</td>
							<td><?=$portfolio_investasi['danatitipanjemaah'];?></td>
						</tr>
						<tr>
							<td>Pendapatan nilai manfaat yang ditangguhkan</td>
							<td><?=$portfolio_investasi['pendapatannilaimanfaatyangditangguhkan'];?></td>
						</tr>
						<tr>
							<td><strong>Jumlah Liabilitas Jangka Panjang</strong></td>
							<td><strong><?=$portfolio_investasi['jumlahliabilitasjangkapanjang'];?></strong></td>
						</tr>
						<tr>
							<td><strong>JUMLAH LIABILITAS</strong></td>
							<td><strong><?=$portfolio_investasi['jumlahliabilitas'];?></strong></td>
						</tr>
						<tr>
							<td><strong>ASET NETO</strong></td>
							<td>&nbsp;</td>	
						</tr>
						<tr>
							<td>Tidak terikat</td>
							<td><?=$portfolio_investasi['tidakterikat'];?></td>
						</tr>
						<tr>
							<td>Terikat temporer</td>
							<td><?=$portfolio_investasi['terikattemporer'];?></td>
						</tr>
						<tr>
							<td>Terikat permanen</td>
							<td><?=$portfolio_investasi['terikatpermanen'];?></td>
						</tr>
						<tr>
							<td><strong>JUMLAH ASET NETO</strong></td>
							<td><strong><?=$portfolio_investasi['jumlahasetneto'];?></strong></td>
						</tr>
						<tr>
							<td><strong>JUMLAH LIABILITAS DAN ASET NETO</strong></td>
							<td><strong><?=$portfolio_investasi['jumlahliabilitasdanasetneto'];?></strong></td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>        
	</div>
</section>

<script>
    $("#pos_tertentu").addClass('active');
    $("#pos_tertentu .portfolio_investasi").addClass('active');
</script>