<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard_user extends Unitkerja_Controller {
		public function __construct(){
			parent::__construct();
			$this->load->model('admin/dashboard_model', 'dashboard_model');
		}

		public function index(){
			$data['title'] = 'Dashboard Admin';
			$data['view'] = 'admin/dashboard/dashboard2';
			$this->load->view('layout', $data);
		}

	}

?>	