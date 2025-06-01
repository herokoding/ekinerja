<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

	public function getRowById($id)
	{
		$this->db->select('u.*, r.*, d.*');
		$this->db->join('roles r', 'r.role_id = u.role_id', 'left');
		$this->db->join('departments d', 'd.depart_id = u.department_id', 'left');
		$this->db->where('u.user_id', $id);

		return $this->db->get('users u');
	}

}

/* End of file UserModel.php */
/* Location: ./application/models/UserModel.php */