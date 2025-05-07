<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

    public function __construct() {
        parent::__construct();
       
    }

    public function index() {
        // Default method, redirect to login
        $this->login();
    }

    public function login() {
        // Load the login view
        $data = array(
            'title' => "Login | E-kinerja",
        );
        
        $this->load->view('auth/login', $data);
    }

    public function do_login() {
        // Handle login logic here
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Example: Simple authentication logic
        if ($username === 'admin' && $password === 'password') {
            $this->session->set_userdata('logged_in', true);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('authcontroller/login');
        }
    }

    public function logout() {
        // Destroy session and redirect to login
        $this->session->sess_destroy();
        redirect('authcontroller/login');
    }
}