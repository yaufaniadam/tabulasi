<?php defined('BASEPATH') or exit('No direct script access allowed');

class Bpih extends MY_Controller
{
	//private $filename = "import_data";

	public function __construct()
	{
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('bpih_model', 'bpih_model');
	}

	public function index()
	{
		$data['view'] = 'index';
		$this->load->view('admin/layout', $data);
	}



	public function pencapaian_perbidang($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->bpih_model->get_tahun_pencapaian_perbidang();
		$data['pencapaian_perbidang'] = $this->bpih_model->get_pencapaian_perbidang($tahun);
		$data['view'] = 'pencapaian_perbidang';
		$this->load->view('admin/layout', $data);
	}
	public function detail_pencapaian_perbidang($bulan=0, $tahun = 0)
	{
		$data['tahun'] = $this->bpih_model->get_tahun_pencapaian_perbidang();
		$data['pencapaian_perbidang'] = $this->bpih_model->get_detail_pencapaian_perbidang($bulan, $tahun);
		$data['view'] = 'detail_pencapaian_perbidang';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_pencapaian_perbidang()
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

				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/bpih/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];


				$data['view'] = 'tambah_pencapaian_perbidang';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_pencapaian_perbidang';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_pencapaian_perbidang';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_pencapaian_perbidang($file_excel)
	{


		$excelreader = new PHPExcel_Reader_Excel2007();
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
						'bulan' => $data["E"][1],
						'tahun' => $data["F"][1],
					));
				}

				$numrow++; // Tambah 1 setiap kali looping
			}

	

		// Panggil fungsi insert_pencapaian_perbidang
		$this->bpih_model->insert_pencapaian_perbidang($data2);

		redirect("bpih/pencapaian_perbidang"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_pencapaian_perbidang($bulan = 0, $tahun = 0, $uri = NULL)
	{
		$this->db->delete('pencapaian_perbidang2', array('bulan' => $bulan, 'tahun' => $tahun));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('bpih/pencapaian_perbidang/'. $tahun));
	}

	public function export_pencapaian_perbidang($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'laporan_pencapaian_output_perbidang_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->bpih_model->get_pencapaian_perbidang($tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Pencapaian Output Perbidang Tahun " . $tahun)
			->setSubject("Laporan Pencapaian Output Perbidang Tahun " . $tahun)
			->setDescription("Laporan Pencapaian Output Perbidang Tahun " . $tahun)
			->setKeywords("Laporan Operasional Akumulasi");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Pencapaian Output Perbidang Tahun " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:' . $maxcolumn . '1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:' . $maxcolumn . '2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->getActiveSheet()->SetCellValue('A4', 'BULAN');
		$excel->getActiveSheet()->SetCellValue('A5', 'Pengembangan dan Kemaslahatan');
		$excel->getActiveSheet()->SetCellValue('A6', 'Keuangan');
		$excel->getActiveSheet()->SetCellValue('A7', 'Investasi');
		$excel->getActiveSheet()->SetCellValue('A8', 'Operasional');
		$excel->getActiveSheet()->SetCellValue('A9', 'Perencanaan dan Manajemen Risiko');
		$excel->getActiveSheet()->SetCellValue('A10', 'SDM dan Pengadaan');
		$excel->getActiveSheet()->SetCellValue('A11', 'Hukum dan Kepatuhan');
		$excel->getActiveSheet()->SetCellValue('A12', 'Audit Internal');
		$excel->getActiveSheet()->SetCellValue('A13', 'Sekretariat Badan Pelaksana');
		$excel->getActiveSheet()->SetCellValue('A14', 'Sekretariat Badan Pelaksana');


		$i = 2;
		foreach ($sebaran as $element) {
			//echo $element['bulan'];echo konversiAngkaKeHuruf($i);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 4, $element['bulan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 5, $element['pengembangan_dan_kemaslahatan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 6, $element['keuangan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 7, $element['investasi']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 8, $element['operasional']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 9, $element['perencanaan_dan_manajemen_risiko']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 10, $element['sdm_dan_pengadaan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 11, $element['hukum_dan_kepatuhan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 12, $element['audit_internal']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 13, $element['sekban']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 14, $element['sekdewas']);


			$i++;
		}

		//header style
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '4')->applyFromArray($style_header);
		}
		//td style
		for ($baris = 5; $baris <= 14; $baris++) {
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				$excel->getActiveSheet()->getStyle($i . $baris)->applyFromArray($style_td);
			}
		}

		for ($i = 5; $i <= 14; $i++) {
			$excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($style_td_left);
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
		$data['tahun'] = $this->bpih_model->get_tahun_penyerapan_perbidang();
		$data['penyerapan_perbidang'] = $this->bpih_model->get_penyerapan_perbidang($tahun);
		$data['view'] = 'penyerapan_perbidang';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_penyerapan_perbidang()
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



				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('./uploads/excel/bpih/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];


				$data['view'] = 'tambah_penyerapan_perbidang';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'tambah_penyerapan_perbidang';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'tambah_penyerapan_perbidang';
			$this->load->view('admin/layout', $data);
		}
	}

	public function import_penyerapan_perbidang($file_excel)
	{


		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('./uploads/excel/bpih/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = transposeData($sheet);

		$dataquery = array(
			'pengembangan_dan_kemaslahatan' => $data['B'][2],
			'keuangan' => $data['B'][3],
			'investasi' => $data['B'][4],
			'operasional' => $data['B'][5],
			'perencanaan_dan_manajemen_risiko' => $data['B'][6],
			'sdm_dan_pengadaan' => $data['B'][7],
			'hukum_dan_kepatuhan' => $data['B'][8],
			'audit_internal' => $data['B'][9],
			'sekretariat_badan_pelaksana' => $data['B'][10],
			'sekretariat_dewan_pengawas' => $data['B'][11],
			'tahun' => $data['C'][1],
			'bulan' => $data['B'][1],
		);

		// Panggil fungsi insert_penyerapan_perbidang
		$this->bpih_model->insert_penyerapan_perbidang($dataquery);

		redirect("bpih/penyerapan_perbidang"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus_penyerapan_perbidang($id = 0, $uri = NULL)
	{
		$this->db->delete('penyerapan_perbidang', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('bpih/penyerapan_perbidang'));
	}

	public function export_penyerapan_perbidang($tahun)
	{

		// ambil style untuk table dari library Excel.php
		$style_header = $this->excel->style('style_header');
		$style_td = $this->excel->style('style_td');
		$style_td_left = $this->excel->style('style_td_left');
		$style_td_bold = $this->excel->style('style_td_bold');

		// create file name

		$fileName = 'laporan_penyerapan_output_perbidang_' . $tahun . '-(' . date('d-m-Y H-i-s', time()) . ').xlsx';

		$sebaran = $this->bpih_model->get_penyerapan_perbidang($tahun);
		$maxcolumn = konversiAngkaKeHuruf(count($sebaran) + 1);
		$excel = new PHPExcel();

		// Settingan awal file excel
		$excel->getProperties()->setCreator('BPKH')
			->setLastModifiedBy('BPKH')
			->setTitle("Laporan Penyerapan Anggaran per Bidang Tahun " . $tahun)
			->setSubject("Laporan Penyerapan Anggaran per Bidang Tahun " . $tahun)
			->setDescription("Laporan Penyerapan Anggaran per Bidang Tahun " . $tahun)
			->setKeywords("Laporan Operasional Akumulasi");

		//judul baris ke 1
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Penyerapan Anggaran per Bidang Tahun " . $tahun); // 
		$excel->getActiveSheet()->mergeCells('A1:' . $maxcolumn . '1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		//sub judul baris ke 2
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Badan Pengelola Keuangan Haji Republik Indonesia");
		$excel->getActiveSheet()->mergeCells('A2:' . $maxcolumn . '2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->getActiveSheet()->SetCellValue('A4', 'BULAN');
		$excel->getActiveSheet()->SetCellValue('A5', 'Pengembangan dan Kemaslahatan');
		$excel->getActiveSheet()->SetCellValue('A6', 'Keuangan');
		$excel->getActiveSheet()->SetCellValue('A7', 'Investasi');
		$excel->getActiveSheet()->SetCellValue('A8', 'Operasional');
		$excel->getActiveSheet()->SetCellValue('A9', 'Perencanaan dan Manajemen Risiko');
		$excel->getActiveSheet()->SetCellValue('A10', 'SDM dan Pengadaan');
		$excel->getActiveSheet()->SetCellValue('A11', 'Hukum dan Kepatuhan');
		$excel->getActiveSheet()->SetCellValue('A12', 'Audit Internal');
		$excel->getActiveSheet()->SetCellValue('A13', 'Sekretariat Badan Pelaksana');
		$excel->getActiveSheet()->SetCellValue('A14', 'Sekretariat Dewan Pengawas');

		$i = 2;
		foreach ($sebaran as $element) {
			//echo $element['bulan'];echo konversiAngkaKeHuruf($i);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 4, $element['bulan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 5, $element['pengembangan_dan_kemaslahatan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 6, $element['keuangan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 7, $element['investasi']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 8, $element['operasional']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 9, $element['perencanaan_dan_manajemen_risiko']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 10, $element['sdm_dan_pengadaan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 11, $element['hukum_dan_kepatuhan']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 12, $element['audit_internal']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 13, $element['sekretariat_badan_pelaksana']);
			$excel->getActiveSheet()->SetCellValue(konversiAngkaKeHuruf($i) . 14, $element['sekretariat_dewan_pengawas']);

			$i++;
		}

		//header style
		for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
			$excel->getActiveSheet()->getStyle($i . '4')->applyFromArray($style_header);
		}
		//td style
		for ($baris = 5; $baris <= 14; $baris++) {
			for ($i = 'A'; $i <=  $excel->getActiveSheet()->getHighestColumn(); $i++) {
				$excel->getActiveSheet()->getStyle($i . $baris)->applyFromArray($style_td);
			}
		}

		for ($i = 5; $i <= 14; $i++) {
			$excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($style_td_left);
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
