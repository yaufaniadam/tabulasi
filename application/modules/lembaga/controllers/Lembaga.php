<?php defined('BASEPATH') OR exit('No direct script access allowed');
	class Lembaga extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('lembaga_model', 'lembaga_model');

			$this->load->library('datatable'); // loaded my custom serverside datatable library
		}

		public function index(){
			$data['all_lembaga'] =  $this->lembaga_model->get_all_lembaga();
			$data['title'] = 'Semua Lembaga';
			$data['view'] = 'lembaga/all_lembaga';
			$this->load->view('admin/layout', $data);
		}	
	
		public function tambah_unit(){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('nama_unit', 'Nama unit', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$data['view'] = 'admin/unit/tambah_unit';
					$this->load->view('layout', $data);
				}
				else{
					$data = array(
						'nama_unit' => $this->input->post('nama_unit'),
						'kode' => 'b',
						'singkatan' => $this->input->post('singkatan'),
						'induk' => '0',
					
					);
					$data = $this->security->xss_clean($data);
					$result = $this->unit_model->add_unit($data);
					if($result){
						$this->session->set_flashdata('msg', 'Unit Kerja telah ditambahkan!');
						redirect(base_url('admin/unit'));
					}
				}
			}
			else{
				$data['view'] = 'admin/unit';
				$this->load->view('layout', $data);
			}
			
		}

		

		public function edit($id = 0){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('nama_unit', 'Nama unit', 'trim|required');

			
					$data = array(
						'nama_unit' => $this->input->post('nama_unit'),
						'singkatan' => $this->input->post('singkatan'),
			
					);
					$data = $this->security->xss_clean($data);
					$result = $this->unit_model->edit_unit($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'Unit telah diperbarui!');
						redirect(base_url('admin/unit'));
					}
				
			}
			else{
				$data['unit'] = $this->unit_model->get_unit_by_id($id,'b');
				$data['view'] = 'admin/unit/edit';
				$this->load->view('layout', $data);
			}
		}

		

		public function del($id = 0, $uri = NULL){	
			$this->db->delete('ci_unit_kerja', array('id' => $id));
			$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
			redirect(base_url('admin/unit/'));
		}

		public function kantor() {

			$data['all_kantor'] =  $this->unit_model->get_all_kantor();
			$data['title'] = 'Kantor Pusat dan Cabang';
			$data['view'] = 'admin/unit/all_kantor';
			$this->load->view('layout', $data);
		}

		public function tambah_kantor(){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('nama_kantor', 'Nama kantor', 'trim|required');
				$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
				$this->form_validation->set_rules('telp', 'Telepon', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$data['unit'] = $this->unit_model->get_all_unit_kerja();
					$data['title'] = "Tambah Kantor Cabang";
					$data['view'] = 'admin/unit/tambah_kantor';
					$this->load->view('layout', $data);
				}
				else{
					$data = array(
						'kantor' => $this->input->post('nama_kantor'),				
						'alamat' => $this->input->post('alamat'),
						'telp' => $this->input->post('telp'),
						
					
					);
					$data = $this->security->xss_clean($data);
					$result = $this->unit_model->add_kantor($data);
					if($result){
						$this->session->set_flashdata('msg', 'Unit Kerja telah ditambahkan!');
						redirect(base_url('admin/unit/kantor'));
					}
				}
			}
			else{
				$data['unit'] = $this->unit_model->get_all_unit_kerja();
				$data['title'] = "Tambah Kantor Cabang";
				$data['view'] = 'admin/unit/tambah_kantor';
				$this->load->view('layout', $data);
			}
			
		}

		public function edit_kantor($id=0){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('nama_kantor', 'Nama kantor', 'trim|required');
				$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
				$this->form_validation->set_rules('telp', 'Telepon', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$data['unit'] = $this->unit_model->get_all_unit_kerja();
					$data['title'] = "Ubah Kantor Cabang";
					$data['view'] = 'admin/unit/edit_kantor';
					$this->load->view('layout', $data);
				}
				else{
					$data = array(
						'kantor' => $this->input->post('nama_kantor'),				
						'alamat' => $this->input->post('alamat'),
						'telp' => $this->input->post('telp'),
						'id_unit'=>implode(',',$this->input->post('id_unit')),
						
					
					);
					$data = $this->security->xss_clean($data);
					$result = $this->unit_model->edit_kantor($data,$id);
					if($result){
						$this->session->set_flashdata('msg', 'Unit Kerja telah ditambahkan!');
						redirect(base_url('admin/unit/kantor'));
					}
				}
			}
			else{
				$data['unit'] = $this->unit_model->get_all_unit_kerja();
				$data['kantor'] = $this->unit_model->get_kantor_by_id($id);
				$data['title'] = "Ubah Kantor Cabang";
				$data['view'] = 'admin/unit/edit_kantor';
				$this->load->view('layout', $data);
			}
			
		}

		public function detail_kantor($id = 0){
			$data['penempatan'] = $this->user_model->get_penempatan_by_kantor($id);
			$data['kantor'] = $this->unit_model->get_kantor_by_id($id);
			$data['view'] = 'admin/unit/detail_kantor';
			$this->load->view('layout', $data);
		}

		public function detail_unit($kantor = 0 , $id = 0){			
			$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
			$data['unit'] = $this->unit_model->get_unit_by_id($id);
			$data['view'] = 'admin/unit/detail_unit';
			$this->load->view('layout', $data);
		}

		public function add_hrd($kantor = 0, $id = 0, $maqasid) {

			

			if($this->input->post('submit')){
				//$this->form_validation->set_rules('nama_kantor', 'Nama kantor', 'trim|required');
				//$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
				//$this->form_validation->set_rules('telp', 'Telepon', 'trim|required');

				/*if ($this->form_validation->run() == FALSE) {
					$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
					$data['unit'] = $this->unit_model->get_unit_by_id($id);
					$data['view'] = 'admin/unit/detail_unit';
					$this->load->view('layout', $data);
				}
				else{ */

						$upload_path = './uploads/teller';

						if (!is_dir($upload_path)) {
						     mkdir($upload_path, 0777, TRUE);					
						}
						//$newName = "hrd-".date('Ymd-His');
						$config = array(
								'upload_path' => $upload_path,
								'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
								'overwrite' => FALSE,							
							
						);

					

						$this->load->library('upload', $config);
				         // script upload file pertama

						/*pengajian */
						if( $this->input->post('sub_maqasid') == "pengajian") { 

					        $this->upload->do_upload('presensi_peserta');
					        $upload_data = $this->upload->data();	
							
							$this->upload->do_upload('komentar_peserta');
					        $upload_data2 = $this->upload->data();	
						
							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	

								'lokasi' => $this->input->post('lokasi'),
								'jenis_kegiatan' => $this->input->post('jenis_kegiatan'),			
								'tanggal' => $this->input->post('tanggal_pelaksanaan'),		
								'nama_pemateri' => $this->input->post('nama_pemateri'),	
								'kontak_pemateri' => $this->input->post('kontak_pemateri'),	
								'topik_kegiatan' => $this->input->post('topik_kegiatan'),
								'rekomendasi' => $this->input->post('rekomendasi'),
								'file_presensi' => $upload_path.'/'.$upload_data['file_name'],
								'file_komentar' => $upload_path.'/'.$upload_data2['file_name'],
								'link_berita' => $this->input->post('link_berita'),	
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if ($this->input->post('sub_maqasid') == "rekrutmen")  {

							$this->upload->do_upload('file_sdm');
					        $file_sdm = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	

								'tanggal_rekrutmen' => $this->input->post('tanggal_rekrutmen'),
								'bentuk_rekrutmen' => $this->input->post('bentuk_rekrutmen'),
								'sdm_diperlukan' => $this->input->post('sdm_diperlukan'),
								'sdm_seleksi' => $this->input->post('sdm_seleksi'),
								'sdm_diterima' => $this->input->post('sdm_diterima'),
								'file_sdm' => $upload_path.'/'.$file_sdm['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if ($this->input->post('sub_maqasid') == "kinerja")  {

							$this->upload->do_upload('file_kinerja');
					        $file_kinerja = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	

								'file_kinerja_pegawai' => $upload_path.'/'.$file_kinerja['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if ($this->input->post('sub_maqasid') == "employee_productivity")  {

							$this->upload->do_upload('file_employee_productivity');
					        $file_employee_productivity = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	

								'file_employee_productivity' => $upload_path.'/'.$file_employee_productivity['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if( $this->input->post('sub_maqasid') == "training") { 

					        $this->upload->do_upload('presensi_peserta');
					        $upload_data = $this->upload->data();	
							
							//$this->upload->do_upload('komentar_peserta');
					       // $upload_data2 = $this->upload->data();	
						
							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	

								'lokasi' => $this->input->post('lokasi'),
								'jenis_kegiatan' => $this->input->post('jenis_kegiatan'),			
								'tanggal' => $this->input->post('tanggal_pelaksanaan'),		
								'nama_pemateri' => $this->input->post('nama_pemateri'),	
								'kontak_pemateri' => $this->input->post('kontak_pemateri'),	
								'topik_kegiatan' => $this->input->post('topik_kegiatan'),
								'rekomendasi' => $this->input->post('rekomendasi'),
								'file_presensi' => $upload_path.'/'.$upload_data['file_name'],
								'link_berita' => $this->input->post('link_berita'),	
							//	'file_komentar' => $upload_path.'/'.$upload_data2['file_name'],
								
								'date' => date('Y-m-d : h:i:s'),

							);

						}  else if( $this->input->post('sub_maqasid') == "gathering") { 

					        $this->upload->do_upload('presensi_peserta');
					        $upload_data = $this->upload->data();	
							
							$this->upload->do_upload('komentar_peserta');
					        $upload_data2 = $this->upload->data();	
						
							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	

								'lokasi' => $this->input->post('lokasi'),
								'jenis_kegiatan' => $this->input->post('jenis_kegiatan'),			
								'tanggal' => $this->input->post('tanggal_pelaksanaan'),		
								'nama_pemateri' => $this->input->post('nama_pemateri'),	
								'kontak_pemateri' => $this->input->post('kontak_pemateri'),	
								'topik_kegiatan' => $this->input->post('topik_kegiatan'),
								'rekomendasi' => $this->input->post('rekomendasi'),
								'file_presensi' => $upload_path.'/'.$upload_data['file_name'],
								'link_berita' => $this->input->post('link_berita'),	
								'file_komentar' => $upload_path.'/'.$upload_data2['file_name'],
								
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if( $this->input->post('sub_maqasid') == "gaji"){

							$this->upload->do_upload('file_gaji');
					        $file_gaji = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	

								'tanggal' => $this->input->post('tanggal_pelaksanaan'),	
								'file_gaji' => $upload_path.'/'.$file_gaji['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);

						}




							
						$data = $this->security->xss_clean($data);
						$result = $this->unit_model->add_hrd($data);
						if($result){
							$this->session->set_flashdata('msg', 'Data telah disimpan!');
							redirect(base_url('admin/unit/detail_unit/'. $kantor. "/". $id));
						}
								
						//}				
							
						

			}
			else{
				$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
				$data['unit'] = $this->unit_model->get_unit_by_id($id);
				$data['view'] = 'admin/unit/detail_unit';
				$this->load->view('layout', $data);
			}

		}

		public function add_teller($kantor = 0, $id = 0, $maqasid) {

			

			if($this->input->post('submit')){
				//$this->form_validation->set_rules('nama_kantor', 'Nama kantor', 'trim|required');
				//$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
				//$this->form_validation->set_rules('telp', 'Telepon', 'trim|required');

				/*if ($this->form_validation->run() == FALSE) {
					$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
					$data['unit'] = $this->unit_model->get_unit_by_id($id);
					$data['view'] = 'admin/unit/detail_unit';
					$this->load->view('layout', $data);
				}
				else{ */

						$upload_path = './uploads/teller';

						if (!is_dir($upload_path)) {
						     mkdir($upload_path, 0777, TRUE);					
						}
						//$newName = "hrd-".date('Ymd-His');
						$config = array(
								'upload_path' => $upload_path,
								'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
								'overwrite' => FALSE,										
						);

						$this->load->library('upload', $config);
				         // script upload file pertama

						/*  */
						if( $this->input->post('sub_maqasid') == "komplain") { 

					     
							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'tanggal_kejadian' => $this->input->post('tanggal_kejadian'),		
								'tanggal_komplain' => $this->input->post('tanggal_komplain'),	
								'pihak_komplain' => $this->input->post('pihak_komplain'),	
								'bentuk_komplain' => $this->input->post('bentuk_komplain'),
								'tindakan_diambil' => $this->input->post('tindakan_diambil'),
								'tindakan_perlu_diambil' => $this->input->post('tindakan_perlu_diambil'),
								'status' => $this->input->post('status'),
								
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if ($this->input->post('sub_maqasid') == "kecepatan")  {

							$this->upload->do_upload('file_kecepatan_kerja');
					        $file_kecepatan_kerja = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	

								'tanggal_rekrutmen' => $this->input->post('tanggal_rekrutmen'),
				
								'file_kecepatan_kerja' => $upload_path.'/'.$file_kecepatan_kerja['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if ($this->input->post('sub_maqasid') == "product_knowledge")  {

							$this->upload->do_upload('file_product_knowledge');
					        $file_product_knowledge = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	

								'file_product_knowledge' => $upload_path.'/'.$file_product_knowledge['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} 

						$data = $this->security->xss_clean($data);
						$result = $this->unit_model->add_teller($data);
						if($result){
							$this->session->set_flashdata('msg', 'Data telah disimpan!');
							redirect(base_url('admin/unit/detail_unit/'. $kantor. "/". $id));
						}
								
						//}				
							
						

			}
			else{
				$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
				$data['unit'] = $this->unit_model->get_unit_by_id($id);
				$data['view'] = 'admin/unit/detail_unit';
				$this->load->view('layout', $data);
			}

		}

		public function add_akunting($kantor = 0, $id = 0, $maqasid) {

			

			if($this->input->post('submit')){
				//$this->form_validation->set_rules('nama_kantor', 'Nama kantor', 'trim|required');
				//$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
				//$this->form_validation->set_rules('telp', 'Telepon', 'trim|required');

				/*if ($this->form_validation->run() == FALSE) {
					$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
					$data['unit'] = $this->unit_model->get_unit_by_id($id);
					$data['view'] = 'admin/unit/detail_unit';
					$this->load->view('layout', $data);
				}
				else{ */

						$upload_path = './uploads/akunting';

						if (!is_dir($upload_path)) {
						     mkdir($upload_path, 0777, TRUE);					
						}
						//$newName = "hrd-".date('Ymd-His');
						$config = array(
								'upload_path' => $upload_path,
								'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
								'overwrite' => FALSE,										
						);

						$this->load->library('upload', $config);
				         // script upload file pertama

						/*  */
						if( $this->input->post('sub_maqasid') == "laporan_keuangan") { 

							$this->upload->do_upload('file_laporan_keuangan');
					        $file_laporan_keuangan = $this->upload->data();
					     
							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'tanggal' => $this->input->post('tanggal'),		
								
								'file_laporan_keuangan' => $upload_path.'/'.$file_laporan_keuangan['file_name'],	
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if ($this->input->post('sub_maqasid') == "laporan_keuangan_harian")  {

							$this->upload->do_upload('file_laporan_keuangan_harian');
					        $file_laporan_keuangan_harian = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'tanggal' => $this->input->post('tanggal'),
								'file_laporan_keuangan_harian' => $upload_path.'/'.$file_laporan_keuangan_harian['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						}

						$data = $this->security->xss_clean($data);
						$result = $this->unit_model->add_akunting($data);
						if($result){
							$this->session->set_flashdata('msg', 'Data telah disimpan!');
							redirect(base_url('admin/unit/detail_unit/'. $kantor. "/". $id));
						}
								
						//}				
							
						

			}
			else{
				$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
				$data['unit'] = $this->unit_model->get_unit_by_id($id);
				$data['view'] = 'admin/unit/detail_unit';
				$this->load->view('layout', $data);
			}

		}

		public function add_cs($kantor = 0, $id = 0, $maqasid) {

			

			if($this->input->post('submit')){
				//$this->form_validation->set_rules('nama_kantor', 'Nama kantor', 'trim|required');
				//$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
				//$this->form_validation->set_rules('telp', 'Telepon', 'trim|required');

				/*if ($this->form_validation->run() == FALSE) {
					$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
					$data['unit'] = $this->unit_model->get_unit_by_id($id);
					$data['view'] = 'admin/unit/detail_unit';
					$this->load->view('layout', $data);
				}
				else{ */

						$upload_path = './uploads/cs';

						if (!is_dir($upload_path)) {
						     mkdir($upload_path, 0777, TRUE);					
						}
						//$newName = "hrd-".date('Ymd-His');
						$config = array(
								'upload_path' => $upload_path,
								'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
								'overwrite' => FALSE,										
						);

						$this->load->library('upload', $config);
				         // script upload file pertama

						/*  */
						if( $this->input->post('sub_maqasid') == "mitra_baru") { 

							$this->upload->do_upload('file_mitra');
					        $file_mitra = $this->upload->data();
					     
							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'tanggal' => $this->input->post('tanggal'),		
								'target_mitra' => $this->input->post('target_mitra'),	
								'realisasi_mitra' => $this->input->post('realisasi_mitra'),	
								
								'file_mitra' => $upload_path.'/'.$file_mitra['file_name'],	
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if ($this->input->post('sub_maqasid') == "evaluasi_nasabah")  {

							$this->upload->do_upload('file_evaluasi_nasabah');
					        $file_evaluasi_nasabah = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'tanggal' => $this->input->post('tanggal'),
								'file_evaluasi_nasabah' => $upload_path.'/'.$file_evaluasi_nasabah['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if ($this->input->post('sub_maqasid') == "product_knowledge")  {

							$this->upload->do_upload('file_product_knowledge');
					        $file_product_knowledge = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'tanggal' => $this->input->post('tanggal'),
								'file_product_knowledge' => $upload_path.'/'.$file_product_knowledge['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if( $this->input->post('sub_maqasid') == "komplain") { 

					     
							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'tanggal_kejadian' => $this->input->post('tanggal_kejadian'),		
								'tanggal_komplain' => $this->input->post('tanggal_komplain'),	
								'pihak_komplain' => $this->input->post('pihak_komplain'),	
								'bentuk_komplain' => $this->input->post('bentuk_komplain'),
								'tindakan_diambil' => $this->input->post('tindakan_diambil'),
								'tindakan_perlu_diambil' => $this->input->post('tindakan_perlu_diambil'),
								'status' => $this->input->post('status'),
								
								'date' => date('Y-m-d : h:i:s'),

							);

						}

						$data = $this->security->xss_clean($data);
						$result = $this->unit_model->add_cs($data);
						if($result){
							$this->session->set_flashdata('msg', 'Data telah disimpan!');
							redirect(base_url('admin/unit/detail_unit/'. $kantor. "/". $id));
						}
								
						//}				
							
						

			}
			else{
				$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
				$data['unit'] = $this->unit_model->get_unit_by_id($id);
				$data['view'] = 'admin/unit/detail_unit';
				$this->load->view('layout', $data);
			}

		}

		public function add_pembiayaan($kantor = 0, $id = 0, $maqasid) {

			

			if($this->input->post('submit')){
				//$this->form_validation->set_rules('nama_kantor', 'Nama kantor', 'trim|required');
				//$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
				//$this->form_validation->set_rules('telp', 'Telepon', 'trim|required');

				/*if ($this->form_validation->run() == FALSE) {
					$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
					$data['unit'] = $this->unit_model->get_unit_by_id($id);
					$data['view'] = 'admin/unit/detail_unit';
					$this->load->view('layout', $data);
				}
				else{ */

						$upload_path = './uploads/pembiayaan';

						if (!is_dir($upload_path)) {
						     mkdir($upload_path, 0777, TRUE);					
						}
						//$newName = "hrd-".date('Ymd-His');
						$config = array(
								'upload_path' => $upload_path,
								'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
								'overwrite' => FALSE,										
						);

						$this->load->library('upload', $config);
				         // script upload file pertama

						if ($this->input->post('sub_maqasid') == "product_knowledge")  {

							$this->upload->do_upload('file_product_knowledge');
					        $file_product_knowledge = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'tanggal' => $this->input->post('tanggal'),
								'file_product_knowledge' => $upload_path.'/'.$file_product_knowledge['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if( $this->input->post('sub_maqasid') == "komplain") { 

					     
							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'tanggal_kejadian' => $this->input->post('tanggal_kejadian'),		
								'tanggal_komplain' => $this->input->post('tanggal_komplain'),	
								'pihak_komplain' => $this->input->post('pihak_komplain'),	
								'bentuk_komplain' => $this->input->post('bentuk_komplain'),
								'tindakan_diambil' => $this->input->post('tindakan_diambil'),
								'tindakan_perlu_diambil' => $this->input->post('tindakan_perlu_diambil'),
								'status' => $this->input->post('status'),
								
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if( $this->input->post('sub_maqasid') == "akad") { 

					     	$this->upload->do_upload('file_berita_acara_komite');
					        $file_berita_acara_komite = $this->upload->data();

							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'jumlah_akad' => $this->input->post('jumlah_akad'),		
								'plafon_akad' => $this->input->post('plafon_akad'),	
								'pihak_komplain' => $this->input->post('pihak_komplain'),	
								'file_berita_acara_komite' => $upload_path.'/'.$file_berita_acara_komite['file_name'],
								
								
								'date' => date('Y-m-d : h:i:s'),

							);

						}

						$data = $this->security->xss_clean($data);
						$result = $this->unit_model->add_pembiayaan($data);
						if($result){
							$this->session->set_flashdata('msg', 'Data telah disimpan!');
							redirect(base_url('admin/unit/detail_unit/'. $kantor. "/". $id));
						}
								
						//}				
							
						

			}
			else{
				$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
				$data['unit'] = $this->unit_model->get_unit_by_id($id);
				$data['view'] = 'admin/unit/detail_unit';
				$this->load->view('layout', $data);
			}

		}

		public function add_surveyor($kantor = 0, $id = 0, $maqasid) {			

			if($this->input->post('submit')){
				
				//$this->form_validation->set_rules('nama_kantor', 'Nama kantor', 'trim|required');
				//$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
				//$this->form_validation->set_rules('telp', 'Telepon', 'trim|required');

				/*if ($this->form_validation->run() == FALSE) {
					$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
					$data['unit'] = $this->unit_model->get_unit_by_id($id);
					$data['view'] = 'admin/unit/detail_unit';
					$this->load->view('layout', $data);
				}
				else{ */

						$upload_path = './uploads/surveyor';

						if (!is_dir($upload_path)) {
						     mkdir($upload_path, 0777, TRUE);					
						}
						//$newName = "hrd-".date('Ymd-His');
						$config = array(
								'upload_path' => $upload_path,
								'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
								'overwrite' => FALSE,										
						);

						$this->load->library('upload', $config);
				         // script upload file pertama

						if ($this->input->post('sub_maqasid') == "product_knowledge")  {

							$this->upload->do_upload('file_product_knowledge');
					        $file_product_knowledge = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'tanggal' => $this->input->post('tanggal'),
								'file_product_knowledge' => $upload_path.'/'.$file_product_knowledge['file_name'],

								'date' => date('Y-m-d : h:i:s'),

							);
						} else if ($this->input->post('sub_maqasid') == "akurasi")  {

							$this->upload->do_upload('file_hasil_survey_akurasi');
					        $file_hasil_survey_akurasi = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'tanggal' => $this->input->post('tanggal'),
								'file_hasil_survey_akurasi' => $upload_path.'/'.$file_hasil_survey_akurasi['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if ($this->input->post('sub_maqasid') == "barang_dibeli")  {

							$this->upload->do_upload('file_barang_dibeli');
					        $file_barang_dibeli = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'tanggal' => $this->input->post('tanggal'),
								'file_barang_dibeli' => $upload_path.'/'.$file_barang_dibeli['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} 

						$data = $this->security->xss_clean($data);
						$result = $this->unit_model->add_surveyor($data);
						if($result){
							$this->session->set_flashdata('msg', 'Data telah disimpan!');
							redirect(base_url('admin/unit/detail_unit/'. $kantor. "/". $id));
						}
								
						//}						

			}
			else{
				$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
				$data['unit'] = $this->unit_model->get_unit_by_id($id);
				$data['view'] = 'admin/unit/detail_unit';
				$this->load->view('layout', $data);
			}

		}

		public function add_auditor($kantor = 0, $id = 0, $maqasid) {			

			if($this->input->post('submit')){
				

						$upload_path = './uploads/auditor';

						if (!is_dir($upload_path)) {
						     mkdir($upload_path, 0777, TRUE);					
						}
						//$newName = "hrd-".date('Ymd-His');
						$config = array(
								'upload_path' => $upload_path,
								'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
								'overwrite' => FALSE,										
						);

						$this->load->library('upload', $config);
				         // script upload file pertama

						if ($this->input->post('sub_maqasid') == "review_kerja")  {

							$this->upload->do_upload('file_auditor');
					        $file_auditor = $this->upload->data();
					    
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'nilai_efisiensi' => $this->input->post('nilai_efisiensi'),
								'nilai_efektifitas' => $this->input->post('nilai_efektifitas'),					
								'file_auditor' => $upload_path.'/'.$file_auditor['file_name'],			
								
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if ($this->input->post('sub_maqasid') == "review_keuangan")  {

							$this->upload->do_upload('file_keakuratan');
					        $file_keakuratan = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'nilai_standar' => $this->input->post('nilai_standar'),
								'nilai_keakuratan' => $this->input->post('nilai_keakuratan'),
								'file_keakuratan' => $upload_path.'/'.$file_keakuratan['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if ($this->input->post('sub_maqasid') == "review_rencana")  {

							$this->upload->do_upload('file_tindak_lanjut');
					        $file_tindak_lanjut = $this->upload->data();

					        $this->upload->do_upload('file_follow_up');
					        $file_follow_up = $this->upload->data();


							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	

								'file_follow_up' => $upload_path.'/'.$file_follow_up['file_name'],
							
								'file_tindak_lanjut' => $upload_path.'/'.$file_tindak_lanjut['file_name'],

								'date' => date('Y-m-d : h:i:s'),

							);
						} 

						$data = $this->security->xss_clean($data);
						$result = $this->unit_model->add_auditor($data);
						if($result){
							$this->session->set_flashdata('msg', 'Data telah disimpan!');
							redirect(base_url('admin/unit/detail_unit/'. $kantor. "/". $id));
						}
								
						//}							

			}
			else{
				$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
				$data['unit'] = $this->unit_model->get_unit_by_id($id);
				$data['view'] = 'admin/unit/detail_unit';
				$this->load->view('layout', $data);
			}

		}

		public function add_marketing($kantor = 0, $id = 0, $maqasid) {

			

			if($this->input->post('submit')){
				
						$upload_path = './uploads/marketing';

						if (!is_dir($upload_path)) {
						     mkdir($upload_path, 0777, TRUE);					
						}
						//$newName = "hrd-".date('Ymd-His');
						$config = array(
								'upload_path' => $upload_path,
								'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
								'overwrite' => FALSE,										
						);

						$this->load->library('upload', $config);
				         // script upload file pertama

						if ($this->input->post('sub_maqasid') == "product_knowledge")  {

							$this->upload->do_upload('file_product_knowledge');
					        $file_product_knowledge = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								
								'file_product_knowledge' => $upload_path.'/'.$file_product_knowledge['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if( $this->input->post('sub_maqasid') == "komplain") { 

					     
							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'tanggal_kejadian' => $this->input->post('tanggal_kejadian'),		
								'tanggal_komplain' => $this->input->post('tanggal_komplain'),	
								'pihak_komplain' => $this->input->post('pihak_komplain'),	
								'bentuk_komplain' => $this->input->post('bentuk_komplain'),
								'tindakan_diambil' => $this->input->post('tindakan_diambil'),
								'tindakan_perlu_diambil' => $this->input->post('tindakan_perlu_diambil'),
								'status' => $this->input->post('status'),
								
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if( $this->input->post('sub_maqasid') == "funding") { 

					     	$this->upload->do_upload('file_funding');
					        $file_funding = $this->upload->data();

							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'target_funding' => $this->input->post('target_funding'),		
								'realisasi_funding' => $this->input->post('realisasi_funding'),			
								'file_funding' => $upload_path.'/'.$file_funding['file_name'],	
								
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if( $this->input->post('sub_maqasid') == "lending") { 

					     	$this->upload->do_upload('file_lending');
					        $file_lending = $this->upload->data();

							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'target_lending' => $this->input->post('target_lending'),		
								'realisasi_lending' => $this->input->post('realisasi_lending'),			
								'file_lending' => $upload_path.'/'.$file_lending['file_name'],	
								
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if( $this->input->post('sub_maqasid') == "collection") { 

					     	$this->upload->do_upload('file_collection');
					        $file_collection = $this->upload->data();

							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'target_collection' => $this->input->post('target_collection'),		
								'realisasi_collection' => $this->input->post('realisasi_collection'),			
								'file_collection' => $upload_path.'/'.$file_collection['file_name'],	
								
								'date' => date('Y-m-d : h:i:s'),

							);

						} else if( $this->input->post('sub_maqasid') == "npf") { 

					     	$this->upload->do_upload('file_npf');
					        $file_npf = $this->upload->data();

							//if ($upload_data) {		
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),						
							
								'target_npf' => $this->input->post('target_npf'),		
								'realisasi_npf' => $this->input->post('realisasi_npf'),			
								'file_npf' => $upload_path.'/'.$file_npf['file_name'],	
								
								'date' => date('Y-m-d : h:i:s'),

							);

						}

						$data = $this->security->xss_clean($data);
						$result = $this->unit_model->add_marketing($data);
						if($result){
							$this->session->set_flashdata('msg', 'Data telah disimpan!');
							redirect(base_url('admin/unit/detail_unit/'. $kantor. "/". $id));
						}
								
						//}				
							
						

			}
			else{
				$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
				$data['unit'] = $this->unit_model->get_unit_by_id($id);
				$data['detail_unit'] = $this->unit_model->get_unit_by_kantor($id,$kantor);
				$data['view'] = 'admin/unit/detail_unit';
				$this->load->view('layout', $data);
			}

		}

		public function add_digimark($kantor = 0, $id = 0, $maqasid) {	

			if($this->input->post('submit')){				

						$upload_path = './uploads/auditor';

						if (!is_dir($upload_path)) {
						     mkdir($upload_path, 0777, TRUE);					
						}
						//$newName = "hrd-".date('Ymd-His');
						$config = array(
							'upload_path' => $upload_path,
							'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
							'overwrite' => FALSE,						
						);

						$this->load->library('upload', $config);
				         // script upload file pertama

						if ($this->input->post('sub_maqasid') == "konten_edukatif")  {

							$this->upload->do_upload('file_konten_edukatif');
					        $file_konten_edukatif = $this->upload->data();
					    
							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'konten_edukatif' => $this->input->post('konten_edukatif'),					
								'file_konten_edukatif' => $upload_path.'/'.$file_konten_edukatif['file_name'],
								'date' => date('Y-m-d : h:i:s'),
							);
						} else if ($this->input->post('sub_maqasid') == "respon_masyarakat")  {

							$this->upload->do_upload('file_respon_masyarakat');
					        $file_respon_masyarakat = $this->upload->data();

							$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'respon_masyarakat' => $this->input->post('respon_masyarakat'),				
								'file_respon_masyarakat' => $upload_path.'/'.$file_respon_masyarakat['file_name'],
								'date' => date('Y-m-d : h:i:s'),

							);
						} else if ($this->input->post('sub_maqasid') == "respon_negatif")  {

							$this->upload->do_upload('file_respon_negatif');
					        $file_respon_negatif = $this->upload->data();

					     	$data = array(
								'id_kantor' => $kantor,	
								'maqasid' => $this->input->post('maqasid'),
								'sub_maqasid' => $this->input->post('sub_maqasid'),	
								'respon_negatif' => $this->input->post('respon_negatif'),				
								'file_respon_negatif' => $upload_path.'/'.$file_respon_negatif['file_name'],

								'date' => date('Y-m-d : h:i:s'),

							);
						} 

						$data = $this->security->xss_clean($data);
						$result = $this->unit_model->add_digimark($data);
						if($result){
							$this->session->set_flashdata('msg', 'Data telah disimpan!');
							redirect(base_url('admin/unit/detail_unit/'. $kantor. "/". $id));
						}
								
						//}							

			}
			else{
				$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
				$data['unit'] = $this->unit_model->get_unit_by_id($id);
				$data['view'] = 'admin/unit/detail_unit';
				$this->load->view('layout', $data);
			}

		}

		public function lihat_unit( $kantor=0, $id=0, $sub_maqasid){
			
			$data['kantor'] = $this->unit_model->get_kantor_by_id($kantor);
			$data['unit'] = $this->unit_model->get_unit_by_id($id);
			$data['detail_unit'] = $this->unit_model->get_unit_by_kantor($kantor, $id, $sub_maqasid);
			$data['title'] = 'Unit Kerja';
			$data['view'] = 'admin/unit/lihat_unit';
			$this->load->view('layout', $data);
			
		}	
	}
?>