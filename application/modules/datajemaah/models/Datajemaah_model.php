<?php
class Datajemaah_model extends CI_Model
{
	//GDP Ina
	public function get_datajemaah($kat)
	{
		$this->db->select('*');
		$this->db->from('data_jemaah');
		$this->db->where('kat_data_jemaah', $kat);
		$this->db->order_by('tahun', 'ASC');
		$query = $this->db->get();

		return $result = $query->result_array();
	}

	public function get_datajemaah_id($id)
	{
		$this->db->from('data_jemaah');
		$this->db->where('id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function tambah_datajemaah($data)
	{
		$this->db->insert('data_jemaah', $data);
		return $this->db->insert_id();
	}

	// LAPORAN REALISASI ANGGARAN

	public function get_tahun_realisasi_bpih()
	{

		$this->db->select('tahun');
		$this->db->from('realisasi_bpih');
		$this->db->where(array('tahun !=' => '0', 'tahun !=' => ''));
		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_realisasi_bpih()
	{
		$this->db->select('id, tahun');
		$this->db->from('realisasi_bpih');
		$this->db->order_by('id', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_realisasi_bpih($tahun)
	{
		$this->db->select('*');
		$this->db->from('realisasi_bpih');
		$this->db->where('tahun', $tahun);
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function insert_realisasi_bpih($data)
	{
		$this->db->insert_batch('realisasi_bpih', $data);
	}
}
