<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KinerjaController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MenuModel', 'menu');
	}

	public function index()
	{
		$this->listKinerja();
	}

	public function listKinerja()
	{
		$data = array(
			'title' => "Daftar Kinerja",
			'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
		);

		$this->load->view('main/header', $data, FALSE);
		$this->load->view('main/navbar', $data, FALSE);
		$this->load->view('content/list-kinerja', $data, FALSE);
		$this->load->view('main/footer');
	}

}

/* End of file KinerjaController.php */
/* Location: ./application/controllers/KinerjaController.php */