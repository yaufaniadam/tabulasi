<section class="content-header">
  <h1><i class="fa fa-file-pdf"></i> &nbsp; Laporan Realisasi Program Kemaslahatan
    <a href="<?=base_url('visitor/kemaslahatan/export_kemaslahatan/'.$thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;  Export Data ke Excel</a>
  </h1>
    
</section>

<section class="content">
<?php breadcrumb('visitor',$tahun, $thn); ?>
  <div class="box">
    <div class="box-header">
    
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive" style="padding-top:0;">
      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Bulan</th>
            <th>Nama Penerima</th>
            <th>Jenis</th>
            <th>Lokasi</th>
            <th>Kegiatan</th>
            <th>Asnaf</th>
            <th>Nilai</th>
            <th style="width:10px;text-align: center;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($kemaslahatan as $row) { ?>
            <tr>
              <td><?=konversiBulanAngkaKeNama($row['bulan']); ?></td>
              <td><?=$row['nama_penerima']; ?></td>
              <td><?=$row['jenis']; ?></td>
              <td><?=$row['lokasi']; ?></td>
              <td><?=$row['kegiatan']; ?></td>
              <td><?=$row['asnaf']; ?></td>
              <td class="text-right"><?=$row['nilai']; ?></td>
              <td class="text-center;width:100px;">                
               
                <a style="color:#fff;" title="Lihat Dokumentasi" class="dbtn btn-xs btn-info" href="<?=base_url('visitor/kemaslahatan/dokumentasi/'.$row['id']); ?>"> <i class="fas fa-image"></i></a>

               
              </td>
             
          <?php  } ?>
        </tbody>           
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
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


<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>


<script type="text/javascript">
  $(function () {
    $("#table").DataTable();
  });
  

  $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });

  $("#kemaslahatan").addClass('active');
</script>