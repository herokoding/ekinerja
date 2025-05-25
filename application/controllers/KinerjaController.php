<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KinerjaController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MenuModel', 'menu');
		$this->load->model('KinerjaModel', 'kinerja');
	}

	public function index()
	{
		$this->listKinerja();
	}

	public function listKinerja()
	{
		$this->form_validation->set_rules('record_date', 'Tanggal Kinerja', 'required');
		$this->form_validation->set_rules('record_desc', 'Uraian Kinerja', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'title' => "Daftar Kinerja",
				'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
			);

			$this->load->view('main/header', $data, FALSE);
			$this->load->view('main/navbar', $data, FALSE);
			$this->load->view('content/list-kinerja', $data, FALSE);
			$this->load->view('main/footer');
		} else {
			if ($this->input->post()) {
				date_default_timezone_set('Asia/Jakarta');
				$post = [
					'user_id' => $this->session->userdata('user_id'),
					'record_date' => $this->input->post('record_date'),
					'record_status' => 0,
					'record_desc' => $this->input->post('record_desc'),
					'created_at' => date('Y-m-d H:i:s'),
				];

				$this->db->insert('performance_records', $post);

				$id = $this->db->insert_id();

				$config['upload_path']   = './uploads/documents/';
				$config['allowed_types'] = 'pdf|doc|docx|xlsx|txt|jpg|png';
            	$config['max_size']      = 2048;

            	if (!is_dir($config['upload_path']) || !is_writable($config['upload_path'])) {
            		show_error('Upload folder tidak ada atau tidak memiliki permission write.');
            	}

            	$this->upload->initialize($config);

            	if (!$this->upload->do_upload('document_name')) {
            		$errorUpload = $this->upload->display_errors('', '');
            		log_message('error', 'Upload Error:' . $errorUpload);
            		$this->session->set_flashdata('upload_error', $errorUpload);

            		redirect('kinerja/listKinerja');
            	} else {
            		$uploadedData = $this->upload->data();

            		$fileName = $uploadedData['file_name'];

            		$this->db->insert('document_records', [
            			'record_id' => $id,
            			'document_name' => $fileName,
            			'document_path' => 'uploads/documents/' . $fileName,
            			'uploaded_by' => $this->session->userdata('user_id'),
            			'uploaded_at' => date('Y-m-d H:i:s'),
            		]);

            		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Performance added!</div>');

            		redirect('kinerja/listKinerja','refresh');
            	}
        	}
    	}
	}

	public function api_get_lists()
	{
		$listKinerja = $this->kinerja->getLists()->result_array();

    	foreach ($listKinerja as &$item) { 
    		$item['document_path'] = !empty($item['document_name']) ? base_url('uploads/documents/' . $item['document_name']) : '';
    	}

    	unset($item);
	
    	$this->output
    	->set_content_type('application/json')
    	->set_output(json_encode(['data' => $listKinerja]));
	}

	public function api_get_row_kinerja($id)
	{
		$rowKinerja = $this->kinerja->getRowById($id)->row_array();

		if($rowKinerja) {
			$response = [
				'success' => true,
				'data' => $rowKinerja,
			];
		} else {
			$response = [
				'success' => false,
				'message' => 'Data tidak ditemukan'
			];
		}

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($response));
	}

}

/* End of file KinerjaController.php */
/* Location: ./application/controllers/KinerjaController.php */