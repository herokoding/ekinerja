<?php  

function is_logged_in()
{
	$CI =& get_instance();

    // 1. Cek session: apakah user sudah login?
	if (!$CI->session->userdata('user_id')) {
		redirect('auth','refresh');
		return;
	} else {
        $role_id = $CI->session->userdata('role_id');
        
        $queryMenu = $CI->db->get_where('menus', ['menu_name' => $menu])->row_array();


    }

    // Jika tidak ditemukan entri menu, langsung blok akses
    if (!$queryMenu) {
    	redirect('auth/blocked','refresh');
    	return;
    }

    $menu_id = $queryMenu['menu_id'];

    // 5. Cek apakah role ini punya akses ke menu tersebut
    $userAccess = $CI->db->get_where('access_menu', [
    	'role_id' => $role_id, 
    	'menu_id' => $menu_id
    ]);

    if ($userAccess->num_rows() < 1) {
    	redirect('auth/blocked','refresh');
    }
}
