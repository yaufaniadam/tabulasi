<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory; 
	use PhpOffice\PhpSpreadsheet\Style\Alignment; 
	
	class Kemaslahatan extends Admin_Controller {
	
		public function __construct(){
			parent::__construct();
			$this->load->library('excel');
			$this->load->model('kemaslahatan_model', 'kemaslahatan_model');
			$this->load->model('kemaslahatan/kemaslahatan_model', 'kemaslahatan_model');
		}

		public function index( $tahun=0 ){		
			$tahun = ($tahun !='') ? $tahun : date('Y');
			$data['thn'] = $tahun;
			$data['tahun'] = $this->kemaslahatan_model->get_tahun_kemaslahatan();
			$data['kemaslahatan'] = $this->kemaslahatan_model->get_kemaslahatan($tahun);
			$data['view'] = 'index';
			$this->load->view('admin/layout', $data);
		}
		

		public function tambah_kemaslahatan(){	
			
			if(isset($_POST['submit'])){ 

			    $upload_path = './uploads/excel/kemaslahatan';

				if (!is_dir($upload_path)) {
				    mkdir($upload_path, 0777, TRUE);					
				}
						//$newName = "hrd-".date('Ymd-His');
				$config = array(
					'upload_path' => $upload_path,
					'allowed_types' => "xlsx",
					'overwrite' => FALSE,				
				);					

				$this->load->library('upload', $config);
				$this->upload->do_upload('file');
				$upload = $this->upload->data();

			      
			    if($upload){ // Jika proses upload sukses

			        $excelreader = new Xlsx;
			        $loadexcel = $excelreader->load('./uploads/excel/kemaslahatan/'.$upload['file_name']); // Load file yang tadi diupload ke folder excel
			        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			        
			        $data['sheet'] = $sheet; 
			        $data['file_excel'] =$upload['file_name'];			       

			        $data['view'] = 'tambah_kemaslahatan';
    				$this->load->view('admin/layout', $data);

			    }else{ 
			    	
			        echo "gagal";
			        $data['view'] = 'tambah_kemaslahatan';
    				$this->load->view('admin/layout', $data);

			    }
		    } else {

				$data['view'] = 'tambah_kemaslahatan';
    			$this->load->view('admin/layout', $data);

		    }

		}

		public function import_kemaslahatan($file_excel){
		
		    $excelreader = new Xlsx;
		    $loadexcel = $excelreader->load('./uploads/excel/kemaslahatan/'.$file_excel); // Load file yang telah diupload ke folder excel
		    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);			   	
		  
		    $data2 = array();

			$numrow = 1;
			
			foreach($sheet as $row){
				
			    if($numrow > 1){
				    // Kita push (add) array data ke variabel data
				    array_push($data2, array(
				    	'nama_penerima'=>$row['C'],
					    'jenis'=>$row['D'],
					    'mitra'=>$row['E'],
					    'lokasi'=>$row['F'],
					    'kegiatan'=>$row['G'],
					    'asnaf'=>$row['H'],	
					    'nilai'=>$row['I'],    						
						'bulan'=>konversi_bulan_ke_angka($row['A']),
						'tahun'=>$row['B'],	        
				    ));
				}
			      
			    $numrow++; // Tambah 1 setiap kali looping
			}

		    
		    // Panggil fungsi insert_kemaslahatan
		  	$this->kemaslahatan_model->insert_kemaslahatan($data2);
		
		    redirect("kemaslahatan"); // Redirect ke halaman awal (ke controller siswa fungsi index)
		}

		public function hapus_kemaslahatan($id = 0, $uri = NULL){	
			$this->db->delete('program_kemaslahatan', array('id' => $id));
			$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
			redirect(base_url('kemaslahatan/index/'.$uri));
		}
		
		public function export_kemaslahatan($tahun){

			// ambil style untuk table dari library Excel.php
			$style_header = $this->excel->style('style_header');
			$style_td = $this->excel->style('style_td');
			$style_td_left = $this->excel->style('style_td_left');
			$style_td_bold = $this->excel->style('style_td_bold');

			// create file name
			
	        $fileName = 'program_kemaslahatan_'.$tahun.'-('. date('d-m-Y H-i-s', time()) .').xlsx';  

	        $sebaran = $this->kemaslahatan_model->get_kemaslahatan($tahun);
	        $excel = new Spreadsheet;

	        // Settingan awal file excel
			$excel->getProperties()->setCreator('BPKH')
             		->setLastModifiedBy('BPKH')
             		->setTitle("Program Kemaslahatan Tahun " .$tahun)
             		->setSubject("Program Kemaslahatan Tahun " .$tahun)
             		->setDescription("Program Kemaslahatan Tahun " .$tahun)
             		->setKeywords("Investasi Lainnya");        

			//judul baris ke 1
			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Program Kemaslahatan Tahun " .$tahun); // 
			$excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai F1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			//sub judul baris ke 2
			$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); 
			$excel->getActiveSheet()->mergeCells('A2:F2'); // Set Merge Cell pada kolom A1 sampai F1
			$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


	        $excel->setActiveSheetIndex(0);
	        // set Header
	        $excel->getActiveSheet()->SetCellValue('A4', 'No.');
	        $excel->getActiveSheet()->SetCellValue('B4', 'Bulan');
	        $excel->getActiveSheet()->SetCellValue('C4', 'Tahun');
	        $excel->getActiveSheet()->SetCellValue('D4', 'Nama Penerima');
	        $excel->getActiveSheet()->SetCellValue('E4', 'Jenis');
	        $excel->getActiveSheet()->SetCellValue('F4', 'Mitra');
	        $excel->getActiveSheet()->SetCellValue('G4', 'Lokasi');
	        $excel->getActiveSheet()->SetCellValue('H4', 'Kegiatan');
	        $excel->getActiveSheet()->SetCellValue('I4', 'Asnaf');  
	        $excel->getActiveSheet()->SetCellValue('J4', 'Nilai');  
	         
	        //no 
	        $no = 1;
	        // set Row
	        $rowCount = 5;
	        $last_row = count($sebaran)+4;
	        foreach ($sebaran as $element) {
	        	$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
	            $excel->getActiveSheet()->SetCellValue('B' . $rowCount, konversiBulanAngkaKeNama($element['bulan']));
	            $excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['tahun']);
	            $excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['nama_penerima']);
	            $excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['jenis']);
	            $excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['mitra']);
	            $excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['lokasi']);
	            $excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['kegiatan']);
	            $excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['asnaf']);
	            $excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['nilai']);

	            //stile column No
	           	// $excel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray($style_td);
	            
	            //header style lainnya
	       		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			    	 $excel->getActiveSheet()->getStyle($i.$rowCount)->applyFromArray($style_td);
				}   

				//style column BPS/BPIH
	           	//$excel->getActiveSheet()->getStyle('B'.$rowCount)->applyFromArray($style_td_left);	            

	            $rowCount++;
	            $no++;
	        }
        
			
	        //header style
	       	for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			    $excel->getActiveSheet()->getStyle($i.'4')->applyFromArray($style_header);
			}
	       	// last row style    		
	      	 	for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			    $excel->getActiveSheet()->getStyle($i.$last_row)->applyFromArray($style_td_bold);
			} 
			
			

	        /* Set judul file excel n
			$excel->getActiveSheet(0)->setTitle("Posisi Penempatan Thn " . $tahun);
			$excel->setActiveSheetIndex(0); */

	        $objWriter = IOFactory::createWriter($excel, "Xlsx");
	        $objWriter->save('./uploads/excel/'.$fileName);
	   		// download file
	        header("Content-Type: application/vnd.ms-excel");
	        redirect('./uploads/excel/'.$fileName); 			

		}		

		public function regulasi_tentang_kemaslahatan(){			
			$data['id'] = 'regulasi_tentang_kemaslahatan';
			$data['class'] = 'penerima_manfaat';			
			$data['judul'] = 'Regulasi Tentang Kemaslahatan';
			$data['dokumen'] = $this->kemaslahatan_model->get_dokumen('regulasi_kemaslahatan');
			$data['view'] = 'regulasi_kemaslahatan';
    		$this->load->view('admin/layout', $data);
		}

		public function tambah_dokumentasi($id){
			if($this->input->post('submit')){

				$this->form_validation->set_rules('judul_foto', 'Judul Foto', 'trim|required');
					
				if ($this->form_validation->run() == FALSE) {					
				
					$data['view'] = 'kemaslahatan/tambah_dokumentasi';
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
						$this->upload->do_upload('file_foto');
					    $dokumen = $this->upload->data();							

						$data = array(
									
							'judul_foto' => $this->input->post('judul_foto'),
							'foto' => $upload_path.'/'.$dokumen['file_name'],	
							'id_kemaslahatan' => $id									
							
						);
									
						$data = $this->security->xss_clean($data);
						$result = $this->kemaslahatan_model->tambah_dokumentasi($data);

						if($result){
							$this->session->set_flashdata('msg', 'Foto telah ditambahkan!');
							redirect(base_url('kemaslahatan/tambah_dokumentasi/'. $id));							
						} 

					} 

				}

				else{					
					$data['nama_penerima'] = $this->kemaslahatan_model->get_penerima($id);
					$data['dokumentasi'] = $this->kemaslahatan_model->get_dokumentasi($id);
					$data['view'] = 'kemaslahatan/tambah_dokumentasi';
    				$this->load->view('admin/layout', $data);
				}
		}

	} //class

