<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        // Kiểm tra role
        if (empty($this->session_data['logged_in']) || $this->session_data['role'] != 'admin') {
            redirect('auth/login');
        }
    }

    public function index() {
        $data = array(
            'title' => 'Admin Dashboard',
            'session_data' => $this->session_data // lấy từ MY_Controller
        );
        $this->load->view('dashboard/admin', $data);
    }
}
?>
