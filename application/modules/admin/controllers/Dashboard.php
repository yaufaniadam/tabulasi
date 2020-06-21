<?php defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use PhpOffice\PhpSpreadsheet\Style\Alignment; 
class Dashboard extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/dashboard_model', 'dashboard_model');
		$this->load->model('dashboard_model');
		$this->load->library('excel');
	}

	public function index($tahun=0)
	{
		if ($tahun =='') {

		$query = $this->db->query('SELECT * from dashboard ORDER BY id DESC limit 1');

		} else {
			$query = $this->db->query("SELECT * from dashboard WHERE tahun='$tahun' ORDER BY id DESC limit 1");
		}

		$data['result'] = $query->row_array();

		$all_grafik = $this->db->query('SELECT * from dashboard ORDER BY id DESC');

		$data['all_grafik'] = $all_grafik->result_array();

		$data['title'] = 'Dashboard Admin';
		$data['view'] = 'admin/dashboard/dashboard2';
		$this->load->view('layout', $data);
	}

	public function users()
	{
		$data['view'] = 'admin/dashboard/dashboard_user';
		$this->load->view('layout', $data);
	}

	public function tambah()
	{

		if (isset($_POST['submit'])) {

			$upload_path = './uploads/excel/dashboard';

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
				$loadexcel = $excelreader->load('./uploads/excel/dashboard/' . $upload['file_name']); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				$data['sheet'] = $sheet;
				$data['file_excel'] = $upload['file_name'];


				$data['view'] = 'dashboard/tambah';
				$this->load->view('admin/layout', $data);
			} else {

				echo "gagal";
				$data['view'] = 'dashboard/tambah';
				$this->load->view('admin/layout', $data);
			}
		} else {

			$data['view'] = 'dashboard/tambah';
			$this->load->view('admin/layout', $data);
		}
    }
    
    public function import_dashboard($file_excel)
	{
		$excelreader = new Xlsx;
		$loadexcel = $excelreader->load('./uploads/excel/dashboard/' . $file_excel); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = array(
			
			'periode' =>$sheet[1]['D'],
			'tahun' =>$sheet[1]['E'],

			'penempatan' => $sheet[2]['B'],
			'setoran_awal' =>$sheet[3]['B'],
			'setoran_awal_per' =>$sheet[3]['C'],
			'setoran_lunas' =>$sheet[4]['B'],
			'setoran_lunas_per' =>$sheet[4]['C'],
			'nilai_manfaat' =>$sheet[5]['B'],
			'nilai_manfaat_per' =>$sheet[5]['C'],
			'dau' =>$sheet[6]['B'],
			'dau_per' =>$sheet[6]['C'],

			'investasi' =>$sheet[7]['B'],
			'setoran_awal_inv' =>$sheet[8]['B'],
			'setoran_awal_inv_per' =>$sheet[8]['C'],
			'dau_inv' =>$sheet[9]['B'],
			'dau_inv_per' =>$sheet[9]['C'],
			'total' => $sheet[10]['B'],
		); 
		echo "<pre>";		
		print_r($data);
		echo "</pre>";
		
		// Panggil fungsi insert_dashboard
		$this->dashboard_model->tambah($data);

		redirect("admin/dashboard"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function hapus($tahun = 0){
		$this->db->delete('dashboard', array('tahun' => $tahun));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('admin/dashboard'));
	}
}
