<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Dashboard <a href="<?= base_url('admin/dashboard/tambah'); ?>" class="btn btn-warning btn-sm"><i
				class="fas fa-plus"></i>&nbsp; Tambah Data</a>
  </h1>
  
</section>

<!-- Main content -->
<section class="content">

<?php if($result) { ?>
	<div class="row">
		<div class="col-md-12">
			<!-- DONUT CHART -->
			<div class="box">
				<div class="box-body">
					<!--<h3 class="text-center">IKHTISAR KEUANGAN LAPORAN PERTANGGUNGJAWABAN <br> PELAKSANAAN PENGELOLAAN KEUANGAN
						KEUANGAN HAJI BPKH TAHUN </h3>-->
					<h3 class="text-center" style="text-transform:uppercase">Total Dana Kelolaan Per <?=$result['periode']; ?> <?=$result['tahun']; ?></h3>
					<h2 class="text-center alert alert-info btn-lg" style="font-size:4rem;">Rp<?=$result['total']; ?></h2>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<!-- DONUT CHART -->
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Penempatan Rp<?=$result['penempatan']; ?></h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
          <canvas id="penempatan" style="height:200px"></canvas>          
          <p class="text-center" style="margin-top:50px;">
            <a href="<?= base_url('keuanganhaji/porsi_penempatan_bps_bpih/'); ?>" class="btn btn-md btn-warning">
            Lihat Porsi Penempatan</a>        
          </p>
         
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->

		</div>
	
      	<!-- /.col (LEFT) -->
		<div class="col-md-6">

      <!-- BAR CHART -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Investasi Rp<?=$result['investasi']; ?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="investasi" style="height:230px"></canvas>

            <p class="text-center" style="margin-top:50px;">
              <a href="<?= base_url('keuanganhaji/sbssn_rupiah/'); ?>" class="btn btn-md btn-success">Lihat Porsi
              Investasi</a>       
            </p>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </div>
		<div class="col-md-12">

      <!-- BAR CHART -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Tahun Lainnya</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <ul style="list-style: none;">
              <?php foreach($all_grafik as $row) {
                echo '<li style="padding:5px">
                <a class="btn btn-md btn-warning" href="'.base_url('admin/dashboard/index/'. $row['tahun']).'">'.$row['tahun'] .'</a> 
                <a title="Hapus" class="btn btn-xs btn-danger" href="'.base_url('admin/dashboard/hapus/'. $row['tahun']).'"><i class="fas fa-trash"></i></a></li>';
              } ?>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </div>
	
	</div>
  <!-- /.row -->
  
 <?php } else {
     echo "belum ada data";
  }
  ?>

</section>
<!-- /.content -->

<!-- ChartJS 1.0.1 -->
<script src="<?= base_url() ?>public/plugins/chartjs/Chart.min.js"></script>
<script src="<?= base_url() ?>public/plugins/chartjs/utils.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>public/plugins/fastclick/fastclick.js"></script>
<!-- page script -->
<script>
	$(function () {
    new Chart(document.getElementById("penempatan"), {
    type: 'pie',
    data: {
      labels: ["Setoran Awal (Rp<?=$result['setoran_awal']; ?>)", "Setoran Lunas (Rp<?=$result['setoran_lunas']; ?>)", "Nilai Manfaat (Rp<?=$result['nilai_manfaat']; ?>)", "DAU (Rp<?=$result['dau']; ?>)"],
      datasets: [{
        label: "Penempatan",
        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
        data: [<?=$result['setoran_awal_per']; ?>,<?=$result['setoran_lunas_per']; ?>,<?=$result['nilai_manfaat_per']; ?>,<?=$result['dau_per']; ?>]
      }]
    },
    options: {
      legend: {
            display: true,
            position : "right",
           
        }
    }
    });
        new Chart(document.getElementById("investasi"), {
        type: 'pie',
        data: {
          labels: ["Setoran Awal (Rp<?=$result['setoran_awal_inv']; ?>)", "DAU (Rp<?=$result['dau_inv']; ?>)"],
          datasets: [{
            label: "Investasi",
            backgroundColor: ["#4ad840","#c5c146"],
            data: [<?=$result['setoran_awal_inv_per']; ?>,<?=$result['dau_inv_per']; ?>]
          }]
        },
        options: {
          legend: {
            display: true,
            position : "right",           
          }
        }
    });
	}); 

</script>

<script>
	$("#charts").addClass('active');
	$("#chartjs").addClass('active');
</script>
