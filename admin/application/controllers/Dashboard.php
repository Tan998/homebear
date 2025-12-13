<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'user') {
            redirect('auth/login');
        }
    }

    public function index() {
        $data = array(
            'title' => 'User Dashboard',
            'session_data' => $this->session_data
        );
        $this->load->view('dashboard/user', $data);
    }
}
?>
