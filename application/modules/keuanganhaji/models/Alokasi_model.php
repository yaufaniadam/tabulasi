<?php
	class Alokasi_model extends CI_Model{	

		// alokasi_investasi

		public function get_tahun_alokasi_investasi(){
			
			$this->db->select('tahun');
			$this->db->from('alokasi_investasi');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bulan_alokasi_investasi($tahun){
			
			$this->db->select('bulan');
			$this->db->from('alokasi_investasi');			
			$this->db->where('tahun', $tahun);

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_alokasi_investasi($tahun){
			$this->db->select('*, tahun');
			$this->db->from('alokasi_investasi');
			$this->db->where('tahun', $tahun);
			$this->db->order_by('bulan', 'ASC');
    		$query = $this->db->get(); 
    		return $result = $query->result_array();
  		}

  		public function get_detail_alokasi_investasi($id){
			$this->db->select('*');
			$this->db->from('alokasi_investasi');
			$this->db->where('id_alokasi_investasi', $id);
    		$query = $this->db->get(); 
    		return $result = $query->row_array();
  		}		  
		  
		public function insert_alokasi_investasi($data){
		    $this->db->insert('alokasi_investasi', $data);
		}

		// manfaat_investasi

		public function get_tahun_manfaat_investasi(){
			
			$this->db->select('tahun');
			$this->db->from('manfaat_investasi');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_manfaat_investasi($tahun){
			$this->db->select('*, tahun');
			$this->db->from('manfaat_investasi');
			$this->db->where('tahun', $tahun);
			$this->db->order_by('bulan', 'ASC');
    		$query = $this->db->get(); 
    		return $result = $query->result_array();
  		}

  		public function get_detail_manfaat_investasi($id){
			$this->db->select('*');
			$this->db->from('manfaat_investasi');
			$this->db->where('id_manfaat_investasi', $id);
    		$query = $this->db->get(); 
    		return $result = $query->row_array();
  		}		  
		  
		public function insert_manfaat_investasi($data){
		    $this->db->insert('manfaat_investasi', $data);
		}

	}

?>