<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Company_Profile_Manager_Ver2 extends MY_Controller {

    public $upload;
    public $Company_Profile_Ver2_model;
    public $db;

    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'upload']);
        $this->load->helper(['url', 'form']);
        $this->load->model('Company_Profile_Ver2_model');
        $this->load->database();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function create() {
        if ($this->Company_Profile_Ver2_model->has_profile()) {
            // Không cho tạo thêm
            redirect('company_profile_ver2/Manager');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $this->Company_Profile_Ver2_model->insert_profile([
                'text_company_profile' => $this->input->post('text_company_profile'),
                'text_content' => $this->input->post('text_content')
            ]);

            // SAVE FIELDS
            $keys = $this->input->post('field_key');
            $values = $this->input->post('field_value');
            $orders = $this->input->post('field_order');

            if ($keys) {
                foreach ($keys as $i => $key) {
                    $this->Company_Profile_Ver2_model->insert_field($id, [
                        'field_key' => $key,
                        'field_value' => $values[$i],
                        'sort_order' => intval($orders[$i])
                    ]);
                }
            }

            // UPLOAD title image
            $this->upload_title_image($id);

            // Upload sub images
            $this->upload_sub_image($id);

            redirect('Company_Profile_Manager_Ver2/index');
        }

        $data['title'] = "Create Profile Ver2";
        $this->load->view('company_profile_ver2/Form', $data);
    }

    public function edit($id) {
        $profile = $this->Company_Profile_Ver2_model->get($id);
        if (!$profile) show_404();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // UPDATE PROFILE
            $this->Company_Profile_Ver2_model->update_profile($id, [
                'text_company_profile' => $this->input->post('text_company_profile'),
                'text_content' => $this->input->post('text_content')
            ]);

            // DELETE OLD FIELDS → INSERT NEW
            $this->Company_Profile_Ver2_model->delete_all_fields($id);

            $keys = $this->input->post('field_key');
            $values = $this->input->post('field_value');
            $orders = $this->input->post('field_order');

            if ($keys) {
                foreach ($keys as $i => $key) {
                    $this->Company_Profile_Ver2_model->insert_field($id, [
                        'field_key' => $key,
                        'field_value' => $values[$i],
                        'sort_order' => intval($orders[$i])
                    ]);
                }
            }

            $this->upload_title_image($id);
            $this->upload_sub_image($id);

            redirect("Company_Profile_Manager_Ver2/edit/$id");
        }

        $data = [
            'title' => 'Edit Profile Ver2',
            'profile' => $profile,
            'fields' => $this->Company_Profile_Ver2_model->get_fields($id),
            'images' => $this->Company_Profile_Ver2_model->get_images($id)
        ];
        $this->load->view('company_profile_ver2/Form', $data);
    }

    private function upload_title_image($id)
    {
        $folder = FCPATH . "uploads/company_profile_ver2/title_img/$id/";

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if (empty($_FILES['title_img']['name'])) return;

        foreach (glob($folder . '*') as $oldFile) {
            if (is_file($oldFile)) {
                unlink($oldFile);
            }
        }

        $config = [
            'upload_path'   => $folder,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'encrypt_name'  => true,
            'overwrite'     => true
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload('title_img')) {
            $file = $this->upload->data('file_name');

            // update DB
            $this->Company_Profile_Ver2_model->update_profile($id, [
                'title_img' => $file
            ]);
        }
    }


    private function upload_sub_image($id)
    {
        $folder = FCPATH . "uploads/company_profile_ver2/sub_img/$id/";

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if (empty($_FILES['sub_img']['name'])) return;

        foreach (glob($folder . '*') as $oldFile) {
            if (is_file($oldFile)) {
                unlink($oldFile);
            }
        }

        $this->Company_Profile_Ver2_model->delete_images_by_profile($id);

        $config = [
            'upload_path'   => $folder,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'encrypt_name'  => true,
            'overwrite'     => true
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload('sub_img')) {
            $file = $this->upload->data('file_name');

            $this->Company_Profile_Ver2_model->insert_image($id, $file);
        }
    }


    public function index()
    {
        $data['title'] = "Company Profile Manager Ver2";

        $data['has_profile'] = $this->Company_Profile_Ver2_model->has_profile();
        $data['first_profile'] = $this->Company_Profile_Ver2_model->get_first_profile();

        $this->load->view('company_profile_ver2/Manager', $data);
    }
}
?>
