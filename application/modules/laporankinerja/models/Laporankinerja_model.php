<?php
class Laporankinerja_model extends CI_Model
{

	// LAPORAN REALISASI ANGGARAN

	public function get_tahun_pencapaian_perbidang()
	{

		$this->db->select('tahun');
		$this->db->from('pencapaian_perbidang2');
		$this->db->where(array('tahun !=' => '0', 'tahun !=' => ''));
		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_pencapaian_perbidang($tahun)
	{
		$this->db->select('bulan,tahun');
		$this->db->from('pencapaian_perbidang2');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('bulan', 'ASC');
		$this->db->group_by('bulan');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_pencapaian_perbidang($bulan, $tahun)
	{
		$this->db->select('*');
		$this->db->from('pencapaian_perbidang2');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('bidang NOT NULL');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function insert_pencapaian_perbidang($data)
	{
		$this->db->insert_batch('pencapaian_perbidang2', $data);
	}

	public function get_tahun_penyerapan_perbidang()
	{

		$this->db->select('tahun');
		$this->db->from('penyerapan_perbidang2');
		$this->db->where(array('tahun !=' => '0', 'tahun !=' => ''));
		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_penyerapan_perbidang($tahun)
	{
		$this->db->select('bulan,tahun');
		$this->db->from('penyerapan_perbidang2');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('bulan', 'ASC');
		$this->db->group_by('bulan');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_penyerapan_perbidang($bulan, $tahun)
	{
		$this->db->select('*');
		$this->db->from('penyerapan_perbidang2');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('bidang !=', '');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function insert_penyerapan_perbidang($data)
	{
		$this->db->insert_batch('penyerapan_perbidang2', $data);
	}
}
