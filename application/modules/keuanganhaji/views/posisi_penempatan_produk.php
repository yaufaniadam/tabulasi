<section class="content-header">
  <h1><i class="fa fa-kaaba"></i> &nbsp; Dana Haji yang Ditempatkan 

    <a href="<?=base_url('keuanganhaji/tambah_posisi_penempatan_produk'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp;  Tambah Data</a>
    <a href="<?=base_url('keuanganhaji/export_posisi_penempatan_produk/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a></h1>

</section>
<section class="content">
 
  <div class="row">
    <div class="col-md-12">    
     
        <?php breadcrumb('',$tahun, $thn); ?>    

        <div class="box-body smy-form-body box-keuangan">        

          <table class="keuangan table table-striped table-bordered" >
            <thead>
              <tr class="text-center">
                <th style="width:200px !important;">Bulan</th>
                <th>Giro</th>
                <th>Tabungan</th>
                <th>Deposito</th>
                <th>Jumlah</th> 
                <th> &nbsp;</th>               
              </tr>
            </thead>
            <?php foreach ($posisi_penempatan_produk as $row) { ?> 

                     
              <tr>
                <td><?=$row['bulan']; ?></td>
                <td style="text-align: right;"><?=$row['giro']; ?></td>
                <td style="text-align: right;"><?=$row['tabungan']; ?></td>
                <td style="text-align: right;"><?=$row['deposito']; ?></td>
                <td style="text-align: right;"><?=$row['jumlah']; ?></td>
                <td style="text-align: center;"> <a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('keuanganhaji/hapus_posisi_penempatan_produk/'.$row['id']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a></td>             
              </tr>
            <?php

            } //endforeach get bps bpih ?>          
           
          </table>
      
      </div>
    </div>
  </div>  
</section> 

<script>
    $("#alokasi_produk_perbankan").addClass('active');
    $("#alokasi_produk_perbankan .posisi_penempatan_produk").addClass('active');
</script>

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




