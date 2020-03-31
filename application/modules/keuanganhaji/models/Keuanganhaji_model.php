<?php
	class Keuanganhaji_model extends CI_Model{	

		public function get_tahun_porsi_penempatan_bps_bpih(){
			
			$this->db->select('tahun');
			$this->db->from('porsi_penempatan_bps_bpih');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_porsi_penempatan_bps_bpih(){
			
			$this->db->select('*');
			$this->db->from('porsi_penempatan_bps_bpih');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_porsi_penempatan_bps_bpih($tahun){
			
			$this->db->select('*');
			$this->db->from('porsi_penempatan_bps_bpih');			
			$this->db->where('tahun', $tahun);
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get();

			return $result = $query->result_array();			
		}
	
  		public function insert_porsi_penempatan_bps_bpih($data){
		    $this->db->insert_batch('porsi_penempatan_bps_bpih', $data);
		}
		//SEBARAN DANA HAJI
		public function get_tahun_sebaran_dana_haji(){
			
			$this->db->select('tahun');
			$this->db->from('sebaran_dana_haji2');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_sebaran_dana_haji(){
			
			$this->db->select('*');
			$this->db->from('sebaran_dana_haji2');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_sebaran_dana_haji($tahun){
			
			$this->db->select('*');
			$this->db->from('sebaran_dana_haji2');			
			$this->db->where('tahun', $tahun);
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get();

			return $result = $query->result_array();			
		}
	
  		public function insert_sebaran_dana_haji($data){
		    $this->db->insert_batch('sebaran_dana_haji2', $data);
		}	

		//SSDHI RUPIAH
		public function get_tahun_sdhi_rupiah(){
			
			$this->db->select('tahun');
			$this->db->from('sdhi_rupiah');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}		

		public function get_sdhi_rupiah($tahun){
			
			$query = $this->db->query('SELECT *
				FROM sdhi_rupiah
				WHERE tahun="'.$tahun.'"
				ORDER BY (instrumen = "TOTAL") ASC;');

			return $result = $query->result_array();				
		}
	
  		public function insert_sdhi_rupiah($data){
		    $this->db->insert_batch('sdhi_rupiah', $data);
		}

		//Sbssn RUPIAH
		public function get_tahun_sbssn_rupiah(){
			
			$this->db->select('tahun');
			$this->db->from('sbssn_rupiah');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}		

		public function get_sbssn_rupiah($tahun){
			
			$query = $this->db->query('SELECT *
				FROM sbssn_rupiah
				WHERE tahun="'.$tahun.'"
				ORDER BY (instrumen = "TOTAL") ASC;');

			return $result = $query->result_array();			
		}
	
  		public function insert_sbssn_rupiah($data){
		    $this->db->insert_batch('sbssn_rupiah', $data);
		}

		//Sbssn USD
		public function get_tahun_sbssn_usd(){
			
			$this->db->select('tahun');
			$this->db->from('sbssn_usd');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}		

		public function get_sbssn_usd($tahun){
			
			$query = $this->db->query('SELECT *
				FROM sbssn_usd
				WHERE tahun="'.$tahun.'"
				ORDER BY (instrumen = "TOTAL") ASC;');

			return $result = $query->result_array();				
		}
	
  		public function insert_sbssn_usd($data){
		    $this->db->insert_batch('sbssn_usd', $data);
		}

		//Sukuk Korporasi
		public function get_tahun_sukuk_korporasi(){
			
			$this->db->select('tahun');
			$this->db->from('sukuk_korporasi');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}		

		public function get_sukuk_korporasi($tahun){
			
			$query = $this->db->query('SELECT *
				FROM sukuk_korporasi
				WHERE tahun="'.$tahun.'"
				ORDER BY (instrumen = "TOTAL") ASC;');

			return $result = $query->result_array();			
		}
	
  		public function insert_sukuk_korporasi($data){
		    $this->db->insert_batch('sukuk_korporasi', $data);
		}	

		//REKSADANA TERPROTEKSI SARIAH
		public function get_tahun_reksadana_terproteksi_syariah(){
			
			$this->db->select('tahun');
			$this->db->from('reksadana_terproteksi_syariah');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_reksadana_terproteksi_syariah(){
			
			$this->db->select('*');
			$this->db->from('reksadana_terproteksi_syariah');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_reksadana_terproteksi_syariah($tahun){
			
			$query = $this->db->query('SELECT *
				FROM reksadana_terproteksi_syariah
				WHERE tahun="'.$tahun.'"
				ORDER BY (instrumen = "TOTAL") ASC;');

			return $result = $query->result_array();		
		}
	
  		public function insert_reksadana_terproteksi_syariah($data){
		    $this->db->insert_batch('reksadana_terproteksi_syariah', $data);
		}	
	
		//REKSADANA TERPROTEKSI SARIAH
		public function get_tahun_reksadana_pasar_uang_syariah(){
			
			$this->db->select('tahun');
			$this->db->from('reksadana_pasar_uang_syariah');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_reksadana_pasar_uang_syariah(){
			
			$this->db->select('*');
			$this->db->from('reksadana_pasar_uang_syariah');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_reksadana_pasar_uang_syariah($tahun){


			$query = $this->db->query('SELECT *
				FROM reksadana_pasar_uang_syariah
				WHERE tahun="'.$tahun.'"
				ORDER BY (instrumen = "TOTAL") ASC;');

			return $result = $query->result_array();	
		
		}
	
  		public function insert_reksadana_pasar_uang_syariah($data){
		    $this->db->insert_batch('reksadana_pasar_uang_syariah', $data);
		}		


		//PENYERtaan SAHAM
		public function get_tahun_penyertaan_saham(){
			
			$this->db->select('tahun');
			$this->db->from('penyertaan_saham');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_penyertaan_saham(){
			
			$this->db->select('*');
			$this->db->from('penyertaan_saham');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_penyertaan_saham($tahun){
			
			$query = $this->db->query('SELECT *
				FROM penyertaan_saham
				WHERE tahun="'.$tahun.'"
				ORDER BY (bps_bpih = "TOTAL") ASC;');

			return $result = $query->result_array();			
		}
	
  		public function insert_penyertaan_saham($data){
		    $this->db->insert_batch('penyertaan_saham', $data);
		}

		//REKSADANA TERPROTEKSI SARIAH
		public function get_tahun_investasi_langsung(){
			
			$this->db->select('tahun');
			$this->db->from('investasi_langsung');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_investasi_langsung(){
			
			$this->db->select('*');
			$this->db->from('investasi_langsung');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_investasi_langsung($tahun){
			
			$query = $this->db->query('SELECT *
				FROM investasi_langsung
				WHERE tahun="'.$tahun.'"
				ORDER BY id ASC;');

			return $result = $query->result_array();				
		}
	
  		public function insert_investasi_langsung($data){
		    $this->db->insert_batch('investasi_langsung', $data);
		}

		//REKSADANA TERPROTEKSI SARIAH
		public function get_tahun_investasi_lainnya(){
			
			$this->db->select('tahun');
			$this->db->from('investasi_lainnya');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_investasi_lainnya(){
			
			$this->db->select('*');
			$this->db->from('investasi_lainnya');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_investasi_lainnya($tahun){
			
			$query = $this->db->query('SELECT *
				FROM investasi_lainnya
				WHERE tahun="'.$tahun.'"
				ORDER BY id ASC;');

			return $result = $query->result_array();		
		}
	
  		public function insert_investasi_lainnya($data){
		    $this->db->insert_batch('investasi_lainnya', $data);
		}

		//EMAS
		public function get_tahun_emas(){
			
			$this->db->select('tahun');
			$this->db->from('emas');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_emas(){
			
			$this->db->select('*');
			$this->db->from('emas');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_emas($tahun){
			
			$query = $this->db->query('SELECT *
				FROM emas
				WHERE tahun="'.$tahun.'"
				ORDER BY (bps_bpih = "TOTAL") ASC;');

			return $result = $query->result_array();			
		}
	
  		public function insert_emas($data){
		    $this->db->insert_batch('emas', $data);
		}

		//akumulasi_kontribusi_bpsbpih
		public function get_tahun_akumulasi_kontribusi_bpsbpih(){
			
			$this->db->select('tahun');
			$this->db->from('akumulasi_kontribusi_bpsbpih');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_akumulasi_kontribusi_bpsbpih(){
			
			$this->db->select('*');
			$this->db->from('akumulasi_kontribusi_bpsbpih');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_akumulasi_kontribusi_bpsbpih($tahun){
			
			$query = $this->db->query('SELECT *
				FROM akumulasi_kontribusi_bpsbpih
				WHERE tahun="'.$tahun.'"
				ORDER BY (bps_bpih = "TOTAL") ASC;');

			return $result = $query->result_array();		
		}
	
  		public function insert_akumulasi_kontribusi_bpsbpih($data){
		    $this->db->insert_batch('akumulasi_kontribusi_bpsbpih', $data);
		}

		//posisi_penempatan_produk
		public function get_tahun_posisi_penempatan_produk(){
			
			$this->db->select('tahun');
			$this->db->from('posisi_penempatan_produk');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}		

		public function get_posisi_penempatan_produk($tahun){			
			
			$this->db->select('*');
			$this->db->from('posisi_penempatan_produk');			
			$this->db->where('tahun', $tahun);
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get();

			return $result = $query->result_array();				
		}
	
  		public function insert_posisi_penempatan_produk($data){
		    $this->db->insert_batch('posisi_penempatan_produk', $data);
		}

		//PENEMPATAN DANA HAJI
		public function get_tahun_penempatan_dana_haji(){
			
			$this->db->select('tahun');
			$this->db->from('penempatan_dana_haji');			
			
			$this->db->order_by('tahun', 'ASC');
			$this->db->group_by('tahun');

			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_bps_bpih_penempatan_dana_haji(){
			
			$this->db->select('*');
			$this->db->from('penempatan_dana_haji');			
			$this->db->group_by('bps_bpih');
			$query = $this->db->get();

			return $result = $query->result_array();
			
		}

		public function get_penempatan_dana_haji($tahun){
			
			$this->db->select('*');
			$this->db->from('penempatan_dana_haji');			
			$this->db->where('tahun', $tahun);
		//	$this->db->order_by('id', 'ASC');
			$query = $this->db->get();

			return $result = $query->result_array();			
		}
	
  		public function insert_penempatan_dana_haji($data){
		    $this->db->insert_batch('penempatan_dana_haji', $data);
		}	


	}

?>