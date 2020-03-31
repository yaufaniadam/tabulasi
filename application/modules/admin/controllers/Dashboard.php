<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends MY_Controller {
		public function __construct(){
			parent::__construct();
			$this->load->model('admin/dashboard_model', 'dashboard_model');
			$this->load->model('dashboard_model');
		}

		public function index(){
			//$data['all_users'] = $this->dashboard_model->get_all_users();
			//$data['all_prodi'] = $this->dashboard_model->get_all_prodi();
			//$data['all_fakultas'] = $this->dashboard_model->get_all_fakultas();
			//$data['all_biro'] = $this->dashboard_model->get_all_biro();
			$data['title'] = 'Dashboard Admin';
			$data['view'] = 'admin/dashboard/dashboard2';
			$this->load->view('layout', $data);
		}

		public function users(){			
			$data['view'] = 'admin/dashboard/dashboard_user';
			$this->load->view('layout', $data);
		}

	}

?>	