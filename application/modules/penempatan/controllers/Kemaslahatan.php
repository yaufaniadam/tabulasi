<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Kemaslahatan extends MY_Controller {
		public function __construct(){
			parent::__construct();
			$this->load->model('keuanganhaji_model', 'keuanganhaji_model');
			$this->load->model('penempatan_model', 'penempatan_model');
			$this->load->library('datatable'); // loaded my custom serverside datatable library
		}

		public function index($jenis_penempatan = 0, $tahun = 0, $lembaga = 0, $quartal = 0 ){	

			$data['jenis_penempatan'] = $this->penempatan_model->get_jenis_penempatan($jenis_penempatan);
			$data['penempatan'] =  $this->keuanganhaji_model->get_all_penempatan('kk',$jenis_penempatan, $tahun, $lembaga, $quartal);
			$data['total_penempatan'] =  $this->keuanganhaji_model->get_total_return('kk',$jenis_penempatan, $tahun, $lembaga, $quartal);
			$data['title'] = 'Jenis Penempatan';
			$data['view'] = 'kemaslahatan/index';
			$this->load->view('admin/layout', $data);

		}

		public function grafik($jenis_penempatan = 0, $tahun = 0, $lembaga = 0, $quartal = 0  ){	

			$data['jenis_penempatan'] = $this->penempatan_model->get_jenis_penempatan($jenis_penempatan);
			$data['penempatan'] =  $this->keuanganhaji_model->get_grafik('kk',$jenis_penempatan, $tahun, $lembaga, $quartal);
			$data['total_penempatan'] =  $this->keuanganhaji_model->get_total_return('kk',$jenis_penempatan, $tahun, $lembaga, $quartal);
			$data['title'] = 'Jenis Penempatan';
			$data['view'] = 'kemaslahatan/grafik';
			$this->load->view('admin/layout', $data);

		}


	} //class

