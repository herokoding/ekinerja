<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load any required models, libraries, etc.
        // $this->load->model('HomeModel');

        if (!$this->session->userdata('role_id')) {
            redirect('auth','refresh');
        }
    }
    /**
     * Index method
     * 
     * This method is the default method that will be called when the controller is accessed.
     * It can be used to load the home page or any other functionality.
     */
    /**
     * @return void
     */

    public function index()
    {
       $data = array(
         'title' => "Ekinerja",
         'user' => $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(),
         'queryMenu' => $this->menu->getAccessMenu($this->session->userdata('role_id'))->result_array(),
        );

      $this->load->view('main/header', $data, FALSE);
      $this->load->view('main/navbar', $data, FALSE);
      $this->load->view('content/dashboard', $data, FALSE);
      $this->load->view('main/footer');
    }

}

/* End of file HomeController.php */
