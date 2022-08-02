<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('username')) {
            redirect(base_url('admin/dashboard'));
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/login');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('admin', ['username' => $username])->row_array();

        // jika usernya ada
        if ($user) {
            if ($password == $user['password']) {
                $data = [
                    'username' => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'id_admin' => $user['id_admin'],
					'loggedin' => date('Y-m-d H:i:s')
                ];
                $this->session->set_userdata($data);
                redirect(base_url('admin/dashboard'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
                redirect(base_url('auth'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username not found</div>');
            redirect(base_url('auth'));
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('nama_lengkap');
        $this->session->unset_userdata('id_admin');
        $this->session->unset_userdata('loggedin');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect(base_url('auth'));
    }

	public function blocked()
	{
		$this->load->view('auth/blocked');
	}
}
