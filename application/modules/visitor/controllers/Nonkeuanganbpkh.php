<?php defined('BASEPATH') or exit('No direct script access allowed');
class Nonkeuanganbpkh extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('nonkeuanganbpkh/nonkeuanganbpkh_model', 'nonkeuanganbpkh_model');
	}

	public function index()
	{
		$data['view'] = 'nonkeuanganbpkh/index';
		$this->load->view('admin/layout', $data);
	}

	// nilai manfaat regulasi
	public function dokumen($kategori = 0)
	{

		$kategori = ($kategori != '') ? $kategori : '';


		$data['dokumen'] = $this->nonkeuanganbpkh_model->get_dokumen($kategori);

		$data['view'] = 'nonkeuanganbpkh/dokumen';
		$this->load->view('admin/layout', $data);
	}
} //class
