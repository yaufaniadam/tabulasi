<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-body with-border">
        <div class="col-md-8">
          <h4><i class="fa fas fa-money-bill"></i> &nbsp; Semua Investasi</h4>
        </div>   
         <div class="col-md-4 text-right">
          <a href="<?= base_url('investasi/tambah'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Investasi</a>
        </div>    
      </div>  
  
      <div class="box">
        
          <div class="box-header">
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <table id="investasi_json" class="table table-bordered table-striped" style="width:100%">
              <thead>
              <tr>
     
                <th>Jenis Investasi</th>
                <th>Lembaga</th>
                <th>Nomor Seri</th>
                <th>Nomor Transaksi Investasi</th>
                <th>Estimasi Return Bagi Hasil (%)</th>
                <th>Pokok Investasi (Rp)</th>
                <th>Tanggal Transaksi Investasi</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Sisa Jangka Waktu</th>
                <th>Periode</th>
                <th>Aksi</th>
              </tr>
              </thead>
             
             
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
  //---------------------------------------------------
  var table = $('#investasi_json').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "<?=base_url('keuanganhaji/investasi_json')?>",
      "order": [[0,'asc']],
      "columnDefs": [
     
        { "targets": 0, "name": "jenis_investasi", 'searchable':true, 'orderable':true},
        { "targets": 1, "name": "no_seri", 'searchable':true, 'orderable':true},
        { "targets": 2, "name": "no_transaksi", 'searchable':true, 'orderable':true},
        { "targets": 3, "name": "estimasi_return", 'searchable':true, 'orderable':true},
        { "targets": 4, "name": "pokok_investasi", 'searchable':true, 'orderable':true},
        { "targets": 5, "name": "tgl_transaksi", 'searchable':true, 'orderable':true},
        { "targets": 6, "name": "tgl_jatuh_tempo", 'searchable':true, 'orderable':true},
        { "targets": 7, "name": "periode", 'searchable':true, 'orderable':true},
         { "targets": 8, "name": "periode", 'searchable':false, 'orderable':true},      
         { "targets": 9, "name": "aksi", 'searchable':false, 'orderable':false},
          { "targets": 10, "name": "aksi", 'searchable':false, 'orderable':false},
      ]
    });



  </script>



<script>
  $("#keuangan_haji").addClass('active');
  $("#keuangan_haji .sub_investasi").addClass('active');
</script