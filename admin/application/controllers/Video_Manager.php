<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Video_Manager extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url', 'form'));
        $this->load->database();
        $this->load->model('Video_Manager_model');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Trang danh sách video
    public function VideoList() {
        $videos = $this->Video_Manager_model->get_all();

        $data = array(
            'title'        => 'YouTube Video Manager',
            'videos'       => $videos,
            'session_data' => $this->session_data
        );

        $this->load->view('video_manager/VideoList', $data);
    }

    // Trang tạo mới
    public function VideoCreate() {
        $data = array(
            'title'        => 'Thêm Video YouTube',
            'session_data' => $this->session_data
        );
        $this->load->view('video_manager/VideoCreate', $data);
    }

    // Lưu video mới
    public function save() {
        $video_title = $this->input->post('video_title');
        $youtube_id = $this->input->post('youtube_id');
        $status     = $this->input->post('status');

        if (empty($youtube_id)) {
            $this->session->set_flashdata('error', 'YouTube ID を入力してください!');
            redirect('video_manager/VideoCreate');
        }

        $this->Video_Manager_model->insert($youtube_id, $video_title, $status);
        $this->session->set_flashdata('success', 'Video追加完了しました！');
        redirect('video_manager/VideoList');
    }

    // Xóa video
    public function delete($id = null) {
        if ($id === null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'IDがありません');
            redirect('video_manager/VideoList');
        }

        $this->Video_Manager_model->delete($id);
        $this->session->set_flashdata('success', '削除完了しました！');
        redirect('video_manager/VideoList');
    }

    // Đổi trạng thái 0/1
    public function toggle_status($id) {
        $this->Video_Manager_model->toggle_status($id);
        redirect('video_manager/VideoList');
    }
}
