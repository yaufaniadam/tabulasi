<?php
class Dashboard_model extends CI_Model
{

	public function get_grafik($survey_id)
	{
		$grafik = $this->db->query('(SELECT DATE_FORMAT(start_date,"%e %M") as date, start_date, 
		count(DATE_FORMAT(start_date,"%e")) as total from bpk_surveys_entity_participants 
		where survey_id = ' . $survey_id . ' AND
		status = 2
		GROUP BY date )

		UNION ALL

		(SELECT DATE_FORMAT(start_date,"%e %M") as date, start_date,
		count(DATE_FORMAT(start_date,"%e")) as total from sitejumat_surveys_entity_participants 
		where survey_id = ' . $survey_id . ' AND
		status = 2
		GROUP BY date )
		
		ORDER BY start_date ASC
		');

		return $grafik;
	}
}
