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
        // Validation
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('user_password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            // Load the login view
            $data = array(
                'title' => "Login | E-kinerja",
            );

            $this->load->view('auth/login', $data, FALSE);
        } else {
            $this->_do_login();
        }
    }

    private function _do_login() {
    // 1. Ambil input
        $username = $this->input->post('username');
        $password = $this->input->post('user_password');

    // 2. Query user
        $user = $this->db->get_where('users', ['username' => $username])->row_array();

        if ($user && $user['user_is_active'] == 1) {
            $storedHash = $user['user_password'];
            $isValid    = false;

        // 3. Coba verifikasi modern (bcrypt/Argon2)
            if (password_verify($password, $storedHash)) {
                $isValid = true;
            }
        // 4. Fallback: cek MD5 legacy
            elseif (md5($password) === $storedHash) {
                $isValid = true;

            // 5. Migrasi ke hash baru (bcrypt)
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $this->db->where('user_id', $user['user_id'])
                ->update('users', ['user_password' => $newHash]);
            }

            if ($isValid) {
            // 6. Set session dan redirect
                $this->session->set_userdata([
                    'user_id'       => $user['user_id'],
                    'user_email'    => $user['user_email'],
                    'username'      => $user['username'],
                    'role_id'       => $user['role_id'],
                    'department_id' => $user['department_id']
                ]);
                redirect('admin/dashboard','refresh');
                return;
            } 
            else {
                echo "Wrong password!";
                return;
            }
        }

    // Username tidak ditemukan atau belum aktif
        echo isset($user) ? "Username not activated" : "Username not registered";
    }


    public function logout() {
        // Destroy session and redirect to login
        $this->session->sess_destroy();
        redirect('auth', 'refresh');
    }

    public function blocked()
    {
        echo 'Access Denied !!';
    }
}