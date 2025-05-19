<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('MenuModel', 'menu');
	}

	public function index()
	{
		$data = array(
			'title' => "Ekinerja",
			'user' => $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(),
			'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
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

    public function listMenu()
    {
    	$this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');

    	if ($this->form_validation->run() == FALSE) {
    		$data = array(
    			'title' => "List Data Menu",
    			'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
    		);

    		$this->load->view('main/header', $data, FALSE);
    		$this->load->view('main/navbar', $data, FALSE);
    		$this->load->view('content/list-menu', $data, FALSE);
    		$this->load->view('main/footer');
    	} else {
    		$this->db->insert('menus', ['menu_name' => $this->input->post('menu_name')]);
    		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');

    		redirect('admin/listMenu','refresh');
    	}
    }

    public function listSubMenu()
    {
    	$this->form_validation->set_rules('sub_title', 'Nama Sub Menu', 'required');
    	$this->form_validation->set_rules('sub_url', 'Nama Sub URL', 'required');
    	
    	if ($this->form_validation->run() == FALSE) {
    		$data = array(
    			'title' => "List Sub Menu",
    			'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
    			'menu' => $this->menu->getDataMenu()->result_array(),
    		);

    		$this->load->view('main/header', $data, FALSE);
    		$this->load->view('main/navbar', $data, FALSE);
    		$this->load->view('content/list-sub-menu', $data, FALSE);
    		$this->load->view('main/footer');
    	} else {
    		if ($this->input->post()) {
    			$post = array(
    				'sub_title' => $this->input->post('sub_title'), 
    				'menu_id' => $this->input->post('menu_id'), 
    				'sub_url' => $this->input->post('sub_url'), 
    				'sub_icon' => $this->input->post('sub_icon'), 
    				'is_active' => $this->input->post('is_active'), 
    			);

    			$this->db->insert('sub_menus', $post);
    			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New sub menu added!</div>');

    			redirect('admin/listSubMenu','refresh');
    		}
    	}
    }

    public function listRole()
    {
    	$this->form_validation->set_rules('role_name', 'Nama Role', 'required');

    	if ($this->form_validation->run() == FALSE) {
    		$data = array(
    			'title' => "List Data Role",
    			'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
    		);

    		$this->load->view('main/header', $data, FALSE);
    		$this->load->view('main/navbar', $data, FALSE);
    		$this->load->view('content/list-role', $data, FALSE);
    		$this->load->view('main/footer');
    	} else {
    		$this->db->insert('roles', ['role_name' => $this->input->post('role_name')]);
    		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New role added!</div>');

    		redirect('admin/listRole','refresh');
    	}

    }

    public function api_get_menu()
    {
    	$menus = $this->menu->getDataMenu()->result_array();

    	echo json_encode([
    		'data' => $menus
    	]);
    }

    public function api_get_sub_menu()
    {
    	$submenu = $this->menu->getDataSubMenu()->result_array();

    	echo json_encode([
    		'data' => $submenu
    	]);
    }
}

/* End of file AdminController.php */
/* Location: ./application/controllers/AdminController.php */