<?php
class Laporankeuangan_model extends CI_Model
{

	// NERACA

	public function get_tahun_neraca()
	{
		$this->db->select('YEAR(date) as tahun');
		$this->db->from('neraca');

		$this->db->order_by('date', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();

		return $result = $query->result_array();
	}

	public function get_neraca($tahun)
	{
		$this->db->select("
		date as Bulan,
		id as Hapus,
		'' as '<strong>ASET</strong>',
		'' as '<strong><em>Aset Lancar</em></strong>',
		uangmukabpih as 'Uang muka BPIH',
		penempatanpadabank as 'Penempatan pada bank',
		investasijangkapendek as 'Investasi jangka pendek',
		jumlahasetlancar as '<strong>Jumlah Aset Lancar</strong>',
		'' as '<strong><em>Aset Tidak Lancar</em></strong>',
		investasijangkapanjang as 'Investasi jangka panjang',
		asettetapbersih as 'Aset tetap - bersih',
		asettakberwujudbersih as 'Aset tak berwujud - bersih',
		asetlainlain as 'Aset lain-lain',
		jumlahasettidaklancar as '<strong>Jumlah Aset Tidak Lancar</strong>',
		totalaset as '<strong>TOTAL ASET</strong>',
		'' as '<strong>LIABILITAS</strong>',
		'' as '<strong><em>Liabilitas Jangka Pendek</em></strong>',
		utangbeban as 'Utang beban',
		utangsetoranlunasdantunda as 'Utang setoran lunas dan tunda',
		utangpajak as 'Utang pajak',
		utanglainlain as 'Utang lain-Lain',
		jumlahliabilitasjangkapendek as '<strong>Jumlah Liabilitas Jangka Pendek</strong>',
		'' as '<strong><em>Liabilitas Jangka Panjang</em></strong>',
		danatitipanjemaah as 'Dana titipan jemaah',
		pendapatannilaimanfaatyangditangguhkan as 'Pendapatan nilai manfaat yang ditangguhkan',
		jumlahliabilitasjangkapanjang as '<strong>Jumlah Liabilitas Jangka Panjang</strong>',
		jumlahliabilitas as '<strong>JUMLAH LIABILITAS</strong>',
		'' as '<strong>ASET NETO</strong>',
		tidakterikat as 'Tidak terikat',
		terikattemporer as 'Terikat temporer',
		terikatpermanen as 'Terikat permanen',
		jumlahasetneto as '<strong>JUMLAH ASET NETO</strong>',
		jumlahliabilitasdanasetneto as '<strong>JUMLAH LIABILITAS DAN ASET NETO</strong>'	
		");
		$this->db->from('neraca');
		$this->db->where('YEAR(date)', $tahun);
		$this->db->order_by('date', 'ASC');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_neraca_export($tahun)
	{
		$this->db->select('*, YEAR(date) as tahun');
		$this->db->from('neraca');
		$this->db->where('YEAR(date)', $tahun);
		$this->db->order_by('date', 'ASC');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_neraca($id)
	{
		$this->db->select('*');
		$this->db->from('neraca');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $result = $query->row_array();
	}

	public function insert_neraca($data)
	{
		$this->db->insert('neraca', $data);
	}

	// LAPORAN BULANAN

	public function get_tahun_lap_bulanan()
	{

		$this->db->select('tahun');
		$this->db->from('lap_bulanan');

		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();

		return $result = $query->result_array();
	}

	public function get_lap_bulanan($tahun)
	{
		$this->db->select('*,tahun');
		$this->db->from('lap_bulanan');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('bulan', 'ASC');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_lap_bulanan($id)
	{
		$this->db->select('*');
		$this->db->from('lap_bulanan');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $result = $query->row_array();
	}

	public function insert_lap_bulanan($data)
	{
		$this->db->insert('lap_bulanan', $data);
	}

	// LAPORAN AKUMULASI

	public function get_tahun_lap_akumulasi()
	{

		$this->db->select('tahun');
		$this->db->from('lap_akumulasi');

		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();

		return $result = $query->result_array();
	}

	public function get_lap_akumulasi($tahun)
	{
		$this->db->select('*,tahun');
		$this->db->from('lap_akumulasi');
		$this->db->where('tahun', $tahun);		
		$this->db->order_by('bulan', 'ASC');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_lap_akumulasi($id)
	{
		$this->db->select('*');
		$this->db->from('lap_akumulasi');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $result = $query->row_array();
	}

	public function insert_lap_akumulasi($data)
	{
		$this->db->insert('lap_akumulasi', $data);
	}

	// LAPORAN PERUBAHAN ASET NETO

	public function get_tahun_perubahan_asetneto()
	{

		$this->db->select('tahun');
		$this->db->from('perubahan_asetneto');

		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();

		return $result = $query->result_array();
	}

	public function get_perubahan_asetneto($tahun)
	{
		$this->db->select('*,tahun');
		$this->db->from('perubahan_asetneto');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('bulan', 'ASC');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function get_detail_perubahan_asetneto($id)
	{
		$this->db->select('*');
		$this->db->from('perubahan_asetneto');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $result = $query->row_array();
	}

	public function insert_perubahan_asetneto($data)
	{
		$this->db->insert('perubahan_asetneto', $data);
	}

	// LAPORAN REALISASI ANGGARAN

	public function get_tahun_realisasi_anggaran(){
			
		$this->db->select('tahun');
		$this->db->from('realisasi_anggaran2');			
		
		$this->db->order_by('tahun', 'ASC');
		$this->db->group_by('tahun');

		$query = $this->db->get();
		return $result = $query->result_array();			
	}

	public function get_realisasi_anggaran($tahun){
		$this->db->select('bulan,tahun');
		$this->db->from('realisasi_anggaran2');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('id', 'ASC');
		$this->db->group_by('bulan');
		$query = $this->db->get(); 
		return $result = $query->result_array();
	  }

	  public function get_detail_realisasi_anggaran($bulan, $tahun){
		$this->db->select('*');
		$this->db->from('realisasi_anggaran2');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get(); 
		return $result = $query->result_array();
	  }		  
	  
	public function insert_realisasi_anggaran($data){
		$this->db->insert_batch('realisasi_anggaran2', $data);
	}

	public function get_tahun_penyerapan_perbidang(){
		
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
