<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">

			<?php if (is_admin() == 1) {				
				$role='';
			?>
			<li id="dashboard" class="treeview">
				<a href="<?= base_url('admin/dashboard'); ?>">
					<i class="fas fa-tachometer-alt"></i><span> Dashboard</span>
				</a>
			</li>
			<?php } else {
				$role='visitor/';
			 ?>
			<li id="dashboard" class="treeview">
				<a href="<?= base_url('visitor/dashboard'); ?>">
					<i class="fas fa-tachometer-alt"></i><span> Dashboard</span>
				</a>
			</li>
			<?php } ?>

			<li class="header">KEUANGAN HAJI</li>
			<li id="alokasi_produk_perbankan" class="treeview">
				<a href="<?= base_url($role.'keuanganhaji'); ?>">
					<span>Alokasi Produk Perbankan</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="sebaran_dana_haji"><a
							href="<?= base_url($role.'keuanganhaji/sebaran_dana_haji'); ?>">Penempatan Dana
							Kelolaan di BPS-BPIH</a></li>
					<li class="posisi_penempatan_produk"><a
							href="<?= base_url($role.'keuanganhaji/posisi_penempatan_produk'); ?>">Dana
							Haji yang Ditempatkan</a></li>

				</ul>
			</li>

			<li id="alokasi_produk_investasi" class="treeview">
				<a href="<?= base_url($role.'keuanganhaji'); ?>">
					<span>Alokasi Produk Investasi</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">

					<li class="sukuk"><a href="<?= base_url($role.'keuanganhaji/sukuk_korporasi'); ?>">Sukuk</a></li>
					<li class="reksadana"><a
							href="<?= base_url($role.'keuanganhaji/reksadana_terproteksi_syariah'); ?>">Reksadana</a>
					</li>
					<li class="penyertaan_saham"><a href="<?= base_url($role.'keuanganhaji/penyertaan_saham'); ?>">Penyertaan
							Saham</a>
					</li>
					<li class="investasi_langsung"><a
							href="<?= base_url($role.'keuanganhaji/investasi_langsung'); ?>">Investasi
							Langsung</a></li>
					<li class="investasi_lainnya"><a href="<?= base_url($role.'keuanganhaji/investasi_lainnya'); ?>">Investasi
							Lainnya</a></li>
					<li class="emas"><a href="<?= base_url($role.'keuanganhaji/emas'); ?>">Emas</a></li>

				</ul>
			</li>

			<li id="nilai_manfaat" class="treeview">
				<a href="#">
					<span>Nilai Manfaat</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="per_instrumen"><a
							href="<?= base_url($role.'keuanganhaji/nilaimanfaat/per_instrumen'); ?>">Produk
							Investasi</a></li>
					<!-- <li class="penempatan_di_bpsbpih"><a href="<?= base_url($role.'keuanganhaji/nilaimanfaat/penempatan_di_bpsbpih'); ?>">Nilai Manfaat Hasil<br> Penempatan di BPS-BPIH</a></li>-->
					<li class="produk"><a href="<?= base_url($role.'keuanganhaji/nilaimanfaat/produk'); ?>">Produk
							Penempatan</a></li>
				</ul>
			</li>

			<li id="alokasi">
				<a href="<?= base_url($role.'keuanganhaji/alokasi'); ?>">
					<span>Alokasi Investasi BPKH</span>
				</a>
			</li>

			<li class="header">LAPORAN KEUANGAN HAJI</li>
			<li id="neraca" class="treeview">
				<a href="<?= base_url($role.'laporankeuangan/neraca'); ?>">
					<span>Neraca</span>
				</a>
			</li>
			<li id="operasional" class="treeview">
				<a href="#">
					<span>Operasional</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="lap_bulanan"><a href="<?= base_url($role.'laporankeuangan/lap_bulanan'); ?>"> &nbsp;Bulanan</a>
					</li>
					<li class="lap_akumulasi"><a href="<?= base_url($role.'laporankeuangan/lap_akumulasi'); ?>">
							&nbsp;Akumulasi</a>
					</li>
				</ul>
			</li>
			<li id="perubahan_asetneto">
				<a href="<?= base_url($role.'laporankeuangan/perubahan_asetneto'); ?>">
					<span>Perubahan Aset Neto</span>
				</a>
			</li>
			<li id="lap_arus_kas">
				<a href="<?= base_url($role.'laporankeuangan/lap_arus_kas'); ?>">
					<span>Laporan Arus Kas</span>
				</a>
			</li>
			<li id="realisasi_anggaran">
				<a href="<?= base_url($role.'laporankeuangan/realisasi_anggaran'); ?>">
					<span>Laporan Realisasi Anggaran</span>
				</a>
			</li>
			<li class="header">PROGRAM KEMASLAHATAN</li>
			<li id="kemaslahatan">
				<a href="<?= base_url($role.'kemaslahatan'); ?>"><span>Lap. Realisasi Kemaslahatan</span></a>
			</li>

			<li id="regulasi_kemaslahatan">
				<a href="<?= base_url($role.'kemaslahatan/regulasi_tentang_kemaslahatan'); ?>"><span>Regulasi Tentang
						Kemaslahatan
					</span></a>
			</li>
			<li class="header">LAPORAN KINERJA</li>
			<li id="pencapaian_perbidang">
				<a href="<?= base_url($role.'laporankinerja/pencapaian_perbidang'); ?>">
					<span>Pencapaian Output per-Bidang</span>
				</a>
			</li>
			<li id="penyerapan_perbidang">
				<a href="<?= base_url($role.'laporankinerja/penyerapan_perbidang'); ?>">
					<span> Penyerapan Anggaran per-Bidang</span>
				</a>
			</li>
			<li class="header">DATA MAKRO EKONOMI</li>
			<li id="makro" class="treeview">
				<a href="#">
					<span>Makro Ekonomi</span>
					<span class="pull-right-container">
						<i class="fas fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="laporan_industri_keuangan_syariah"><a
							href="<?= base_url($role.'makro/laporan_industri_keuangan_syariah'); ?>">Laporan Industri Keuangan
							Syariah</a>
					</li>
					<li class="gdp_ina"><a href="<?= base_url($role.'makro/gdp_ina'); ?>">Pertumbuhan GDP Indonesia </a></li>
					<li class="gdp_ksa"><a href="<?= base_url($role.'makro/gdp_ksa'); ?>">Pertumbuhan GDP KSA </a></li>
					<li class="inflasi"><a href="<?= base_url($role.'makro/inflasi'); ?>">Inflasi Tahunan</a></li>
					<li class="indeks_saham_syariah"><a href="<?= base_url($role.'makro/indeks_saham_syariah'); ?>">Indeks
							Saham
							Syariah</a></li>
					<li class="harga_avtur"><a href="<?= base_url($role.'makro/harga_avtur'); ?>">Harga Avtur</a></li>
					<li class="suku_bunga_lps"><a href="<?= base_url($role.'makro/suku_bunga_lps'); ?>">Suku Bunga LPS</a>
					</li>
					<li class="yield_sukuk_negara"><a href="<?= base_url($role.'makro/yield_sukuk_negara'); ?>">Yield Sukuk
							Negara</a>
					</li>
					<li class="harga_emas"><a href="<?= base_url($role.'makro/harga_emas'); ?>">Harga Emas</a></li>
				</ul>
			</li>

			<li class="header">BPIH</li>

			<li id="datajemaah" class="treeview">
				<a href="#">
					<span>Data Jemaah</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="antri"><a href="<?= base_url($role.'datajemaah/antri'); ?>"> &nbsp;Data Jemaah Antri</a></li>
					<li class="kuota"><a href="<?= base_url($role.'datajemaah/kuota'); ?>"> &nbsp;Kuota Jemaah Berangkat</a>
					</li>
					<li class="batal"><a href="<?= base_url($role.'datajemaah/batal'); ?>"> &nbsp;Data Jemaah Batal</a></li>
					<li class="bpih"><a href="<?= base_url($role.'datajemaah/realisasi_bpih'); ?>"> &nbsp;Realisasi BIPIH &
							BPIH</a>
					</li>
				</ul>
			</li>

			<li class="header">INFORMASI NON KEUANGAN BPKH</li>
			<li id="dokumen" class="treeview">
				<a href="#">
					<i class="fa fa-file-pdf"></i>
					<span>Dokumen</span>
					<span class="pull-right-container">
						<i class="fas fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="regulasi"><a href="<?= base_url($role.'nonkeuanganbpkh/dokumen/regulasi'); ?>">Regulasi</a>
					</li>
					<li class="sdm"><a href="<?= base_url($role.'nonkeuanganbpkh/dokumen/sdm'); ?>">SDM</a></li>
					<li class="aset_nontunai"><a href="<?= base_url($role.'nonkeuanganbpkh/dokumen/aset_nontunai'); ?>">Aset
							Non
							Tunai</a></li>
					<li class="survey"><a
							href="<?= base_url($role.'nonkeuanganbpkh/dokumen/survey'); ?>"><span>Survey</span></a></li>
					<li class="kajian"><a
							href="<?= base_url($role.'nonkeuanganbpkh/dokumen/kajian'); ?>"><span>Kajian</span></a></li>
					<li class="laporan_kinerja"><a
							href="<?= base_url($role.'nonkeuanganbpkh/dokumen/laporan_kinerja'); ?>"><span>Laporan
								Kinerja</span></a></li>
					<li class="materi_video_dan_paparan"><a
							href="<?= base_url($role.'nonkeuanganbpkh/dokumen/materi_video_dan_paparan'); ?>"><span>Materi
								Video dan
								Paparan</span></a></li>
				</ul>
			</li>

			<?php if (is_admin() == 1) { ?>
			<li id="users" class="staf">
				<a href="<?= base_url($role.'admin/users'); ?>">
					<i class="fa fa-users"></i> <span>Staf BPKH</span>
				</a>
			</li>
			<?php } ?>
		</ul>

	</section>
	<!-- /.sidebar -->
</aside>
