  
<section class="content">
	<div class="row">
	    <div class="col-md-12">
		    <div class="box box-body">
		        <div class="col-md-6">
		    	    <h4><i class="fa fa-user"></i> &nbsp; Profil <?= $user['firstname']; ?></h4>
		        </div>        
		    </div>
	    </div>
	</div> 


  	<div class="row">
	    <div class="col-md-12">
	      	<div class="box box-body">
		        <div class="col-md-6">
			        <table class="table table-striped table-bordered">
			          	<tr>
			                <td style="width:200px;">Nama Lengkap</td>
			                <td><?= $user['firstname']; ?></td>
			            </tr>             
			            <tr>
			            	<td>Email</td>
			                <td><?= $user['email']; ?></td>
			            </tr>
			            <tr>
			            	<td>Mobile Number</td>
			                <td><?= $user['mobile_no']; ?></td>
			            </tr>
			        	</table>
		        </div>        
	      	</div>
	    </div>
	</div> 
</section>

<script>
    $("#pengguna").addClass('active');
    $("#pengguna .submenu_userlist").addClass('active');
</script>
