<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Black_List extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Black_List_model');
        $this->load->library(['session']);
        $this->load->helper(['url', 'form']);

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // =========================
    // CREATE BLACK LIST ENTRY
    // =========================
    public function create_black_list() {
        if ($this->input->method() === 'post') {

            $ip = $this->input->post('IP');
            $reason = $this->input->post('reason');

            if ($this->Black_List_model->exists($ip)) {
                $data['title'] = 'ブラックリスト管理';
                $data['error'] = 'このIPは既に登録されています！';
                $this->load->view('black_list/create_black_list', $data);
                return;
            }

            $dataInsert = [
                'ip'         => trim($ip),
                'reason'     => $reason,
                'blocked_at' => time(),
            ];

            $this->Black_List_model->insert($dataInsert);

            // dùng data
            $data['title'] = 'ブラックリスト管理';
            $data['success'] = '登録完了しました！';
            $this->load->view('black_list/create_black_list', $data);
            return;
        }
        $data['title'] = 'Create Black List';
        $this->load->view('black_list/create_black_list', $data);
    }


    // =========================
    // DELETE ENTRY
    // =========================
    public function delete($ip) {
        $this->Black_List_model->delete($ip);
        redirect('black_list/BlackListManage');
    }

    // =========================
    // SHOW LIST
    // =========================
    public function BlackListManage() {
        $data = [
            'title'   => "Black List Manage",
            'black_list' => $this->Black_List_model->get_all(),
            'session_data' => $this->session_data
        ];
        $this->load->view('black_list/BlackListManage', $data);
    }
}
?>
