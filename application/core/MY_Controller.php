<?php
	class MY_Controller extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			date_default_timezone_set('Asia/Jakarta');

			if(!$this->session->has_userdata('is_login'))
			{
				redirect('auth/login', 'refresh');
			} 
		}
	}

?>

    