<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('excel');
	}

	public function index()
	{

		$participants_sah = $this->db->query('SELECT * from bpk_surveys_entity_participants where survey_id = 4 and status = 2 ORDER BY id DESC');

		$participants = $this->db->query('SELECT * from bpk_surveys_entity_participants where survey_id = 4 ORDER BY id DESC');

		$grafik = $this->db->query('SELECT DATE_FORMAT(start_date,"%e") as date, count(DATE_FORMAT(start_date,"%e")) as total from bpk_surveys_entity_participants 
		where survey_id = 4 AND
		status = 2
		GROUP BY date ORDER BY DATE_FORMAT(start_date,"%d") ASC ');

		$data['totalparticipants'] = $participants;
		$data['totalparticipants_sah'] = $participants_sah;
		$data['grafik'] = $grafik->result_array();
		$data['grafik_total'] = $grafik->result_array();

		$data['title'] = 'Hasil Statistik';
		$data['view'] = 'admin/dashboard/dashboard2';
		$this->load->view('layout', $data);
	}


	public function import_dashboard($file_excel)
	{
		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/dashboard/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = array(

			'periode' => $sheet[1]['D'],
			'tahun' => $sheet[1]['E'],

			'penempatan' => $sheet[2]['B'],
			'setoran_awal' => $sheet[3]['B'],
			'setoran_awal_per' => $sheet[3]['C'],
			'setoran_lunas' => $sheet[4]['B'],
			'setoran_lunas_per' => $sheet[4]['C'],
			'nilai_manfaat' => $sheet[5]['B'],
			'nilai_manfaat_per' => $sheet[5]['C'],
			'dau' => $sheet[6]['B'],
			'dau_per' => $sheet[6]['C'],

			'investasi' => $sheet[7]['B'],
			'setoran_awal_inv' => $sheet[8]['B'],
			'setoran_awal_inv_per' => $sheet[8]['C'],
			'dau_inv' => $sheet[9]['B'],
			'dau_inv_per' => $sheet[9]['C'],
			'total' => $sheet[10]['B'],
		);
		echo "<pre>";
		print_r($data);
		echo "</pre>";

		// Panggil fungsi insert_dashboard
		$this->dashboard_model->tambah($data);

		redirect("admin/dashboard"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}
}
