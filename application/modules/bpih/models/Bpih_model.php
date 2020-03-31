<?php
	class Bpih_model extends CI_Model{			

		// LAPORAN REALISASI ANGGARAN

		public function get_tahun_pencapaian_perbidang(){
			
			$this->db->select('tahun');
			$this->db->from('pencapaian_perbidang');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_pencapaian_perbidang($tahun){
			$this->db->select('*,tahun');
			$this->db->from('pencapaian_perbidang');
			$this->db->where('tahun', $tahun);
    		$query = $this->db->get(); 
    		return $result = $query->result_array();
  		}

  		public function get_detail_pencapaian_perbidang($id){
			$this->db->select('*');
			$this->db->from('pencapaian_perbidang');
			$this->db->where('id', $id);
    		$query = $this->db->get(); 
    		return $result = $query->row_array();
  		}		  
		  
		public function insert_pencapaian_perbidang($data){
		    $this->db->insert('pencapaian_perbidang', $data);
		}

		// LAPORAN REALISASI ANGGARAN

		public function get_tahun_penyerapan_perbidang(){
			
			$this->db->select('tahun');
			$this->db->from('penyerapan_perbidang');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_penyerapan_perbidang($tahun){
			$this->db->select('*,tahun');
			$this->db->from('penyerapan_perbidang');
			$this->db->where('tahun', $tahun);
    		$query = $this->db->get(); 
    		return $result = $query->result_array();
  		}

  		public function get_detail_penyerapan_perbidang($id){
			$this->db->select('*');
			$this->db->from('penyerapan_perbidang');
			$this->db->where('id', $id);
    		$query = $this->db->get(); 
    		return $result = $query->row_array();
  		}		  
		  
		public function insert_penyerapan_perbidang($data){
		    $this->db->insert('penyerapan_perbidang', $data);
		}
	}

?>