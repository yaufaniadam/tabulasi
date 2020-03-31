<section class="content-header">
  <h1>Keuangan Haji <a href="<?= base_url('penempatan/tambah/kh/'.$jenis_penempatan['slug']) ?>" class="btn btn-default btn-sm">Tambah Penempatan</a></h1>
</section>

<?php
$kat = $this->uri->segment('4');
$tahun = $this->uri->segment('5');
isset ($tahun) ?  $tahun = $tahun :  $tahun = "all";
$lembaga = $this->uri->segment('6');
isset ($lembaga) ?  $lembaga = $lembaga :  $lembaga = "all";
$quartal = $this->uri->segment('7');
isset ($quartal) ?  $quartal = $quartal :  $quartal = "all";
?>
     
<section class="content">
  <div class="row">
    <div class="col-md-12">
      
        <div class="box">   
          <div class="box-header">
            <h3 class="box-title"><?=$jenis_penempatan['jenis_penempatan'];?> </h3>
            Total Penempatan : <?=number_format($total_penempatan['pokok_estimasi']);?>
            <a href="<?= base_url('penempatan/keuanganhaji/grafik/'.$jenis_penempatan['slug']) ?>" class="btn btn-default btn-md pull-right"><i class="fas fa-chart-area"></i> Lihat Grafik</a>
          </div>     
          <div class="box-body table-responsive">
            <table id="penempatan" class="table table-bordered table-striped dataTable" style="width:100%">
              <thead>
                <tr>       
                  <th>Lembaga</th>
                 <!-- <th>No. Seri</th>
                  <th>No. Transaksi</th>-->
                  <th style="text-align: center">Est. Return <!--Bagi Hasil--></th>
                  <th style="text-align: center">Pokok <!--Penempatan--> (Rp)</th>
                  <th style="text-align: center">Jumlah (Rp)</th>
                  <th style="text-align: center">Tgl Transaksi</th>
                  <th style="text-align: center">Jatuh Tempo</th>
                  <th style="text-align: center">Sisa Hari</th>
                  <th style="text-align: center">Q</th>
                  <!--<th>Tahun</th>-->
                </tr>
              </thead>
              <tbody>
                
                <?php foreach ($penempatan as $row) { ?>
                  <tr>   
                    <td><a href="<?= base_url('penempatan/keuanganhaji/index/'.$jenis_penempatan['slug']) ?>/all/<?=$row['lembaga']; ?>/all"><?=get_nama_lembaga($row['lembaga']); ?></a></td>
                    <!--<td><?=$row['no_seri']; ?></td>
                    <td><?=$row['no_transaksi']; ?></td>-->
                    <td style="text-align: center"><?=$row['estimasi_return']; ?> %</td>
                    <td style="text-align: right;"><?=number_format($row['pokok_penempatan']); ?></td>
                    <td style="text-align: right;"><?=number_format( $row['total_penempatan'] ); ?></td>
                    <td><?=$row['tgl_transaksi']; ?></td>
                    <td><?=$row['tgl_jatuh_tempo']; ?></td>
                    <td style="text-align: right"><?=$row['sisa_hari'] ?></td>
                    <td><a href="<?= base_url('penempatan/keuanganhaji/index/'.$jenis_penempatan['slug']) ?>/<?=$tahun; ?>/<?=$row['lembaga']; ?>/<?=$row['quartal']; ?>"><?=$row['quartal']; ?> <?=$row['tahun']; ?></a></td>
                   
                  </tr>
                <?php } //endforeach ?>
                 

              </tbody> 
            
            </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
     

     </div>
  </div><!-- /.row  -->
  


 
</section>  

<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
 //datatable
  var table =$("#penempatan").DataTable(
  {
    order: [[ 1, "asc" ]],
      language: {
        searchPlaceholder: "Cari data"
      }
    }
  );

</script> 

<script>
  $("#keuangan_haji").addClass('active');
  $("#keuangan_haji .<?=$jenis_penempatan['slug']; ?>").addClass('active');
</script