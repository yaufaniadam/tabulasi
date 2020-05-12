<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Neraca <a href="<?=base_url('laporankeuangan/tambah_neraca'); ?>" class="btn btn-default btn-sm">Tambah Data</a></h1>
	
</section>

<style>
	tbody.neraca td:nth-child(2) {
		text-align: right;

	}
</style>


<section class="content">
 	
  	<div class="row no-gutters" style="" >
  		<div class="col-md-12">
  			<h4 style="text-align: center; text-transform: uppercase;margin-bottom: 20px;"> Neraca Periode <?=konversiTanggalAngkaKeNama($neraca['date']);?> <br><br><a href="<?=base_url('laporankeuangan/neraca'); ?>" class="btn btn-warning btn-sm"><i class="fa fa-chevron-circle-left"></i> &nbsp; Kembali</a></h4>     
        	<div class="box-body my-form-body" style="border:5px solid #ffffff; overflow: auto;padding:0;"> 


		  		<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th><strong>Uraian</strong></th>
							<th style="text-align: right"><strong><?=konversiTanggalAngkaKeNama($neraca['date']);?></strong></th>				
						</tr>
					</thead>
					<tbody class="neraca">	
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
							<td><?=$neraca['kasdansetarakas'];?></td>
						</tr>
						<tr>
							<td>Piutang</td>
							<td><?=$neraca['piutang'];?></td>
						</tr>
						<tr>
							<td>Pendapatan yang masih harus diterima</td>
							<td><?=$neraca['pendapatannilaimanfaatyangditangguhkan'];?></td>
						</tr>
						<tr>
							<td>Uang muka BPIH</td>
							<td><?=$neraca['uangmukabpih'];?></td>
						</tr>
						<tr>
							<td>Penempatan pada bank</td>
							<td><?=$neraca['penempatanpadabank'];?></td>
						</tr>
						<tr>
							<td>Investasi jangka pendek</td>
							<td><?=$neraca['investasijangkapendek'];?></td>
						</tr>
						<tr>
							<td><strong>Jumlah Aset Lancar</strong></td>
							<td><strong><?=$neraca['jumlahasetlancar'];?></strong></td>
						</tr>
						<tr>
							<td><strong><em>Aset Tidak Lancar</em></strong></td>
							
						</tr>
						<tr>
							<td>Investasijangka panjang</td>
							<td><?=$neraca['investasijangkapanjang'];?></td>
						</tr>
						<tr>
							<td>Aset tetap - bersih</td>
							<td><?=$neraca['asettetapbersih'];?></td>
						</tr>
						<tr>
							<td>Aset tak berwujud - bersih</td>
							<td><?=$neraca['asettakberwujudbersih'];?></td>
						</tr>
						<tr>
							<td>Aset lain-lain</td>
							<td><?=$neraca['asetlainlain'];?></td>
						</tr>
						<tr>
							<td><strong>Jumlah Aset Tidak Lancar</strong></td>
							<td><strong><?=$neraca['jumlahasettidaklancar'];?></strong></td>
						</tr>
						<tr>
							<td><strong>TOTAL ASET</strong></td>
							<td><strong><?=$neraca['totalaset'];?></strong></td>
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
							<td><?=$neraca['utangbeban'];?></td>
						</tr>
						<tr>
							<td>Utang setoran lunas dan tunda </td>
							<td><?=$neraca['utangsetoranlunasdantunda'];?></td>
						</tr>
						<tr>
							<td>Utang pajak</td>
							<td><?=$neraca['utangpajak'];?></td>
						</tr>
						<tr>
							<td>Utang lain-Lain</td>
							<td><?=$neraca['utanglainlain'];?></td>
						</tr>
						<tr>
							<td><strong>Jumlah Liabilitas Jangka Pendek</strong></td>
							<td><strong><em><?=$neraca['jumlahliabilitasjangkapendek'];?></em></strong></td>
						</tr>
						<tr>
							<td><strong><em>Liabilitas Jangka Panjang</em></strong></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Dana titipan jemaah</td>
							<td><?=$neraca['danatitipanjemaah'];?></td>
						</tr>
						<tr>
							<td>Pendapatan nilai manfaat yang ditangguhkan</td>
							<td><?=$neraca['pendapatannilaimanfaatyangditangguhkan'];?></td>
						</tr>
						<tr>
							<td><strong>Jumlah Liabilitas Jangka Panjang</strong></td>
							<td><strong><?=$neraca['jumlahliabilitasjangkapanjang'];?></strong></td>
						</tr>
						<tr>
							<td><strong>JUMLAH LIABILITAS</strong></td>
							<td><strong><?=$neraca['jumlahliabilitas'];?></strong></td>
						</tr>
						<tr>
							<td><strong>ASET NETO</strong></td>
							<td>&nbsp;</td>	
						</tr>
						<tr>
							<td>Tidak terikat</td>
							<td><?=$neraca['tidakterikat'];?></td>
						</tr>
						<tr>
							<td>Terikat temporer</td>
							<td><?=$neraca['terikattemporer'];?></td>
						</tr>
						<tr>
							<td>Terikat permanen</td>
							<td><?=$neraca['terikatpermanen'];?></td>
						</tr>
						<tr>
							<td><strong>JUMLAH ASET NETO</strong></td>
							<td><strong><?=$neraca['jumlahasetneto'];?></strong></td>
						</tr>
						<tr>
							<td><strong>JUMLAH LIABILITAS DAN ASET NETO</strong></td>
							<td><strong><?=$neraca['jumlahliabilitasdanasetneto'];?></strong></td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>        
	</div>
</section>