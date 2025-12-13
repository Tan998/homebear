<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Download_Materials extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url', 'form'));
        $this->load->database();
        $this->load->model('Download_Materials_model');

        // Yêu cầu đăng nhập
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Hiển thị danh sách liên hệ
    public function Download_Materials_Manager() {
        $download_materials = $this->Download_Materials_model->get_all_download_materials();

        $data = array(
            'title'        => '資料ダウンローリクエスト一覧',
            'download_materials'     => $download_materials,
            'session_data' => $this->session_data
        );

        $this->load->view('download_materials/Download_Materials_Manager', $data);
    }


    // Xoá liên hệ
    public function delete_download_materials($id = null) {
        if ($id === null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'ID存じません！');
            redirect('download_materials/Download_Materials_Manager');
        }

        if ($this->Download_Materials_model->delete_download_materials($id)) {
            $this->session->set_flashdata('success', '削除完了しました。');
        } else {
            $this->session->set_flashdata('error', '削除失敗しました。');
        }
        redirect('download_materials/Download_Materials_Manager');
    }
}
