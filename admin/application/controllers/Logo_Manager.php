<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logo_Manager extends MY_Controller {

    public $upload;
    public $Logo_Manager_model;
    public $db;

    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'upload']);
        $this->load->helper(['url', 'form']);
        $this->load->model('Logo_Manager_model');

        // yêu cầu đăng nhập
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $logos = glob(FCPATH . 'uploads/company_logo/*.{jpg,jpeg,png,svg,webp}', GLOB_BRACE);

        // convert về đường dẫn tương đối
        $logos = array_map(function($p) {
            return 'uploads/company_logo/' . basename($p);
        }, $logos);

        $data = [
            'title' => "Company Logo Manager",
            'logos' => $logos,
            'setting' => $this->Logo_Manager_model->get_setting()
        ];

        $this->load->view('logo_manager/index', $data);
    }

    public function upload()
    {
        if (!empty($_FILES['logo_file']['name'])) {
            $config = [
                'upload_path'   => FCPATH . 'uploads/company_logo/',
                'allowed_types' => 'jpg|jpeg|png|svg|webp',
                'file_name'     => time() . "_" . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $_FILES['logo_file']['name'])
            ];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('logo_file')) {
                $upload_data = $this->upload->data();
                $filename = $upload_data['file_name'];

                // lưu DB (logo đang được sử dụng)
                $this->Logo_Manager_model->update_logo($filename);
            } else {
                echo $this->upload->display_errors();
                return;
            }
        }

        redirect('Logo_Manager/index');
    }

    public function select()
    {
        $selected = $this->input->post('logo_selected');

        if ($selected) {
            $this->Logo_Manager_model->update_logo($selected);
        }

        redirect('Logo_Manager/index');
    }

    public function delete($filename)
    {
        $filename = urldecode($filename);
        $path = FCPATH . "uploads/company_logo/" . $filename;

        if (file_exists($path)) {
            unlink($path);
        }

        redirect('Logo_Manager/index');
    }
}
