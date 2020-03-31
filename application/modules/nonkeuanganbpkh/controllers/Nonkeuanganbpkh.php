<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Nonkeuanganbpkh extends MY_Controller {
		
		public function __construct(){
			parent::__construct();
			$this->load->model('nonkeuanganbpkh_model', 'nonkeuanganbpkh_model');

		}

		public function index( ){				
			$data['view'] = 'nonkeuanganbpkh/index';
			$this->load->view('admin/layout', $data);
		}		

		// nilai manfaat regulasi
		public function dokumen($kategori=0){

			$kategori = ($kategori !='') ? $kategori : '';

			
			$data['dokumen'] = $this->nonkeuanganbpkh_model->get_dokumen($kategori);

			$data['view'] = 'nonkeuanganbpkh/dokumen';
			$this->load->view('admin/layout', $data);

		}

		public function tambah_dokumen(){
			if($this->input->post('submit')){

				$this->form_validation->set_rules('nama_dokumen', 'Judul dokumen', 'trim|required');
				$this->form_validation->set_rules('jenis_dokumen', 'Jenis Dokumen', 'trim|required');
				
	
				if ($this->form_validation->run() == FALSE) {					
				
					$data['view'] = 'nonkeuanganbpkh/tambah_dokumen';
    				$this->load->view('admin/layout', $data);
				}
				else{ 

					$upload_path = './uploads/dokumen';

						if (!is_dir($upload_path)) {
						     mkdir($upload_path, 0777, TRUE);					
						}
					
						$config = array(
								'upload_path' => $upload_path,
								'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
								'overwrite' => FALSE,				
						);					

						$this->load->library('upload', $config);
						$this->upload->do_upload('file_dokumen');
					    $dokumen = $this->upload->data();			
						

						$data = array(
									
							'nama_dokumen' => $this->input->post('nama_dokumen'),
							'date' => date('Y-m-d'),		
							'file' => $upload_path.'/'.$dokumen['file_name'],	
							'jenis_dokumen' => $this->input->post('jenis_dokumen'),			
							
						);
									
						$data = $this->security->xss_clean($data);
						$result = $this->nonkeuanganbpkh_model->tambah_dokumen($data);

						if($result){
							$this->session->set_flashdata('msg', 'Dokumen telah ditambahkan!');
							redirect(base_url('nonkeuanganbpkh/dokumen'));
						} 

					} 

				}

				else{
					
					
					$data['view'] = 'nonkeuanganbpkh/tambah_dokumen';
    				$this->load->view('admin/layout', $data);
				}
		}

		

		public function hapus_dokumen($id = 0, $uri = NULL){	
			$this->db->delete('dokumen', array('id' => $id));
			$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
			redirect(base_url('nonkeuanganbpkh/dokumen'));
		}




	} //class

