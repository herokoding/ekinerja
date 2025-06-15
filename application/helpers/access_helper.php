<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('check_access'))
{
    function check_access($role_id, $menu_id)
    {
        $ci =& get_instance();

        $ci->db->where('role_id', $role_id);
        $ci->db->where('menu_id', $menu_id);
        $result = $ci->db->get('access_menu');

        if ($result->num_rows() > 0) {
            return "checked='checked'";
        }
        return '';
    }
}
