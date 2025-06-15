<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KinerjaModel extends CI_Model {

	public function getLists($month = null, $year = null)
	{
		if (empty($month) && empty($year)) {
			$month = date('m');
			$year = date('Y');
		}

		$this->db->select('perform.*, doc.*');
		$this->db->join('document_records doc', 'doc.record_id = perform.record_id', 'left');
		$this->db->where('perform.user_id', $this->session->userdata('user_id'));
		$this->db->where('MONTH(perform.record_date)', $month);
		$this->db->where('YEAR(perform.record_date)', $year);
		$this->db->order_by('perform.record_id', 'asc');

		return $this->db->get('performance_records perform');
	}

	public function getApprove($month = null, $year = null, $user = null)
	{
		if (empty($month) && empty($year) && empty($user)) {
			$month = date('m');
			$year = date('Y');
			$user = "";
		}

		$this->db->select('perform.*, doc.*, user.user_fullname');
		$this->db->join('document_records doc', 'doc.record_id = perform.record_id', 'left');
		$this->db->join('users user', 'user.user_id = perform.user_id', 'left');
		$this->db->where('perform.user_id', $user);
		$this->db->where('MONTH(perform.record_date)', $month);
		$this->db->where('YEAR(perform.record_date)', $year);
		$this->db->order_by('perform.record_id', 'asc');

		return $this->db->get('performance_records perform');
	}

	public function getGroupedData($month = null, $year = null)
	{
		if (empty($month) && empty($year)) {
            $month = date('m');
            $year  = date('Y');
        }

        $this->db->select('perform.*, doc.document_name, doc.document_path');
        $this->db->from('performance_records perform');
        $this->db->join('document_records doc', 'doc.record_id = perform.record_id', 'left');
        $this->db->where('perform.user_id', $this->session->userdata('user_id'));
        $this->db->where('MONTH(perform.record_date)', (int) $month);
        $this->db->where('YEAR(perform.record_date)',  (int) $year);

        $this->db->order_by('perform.record_date', 'ASC');
        $this->db->order_by('perform.record_id',   'ASC');

        $query  = $this->db->get();
        $result = $query->result_array();

        $grouped = [];
        foreach ($result as $row) {
            $tgl = date('Y-m-d', strtotime($row['record_date']));

            if (! isset($grouped[$tgl])) {
                $grouped[$tgl] = [];
            }
            $grouped[$tgl][] = $row;
        }

        return $grouped;
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

    public function deleteById($id)
    {
    	$this->db->trans_begin();

    	$this->db->where('record_id', $id)
    	->delete('document_records');

    	$this->db->where('record_id', $id)
    	->delete('performance_records');

    	if ($this->db->trans_status() === FALSE) {
    		$this->db->trans_rollback();
    		return false;
    	}

    	$this->db->trans_commit();
    	return true;
    }


    public function getFilteredKinerja($month = null, $year = null)
    {
		if (empty($month) && empty($year)) {
			$month = date('m');
			$year = date('Y');
		}

		$this->db->select('perform.*, doc.*');
		$this->db->join('document_records doc', 'doc.record_id = perform.record_id', 'left');
		$this->db->from('performance_records perform');
		$this->db->where('perform.user_id', $this->session->userdata('user_id'));
		$this->db->where('MONTH(perform.record_date)', $month);
		$this->db->where('YEAR(perform.record_date)', $year);
		$this->db->order_by('perform.record_date', 'asc');

		return $this->db->get();
    }

    public function getUserProfile()
    {
    	$this->db->select('user.*, role.role_name, depart.depart_name');
    	$this->db->join('roles role', 'role.role_id = user.role_id', 'left');
    	$this->db->join('departments depart', 'depart.depart_id = user.department_id', 'left');
    	$this->db->where('user.user_id', $this->session->userdata('user_id'));

    	return $this->db->get('users user');
    }

    public function updateStatus($record_id,$status)
    {
    	if (!in_array($status, [1, 2])) {
    		return false;
    	}

    	$this->db->where('record_id', $record_id);
    	return $this->db->update('performance_records', ['record_status' => $status]);
    }

}

/* End of file KinerjaModel.php */
/* Location: ./application/models/KinerjaModel.php */