<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('admin/profile_model', 'profile_model');
	}
	//-------------------------------------------------------------------------
	public function index(){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('mobile_no', 'Telepon', 'trim|required');
			$this->form_validation->set_rules('email', 'E-mail', 'trim|required');

			if ($this->input->post('password') !=='') {
					$pass = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
				} else {
					$pass = $this->input->post('password_hidden');
				}

			if ($this->form_validation->run() == FALSE) {
				$data['user'] = $this->profile_model->get_user_detail();
				$data['title'] = 'Admin Profile';
				$data['view'] = 'admin/profile/index';
				$this->load->view('layout', $data);

			} else {	
				
				$data = array(
					
					'firstname' => $this->input->post('firstname'),
					'email' => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'updated_at' => date('Y-m-d : h:m:s'),
					'password' =>  $pass,
				);

				
				$data = $this->security->xss_clean($data);
				$result = $this->profile_model->update_user($data);
				if($result){
					$this->session->set_flashdata('msg', 'Profil Anda berhasil diubah!');
					redirect(base_url('admin/profile'), 'refresh');
				} 
			}
		}
		else{
			$data['user'] = $this->profile_model->get_user_detail();
			$data['title'] = 'Admin Profile';
			$data['view'] = 'admin/profile/index';
			$this->load->view('layout', $data);
		}
	}

	

	

}

?>	