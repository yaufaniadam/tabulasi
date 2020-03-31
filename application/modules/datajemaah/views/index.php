<section class="content-header">
  <h1><i class="fa fa-kaaba"></i> Mitra Kemaslahatan 
    <a href="<?=base_url('kemaslahatan/tambah_kemaslahatan'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp;  Tambah Data</a>
    <a href="<?=base_url('kemaslahatan/export_kemaslahatan/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>
  </h1>
  
</section>



<section class="content">   
    <div class="row">
      <div class="col-lg-12">
     <?php breadcrumb('',$tahun, $thn); ?> 
     <div class="box-body smy-form-body box-keuangan">  
      <table id="table1" class="table table-striped table-bordered">
        <thead>
          
          <tr>  
            <th style="text-align: center;width:160px;">Bulan</th>     
            <th style="text-align: center;">Nama Penerima</th>
            <th style="text-align: center;">Lokasi</th>
            <th style="text-align: center;">Asnaf</th>
            <th style="text-align: center;">Nilai</th>           
          </tr>
          
        </thead>
        <tbody>   

          <?php foreach($kemaslahatan as $row ) { ?>
            <tr>
            <td>
              
               <a style="color:#fff;" title="Hapus" class="delete btn btn-xs btn-danger" data-href="<?=base_url('kemaslahatan/hapus_kemaslahatan/'.$row['id']); ?>" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
               &nbsp;
               <?=konversiBulanAngkaKeNama($row['bulan']) . " " . $row['tahun'];?>
            </td> 

            <td><?=$row['nama_penerima'];?></td>
            <td><?=$row['lokasi'];?></td>
            <td><?=$row['asnaf'];?></td>
            <td style="text-align: right;"><?=$row['nilai'];?></td>       
          </tr>         
        <?php } ?>          
        </tbody>
      </table>
    </div>
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
   $("#kemaslahatan").addClass('active');
</script>

