<?php defined('BASEPATH') or exit('No direct script access allowed');

class Makro extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('makro_model', 'makro_model');
	}

	public function index($tahun = 0)
	{
		$data['view'] = 'index';
		$this->load->view('admin/layout', $data);
	}

	public function gdp_ina()
	{
		$data['gdp_ina'] = $this->makro_model->get_gdp_ina();
		$data['view'] = 'gdp_ina';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_gdp_ina()
	{
		$data = array(
			'tahun' => $this->input->post('tahun'),
			'gdp_ina' => $this->input->post('gdp_ina'),
			'date' => date('Y-m-d : h:i:s'),
		);

		$id = $this->makro_model->tambah_gdp_ina($data);
		$status = true;

		$data = $this->makro_model->get_gdp_ina_by_id($id);

		echo json_encode(array("status" => $status, 'data' => $data));
	}

	public function hapus_gdp_ina($id = 0, $uri = NULL)
	{
		$this->db->delete('gdp_ina', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('makro/gdp_ina'));
	}

	public function gdp_ksa()
	{
		$data['gdp_ksa'] = $this->makro_model->get_gdp_ksa();
		$data['view'] = 'gdp_ksa';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_gdp_ksa()
	{
		$data = array(
			'tahun' => $this->input->post('tahun'),
			'gdp_ksa' => $this->input->post('gdp_ksa'),
			'date' => date('Y-m-d : h:i:s'),
		);

		$id = $this->makro_model->tambah_gdp_ksa($data);
		$status = true;

		$data = $this->makro_model->get_gdp_ksa_by_id($id);

		echo json_encode(array("status" => $status, 'data' => $data));
	}

	public function hapus_gdp_ksa($id = 0, $uri = NULL)
	{
		$this->db->delete('gdp_ksa', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('makro/gdp_ksa'));
	}

	// INFLASI

	public function inflasi()
	{
		$data['inflasi'] = $this->makro_model->get_inflasi();
		$data['view'] = 'inflasi';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_inflasi()
	{
		$data = array(
			'tahun' => $this->input->post('tahun'),
			'inflasi' => $this->input->post('inflasi'),
			'date' => date('Y-m-d : h:i:s'),
		);

		$id = $this->makro_model->tambah_inflasi($data);
		$status = true;

		$data = $this->makro_model->get_inflasi_by_id($id);

		echo json_encode(array("status" => $status, 'data' => $data));
	}

	public function hapus_inflasi($id = 0, $uri = NULL)
	{
		$this->db->delete('inflasi', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('makro/inflasi'));
	}

	// HARGA EMAS
	public function harga_emas()
	{
		$data['harga_emas'] = $this->makro_model->get_harga_emas();
		$data['view'] = 'harga_emas';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_harga_emas()
	{
		$data = array(
			'tahun' => $this->input->post('tahun'),
			'harga_emas' => $this->input->post('harga_emas'),
			'date' => date('Y-m-d : h:i:s'),
		);

		$id = $this->makro_model->tambah_harga_emas($data);
		$status = true;

		$data = $this->makro_model->get_harga_emas_by_id($id);

		echo json_encode(array("status" => $status, 'data' => $data));
	}

	public function hapus_harga_emas($id = 0, $uri = NULL)
	{
		$this->db->delete('harga_emas', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('makro/harga_emas'));
	}

	public function indeks_saham_syariah()
	{
		$data['indeks_saham_syariah'] = $this->makro_model->get_indeks_saham_syariah();
		$data['view'] = 'indeks_saham_syariah';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_indeks_saham_syariah()
	{
		$data = array(
			'tahun' => $this->input->post('tahun'),
			'indeks_saham_syariah' => $this->input->post('indeks_saham_syariah'),
			'date' => date('Y-m-d : h:i:s'),
		);

		$id = $this->makro_model->tambah_indeks_saham_syariah($data);
		$status = true;

		$data = $this->makro_model->get_indeks_saham_syariah_by_id($id);

		echo json_encode(array("status" => $status, 'data' => $data));
	}

	public function hapus_indeks_saham_syariah($id = 0, $uri = NULL)
	{
		$this->db->delete('indeks_saham_syariah', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('makro/indeks_saham_syariah'));
	}

	// harga avtur 

	public function harga_avtur()
	{
		$data['harga_avtur'] = $this->makro_model->get_harga_avtur();
		$data['view'] = 'harga_avtur';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_harga_avtur()
	{
		$data = array(
			'tahun' => $this->input->post('tahun'),
			'harga_avtur' => $this->input->post('harga_avtur'),
			'date' => date('Y-m-d : h:i:s'),
		);

		$id = $this->makro_model->tambah_harga_avtur($data);
		$status = true;

		$data = $this->makro_model->get_harga_avtur_by_id($id);

		echo json_encode(array("status" => $status, 'data' => $data));
	}

	public function hapus_harga_avtur($id = 0, $uri = NULL)
	{
		$this->db->delete('harga_avtur', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('makro/harga_avtur'));
	}

	// SB LPS
	public function suku_bunga_lps()
	{
		$data['suku_bunga_lps'] = $this->makro_model->get_suku_bunga_lps();
		$data['view'] = 'suku_bunga_lps';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_suku_bunga_lps()
	{
		$data = array(
			'tahun' => $this->input->post('tahun'),
			'suku_bunga_lps' => $this->input->post('suku_bunga_lps'),
			'date' => date('Y-m-d : h:i:s'),
		);

		$id = $this->makro_model->tambah_suku_bunga_lps($data);
		$status = true;

		$data = $this->makro_model->get_suku_bunga_lps_by_id($id);

		echo json_encode(array("status" => $status, 'data' => $data));
	}

	public function hapus_suku_bunga_lps($id = 0, $uri = NULL)
	{
		$this->db->delete('suku_bunga_lps', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('makro/suku_bunga_lps'));
	}

	// YIELD
	public function yield_sukuk_negara()
	{
		$data['yield_sukuk_negara'] = $this->makro_model->get_yield_sukuk_negara();
		$data['view'] = 'yield_sukuk_negara';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_yield_sukuk_negara()
	{
		$data = array(
			'tahun' => $this->input->post('tahun'),
			'yield_sukuk_negara' => $this->input->post('yield_sukuk_negara'),
			'date' => date('Y-m-d : h:i:s'),
		);

		$id = $this->makro_model->tambah_yield_sukuk_negara($data);
		$status = true;

		$data = $this->makro_model->get_yield_sukuk_negara_by_id($id);

		echo json_encode(array("status" => $status, 'data' => $data));
	}

	public function hapus_yield_sukuk_negara($id = 0, $uri = NULL)
	{
		$this->db->delete('yield_sukuk_negara', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('makro/yield_sukuk_negara'));
	}

	// nilai manfaat regulasi
	public function laporan_industri_keuangan_syariah($kategori = 0)
	{

		$kategori = ($kategori != '') ? $kategori : '';


		$data['dokumen'] = $this->makro_model->get_laporan_industri_keuangan_syariah($kategori);

		$data['view'] = 'makro/laporan_industri_keuangan_syariah';
		$this->load->view('admin/layout', $data);
	}

	public function tambah_laporan_industri_keuangan_syariah()
	{
		if ($this->input->post('submit')) {

			$this->form_validation->set_rules('nama_laporan_industri_keuangan_syariah', 'Judul laporan_industri_keuangan_syariah', 'trim|required');
	
			if ($this->form_validation->run() == FALSE) {

				$data['view'] = 'makro/tambah_laporan_industri_keuangan_syariah';
				$this->load->view('admin/layout', $data);
			} else {

				$upload_path = './uploads/laporan_industri_keuangan_syariah';

				if (!is_dir($upload_path)) {
					mkdir($upload_path, 0777, TRUE);
				}

				$config = array(
					'upload_path' => $upload_path,
					'allowed_types' => "doc|docx|xls|xlsx|ppt|pptx|odt|rtf|jpg|png|pdf",
					'overwrite' => FALSE,
				);

				$this->load->library('upload', $config);
				$this->upload->do_upload('file_laporan_industri_keuangan_syariah');
				$laporan_industri_keuangan_syariah= $this->upload->data();


				$data = array(
					'nama_dokumen' => $this->input->post('nama_laporan_industri_keuangan_syariah'),
					'date' => date('Y-m-d'),
					'upload_by' => $this->session->userdata('user_id'),
					'file' => $upload_path . '/' . $laporan_industri_keuangan_syariah['file_name'],
				
				);

				$data = $this->security->xss_clean($data);
				$result = $this->makro_model->tambah_laporan_industri_keuangan_syariah($data);

				if ($result) {
					$this->session->set_flashdata('msg', 'Dokumen telah ditambahkan!');
					redirect(base_url('makro/laporan_industri_keuangan_syariah'));
				}
			}
		} else {


			$data['view'] = 'makro/tambah_laporan_industri_keuangan_syariah';
			$this->load->view('admin/layout', $data);
		}
	}



	public function hapus_laporan_industri_keuangan_syariah($id = 0, $uri = NULL)
	{
		$this->db->delete('laporan_industri_keuangan_syariah', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('makro/laporan_industri_keuangan_syariah'));
	}
} //class
