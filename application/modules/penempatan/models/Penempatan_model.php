<?php
	class Penempatan_model extends CI_Model{

		public function add_jenis_penempatan($data){
			$this->db->insert('jenis_penempatan', $data);
			return true;
		}

		public function tambah_data_penempatan($data){
			$this->db->insert('penempatan', $data);
			return true;
		}
		
		//---------------------------------------------------
		// get all unit records
		public function get_all_jenis_penempatan(){
		
			$query = $this->db->get('jenis_penempatan');		
			return $result = $query->result_array();
		}	

		public function get_jenis_penempatan($slug){
	
			$query = $this->db->get_where('jenis_penempatan', array('slug' => $slug));		
			return $result = $query->row_array();
		
		}	

		

	}

?>