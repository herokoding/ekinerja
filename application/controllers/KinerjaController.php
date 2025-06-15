<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KinerjaController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MenuModel', 'menu');
		$this->load->model('KinerjaModel', 'kinerja');

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
		$this->listKinerja();
	}

	public function listKinerja()
	{
		$this->form_validation->set_rules('record_date', 'Tanggal Kinerja', 'required');
		$this->form_validation->set_rules('record_desc', 'Uraian Kinerja', 'required');

		if ($this->form_validation->run() == FALSE) {
			$month = $this->input->get('month') ?? date('m');
			$year = $this->input->get('year') ?? date('Y');

			$data = array(
				'title' => "Daftar Kinerja",
				'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
				'current_month' => $month,
				'current_year' => $year,
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

	public function checkStatus()
	{
		$month = $this->input->get('month') ?? date('m');
		$year = $this->input->get('year') ?? date('Y');

		$data = [
			'title' => "Status Approval",
			'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
			'kinerjaList' => $this->kinerja->getLists($month, $year)->result_array(),
			'month' => $month,
			'year' => $year,
		];

		$this->load->view('main/header', $data, FALSE);
		$this->load->view('main/navbar', $data, FALSE);
		$this->load->view('content/checklist-kinerja', $data, FALSE);
		$this->load->view('main/footer');
	}

	public function reportPrint()
	{
		$month = $this->input->get('month') ?? date('m');
		$year = $this->input->get('year') ?? date('Y');

		$data = [
			'title' => "Status Approval",
			'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
			'kinerjaList' => $this->kinerja->getGroupedData($month, $year),
			'month' => $month,
			'year' => $year,
		];

		$this->load->view('main/header', $data, FALSE);
		$this->load->view('main/navbar', $data, FALSE);
		$this->load->view('content/print-kinerja', $data, FALSE);
		$this->load->view('main/footer');
	}

	public function exportPdf()
	{
		$this->load->library('dompdf_lib');

		$month = $this->input->get('month') ?? date('m');
		$year = $this->input->get('year') ?? date('Y');

		$data = [
			'title' => "Status Approval",
			'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
			'kinerjaList' => $this->kinerja->getGroupedData($month, $year),
			'periode' => $this->kinerja->getLists($month, $year)->row_array(),
			'profile' => $this->kinerja->getUserProfile()->row_array(),
			'month' => $month,
			'year' => $year,
		];

		$html = $this->load->view('content/report_pdf', $data, TRUE);

		$this->dompdf_lib->loadHtml($html);
        $this->dompdf_lib->setPaper('A4', 'portrait');
        $this->dompdf_lib->render();

        $this->dompdf_lib->stream("laporan_kinerja.pdf", array("Attachment" => false));
	}

	public function api_get_lists()
	{
		$month = $this->input->get('month') ?? date('m');
		$year = $this->input->get('year') ?? date('Y');

		$listKinerja = $this->kinerja->getFilteredKinerja($month, $year)->result_array();

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
		if (!is_numeric($id)) {
			echo json_encode([
				'success' => false,
				'message' => 'ID tidak valid'
			]);
			return;
		}
		
		$rowKinerja = $this->kinerja->getRowById($id);

		$response = [
			'success' => false,
			'message' => 'Data tidak ditemukan',
			'data' => null,
			'document' => null
		];

		if ($rowKinerja) {
			$response = [
				'success' => true,
				'message' => 'Data ditemukan',
				'data' => [
					'record_id' => $rowKinerja['record_id'],
					'record_date' => $rowKinerja['record_date'],
					'record_desc' => $rowKinerja['record_desc'] ?? ''
				],
				'document' => [
					'document_name' => $rowKinerja['document_name'] ?? null,
					'document_path' => $rowKinerja['document_path'] ?? null
				]
			];
		}

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($response));
	}

	public function api_update_kinerja($id)
	{
		if (!is_numeric($id)) {
			log_message('error', "Invalid ID for update: $id");
			return $this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'success' => false,
				'message' => 'ID tidak valid'
			]));
		}

		$response = ['success' => false, 'message' => 'Update gagal'];

        // Fetch existing record
		$row = $this->kinerja->getRowById($id);
		if (!$row) {
			log_message('debug', "No existing record for ID: $id");
			$response['message'] = 'Data tidak ditemukan';
			return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
		}

        // Gather inputs
		$record_desc = $this->input->post('record_desc');
		$record_date = $this->input->post('record_date');
		log_message('debug', "Updating ID $id with desc='$record_desc' date='$record_date'");

		$perfData = [
			'record_desc' => $record_desc,
			'record_date' => $record_date
		];
		$docData = null;

        // Handle file upload
		if (!empty($_FILES['document_name']['name'])) {
			$config = [
				'upload_path'   => './uploads/kinerja/',
				'allowed_types' => 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png|gif',
				'max_size'      => 2048
			];
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('document_name')) {
				$u = $this->upload->data();
				$docData = [
					'document_name' => $u['file_name'],
					'document_path' => base_url('uploads/kinerja/' . $u['file_name'])
				];
				log_message('debug', "File uploaded: {$u['file_name']}");

				if (!empty($row['document_name'])) {
					$old = FCPATH . 'uploads/kinerja/' . $row['document_name'];
					if (file_exists($old)) {
						unlink($old);
						log_message('debug', "Old file deleted: {$row['document_name']}");
					}
				}
			} else {
				$error = $this->upload->display_errors('', '');
				log_message('error', "Upload error: $error");
				$response['message'] = $error;
				return $this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
			}
		}

        // Perform update via model
		$updated = $this->kinerja->updateById($id, $perfData, $docData);
		log_message('debug', "Model updateById returned: " . ($updated ? 'true' : 'false'));
		if ($updated) {
			$response = ['success' => true, 'message' => 'Data berhasil diperbarui'];
		} else {
			$response['message'] = 'Query gagal dijalankan';
		}

		return $this->output
		->set_content_type('application/json')
		->set_output(json_encode($response));
	}

	public function api_delete_kinerja($id)
	{
		if (!is_numeric($id)) {
			log_message('error', "Invalid ID for delete: $id");
			return $this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'success' => false,
				'message' => 'ID tidak valid'
			]));
		}

		$row = $this->kinerja->getRowById($id);
		if (!$row) {
			log_message('debug', "No existing record for ID: $id");
			return $this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'success' => false,
				'message' => 'Data tidak ditemukan'
			]));
		}

		if (!empty($row['document_name'])) {
			$file = FCPATH . 'uploads/kinerja/' . $row['document_name'];
			if (file_exists($file)) {
				if (unlink($file)) {
					log_message('debug', "Old file deleted: {$row['document_name']}");
				} else {
					log_message('error', "Failed to delete file: {$row['document_name']}");
				}
			}
		}

		$deleted = $this->kinerja->deleteById($id);  
		log_message('debug', "Model deleteById returned: " . ($deleted ? 'true' : 'false'));

		if ($deleted) {
			$response = ['success' => true, 'message' => 'Data berhasil dihapus'];
		} else {
			$response = ['success' => false, 'message' => 'Gagal menghapus data'];
		}

		return $this->output
		->set_content_type('application/json')
		->set_output(json_encode($response));
	}



}

/* End of file KinerjaController.php */
/* Location: ./application/controllers/KinerjaController.php */