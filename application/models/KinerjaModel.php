<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KinerjaModel extends CI_Model {

	public function getLists()
	{
		$this->db->select('perform.*, doc.*');
		$this->db->join('document_records doc', 'doc.record_id = perform.record_id', 'left');
		$this->db->order_by('perform.record_id', 'asc');

		return $this->db->get('performance_records perform');
	}

	public function getRowById($id)
	{
		$this->db->select('perform.*, doc.*');
		$this->db->join('document_records doc', 'doc.record_id = perform.record_id', 'left');
		$this->db->where('perform.record_id', $id);

		return $this->db->get('performance_records perform');
	}

}

/* End of file KinerjaModel.php */
/* Location: ./application/models/KinerjaModel.php */