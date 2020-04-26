<?php defined('BASEPATH') or exit('No direct script access allowed');

class Datajemaah extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('datajemaah_model', 'datajemaah_model');
	}

	public function index()
	{
		redirect(base_url('datajemaah/antri'));
	}

	public function antri()
	{
		$id_kat = 2;
		$data['kat'] = $id_kat;
		$data['judul'] = "Data Jemaah Antri";
		$data['antri'] = $this->datajemaah_model->get_datajemaah($id_kat);
		$data['view'] = 'index';
		$this->load->view('admin/layout', $data);
	}
	public function kuota()
	{
		$id_kat = 3;
		$data['kat'] = $id_kat;
		$data['judul'] = "Data Kuota Jemaah Berangkat";
		$data['antri'] = $this->datajemaah_model->get_datajemaah($id_kat);
		$data['view'] = 'index';
		$this->load->view('admin/layout', $data);
	}
	public function batal()
	{
		$id_kat = 1;
		$data['kat'] = $id_kat;
		$data['judul'] = "Data Jemaah Batal Berangkat";
		$data['antri'] = $this->datajemaah_model->get_datajemaah($id_kat);
		$data['view'] = 'index';
		$this->load->view('admin/layout', $data);
	}
	public function bipih()
	{
		$id_kat = 4;
		$data['kat'] = $id_kat;
		$data['judul'] = "Data Reaslisasi Bipih";
		$data['antri'] = $this->datajemaah_model->get_datajemaah($id_kat);
		$data['view'] = 'index';
		$this->load->view('admin/layout', $data);
	}
	public function bpih()
	{
		$id_kat = 5;
		$data['kat'] = $id_kat;
		$data['judul'] = "Data Realisasi BPIH";
		$data['antri'] = $this->datajemaah_model->get_datajemaah($id_kat);
		$data['view'] = 'index';
		$this->load->view('admin/layout', $data);
	}

	public function tambah($kat)
	{
		$data = array(
			'tahun' => $this->input->post('tahun'),
			'jumlah' => $this->input->post('jumlah'),
			'kat_data_jemaah' => $kat,
		);

		$id = $this->datajemaah_model->tambah_datajemaah($data);
		$status = true;

		$data = $this->datajemaah_model->get_datajemaah_id($id);

		echo json_encode(array("status" => $status, 'data' => $data));
	}

	public function hapus($id = 0, $uri = NULL)
	{
		$this->db->delete('data_jemaah', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus!');
		redirect(base_url('datajemaah/'.$uri));
	}
	
} //class
