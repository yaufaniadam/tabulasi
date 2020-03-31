<?php 
$cur_tab = $this->uri->segment(2)==''?'dashboard': $this->uri->segment(2);  
?>  

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">      
    
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li id="dashboard" class="treeview">
          <a href="<?= base_url('admin/dashboard'); ?>">
            <i class="fa fa-home"></i> <span>Beranda</span>            
          </a>         
        </li>
      </ul>
     
      <!-- Menu admin -->
      <?php if(is_admin() == 1) { ?>

        <ul class="sidebar-menu">
          <li class="header">KEUANGAN HAJI</li>
          
            <li id="pengelolaan_keuangan_haji" class="treeview">
              <a href="<?= base_url('keuanganhaji'); ?>">
                <span>Pengelolaan Keu. Haji</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">                  
               
                   <li class="sebaran_dana_haji"><a href="<?= base_url('keuanganhaji/sebaran_dana_haji'); ?>">Posisi Sebaran Dana Haji</a></li>
                   <li class="sdhi_rupiah"><a href="<?= base_url('keuanganhaji/sdhi_rupiah'); ?>">SBN - SDHI Rupiah</a></li>
                   <li class="sbssn_rupiah"><a href="<?= base_url('keuanganhaji/sbssn_rupiah'); ?>">SBN - SBSSN Rupiah</a></li>
                   <li class="sbssn_usd"><a href="<?= base_url('keuanganhaji/sbssn_usd'); ?>">SBN - SBSSN USD</a></li>
                   <li class="sukuk_korporasi"><a href="<?= base_url('keuanganhaji/sukuk_korporasi'); ?>">Sukuk Korporasi</a></li>
                   <li class="reksadana_terproteksi_syariah"><a href="<?= base_url('keuanganhaji/reksadana_terproteksi_syariah'); ?>">Reksadana Terproteksi Syariah</a></li>
                   <li class="reksadana_pasar_uang_syariah"><a href="<?= base_url('keuanganhaji/reksadana_pasar_uang_syariah'); ?>">Reksadana Pasar Uang Syariah</a></li>
                   <li class="penyertaan_saham"><a href="<?= base_url('keuanganhaji/penyertaan_saham'); ?>">Penyertaan Saham</a></li>
                   <li class="investasi_langsung"><a href="<?= base_url('keuanganhaji/investasi_langsung'); ?>">Investasi Langsung</a></li>
                   <li class="investasi_lainnya"><a href="<?= base_url('keuanganhaji/investasi_lainnya'); ?>">Investasi Lainnya</a></li>
                   <li class="emas"><a href="<?= base_url('keuanganhaji/emas'); ?>">Emas</a></li>
                
                </ul>
            </li>  

            <li id="akumulasi_kontribusi_bpsbpih">
              <a href="<?= base_url('keuanganhaji/akumulasi_kontribusi_bpsbpih'); ?>">
                <span>Akumulasi Kontribusi BPS BPIH</span>
              </a>
            </li>

            <li id="posisi_penempatan_produk">
              <a href="<?= base_url('keuanganhaji/posisi_penempatan_produk'); ?>">
                <span>Posisi Penempatan Produk</span>
              </a>
            </li>

            <li id="nilai_manfaat" class="treeview">
              <a href="#">
                <span>Nilai Manfaat Investasi</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">   
                   <li class="per_instrumen"><a href="<?= base_url('keuanganhaji/nilaimanfaat/per_instrumen'); ?>">Nilai Manfaat Investasi<br>per-Instrumen</a></li>
                   <li class="penempatan_di_bpsbpih"><a href="<?= base_url('keuanganhaji/nilaimanfaat/penempatan_di_bpsbpih'); ?>">Nilai Manfaat Hasil<br> Penempatan di BPS-BPIH</a></li>
                   <li class="produk"><a href="<?= base_url('keuanganhaji/nilaimanfaat/produk'); ?>">Nilai Manfaat Hasil <br>Penempatan berdasarkan Produk</a></li>         
                </ul>
            </li>

            <li id="pos_tertentu" class="treeview">
              <a href="#">
                <span>Pos Tertentu Investasi</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">   
                   <li class="portfolio_investasi"><a href="<?= base_url('keuanganhaji/postertentu/portfolio_investasi'); ?>">Portfolio Investasi BPKH </a></li>
                   <li class="manfaat_investasi"><a href="<?= base_url('keuanganhaji/postertentu/manfaat_investasi'); ?>">Nilai Manfaat Investasi BPKH </a></li>
                          
                </ul>
            </li>  


             <li id="alokasi">
              <a href="<?= base_url('keuanganhaji/alokasi'); ?>">
                <span>Alokasi Investasi BPKH</span>
              </a>       
            </li>  
            <li class="header">LAPORAN KEUANGAN HAJI</li>
             <li id="neraca" class="treeview">
              <a href="<?= base_url('laporankeuangan/neraca'); ?>">
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
                  <li class="lap_bulanan"><a href="<?= base_url('laporankeuangan/lap_bulanan'); ?>"> &nbsp;Bulanan</a></li>
                  <li class="lap_akumulasi"><a href="<?= base_url('laporankeuangan/lap_akumulasi'); ?>"> &nbsp;Akumulasi</a></li>        
                </ul>          
            </li>  
            <li id="perubahan_asetneto">
              <a href="<?= base_url('laporankeuangan/perubahan_asetneto'); ?>">
                <span>Perubahan Aset Neto</span>             
              </a>
                        
            </li>  
            <li class="header">PROGRAM KEMASLAHATAN</li>
            <li id="kemaslahatan">
              <a href="<?= base_url('kemaslahatan'); ?>"><span>Program Kemaslahatan</span></a>        
            </li> 

          
            <li class="header">BPIH</li>
            <li id="realisasi_anggaran">
              <a href="<?= base_url('bpih/realisasi_anggaran'); ?>">
                <span>Laporan Realisasi Anggaran</span>
              </a>                    
            </li>
            <li id="pencapaian_perbidang">
              <a href="<?= base_url('bpih/pencapaian_perbidang'); ?>">
                <span>Pencapaian Output per-Bidang</span>
              </a>                    
            </li>  
            <li id="penyerapan_perbidang">
              <a href="<?= base_url('bpih/penyerapan_perbidang'); ?>">
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
                  
                  <li class="gdp_ina"><a href="<?= base_url('makro/gdp_ina'); ?>">Pertumbuhan GDP Indonesia </a></li>
                  <li class="gdp_ksa"><a href="<?= base_url('makro/gdp_ksa'); ?>">Pertumbuhan GDP KSA </a></li>
                  <li class="inflasi"><a href="<?= base_url('makro/inflasi'); ?>">Inflasi Tahunan</a></li>
                <!--  <li class="kurs"><a href="<?= base_url('makro/kurs'); ?>">Kurs IDR/USD</a></li>
                  <li class="kurs"><a href="<?= base_url('makro/kurs'); ?>">Kurs IDR/SAR</a></li>-->
                  <li class="indeks_saham_syariah"><a href="<?= base_url('makro/indeks_saham_syariah'); ?>">Indeks Saham Syariah</a></li>
                  <li class="harga_avtur"><a href="<?= base_url('makro/harga_avtur'); ?>">Harga Avtur</a></li>
                  <li class="suku_bunga_lps"><a href="<?= base_url('makro/suku_bunga_lps'); ?>">Suku Bunga LPS</a></li>
                  <li class="yield_sukuk_negara"><a href="<?= base_url('makro/yield_sukuk_negara'); ?>">Yield Sukuk Negara</a></li>
                  <li class="harga_emas"><a href="<?= base_url('makro/harga_emas'); ?>">Harga Emas</a></li>   
                </ul>
            </li>        
                
            <li class="header">INTERNAL BPKH</li>          
            <li id="dokumen" class="treeview">
              <a href="#">
                <i class="fa fa-file-pdf"></i> 
                <span>Dokumen</span>
                <span class="pull-right-container">
                <i class="fas fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">                  
                  <li class="regulasi"><a href="<?= base_url('internalbpkh/dokumen/regulasi'); ?>">Regulasi</a></li>
                  <li class="sdm"><a href="<?= base_url('internalbpkh/dokumen/sdm'); ?>">SDM</a></li>
                  <li class="aset_nontunai"><a href="<?= base_url('internalbpkh/dokumen/aset_nontunai'); ?>">Aset Non Tunai</a></li> 
                  <li class="survey"><a href="<?= base_url('internalbpkh/dokumen/survey'); ?>"><span>Survey</span></a></li>
                  <li class="kajian"><a href="<?= base_url('internalbpkh/dokumen/kajian'); ?>"><span>Kajian</span></a></li>   
                    
                </ul>
            </li>
            <li id="users" class="staf">
              <a href="<?= base_url('admin/users'); ?>">
                <i class="fa fa-users"></i> <span>Staf BPKH</span>            
              </a>         
            </li>          
                     
        </ul>  

      <?php } else   { ?>


      <?php } ?>
    </section>
    <!-- /.sidebar -->
  </aside>

  
<script>
  $("#<?= $cur_tab ?>").addClass('active');
</script>
