<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuModel extends CI_Model {

	public function getAccessMenu($roleId)
	{
		$this->db->select('menu.*, access.*');
		$this->db->join('access_menu access', 'access.menu_id = menu.menu_id', 'left');
		$this->db->where('access.role_id', $roleId);
		$this->db->order_by('access.menu_id', 'asc');

		return $this->db->get('menus menu');
	}

	public function getDataMenu()
	{
		$this->db->select('*');
		$this->db->order_by('menu_id', 'asc');

		return $this->db->get('menus');
	}

	public function getDataSubMenu()
	{
		$this->db->select('sub.*, menu.menu_name');
		$this->db->join('menus menu', 'menu.menu_id = sub.menu_id', 'left');
		$this->db->order_by('sub.id', 'asc');

		return $this->db->get('sub_menus sub');
	}

	public function getRole()
	{
		$this->db->order_by('role_id', 'asc');

		return $this->db->get('roles');
	}

	public function getDepart()
	{
		$this->db->order_by('depart_id', 'asc');

		return $this->db->get('departments');
	}

	public function getDataUsers()
	{
		$this->db->select('user.*, role.role_name, depart.depart_name');
		$this->db->join('roles role', 'role.role_id = user.role_id', 'left');
		$this->db->join('departments depart', 'depart.depart_id = user.department_id', 'left');
		$this->db->order_by('user.user_id', 'asc');

		return $this->db->get('users user');
	}

}

/* End of file MenuModel.php */
/* Location: ./application/models/MenuModel.php */