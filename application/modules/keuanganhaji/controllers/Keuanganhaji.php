<?php defined('BASEPATH') or exit('No direct script access allowed');

class Keuanganhaji extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('keuanganhaji_model', 'keuanganhaji_model');
		$this->load->model('alokasi_model', 'alokasi_model');
		$this->load->library('excel');
	}

	public function index()
	{
		$data['view'] = 'index';
		$this->load->view('admin/layout', $data);
	}

	public function total_dana_kelolaan_non_dau()
	{
		$data['view'] = 'total_dana_kelolaan_non_dau';
		$this->load->view('admin/layout', $data);
	}

	public function total_dana_kelolaan_dau()
	{
		$data['view'] = 'total_dana_kelolaan_dau';
		$this->load->view('admin/layout', $data);
	}

	// SEBARAN DANA HAJI
	public function porsi_penempatan_bps_bpih($tahun = 0)
	{
		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_sebaran_dana_haji(); // untuk menu pilihan tahun
		$data['sebaran_dana_haji'] = $this->keuanganhaji_model->get_sebaran_dana_haji($tahun);

		$data['view'] = 'keuanganhaji/posisi_sebaran_dana_haji';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_porsi_penempatan_bps_bpih()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();

			if ($upload) { // Jika proses upload sukses	    
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_porsi_penempatan_bps_bpih';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_porsi_penempatan_bps_bpih';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_porsi_penempatan_bps_bpih';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_porsi_penempatan_bps_bpih($file_excel)
	{

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum
		$this->db->select('*');
		$this->db->from('porsi_penempatan_bps_bpih2');
		$this->db->where('tahun', $data["C"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('bps_bpih');
				$this->db->from('porsi_penempatan_bps_bpih2');
				$this->db->where('bps_bpih', $data["A"][$i]);
				$bps_bpih_check = $this->db->get()->result();

				if (count($bps_bpih_check) > 0) {

					$query = array(
						$data["B"][1] => $data["B"][$i]
					);

					$this->db->update('porsi_penempatan_bps_bpih2', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'bps_bpih' => $data["A"][$i],
						$data["B"][1] => $data["B"][$i],
						'tahun' => $data["C"][1],
					);
					$this->db->insert('porsi_penempatan_bps_bpih2', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/bps_bpih

			$data2 = array();

			$numrow = 1;
			$bulan = $sheet['1']['B'];
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'bps_bpih' => $row['A'], // Insert data nis dari kolom A di
						$sheet['1']['B'] => $row['B'],
						'tahun' => $data["C"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->keuanganhaji_model->insert_porsi_penempatan_bps_bpih($data2);
		}

		redirect("keuanganhaji/porsi_penempatan_bps_bpih"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_porsi_penempatan_bps_bpih($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'porsi_penempatan_bps_bpih_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_porsi_penempatan_bps_bpih($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Porsi Penempatan di Bank BPS-BPIH Tahun " . $tahun)
			->setSubject("Porsi Penempatan di Bank BPS-BPIH Tahun " . $tahun)
			->setDescription("Porsi Penempatan di Bank BPS-BPIH Tahun " . $tahun)
			->setKeywords("Porsi Penempatan di Bank BPS-BPIH");



		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Porsi Penempatan di Bank BPS-BPIH Tahun " . $tahun); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A2:N2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'BPS BPIH');
		$excel->getActiveSheet()->SetCellValue('C4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('D4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('E4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('F4', 'April');
		$excel->getActiveSheet()->SetCellValue('G4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('H4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('I4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('J4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('K4', 'September');
		$excel->getActiveSheet()->SetCellValue('L4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('M4', 'November');
		$excel->getActiveSheet()->SetCellValue('N4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bps_bpih']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['desember']);

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

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	// SEBARAN DANA HAJI
	public function sebaran_dana_haji($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_sebaran_dana_haji(); // untuk menu pilihan tahun
		$data['sebaran_dana_haji'] = $this->keuanganhaji_model->get_sebaran_dana_haji($tahun);

		$data['view'] = 'keuanganhaji/posisi_sebaran_dana_haji';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_sebaran_dana_haji()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_sebaran_dana_haji';
				$this->load->view('admin/layout', $data);
			} else {
				echo "gagal";
				$data['view'] = 'tambah_sebaran_dana_haji';
				$this->load->view('admin/layout', $data);
			}
		} else {
			$data['view'] = 'tambah_sebaran_dana_haji';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_sebaran_dana_haji($file_excel)
	{
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum
		$this->db->select('*');
		$this->db->from('sebaran_dana_haji2');
		$this->db->where('tahun', $data["C"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('bps_bpih');
				$this->db->from('sebaran_dana_haji2');
				$this->db->where('bps_bpih', $data["A"][$i]);
				$bps_bpih_check = $this->db->get()->result();

				if (count($bps_bpih_check) > 0) {

					$query = array(
						$data["B"][1] => $data["B"][$i]
					);

					$this->db->update('sebaran_dana_haji2', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'bps_bpih' => $data["A"][$i],
						$data["B"][1] => $data["B"][$i],
						'tahun' => $data["C"][1],
					);
					$this->db->insert('sebaran_dana_haji2', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/bps_bpih

			$data2 = array();

			$numrow = 1;
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'bps_bpih' => $row['A'], // Insert data nis dari kolom A di
						$sheet['1']['B'] => $row['B'],
						'tahun' => $data["C"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->keuanganhaji_model->insert_sebaran_dana_haji($data2);
		}

		redirect("keuanganhaji/sebaran_dana_haji"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_sebaran_dana_haji($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'posisi_sebaran_dana_haji_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_sebaran_dana_haji($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Posisi Sebaran Dana Haji Tahun " . $tahun)
			->setSubject("Posisi Sebaran Dana Haji Tahun " . $tahun)
			->setDescription("Posisi Sebaran Dana Haji Tahun " . $tahun)
			->setKeywords("Posisi Sebaran Dana Haji");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Posisi Sebaran Dana Haji Tahun " . $tahun); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A2:N2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'BPS BPIH');
		$excel->getActiveSheet()->SetCellValue('C4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('D4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('E4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('F4', 'April');
		$excel->getActiveSheet()->SetCellValue('G4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('H4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('I4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('J4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('K4', 'September');
		$excel->getActiveSheet()->SetCellValue('L4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('M4', 'November');
		$excel->getActiveSheet()->SetCellValue('N4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bps_bpih']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['desember']);

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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Posisi Sebaran Dana Haji" . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	//SDHI RUPIAH

	public function sdhi_rupiah($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_sdhi_rupiah(); // untuk menu pilihan tahun
		$data['sdhi_rupiah'] = $this->keuanganhaji_model->get_sdhi_rupiah($tahun);

		$data['view'] = 'keuanganhaji/sdhi_rupiah';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_sdhi_rupiah()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses		        

				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_sdhi_rupiah';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_sdhi_rupiah';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_sdhi_rupiah';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_sdhi_rupiah($file_excel)
	{

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum

		$this->db->select('*');
		$this->db->from('sdhi_rupiah');
		$this->db->where('tahun', $data["D"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	
			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah Instrumen sudah ada pada tabel
				$this->db->select('instrumen');
				$this->db->from('sdhi_rupiah');
				$this->db->where('instrumen', $data["A"][$i]);
				$this->db->where('tahun', $data["D"][1]);
				$instrumen_check = $this->db->get()->result();

				if (count($instrumen_check) > 0) {

					$query = array(
						$data["C"][1] => $data["C"][$i]
					);
					$this->db->where('tahun', $data["D"][1]);
					$this->db->update('sdhi_rupiah', $query, "instrumen = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'instrumen' => $data["A"][$i],
						'maturity' => $data["B"][$i],
						$data["C"][1] => $data["C"][$i],
						'tahun' => $data["D"][1],
					);
					$this->db->insert('sdhi_rupiah', $query, "instrumen = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/instrumen

			$data2 = array();

			$numrow = 1;
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'instrumen' => $row['A'], // Insert data nis dari kolom A di
						'maturity' => $row["B"],
						$sheet['1']['C'] => $row['C'],
						'tahun' => $data["D"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->keuanganhaji_model->insert_sdhi_rupiah($data2);
		}

		redirect("keuanganhaji/sdhi_rupiah"); // Redirect ke halaman awal (ke controller siswa fungsi index)

	}

	public function export_sdhi_rupiah($tahun)
	{
		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name
		$fileName = 'sdhi_rupiah_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_sdhi_rupiah($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("SBN-SDHI Rupiah Tahun " . $tahun)
			->setSubject("SBN-SDHI Rupiah Tahun " . $tahun)
			->setDescription("SBN-SDHI Rupiah Tahun " . $tahun)
			->setKeywords("SBN-SDHI Rupiah");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Surat Berharga Negara (SBN) - SDHI Rupiah " . $tahun); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:O1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 
		$excel->getActiveSheet()->mergeCells('A2:O2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Instrumen');
		$excel->getActiveSheet()->SetCellValue('C4', 'Maturity');
		$excel->getActiveSheet()->SetCellValue('D4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('E4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('F4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('G4', 'April');
		$excel->getActiveSheet()->SetCellValue('H4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('I4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('J4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('K4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('L4', 'September');
		$excel->getActiveSheet()->SetCellValue('M4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('N4', 'November');
		$excel->getActiveSheet()->SetCellValue('O4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['instrumen']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['maturity']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['desember']);

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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("SBN-SDHI Rupiah" . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}


	//sbssn RUPIAH

	public function sbssn_rupiah($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_sbssn_rupiah(); // untuk menu pilihan tahun
		$data['sbssn_rupiah'] = $this->keuanganhaji_model->get_sbssn_rupiah($tahun);

		$data['view'] = 'keuanganhaji/sbssn_rupiah';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_sbssn_rupiah()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_sbssn_rupiah';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_sbssn_rupiah';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_sbssn_rupiah';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_sbssn_rupiah($file_excel)
	{



		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum

		$this->db->select('*');
		$this->db->from('sbssn_rupiah');
		$this->db->where('tahun', $data["E"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya	



			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				$this->db->select('instrumen');
				$this->db->from('sbssn_rupiah');
				$this->db->where('instrumen', $data["A"][$i]);
				$this->db->where('tahun', $data["E"][1]);
				$instrumen_check = $this->db->get()->result();

				if (count($instrumen_check) > 0) {

					$query = array(
						$data["D"][1] => $data["D"][$i]
					);


					$this->db->where('tahun', $data["E"][1]);
					$this->db->update('sbssn_rupiah', $query, "instrumen = '" . $data["A"][$i] . "'");
				} else {

					$query = array(
						'instrumen' => $data["A"][$i],
						'maturity' => $data["B"][$i],
						'counterpart' => $data["C"][$i],
						$data["D"][1] => $data["D"][$i],
						'tahun' => $data["E"][1],
					);

					$this->db->insert('sbssn_rupiah', $query, "instrumen = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/instrumen				

			$data2 = array();

			$numrow = 1;
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'instrumen' => $row['A'], // Insert data nis dari kolom A di
						'maturity' => $row["B"],
						'counterpart' => $row['C'],
						$sheet['1']['D'] => $row['D'],
						'tahun' => $data["E"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}


			$this->keuanganhaji_model->insert_sbssn_rupiah($data2);
		}


		redirect("keuanganhaji/sbssn_rupiah"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}


	public function export_sbssn_rupiah($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'sbssn_rupiah_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_sbssn_rupiah($tahun);


		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("SBN-SBSSN Rupiah Tahun " . $tahun)
			->setSubject("SBN-SBSSN Rupiah Tahun " . $tahun)
			->setDescription("SBN-SBSSN Rupiah Tahun " . $tahun)
			->setKeywords("SBN-SBSSN Rupiah");



		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Surat Berharga Negara (SBN) - SBSSN Rupiah " . $tahun); // Set kolom A1 
		$excel->getActiveSheet()->mergeCells('A1:P1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 
		$excel->getActiveSheet()->mergeCells('A2:P2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A2


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Instrumen');
		$excel->getActiveSheet()->SetCellValue('C4', 'Maturity');
		$excel->getActiveSheet()->SetCellValue('D4', 'Counterpart');
		$excel->getActiveSheet()->SetCellValue('E4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('F4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('G4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('H4', 'April');
		$excel->getActiveSheet()->SetCellValue('I4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('J4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('K4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('L4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('M4', 'September');
		$excel->getActiveSheet()->SetCellValue('N4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('O4', 'November');
		$excel->getActiveSheet()->SetCellValue('P4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {

			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['instrumen']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['maturity']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['counterpart']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['desember']);

			//style column No
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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("SBN-SBSSN Rupiah" . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}


	//sbssn USD

	public function sbssn_usd($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_sbssn_usd(); // untuk menu pilihan tahun
		$data['sbssn_usd'] = $this->keuanganhaji_model->get_sbssn_usd($tahun);

		$data['view'] = 'keuanganhaji/sbssn_usd';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_sbssn_usd()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses




				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_sbssn_usd';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_sbssn_usd';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_sbssn_usd';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_sbssn_usd($file_excel)
	{



		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum

		$this->db->select('*');
		$this->db->from('sbssn_usd');
		$this->db->where('tahun', $data["E"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('instrumen');
				$this->db->from('sbssn_usd');
				$this->db->where('instrumen', $data["A"][$i]);
				$this->db->where('tahun', $data["E"][1]);
				$instrumen_check = $this->db->get()->result();

				if (count($instrumen_check) > 0) {

					$query = array(
						$data["D"][1] => $data["D"][$i]
					);
					$this->db->where('tahun', $data["E"][1]);
					$this->db->update('sbssn_usd', $query, "instrumen = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'instrumen' => $data["A"][$i],
						'maturity' => $data["B"][$i],
						'counterpart' => $data["C"][$i],
						$data["D"][1] => $data["D"][$i],
						'tahun' => $data["E"][1],
					);
					$this->db->insert('sbssn_usd', $query, "instrumen = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/instrumen

			$data2 = array();

			$numrow = 1;
			$bulan = $sheet['1']['B'];
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'instrumen' => $row['A'], // Insert data nis dari kolom A di
						'maturity' => $row["B"],
						'counterpart' => $row['C'],
						$sheet['1']['D'] => $row['D'],
						'tahun' => $data["E"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			/* echo "<pre>";
			    print_r($data2);
			    echo "</pre>"; */
			$this->keuanganhaji_model->insert_sbssn_usd($data2);
		}

		redirect("keuanganhaji/sbssn_usd"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_sbssn_usd($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'sbssn_usd_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_sbssn_usd($tahun);


		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("SBN-SBSSN USD Tahun " . $tahun)
			->setSubject("SBN-SBSSN USD Tahun " . $tahun)
			->setDescription("SBN-SBSSN USD Tahun " . $tahun)
			->setKeywords("SBN-SBSSN USD");



		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Surat Berharga Negara (SBN) - SBSSN USD " . $tahun); // Set kolom A1 
		$excel->getActiveSheet()->mergeCells('A1:P1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 
		$excel->getActiveSheet()->mergeCells('A2:P2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A2


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Instrumen');
		$excel->getActiveSheet()->SetCellValue('C4', 'Maturity');
		$excel->getActiveSheet()->SetCellValue('D4', 'Counterpart');
		$excel->getActiveSheet()->SetCellValue('E4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('F4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('G4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('H4', 'April');
		$excel->getActiveSheet()->SetCellValue('I4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('J4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('K4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('L4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('M4', 'September');
		$excel->getActiveSheet()->SetCellValue('N4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('O4', 'November');
		$excel->getActiveSheet()->SetCellValue('P4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {

			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['instrumen']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['maturity']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['counterpart']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['desember']);

			//style column No
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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("SBN-SBSSN USD" . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	//sukuk korporasi

	public function sukuk_korporasi($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_sukuk_korporasi(); // untuk menu pilihan tahun
		$data['sukuk_korporasi'] = $this->keuanganhaji_model->get_sukuk_korporasi($tahun);

		$data['view'] = 'keuanganhaji/sukuk_korporasi';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_sukuk_korporasi()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses




				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_sukuk_korporasi';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_sukuk_korporasi';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_sukuk_korporasi';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_sukuk_korporasi($file_excel)
	{



		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum

		$this->db->select('*');
		$this->db->from('sukuk_korporasi');
		$this->db->where('tahun', $data["E"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('instrumen');
				$this->db->from('sukuk_korporasi');
				$this->db->where('instrumen', $data["A"][$i]);
				$this->db->where('tahun', $data["E"][1]);
				$instrumen_check = $this->db->get()->result();

				if (count($instrumen_check) > 0) {

					$query = array(
						$data["D"][1] => $data["D"][$i]
					);

					$this->db->update('sukuk_korporasi', $query, "instrumen = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'instrumen' => $data["A"][$i],
						'maturity' => $data["B"][$i],
						'counterpart' => $data["C"][$i],
						$data["D"][1] => $data["D"][$i],
						'tahun' => $data["E"][1],
					);
					$this->db->insert('sukuk_korporasi', $query, "instrumen = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/instrumen

			$data2 = array();

			$numrow = 1;
			$bulan = $sheet['1']['B'];
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'instrumen' => $row['A'], // Insert data nis dari kolom A di
						'maturity' => $row["B"],
						'counterpart' => $row['C'],
						$sheet['1']['D'] => $row['D'],
						'tahun' => $data["E"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->keuanganhaji_model->insert_sukuk_korporasi($data2);
		}

		redirect("keuanganhaji/sukuk_korporasi"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_sukuk_korporasi($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'sukuk_korporasi_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_sukuk_korporasi($tahun);


		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Sukuk Korporasi Tahun " . $tahun)
			->setSubject("Sukuk Korporasi Tahun " . $tahun)
			->setDescription("Sukuk Korporasi Tahun " . $tahun)
			->setKeywords("Sukuk Korporasi");



		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Sukuk Korporasi " . $tahun); // Set kolom A1 
		$excel->getActiveSheet()->mergeCells('A1:P1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 
		$excel->getActiveSheet()->mergeCells('A2:P2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A2


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Instrumen');
		$excel->getActiveSheet()->SetCellValue('C4', 'Maturity');
		$excel->getActiveSheet()->SetCellValue('D4', 'Counterpart');
		$excel->getActiveSheet()->SetCellValue('E4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('F4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('G4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('H4', 'April');
		$excel->getActiveSheet()->SetCellValue('I4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('J4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('K4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('L4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('M4', 'September');
		$excel->getActiveSheet()->SetCellValue('N4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('O4', 'November');
		$excel->getActiveSheet()->SetCellValue('P4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {

			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['instrumen']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['maturity']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['counterpart']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['desember']);

			//style column No
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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Sukuk Korporasi" . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	// reksadana_terproteksi_syariah
	public function reksadana_terproteksi_syariah($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_reksadana_terproteksi_syariah(); // untuk menu pilihan tahun
		$data['reksadana_terproteksi_syariah'] = $this->keuanganhaji_model->get_reksadana_terproteksi_syariah($tahun);

		$data['view'] = 'keuanganhaji/reksadana_terproteksi_syariah';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_reksadana_terproteksi_syariah()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses			    	


				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_reksadana_terproteksi_syariah';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_reksadana_terproteksi_syariah';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_reksadana_terproteksi_syariah';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_reksadana_terproteksi_syariah($file_excel)
	{

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum

		$this->db->select('*');
		$this->db->from('reksadana_terproteksi_syariah');
		$this->db->where('tahun', $data["C"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('instrumen');
				$this->db->from('reksadana_terproteksi_syariah');
				$this->db->where('instrumen', $data["A"][$i]);
				$this->db->where('tahun', $data["C"][1]);
				$instrumen_check = $this->db->get()->result();

				if (count($instrumen_check) > 0) {

					$query = array(
						$data["B"][1] => $data["B"][$i]
					);
					$this->db->where('tahun', $data["C"][1]);
					$this->db->update('reksadana_terproteksi_syariah', $query, "instrumen = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'instrumen' => $data["A"][$i],
						$data["B"][1] => $data["B"][$i],
						'tahun' => $data["C"][1],
					);
					$this->db->insert('reksadana_terproteksi_syariah', $query, "instrumen = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/instrumen

			$data2 = array();

			$numrow = 1;
			$bulan = $sheet['1']['B'];
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'instrumen' => $row['A'], // Insert data nis dari kolom A di
						$sheet['1']['B'] => $row['B'],
						'tahun' => $data["C"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->keuanganhaji_model->insert_reksadana_terproteksi_syariah($data2);
		}

		redirect("keuanganhaji/reksadana_terproteksi_syariah"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_reksadana_terproteksi_syariah($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'reksadana_terproteksi_syariah_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_reksadana_terproteksi_syariah($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Reksadana Terproteksi Syariah Tahun " . $tahun)
			->setSubject("Reksadana Terproteksi Syariah Tahun " . $tahun)
			->setDescription("Reksadana Terproteksi Syariah Tahun " . $tahun)
			->setKeywords("Reksadana Terproteksi Syariah");



		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Reksadana Terproteksi Syariah Tahun " . $tahun); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A2:N2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Instrumen RTDS');
		$excel->getActiveSheet()->SetCellValue('C4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('D4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('E4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('F4', 'April');
		$excel->getActiveSheet()->SetCellValue('G4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('H4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('I4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('J4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('K4', 'September');
		$excel->getActiveSheet()->SetCellValue('L4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('M4', 'November');
		$excel->getActiveSheet()->SetCellValue('N4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['instrumen']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['desember']);

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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("RTS" . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}
	// reksadana pasar uang syariah

	public function reksadana_pasar_uang_syariah($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_reksadana_pasar_uang_syariah(); // untuk menu pilihan tahun
		$data['reksadana_pasar_uang_syariah'] = $this->keuanganhaji_model->get_reksadana_pasar_uang_syariah($tahun);

		$data['view'] = 'keuanganhaji/reksadana_pasar_uang_syariah';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_reksadana_pasar_uang_syariah()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses




				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_reksadana_pasar_uang_syariah';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_reksadana_pasar_uang_syariah';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_reksadana_pasar_uang_syariah';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_reksadana_pasar_uang_syariah($file_excel)
	{

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum

		$this->db->select('*');
		$this->db->from('reksadana_pasar_uang_syariah');
		$this->db->where('tahun', $data["C"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('instrumen');
				$this->db->from('reksadana_pasar_uang_syariah');
				$this->db->where('instrumen', $data["A"][$i]);
				$this->db->where('tahun', $data["C"][1]);
				$instrumen_check = $this->db->get()->result();

				if (count($instrumen_check) > 0) {

					$query = array(
						$data["B"][1] => $data["B"][$i]
					);
					$this->db->where('tahun', $data["C"][1]);
					$this->db->update('reksadana_pasar_uang_syariah', $query, "instrumen = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'instrumen' => $data["A"][$i],
						$data["B"][1] => $data["B"][$i],
						'tahun' => $data["C"][1],
					);
					$this->db->insert('reksadana_pasar_uang_syariah', $query, "instrumen = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/instrumen

			$data2 = array();

			$numrow = 1;
			$bulan = $sheet['1']['B'];
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'instrumen' => $row['A'], // Insert data nis dari kolom A di
						$sheet['1']['B'] => $row['B'],
						'tahun' => $data["C"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->keuanganhaji_model->insert_reksadana_pasar_uang_syariah($data2);
		}

		redirect("keuanganhaji/reksadana_pasar_uang_syariah"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}


	public function export_reksadana_pasar_uang_syariah($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'reksadana_pasar_uang_syariah_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_reksadana_pasar_uang_syariah($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Reksadana Pasar Uang Syariah Tahun " . $tahun)
			->setSubject("Reksadana Pasar Uang Syariah Tahun " . $tahun)
			->setDescription("Reksadana Pasar Uang Syariah Tahun " . $tahun)
			->setKeywords("Reksadana Pasar Uang Syariah");



		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Reksadana Pasar Uang Syariah Tahun " . $tahun); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A2:N2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Instrumen RTDS');
		$excel->getActiveSheet()->SetCellValue('C4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('D4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('E4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('F4', 'April');
		$excel->getActiveSheet()->SetCellValue('G4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('H4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('I4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('J4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('K4', 'September');
		$excel->getActiveSheet()->SetCellValue('L4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('M4', 'November');
		$excel->getActiveSheet()->SetCellValue('N4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['instrumen']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['desember']);

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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("RTS" . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}


	// rpenyertaan saham

	public function penyertaan_saham($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_penyertaan_saham(); // untuk menu pilihan tahun
		$data['penyertaan_saham'] = $this->keuanganhaji_model->get_penyertaan_saham($tahun);

		$data['view'] = 'keuanganhaji/penyertaan_saham';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_penyertaan_saham()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses




				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_penyertaan_saham';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_penyertaan_saham';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_penyertaan_saham';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_penyertaan_saham($file_excel)
	{



		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum

		$this->db->select('*');
		$this->db->from('penyertaan_saham');
		$this->db->where('tahun', $data["C"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('bps_bpih');
				$this->db->from('penyertaan_saham');
				$this->db->where('bps_bpih', $data["A"][$i]);
				$this->db->where('tahun', $data["C"][1]);
				$instrumen_check = $this->db->get()->result();

				if (count($instrumen_check) > 0) {

					$query = array(
						$data["B"][1] => $data["B"][$i]
					);
					$this->db->where('tahun', $data["C"][1]);
					$this->db->update('penyertaan_saham', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'bps_bpih' => $data["A"][$i],
						$data["B"][1] => $data["B"][$i],
						'tahun' => $data["C"][1],
					);
					$this->db->insert('penyertaan_saham', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/bps_bpih

			$data2 = array();

			$numrow = 1;
			$bulan = $sheet['1']['B'];
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'bps_bpih' => $row['A'], // Insert data nis dari kolom A di
						$sheet['1']['B'] => $row['B'],
						'tahun' => $data["C"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->keuanganhaji_model->insert_penyertaan_saham($data2);
		}

		redirect("keuanganhaji/penyertaan_saham"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_penyertaan_saham($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'penyertaan_saham_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_penyertaan_saham($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Penyertaan Saham Tahun " . $tahun)
			->setSubject("Penyertaan Saham Tahun " . $tahun)
			->setDescription("Penyertaan Saham Tahun " . $tahun)
			->setKeywords("Penyertaan Saham");



		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Penyertaan Saham Tahun " . $tahun); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A2:N2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Nama Perusahaan');
		$excel->getActiveSheet()->SetCellValue('C4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('D4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('E4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('F4', 'April');
		$excel->getActiveSheet()->SetCellValue('G4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('H4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('I4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('J4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('K4', 'September');
		$excel->getActiveSheet()->SetCellValue('L4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('M4', 'November');
		$excel->getActiveSheet()->SetCellValue('N4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bps_bpih']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['desember']);


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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Penyertaan Saham " . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	// investasi langsung

	public function investasi_langsung($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_investasi_langsung(); // untuk menu pilihan tahun
		$data['investasi_langsung'] = $this->keuanganhaji_model->get_investasi_langsung($tahun);

		$data['view'] = 'keuanganhaji/investasi_langsung';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_investasi_langsung()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses  	


				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_investasi_langsung';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_investasi_langsung';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_investasi_langsung';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_investasi_langsung($file_excel)
	{

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);
		$data = array();
		$numrow = 1;
		foreach ($sheet as $row) {
			if ($numrow > 1) {
				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'bulan' => $row['A'],
					'tahun' => $row['B'],
					'usaha_sendiri' => $row['C'],
					'penyertaan_modal' => $row['D'],
					'pemilikan_saham' => $row['E'],
					'kerjasama_investasi' => $row['F'],
					'investasi_tanah_bangunan' => $row['G'],
					'investasi_langsung_lain' => $row['H'],
					'total' => $row['I'],
				));
			}

			$numrow++; // Tambah 1 setiap kali looping

		}

		$this->keuanganhaji_model->insert_investasi_langsung($data);

		redirect("keuanganhaji/investasi_langsung"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_investasi_langsung($id = 0)
	{
		$this->db->delete('investasi_langsung', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('keuanganhaji/investasi_langsung'));
	}

	public function export_investasi_langsung($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'investasi_langsung_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_investasi_langsung($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Investasi Langsung Tahun " . $tahun)
			->setSubject("Investasi Langsung Tahun " . $tahun)
			->setDescription("Investasi Langsung Tahun " . $tahun)
			->setKeywords("Investasi Langsung");



		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Investasi Langsung Tahun " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A2:G2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Bulan');
		$excel->getActiveSheet()->SetCellValue('C4', 'Mudharabah Muqayaddah');
		$excel->getActiveSheet()->SetCellValue('D4', 'Produk Keuangan Non-Bank');
		$excel->getActiveSheet()->SetCellValue('E4', 'Sewa');
		$excel->getActiveSheet()->SetCellValue('F4', 'Investasi lain-lain');
		$excel->getActiveSheet()->SetCellValue('G4', 'Total');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bulan']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['mudharabah_muqayaddah']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['produk_keuangan_nonbank']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['sewa']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['investasi_lain']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['total']);

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

		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Investasi Langsung Th " . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	// investasi lainnya

	public function investasi_lainnya($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_investasi_lainnya(); // untuk menu pilihan tahun
		$data['investasi_lainnya'] = $this->keuanganhaji_model->get_investasi_lainnya($tahun);

		$data['view'] = 'keuanganhaji/investasi_lainnya';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_investasi_lainnya()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses			        

				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_investasi_lainnya';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_investasi_lainnya';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_investasi_lainnya';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_investasi_lainnya($file_excel)
	{

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);
		$data = array();
		$numrow = 1;
		foreach ($sheet as $row) {
			if ($numrow > 1) {
				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'bulan' => $row['A'],
					'tahun' => $row['B'],
					'mudharabah_muqayaddah' => $row['C'],
					'produk_keuangan_nonbank' => $row['D'],
					'sewa' => $row['E'],
					'investasi_lain' => $row['F'],
					'total' => $row['G'],
				));
			}

			$numrow++; // Tambah 1 setiap kali looping

		}

		$this->keuanganhaji_model->insert_investasi_lainnya($data);

		redirect("keuanganhaji/investasi_lainnya"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_investasi_lainnya($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'investasi_lainnya_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_investasi_lainnya($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Investasi Lainnya Tahun " . $tahun)
			->setSubject("Investasi Lainnya Tahun " . $tahun)
			->setDescription("Investasi Lainnya Tahun " . $tahun)
			->setKeywords("Investasi Lainnya");



		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Investasi Lainnya Tahun " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A2:G2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Bulan');
		$excel->getActiveSheet()->SetCellValue('C4', 'Mudharabah Muqayaddah');
		$excel->getActiveSheet()->SetCellValue('D4', 'Produk Keuangan Non-Bank');
		$excel->getActiveSheet()->SetCellValue('E4', 'Sewa');
		$excel->getActiveSheet()->SetCellValue('F4', 'Investasi lain-lain');
		$excel->getActiveSheet()->SetCellValue('G4', 'Total');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bulan']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['mudharabah_muqayaddah']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['produk_keuangan_nonbank']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['sewa']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['investasi_lain']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['total']);

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

		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Investasi Lainnya Th " . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	public function hapus_investasi_lainnya($id = 0)
	{
		$this->db->delete('investasi_lainnya', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('keuanganhaji/investasi_lainnya'));
	}

	// investasi lainnya

	public function emas($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_emas(); // untuk menu pilihan tahun
		$data['emas'] = $this->keuanganhaji_model->get_emas($tahun);

		$data['view'] = 'keuanganhaji/emas';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_emas()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses




				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_emas';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_emas';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_emas';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_emas($file_excel)
	{

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum

		$this->db->select('*');
		$this->db->from('emas');
		$this->db->where('tahun', $data["C"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('bps_bpih');
				$this->db->from('emas');
				$this->db->where('bps_bpih', $data["A"][$i]);
				$this->db->where('tahun', $data["C"][1]);
				$instrumen_check = $this->db->get()->result();

				if (count($instrumen_check) > 0) {

					$query = array(
						$data["B"][1] => $data["B"][$i]
					);
					$this->db->where('tahun', $data["C"][1]);
					$this->db->update('emas', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'bps_bpih' => $data["A"][$i],
						$data["B"][1] => $data["B"][$i],
						'tahun' => $data["C"][1],
					);
					$this->db->insert('emas', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/bps_bpih

			$data2 = array();

			$numrow = 1;
			$bulan = $sheet['1']['B'];
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'bps_bpih' => $row['A'], // Insert data nis dari kolom A di
						$sheet['1']['B'] => $row['B'],
						'tahun' => $data["C"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->keuanganhaji_model->insert_emas($data2);
		}

		redirect("keuanganhaji/emas"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_emas($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'emas_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_emas($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Emas Tahun " . $tahun)
			->setSubject("Emas Tahun " . $tahun)
			->setDescription("Emas Tahun " . $tahun)
			->setKeywords("Investasi Lainnya");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Emas Tahun " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:N2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Nama Perusahaan');
		$excel->getActiveSheet()->SetCellValue('C4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('D4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('E4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('F4', 'April');
		$excel->getActiveSheet()->SetCellValue('G4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('H4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('I4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('J4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('K4', 'September');
		$excel->getActiveSheet()->SetCellValue('L4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('M4', 'November');
		$excel->getActiveSheet()->SetCellValue('N4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bps_bpih']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['desember']);

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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Emas Thn " . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	// investasi lainnya

	public function akumulasi_kontribusi_bpsbpih($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_akumulasi_kontribusi_bpsbpih(); // untuk menu pilihan tahun
		$data['akumulasi_kontribusi_bpsbpih'] = $this->keuanganhaji_model->get_akumulasi_kontribusi_bpsbpih($tahun);

		$data['view'] = 'keuanganhaji/akumulasi_kontribusi_bpsbpih';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_akumulasi_kontribusi_bpsbpih()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses




				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_akumulasi_kontribusi_bpsbpih';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_akumulasi_kontribusi_bpsbpih';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_akumulasi_kontribusi_bpsbpih';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_akumulasi_kontribusi_bpsbpih($file_excel)
	{



		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum

		$this->db->select('*');
		$this->db->from('akumulasi_kontribusi_bpsbpih');
		$this->db->where('tahun', $data["C"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('bps_bpih');
				$this->db->from('akumulasi_kontribusi_bpsbpih');
				$this->db->where('bps_bpih', $data["A"][$i]);
				$this->db->where('tahun', $data["C"][1]);
				$instrumen_check = $this->db->get()->result();

				if (count($instrumen_check) > 0) {

					$query = array(
						$data["B"][1] => $data["B"][$i]
					);
					$this->db->where('tahun', $data["C"][1]);
					$this->db->update('akumulasi_kontribusi_bpsbpih', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'bps_bpih' => $data["A"][$i],
						$data["B"][1] => $data["B"][$i],
						'tahun' => $data["C"][1],
					);
					$this->db->insert('akumulasi_kontribusi_bpsbpih', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/bps_bpih

			$data2 = array();

			$numrow = 1;
			$bulan = $sheet['1']['B'];
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'bps_bpih' => $row['A'], // Insert data nis dari kolom A di
						$sheet['1']['B'] => $row['B'],
						'tahun' => $data["C"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->keuanganhaji_model->insert_akumulasi_kontribusi_bpsbpih($data2);
		}

		redirect("keuanganhaji/akumulasi_kontribusi_bpsbpih"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_akumulasi_kontribusi_bpsbpih($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'akumulasi_kontribusi_bpsbpih_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_akumulasi_kontribusi_bpsbpih($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Akumulasi Kontribusi BPS BPIH Tahun " . $tahun)
			->setSubject("Akumulasi Kontribusi BPS BPIH Tahun " . $tahun)
			->setDescription("Akumulasi Kontribusi BPS BPIH Tahun " . $tahun)
			->setKeywords("Investasi Lainnya");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Akumulasi Kontribusi BPS BPIH Tahun " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:N2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'BPS BPIH');
		$excel->getActiveSheet()->SetCellValue('C4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('D4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('E4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('F4', 'April');
		$excel->getActiveSheet()->SetCellValue('G4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('H4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('I4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('J4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('K4', 'September');
		$excel->getActiveSheet()->SetCellValue('L4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('M4', 'November');
		$excel->getActiveSheet()->SetCellValue('N4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bps_bpih']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['desember']);

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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Kontribusi BPS BPIH Thn " . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}


	// posisi penempatan produk

	public function posisi_penempatan_produk($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_posisi_penempatan_produk(); // untuk menu pilihan tahun
		$data['posisi_penempatan_produk'] = $this->keuanganhaji_model->get_posisi_penempatan_produk($tahun);

		$data['view'] = 'keuanganhaji/posisi_penempatan_produk';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_posisi_penempatan_produk()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses        

				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_posisi_penempatan_produk';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_posisi_penempatan_produk';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_posisi_penempatan_produk';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_posisi_penempatan_produk($file_excel)
	{



		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);
		$data = array();

		$numrow = 1;

		foreach ($sheet as $row) {
			if ($numrow > 1) {
				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'bulan' => $row['A'], // Insert data nis dari kolom A di
					'giro' => $row['B'],
					'tabungan' => $row['C'],
					'deposito' => $row['D'],
					'jumlah' => $row['E'],
					'tahun' => $row['F'],
				));
			}

			$numrow++; // Tambah 1 setiap kali looping
		}

		$this->keuanganhaji_model->insert_posisi_penempatan_produk($data);

		redirect("keuanganhaji/posisi_penempatan_produk"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_posisi_penempatan_produk($id = 0)
	{
		$this->db->delete('posisi_penempatan_produk', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('keuanganhaji/posisi_penempatan_produk'));
	}

	public function export_posisi_penempatan_produk($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'posisi_penempatan_produk_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_posisi_penempatan_produk($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Posisi Penempatan Produk Tahun " . $tahun)
			->setSubject("Posisi Penempatan Produk Tahun " . $tahun)
			->setDescription("Posisi Penempatan Produk Tahun " . $tahun)
			->setKeywords("Investasi Lainnya");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Posisi Penempatan Produk Tahun " . $tahun); // 
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


		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'Bulan');
		$excel->getActiveSheet()->SetCellValue('C4', 'Giro');
		$excel->getActiveSheet()->SetCellValue('D4', 'Tabungan');
		$excel->getActiveSheet()->SetCellValue('E4', 'Deposito');
		$excel->getActiveSheet()->SetCellValue('F4', 'Jumlah');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bulan']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['giro']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['tabungan']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['deposito']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['jumlah']);

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
		/* 	for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			    $excel->getActiveSheet()->getStyle($i.$last_row)->applyFromArray($style_td_bold);
			} */
		//auto column width
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Posisi Penempatan Thn " . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	public function porsi_investasi($tahun=0)
	{
		$tahun = ($tahun !='') ? $tahun : date('Y');

			$data['thn'] = $tahun;
			$data['tahun'] = $this->alokasi_model->get_tahun_alokasi_investasi();
			$data['alokasi_investasi'] = $this->alokasi_model->get_alokasi_investasi($tahun);
			$data['view'] = 'Alokasi/index';
			$this->load->view('admin/layout', $data);
	}

	// SEBARAN DANA HAJI
	public function penempatan_dana_haji($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->keuanganhaji_model->get_tahun_penempatan_dana_haji(); // untuk menu pilihan tahun
		$data['penempatan_dana_haji'] = $this->keuanganhaji_model->get_penempatan_dana_haji($tahun);

		$data['view'] = 'keuanganhaji/penempatan_dana_haji';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_penempatan_dana_haji()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel';

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
			$this->upload->do_upload('file');
			$upload = $this->upload->data();


			if ($upload) { // Jika proses upload sukses
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_penempatan_dana_haji';
				$this->load->view('admin/layout', $data);
			} else {
				echo "gagal";
				$data['view'] = 'tambah_penempatan_dana_haji';
				$this->load->view('admin/layout', $data);
			}
		} else {
			$data['view'] = 'tambah_penempatan_dana_haji';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_penempatan_dana_haji($file_excel)
	{
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum
		$this->db->select('*');
		$this->db->from('penempatan_dana_haji2');
		$this->db->where('tahun', $data["C"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('bps_bpih');
				$this->db->from('penempatan_dana_haji2');
				$this->db->where('bps_bpih', $data["A"][$i]);
				$bps_bpih_check = $this->db->get()->result();

				if (count($bps_bpih_check) > 0) {

					$query = array(
						$data["B"][1] => $data["B"][$i]
					);

					$this->db->update('penempatan_dana_haji', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'bps_bpih' => $data["A"][$i],
						$data["B"][1] => $data["B"][$i],
						'tahun' => $data["C"][1],
					);
					$this->db->insert('penempatan_dana_haji', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				}
			}
		} else { // jika tidak ditemukan maka masukkan data bank/bps_bpih

			$data2 = array();

			$numrow = 1;
			foreach ($sheet as $row) {
				// Cek $numrow apakah lebih dari 1
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport

				if ($numrow > 1) {
					// Kita push (add) array data ke variabel data
					array_push($data2, array(
						'bps_bpih' => $row['A'], // Insert data nis dari kolom A di
						$sheet['1']['B'] => $row['B'],
						'tahun' => $data["C"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->keuanganhaji_model->insert_penempatan_dana_haji($data2);
		}

		redirect("keuanganhaji/penempatan_dana_haji"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_penempatan_dana_haji($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'penempatan_dana_haji_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->keuanganhaji_model->get_penempatan_dana_haji($tahun);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Posisi Sebaran Dana Haji Tahun " . $tahun)
			->setSubject("Posisi Sebaran Dana Haji Tahun " . $tahun)
			->setDescription("Posisi Sebaran Dana Haji Tahun " . $tahun)
			->setKeywords("Posisi Sebaran Dana Haji");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Posisi Sebaran Dana Haji Tahun " . $tahun); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A2:N2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0);
		// set Header
		$excel->getActiveSheet()->SetCellValue('A4', 'No.');
		$excel->getActiveSheet()->SetCellValue('B4', 'BPS BPIH');
		$excel->getActiveSheet()->SetCellValue('C4', 'Januari');
		$excel->getActiveSheet()->SetCellValue('D4', 'Februari');
		$excel->getActiveSheet()->SetCellValue('E4', 'Maret');
		$excel->getActiveSheet()->SetCellValue('F4', 'April');
		$excel->getActiveSheet()->SetCellValue('G4', 'Mei');
		$excel->getActiveSheet()->SetCellValue('H4', 'Juni');
		$excel->getActiveSheet()->SetCellValue('I4', 'Juli');
		$excel->getActiveSheet()->SetCellValue('J4', 'Agustus');
		$excel->getActiveSheet()->SetCellValue('K4', 'September');
		$excel->getActiveSheet()->SetCellValue('L4', 'Oktober');
		$excel->getActiveSheet()->SetCellValue('M4', 'November');
		$excel->getActiveSheet()->SetCellValue('N4', 'Desember');

		//no 
		$no = 1;
		// set Row
		$rowCount = 5;
		$last_row = count($sebaran) + 4;
		foreach ($sebaran as $element) {
			$excel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bps_bpih']);
			$excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['januari']);
			$excel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['februari']);
			$excel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['maret']);
			$excel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['april']);
			$excel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['mei']);
			$excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['juni']);
			$excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['juli']);
			$excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['agustus']);
			$excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['september']);
			$excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['oktober']);
			$excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['november']);
			$excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['desember']);

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

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Posisi Sebaran Dana Haji" . $tahun);
		$excel->setActiveSheetIndex(0);

		$objWriter = new PHPExcel_Writer_Excel2007($excel);
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

} //class
