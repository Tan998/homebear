<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FontTextManager extends MY_Controller {
    public $upload;
    public $FontText_model;
    public $db;

    public function __construct() {
        parent::__construct();
        $this->load->model('FontText_model');
        $this->load->library('session');
        $this->load->database();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = "Font Text Manager";
        $data['fonts'] = $this->FontText_model->get_all();

        $this->load->view('fonttext/Manager', $data);
    }

    public function create() {
        $data['title'] = "Add Font Setting";
        $this->load->view('fonttext/Create', $data);
    }

    public function store() {
        $data = [
            'page_key'     => $this->input->post('page_key'),
            'font_family'  => $this->input->post('font_family'),
            'font_url'     => $this->input->post('font_url'),
            'css_selector' => $this->input->post('css_selector')
        ];

        $this->FontText_model->save_font_settings($data);

        redirect('FontTextManager');
    }

    public function delete($id) {
        $this->FontText_model->delete($id);
        redirect('FontTextManager');
    }
}
