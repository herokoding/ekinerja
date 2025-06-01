<?php  

function is_logged_in()
{
	$CI =& get_instance();

    // 1. Cek session: apakah user sudah login?
	if (!$CI->session->userdata('user_id')) {
		redirect('AuthController','refresh');
		return;
	}

    // 2. Ambil role_id user
	$role_id = $CI->session->userdata('role_id');

    /**
     * 3. Ambil keseluruhan URI string (setelah base_url),
     *    misalnya “admin/dashboard” jika route di‐set:
     *      $route['admin/dashboard'] = 'AdminController/index';
     *    
     *    Dengan uri_string(), kolom menu_name di tabel `menus`
     *    harus persis “admin/dashboard”. 
     *    
     *    Jika Anda juga punya menu lain tanpa custom route, 
     *    misal “profile/edit”, cukup simpan sesuai URI-nya di DB.
     *
     *    Jika Anda ingin fallback ke controller saja (misalnya 
     *    ada URL yang langsung ke ‘admin’ tanpa segmen lebih lanjut),
     *    bisa dicek: jika uri_string kosong atau tidak terdaftar, 
     *    gunakan fetch_class().
     */
    $uri = trim($CI->uri->uri_string(), '/');

    if ($uri === '') {
        // Misalnya URL: example.com/ (tidak ada segmen),
        // atau Anda ingin treat “AdminController/index” sebagai “admin”.
    	$menu = strtolower($CI->router->fetch_class());
    } else {
        // Gunakan seluruh path (tanpa slash di awal/akhir)
    	$menu = strtolower($uri);
    }

    // 4. Query ke tabel `menus` berdasarkan kolom menu_name
    $queryMenu = $CI->db->get_where('menus', ['menu_name' => $menu])->row_array();

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
