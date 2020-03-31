<?php
	class Makro_model extends CI_Model{	
		//GDP Ina
		public function get_gdp_ina(){
			$this->db->select('*');
			$this->db->from('gdp_ina');
			$this->db->order_by('tahun','ASC');
    		$query = $this->db->get(); 

    		return $result = $query->result_array();
  		} 	

  		public function get_gdp_ina_by_id($id){		
	        $this->db->from('gdp_ina');
	        $this->db->where('id',$id);
	        $query = $this->db->get();
	  
	        return $query->row();
  		} 			  
		  
		public function tambah_gdp_ina($data){
	       	$this->db->insert('gdp_ina', $data);
			return $this->db->insert_id();    
		}

		//GDP ksa
		public function get_gdp_ksa(){
			$this->db->select('*');
			$this->db->from('gdp_ksa');
			$this->db->order_by('tahun','ASC');
    		$query = $this->db->get(); 

    		return $result = $query->result_array();
  		} 	

  		public function get_gdp_ksa_by_id($id){		
	        $this->db->from('gdp_ksa');
	        $this->db->where('id',$id);
	        $query = $this->db->get();
	  
	        return $query->row();
  		} 			  
		  
		public function tambah_gdp_ksa($data){
	       	$this->db->insert('gdp_ksa', $data);
			return $this->db->insert_id();    
		}

		//Inflasi
		public function get_inflasi(){
			$this->db->select('*');
			$this->db->from('inflasi');
			$this->db->order_by('tahun','ASC');
    		$query = $this->db->get(); 

    		return $result = $query->result_array();
  		} 	

  		public function get_inflasi_by_id($id){		
	        $this->db->from('inflasi');
	        $this->db->where('id',$id);
	        $query = $this->db->get();
	  
	        return $query->row();
  		} 			  
		  
		public function tambah_inflasi($data){
	       	$this->db->insert('inflasi', $data);
			return $this->db->insert_id();    
		}

		//HARGA EMAS
		public function get_harga_emas(){
			$this->db->select('*');
			$this->db->from('harga_emas');
			$this->db->order_by('tahun','ASC');
    		$query = $this->db->get(); 

    		return $result = $query->result_array();
  		} 	

  		public function get_harga_emas_by_id($id){		
	        $this->db->from('harga_emas');
	        $this->db->where('id',$id);
	        $query = $this->db->get();
	  
	        return $query->row();
  		} 			  
		  
		public function tambah_harga_emas($data){
	       	$this->db->insert('harga_emas', $data);
			return $this->db->insert_id();    
		}

		//HARGA ISS
		public function get_indeks_saham_syariah(){
			$this->db->select('*');
			$this->db->from('indeks_saham_syariah');
			$this->db->order_by('tahun','ASC');
    		$query = $this->db->get(); 

    		return $result = $query->result_array();
  		} 	

  		public function get_indeks_saham_syariah_by_id($id){		
	        $this->db->from('indeks_saham_syariah');
	        $this->db->where('id',$id);
	        $query = $this->db->get();
	  
	        return $query->row();
  		} 			  
		  
		public function tambah_indeks_saham_syariah($data){
	       	$this->db->insert('indeks_saham_syariah', $data);
			return $this->db->insert_id();    
		}

		//HARGA AVTUR
		public function get_harga_avtur(){
			$this->db->select('*');
			$this->db->from('harga_avtur');
			$this->db->order_by('tahun','ASC');
    		$query = $this->db->get(); 

    		return $result = $query->result_array();
  		} 	

  		public function get_harga_avtur_by_id($id){		
	        $this->db->from('harga_avtur');
	        $this->db->where('id',$id);
	        $query = $this->db->get();
	  
	        return $query->row();
  		} 			  
		  
		public function tambah_harga_avtur($data){
	       	$this->db->insert('harga_avtur', $data);
			return $this->db->insert_id();    
		}

		//SB LPS
		public function get_suku_bunga_lps(){
			$this->db->select('*');
			$this->db->from('suku_bunga_lps');
			$this->db->order_by('tahun','ASC');
    		$query = $this->db->get(); 

    		return $result = $query->result_array();
  		} 	

  		public function get_suku_bunga_lps_by_id($id){		
	        $this->db->from('suku_bunga_lps');
	        $this->db->where('id',$id);
	        $query = $this->db->get();
	  
	        return $query->row();
  		} 			  
		  
		public function tambah_suku_bunga_lps($data){
	       	$this->db->insert('suku_bunga_lps', $data);
			return $this->db->insert_id();    
		}

		//YIELD SB
		public function get_yield_sukuk_negara(){
			$this->db->select('*');
			$this->db->from('yield_sukuk_negara');
			$this->db->order_by('tahun','ASC');
    		$query = $this->db->get(); 

    		return $result = $query->result_array();
  		} 	

  		public function get_yield_sukuk_negara_by_id($id){		
	        $this->db->from('yield_sukuk_negara');
	        $this->db->where('id',$id);
	        $query = $this->db->get();
	  
	        return $query->row();
  		} 			  
		  
		public function tambah_yield_sukuk_negara($data){
	       	$this->db->insert('yield_sukuk_negara', $data);
			return $this->db->insert_id();    
		}

		public function get_laporan_industri_keuangan_syariah($kategori){
			
			$this->db->select('*');
			$this->db->from('laporan_industri_keuangan_syariah');	
			if($kategori != '') {		
				$this->db->where('jenis_laporan_industri_keuangan_syariah', $kategori);
			}
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get();

			return $result = $query->result_array();			
		}
	
  		public function tambah_laporan_industri_keuangan_syariah($data){
		   return $this->db->insert('laporan_industri_keuangan_syariah', $data);
		}

	}

?>