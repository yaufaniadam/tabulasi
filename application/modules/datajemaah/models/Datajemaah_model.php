<?php
	class Datajemaah_model extends CI_Model{	
		//GDP Ina
		public function get_datajemaah($kat){
			$this->db->select('*');
			$this->db->from('data_jemaah');
			$this->db->where('kat_data_jemaah',$kat);
			$this->db->order_by('tahun','ASC');
    		$query = $this->db->get(); 

    		return $result = $query->result_array();
  		} 	

  		public function get_datajemaah_id($id){		
	        $this->db->from('data_jemaah');
	        $this->db->where('id',$id);
	        $query = $this->db->get();
	  
	        return $query->row();
  		} 			  
		  
		public function tambah_datajemaah($data){
	       	$this->db->insert('data_jemaah', $data);
			return $this->db->insert_id();    
		}

		

	}

?>