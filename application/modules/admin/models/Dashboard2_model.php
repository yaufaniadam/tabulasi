<?php
class Dashboard2_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		// data dari bpkh_site
		$bpkh_site = $this->load->database('bpkh_site', TRUE);
	}

	public function get_participant_sah($survey_id)
	{
		return $this->db->query("SELECT * from bpk_surveys_entity_participants where survey_id = '$survey_id' and status = 2 ORDER BY id DESC");
	}

	public function get_semua_participant($survey_id)
	{
		return $this->db->query("SELECT * from bpk_surveys_entity_participants where survey_id = '$survey_id' ORDER BY id DESC");
	}
}
