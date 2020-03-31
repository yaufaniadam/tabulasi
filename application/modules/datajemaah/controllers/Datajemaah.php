<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Datajemaah extends MY_Controller {
	
		public function __construct(){
			parent::__construct();
			$this->load->library('excel');
			$this->load->model('kemaslahatan_model', 'kemaslahatan_model');

		}

		public function index( $tahun=0 ){				
		

			$tahun = ($tahun !='') ? $tahun : date('Y');
			$data['thn'] = $tahun;
			$data['tahun'] = $this->kemaslahatan_model->get_tahun_kemaslahatan();
			$data['kemaslahatan'] = $this->kemaslahatan_model->get_kemaslahatan($tahun);
			$data['view'] = 'index';
			$this->load->view('admin/layout', $data);
		}
		

		public function data_jemaah_antri(){
			$data['id'] = 'datajemaah';
			$data['class'] = 'data_jemaah_antri';			
			$data['judul'] = 'Data Jemaah Antri';
			$data['view'] = 'keuanganhaji/tambahan';
    		$this->load->view('admin/layout', $data);
		}

		public function data_jemaah_batal(){
			$data['id'] = 'datajemaah';
			$data['class'] = 'data_jemaah_batal';			
			$data['judul'] = 'Data Jemaah Batal';
			$data['view'] = 'keuanganhaji/tambahan';
    		$this->load->view('admin/layout', $data);
		}

		public function kuota_jemaah_berangkat(){
			$data['id'] = 'datajemaah';
			$data['class'] = 'kuota_jemaah_berangkat';			
			$data['judul'] = 'Kuota Jemaah berangkat';
			$data['view'] = 'keuanganhaji/tambahan';
    		$this->load->view('admin/layout', $data);
		}

		public function dokumentasi_kegiatan_kemaslahatan(){
			$data['id'] = 'dokumentasi_kegiatan_kemaslahatan';
			$data['class'] = 'penerima_manfaat';			
			$data['judul'] = 'Dokumentasi Kegiatan Kemaslahatan';
			$data['view'] = 'keuanganhaji/tambahan';
    		$this->load->view('admin/layout', $data);
		}

		public function regulasi_tentang_kemaslahatan(){
			$data['id'] = 'regulasi_tentang_kemaslahatan';
			$data['class'] = 'penerima_manfaat';			
			$data['judul'] = 'Regulasi Tentang Kemaslahatan';
			$data['view'] = 'keuanganhaji/tambahan';
    		$this->load->view('admin/layout', $data);
		}

		public function realisasi_bipih_2000(){
			$data['id'] = 'realisasi_bipih';
			$data['class'] = 'realisasi_bipih_2000';			
			$data['judul'] = 'Realisasi BIPH Tahun 2000';
			$data['view'] = 'keuanganhaji/tambahan';
    		$this->load->view('admin/layout', $data);
		}

		public function realisasi_bipih_2001(){
			$data['id'] = 'realisasi_bipih';
			$data['class'] = 'realisasi_bipih_2001';			
			$data['judul'] = 'Realisasi BIPH Tahun 2001';
			$data['view'] = 'keuanganhaji/tambahan';
    		$this->load->view('admin/layout', $data);
		}

		public function realisasi_bpih_2000(){
	      $data['id'] = 'realisasi_bpih';
	      $data['class'] = 'realisasi_bpih_2000';      
	      $data['judul'] = 'Realisasi BIPH Tahun 2000';
	      $data['view'] = 'keuanganhaji/tambahan';
	        $this->load->view('admin/layout', $data);
	    }

	    public function realisasi_bpih_2001(){
	      $data['id'] = 'realisasi_bpih';
	      $data['class'] = 'realisasi_bpih_2001';      
	      $data['judul'] = 'Realisasi BIPH Tahun 2001';
	      $data['view'] = 'keuanganhaji/tambahan';
	        $this->load->view('admin/layout', $data);
	    }

	} //class