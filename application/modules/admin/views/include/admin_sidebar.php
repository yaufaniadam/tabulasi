<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li id="dashboard" class="treeview">
				<a href="<?= base_url('admin/dashboard'); ?>">
					<i class="fas fa-tachometer-alt"></i><span> Dashboard</span>
				</a>
			</li>


			<li id="alokasi_produk_perbankan" class="treeview">
				<a href="<?= base_url('keuanganhaji'); ?>">
					<span>Survey</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="sebaran_dana_haji"><a href="<?= base_url('keuanganhaji/sebaran_dana_haji'); ?>">Penempatan Dana
							Kelolaan di BPS-BPIH</a></li>
					<li class="posisi_penempatan_produk"><a href="<?= base_url('keuanganhaji/posisi_penempatan_produk'); ?>">Dana
							Haji yang Ditempatkan</a></li>

				</ul>
			</li>

			<li id="users" class="staf">
				<a href="<?= base_url('admin/users'); ?>">
					<i class="fa fa-users"></i> <span>Manajemen Pengguna</span>
				</a>
			</li>
		</ul>

	</section>
	<!-- /.sidebar -->
</aside>