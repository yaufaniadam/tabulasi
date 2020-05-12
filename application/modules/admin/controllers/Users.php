<?php defined('BASEPATH') OR exit('No direct script access allowed');
	class Users extends Admin_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('admin/user_model', 'user_model');
			$this->load->model('admin/profile_model', 'profile_model');
			$this->load->library('datatable'); // loaded my custom serverside datatable library
		}

		public function index(){
			$data['view'] = 'admin/users/user_list';
			$this->load->view('layout', $data);
		}
		
		public function datatable_json(){				   					   
			$records = $this->user_model->get_all_users();
	        $data = array();
	        foreach ($records['data']  as $row) 
			{  
				$status = ($row['is_active'] == 0)? 'Deactive': 'Active'.'<span>';
				$disabled = ($row['is_admin'] == 1)? 'disabled': ''.'<span>';
				$data[]= array(
					$row['username'],
					$row['firstname'],
					$row['email'],
								
					
					'<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/users/edit/'.$row['id']).'"> <i class="fas fa-user-edit"></i></a>
					 <a title="View" class="view btn btn-sm btn-info" href="'.base_url('admin/users/detail/'.$row['id']).'"> <i class="fa fa-eye"></i></a>' 
				);
	        }
			$records['data']=$data;
	        echo json_encode($records);						   
		}

		public function add(){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('username', 'Username', 'trim|required');
				$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
				$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');

				if ($this->input->post('password') =='') {
					$pass = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
				} else {
					$pass = $this->input->post('password_hidden');
				}
	
				if ($this->form_validation->run() == FALSE) {
					$data['view'] = 'admin/users/user_add';
					$this->load->view('layout', $data);
				}
				else{
					$data = array(
						'username' => $this->input->post('username'),
						'firstname' => $this->input->post('firstname'),
						'email' => $this->input->post('email'),
						'mobile_no' => $this->input->post('mobile_no'),
						'password' =>  $pass,
						'created_at' => date('Y-m-d : h:m:s'),
						'updated_at' => date('Y-m-d : h:m:s'),
						'is_verify' => 1,
						'is_active' => 1,
						'role' => 2,
					);
					$data = $this->security->xss_clean($data);
					$result = $this->user_model->add_user($data);
					if($result){
						$this->session->set_flashdata('msg', 'User has been added successfully!');
						redirect(base_url('admin/users'));
					}
				}
			}
			else{
				
				$data['view'] = 'admin/users/user_add';
				$this->load->view('layout', $data);
			}
			
		}

		public function edit($id = 0){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('firstname', 'Username', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
				$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');

				if ($this->input->post('password') !=='') {
					$pass = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
				} else {
					$pass = $this->input->post('password_hidden');
				}

				if ($this->form_validation->run() == FALSE) {
					$data['user'] = $this->user_model->get_user_by_id($id);
					$data['view'] = 'admin/users/user_edit';
					$this->load->view('layout', $data);
				}
				else{
					$data = array(
						'firstname' => $this->input->post('firstname'),
						'email' => $this->input->post('email'),
						'mobile_no' => $this->input->post('mobile_no'),
						'password' =>  $pass,
						'updated_at' => date('Y-m-d : h:m:s'),
						'is_active' => $this->input->post('status'),
						'modul' => implode(',',$this->input->post('modul')),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->user_model->edit_user($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'User has been updated successfully!');
						redirect(base_url('admin/users'));
					}
				}
			}
			else{
				$data['user'] = $this->user_model->get_user_by_id($id);		
				$data['modules'] = $this->user_model->get_modules();		
				$data['view'] = 'admin/users/user_edit';
				$this->load->view('layout', $data);
			}
		}

		public function detail($id = 0){
			$data['user'] = $this->user_model->get_user_by_id($id);
			
			$data['view'] = 'admin/users/detail';
			$this->load->view('layout', $data);
		}

		public function del($id = 0){
			$this->db->delete('ci_users', array('id' => $id));
			$this->session->set_flashdata('msg', 'Pengguna berhasil dihapus!');
			redirect(base_url('admin/users'));
		}

		

	}


?>