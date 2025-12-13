<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class News_Manager extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url','form']);
        $this->load->library(['session']);
        $this->load->model('News_Manager_model');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Hiển thị danh sách news
    public function index() {
        $news = $this->News_Manager_model->get_all();

        $data = [
            'title' => 'News Manager',
            'news'  => $news
        ];

        $this->load->view('news_manager/NewsList', $data);
    }

    // Trang tạo mới
    public function create() {
        $data = [
            'title' => 'ニュース登録'
        ];
        $this->load->view('news_manager/NewsCreate', $data);
    }

    // Lưu bài mới
    public function save() {
        $title        = $this->input->post('news_title');
        $content      = $this->input->post('news_content');
        $publish_date = $this->input->post('publish_date');

        if (empty($title) || empty($content) || empty($publish_date)) {
            $this->session->set_flashdata('error', '完全な情報を入力してください。');
            redirect('news_manager/create');
        }

        $this->News_Manager_model->insert($title, $content, $publish_date);
        $this->session->set_flashdata('success', 'ニュース投稿が正常に作成されました。');
        redirect('news_manager');
    }

    // Trang chỉnh sửa
    public function edit($id) {
        $news_item = $this->News_Manager_model->get_by_id($id);

        if (!$news_item) {
            $this->session->set_flashdata('error', 'ニュース記事が見つかりません。');
            redirect('news_manager');
        }

        $data = [
            'title' => 'Chỉnh sửa News',
            'news'  => $news_item
        ];

        $this->load->view('news_manager/NewsEdit', $data);
    }

    // Xử lý cập nhật
    public function update($id) {
        $title        = $this->input->post('news_title');
        $content      = $this->input->post('news_content');
        $publish_date = $this->input->post('publish_date');

        $this->News_Manager_model->update($id, $title, $content, $publish_date);
        $this->session->set_flashdata('success', 'ニュースの更新に成功しました!');
        redirect('news_manager');
    }

    // Xóa
    public function delete($id) {
        $this->News_Manager_model->delete($id);
        $this->session->set_flashdata('success', '正常に削除されました。');
        redirect('news_manager');
    }
}
