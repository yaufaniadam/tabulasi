<section class="content-header">
  <h1><i class="fa fa-kaaba"></i> Produk Investasi
    <a href="<?= base_url('keuanganhaji/nilaimanfaat/tambah_per_instrumen'); ?>" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp; Tambah Data</a>

    <a href="<?= base_url('keuanganhaji/nilaimanfaat/export_per_instrumen/' . $thn); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp; Export Data ke Excel</a>

  </h1>

</section>

<section class="content">
  <div class="row no-gutters">
    <div class="col-md-12">
      <?php breadcrumb('keuanganhaji', $tahun, $thn); ?>
      <?php if (count($per_instrumen) > 0) { ?>
      <div class="box-body smy-form-body box-keuangan">
        <?php        

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
            } else if ($i == 2) {
              echo "<tr>\n"; // start the row
              echo "\t<th>Hapus</th>\n"; // create a table cell with the field name
              foreach ($values as $cell) // for every sub-array iterate through all values
              {
                echo '<th class="text-center"><a class="delete btn btn-xs btn-danger" data-href="' . base_url('keuanganhaji/nilaimanfaat/hapus_per_instrumen/' . $cell . "/" . $thn) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>
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
          echo "</table>";
         ?>


      
    </div>
    <?php } else {
          echo '<p class="alert alert-success"> Pilih tahun</p>';
        } ?>
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
  $("#nilai_manfaat").addClass('active');
  $("#nilai_manfaat .per_instrumen").addClass('active');
</script>