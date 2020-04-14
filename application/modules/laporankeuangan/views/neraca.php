<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Neraca 

		<a href="<?=base_url('laporankeuangan/tambah_neraca'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp;  Tambah Data</a>
		<a href="<?=base_url('laporankeuangan/export_neraca/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>

	</h1>


	
</section>



<section class="content"> 	
  	<div class="row no-gutters"> 

		  <?php breadcrumb('',$tahun, $thn); ?> 
		  

		  <?php

if (count($neraca) > 0) {

	$jumlah_col = count($neraca);
	$tb_w =  ($jumlah_col <= 3) ? $jumlah_col * 400 : $jumlah_col * 200;

  foreach ($neraca as $key => $row) {
	foreach ($row as $field => $value) {
	  $recNew[$field][] = $value;
	}
  }
  echo '<div class="well well-sm pre-scrollable" style="overflow-x: scroll; min-height:450px;">';
	echo '<table id="table1" class="table table-striped table-bordered" style="width:'. $tb_w .'px;">';

  $i = 1;
  foreach ($recNew as $key => $values) // For every field name (id, name, last_name, gender)
  {
	if ($i == 1) {
	  echo "<tr>\n"; // start the row
	  echo "\t<th style='width:200px !important'>Bulan</th>\n"; // create a table cell with the field name
	  foreach ($values as $cell) // for every sub-array iterate through all values
	  {
		echo '<th class="text-center">'. konversiTanggalAngkaKeNama($cell) .'</th>'; // write cells next to each other
	  }
	  echo "</tr>\n"; // end row
	} elseif ($i == 2) {
	  echo "<tr>\n"; // start the row
	  echo "\t<th style='width:200px !important'></th>\n"; // create a table cell with the field name
	  foreach ($values as $cell) // for every sub-array iterate through all values
	  {
		echo '<th class="text-center"><a class="delete btn btn-xs btn-danger" data-href="'.base_url('laporankeuangan/hapus_neraca/'. $cell.'/'.$thn).'" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
		</th>'; // write cells next to each other
	  }
	  echo "</tr>\n"; // end row
	} else {
	  echo "<tr>\n"; // start the row
	  echo "\t<td>" . $key . "</td>\n"; // create a table cell with the field name
	  foreach ($values as $cell) // for every sub-array iterate through all values
	  {
		echo "\t<td class='text-center'>" . $cell . "</td>\n"; // write cells next to each other
	  }
	  echo "</tr>\n"; // end row

	}
	$i++;
  }
  echo "</table></div>";
} else { echo '<p class="alert alert-success"> Pilih tahun</p>';} ?> 


<?php /*

  		<div class="well well-sm pre-scrollable" style="overflow-x: scroll; min-height:500px;">
			<table id="table1" class="table table-striped table-bordered" style="width:3600px;">
				<thead>
					<tr class="mainheadingtable">
						<th rowspan="3" class="pertama"><strong>Uraian</strong></th>
					
						<th colspan="13">
							ASET
						</th>
						<th colspan="9">
							LIABILITAS
						</th>
						<th colspan="4">
							ASET NETO
						</th>
						<th rowspan="3"><strong>JUMLAH LIABILITAS DAN ASET NETO</strong></th>
					</tr>
					<tr class="headingtable">
						
					
						<th colspan="7">
							Aset Lancar
						</th>
						<th colspan="5">
							Aset Tidak Lancar
						</th>
						<th rowspan="2"><strong>TOTAL ASET</strong></th>
						<th colspan="5"><strong>Liabilitas Jangka Pendek</strong></th>
						<th colspan="3"><strong>Liabilitas Jangka Panjang</strong></th>

						<th rowspan="2"><strong>JUMLAH LIABILITAS</strong></th>
						<th rowspan="2">Tidak terikat</th>	
						<th rowspan="2">Terikat temporer</th>	
						<th rowspan="2">Terikat permanen</th>
						<th rowspan="2"><strong>JUMLAH ASET NETO</strong></th>		

					</tr>
					<tr class="subheadingtable">						
						<th>Kas dan setara kas</th><th>Piutang</th>
						<th>Pendapatan yang masih harus diterima</th>
						<th>Uang muka BPIH</th>
						<th>Penempatan pada bank</th>
						<th>Investasi jangka pendek</th>
						<th><strong>Jumlah Aset Lancar</strong></th>
						
						<th>Investasijangka panjang</th>
						<th>Aset tetap - bersih</th>
						<th>Aset tak berwujud - bersih</th>
						<th>Aset lain-lain</th>		
						<th><strong>Jumlah Aset Tidak Lancar</strong></th>						
						
						<th>Utang beban</th>
						<th>Utang setoran lunas dan tunda </th>
						<th>Utang pajak</th><th>Utang lain-Lain</th>
						<th><strong>Jumlah Liabilitas Jangka Pendek</strong></th>
						<th>Dana titipan jemaah</th>
						<th>Pendapatan nilai manfaat yang ditangguhkan</th>
						<th><strong>Jumlah Liabilitas Jangka Panjang</strong></th>	
						
					</tr>
					
				</thead>
				<tbody>		

  				<?php foreach($neraca as $neraca ) { ?>
  					<tr class="uang">
						<td class="pertama">
							<a href="<?=base_url('laporankeuangan/neraca_detail/'.$neraca['id']); ?>"><strong><?=konversiTanggalAngkaKeNama($neraca['date']);?></strong></a> <a title="Lihat Periode <?=konversiTanggalAngkaKeNama($neraca['date']);?>" class="btn btn-default btn-xs" href="<?=base_url('laporankeuangan/detail_neraca/'.$neraca['id']); ?>"><i class="fa fa-search"></i></a> <a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('laporankeuangan/hapus_neraca/'.$neraca['id']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
						</td>	

						<td class="warning"><?=$neraca['kasdansetarakas'];?></td>
						<td class="warning"><?=$neraca['piutang'];?></td>
						<td class="warning"><?=$neraca['pendapatannilaimanfaatyangditangguhkan'];?></td>
						<td class="warning"><?=$neraca['uangmukabpih'];?></td>
						<td class="warning"><?=$neraca['penempatanpadabank'];?></td>
						<td class="warning"><?=$neraca['investasijangkapendek'];?></td>
						<td class="warning"><strong><?=$neraca['jumlahasetlancar'];?></strong></td>
					
						<td><?=$neraca['investasijangkapanjang'];?></td>
						<td><?=$neraca['asettetapbersih'];?></td>
						<td><?=$neraca['asettakberwujudbersih'];?></td>
						<td><?=$neraca['asetlainlain'];?></td>
						<td><strong><?=$neraca['jumlahasettidaklancar'];?></strong></td>
						<td><strong><?=$neraca['totalaset'];?></strong></td>
					
						
						<td class="success"><?=$neraca['utangbeban'];?></td>
						<td class="success"><?=$neraca['utangsetoranlunasdantunda'];?></td>
						<td class="success"><?=$neraca['utangpajak'];?></td>
						<td class="success"><?=$neraca['utanglainlain'];?></td>
						<td class="success"><strong><em><?=$neraca['jumlahliabilitasjangkapendek'];?></em></strong></td>					
						
						<td class="info"><?=$neraca['danatitipanjemaah'];?></td>
						<td class="info"><?=$neraca['pendapatannilaimanfaatyangditangguhkan'];?></td>
						<td class="info"><strong><?=$neraca['jumlahliabilitasjangkapanjang'];?></strong></td>
						<td class="info"><strong><?=$neraca['jumlahliabilitas'];?></strong></td>
						
						<td class="danger"><?=$neraca['tidakterikat'];?></td>
						<td class="danger"><?=$neraca['terikattemporer'];?></td>
						<td class="danger"><?=$neraca['terikatpermanen'];?></td>
						<td class="danger"><strong><?=$neraca['jumlahasetneto'];?></strong></td>

						<td><strong><?=$neraca['jumlahliabilitasdanasetneto'];?></strong></td>	
					</tr>					
				<?php } ?>					
				</tbody>
			</table>
		</div>

		*/ ?>
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
    $("#neraca").addClass('active');
</script>





