<!-- Content Header (Page header) -->


<!-- Main content -->
<section class="content">



  <div class="row">
    <div class="col-md-6">
      <!-- DONUT CHART -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Total Responden (<?= $totalparticipants->num_rows(); ?>)</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <canvas id="responden" style="height:200px"></canvas>


        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </div>
    <div class="col-md-6">


    </div>

    <!-- /.col (LEFT) -->



  </div>
  <!-- /.row -->

  <!-- DONUT CHART -->
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">Grafik Harian</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <canvas id="myChart" style="height:200px"></canvas>


    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->


</section>
<!-- /.content -->

<!-- ChartJS 1.0.1 -->
<script src="<?= base_url() ?>public/plugins/chartjs/Chart.min.js"></script>
<script src="<?= base_url() ?>public/plugins/chartjs/utils.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>public/plugins/fastclick/fastclick.js"></script>
<!-- page script -->
<script>
  $(function() {
    new Chart(document.getElementById("responden"), {
      type: 'pie',
      data: {
        labels: ["Menyelesaikan <?= $totalparticipants_sah->num_rows(); ?>", "Tidak menyelesaikan <?= $totalparticipants->num_rows() - $totalparticipants_sah->num_rows(); ?>"],
        datasets: [{
          label: "Total Responden",
          backgroundColor: ["#3e95cd", "#8e5ea2"],
          data: [<?= $totalparticipants_sah->num_rows(); ?>, <?= $totalparticipants->num_rows() - $totalparticipants_sah->num_rows(); ?>]
        }]
      },
      options: {
        legend: {
          display: true,
          position: "right",

        }
      }
    });

  });
</script>

<script>
  var ctx = document.getElementById("myChart").getContext('2d');


  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [
        <?php foreach ($grafik as $grf) {
          echo '"' . $grf['date'] . '",';
        } ?>
      ],
      datasets: [{
        label: "Grafik Harian",
        // Name the series
        data: [<?php foreach ($grafik_total as $grfk) {
                  echo '"' . $grfk['total'] . '",';
                } ?>], // Specify the data values array
        fill: false,
        borderColor: '#2196f3', // Add custom color border (Line)
        backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
        borderWidth: 1 // Specify bar border width
      }]
    },
    options: {
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
    }
  });
</script>
<script>
  $("#dashboard").addClass('active');
  $("#dashboard").addClass('active');
</script>