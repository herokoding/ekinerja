<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfigController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('ConfigModel', 'config_model');
		$this->load->model('MenuModel', 'menu');

		if (!$this->session->userdata('role_id')) {
            redirect('auth','refresh');
        }

        $accessMenu = $this->db->get_where('access_menu', ['role_id' => $this->session->userdata('role_id')]);

        if ($accessMenu->num_rows() < 1) {
            redirect('auth/blocked','refresh');
        }
	}

	public function index()
	{
		
	}

	public function showProfile()
	{
		$data = array(
			'title' => "Profile Page",
			'userRow' => $this->config_model->getUser($this->session->userdata('user_id'))->row_array(),
			'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
			'roles' => $this->db->get('roles')->result_array(),
			'departments' => $this->db->get('departments')->result_array(),
		);

		$this->load->view('main/header', $data, FALSE);
		$this->load->view('main/navbar', $data, FALSE);
		$this->load->view('content/profile', $data, FALSE);
		$this->load->view('main/footer');
	}

	public function updateProfile()
	{
		$this->config_model->updateProfile();

		redirect('user/show-profile', 'refresh');
	}

	public function updatePassword() 
	{
		$this->config_model->updatePassword();

		redirect('user/show-profile', 'refresh');
	}

}

/* End of file ConfigController.php */
/* Location: ./application/controllers/ConfigController.php */