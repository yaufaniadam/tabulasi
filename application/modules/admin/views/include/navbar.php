<header class="main-header">
	<!-- Logo -->
	<a href="<?= base_url((is_admin()==1) ? 'admin/dashboard' : 'visitor/dashboard'); ?>" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><img style="padding:10px 10px 10px 0;" width="130" height=""
				src="<?= base_url() ?>public/dist/img/logo-bpkh-small.png" alt="Database Ekonomi dan Keuangan BPKH"></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><img style="padding:10px 10px 10px 0;" width="200" height=""
				src="<?= base_url() ?>public/dist/img/logo-bpkh-w.png" alt="Database Ekonomi dan Keuangan BPKH"></span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<i class="fa fa-bars"></i>
		</a>
		<div class="navbar-custom-menu">

			<ul class="nav navbar-nav">

				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="<?php echo base_url('admin/profile');  ?>">
						<i class="fas fa-user"></i> &nbsp;
						<span class="hidden-xs"><?= getUserbyId($this->session->userdata('user_id')); ?></span>
					</a>
				</li>
				<li class="dropdown user user-menu">
					<a href="<?= site_url('auth/logout'); ?>">
						<i class="fas fa-sign-out-alt"></i> &nbsp;
						<span class="hidden-xs">Log out</span>
					</a>
				</li>
				<!-- Control Sidebar Toggle Button -->
				<li>
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
				</li>
			</ul>
		</div>
	</nav>
</header>
