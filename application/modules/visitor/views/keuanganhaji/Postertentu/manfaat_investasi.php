<section class="content-header">
  <h1><i class="fa fa-kaaba"></i> Nilai Manfaat Investasi BPKH 

    <a href="<?=base_url('keuanganhaji/postertentu/tambah_manfaat_investasi'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp;  Tambah Data</a>

    <a href="<?=base_url('keuanganhaji/postertentu/export_manfaat_investasi/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>

  </h1>
 
</section>

<style type="text/css">

  table tr td {
    text-align: right;
    width:6%;
  }
 
  table tr td:first-child {
    text-align: left;
    box-shadow: 0px 0px 6px 1px rgba(179,179,179,0.5);
  }

</style>
<section class="content">   
    <div class="row no-gutters" style="" >

      <?php breadcrumb('keuanganhaji',$tahun, $thn); ?>  

      <div class="well well-sm pre-scrollable" style="overflow-y:hidden;overflow-x: scroll; min-height:780px;">
      <table id="table1" class="table table-striped table-bordered" style="width:<?=count($manfaat_investasi)*190;?>px; min-width: 50%">
       
          <tr class="mainheadingtable">
            <th style="width:25%;" class="first"><strong>Uraian</strong></td> 
              <?php foreach ($manfaat_investasi as $row) { ?>
              <th style="text-align: right; width:20%"><?=$row['bulan']; ?>
                <a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('keuanganhaji/postertentu/hapus_manfaat_investasi/'.$row['id_manfaat_investasi']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>

            </th>
            <?php } ?>

          </tr>
          <tr class="danger">
            <td><strong>INVESTASI</strong></td> 
            <?php foreach ($manfaat_investasi as $row) { ?>
              <td><strong><?=$row['investasi']; ?></strong></td>
            <?php } ?>
          </tr>
          <tr class="success">  
            <td><strong>PER JANGKA WAKTU</strong></td>
            <?php foreach ($manfaat_investasi as $row) { ?>
              <td><strong><?=$row['per_jangka_waktu']; ?></strong></td>
            <?php } ?>
          </tr>
          <tr class="success"> 
            <td>Jangka Pendek</td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['jk_pendek']; ?></td>
            <?php } ?>
          </tr>
          <tr class="success">
            <td>Jangka Panjang</td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['jk_panjang']; ?></td>
            <?php } ?>
          </tr>
          <tr class="warning">
            <td><strong>PER JENIS PRODUK</strong></td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><strong><?=$row['per_jenis_produk']; ?></strong></td>
            <?php } ?>
          </tr>
          <tr class="warning"> 
            <td>Sukuk</td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['sukuk']; ?></td>
            <?php } ?>
          </tr>
          <tr class="warning">
            <td><em> - Negara / Pemerintah</em></td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><em><?=$row['negara_pemerintah']; ?></em></td>
            <?php } ?>
          </tr>
          <tr class="warning">
            <td><em> - Korporasi</em> </td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><em><?=$row['korporasi']; ?></em></td>
            <?php } ?>
          </tr>
          
          <tr class="warning">
            <td>Reksadana</td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['reksadana']; ?></td>
            <?php } ?>
          </tr>
          <tr class="warning">
            <td> Accurued Interest Jual PBS </td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['accrued_interest_jual_pbs']; ?></td>
            <?php } ?>
          </tr>
          <tr class="warning">
            <td>Investasi Non SB</td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['investasi_non_sb']; ?></td>
            <?php } ?>
          </tr>
          <tr class="warning">
            <td> <em>- Emas</em></td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><em><?=$row['emas']; ?></em></td>
            <?php } ?>
          </tr>
          <tr class="warning">
            <td><em> - Langsung </em></td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><em><?=$row['langsung']; ?></em></td>
            <?php } ?>
          </tr>
          <tr class="warning">
            <td>Penyertaan</td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['penyertaan']; ?></td>
            <?php } ?>
          </tr>
          <tr class="warning">
            <td> Capital Gain SBSN </td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['capital_gain_sbsn']; ?></td>
            <?php } ?>
          </tr>
          <tr class="warning">
            <td> Lain-lain </td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['lain_lain']; ?></td>
            <?php } ?>
          </tr>
          <tr class="success">
            <td><strong>PER SUMBER KAS HAJI</strong> </td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><strong><?=$row['per_sumber_kas_haji']; ?></strong></td>
            <?php } ?>
          </tr>
          <tr class="success">
            <td>Setoran Jemaah Haji </td>
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['setoran_jemaah_haji']; ?></td>
            <?php } ?>
          </tr>
          <tr class="success"> 
            <td>DAU </td> 
             <?php foreach ($manfaat_investasi as $row) { ?>
              <td><?=$row['dau']; ?></td>
            <?php } ?>          
          </tr>
        
        
      </table>
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
    $("#pos_tertentu").addClass('active');
    $("#pos_tertentu .manfaat_investasi").addClass('active');
</script>






