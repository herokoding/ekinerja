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

	public function updateById($id, array $perfData, array $docData = null)
    {
        $this->db->trans_begin();

        // Update performance_records
        $this->db->where('record_id', $id)
                 ->update('performance_records', $perfData);

        // If document data provided, update or insert into document_records
        if ($docData !== null) {
            // Check if existing document record
            $exists = $this->db->where('record_id', $id)
                               ->count_all_results('document_records') > 0;
            if ($exists) {
                $this->db->where('record_id', $id)
                         ->update('document_records', array_merge($docData, ['updated_at' => date('Y-m-d H:i:s')]));
            } else {
                $docData['record_id'] = $id;
                $docData['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('document_records', $docData);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

}

/* End of file KinerjaModel.php */
/* Location: ./application/models/KinerjaModel.php */