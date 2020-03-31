<?php defined('BASEPATH') OR exit('No direct script access allowed');
	class Penempatan extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('penempatan_model', 'penempatan_model');
			$this->load->model('lembaga/lembaga_model', 'lembaga_model');
			$this->load->library('datatable'); // loaded my custom serverside datatable library
		}

		public function index(){
			$data['all_jenis_penempatan'] =  $this->penempatan_model->get_all_jenis_penempatan();
			$data['title'] = 'Jenis penempatan';
			$data['view'] = 'penempatan/all_jenis_penempatan';
			$this->load->view('admin/layout', $data);
		}	

		public function tambah($kat = 0, $slug = 0){
			
		

			if($this->input->post('submit')){
				$this->form_validation->set_rules('kategori', 'kategori', 'trim|required');
				$this->form_validation->set_rules('jenis_penempatan', 'Jenis Penempatan', 'trim|required');				
				$this->form_validation->set_rules('lembaga', 'Lembaga', 'trim|required');
				$this->form_validation->set_rules('no_seri', 'Nomor Seri', 'trim|required');
				$this->form_validation->set_rules('no_transaksi', 'Nomor Transaksi', 'trim|required');
				$this->form_validation->set_rules('estimasi_return', 'Estimasi Return', 'trim|required');
				$this->form_validation->set_rules('pokok_penempatan', 'Pokok Penempatan', 'trim|required');
				$this->form_validation->set_rules('tgl_transaksi', 'Tanggal Transaksi', 'trim|required');
				$this->form_validation->set_rules('tgl_jatuh_tempo', 'Tanggal Jatuh Tempo', 'trim|required');
	
				if ($this->form_validation->run() == FALSE) {
					$data['all_jenis_penempatan'] =  $this->penempatan_model->get_all_jenis_penempatan();
					$data['all_lembaga'] =  $this->lembaga_model->get_all_lembaga();
					$data['title'] = 'Tambah Penempatan';
					$data['view'] = 'penempatan/tambah_penempatan';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'kategori' 			=> $this->input->post('kategori'),		
						'jenis_penempatan' 	=> $this->input->post('jenis_penempatan'),	
						'lembaga' 			=> $this->input->post('lembaga'),	
						'no_seri' 			=> $this->input->post('no_seri'),					
						'no_transaksi' 		=> $this->input->post('no_transaksi'),	
						'estimasi_return' 	=> $this->input->post('estimasi_return'),	
						'pokok_penempatan' 	=> $this->input->post('pokok_penempatan'),	
						'tgl_transaksi' 	=> $this->input->post('tgl_transaksi'),	
						'tgl_jatuh_tempo' 	=> $this->input->post('tgl_jatuh_tempo'),	
						'date' 				=> date('Y-m-d : h:i:s'),					
					);
					$data = $this->security->xss_clean($data);
					$result = $this->penempatan_model->tambah_data_penempatan($data);
					if($result){
						$this->session->set_flashdata('msg', 'Data berhasil ditambahkan!');
						redirect(base_url('penempatan/tambah/'.$kat.'/'.$slug));
					}
				}
			}
			else{
				$data['all_jenis_penempatan'] =  $this->penempatan_model->get_all_jenis_penempatan();
				$data['all_lembaga'] =  $this->lembaga_model->get_all_lembaga();
				$data['title'] = 'Tambah Penempatan';
				$data['view'] = 'penempatan/tambah_penempatan';
				$this->load->view('admin/layout', $data);
			}
			
		}		
	}
?>