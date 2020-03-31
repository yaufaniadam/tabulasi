<?php
	class Lembaga_model extends CI_Model{

		public function add_lembaga($data){
			$this->db->insert('lembaga', $data);
			return true;
		}
		
		//---------------------------------------------------
		// get all unit records
		public function get_all_lembaga(){
			$wh =array();
			$query = $this->db->get('lembaga');
		
			return $result = $query->result_array();
		}

		
		//---------------------------------------------------
		// Count total unit for pagination
		public function count_all_unit(){
			return $this->db->count_all('lembaga');
		}

		

		//---------------------------------------------------
		// get all units for server-side datatable with advanced search
		public function get_all_unit_by_advance_search(){
			$wh =array();
			$SQL ='SELECT * FROM ci_unit_kerja';
			if($this->session->unitdata('unit_search_type')!='')
			$wh[]="is_active = '".$this->session->unitdata('unit_search_type')."'";
			if($this->session->unitdata('unit_search_from')!='')
			$wh[]=" `created_at` >= '".date('Y-m-d', strtotime($this->session->unitdata('unit_search_from')))."'";
			if($this->session->unitdata('unit_search_to')!='')
			$wh[]=" `created_at` <= '".date('Y-m-d', strtotime($this->session->unitdata('unit_search_to')))."'";

			$wh[] = " is_admin = 0";
			if(count($wh)>0)
			{
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE);
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}
		}

		//---------------------------------------------------
		// Get unit detial by ID
		public function get_unit_by_id($id){
			$query = $this->db->get_where('ci_unit_kerja', array('id' => $id));
			return $result = $query->row_array();
		}

		
		//---------------------------------------------------
		// Edit unit Record
		public function edit_unit($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_unit_kerja', $data);
			return true;
		}

		//---------------------------------------------------
		// Get unit detial by userID
		public function get_unit_by_userid($user_id){
			//$this->db->select('prodi');
			$query = $this->db->get_where('ci_users', array('id' => $user_id));	
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// get all unit records
		public function get_all_kantor(){
			$query = $this->db->get('ci_kantor');		
			return $result = $query->result_array();
		}


		public function add_kantor($data){
			$this->db->insert('ci_kantor', $data);
			return true;
		}

		// Edit unit Record
		public function edit_kantor($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_kantor', $data);
			return true;
		}

		// Get unit detial by ID
		public function get_kantor_by_id($id){
			//$this->db->select('prodi');
			$query = $this->db->get_where('ci_kantor', array('id' => $id));	
			return $result = $query->row_array();
		}

		public function add_hrd($data) {
			$this->db->insert('ci_hrd', $data);
			return true;
		}
		public function add_teller($data) {
			$this->db->insert('ci_teller', $data);
			return true;
		}
		public function add_akunting($data) {
			$this->db->insert('ci_akunting', $data);
			return true;
		}
		public function add_cs($data) {
			$this->db->insert('ci_cs', $data);
			return true;
		}
		public function add_pembiayaan($data) {
			$this->db->insert('ci_pembiayaan', $data);
			return true;
		}
		public function add_surveyor($data) {
			$this->db->insert('ci_surveyor', $data);
			return true;
		}
		public function add_marketing($data) {
			$this->db->insert('ci_marketing', $data);
			return true;
		}

		public function add_auditor($data) {
			$this->db->insert('ci_auditor', $data);
			return true;
		}
		public function add_digimark($data) {
			$this->db->insert('ci_digimark', $data);
			return true;
		}
		
		

		public function get_unit_by_kantor($kantor,$unit, $sub_maqasid) {

			$unit_kerja = get_kode_unit_kerja_by_id($unit);
				
			$query = $this->db->get_where('ci_'.$unit_kerja, array('id_kantor' => $kantor,'sub_maqasid'=>$sub_maqasid));	
			return $result = $query->result_array();
			
		}

	}

?>