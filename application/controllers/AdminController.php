<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('MenuModel', 'menu');
        $this->load->model('UserModel', 'user');

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

  public function listUser()
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
        'title' => "List Data User",
        'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
        'role' => $this->menu->getRole()->result_array(),
        'department' => $this->menu->getDepart()->result_array(),
    );
    $this->load->view('main/header', $data, FALSE);
    $this->load->view('main/navbar', $data, FALSE);
    $this->load->view('content/list-user', $data, FALSE);
    $this->load->view('main/footer');
} else {
    if ($this->input->post()) {
        $data = [
            'user_nik' => $this->input->post('user_nik'),
            'user_fullname' => $this->input->post('user_fullname'),
            'user_email' => $this->input->post('user_email'),
            'username' => $this->input->post('username'),
            'user_password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role_id' => $this->input->post('role_id'),
            'department_id' => $this->input->post('department_id'),
            'user_is_active' => 1,
            'user_gender' => $this->input->post('user_gender'),
            'is_supervisor' => 0,
            'created_date' => time(),
        ];

        $this->db->insert('users', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New User added!</div>');

        redirect('admin/listUser','refresh');
        
    }
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

public function roleAccess($id)
{
    $data = array(
       'title' => "List Data Role",
       'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
       'role' => $this->db->get_where('roles', ['role_id' => $id])->row_array(),
       'menu' => $this->db->get('menus')->result_array(),
    );

    $this->load->view('main/header', $data, FALSE);
    $this->load->view('main/navbar', $data, FALSE);
    $this->load->view('content/list-role-access', $data, FALSE);
    $this->load->view('main/footer');
}

public function listDepart()
{
    $this->form_validation->set_rules('depart_name', 'Nama Department', 'required');

    if ($this->form_validation->run() == FALSE) {
        $data = array(
            'title' => "List Data Department",
            'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
        );

        $this->load->view('main/header', $data, FALSE);
        $this->load->view('main/navbar', $data, FALSE);
        $this->load->view('content/list-depart', $data, FALSE);
        $this->load->view('main/footer');
    } else {
        $this->db->insert('departments', ['depart_name' => $this->input->post('depart_name')]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New department added!</div>');

        redirect('admin/listDepart','refresh');
    }
}

public function api_get_menu()
{
   $menus = $this->menu->getDataMenu()->result_array();

   echo json_encode([
      'data' => $menus
  ]);
}

public function api_get_users()
{
    $users = $this->menu->getDataUsers()->result_array();

    echo json_encode([
        'data' => $users
    ]);
}

public function api_get_row_users($id)
{
    if (!is_numeric($id)) {
        echo json_encode([
            'success' => false,
            'message' => 'ID tidak valid'
        ]);
        return;
    }

    $rowUser = $this->user->getRowById($id)->row_array();

    $response = [
        'success' => false,
        'message' => 'Data tidak ditemukan',
        'data' => null,
        'document' => null
    ];

    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($response));
}

public function api_get_role()
{
    $roles = $this->menu->getRole()->result_array();

    echo json_encode([
        'data' => $roles
    ]);
}

public function api_get_sub_menu()
{
   $submenu = $this->menu->getDataSubMenu()->result_array();

   echo json_encode([
      'data' => $submenu
  ]);
}

public function api_get_department()
{
    $department = $this->menu->getDepart()->result_array();

    echo json_encode([
        'data' => $department
    ]);
}
}

/* End of file AdminController.php */
/* Location: ./application/controllers/AdminController.php */