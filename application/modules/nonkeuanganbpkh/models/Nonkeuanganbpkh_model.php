<?php
class Nonkeuanganbpkh_model extends CI_Model
{

	public function get_dokumen($kategori)
	{

		$this->db->select('*');
		$this->db->from('dokumen');
		if ($kategori != '') {
			$this->db->where('jenis_dokumen', $kategori);
		}
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();

		return $result = $query->result_array();
	}

	public function tambah_dokumen($data)
	{
		return $this->db->insert('dokumen', $data);
	}
}
