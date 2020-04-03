<?php
	class Nilaimanfaat_model extends CI_Model{	
		// PER INSTRUMEN

		public function get_tahun_per_instrumen(){
			
			$this->db->select('tahun');
			$this->db->from('per_instrumen');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_per_instrumen_export($tahun){
			$this->db->select('*');
			$this->db->from('per_instrumen');
			$this->db->where('tahun', $tahun);
			$this->db->order_by('tahun', 'ASC');
    		$query = $this->db->get(); 
    		return $result = $query->result_array();
  		}

		  public function get_per_instrumen($tahun){
			$this->db->select("
				bulan as Bulan, 
				id_per_instrumen as Hapus,
				dau as 'DAU (SDHI & SBSN)',
				surat_berharga as Surat Berharga,
				sdhi as SDHI,
				sbsn as SBSN,
				sbsn_usd as SBSN USD,
				sukuk_korporasi as Sukuk Korporasi,
				rd_terproteksi_syariah as RD Terproteksi Syariah,
				rd_pasar_uang_syariah as RD Pasar Uang Syariah,
				rd_penyertaan_terbatas as RD Penyertaan Terbatas,
				saham_bmi as Saham BMI,
				lain_lain as Lain-lain,
				investasi_langsung as Investasi Langsung,
				investasi_lainnya as Investasi Lainnya,
				emas as Emas,
				total as Total,
				total_exclude_dau as Total Exclude DAU
			");
			$this->db->from('per_instrumen');
			$this->db->where('tahun', $tahun);
			$this->db->order_by('tahun', 'ASC');
    		$query = $this->db->get(); 
    		return $result = $query->result_array();
  		}
  		public function get_detail_per_instrumen($id){
			$this->db->select('*');
			$this->db->from('per_instrumen');
			$this->db->where('id_per_instrumen', $id);
    		$query = $this->db->get(); 
    		return $result = $query->row_array();
  		}		  
		  
		public function insert_per_instrumen($data){
		    $this->db->insert('per_instrumen', $data);
		}

		//NILAI MANFAAT PER BPS BPIH
		public function get_tahun_nilai_manfaat_penempatan_di_bpsbpih(){
			
			$this->db->select('tahun');
			$this->db->from('nilai_manfaat_penempatan_di_bpsbpih');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();			
		}

		public function get_bps_bpih_nilai_manfaat_penempatan_di_bpsbpih(){
			
			$this->db->select('*');
			$this->db->from('nilai_manfaat_penempatan_di_bpsbpih');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();			
		}

		public function get_nilai_manfaat_penempatan_di_bpsbpih($tahun){
			
			$this->db->select('*');
			$this->db->from('nilai_manfaat_penempatan_di_bpsbpih');			
			$this->db->where('tahun', $tahun);
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get();

			return $result = $query->result_array();			
		}
	
  		public function insert_nilai_manfaat_penempatan_di_bpsbpih($data){
		    $this->db->insert_batch('nilai_manfaat_penempatan_di_bpsbpih', $data);
		}	

		//NILAI MANFAAT PER PRODUK
		public function get_tahun_nilai_manfaat_produk(){
			
			$this->db->select('tahun');
			$this->db->from('nilai_manfaat_produk');			
			
			$this->db->order_by('bulan', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_nilai_manfaat_produk(){
			
			$this->db->select('*');
			$this->db->from('nilai_manfaat_produk');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_nilai_manfaat_produk($tahun){
			
			$this->db->select('*');
			$this->db->from('nilai_manfaat_produk');			
			$this->db->where('tahun', $tahun);
				
			$query = $this->db->get();

			return $result = $query->result_array();			
		}
	
  		public function insert_nilai_manfaat_produk($data){
		    $this->db->insert_batch('nilai_manfaat_produk', $data);
		}

	}

?>