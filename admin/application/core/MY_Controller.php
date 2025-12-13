<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $session;
    public $session_data = array();

    public function __construct()
    {
        parent::__construct();

        // Load thư viện session (bạn cũng có thể autoload)
        $this->load->library('session');

        // Lấy tất cả userdata lưu vào biến public, controller con sẽ dùng được
        $this->session_data = $this->session->userdata();

        // Share cho tất cả view
        $this->load->vars(['session_data' => $this->session_data]);
        // Nếu muốn: kiểm tra login luôn ở đây
        // if (empty($this->session_data['logged_in'])) {
        //     redirect('auth/login');
        // }
    }
}
