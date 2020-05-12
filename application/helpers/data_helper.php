<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


// -----------------------------------------------------------------------------
function get_jenis_investasi($id)
{

    $CI = &get_instance();
    return $CI->db->get_where('jenis_penempatan', array('id' => $id))->row_array()['jenis_penempatan'];
}

// -----------------------------------------------------------------------------



// -----------------------------------------------------------------------------
function getUserbyId($id)
{

    $CI = &get_instance();
    return $CI->db->get_where('ci_users', array('id' => $id))->row_array()['firstname'];
}

function is_admin()
{
    $CI = &get_instance();
    $admin = $CI->session->userdata('role', 1);
    return $admin;
}

function transposeData($data)
{
    $retData = array();
    foreach ($data as $row => $columns) {
        foreach ($columns as $row2 => $column2) {
            $retData[$row2][$row] = $column2;
        }
    }
    return $retData;
}

function konversi_bulan_ke_angka($bulan)
{
    $lcase = strtolower($bulan);

    if ($lcase == "januari") {
        $bulan = 1;
    } elseif ($lcase == "februari") {
        $bulan = 2;
    } elseif ($lcase == "maret") {
        $bulan = 3;
    } elseif ($lcase == "april") {
        $bulan = 4;
    } elseif ($lcase == "mei") {
        $bulan = 5;
    } elseif ($lcase == "juni") {
        $bulan = 6;
    } elseif ($lcase == "juli") {
        $bulan = 7;
    } elseif ($lcase == "agustus") {
        $bulan = 8;
    } elseif ($lcase == "september") {
        $bulan = 9;
    } elseif ($lcase == "oktober") {
        $bulan = 10;
    } elseif ($lcase == "november") {
        $bulan = 11;
    } else {
        $bulan = 12;
    }

    return $bulan;
}

function get_sebaran_dana_haji_by_bpih($bpih, $bulan, $tahun)
{
    $CI = &get_instance();
    $CI->db->select('jumlah');
    $CI->db->from('sebaran_dana_haji');
    $CI->db->where('bulan', $bulan);
    $CI->db->where('tahun', $tahun);
    $CI->db->where('bps_bpih', $bpih);

    $query = $CI->db->get();

    if ($query->num_rows() > 0) {
        echo $query->row()->jumlah;
    } else {
        echo "-";
    }
}

//bhs indo
function konversitanggalmysqlformat($tanggal)
{
    $explode = explode(" ", $tanggal);

    $month = konversi_bulan_ke_angka($explode[1]);
    $date = $explode[2] . "-" . $month . "-" . $explode[0];

    $datesql = DateTime::createFromFormat('Y-m-d', $date);
    $result = $datesql->format('Y-m-d');

    return $result;
}

//bhs english
function konversitanggalmysqlformat_en($tanggal)
{

    $datesql = DateTime::createFromFormat('d F Y', $tanggal);
    $result = $datesql->format('Y-m-d');

    return $result;
}

function konversitanggalpanjang($tanggal)
{

    $datesql = DateTime::createFromFormat('Y-m-d', $tanggal);
    $result = $datesql->format('j F Y');
    setlocale(LC_ALL, 'id_ID');

    return $result;
}

function konversiTanggalAngkaKeNama($tanggal)
{

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}

function konversiBulanAngkaKeNama($tanggal)
{

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );

    return  $bulan[$tanggal];
}

function konversiAngkaKeHuruf($angka)
{

    $huruf = array(
        1 =>   'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P'
    );

    return  $huruf[$angka];
}
/*
    function breadcrumb( $dir, $tahun, $thn) { 
        $CI = & get_instance();  
        ?>

<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Pilih tahun </a></li>

	<?php foreach($tahun as $tahun) {

          if ($tahun['tahun'] == $thn ) { ?>
	<li class="breadcrumb-item active" aria-current="page"> <?=$tahun['tahun']; ?></li>
	<?php } else { ?>
	<li><a
			href="<?=base_url($dir."/".$CI->router->fetch_class().'/' . $CI->router->fetch_method() .'/'. $tahun['tahun']); ?>">
			<?=$tahun['tahun']; ?></a></li>
	<?php } //endif
        } // end foreach ?>

</ol>

<?php
    } */

function breadcrumb($dir, $tahun, $thn)
{
    $CI = &get_instance();
?>

    <div class="btn-group" role="group" style="margin-bottom: 20px;">

        <a class="btn btn-md btn-default">Pilih tahun</a>

        <?php foreach ($tahun as $tahun) {
            if ($tahun['tahun'] !== '') {
        ?>
                <a href="<?= base_url($dir . "/" . $CI->router->fetch_class() . '/' . $CI->router->fetch_method() . '/' . $tahun['tahun']); ?>" class="btn btn-md <?= ($tahun['tahun'] == $thn) ? "disabled btn-success" : "btn-default" ?>"><?= $tahun['tahun']; ?></a>

        <?php }
        } // end foreach 
        ?>
    </div>
<?php
}

function menu_sukuk()
{

    $CI = &get_instance();

?>

    <div class="btn-group" role="group" style="margin-bottom: 20px;">

        <a href="<?= base_url(((is_admin() == 1) ? '': 'visitor/') . 'keuanganhaji/sbssn_rupiah/'); ?>" class="btn btn-md <?= ($CI->router->fetch_method() == 'sbssn_rupiah') ? "btn-info disabled" : "btn-default"; ?>">Sukuk
            SBSN Rupiah</a>
        <a href="<?= base_url(((is_admin() == 1) ? '': 'visitor/') . 'keuanganhaji/sbssn_usd/'); ?>" class="btn btn-md <?= ($CI->router->fetch_method() == 'sbssn_usd') ? "btn-info disabled" : "btn-default"; ?>">Sukuk
            SBSN USD</a>
        <a href="<?= base_url(((is_admin() == 1) ? '': 'visitor/') . 'keuanganhaji/sdhi_rupiah/'); ?>" class="btn btn-md <?= ($CI->router->fetch_method() == 'sdhi_rupiah') ? "btn-info disabled" : "btn-default"; ?>">Sukuk
            SDHI Rupiah</a>
        <a href="<?= base_url(((is_admin() == 1) ? '': 'visitor/') . 'keuanganhaji/sukuk_korporasi/'); ?>" class="btn btn-md <?= ($CI->router->fetch_method() == 'sukuk_korporasi') ? "btn-info disabled" : "btn-default"; ?>">Sukuk
            Korporasi</a>



    </div>


<?php
}

function menu_reksadana()
{

    $CI = &get_instance();

?>

    <div class="btn-group" role="group" style="margin-bottom: 20px;">

        <a href="<?= base_url(((is_admin() == 1) ? '': 'visitor/') . 'keuanganhaji/reksadana_terproteksi_syariah/'); ?>" class="btn btn-md <?= ($CI->router->fetch_method() == 'reksadana_terproteksi_syariah') ? "btn-info disabled" : "btn-default"; ?>">Terproteksi
            Syariah</a>
        <a href="<?= base_url(((is_admin() == 1) ? '': 'visitor/') . 'keuanganhaji/reksadana_pasar_uang_syariah/'); ?>" class="btn btn-md <?= ($CI->router->fetch_method() == 'reksadana_pasar_uang_syariah') ? "btn-info disabled" : "btn-default"; ?>">Pasar
            Uang Syariah</a>


    </div>


<?php
}

function menu_non_dau()
{

    $CI = &get_instance();

?>

    <div class="btn-group" role="group" style="margin-bottom: 20px;">

        <a href="<?= base_url('keuanganhaji/porsi_penempatan_bps_bpih/'); ?>" class="btn btn-md <?= ($CI->router->fetch_method() == 'porsi_penempatan_bps_bpih') ? "btn-info disabled" : "btn-default"; ?>">Porsi
            Penempatan di Bank BPS-BPIH</a>
        <a href="<?= base_url('keuanganhaji/sbssn_rupiah/'); ?>" class="btn btn-md <?= ($CI->router->fetch_method() == 'porsi_investasi') ? "btn-info disabled" : "btn-default"; ?>">Porsi
            Investasi</a>


    </div>


<?php
}
