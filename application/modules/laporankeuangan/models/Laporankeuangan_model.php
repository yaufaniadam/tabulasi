<?php
class Laporankeuangan_model extends CI_Model
{
	public function get_tahun_neraca()
	{

		$this->db->select('tahun');
		$this->db->from('neraca2');

		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_neraca($tahun)
	{
		$this->db->select('bulan,tahun');
		$this->db->from('neraca2');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('bulan', 'ASC');
		$this->db->group_by('bulan');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_neraca($bulan, $tahun)
	{
		$this->db->select('*');
		$this->db->from('neraca2');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('bidang !=', '');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function insert_neraca($data)
	{
		$this->db->insert_batch('neraca2', $data);
	}

	// LAPORAN BULANAN

	public function get_tahun_lap_bulanan()
	{

		$this->db->select('tahun');
		$this->db->from('lap_bulanan2');

		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_lap_bulanan($tahun)
	{
		$this->db->select('bulan,tahun');
		$this->db->from('lap_bulanan2');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('bulan', 'ASC');
		$this->db->group_by('bulan');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_lap_bulanan($bulan, $tahun)
	{
		$this->db->select('*');
		$this->db->from('lap_bulanan2');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('bidang !=', '');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function insert_lap_bulanan($data)
	{
		$this->db->insert_batch('lap_bulanan2', $data);
	}

	// LAPORAN BULANAN

	public function get_tahun_lap_akumulasi()
	{

		$this->db->select('tahun');
		$this->db->from('lap_akumulasi2');

		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_lap_akumulasi($tahun)
	{
		$this->db->select('bulan,tahun');
		$this->db->from('lap_akumulasi2');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('bulan', 'ASC');
		$this->db->group_by('bulan');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_lap_akumulasi($bulan, $tahun)
	{
		$this->db->select('*');
		$this->db->from('lap_akumulasi2');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('bidang !=', '');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function insert_lap_akumulasi($data)
	{
		$this->db->insert_batch('lap_akumulasi2', $data);
	}

	// LAPORAN PERUBAHAN ASET NETO

	public function get_tahun_perubahan_asetneto()
	{

		$this->db->select('tahun');
		$this->db->from('perubahan_asetneto2');

		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_perubahan_asetneto($tahun)
	{
		$this->db->select('bulan,tahun');
		$this->db->from('perubahan_asetneto2');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('bulan', 'ASC');
		$this->db->group_by('bulan');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_perubahan_asetneto($bulan, $tahun)
	{
		$this->db->select('*');
		$this->db->from('perubahan_asetneto2');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('bidang !=', '');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function insert_perubahan_asetneto($data)
	{
		$this->db->insert_batch('perubahan_asetneto2', $data);
	}

	// LAPORAN REALISASI ANGGARAN

	public function get_tahun_realisasi_anggaran()
	{

		$this->db->select('tahun');
		$this->db->from('realisasi_anggaran2');

		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_realisasi_anggaran($tahun)
	{
		$this->db->select('bulan,tahun');
		$this->db->from('realisasi_anggaran2');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('bulan', 'ASC');
		$this->db->group_by('bulan');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_realisasi_anggaran($bulan, $tahun)
	{
		$this->db->select('*');
		$this->db->from('realisasi_anggaran2');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function insert_realisasi_anggaran($data)
	{
		$this->db->insert_batch('realisasi_anggaran2', $data);
	}

	public function get_tahun_penyerapan_perbidang()
	{

		$this->db->select('tahun');
		$this->db->from('penyerapan_perbidang2');

		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();
	}

	// LAPORAN BULANAN

	public function get_tahun_lap_arus_kas()
	{

		$this->db->select('tahun');
		$this->db->from('lap_arus_kas');

		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();

		return $result = $query->result_array();
	}

	public function get_lap_arus_kas($tahun)
	{
		$this->db->select('*,tahun');
		$this->db->from('lap_arus_kas');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('bulan', 'ASC');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_lap_arus_kas($id)
	{
		$this->db->select('*');
		$this->db->from('lap_arus_kas');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $result = $query->row_array();
	}

	public function insert_lap_arus_kas($data)
	{
		$this->db->insert('lap_arus_kas', $data);
	}
}
