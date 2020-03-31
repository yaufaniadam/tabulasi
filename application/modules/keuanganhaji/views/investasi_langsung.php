<section class="content-header">
  <h1><i class="fa fa-kaaba"></i> &nbsp; Investasi Langsung 

    <a href="<?=base_url('keuanganhaji/tambah_investasi_langsung'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp;  Tambah Data</a>
    <a href="<?=base_url('keuanganhaji/export_investasi_langsung/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a></h1>

</section>
<section class="content">
 
  <div class="row">
    <div class="col-md-12">    
     
        <?php breadcrumb('',$tahun, $thn); ?>
        <?php if($investasi_langsung) { ?>
        <div class="box-body smy-form-body box-keuangan">        

          <table class="table table-striped table-bordered" style="width: 1500px;">
            <thead>
              <tr class="text-center">
                <th>Bulan</th>
                <th class="text-center">Usaha Sendiri</th>
                <th class="text-center">Penyertaan Modal</th>
                <th class="text-center">Pemilikan Saham</th>
                <th class="text-center">Kerjasama Investasi</th>
                <th class="text-center">Investasi Tanah/Bangunan</th>
                <th class="text-center">Investasi Langsung Lain</th>
                <th class="text-center">Total</th> 
              </tr>
            </thead>
            <?php foreach ($investasi_langsung as $row) { ?>                          
              <tr>
                <td> <a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('keuanganhaji/hapus_investasi_langsung/'.$row['id']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a> &nbsp; <?=$row['bulan']; ?></td>
                <td style="text-align: right;"><?=$row['usaha_sendiri']; ?></td>
                <td style="text-align: right;"><?=$row['penyertaan_modal']; ?></td>
                <td style="text-align: right;"><?=$row['pemilikan_saham']; ?></td>
                <td style="text-align: right;"><?=$row['kerjasama_investasi']; ?></td>
                <td style="text-align: right;"><?=$row['investasi_tanah_bangunan']; ?></td>
                <td style="text-align: right;"><?=$row['investasi_langsung_lain']; ?></td>
                <td style="text-align: right;"><?=$row['total']; ?></td>               
              </tr>
            <?php

            } //endforeach get bps bpih ?>          
           
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
  $("#alokasi_produk_investasi").addClass('active');
  $("#alokasi_produk_investasi .investasi_langsung").addClass('active');
</script>





