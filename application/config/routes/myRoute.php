<?php

// API Routing
$route['admin/api/getMenu']['get'] = 'AdminController/api_get_menu';
$route['admin/api/getRole']['get'] = 'AdminController/api_get_role';
$route['admin/api/getSubMenu']['get'] = 'AdminController/api_get_sub_menu';

// Admin Routes
$route['admin/dashboard'] = 'AdminController/index';
$route['admin/listMenu'] = 'AdminController/listMenu';
$route['admin/listSubMenu'] = 'AdminController/listSubMenu';
$route['admin/listRole'] = 'AdminController/listRole';
$route['admin/addMenu']['post'] = 'AdminController/listMenu';
$route['admin/addSubMenu']['post'] = 'AdminController/listSubMenu';

// Auth Routes
$route['auth'] = 'AuthController/index';
$route['auth/logout'] = 'AuthController/logout';

// Config Routes
$route['user/show-profile'] = 'ConfigController/showProfile';