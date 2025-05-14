<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		$data = array(
			'user' => $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(), 
		);

		$this->load->view('main/header', $data, FALSE);
		$this->load->view('main/navbar', $data, FALSE);
		$this->load->view('content/admin_dashboard', $data, FALSE);
		$this->load->view('main/footer');
	}

	public function registration_user()
    {
    	$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]', [
    		'is_unique' => "This Email has been registered!"
    	]);
    	$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[10]|is_unique[users.username]', [
    		'is_unique' => "This username already taken, please use another username"
    	]);
    	$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[5]|max_length[12]|matches[password2]', [
    		'matches' => "Your password not match!",
    		'min_length' => "Your password is too short"
    	]);
    	$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[5]|max_length[12]|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => "Form User Registration", 
            );
            $this->load->view('admin/register_user', $data, FALSE);
        } else {
            echo "Sudah Login";
        }
    }
}

/* End of file AdminController.php */
/* Location: ./application/controllers/AdminController.php */