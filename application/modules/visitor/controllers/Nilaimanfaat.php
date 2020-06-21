<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use PhpOffice\PhpSpreadsheet\Style\Alignment; 
class Nilaimanfaat extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('keuanganhaji/nilaimanfaat_model', 'nilaimanfaat_model');
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
		$data['view'] = 'nilaimanfaat/per_instrumen';
		$this->load->view('admin/layout', $data);
	}

	public function detail_per_instrumen($id = 0)
	{

		$data['per_instrumen'] = $this->nilaimanfaat_model->get_detail_per_instrumen($id);
		$data['view'] = 'detail_per_instrumen';
		$this->load->view('admin/layout', $data);
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

		$data['view'] = 'nilaimanfaat/nilai_manfaat_penempatan_di_bpsbpih';
		$this->load->view('admin/layout', $data);
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
		redirect(base_url('keuanganhaji/nilaimanfaat/penempatan_di_bpsbpih/'.$tahun));
	}
	

	// nilai manfaat produk
	public function produk($tahun = 0)
	{

		$tahun = ($tahun != '') ? $tahun : date('Y');

		$data['thn'] = $tahun;
		$data['tahun'] = $this->nilaimanfaat_model->get_tahun_nilai_manfaat_produk(); // untuk menu pilihan tahun
		$data['nilai_manfaat_produk'] = $this->nilaimanfaat_model->get_nilai_manfaat_produk($tahun);

		$data['view'] = 'nilaimanfaat/nilai_manfaat_produk';
		$this->load->view('admin/layout', $data);
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
