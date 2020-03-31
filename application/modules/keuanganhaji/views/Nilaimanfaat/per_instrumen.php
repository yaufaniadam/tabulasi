<section class="content-header">
	<h1><i class="fa fa-kaaba"></i> Produk Investasi
		<a href="<?= base_url('keuanganhaji/nilaimanfaat/tambah_per_instrumen'); ?>" class="btn btn-warning btn-sm"><i
				class="fas fa-plus"></i>&nbsp; Tambah Data</a>

		<a href="<?= base_url('keuanganhaji/nilaimanfaat/export_per_instrumen/' . $thn); ?>"
			class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp; Export Data ke Excel</a>

	</h1>

</section>

<section class="content">
	<div class="row no-gutters">
		<div class="col-md-12">
    <?php breadcrumb('keuanganhaji',$tahun, $thn); ?>  
			<?php

    if (count($per_instrumen) > 0) {

      foreach ($per_instrumen as $key => $row) {
        foreach ($row as $field => $value) {
          $recNew[$field][] = $value;
        }
      }

      echo "<table class='table table-bordered table-striped'>\n";
      $i = 1;
      foreach ($recNew as $key => $values) // For every field name (id, name, last_name, gender)
      {
        if ($i == 1) {
          echo "<tr>\n"; // start the row
          echo "\t<th>" . $key . "</th>\n"; // create a table cell with the field name
          foreach ($values as $cell) // for every sub-array iterate through all values
          {
            echo "\t<th class='text-center'>" . $cell . "</th>\n"; // write cells next to each other
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
      echo "</table>";
    } else { echo '<p class="alert alert-success"> Pilih tahun</p>';} ?> 

			<!--
      <div class="well well-sm pre-scrollable" style="overflow-x: scroll; min-height:500px;">
      <table id="table1" class="table table-striped table-bordered" style="width:2600px;">
        <thead>
          
          <tr class="subheadingtable">  
            <th>Bulan</th>          
            <th>DAU (SDHI & SBSN)</th>
            <th>Surat Berharga</th>
            <th>SDHI</th>
            <th>SBSN</th>
            <th>SBSN USD</th>
            <th>Sukuk Korporasi</th>
            <th><strong>RD Terproteksi Syariah</strong></th>
            
            <th>RD Pasar Uang Syariah</th>
            <th>RD Penyertaan Terbatas</th>
            <th>Saham BMI</th>
            <th>Lain-lain</th>
            <th>Investasi Langsung</th>   
            <th>Investasi Lainnya</th>            
            
            <th>Emas</th>       
            <th><strong>Total</strong></th>
            <th><strong>Total Exclude DAU</strong></th>
            
          </tr>
          
        </thead>
        <tbody>   

          <?php foreach ($per_instrumen as $per_instrumen) { ?>
            <tr class="uang">
            <td class="pertama">
              <a href="<?= base_url('keuanganhaji/nilaimanfaat/per_instrumen_detail/' . $per_instrumen['id_per_instrumen']); ?>"><strong><?= $per_instrumen['bulan']; ?></strong></a> <a title="Lihat Periode <?= $per_instrumen['bulan']; ?>" class="btn btn-default btn-xs" href="<?= base_url('keuanganhaji/nilaimanfaat/detail_per_instrumen/' . $per_instrumen['id_per_instrumen']); ?>"><i class="fa fa-search"></i></a> <a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?= base_url('keuanganhaji/nilaimanfaat/hapus_per_instrumen/' . $per_instrumen['id_per_instrumen']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
            </td> 

            <td class="warning"><?= $per_instrumen['dau']; ?></td>
            <td class="warning"><?= $per_instrumen['surat_berharga']; ?></td>
            <td class="warning"><?= $per_instrumen['sdhi']; ?></td>
            <td class="warning"><?= $per_instrumen['sbsn']; ?></td>
            <td class="warning"><?= $per_instrumen['sbsn_usd']; ?></td>
            <td class="warning"><?= $per_instrumen['sukuk_korporasi']; ?></td>
            <td class="warning"><?= $per_instrumen['rd_terproteksi_syariah']; ?></td>
            <td class="warning"><strong><?= $per_instrumen['rd_pasar_uang_syariah']; ?></strong></td>          
            <td><?= $per_instrumen['rd_penyertaan_terbatas']; ?></td>
            <td><?= $per_instrumen['saham_bmi']; ?></td>
            <td><?= $per_instrumen['lain_lain']; ?></td>
            <td><?= $per_instrumen['investasi_langsung']; ?></td>
            <td><?= $per_instrumen['investasi_lainnya']; ?></td>
            <td><strong><?= $per_instrumen['emas']; ?></strong></td>
            <td><strong><?= $per_instrumen['total']; ?></strong></td>         
            
            <td class="success"><?= $per_instrumen['total_exclude_dau']; ?></td>

           
          </tr>         
        <?php } ?>          
        </tbody>
      </table>
    </div>-->
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
	$('#confirm-delete').on('show.bs.modal', function (e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});

</script>

<script>
	$("#nilai_manfaat").addClass('active');
	$("#nilai_manfaat .per_instrumen").addClass('active');

</script>
