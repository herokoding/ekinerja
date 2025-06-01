<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApprovalController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('KinerjaModel', 'kinerja');
		$this->load->model('MenuModel', 'menu');

		if (!$this->session->userdata('role_id')) {
            redirect('auth','refresh');
        }

        $accessMenu = $this->db->get_where('access_menu', ['role_id' => $this->session->userdata('role_id')]);

        if ($accessMenu->num_rows() < 1) {
            redirect('auth/blocked','refresh');
        }
	}

	public function index()
	{
		$this->approvedWork();
	}

	public function approvedWork()
	{
		$month = $this->input->get('month') ?? date('m');
		$year = $this->input->get('year') ?? date('Y');
		$user = $this->input->get('user');

		$data = [
			'title' => "Approve Work",
			'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
			'kinerjaList' => $this->kinerja->getLists($month, $year)->result_array(),
			'listUser' => $this->db->get_where('users', ['is_supervisor' => 1])->result_array(),
			'month' => $month,
			'year' => $year,
			'user' => $user,
		];

		$this->load->view('main/header', $data);
		$this->load->view('main/navbar', $data);
		$this->load->view('content/approve-work', $data);
		$this->load->view('main/footer');
	}

	public function updateStatus($record_id, $status)
	{
		$record_id = (int) $record_id;
		$status = (int) $status;

		if (!in_array($status, [1, 2])) {
			show_error('Status tidak valid.', 400);
		}

		 $updated = $this->kinerja->updateStatus($record_id, $status);

		 if ($updated) {
		 	$this->session->set_flashdata('message', '<div class="alert alert-success">Status berhasil diupdate.</div>');
		 } else {
		 	$this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal update status.</div>');
		 }

		 redirect('approval/index','refresh');
	}

	public function api_get_lists()
	{
		$month = $this->input->get('month') ?? date('m');
		$year = $this->input->get('year') ?? date('Y');
		$user = $this->input->get('user');

		$listApprove = $this->kinerja->getApprove($month, $year, $user)->result_array();

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode(['data' => $listApprove]));
	}

}

/* End of file ApprovalController.php */
/* Location: ./application/controllers/ApprovalController.php */