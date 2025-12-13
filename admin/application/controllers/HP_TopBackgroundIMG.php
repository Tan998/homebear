<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HP_TopBackgroundIMG extends MY_Controller {
    public $upload;
    public $HP_TopBackgroundIMG_model;
    public $db;

    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'upload']);
        $this->load->helper(['url', 'form']);
        $this->load->model('HP_TopBackgroundIMG_model');
        $this->load->database();

        // Yêu cầu đăng nhập
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function topbackgroundimg_index()
    {
        $setting = $this->HP_TopBackgroundIMG_model->get_setting();

        // Lấy danh sách file và convert sang relative path
        $lg_images = glob(FCPATH . 'uploads/HP_TopBackgroundIMG/BG_lg/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
        $sm_images = glob(FCPATH . 'uploads/HP_TopBackgroundIMG/BG_sm/*.{jpg,jpeg,png,webp}', GLOB_BRACE);

        // Convert về dạng: uploads/HP_TopBackgroundIMG/BG_lg/file.jpg
        $lg_images = array_map(function ($path) {
            return 'uploads/HP_TopBackgroundIMG/BG_lg/' . basename($path);
        }, $lg_images);

        $sm_images = array_map(function ($path) {
            return 'uploads/HP_TopBackgroundIMG/BG_sm/' . basename($path);
        }, $sm_images);

        $data = [
            'title' => "Background IMG Manager",
            'setting' => $setting,
            'lg_images' => $lg_images,
            'sm_images' => $sm_images,
        ];

        $this->load->view('hp_topbackgroundimg/topbackgroundimg_index', $data);
    }


    public function update() {
        $bg_lg = $this->input->post('bg_lg');
        $bg_sm = $this->input->post('bg_sm');

        // Chỉ update khi có dữ liệu
        if ($bg_lg || $bg_sm) {
            $this->HP_TopBackgroundIMG_model->update_setting($bg_lg, $bg_sm);
        }

        redirect('HP_TopBackgroundIMG/topbackgroundimg_index');
    }

    public function upload() {
        $uploaded_lg = null;
        $uploaded_sm = null;

        foreach (['bg_lg' => 'BG_lg', 'bg_sm' => 'BG_sm'] as $field => $folder) {
            if (!empty($_FILES[$field]['name'])) {
                $config = [
                    'upload_path'   => FCPATH . 'uploads/HP_TopBackgroundIMG/' . $folder . '/',
                    'allowed_types' => 'jpg|jpeg|png|webp',
                    'file_name'     => time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $_FILES[$field]['name'])
                ];

                $this->upload->initialize($config);

                if ($this->upload->do_upload($field)) {
                    $upload_data = $this->upload->data();
                    if ($field === 'bg_lg') {
                        $uploaded_lg = $upload_data['file_name'];
                    } elseif ($field === 'bg_sm') {
                        $uploaded_sm = $upload_data['file_name'];
                    }
                } else {
                    log_message('error', $this->upload->display_errors());
                    echo $this->upload->display_errors();
                }
            }
        }

        // Gọi update_setting nếu có ảnh được upload
        if ($uploaded_lg || $uploaded_sm) {
            $current = $this->HP_TopBackgroundIMG_model->get_setting();

            $bg_lg_filename = $uploaded_lg ?? $current['bg_lg_filename'];
            $bg_sm_filename = $uploaded_sm ?? $current['bg_sm_filename'];

            $this->HP_TopBackgroundIMG_model->update_setting($bg_lg_filename, $bg_sm_filename);
        }

        redirect('HP_TopBackgroundIMG/topbackgroundimg_index');
    }


    public function delete($type, $filename) {
        $folder = $type === 'lg' ? 'BG_lg' : 'BG_sm';
        $filename = urldecode($filename);
        $path = FCPATH . "uploads/HP_TopBackgroundIMG/$folder/$filename";

        if (file_exists($path)) {
            unlink($path);
        }

        redirect('HP_TopBackgroundIMG/topbackgroundimg_index');
    }
}
