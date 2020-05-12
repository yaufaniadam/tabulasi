<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Postertentu extends Admin_Controller {
		//private $filename = "import_data";

		public function __construct(){
			parent::__construct();
			$this->load->model('postertentu_model', 'postertentu_model');
			$this->load->library('excel');
		}

		public function index( ){				
			$data['view'] = 'Postertentu/index';
			$this->load->view('admin/layout', $data);
		}
		
		public function portfolio_investasi($tahun=0){

			$tahun = ($tahun !='') ? $tahun : date('Y');

			$data['thn'] = $tahun;
			$data['tahun'] = $this->postertentu_model->get_tahun_portfolio_investasi();
			$data['portfolio_investasi'] = $this->postertentu_model->get_portfolio_investasi($tahun);
			$data['view'] = 'Postertentu/portfolio_investasi';
			$this->load->view('admin/layout', $data);
		}

		public function detail_portfolio_investasi($id=0){

			$data['portfolio_investasi'] = $this->postertentu_model->get_detail_portfolio_investasi($id);
			$data['view'] = 'Postertentu/detail_portfolio_investasi';
			$this->load->view('admin/layout', $data);
		}

		public function tambah_portfolio_investasi(){	
			
			if(isset($_POST['submit'])){ 

			    $upload_path = './uploads/excel/postertentu';

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

			  
			        $excelreader = new PHPExcel_Reader_Excel2007();
			        $loadexcel = $excelreader->load('./uploads/excel/postertentu/'.$upload['file_name']); // Load file yang tadi diupload ke folder excel
			        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			        
			        $data['sheet'] = $sheet; 
			        $data['file_excel'] =$upload['file_name'];
			       

			        $data['view'] = 'Postertentu/tambah_portfolio_investasi';
    				$this->load->view('admin/layout', $data);

			    }else{ 
			    	
			        echo "gagal";
			        $data['view'] = 'Postertentu/tambah_portfolio_investasi';
    				$this->load->view('admin/layout', $data);

			    }
		    } else {

				$data['view'] = 'Postertentu/tambah_portfolio_investasi';
    			$this->load->view('admin/layout', $data);

		    }

		}

		public function import_portfolio_investasi($file_excel){
	
		    $excelreader = new PHPExcel_Reader_Excel2007();
		    $loadexcel = $excelreader->load('./uploads/excel/postertentu/'.$file_excel); // Load file yang telah diupload ke folder excel
		    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);		    

		   	$data = transposeData($sheet);

		    $dataquery = array (
		    		'investasi'=>$data['B'][2],
		    		'per_jangka_waktu'=>$data['B'][3],
		    		'jk_pendek'=>$data['B'][4],
					'jk_panjang'=>$data['B'][5],
					'per_jenis_produk'=>$data['B'][6],
					'sukuk'=>$data['B'][7],
					'negara_pemerintah'=>$data['B'][8],
					'korporasi'=>$data['B'][9],
					'reksadana'=>$data['B'][10],
					'investasi_non_sb'=>$data['B'][11],
					'emas'=>$data['B'][12],
					'langsung'=>$data['B'][13],
					'penyertaan'=>$data['B'][14],
					'per_sumber_kas_haji'=>$data['B'][15],
					'setoran_jemaah_haji'=>$data['B'][16],
					'dau'=>$data['B'][17],					
					'bulan'=>$data['B'][1],
					'tahun'=>$data['C'][1],
		    	);

		   

		    // Panggil fungsi insert_portfolio_investasi
		  	$this->postertentu_model->insert_portfolio_investasi($dataquery);
		
		    redirect("keuanganhaji/postertentu/portfolio_investasi"); // Redirect ke halaman awal (ke controller siswa fungsi index)
		}

		public function hapus_portfolio_investasi($id = 0, $uri = NULL){	
			$this->db->delete('portfolio_investasi', array('id_portfolio_investasi' => $id));
			$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
			redirect(base_url('keuanganhaji/postertentu/portfolio_investasi'));
		}

		public function export_portfolio_investasi($tahun){

			// ambil style untuk table dari library Excel.php
			$style_header = $this->excel->style('style_header');
			$style_td = $this->excel->style('style_td');
			$style_td_left = $this->excel->style('style_td_left');
			$style_td_bold = $this->excel->style('style_td_bold');

			// create file name
			
	        $fileName = 'portfolio_investasi_'.$tahun.'-('. date('d-m-Y H-i-s', time()) .').xlsx';  

	        $sebaran = $this->postertentu_model->get_portfolio_investasi($tahun);
	        $maxcolumn = konversiAngkaKeHuruf(count($sebaran)+1);
	        $excel = new PHPExcel();

	        // Settingan awal file excel
			$excel->getProperties()->setCreator('BPKH')
             		->setLastModifiedBy('BPKH')
             		->setTitle("Portfolio Investasi BPKH Tahun " .$tahun)
             		->setSubject("Portfolio Investasi BPKH Tahun " .$tahun)
             		->setDescription("Portfolio Investasi BPKH Tahun " .$tahun)
             		->setKeywords("Portfolio Investasi BPKH");        

			//judul baris ke 1
			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Portfolio Investasi BPKH Tahun " .$tahun); // 
			$excel->getActiveSheet()->mergeCells('A1:'.$maxcolumn.'1'); // Set Merge Cell pada kolom A1 sampai F1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			//sub judul baris ke 2
			$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); 
			$excel->getActiveSheet()->mergeCells('A2:'.$maxcolumn.'2'); // Set Merge Cell pada kolom A1 sampai F1
			$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

	        $excel->getActiveSheet()->SetCellValue('A4', 'Uraian');
	        $excel->getActiveSheet()->SetCellValue('A5', 'INVESTASI');
	        $excel->getActiveSheet()->SetCellValue('A6', 'PER JANGKA WAKTU');
	        $excel->getActiveSheet()->SetCellValue('A7', 'Jangka Pendek');
	        $excel->getActiveSheet()->SetCellValue('A8', 'Jangka Panjang');
	        $excel->getActiveSheet()->SetCellValue('A9', 'PER JENIS PRODUK');
	        $excel->getActiveSheet()->SetCellValue('A10', 'Sukuk');
	        $excel->getActiveSheet()->SetCellValue('A11', '- Negara / Pemerintah');
	        $excel->getActiveSheet()->SetCellValue('A12', '- Korporasi');
	        $excel->getActiveSheet()->SetCellValue('A13', 'Reksadana');
	        $excel->getActiveSheet()->SetCellValue('A14', 'Investasi Non SB');
	        $excel->getActiveSheet()->SetCellValue('A15', '- Emas');
	        $excel->getActiveSheet()->SetCellValue('A16', '- Langsung');
	        $excel->getActiveSheet()->SetCellValue('A17', 'Penyertaan');
	        $excel->getActiveSheet()->SetCellValue('A18', 'PER SUMBER KAS HAJI');
	        $excel->getActiveSheet()->SetCellValue('A19', 'Setoran Jemaah Haji');
	        $excel->getActiveSheet()->SetCellValue('A20', 'DAU');
  

	        $i = 2;
			foreach ($sebaran as $element) {
				//echo $element['bulan'];echo konversiAngkaKeHuruf($i);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 4, $element['bulan']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 5, $element['investasi']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 6, $element['per_jangka_waktu']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 7, $element['jk_pendek']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 8, $element['jk_panjang']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 9, $element['per_jenis_produk']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 10, $element['sukuk']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 11, $element['negara_pemerintah']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 12, $element['korporasi']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 13, $element['reksadana']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 14, $element['investasi_non_sb']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 15, $element['emas']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 16, $element['langsung']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 17, $element['penyertaan']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 18, $element['per_sumber_kas_haji']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 19, $element['setoran_jemaah_haji']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 20, $element['dau']);
			    $i++;

			    
			}    

			//header style
	       	for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			    $excel->getActiveSheet()->getStyle($i.'4')->applyFromArray($style_header);
			}
			//td style
			for($baris = 5; $baris <= 20; $baris++) {
		       	for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				    $excel->getActiveSheet()->getStyle($i.$baris)->applyFromArray($style_td);
				}
			}

			for($i = 5; $i <=20 ; $i++) {
	         $excel->getActiveSheet()->getStyle('A'. $i)->applyFromArray($style_td_left);	
			}

			$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE); 
			$excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE); 
			$excel->getActiveSheet()->getStyle('A9')->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('A18')->getFont()->setBold(TRUE);  
	       
			//auto column width
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			    $excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
			}
  	
        	
			

	        $objWriter = new PHPExcel_Writer_Excel2007($excel);
	        $objWriter->save('./uploads/excel/'.$fileName);
	   		// download file
	        header("Content-Type: application/vnd.ms-excel");
	        redirect('./uploads/excel/'.$fileName); 			

		}

		public function manfaat_investasi($tahun=0){

			$tahun = ($tahun !='') ? $tahun : date('Y');

			$data['thn'] = $tahun;
			$data['tahun'] = $this->postertentu_model->get_tahun_manfaat_investasi();
			$data['manfaat_investasi'] = $this->postertentu_model->get_manfaat_investasi($tahun);
			$data['view'] = 'Postertentu/manfaat_investasi';
			$this->load->view('admin/layout', $data);
		}

		public function detail_manfaat_investasi($id=0){

			$data['manfaat_investasi'] = $this->postertentu_model->get_detail_manfaat_investasi($id);
			$data['view'] = 'Postertentu/detail_manfaat_investasi';
			$this->load->view('admin/layout', $data);
		}

		public function tambah_manfaat_investasi(){	
			
			if(isset($_POST['submit'])){ 

			    $upload_path = './uploads/excel/postertentu';

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

			        $excelreader = new PHPExcel_Reader_Excel2007();
			        $loadexcel = $excelreader->load('./uploads/excel/postertentu/'.$upload['file_name']); // Load file yang tadi diupload ke folder excel
			        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			        
			        $data['sheet'] = $sheet; 
			        $data['file_excel'] =$upload['file_name'];
			       

			        $data['view'] = 'Postertentu/tambah_manfaat_investasi';
    				$this->load->view('admin/layout', $data);

			    }else{ 
			    	
			        echo "gagal";
			        $data['view'] = 'Postertentu/tambah_manfaat_investasi';
    				$this->load->view('admin/layout', $data);

			    }
		    } else {

				$data['view'] = 'Postertentu/tambah_manfaat_investasi';
    			$this->load->view('admin/layout', $data);

		    }

		}

		public function import_manfaat_investasi($file_excel){
		   
		    $excelreader = new PHPExcel_Reader_Excel2007();
		    $loadexcel = $excelreader->load('./uploads/excel/postertentu/'.$file_excel); // Load file yang telah diupload ke folder excel
		    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);		    

		   	$data = transposeData($sheet);

		    $dataquery = array (
		    		'investasi'=>$data['B'][2],
		    		'per_jangka_waktu'=>$data['B'][3],
		    		'jk_pendek'=>$data['B'][4],
					'jk_panjang'=>$data['B'][5],
					'per_jenis_produk'=>$data['B'][6],
					'sukuk'=>$data['B'][7],
					'negara_pemerintah'=>$data['B'][8],
					'korporasi'=>$data['B'][9],
					'reksadana'=>$data['B'][10],
					'accrued_interest_jual_pbs'=>$data['B'][11],
					'investasi_non_sb'=>$data['B'][12],
					'emas'=>$data['B'][13],
					'langsung'=>$data['B'][14],
					'penyertaan'=>$data['B'][15],
					'capital_gain_sbsn'=>$data['B'][16],
					'lain_lain'=>$data['B'][17],
					'per_sumber_kas_haji'=>$data['B'][18],
					'setoran_jemaah_haji'=>$data['B'][19],
					'dau'=>$data['B'][20],					
					'bulan'=>$data['B'][1],
					'tahun'=>$data['C'][1],
		    	);

		   

		    // Panggil fungsi insert_manfaat_investasi
		  	$this->postertentu_model->insert_manfaat_investasi($dataquery);
		
		    redirect("keuanganhaji/postertentu/manfaat_investasi"); // Redirect ke halaman awal (ke controller siswa fungsi index)
		}

		public function hapus_manfaat_investasi($id = 0, $uri = NULL){	
			$this->db->delete('manfaat_investasi', array('id_manfaat_investasi' => $id));
			$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
			redirect(base_url('keuanganhaji/postertentu/manfaat_investasi'));
		}

		public function export_manfaat_investasi($tahun){

			// ambil style untuk table dari library Excel.php
			$style_header = $this->excel->style('style_header');
			$style_td = $this->excel->style('style_td');
			$style_td_left = $this->excel->style('style_td_left');
			$style_td_bold = $this->excel->style('style_td_bold');

			// create file name
			
	        $fileName = 'manfaat_investasi_'.$tahun.'-('. date('d-m-Y H-i-s', time()) .').xlsx';  

	        $sebaran = $this->postertentu_model->get_manfaat_investasi($tahun);
	        $maxcolumn = konversiAngkaKeHuruf(count($sebaran)+1);

	        $excel = new PHPExcel();

	        // Settingan awal file excel
			$excel->getProperties()->setCreator('BPKH')
             		->setLastModifiedBy('BPKH')
             		->setTitle("Nilai Manfaat Investasi BPKH Tahun " .$tahun)
             		->setSubject("Nilai Manfaat Investasi BPKH Tahun " .$tahun)
             		->setDescription("Nilai Manfaat Investasi BPKH Tahun " .$tahun)
             		->setKeywords("Nilai Manfaat Investasi BPKH");        

			//judul baris ke 1
			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Nilai Manfaat Investasi BPKH Tahun " .$tahun); // 
			$excel->getActiveSheet()->mergeCells('A1:'.$maxcolumn.'1'); // Set Merge Cell pada kolom A1 sampai F1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			//sub judul baris ke 2
			$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); 
			$excel->getActiveSheet()->mergeCells('A2:'.$maxcolumn.'2'); // Set Merge Cell pada kolom A1 sampai F1
			$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

	        $excel->getActiveSheet()->SetCellValue('A4', 'Uraian');
	        $excel->getActiveSheet()->SetCellValue('A5', 'INVESTASI');
	        $excel->getActiveSheet()->SetCellValue('A6', 'PER JANGKA WAKTU');
	        $excel->getActiveSheet()->SetCellValue('A7', 'Jangka Pendek');
	        $excel->getActiveSheet()->SetCellValue('A8', 'Jangka Panjang');
	        $excel->getActiveSheet()->SetCellValue('A9', 'PER JENIS PRODUK');
	        $excel->getActiveSheet()->SetCellValue('A10', 'Sukuk');
	        $excel->getActiveSheet()->SetCellValue('A11', '- Negara / Pemerintah');
	        $excel->getActiveSheet()->SetCellValue('A12', '- Korporasi');
	        $excel->getActiveSheet()->SetCellValue('A13', 'Reksadana');
	        $excel->getActiveSheet()->SetCellValue('A14', 'Accurued Interest Jual PBS');
	        $excel->getActiveSheet()->SetCellValue('A15', 'Investasi Non SB');
	        $excel->getActiveSheet()->SetCellValue('A16', '- Emas');
	        $excel->getActiveSheet()->SetCellValue('A17', '- Langsung');
	        $excel->getActiveSheet()->SetCellValue('A18', 'Penyertaan');
	        $excel->getActiveSheet()->SetCellValue('A19', 'Capital Gain SBSN');
	        $excel->getActiveSheet()->SetCellValue('A20', 'Lain-lain');
	        $excel->getActiveSheet()->SetCellValue('A21', 'PER SUMBER KAS HAJI');
	        $excel->getActiveSheet()->SetCellValue('A22', 'Setoran Jemaah Haji');
	        $excel->getActiveSheet()->SetCellValue('A23', 'DAU');
  

	        $i = 2;
			foreach ($sebaran as $element) {
				//echo $element['bulan'];echo konversiAngkaKeHuruf($i);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 4, $element['bulan']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 5, $element['investasi']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 6, $element['per_jangka_waktu']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 7, $element['jk_pendek']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 8, $element['jk_panjang']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 9, $element['per_jenis_produk']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 10, $element['sukuk']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 11, $element['negara_pemerintah']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 12, $element['korporasi']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 13, $element['reksadana']);

	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 14, $element['accrued_interest_jual_pbs']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 15, $element['investasi_non_sb']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 16, $element['emas']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 17, $element['langsung']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 18, $element['penyertaan']);

	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 19, $element['capital_gain_sbsn']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 20, $element['lain_lain']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 21, $element['per_sumber_kas_haji']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 22, $element['setoran_jemaah_haji']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 23, $element['dau']);
			    $i++;

			    
			}    

			//header style
	       	for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			    $excel->getActiveSheet()->getStyle($i.'4')->applyFromArray($style_header);
			}
			//td style
			for($baris = 5; $baris <= 23; $baris++) {
		       	for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				    $excel->getActiveSheet()->getStyle($i.$baris)->applyFromArray($style_td);
				}
			}

			for($i = 5; $i <=23 ; $i++) {
	         $excel->getActiveSheet()->getStyle('A'. $i)->applyFromArray($style_td_left);	
			}

			$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE); 
			$excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE); 
			$excel->getActiveSheet()->getStyle('A9')->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('A21')->getFont()->setBold(TRUE);  
	       
			//auto column width
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			    $excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
			}
  		
  		    $objWriter = new PHPExcel_Writer_Excel2007($excel);
	        $objWriter->save('./uploads/excel/'.$fileName);
	   		// download file
	        header("Content-Type: application/vnd.ms-excel");
	        redirect('./uploads/excel/'.$fileName); 			

		}

	} //class

