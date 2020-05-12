<section class="content-header">
  <h1><i class="fa fa-kaaba"></i> Alokasi Investasi BPKH 

    <a href="<?=base_url('keuanganhaji/alokasi/tambah_alokasi_investasi'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp;  Tambah Data</a>

    <a href="<?=base_url('keuanganhaji/alokasi/export_alokasi_investasi/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>


  </h1>
 
</section>


<section class="content">   
    <div class="row no-gutters" style="" >

      <?php breadcrumb('keuanganhaji',$tahun, $thn); ?> 
      <?php if($alokasi_investasi) { ?>
      <div class="well well-sm pre-scrollable" style="overflow-y:hidden;overflow-x: scroll; min-height:450px;">

      
      <table id="table1" class="table table-striped table-bordered"
       
          <tr class="mainheadingtable">
            <th class="first"><strong>Uraian</strong></td> 
              <?php foreach ($alokasi_investasi as $row) { ?>
              <th style="text-align: right; width:20%"><?= konversiBulanAngkaKeNama($row['bulan']); ?>
                
                <a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('keuanganhaji/alokasi/hapus_alokasi_investasi/'.$row['id_alokasi_investasi']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>

              </th>
            <?php } ?>

          </tr>
         
          <tr>  
            <td><strong>PER JANGKA WAKTU</strong></td>
            <?php foreach ($alokasi_investasi as $row) { ?>
              <td class="text-right"><strong><?=$row['per_jangka_waktu']; ?></strong></td>
            <?php } ?>
          </tr>
          <tr> 
            <td>Jangka Pendek</td> 
             <?php foreach ($alokasi_investasi as $row) { ?>
              <td class="text-right"><?=$row['jk_pendek']; ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td>Jangka Panjang</td> 
             <?php foreach ($alokasi_investasi as $row) { ?>
              <td class="text-right"><?=$row['jk_panjang']; ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td><strong>PER JENIS PRODUK</strong></td> 
             <?php foreach ($alokasi_investasi as $row) { ?>
              <td class="text-right"><strong><?=$row['per_jenis_produk']; ?></strong></td>
            <?php } ?>
          </tr>
          <tr> 
            <td>Sukuk</td> 
             <?php foreach ($alokasi_investasi as $row) { ?>
              <td class="text-right"><?=$row['sukuk']; ?></td>
            <?php } ?>
          </tr>
          
          <tr>
            <td>Reksadana</td> 
             <?php foreach ($alokasi_investasi as $row) { ?>
              <td class="text-right"><?=$row['reksadana']; ?></td>
            <?php } ?>
          </tr>
          
          <tr>
            <td>Penyertaan</td> 
             <?php foreach ($alokasi_investasi as $row) { ?>
              <td class="text-right"><?=$row['penyertaan']; ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td><strong>PER SUMBER KAS HAJI</strong> </td> 
             <?php foreach ($alokasi_investasi as $row) { ?>
              <td class="text-right"><strong><?=$row['per_sumber_kas_haji']; ?></strong></td>
            <?php } ?>
          </tr>
          <tr>
            <td>Setoran Jemaah Haji </td>
             <?php foreach ($alokasi_investasi as $row) { ?>
              <td class="text-right"><?=$row['setoran_jemaah_haji']; ?></td>
            <?php } ?>
          </tr>
          <tr> 
            <td>DAU </td> 
             <?php foreach ($alokasi_investasi as $row) { ?>
              <td class="text-right"><?=$row['dau']; ?></td>
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
    $("#alokasi").addClass('active');
</script>






