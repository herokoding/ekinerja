<?php

// API Routing
$route['admin/api/getMenu']['get'] = 'AdminController/api_get_menu';
$route['admin/api/getRole']['get'] = 'AdminController/api_get_role';
$route['admin/api/getSubMenu']['get'] = 'AdminController/api_get_sub_menu';
$route['admin/api/getDepart']['get'] = 'AdminController/api_get_department';
$route['admin/api/getUser']['get'] = 'AdminController/api_get_users';
$route['admin/api/editUser/(:num)']['get'] = 'AdminController/api_get_row_users/$1';
$route['kinerja/api/getListKinerja']['get'] = 'KinerjaController/api_get_lists';
$route['kinerja/api/editKinerja/(:num)']['get'] = 'KinerjaController/api_get_row_kinerja/$1';
$route['kinerja/api/updateKinerja/(:num)']['post'] = 'KinerjaController/api_update_kinerja/$1';
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
$route['admin/roleAccess/(:num)'] = 'AdminController/roleAccess/$1';

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