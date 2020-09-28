<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Laporankeuangan extends Admin_Controller
{
	//private $filename = "import_data";

	public function __construct()
	{
		parent::__construct();
		$this->load->library('excel');

		$this->load->model('laporankeuangan_model', 'laporankeuangan_model');
	}

	public function index()
	{
		$data['view'] = 'index';
		$this->load->view('admin/layout', $data);
	}



	public function neraca($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_neraca();
		$data['neraca'] = $this->laporankeuangan_model->get_neraca($tahun);
		$data['view'] = 'neraca';
		$this->load->view('admin/layout', $data);
	}
	public function detail_neraca($bulan = 0, $tahun = 0)
	{
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_neraca();
		$data['neraca'] = $this->laporankeuangan_model->get_detail_neraca($bulan, $tahun);
		$data['view'] = 'detail_neraca';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_neraca()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel/laporankeuangan';

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


			if ($upload) { // Jika proses upload sukses			    	

				$excelreader = new Xlsx;
				$loadexcel = $excelreader->load('./uploads/excel/laporankeuangan/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];


				$data['view'] = 'tambah_neraca';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_neraca';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_neraca';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_neraca($file_excel)
	{

		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/laporankeuangan/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		$data2 = array();

		$numrow = 1;
		foreach ($sheet as $row) {

			if ($numrow > 1) {
				// Kita push (add) array data ke variabel data
				array_push($data2, array(
					'bidang' => $row['A'],
					'target' => $row['B'],
					'bulan' => konversi_bulan_ke_angka($data["B"][1]),
					'tahun' => $data["C"][1],
				));
			}

			$numrow++; // Tambah 1 setiap kali looping
		}

		// Panggil fungsi insert_neraca
		$this->laporankeuangan_model->insert_neraca($data2);

		redirect("laporankeuangan/neraca"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_neraca($bulan = 0, $tahun = 0, $uri = NULL)
	{
		$this->db->delete('neraca2', array('bulan' => $bulan, 'tahun' => $tahun));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('laporankeuangan/neraca/' . $tahun));
	}

	public function export_neraca($bulan, $tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');
		$style_td_bold_no_bg = $this->excel->style('style_td_bold_no_bg');

		// create file name

		$fileName = 'laporan_operasional_bulanan' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->laporankeuangan_model->get_detail_neraca($bulan, $tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new Spreadsheet;

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setSubject("Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setDescription("Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setKeywords("Laporan Operasional Bulanan");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:B1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:B2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->getActiveSheet()->SetCellValue('A4', 'Uraian');
		$excel->getActiveSheet()->SetCellValue('B4', konversiBulanAngkaKeNama($bulan));

		$excel->getActiveSheet()->SetCellValue('A5', '');
		$excel->getActiveSheet()->SetCellValue('B5', '');

		$no = 1;
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {

			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['bidang']);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['target']);


			//stile column No
			// $excel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray($style_td);

			//header style lainnya
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				$excel->getActiveSheet()->getStyle($i . $rowCount)->applyFromArray($style_td);
			}

			//style column BPS/BPIH
			$excel->getActiveSheet()->getStyle('A' . $rowCount)->applyFromArray($style_td_left);

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

		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '8')->applyFromArray($style_td_bold_no_bg);
		}
		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '12')->applyFromArray($style_td_bold_no_bg);
		}
		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '15')->applyFromArray($style_td_bold_no_bg);
			$excel->getActiveSheet()->getStyle($i . '16')->applyFromArray($style_td_bold_no_bg);
			$excel->getActiveSheet()->getStyle($i . '18')->applyFromArray($style_td_bold_no_bg);
		}

		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}

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

	public function lap_bulanan($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_lap_bulanan();
		$data['lap_bulanan'] = $this->laporankeuangan_model->get_lap_bulanan($tahun);
		$data['view'] = 'lap_bulanan';
		$this->load->view('admin/layout', $data);
	}
	public function detail_lap_bulanan($bulan = 0, $tahun = 0)
	{
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_lap_bulanan();
		$data['lap_bulanan'] = $this->laporankeuangan_model->get_detail_lap_bulanan($bulan, $tahun);
		$data['view'] = 'detail_lap_bulanan';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_lap_bulanan()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel/laporankeuangan';

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


			if ($upload) { // Jika proses upload sukses			    	

				$excelreader = new Xlsx;
				$loadexcel = $excelreader->load('./uploads/excel/laporankeuangan/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];


				$data['view'] = 'tambah_lap_bulanan';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_lap_bulanan';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_lap_bulanan';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_lap_bulanan($file_excel)
	{

		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/laporankeuangan/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		$data2 = array();

		$numrow = 1;
		foreach ($sheet as $row) {

			if ($numrow > 1) {
				// Kita push (add) array data ke variabel data
				array_push($data2, array(
					'bidang' => $row['A'],
					'target' => $row['B'],
					'bulan' => konversi_bulan_ke_angka($data["B"][1]),
					'tahun' => $data["C"][1],
				));
			}

			$numrow++; // Tambah 1 setiap kali looping
		}

		// Panggil fungsi insert_lap_bulanan
		$this->laporankeuangan_model->insert_lap_bulanan($data2);

		redirect("laporankeuangan/lap_bulanan"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_lap_bulanan($bulan = 0, $tahun = 0, $uri = NULL)
	{
		$this->db->delete('lap_bulanan2', array('bulan' => $bulan, 'tahun' => $tahun));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('laporankeuangan/lap_bulanan/' . $tahun));
	}

	public function export_lap_bulanan($bulan, $tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');
		$style_td_bold_no_bg = $this->excel->style('style_td_bold_no_bg');

		// create file name

		$fileName = 'laporan_operasional_bulanan' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->laporankeuangan_model->get_detail_lap_bulanan($bulan, $tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new Spreadsheet;

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setSubject("Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setDescription("Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setKeywords("Laporan Operasional Bulanan");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:B1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:B2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->getActiveSheet()->SetCellValue('A4', 'Uraian');
		$excel->getActiveSheet()->SetCellValue('B4', konversiBulanAngkaKeNama($bulan));

		$excel->getActiveSheet()->SetCellValue('A5', '');
		$excel->getActiveSheet()->SetCellValue('B5', '');

		$no = 1;
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {

			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['bidang']);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['target']);


			//stile column No
			// $excel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray($style_td);

			//header style lainnya
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				$excel->getActiveSheet()->getStyle($i . $rowCount)->applyFromArray($style_td);
			}

			//style column BPS/BPIH
			$excel->getActiveSheet()->getStyle('A' . $rowCount)->applyFromArray($style_td_left);

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

		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '8')->applyFromArray($style_td_bold_no_bg);
		}
		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '12')->applyFromArray($style_td_bold_no_bg);
		}
		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '15')->applyFromArray($style_td_bold_no_bg);
			$excel->getActiveSheet()->getStyle($i . '16')->applyFromArray($style_td_bold_no_bg);
			$excel->getActiveSheet()->getStyle($i . '18')->applyFromArray($style_td_bold_no_bg);
		}

		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}

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

	public function lap_akumulasi($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_lap_akumulasi();
		$data['lap_akumulasi'] = $this->laporankeuangan_model->get_lap_akumulasi($tahun);
		$data['view'] = 'lap_akumulasi';
		$this->load->view('admin/layout', $data);
	}
	public function detail_lap_akumulasi($bulan = 0, $tahun = 0)
	{
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_lap_akumulasi();
		$data['lap_akumulasi'] = $this->laporankeuangan_model->get_detail_lap_akumulasi($bulan, $tahun);
		$data['view'] = 'detail_lap_akumulasi';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_lap_akumulasi()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel/laporankeuangan';

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


			if ($upload) { // Jika proses upload sukses			    	

				$excelreader = new Xlsx;
				$loadexcel = $excelreader->load('./uploads/excel/laporankeuangan/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];


				$data['view'] = 'tambah_lap_akumulasi';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_lap_akumulasi';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_lap_akumulasi';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_lap_akumulasi($file_excel)
	{


		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/laporankeuangan/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		$data2 = array();

		$numrow = 1;
		foreach ($sheet as $row) {

			if ($numrow > 1) {
				// Kita push (add) array data ke variabel data
				array_push($data2, array(
					'bidang' => $row['A'],
					'target' => $row['B'],
					'bulan' => konversi_bulan_ke_angka($data["B"][1]),
					'tahun' => $data["C"][1],
				));
			}

			$numrow++; // Tambah 1 setiap kali looping
		}



		// Panggil fungsi insert_lap_akumulasi
		$this->laporankeuangan_model->insert_lap_akumulasi($data2);

		redirect("laporankeuangan/lap_akumulasi"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_lap_akumulasi($bulan = 0, $tahun = 0, $uri = NULL)
	{
		$this->db->delete('lap_akumulasi2', array('bulan' => $bulan, 'tahun' => $tahun));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('laporankeuangan/lap_akumulasi/' . $tahun));
	}

	public function export_lap_akumulasi($bulan, $tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');
		$style_td_bold_no_bg = $this->excel->style('style_td_bold_no_bg');

		// create file name

		$fileName = 'laporan_operasional_akumulasi' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->laporankeuangan_model->get_detail_lap_akumulasi($bulan, $tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new Spreadsheet;

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Operasional Akumulasi  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setSubject("Laporan Operasional Akumulasi  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setDescription("Laporan Operasional Akumulasi  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setKeywords("Laporan Operasional Akumulasi");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Operasional Akumulasi  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:B1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:B2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->getActiveSheet()->SetCellValue('A4', 'Uraian');
		$excel->getActiveSheet()->SetCellValue('B4', konversiBulanAngkaKeNama($bulan));

		$excel->getActiveSheet()->SetCellValue('A5', '');
		$excel->getActiveSheet()->SetCellValue('B5', '');

		$no = 1;
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {

			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['bidang']);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['target']);


			//stile column No
			// $excel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray($style_td);

			//header style lainnya
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				$excel->getActiveSheet()->getStyle($i . $rowCount)->applyFromArray($style_td);
			}

			//style column BPS/BPIH
			$excel->getActiveSheet()->getStyle('A' . $rowCount)->applyFromArray($style_td_left);

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

		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '8')->applyFromArray($style_td_bold_no_bg);
		}
		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '12')->applyFromArray($style_td_bold_no_bg);
		}
		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '15')->applyFromArray($style_td_bold_no_bg);
			$excel->getActiveSheet()->getStyle($i . '16')->applyFromArray($style_td_bold_no_bg);
			$excel->getActiveSheet()->getStyle($i . '18')->applyFromArray($style_td_bold_no_bg);
		}

		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}

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

	public function perubahan_asetneto($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_perubahan_asetneto();
		$data['perubahan_asetneto'] = $this->laporankeuangan_model->get_perubahan_asetneto($tahun);
		$data['view'] = 'perubahan_asetneto';
		$this->load->view('admin/layout', $data);
	}
	public function detail_perubahan_asetneto($bulan = 0, $tahun = 0)
	{
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_perubahan_asetneto();
		$data['perubahan_asetneto'] = $this->laporankeuangan_model->get_detail_perubahan_asetneto($bulan, $tahun);
		$data['view'] = 'detail_perubahan_asetneto';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_perubahan_asetneto()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel/laporankeuangan';

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


			if ($upload) { // Jika proses upload sukses			    	

				$excelreader = new Xlsx;
				$loadexcel = $excelreader->load('./uploads/excel/laporankeuangan/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];


				$data['view'] = 'tambah_perubahan_asetneto';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_perubahan_asetneto';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_perubahan_asetneto';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_perubahan_asetneto($file_excel)
	{

		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/laporankeuangan/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		$data2 = array();

		$numrow = 1;
		foreach ($sheet as $row) {

			if ($numrow > 1) {
				// Kita push (add) array data ke variabel data
				array_push($data2, array(
					'bidang' => $row['A'],
					'target' => $row['B'],
					'bulan' => konversi_bulan_ke_angka($data["B"][1]),
					'tahun' => $data["C"][1],
				));
			}

			$numrow++; // Tambah 1 setiap kali looping
		}

		// Panggil fungsi insert_perubahan_asetneto
		$this->laporankeuangan_model->insert_perubahan_asetneto($data2);

		redirect("laporankeuangan/perubahan_asetneto"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_perubahan_asetneto($bulan = 0, $tahun = 0, $uri = NULL)
	{
		$this->db->delete('perubahan_asetneto2', array('bulan' => $bulan, 'tahun' => $tahun));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('laporankeuangan/perubahan_asetneto/' . $tahun));
	}

	public function export_perubahan_asetneto($bulan, $tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');
		$style_td_bold_no_bg = $this->excel->style('style_td_bold_no_bg');

		// create file name

		$fileName = 'laporan_operasional_bulanan' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->laporankeuangan_model->get_detail_perubahan_asetneto($bulan, $tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new Spreadsheet;

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setSubject("Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setDescription("Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun)
			->setKeywords("Laporan Operasional Bulanan");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Operasional Bulanan  Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:B1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:B2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->getActiveSheet()->SetCellValue('A4', 'Uraian');
		$excel->getActiveSheet()->SetCellValue('B4', konversiBulanAngkaKeNama($bulan));

		$excel->getActiveSheet()->SetCellValue('A5', '');
		$excel->getActiveSheet()->SetCellValue('B5', '');

		$no = 1;
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {

			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['bidang']);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['target']);


			//stile column No
			// $excel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray($style_td);

			//header style lainnya
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				$excel->getActiveSheet()->getStyle($i . $rowCount)->applyFromArray($style_td);
			}

			//style column BPS/BPIH
			$excel->getActiveSheet()->getStyle('A' . $rowCount)->applyFromArray($style_td_left);

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

		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '8')->applyFromArray($style_td_bold_no_bg);
		}
		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '12')->applyFromArray($style_td_bold_no_bg);
		}
		// last row style    		
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '15')->applyFromArray($style_td_bold_no_bg);
			$excel->getActiveSheet()->getStyle($i . '16')->applyFromArray($style_td_bold_no_bg);
			$excel->getActiveSheet()->getStyle($i . '18')->applyFromArray($style_td_bold_no_bg);
		}

		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}

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

	public function realisasi_anggaran($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_realisasi_anggaran();
		$data['realisasi_anggaran'] = $this->laporankeuangan_model->get_realisasi_anggaran($tahun);
		$data['view'] = 'realisasi_anggaran';
		$this->load->view('admin/layout', $data);
	}
	public function detail_realisasi_anggaran($bulan = 0, $tahun = 0)
	{
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_realisasi_anggaran();
		$data['realisasi_anggaran'] = $this->laporankeuangan_model->get_detail_realisasi_anggaran($bulan, $tahun);
		$data['view'] = 'detail_realisasi_anggaran';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_realisasi_anggaran()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel/bpih';

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


			if ($upload) { // Jika proses upload sukses			    	

				$excelreader = new Xlsx;
				$loadexcel = $excelreader->load('./uploads/excel/bpih/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];


				$data['view'] = 'tambah_realisasi_anggaran';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_realisasi_anggaran';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_realisasi_anggaran';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_realisasi_anggaran($file_excel)
	{


		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/bpih/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		$data2 = array();

		$numrow = 1;
		foreach ($sheet as $row) {

			if ($numrow > 1) {
				// Kita push (add) array data ke variabel data
				array_push($data2, array(
					'bidang' => $row['A'],
					'target' => $row['B'],
					'realisasi' => $row['C'],
					'persentase' => $row['D'],
					'bulan' => konversi_bulan_ke_angka($data["E"][1]),
					'tahun' => $data["F"][1],
					'upload_by' => $this->session->userdata('user_id'),
				));
			}

			$numrow++; // Tambah 1 setiap kali looping
		}



		// Panggil fungsi insert_realisasi_anggaran
		$this->laporankeuangan_model->insert_realisasi_anggaran($data2);

		redirect("laporankeuangan/realisasi_anggaran"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_realisasi_anggaran($bulan = 0, $tahun = 0, $uri = NULL)
	{
		$this->db->delete('realisasi_anggaran2', array('bulan' => $bulan, 'tahun' => $tahun));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('bpih/realisasi_anggaran/' . $tahun));
	}

	public function export_realisasi_anggaran($bulan, $tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'laporan_pencapaian_output_perbidang_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->laporankeuangan_model->get_detail_realisasi_anggaran($bulan, $tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new Spreadsheet;

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Realisasi Anggaran Bulan " . $bulan . " " . $tahun)
			->setSubject("Laporan Realisasi Anggaran Bulan " . $bulan . " " . $tahun)
			->setDescription("Laporan Realisasi Anggaran Bulan " . $bulan . " " . $tahun)
			->setKeywords("Laporan Operasional Akumulasi");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Realisasi Anggaran Bulan " . konversiBulanAngkaKeNama($bulan) . " " . $tahun); // 
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


	public function lap_arus_kas($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');
		$data['thn'] = $tahun;
		$data['tahun'] = $this->laporankeuangan_model->get_tahun_lap_arus_kas();
		$data['lap_arus_kas'] = $this->laporankeuangan_model->get_lap_arus_kas($tahun);
		$data['view'] = 'lap_arus_kas';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_lap_arus_kas()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel/laporankeuangan';

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


			if ($upload) { // Jika proses upload sukses

				$excelreader = new Xlsx;
				$loadexcel = $excelreader->load('./uploads/excel/laporankeuangan/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];


				$data['view'] = 'tambah_lap_arus_kas';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_lap_arus_kas';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_lap_arus_kas';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_lap_arus_kas($file_excel)
	{

		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/laporankeuangan/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		$dataquery = array(
			'penerima_nilai_manfaat' => $data['B'][3],
			'penerimaan_operasional_efisiensi' => $data['B'][4],
			'penerimaan_jamaah_tdk_brkt' => $data['B'][5],
			'penerimaan_lain' => $data['B'][6],
			'pengeluaran_transfer_pih_dari_manfaat' => $data['B'][7],
			'pengeluaran_pajak_manfaat' => $data['B'][8],
			'operasional_bpkh' => $data['B'][9],
			'pengeluaran_kemaslahatan_umat' => $data['B'][10],
			'kas_bersih_aktivasi_operasi' => $data['B'][11],
			'pembelian_aset_tetap' => $data['B'][13],
			'pembelian_aset_takwujud' => $data['B'][14],
			'penempatan_net' => $data['B'][15],
			'investasi_net' => $data['B'][16],
			'kas_bersih_aktivasi_investasi' => $data['B'][17],
			'penerimaan_setoran_jamaah' => $data['B'][19],
			'pengeluaran_transfer_pih_dr_jamaah' => $data['B'][20],
			'pengeluaran_pengembalian_bpih' => $data['B'][21],
			'pengeluaran_nilai_manfaat_ditangguhkan' => $data['B'][22],
			'kas_bersih_aktivasi_pendanaan' => $data['B'][23],
			'kenaikan_kas_setarakas' => $data['B'][24],
			'kas_setara_kas_2' => $data['B'][25],
			'kas_setara_kas_1' => $data['B'][26],
			'tahun' => $data['C'][1],
			'bulan' =>  konversi_bulan_ke_angka($data['B'][1]),
			'upload_by' => $this->session->userdata('user_id'),
		);

		// Panggil fungsi insert_lap_arus_kas
		$this->laporankeuangan_model->insert_lap_arus_kas($dataquery);

		redirect("laporankeuangan/lap_arus_kas"); // Redirect ke halaman awal (ke controller siswa fungsi index)


	}

	public function hapus_lap_arus_kas($id = 0, $uri = NULL)
	{
		$this->db->delete('lap_arus_kas', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('laporankeuangan/lap_arus_kas'));
	}

	public function export_lap_arus_kas($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'laporan_arus_kas_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->laporankeuangan_model->get_lap_arus_kas($tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new Spreadsheet;

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Arus Kas Tahun " . $tahun)
			->setSubject("Laporan Arus Kas Tahun " . $tahun)
			->setDescription("Laporan Arus Kas Tahun " . $tahun)
			->setKeywords("Laporan Operasional Bulanan");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Arus Kas Tahun " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:' . $maxcolumn . '1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:' . $maxcolumn . '2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->getActiveSheet()->SetCellValue('A4', 'BULAN');
		$excel->getActiveSheet()->SetCellValue('A5', 'Arus Kas dari Aktivitas Operasi');
		$excel->getActiveSheet()->SetCellValue('A6', 'Penerimaan nilai manfaat
		');
		$excel->getActiveSheet()->SetCellValue('A7', 'Penerimaan operasional efisiensi haji');
		$excel->getActiveSheet()->SetCellValue('A8', 'Penerimaan dana jemaah tidak berangkat 1439 H/2018 M');
		$excel->getActiveSheet()->SetCellValue('A9', 'Penerimaaan lain-lain');
		$excel->getActiveSheet()->SetCellValue('A10', 'Pengeluaran transfer penyelenggaraan ibadah haji dari nilai manfaat');
		$excel->getActiveSheet()->SetCellValue('A11', 'Pengeluaran beban pajak nilai manfaat');
		$excel->getActiveSheet()->SetCellValue('A12', 'Pengeluaran operasional BPKH');
		$excel->getActiveSheet()->SetCellValue('A13', 'Pengeluaran kegiatan untuk kemaslahatan umat Islam');
		$excel->getActiveSheet()->SetCellValue('A14', 'Kas Bersih yang diperoleh dari Aktivitas Operasi');
		$excel->getActiveSheet()->SetCellValue('A15', 'Arus Kas Dari Aktivitas Investasi');
		$excel->getActiveSheet()->SetCellValue('A16', 'Pembelian aset tetap');
		$excel->getActiveSheet()->SetCellValue('A17', 'Pembelian aset tak berwujud');
		$excel->getActiveSheet()->SetCellValue('A18', 'Penempatan (net)');
		$excel->getActiveSheet()->SetCellValue('A19', 'Investasi (net)');
		$excel->getActiveSheet()->SetCellValue('A20', 'Kas Bersih yang diperoleh dari Aktivitas Investasi');
		$excel->getActiveSheet()->SetCellValue('A21', 'Arus Kas Dari Aktivitas Pendanaan');
		$excel->getActiveSheet()->SetCellValue('A22', 'Penerimaan setoran jemaah');
		$excel->getActiveSheet()->SetCellValue('A23', 'Pengeluaran transfer penyelenggaraan ibadah haji dari setoran jamaah');
		$excel->getActiveSheet()->SetCellValue('A24', 'Pengeluaran untuk pengembalian dan pembatalan BPIH');
		$excel->getActiveSheet()->SetCellValue('A25', 'Pengeluaran nilai manfaat yang ditangguhkan');
		$excel->getActiveSheet()->SetCellValue('A26', 'Kas Bersih yang diperoleh dari Aktivitas Pendanaan');
		$excel->getActiveSheet()->SetCellValue('A27', 'Kenaikan (penurunan) Kas dan Setara Kas');
		$excel->getActiveSheet()->SetCellValue('A28', 'Kas dan Setara Kas Pada Awal Tahun');
		$excel->getActiveSheet()->SetCellValue('A29', 'Kas dan Setara Kas Pada Akhir Tahun');


		$i = 2;
		foreach ($sebaran as $element) {
			//echo $element['bulan'];echo konversiAngkaKeHuruf($i);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 4,  konversiBulanAngkaKeNama($element['bulan']));
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 6, $element['kas_pih']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 7, $element['kas_nilai_manfaat']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 8, $element['realisasi_pend_tangguhan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 9, $element['beban_pih']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 10, $element['beban_va']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 11, $element['beban_kemaslahatan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 12, $element['belanja_pegawai']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 13, $element['belanja_admin_umum']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 14, $element['pembayaran_utang']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 15, $element['untung_selisih_kurs']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 16, $element['kas_bersih_aktivasi_operasi']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 18, $element['pembelian_aset_tetap']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 19, $element['pembelian_aset_takwujud']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 20, $element['penempatan_net']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 21, $element['investasi_net']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 22, $element['kas_bersih_aktivasi_investasi']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 24, $element['setoran_awal_waitinglist']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 25, $element['pengeluaran_pendapatan_ditangguhkan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 26, $element['kas_bersih_aktivasi_pendanaan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 27, $element['kenaikan_kas_setarakas']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 28, $element['kas_setara_kas_2']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 29, $element['kas_setara_kas_1']);

			$i++;
		}

		//header style
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '4')->applyFromArray($style_header);
		}
		//td style
		for ($baris = 5; $baris <= 29; $baris++) {
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				$excel->getActiveSheet()->getStyle($i . $baris)->applyFromArray($style_td);
			}
		}

		for ($i = 5; $i <= 29; $i++) {
			$excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($style_td_left);
		}

		$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A14')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A15')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A20')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A21')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A26')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A27')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A28')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A29')->getFont()->setBold(TRUE);

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
