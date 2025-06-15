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

	public function updateMenu($id, array $data)
	{
		$this->db->where('menu_id', $id)
				->update('menus', $data);

		return ($this->db->affected_rows()> 0);
	}

	public function updateRole($id, array $data)
	{
		$this->db->where('role_id', $id)
				->update('roles', $data);

		return ($this->db->affected_rows()> 0);
	}

	public function updateDepart($id, array $data)
	{
		$this->db->where('depart_id', $id)
				->update('departments', $data);

		return ($this->db->affected_rows()> 0);
	}

	public function updateSubMenu($id, array $data)
	{
		$this->db->where('id', $id)
				->update('sub_menus', $data);

		return ($this->db->affected_rows() > 0);
	}

	public function getMenuById($menu_id)
	{
		return $this->db->where('menu_id', $menu_id)
		->get('menus')
		->row();
	}

	public function getRoleById($role_id)
	{
		return $this->db->where('role_id', $role_id)
		->get('roles')
		->row();
	}

	public function getDepartById($depart_id)
	{
		return $this->db->where('depart_id', $depart_id)
		->get('departments')
		->row();
	}

	public function getSubMenuById($id)
	{
		return $this->db->where('id', $id)
		->get('sub_menus')
		->row();
	}

	public function deleteMenu($menu_id)
	{
		$this->db->where('menu_id', $menu_id);
		$this->db->delete('menus');
		return $this->db->affected_rows() > 0;
	}

	public function deleteRole($role_id)
	{
		$this->db->where('role_id', $role_id);
		$this->db->delete('roles');
		return $this->db->affected_rows() > 0;
	}

	public function deleteDepart($depart_id)
	{
		$this->db->where('depart_id', $depart_id);
		$this->db->delete('departments');
		return $this->db->affected_rows() > 0;
	}

	public function deleteSubMenu($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('sub_menus');
		return $this->db->affected_rows() > 0;
	}

}

/* End of file MenuModel.php */
/* Location: ./application/models/MenuModel.php */