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

	public function FunctionName($value='')
	{
		// code...
	}

}

/* End of file MenuModel.php */
/* Location: ./application/models/MenuModel.php */