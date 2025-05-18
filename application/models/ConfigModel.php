<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfigModel extends CI_Model {

	public function getUser($userId)
	{
		$this->db->select('user.*,role.*,depart.*');
		$this->db->join('roles role', 'role.role_id = user.role_id', 'left');
		$this->db->join('departments depart', 'depart.depart_id = user.department_id', 'left');
		$this->db->where('user.user_id', $userId);

		return $this->db->get('users user');
	}

}

/* End of file ConfigModel.php */
/* Location: ./application/models/ConfigModel.php */