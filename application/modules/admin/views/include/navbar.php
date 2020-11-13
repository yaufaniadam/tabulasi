<header class="main-header">
	<!-- Logo -->
	<a href="<?= base_url((is_admin() == 1) ? 'admin/dashboard' : 'visitor/dashboard'); ?>" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><img style="padding:10px 10px 10px 0;" width="130" height="" src="<?= base_url() ?>public/dist/img/logo-bpkh-small.png" alt="Database Ekonomi dan Keuangan BPKH"></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><img style="padding:10px 10px 10px 0;" width="200" height="" src="<?= base_url() ?>public/dist/img/logo-bpkh-w.png" alt="Database Ekonomi dan Keuangan BPKH"></span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<i class="fa fa-bars"></i>
		</a>
		<div class="navbar-custom-menu">
			<h4 style="color:#ffffff; margin-right:20px;">E Survei BPKH</h4>

		</div>
	</nav>
</header>