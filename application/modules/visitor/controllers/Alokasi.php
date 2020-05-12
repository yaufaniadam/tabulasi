<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Alokasi extends MY_Controller {
		//private $filename = "import_data";

		public function __construct(){
			parent::__construct();
			$this->load->library('excel');	
			$this->load->model('alokasi/alokasi_model', 'alokasi_model');
		}

		public function index( $tahun=0 ){;

			$tahun = ($tahun !='') ? $tahun : date('Y');

			$data['thn'] = $tahun;
			$data['tahun'] = $this->alokasi_model->get_tahun_alokasi_investasi();
			$data['alokasi_investasi'] = $this->alokasi_model->get_alokasi_investasi($tahun);
			$data['view'] = 'alokasi/index';
			$this->load->view('admin/layout', $data);
		}

		public function detail_alokasi_investasi($id=0){

			$data['alokasi_investasi'] = $this->alokasi_model->get_detail_alokasi_investasi($id);
			$data['view'] = 'alokasi/detail_alokasi_investasi';
			$this->load->view('admin/layout', $data);
		}

		
		public function export_alokasi_investasi($tahun){

			// ambil style untuk table dari library Excel.php
			$style_header = $this->excel->style('style_header');
			$style_td = $this->excel->style('style_td');
			$style_td_left = $this->excel->style('style_td_left');
			$style_td_bold = $this->excel->style('style_td_bold');

			// create file name
			
	        $fileName = 'alokasi_investasi_'.$tahun.'-('. date('d-m-Y H-i-s', time()) .').xlsx';  

	        $sebaran = $this->alokasi_model->get_alokasi_investasi($tahun);
	        $bulan = $this->alokasi_model->get_bulan_alokasi_investasi($tahun);

	        $maxcolumn = konversiAngkaKeHuruf(count($bulan)+1);

	        $excel = new PHPExcel();

	        // Settingan awal file excel
			$excel->getProperties()->setCreator('BPKH')
             		->setLastModifiedBy('BPKH')
             		->setTitle(" Alokasi Investasi BPKH Tahun " .$tahun)
             		->setSubject(" Alokasi Investasi BPKH Tahun " .$tahun)
             		->setDescription(" Alokasi Investasi BPKH Tahun " .$tahun)
             		->setKeywords("Posisi Sebaran Dana Haji");            

			//judul baris ke 1
			$excel->setActiveSheetIndex(0)->setCellValue('A1', " Alokasi Investasi BPKH Tahun " .$tahun); // Set kolom A1 dengan tulisan "DATA SISWA"
			$excel->getActiveSheet()->mergeCells('A1:'.$maxcolumn.'1' ); // Set Merge Cell pada kolom A1 sampai F1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			//sub judul baris ke 2
			$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 dengan tulisan "DATA SISWA"
			$excel->getActiveSheet()->mergeCells('A2:'.$maxcolumn.'2'); // Set Merge Cell pada kolom A1 sampai F1
			$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


	        $excel->setActiveSheetIndex(0);
	        // set Header
	        $excel->getActiveSheet()->SetCellValue('A4', 'Investasi');
	        $excel->getActiveSheet()->SetCellValue('A5', 'Per Jangka Waktu');
	        $excel->getActiveSheet()->SetCellValue('A6', 'Jangka Pendek');
	        $excel->getActiveSheet()->SetCellValue('A7', 'Jangka Panjang');
	        $excel->getActiveSheet()->SetCellValue('A8', 'Per Jenis Produk');
	        $excel->getActiveSheet()->SetCellValue('A9', 'Sukuk');
	        $excel->getActiveSheet()->SetCellValue('A10', 'Reksadana');
	        $excel->getActiveSheet()->SetCellValue('A11', 'Penyertaan');
	        $excel->getActiveSheet()->SetCellValue('A12', 'Per Sumber Kas');
	        $excel->getActiveSheet()->SetCellValue('A13', 'Setoran Jemaah Haji');
	        $excel->getActiveSheet()->SetCellValue('A14', 'DAU');
  

	        $i = 2;
			foreach ($sebaran as $element) {
				//echo $element['bulan'];echo konversiAngkaKeHuruf($i);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 4, $element['bulan']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 5, $element['per_jangka_waktu']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 6, $element['jk_pendek']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 7, $element['jk_panjang']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 8, $element['per_jenis_produk']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 9, $element['sukuk']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 10, $element['reksadana']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 11, $element['penyertaan']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 12, $element['per_sumber_kas_haji']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 13, $element['setoran_jemaah_haji']);
	        	$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 14, $element['dau']);
			    $i++;

			    
			}  
	        		  

	        //header style
	       	for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			    $excel->getActiveSheet()->getStyle($i.'4')->applyFromArray($style_header);
			}
			//td style
			for($baris = 5; $baris <= 14; $baris++) {
		       	for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				    $excel->getActiveSheet()->getStyle($i.$baris)->applyFromArray($style_td);
				}
			}

			for($i = 5; $i <=14 ; $i++) {
	         $excel->getActiveSheet()->getStyle('A'. $i)->applyFromArray($style_td_left);	
			}

			$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE); 
			$excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE); 
			$excel->getActiveSheet()->getStyle('A12')->getFont()->setBold(TRUE); 
	       
			//auto column width
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			    $excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
			}

	        // Set judul file excel nya
			$excel->getActiveSheet(0)->setTitle("Posisi Sebaran Dana Haji" . $tahun);
			$excel->setActiveSheetIndex(0);

	        $objWriter = new PHPExcel_Writer_Excel2007($excel);
	        $objWriter->save('./uploads/excel/'.$fileName);
	   		// download file
	        header("Content-Type: application/vnd.ms-excel");
	        redirect('./uploads/excel/'.$fileName);

		}

	} //class

