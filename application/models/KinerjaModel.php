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
		$this->db->select('k.*, d.document_name, d.document_path');
		$this->db->from('performance_records k');
		$this->db->join('document_records d', 'd.record_id = k.record_id', 'left');
		$this->db->where('k.record_id', $id);
		
		$query = $this->db->get();
		
		log_message('debug', 'SQL Query: '.$this->db->last_query());
		
		return $query->row_array();
	}

}

/* End of file KinerjaModel.php */
/* Location: ./application/models/KinerjaModel.php */