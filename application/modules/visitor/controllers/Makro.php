<?php defined('BASEPATH') or exit('No direct script access allowed');

class Makro extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('makro/makro_model', 'makro_model');
	}

	public function index($tahun = 0)
	{
		$data['view'] = 'makro/index';
		$this->load->view('admin/layout', $data);
	}

	public function gdp_ina()
	{
		$data['gdp_ina'] = $this->makro_model->get_gdp_ina();
		$data['view'] = 'makro/gdp_ina';
		$this->load->view('admin/layout', $data);
	}

	public function gdp_ksa()
	{
		$data['gdp_ksa'] = $this->makro_model->get_gdp_ksa();
		$data['view'] = 'makro/gdp_ksa';
		$this->load->view('admin/layout', $data);
	}

	// INFLASI

	public function inflasi()
	{
		$data['inflasi'] = $this->makro_model->get_inflasi();
		$data['view'] = 'makro/inflasi';
		$this->load->view('admin/layout', $data);
	}

	

	// HARGA EMAS
	public function harga_emas()
	{
		$data['harga_emas'] = $this->makro_model->get_harga_emas();
		$data['view'] = 'makro/harga_emas';
		$this->load->view('admin/layout', $data);
	}

	

	public function indeks_saham_syariah()
	{
		$data['indeks_saham_syariah'] = $this->makro_model->get_indeks_saham_syariah();
		$data['view'] = 'makro/indeks_saham_syariah';
		$this->load->view('admin/layout', $data);
	}

	

	// harga avtur 

	public function harga_avtur()
	{
		$data['harga_avtur'] = $this->makro_model->get_harga_avtur();
		$data['view'] = 'makro/harga_avtur';
		$this->load->view('admin/layout', $data);
	}

	

	// SB LPS
	public function suku_bunga_lps()
	{
		$data['suku_bunga_lps'] = $this->makro_model->get_suku_bunga_lps();
		$data['view'] = 'makro/suku_bunga_lps';
		$this->load->view('admin/layout', $data);
	}

	

	// YIELD
	public function yield_sukuk_negara()
	{
		$data['yield_sukuk_negara'] = $this->makro_model->get_yield_sukuk_negara();
		$data['view'] = 'makro/yield_sukuk_negara';
		$this->load->view('admin/layout', $data);
	}


	// nilai manfaat regulasi
	public function laporan_industri_keuangan_syariah($kategori = 0)
	{

		$kategori = ($kategori != '') ? $kategori : '';


		$data['dokumen'] = $this->makro_model->get_laporan_industri_keuangan_syariah($kategori);

		$data['view'] = 'makro/laporan_industri_keuangan_syariah';
		$this->load->view('admin/layout', $data);
	}

} //class
