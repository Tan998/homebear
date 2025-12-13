<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Auth extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->database();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $password2 = $this->input->post('password-confirm');
            $role = $this->input->post('role');

            if ($password !== $password2) {
                $data['error'] = '確認パスワードが一致しません。';
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $query = $this->db->get_where('users', array('username' => $username));
                if ($query->num_rows() > 0) {
                    $data['error'] = 'ユーザー名は既に存在します。';
                } else {
                    $this->db->insert('users', array(
                        'username' => $username,
                        'password' => $password_hash,
                        'role' => $role ?: 'user'
                    ));
                    $data['success'] = '登録が完了しました。ログインしてください。';
                }
            }
        }
        $this->load->view('auth/register', isset($data) ? $data : NULL);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $query = $this->db->get_where('users', array('username' => $username));
            $user = $query->row();

            if ($user && password_verify($password, $user->password)) {
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('role', $user->role);

                // Redirect theo role
                if ($user->role == 'admin') {
                    redirect('admin/dashboard'); // admin dashboard
                } else {
                    redirect('index'); // user dashboard riêng
                }
            } else {
                $data['error'] = 'アカウントまたはパスワードが正しくありません。';
            }
        }
        $this->load->view('auth/login', isset($data) ? $data : NULL);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
?>
