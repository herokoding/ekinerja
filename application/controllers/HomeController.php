<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load any required models, libraries, etc.
        // $this->load->model('HomeModel');
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
       $this->load->view('main/header');
    }

}

/* End of file HomeController.php */
