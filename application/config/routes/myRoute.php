<?php

// API Routing
$route['api/getMenu'] = 'AdminController/api_get_menu';

// Admin Routes
$route['admin/dashboard'] = 'AdminController/index';
$route['admin/listMenu'] = 'AdminController/listMenu';

// Auth Routes
$route['auth'] = 'AuthController/index';
$route['auth/logout'] = 'AuthController/logout';

// Config Routes
$route['user/show-profile'] = 'ConfigController/showProfile';