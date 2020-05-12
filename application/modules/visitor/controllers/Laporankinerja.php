<?php defined('BASEPATH') or exit('No direct script access allowed');

class Laporankinerja extends MY_Controller
{
	//private $filename = "import_data";

	public function __construct()
	{
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('laporankinerja/laporankinerja_model', 'laporankinerja_model');
	}

	public function index()
	{
		redirect(base_url('visitor/laporankinerja/pencapaian_perbidang'), 'refresh'); 
	}

	public function pencapaian_perbidang($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->laporankinerja_model->get_tahun_pencapaian_perbidang();
		$data['pencapaian_perbidang'] = $this->laporankinerja_model->get_pencapaian_perbidang($tahun);
		$data['view'] = 'visitor/laporankinerja/pencapaian_perbidang';
		$this->load->view('admin/layout', $data);
	}
	public function detail_pencapaian_perbidang($bulan=0, $tahun = 0)
	{
		$data['tahun'] = $this->laporankinerja_model->get_tahun_pencapaian_perbidang();
		$data['pencapaian_perbidang'] = $this->laporankinerja_model->get_detail_pencapaian_perbidang($bulan, $tahun);
		$data['view'] = 'visitor/laporankinerja/detail_pencapaian_perbidang';
		$this->load->view('admin/layout', $data);
	}

	public function export_pencapaian_perbidang($bulan,$tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'laporan_pencapaian_output_perbidang_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->laporankinerja_model->get_detail_pencapaian_perbidang($bulan, $tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Pencapaian Output Perbidang Bulan ". konversiBulanAngkaKeNama($bulan). " " . $tahun)
			->setSubject("Laporan Pencapaian Output Perbidang Bulan ". konversiBulanAngkaKeNama($bulan). " " . $tahun)
			->setDescription("Laporan Pencapaian Output Perbidang Bulan ". konversiBulanAngkaKeNama($bulan). " " . $tahun)
			->setKeywords("Laporan Operasional Akumulasi");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Pencapaian Output Perbidang Bulan ". konversiBulanAngkaKeNama($bulan). " " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:E2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->getActiveSheet()->SetCellValue('A4', 'No');
		$excel->getActiveSheet()->SetCellValue('B4', 'Bidang');
		$excel->getActiveSheet()->SetCellValue('C4', 'Target');
		$excel->getActiveSheet()->SetCellValue('D4', 'Realisasi');
		$excel->getActiveSheet()->SetCellValue('E4', 'Persentase');
		
		$no=1;
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bidang']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['target']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['realisasi']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['persentase']);
		

			//stile column No
			// $excel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray($style_td);

			//header style lainnya
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				$excel->getActiveSheet()->getStyle($i . $rowCount)->applyFromArray($style_td);
			}

			//style column BPS/laporankinerja
			$excel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($style_td_left);

			$rowCount++;
			$no++;
		}
		//header style
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '4')->applyFromArray($style_header);
		}
		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . $last_row)->applyFromArray($style_td_bold);
		}
		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}

		$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A9')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A13')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A14')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A15')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A18')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A19')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A22')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A23')->getFont()->setBold(TRUE);

		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}


		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	public function penyerapan_perbidang($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->laporankinerja_model->get_tahun_penyerapan_perbidang();
		$data['penyerapan_perbidang'] = $this->laporankinerja_model->get_penyerapan_perbidang($tahun);
		$data['view'] = 'visitor/laporankinerja/penyerapan_perbidang';
		$this->load->view('admin/layout', $data);
	}
	public function detail_penyerapan_perbidang($bulan=0, $tahun = 0)
	{
		$data['tahun'] = $this->laporankinerja_model->get_tahun_penyerapan_perbidang();
		$data['penyerapan_perbidang'] = $this->laporankinerja_model->get_detail_penyerapan_perbidang($bulan, $tahun);
		$data['view'] = 'visitor/laporankinerja/detail_penyerapan_perbidang';
		$this->load->view('admin/layout', $data);
	}
	public function export_penyerapan_perbidang($bulan,$tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'laporan_penyerapan_output_perbidang_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->laporankinerja_model->get_detail_penyerapan_perbidang($bulan, $tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Penyerapan Anggaran Perbidang Bulan ". konversiBulanAngkaKeNama($bulan). " " . $tahun)
			->setSubject("Laporan Penyerapan Anggaran Perbidang Bulan ". konversiBulanAngkaKeNama($bulan). " " . $tahun)
			->setDescription("Laporan Penyerapan Anggaran Perbidang Bulan ". konversiBulanAngkaKeNama($bulan). " " . $tahun)
			->setKeywords("Laporan Operasional Akumulasi");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Penyerapan Anggaran Perbidang Bulan ". konversiBulanAngkaKeNama($bulan). " " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:F2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->getActiveSheet()->SetCellValue('A4', 'No');
		$excel->getActiveSheet()->SetCellValue('B4', 'Bidang');
		$excel->getActiveSheet()->SetCellValue('C4', 'RKAT-P');
		$excel->getActiveSheet()->SetCellValue('D4', 'RKAT-P Efisiensi');
		$excel->getActiveSheet()->SetCellValue('E4', 'Realisasi');
		$excel->getActiveSheet()->SetCellValue('F4', 'Persentase');
		
		$no=1;
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bidang']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['target']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['efisiensi']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['realisasi']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['persentase']);
		

			//stile column No
			// $excel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray($style_td);

			//header style lainnya
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				$excel->getActiveSheet()->getStyle($i . $rowCount)->applyFromArray($style_td);
			}

			//style column BPS/laporankinerja
			$excel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($style_td_left);

			$rowCount++;
			$no++;
		}
		//header style
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '4')->applyFromArray($style_header);
		}
		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . $last_row)->applyFromArray($style_td_bold);
		}
		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}

		$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A9')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A13')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A14')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A15')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A18')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A19')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A22')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A23')->getFont()->setBold(TRUE);

		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}


		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}
} //class
