<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-body">
        <div class="col-md-6">
          <h4><i class="fas fa-user-edit"></i> &nbsp; Ubah Data Pribadi Saya</h4>
        </div>
      
        
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
     
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body m-form-body">
          <?php if(isset($msg) || validation_errors() !== ''): ?>
              <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                  <?= validation_errors();?>
                  <?= isset($msg)? $msg: ''; ?>
              </div>
            <?php endif; ?>
            <?php echo form_open(base_url('admin/profile'), 'class="form-horizontal"' )?> 
              <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Username</label>

                <div class="col-sm-9">
                  <input type="text" name="username" value="<?php if(validation_errors()) {echo set_value('username'); } else { echo $user['username']; }  ?>" class="form-control" id="username" placeholder=""disabled>
                </div>
              </div>
              <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">Nama Lengkap</label>

                <div class="col-sm-9">
                  <input type="text" name="firstname" value="<?php if(validation_errors()) {echo set_value('firstname'); } else { echo $user['firstname']; }  ?>" class="form-control" id="firstname" placeholder="">
                </div>
              </div>  
              

              <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>

                <div class="col-sm-9">
                  <input  type="email" name="email" value="<?php if(validation_errors()) {echo set_value('email'); } else { echo $user['email']; }  ?>" class="form-control" id="email" placeholder="">
                </div>
              </div>

              <div class="form-group">
                <label for="mobile_no" class="col-sm-2 control-label">Telepon</label>

                <div class="col-sm-9">
                  <input  style="width:350px" type="number" name="mobile_no" value="<?php if(validation_errors()) {echo set_value('mobile_no'); } else { echo $user['mobile_no']; }  ?>" class="form-control" id="mobile_no" placeholder="">
                </div>
              </div>  

              <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Password</label>

                <div class="col-sm-9">
                  <input  style="width:350px" type="password" name="password" value="" class="form-control" id="password" placeholder="">

                  <input type="hidden" name="password_hidden" class="form-control" value="<?= $user['password']; ?>" id="password_hidden">
                </div>
              </div>  

              <!--<div class="form-group">
                <label for="foto_profil" class="col-sm-2 control-label">Foto Profil (jpg/png) 200x200px</label>

                <div class="col-sm-9">
                  <input  style="width:350px" type="file" name="foto_profil" value="" class="form-control" id="foto_profil">
                </div>
              </div> -->
               
              <hr>  
              <div class="form-group">
                <div class="col-md-11">
                  <input type="submit" name="submit" value="Ubah Data Pribadi" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close(); ?>
          </div>
          <!-- /.box-body -->
      </div>
    </div>
  </div>  

</section> 

<script>
  $("#pribadi").addClass('active');
  $("#pribadi .submenu_user_edit").addClass('active');

</script>