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
                'pw_text' => $this->input->post('password1'),
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

public function api_get_menu_row($id)
{
    // Pastikan header JSON
    header('Content-Type: application/json; charset=utf-8');

    // Ambil row dari database
    $rowMenu = $this->db
        ->get_where('menus', ['menu_id' => $id])
        ->row_array();

    // Tentukan success flag dan message
    $success = ! empty($rowMenu);
    $message = $success
        ? 'OK'
        : 'Menu dengan ID ' . $id . ' tidak ditemukan.';

    // Balikkan JSON response
    echo json_encode([
        'success' => $success,
        'data'    => $rowMenu,
        'message' => $message
    ]);
    exit;
}

public function api_get_role_row($id)
{
    // Pastikan header JSON
    header('Content-Type: application/json; charset=utf-8');

    // Ambil row dari database
    $rowMenu = $this->db
        ->get_where('roles', ['role_id' => $id])
        ->row_array();

    // Tentukan success flag dan message
    $success = ! empty($rowMenu);
    $message = $success
        ? 'OK'
        : 'Menu dengan ID ' . $id . ' tidak ditemukan.';

    // Balikkan JSON response
    echo json_encode([
        'success' => $success,
        'data'    => $rowMenu,
        'message' => $message
    ]);
    exit;
}

public function api_get_depart_row($id)
{
    // Pastikan header JSON
    header('Content-Type: application/json; charset=utf-8');

    // Ambil row dari database
    $rowMenu = $this->db
        ->get_where('departments', ['depart_id' => $id])
        ->row_array();

    // Tentukan success flag dan message
    $success = ! empty($rowMenu);
    $message = $success
        ? 'OK'
        : 'Menu dengan ID ' . $id . ' tidak ditemukan.';

    // Balikkan JSON response
    echo json_encode([
        'success' => $success,
        'data'    => $rowMenu,
        'message' => $message
    ]);
    exit;
}

public function api_get_sub_menu_row($id)
{
    // Pastikan header JSON
    header('Content-Type: application/json; charset=utf-8');

    // Ambil row dari database
    $rowMenu = $this->db
        ->get_where('sub_menus', ['id' => $id])
        ->row_array();

    // Tentukan success flag dan message
    $success = ! empty($rowMenu);
    $message = $success
        ? 'OK'
        : 'Menu dengan ID ' . $id . ' tidak ditemukan.';

    // Balikkan JSON response
    echo json_encode([
        'success' => $success,
        'data'    => $rowMenu,
        'message' => $message
    ]);
    exit;
}

public function api_get_menu_update($id)
{
    if ($this->input->method() !== 'post') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        return;
    }

    if (!ctype_digit($id)) {
        echo json_encode([
            'success' => false,
            'message' => 'ID not valid'
        ]);
        return;
    }

    $this->form_validation->set_rules('menu_name', 'Nama Menu', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'success' => false,
            'message' => validation_errors('', '')
        ]);
        return;
    } else {
        $data = [
            'menu_name' => $this->input->post('menu_name', true), 
        ];

        $updated = $this->menu->updateMenu($id, $data);

        if ($updated) {
            echo json_encode([
                'success' => true,
                'message' => 'Menu Updated'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Menu Update Failed'
            ]);
        }
    }
}

public function api_get_role_update($id)
{
    if ($this->input->method() !== 'post') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        return;
    }

    if (!ctype_digit($id)) {
        echo json_encode([
            'success' => false,
            'message' => 'ID not valid'
        ]);
        return;
    }

    $this->form_validation->set_rules('role_name', 'Nama Role', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'success' => false,
            'message' => validation_errors('', '')
        ]);
        return;
    } else {
        $data = [
            'role_name' => $this->input->post('role_name', true), 
        ];

        $updated = $this->menu->updateRole($id, $data);

        if ($updated) {
            echo json_encode([
                'success' => true,
                'message' => 'Menu Updated'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Menu Update Failed'
            ]);
        }
    }
}

public function api_get_depart_update($id)
{
    if ($this->input->method() !== 'post') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        return;
    }

    if (!ctype_digit($id)) {
        echo json_encode([
            'success' => false,
            'message' => 'ID not valid'
        ]);
        return;
    }

    $this->form_validation->set_rules('depart_name', 'Nama Bagian', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'success' => false,
            'message' => validation_errors('', '')
        ]);
        return;
    } else {
        $data = [
            'depart_name' => $this->input->post('depart_name', true), 
        ];

        $updated = $this->menu->updateDepart($id, $data);

        if ($updated) {
            echo json_encode([
                'success' => true,
                'message' => 'Menu Updated'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Menu Update Failed'
            ]);
        }
    }
}

public function api_get_submenu_update($id)
{
    if ($this->input->method() !== 'post') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        return;
    }

    if (!ctype_digit($id)) {
        echo json_encode([
            'success' => false,
            'message' => 'ID not valid'
        ]);
        return;
    }

    $this->form_validation->set_rules('menu_id', 'Nama Menu', 'required');
    $this->form_validation->set_rules('sub_title', 'Nama Sub Menu', 'required');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'success' => false,
            'message' => validation_errors('', '')
        ]);
        return;
    } else {
        $data = [
            'menu_id' => $this->input->post('menu_id', true),
            'sub_title' => $this->input->post('sub_title', true),
            'sub_url' => $this->input->post('sub_url', true),
            'sub_icon' => $this->input->post('sub_icon', true),
            'is_active' => $this->input->post('is_active', true), 
        ];

        $updated = $this->menu->updateSubMenu($id, $data);

        if ($updated) {
            echo json_encode([
                'success' => true,
                'message' => 'Menu Updated'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Menu Update Failed'
            ]);
        }
    }
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
    // if (!is_numeric($id)) {
    //     echo json_encode([
    //         'success' => false,
    //         'message' => 'ID tidak valid'
    //     ]);
    //     return;
    // }

    $rowUser = $this->user->getRowById($id)->row_array();

    echo json_encode([
        'success' => true,
        'data' => $rowUser
    ]);

    // $response = [
    //     'success' => false,
    //     'message' => 'Data tidak ditemukan',
    //     'data' => null,
    //     'document' => null
    // ];

    // $this->output
    // ->set_content_type('application/json')
    // ->set_output(json_encode($response));
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

public function api_update_users($user_id)
{
    header('Content-Type: application/json');
    
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($user_id) || $user_id != ($input['user_id'] ?? 0)) {
        throw new Exception('User ID tidak valid');
    }

    $data = [
        'user_nik'       => $input['user_nik'] ?? '',
        'user_fullname'  => $input['user_fullname'] ?? '',
        'user_email'     => $input['user_email'] ?? '',
        'username'       => $input['username'] ?? '',
        'user_gender'    => $input['user_gender'] ?? '',
        'role_id'        => $input['role_id'] ?? 0,
        'department_id'  => $input['department_id'] ?? 0,
        'user_is_active' => $input['user_is_active'] ?? 0
    ];

    if (!empty($input['change_password']) && $input['change_password'] == '1') {
        if ($input['password'] !== $input['password_confirmation']) {
            $response['message'] = 'Password tidak sama';
            echo json_encode($response);
            return;
        }
        $data['user_password'] = password_hash($input['password'], PASSWORD_DEFAULT);
    }

    $this->db->where('user_id', $user_id);
    if ($this->db->update('users', $data)) {
        $response['success'] = true;
        $response['message'] = 'Data berhasil diupdate';
    } else {
        $response['message'] = 'Gagal mengupdate data';
    }

    echo json_encode($response);
}

public function api_delete_users($user_id)
{
    header('Content-Type: application/json');
    
    try {
        // Validasi user_id
        if (empty($user_id)) {
            throw new Exception('ID User tidak valid');
        }

        // Cek apakah user ada
        $user = $this->user->get_user_by_id($user_id);
        if (!$user) {
            throw new Exception('User tidak ditemukan');
        }

        // Hapus user
        $delete = $this->user->delete_user($user_id);

        if (!$delete) {
            throw new Exception('Gagal menghapus user');
        }

        echo json_encode([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
        
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

public function api_delete_menus($menu_id)
{
    header('Content-Type: application/json');

    try {
        if (empty($menu_id)) {
            throw new Exception('ID Menu tidak valid');
        }

        $menu = $this->menu->getMenuById($menu_id);
        if (!$menu) {
            throw new Exception('Menu tidak ditemukan');
        }

        $deleted = $this->menu->deleteMenu($menu_id);

        if (!$deleted) {
            throw new Exception('Gagal Hapus Menu');
        }

        echo json_encode([
            'success' => true,
            'message' => 'Menu berhasil dihapus'
        ]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

public function api_delete_roles($role_id)
{
    header('Content-Type: application/json');

    try {
        if (empty($role_id)) {
            throw new Exception('ID Menu tidak valid');
        }

        $roles = $this->menu->getRoleById($role_id);
        if (!$roles) {
            throw new Exception('Role tidak ditemukan');
        }

        $deleted = $this->menu->deleteRole($role_id);

        if (!$deleted) {
            throw new Exception('Gagal Hapus Menu');
        }

        echo json_encode([
            'success' => true,
            'message' => 'Menu berhasil dihapus'
        ]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

public function api_delete_depart($depart_id)
{
    header('Content-Type: application/json');

    try {
        if (empty($depart_id)) {
            throw new Exception('ID Menu tidak valid');
        }

        $departs = $this->menu->getDepartById($depart_id);
        if (!$departs) {
            throw new Exception('Bagian tidak ditemukan');
        }

        $deleted = $this->menu->deleteDepart($depart_id);

        if (!$deleted) {
            throw new Exception('Gagal Hapus Menu');
        }

        echo json_encode([
            'success' => true,
            'message' => 'Menu berhasil dihapus'
        ]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

public function api_delete_submenus($id)
{
    header('Content-Type: application/json');

    try {
        if (empty($id)) {
            throw new Exception('ID Menu tidak valid');
        }

        $submenu = $this->menu->getSubMenuById($id);
        if (!$submenu) {
            throw new Exception('Menu tidak ditemukan');
        }

        $deleted = $this->menu->deleteSubMenu($id);

        if (!$deleted) {
            throw new Exception('Gagal Hapus Menu');
        }

        echo json_encode([
            'success' => true,
            'message' => 'Menu berhasil dihapus'
        ]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

public function checkAccess()
{
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('roleId');

    $data = [
        'role_id' => $role_id,
        'menu_id' => $menu_id 
    ];

    $exists = $this->db
    ->where($data)
    ->count_all_results('access_menu') > 0;

    if (! $exists) {
        $this->db->insert('access_menu', $data);
    } else {
        $this->db->delete('access_menu', $data);
    }

    return $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode([
        'success' => true,
        'message' => 'Access toggled successfully'
    ]));

}



}

/* End of file AdminController.php */
/* Location: ./application/controllers/AdminController.php */