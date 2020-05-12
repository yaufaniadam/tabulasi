<?php //get las URI
    $last = $this->uri->total_segments();
	$id = $this->uri->segment($last);	 
?>
<section class="content-header">
	<h1><i class="fa fa-file-pdf"></i> &nbsp; Dokumentasi</h1>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			
			<div class="box">
				<div class="box-header with-border">
                    <h4>Dokumentasi Kegiatan Kemaslahatan pada  <?php echo $nama_penerima['nama_penerima']; ?></h4>
				</div>
				<div class="box-body smy-form-body">
                    <div class="row">
                    <?php if($dokumentasi) { ?>
                        <?php foreach($dokumentasi as $dok) { ?>  
                            <div class="col-md-4">
                            <img src="<?=base_url($dok['foto']);?>" alt="<?=$dok['judul_foto']; ?>" class="img-thumbnail">
                            </div>
                        <?php }?>
                    <?php } else {  echo "Belum ada dokumentasi.";  }?>
                    </div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$("#kemaslahatan").addClass('active');

</script>
