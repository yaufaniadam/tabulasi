<?php defined('BASEPATH') or exit('No direct script access allowed');
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory; 
	use PhpOffice\PhpSpreadsheet\Style\Alignment; 
class Nilaimanfaat extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('nilaimanfaat_model', 'nilaimanfaat_model');
		$this->load->library('excel');
	}

	public function index()
	{
		$data['view'] = 'index';
		$this->load->view('admin/layout', $data);
	}

	public function per_instrumen($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->nilaimanfaat_model->get_tahun_per_instrumen();
		$data['per_instrumen'] = $this->nilaimanfaat_model->get_per_instrumen($tahun);
		$data['view'] = 'per_instrumen';
		$this->load->view('admin/layout', $data);
	}

	public function detail_per_instrumen($id = 0)
	{

		$data['per_instrumen'] = $this->nilaimanfaat_model->get_detail_per_instrumen($id);
		$data['view'] = 'detail_per_instrumen';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_per_instrumen()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel/nilaimanfaat';

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
				$loadexcel = $excelreader->load('./uploads/excel/nilaimanfaat/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];


				$data['view'] = 'tambah_per_instrumen';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_per_instrumen';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_per_instrumen';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_per_instrumen($file_excel)
	{

		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/nilaimanfaat/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		$dataquery = array(
			'dau' => $data['B'][2],
			'surat_berharga' => $data['B'][3],
			'sdhi' => $data['B'][4],
			'sbsn' => $data['B'][5],
			'sbsn_usd' => $data['B'][6],
			'sukuk_korporasi' => $data['B'][7],
			'rd_terproteksi_syariah' => $data['B'][8],
			'rd_pasar_uang_syariah' => $data['B'][9],
			'rd_penyertaan_terbatas' => $data['B'][10],
			'saham_bmi' => $data['B'][11],
			'lain_lain' => $data['B'][12],
			'investasi_langsung' => $data['B'][13],
			'investasi_lainnya' => $data['B'][14],
			'emas' => $data['B'][15],
			'total' => $data['B'][16],
			'total_exclude_dau' => $data['B'][17],
			'bulan' => konversi_bulan_ke_angka($data['B'][1]),
			'tahun' => $data['C'][1],
			'upload_by' => $this->session->userdata('user_id'),
		);

		// Panggil fungsi insert_per_instrumen
		$this->nilaimanfaat_model->insert_per_instrumen($dataquery);

		redirect("nilaimanfaat/per_instrumen"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_per_instrumen($id = 0, $uri = NULL)
	{
		$this->db->delete('per_instrumen', array('id_per_instrumen' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('nilaimanfaat/per_instrumen/'.$uri));
	}

	public function export_per_instrumen($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'nilai_manfaat_produk_investasi_per_instrumen_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->nilaimanfaat_model->get_per_instrumen_export($tahun);
		$totalbulan = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new Spreadsheet;

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Nilai Manfaat Produk Investasi Per Instrumen BPKH Tahun " . $tahun)
			->setSubject("Nilai Manfaat Produk Investasi Per Instrumen BPKH Tahun " . $tahun)
			->setDescription("Nilai Manfaat Produk Investasi Per Instrumen BPKH Tahun " . $tahun)
			->setKeywords("Nilai Manfaat Produk Investasi Per Instrumen BPKH");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Nilai Manfaat Produk Investasi Per Instrumen BPKH Tahun " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:' . $totalbulan . '1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:' . $totalbulan . '2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->getActiveSheet()->SetCellValue('A4', 'Nilai Manfaat');
		$excel->getActiveSheet()->SetCellValue('A5', 'DAU (SDHI & SBSN)');
		$excel->getActiveSheet()->SetCellValue('A6', 'Surat Berharga');
		$excel->getActiveSheet()->SetCellValue('A7', 'SDHI');
		$excel->getActiveSheet()->SetCellValue('A8', 'SBSN');
		$excel->getActiveSheet()->SetCellValue('A9', 'SBSN USD');
		$excel->getActiveSheet()->SetCellValue('A10', 'Sukuk Korporasi');
		$excel->getActiveSheet()->SetCellValue('A11', 'RD Terproteksi Syariah');
		$excel->getActiveSheet()->SetCellValue('A12', 'RD Pasar Uang Syariah');
		$excel->getActiveSheet()->SetCellValue('A13', 'RD Penyertaan Terbatas');
		$excel->getActiveSheet()->SetCellValue('A14', 'Saham BMI');
		$excel->getActiveSheet()->SetCellValue('A15', 'Lain-lain');
		$excel->getActiveSheet()->SetCellValue('A16', 'Investasi Langsung');
		$excel->getActiveSheet()->SetCellValue('A17', 'Investasi Lainnya');
		$excel->getActiveSheet()->SetCellValue('A18', 'Emas');
		$excel->getActiveSheet()->SetCellValue('A19', 'Total');
		$excel->getActiveSheet()->SetCellValue('A20', 'Total Exclude DAU');

		$i = 2;
		foreach ($sebaran as $element) {
			//echo  konversiBulanAngkaKeNama($element['bulan']);echo konversiAngkaKeHuruf($i);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 4,  konversiBulanAngkaKeNama($element['bulan']));
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 5, $element['dau']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 6, $element['surat_berharga']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 7, $element['sdhi']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 8, $element['sbsn']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 9, $element['sbsn_usd']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 10, $element['sukuk_korporasi']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 11, $element['rd_terproteksi_syariah']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 12, $element['rd_pasar_uang_syariah']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 13, $element['rd_penyertaan_terbatas']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 14, $element['saham_bmi']);

			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 15, $element['lain_lain']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 16, $element['investasi_langsung']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 17, $element['investasi_lainnya']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 18, $element['emas']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 19, $element['total']);

			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 20, $element['total_exclude_dau']);

			$i++;
		}

		//header style
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '4')->applyFromArray($style_header);
		}
		//td style
		for ($baris = 5; $baris <= 20; $baris++) {
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				$excel->getActiveSheet()->getStyle($i . $baris)->applyFromArray($style_td);
			}
		}

		for ($i = 5; $i <= 20; $i++) {
			$excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($style_td_left);
		}

		$excel->getActiveSheet()->getStyle('A19')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A20')->getFont()->setBold(TRUE);

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

	// nilai manfaat penempatan di bps bpih
	public function penempatan_di_bpsbpih($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->nilaimanfaat_model->get_tahun_nilai_manfaat_penempatan_di_bpsbpih(); // untuk menu pilihan tahun
		$data['nilai_manfaat_penempatan_di_bpsbpih'] = $this->nilaimanfaat_model->get_nilai_manfaat_penempatan_di_bpsbpih($tahun);

		$data['view'] = 'nilai_manfaat_penempatan_di_bpsbpih';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_nilai_manfaat_penempatan_di_bpsbpih()
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

				$excelreader = new Xlsx;
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_nilai_manfaat_penempatan_di_bpsbpih';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_nilai_manfaat_penempatan_di_bpsbpih';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_nilai_manfaat_penempatan_di_bpsbpih';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_nilai_manfaat_penempatan_di_bpsbpih($file_excel)
	{
		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		//cek data per tahun sudah ada apa belum
		$this->db->select('*');
		$this->db->from('nilai_manfaat_penempatan_di_bpsbpih');
		$this->db->where('tahun', $data["C"][1]);
		$query = $this->db->get()->result();

		if (count($query) > 0) { //jika ditemukan data tahun, maka update isinya		    	

			$countdata = count($data["A"]);

			for ($i = 2; $i <= $countdata; $i++) {

				//cek apakah BPS_BPIH sudah ada pada tabel
				$this->db->select('bps_bpih');
				$this->db->from('nilai_manfaat_penempatan_di_bpsbpih');
				$this->db->where('bps_bpih', $data["A"][$i]);
				$this->db->where('tahun', $data["C"][1]);
				$bps_bpih_check = $this->db->get()->result();

				if (count($bps_bpih_check) > 0) {

					$query = array(
						$data["B"][1] => $data["B"][$i]
					);
					$this->db->where('tahun', $data["C"][1]);
					$this->db->update('nilai_manfaat_penempatan_di_bpsbpih', $query, "bps_bpih = '" . $data["A"][$i] . "'");
				} else {
					$query = array(
						'bps_bpih' => $data["A"][$i],
						$data["B"][1] => $data["B"][$i],
						'tahun' => $data["C"][1],
						'upload_by' => $this->session->userdata('user_id'),
					);
					$this->db->insert('nilai_manfaat_penempatan_di_bpsbpih', $query, "bps_bpih = '" . $data["A"][$i] . "'");
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
						'upload_by' => $this->session->userdata('user_id'),
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			$this->nilaimanfaat_model->insert_nilai_manfaat_penempatan_di_bpsbpih($data2);
		}

		redirect("nilaimanfaat/penempatan_di_bpsbpih"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_nilai_manfaat_penempatan_di_bpsbpih($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'nilai_manfaat_penempatan_di_bpsbpih_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->nilaimanfaat_model->get_nilai_manfaat_penempatan_di_bpsbpih($tahun);
		$excel = new Spreadsheet;

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Nilai Manfaat Hasil Penempatan di BPS BPIH Tahun " . $tahun)
			->setSubject("Nilai Manfaat Hasil Penempatan di BPS BPIH Tahun " . $tahun)
			->setDescription("Nilai Manfaat Hasil Penempatan di BPS BPIH Tahun " . $tahun)
			->setKeywords("Nilai Manfaat Hasil Penempatan di BPS BPIH");



		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Nilai Manfaat Hasil Penempatan di BPS BPIH Tahun " . $tahun); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A2:N2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


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

		/* Set judul file excel nya
			$excel->getActiveSheet(0)->setTitle("Nilai Manfaat Hasil Penempatan di BPS BPIH" . $tahun);
			$excel->setActiveSheetIndex(0); */

		$objWriter = IOFactory::createWriter($excel, "Xlsx");
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}

	public function hapus_nilai_manfaat_penempatan_di_bpsbpih($bulan = 0, $tahun = NULL)
	{
		$this->db->where('tahun', $tahun);
		$this->db->update('nilai_manfaat_penempatan_di_bpsbpih', array($bulan => ''));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('nilaimanfaat/penempatan_di_bpsbpih/'.$tahun));
	}
	

	// nilai manfaat produk
	public function produk($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->nilaimanfaat_model->get_tahun_nilai_manfaat_produk(); // untuk menu pilihan tahun
		$data['nilai_manfaat_produk'] = $this->nilaimanfaat_model->get_nilai_manfaat_produk($tahun);

		$data['view'] = 'nilai_manfaat_produk';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_nilai_manfaat_produk()
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

				$excelreader = new Xlsx;
				$loadexcel = $excelreader->load('./uploads/excel/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];

				$data['view'] = 'tambah_nilai_manfaat_produk';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_nilai_manfaat_produk';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_nilai_manfaat_produk';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_nilai_manfaat_produk($file_excel)
	{

		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$dataquery = array(array());

		$data2 = array();

		$numrow = 1;

		foreach ($sheet as $row) {

			if ($numrow > 1) {
				// Kita push (add) array data ke variabel data
				array_push($data2, array(
					'giro' => $row['B'],
					'tabungan' => $row['C'],
					'deposito' => $row['D'],
					'jumlah' => $row['E'],
					'bulan' => konversi_bulan_ke_angka($row['A']),
					'tahun' => $row['F'],
					'upload_by' => $this->session->userdata('user_id'),
				));
			}

			$numrow++; // Tambah 1 setiap kali looping
		}

		$this->nilaimanfaat_model->insert_nilai_manfaat_produk($data2);


		redirect("nilaimanfaat/produk"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_produk($id = 0, $uri = NULL)
	{
		$this->db->delete('nilai_manfaat_produk', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('nilaimanfaat/produk/'.$uri));
	}

	public function export_nilai_manfaat_produk($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'nilai_manfaat_produk_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->nilaimanfaat_model->get_nilai_manfaat_produk($tahun);
		$excel = new Spreadsheet;

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Perolehan Nilai Manfaat Hasil Penempatan berdasarkan Produk Tahun " . $tahun)
			->setSubject("Perolehan Nilai Manfaat Hasil Penempatan berdasarkan Produk Tahun " . $tahun)
			->setDescription("Perolehan Nilai Manfaat Hasil Penempatan berdasarkan Produk Tahun " . $tahun)
			->setKeywords("Investasi Lainnya");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Perolehan Nilai Manfaat Hasil Penempatan berdasarkan Produk Tahun " . $tahun); // 
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
			$excel->getActiveSheet()->SetCellValue('B' . $rowCount,  konversiBulanAngkaKeNama($element['bulan']));
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

		/* Set judul file excel nya
			$excel->getActiveSheet(0)->setTitle("Posisi Penempatan Thn " . $tahun);
			$excel->setActiveSheetIndex(0); */

		$objWriter = IOFactory::createWriter($excel, "Xlsx");
		$objWriter->save('./uploads/excel/' . $fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		redirect('./uploads/excel/' . $fileName);
	}
} //class
