<?php

// API Routing
$route['admin/api/getMenu']['get'] = 'AdminController/api_get_menu';
$route['admin/api/getRole']['get'] = 'AdminController/api_get_role';
$route['admin/api/getSubMenu']['get'] = 'AdminController/api_get_sub_menu';
$route['admin/api/getDepart']['get'] = 'AdminController/api_get_department';
$route['admin/api/getUser']['get'] = 'AdminController/api_get_users';
$route['admin/api/editUser/(:num)']['get'] = 'AdminController/api_get_row_users/$1';
$route['admin/api/updateUser/(:num)']['post'] = 'AdminController/api_update_users/$1';
$route['admin/api/deleteUser/(:num)']['delete'] = 'AdminController/api_delete_users/$1';
$route['admin/api/editMenu/(:num)']['get'] = 'AdminController/api_get_menu_row/$1';
$route['admin/api/editRole/(:num)']['get'] = 'AdminController/api_get_role_row/$1';
$route['admin/api/editDepart/(:num)']['get'] = 'AdminController/api_get_depart_row/$1';
$route['admin/api/updateMenu/(:num)']['post'] = 'AdminController/api_get_menu_update/$1';
$route['admin/api/updateRole/(:num)']['post'] = 'AdminController/api_get_role_update/$1';
$route['admin/api/updateDepart/(:num)']['post'] = 'AdminController/api_get_depart_update/$1';
$route['admin/api/updateSubMenu/(:num)']['post'] = 'AdminController/api_get_submenu_update/$1';
$route['admin/api/deleteMenu/(:num)']['delete'] = 'AdminController/api_delete_menus/$1';
$route['admin/api/deleteRole/(:num)']['delete'] = 'AdminController/api_delete_roles/$1';
$route['admin/api/deleteDepart/(:num)']['delete'] = 'AdminController/api_delete_depart/$1';
$route['admin/api/deleteSubMenu/(:num)']['delete'] = 'AdminController/api_delete_submenus/$1';
$route['admin/api/editSubMenu/(:num)']['get'] = 'AdminController/api_get_sub_menu_row/$1';
$route['admin/api/checkAccess'] = 'AdminController/checkAccess';

$route['kinerja/api/getListKinerja']['get'] = 'KinerjaController/api_get_lists';
$route['kinerja/api/editKinerja/(:num)']['get'] = 'KinerjaController/api_get_row_kinerja/$1';
$route['kinerja/api/updateKinerja/(:num)']['post'] = 'KinerjaController/api_update_kinerja/$1';
$route['kinerja/api/deleteKinerja/(:num)']['delete'] = 'KinerjaController/api_delete_kinerja/$1';

$route['approval/api/getList'] = 'ApprovalController/api_get_lists';

// Admin Routes
$route['admin/dashboard'] = 'AdminController/index';
$route['admin/listMenu'] = 'AdminController/listMenu';
$route['admin/listSubMenu'] = 'AdminController/listSubMenu';
$route['admin/listRole'] = 'AdminController/listRole';
$route['admin/listDepart'] = 'AdminController/listDepart';
$route['admin/listUser'] = 'AdminController/listUser';
$route['admin/addMenu']['post'] = 'AdminController/listMenu';
$route['admin/addSubMenu']['post'] = 'AdminController/listSubMenu';
$route['admin/addRole']['post'] = 'AdminController/listRole';
$route['admin/addUser']['post'] = 'AdminController/listUser';
$route['admin/roleAccess/(:num)']['get'] = 'AdminController/roleAccess/$1';

// Kinerja Routes
$route['kinerja/listKinerja'] = 'KinerjaController/index';
$route['kinerja/checkStatus'] = 'KinerjaController/checkStatus';
$route['kinerja/reportPrint'] = 'KinerjaController/reportPrint';
$route['kinerja/exportPdf'] = 'KinerjaController/exportPdf';

// Head Routes
$route['approval/index'] = 'ApprovalController/index';
$route['approval/updateStatus/(:num)/(:num)'] = 'ApprovalController/updateStatus/$1/$2';

// Auth Routes
$route['auth'] = 'AuthController/index';
$route['auth/logout'] = 'AuthController/logout';
$route['auth/blocked'] = 'AuthController/blocked';

// Config Routes
$route['user/show-profile'] = 'ConfigController/showProfile';
$route['user/update-profile'] = 'ConfigController/updateProfile';
$route['user/update-password'] = 'ConfigController/updatePassword';