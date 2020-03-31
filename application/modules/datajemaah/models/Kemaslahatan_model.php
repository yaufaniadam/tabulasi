<?php
	class Kemaslahatan_model extends CI_Model{	
		// PER INSTRUMEN

		public function get_tahun_kemaslahatan(){
			
			$this->db->select('tahun');
			$this->db->from('program_kemaslahatan');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_kemaslahatan($tahun){
			$this->db->select('*');
			$this->db->from('program_kemaslahatan');
			$this->db->where('tahun', $tahun);
			$this->db->order_by('bulan', 'ASC');
    		$query = $this->db->get(); 
    		return $result = $query->result_array();
  		}

  		public function get_detail_kemaslahatan($id){
			$this->db->select('*');
			$this->db->from('program_kemaslahatan');
			$this->db->where('id_kemaslahatan', $id);
    		$query = $this->db->get(); 
    		return $result = $query->row_array();
  		}		  
		  
		public function insert_kemaslahatan($data){
		    $this->db->insert_batch('program_kemaslahatan', $data);
		}

	}

?>