<?php defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use PhpOffice\PhpSpreadsheet\Style\Alignment; 
class Datajemaah extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('datajemaah/datajemaah_model', 'datajemaah_model');
		$this->load->library('excel');
	}

	public function index()
	{
		redirect(base_url('visitor/datajemaah/antri'));
	}

	public function antri()
	{
		$id_kat = 2;
		$data['kat'] = $id_kat;
		$data['judul'] = "Data Jemaah Antri";
		$data['antri'] = $this->datajemaah_model->get_datajemaah($id_kat);
		$data['view'] = 'datajemaah/index';
		$this->load->view('admin/layout', $data);
	}
	public function kuota()
	{
		$id_kat = 3;
		$data['kat'] = $id_kat;
		$data['judul'] = "Data Kuota Jemaah Berangkat";
		$data['antri'] = $this->datajemaah_model->get_datajemaah($id_kat);
		$data['view'] = 'datajemaah/index';
		$this->load->view('admin/layout', $data);
	}
	public function batal()
	{
		$id_kat = 1;
		$data['kat'] = $id_kat;
		$data['judul'] = "Data Jemaah Batal Berangkat";
		$data['antri'] = $this->datajemaah_model->get_datajemaah($id_kat);
		$data['view'] = 'datajemaah/index';
		$this->load->view('admin/layout', $data);
	}
	public function bipih()
	{
		$id_kat = 4;
		$data['kat'] = $id_kat;
		$data['judul'] = "Data Reaslisasi Bipih";
		$data['antri'] = $this->datajemaah_model->get_datajemaah($id_kat);
		$data['view'] = 'datajemaah/index';
		$this->load->view('admin/layout', $data);
	}
	public function bpih()
	{
		$id_kat = 5;
		$data['kat'] = $id_kat;
		$data['judul'] = "Data Realisasi BPIH";
		$data['antri'] = $this->datajemaah_model->get_datajemaah($id_kat);
		$data['view'] = 'datajemaah/index';
		$this->load->view('admin/layout', $data);
	}



	public function realisasi_bpih()
	{
		$data['tahun'] = $this->datajemaah_model->get_tahun_realisasi_bpih();
		$data['realisasi_bpih'] = $this->datajemaah_model->get_realisasi_bpih();
		$data['view'] = 'datajemaah/realisasi_bpih';
		$this->load->view('admin/layout', $data);
	}
	public function detail_realisasi_bpih( $tahun = 0)
	{
		$data['tahun'] = $this->datajemaah_model->get_tahun_realisasi_bpih();
		$data['realisasi_bpih'] = $this->datajemaah_model->get_detail_realisasi_bpih( $tahun);
		$data['view'] = 'datajemaah/detail_realisasi_bpih';
		$this->load->view('admin/layout', $data);
	}

	

	public function export_realisasi_bpih($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'laporan_realisasi_bpih_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->datajemaah_model->get_detail_realisasi_bpih($tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new Spreadsheet;

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Realisasi BPIH Tahun " . $tahun)
			->setSubject("Laporan Realisasi BPIH Tahun " . $tahun)
			->setDescription("Laporan Realisasi BPIH Tahun " . $tahun)
			->setKeywords("Laporan Operasional Akumulasi");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Realisasi BPIH Tahun " . konversiBulanAngkaKeNama($bulan) . " " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:E2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->getActiveSheet()->SetCellValue('A4', 'No');
		$excel->getActiveSheet()->SetCellValue('B4', 'Bidang');
		$excel->getActiveSheet()->SetCellValue('C4', 'Target');
		$excel->getActiveSheet()->SetCellValue('D4', 'Realisasi');
		$excel->getActiveSheet()->SetCellValue('E4', 'Persentase');

		$no = 1;
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

			//style column BPS/BPIH
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


		$objWriter = IOFactory::createWriter($excel, "Xlsx");
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}
	
} //class
