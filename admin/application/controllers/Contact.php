<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Contact extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url', 'form'));
        $this->load->database();
        $this->load->model('Contact_model');

        // Yêu cầu đăng nhập
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Hiển thị danh sách liên hệ
    public function ContactManager() {
        $contacts = $this->Contact_model->get_all_contacts();

        $data = array(
            'title'        => 'お問い合わせ一覧',
            'contacts'     => $contacts,
            'session_data' => $this->session_data
        );

        $this->load->view('contact/ContactManager', $data);
    }


    // Xoá liên hệ
    public function delete_contact($id = null) {
        if ($id === null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'ID存じません！');
            redirect('contact/ContactManager');
        }

        if ($this->Contact_model->delete_contact($id)) {
            $this->session->set_flashdata('success', '削除完了しました。');
        } else {
            $this->session->set_flashdata('error', '削除失敗しました。');
        }
        redirect('contact/ContactManager');
    }
}
