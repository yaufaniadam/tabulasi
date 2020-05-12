<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/dashboard_model', 'dashboard_model');
		$this->load->library('excel');
	}

	public function index($tahun=0)
	{
		if ($tahun =='') {

		$query = $this->db->query('SELECT * from dashboard ORDER BY id DESC limit 1');

		} else {
			$query = $this->db->query("SELECT * from dashboard WHERE tahun='$tahun' ORDER BY id DESC limit 1");
		}

		$data['result'] = $query->row_array();

		$all_grafik = $this->db->query('SELECT * from dashboard ORDER BY id DESC');

		$data['all_grafik'] = $all_grafik->result_array();

		$data['title'] = 'Dashboard Admin';
		$data['view'] = 'visitor/dashboard/dashboard2';
		$this->load->view('admin/layout', $data);
	}
}
