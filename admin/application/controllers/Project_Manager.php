<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Project_Manager extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'upload', 'user_agent']);
        $this->load->helper(['url', 'form']);
        $this->load->model('Project_model');
        $this->load->database();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    /* =============================
        MANAGER
    ============================== */

    public function index($category_key = 'private') {
        $category = $this->Project_model->get_category_by_key($category_key);
        if (!$category) {
            show_404(); // hoặc redirect về default
            return;
        }

        $settings = $this->Project_model->get_settings();

        if (!$settings) {
            $settings = (object)[
                'top_bg_image' => null,
                'footer_text'  => ''
            ];
        }

        $data = [
            'title' => 'Project Manager',
            'category' => $category,
            'categories' => $this->Project_model->get_categories(),
            'projects' => $this->Project_model->get_projects_by_category($category->id),
            'settings' => $settings
        ];

        $this->load->view('admin_project/manager', $data);
    }

    /* =============================
        CREATE / EDIT
    ============================== */

    public function create($category_key) {
        $category = $this->Project_model->get_category_by_key($category_key);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => $category->id,
                'construction_place' => $this->input->post('construction_place'),
                'client_name' => $this->input->post('client_name')
            ];

            $id = $this->Project_model->insert_project($data);
            $this->upload_image($id);

            redirect('Project_Manager/index/'.$category_key);
        }

        $this->load->view('admin_project/form', [
            'title' => 'Create Project',
            'category' => $category
        ]);
    }

    public function edit($id) {
        $project = $this->Project_model->get_project($id);

        $category = $this->Project_model->get_category_by_id($project->category_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->Project_model->update_project($id, [
                'construction_place' => $this->input->post('construction_place'),
                'client_name' => $this->input->post('client_name')
            ]);

            $this->upload_image($id);

            redirect('Project_Manager/index/'.$category->category_key);
        }

        $this->load->view('admin_project/form', [
            'title'    => 'Edit Project',
            'project'  => $project,
            'category' => $category
        ]);
    }


    public function delete($id) {
        $project = $this->Project_model->get_project($id);
        $this->Project_model->delete_project($id);
        redirect('Project_Manager/index/'.$this->get_category_key($project->category_id));
    }

    /* =============================
        SORT (AJAX)
    ============================== */

    public function update_sort()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['order'])) return;

        foreach ($data['order'] as $index => $id) {
            $this->Project_model->update_project($id, [
                'sort_order' => $index + 1
            ]);
        }
    }

    /* =============================
        TOP BG + FOOTER
    ============================== */

    public function upload_top_bg() {
        $folder = FCPATH . 'uploads/projects/top_bg/1/';
        if (!is_dir($folder)) mkdir($folder, 0777, true);

        foreach (glob($folder.'*') as $f) unlink($f);

        if (!empty($_FILES['top_bg']['name'])) {
            $config = [
                'upload_path' => $folder,
                'allowed_types' => 'jpg|jpeg|png|webp',
                'encrypt_name' => true
            ];
            $this->upload->initialize($config);

            if ($this->upload->do_upload('top_bg')) {
                $file = $this->upload->data('file_name');
                $this->Project_model->update_settings(['top_bg_image' => $file]);
            }
        }

        redirect($this->agent->referrer());
    }

    public function update_footer() {
        $this->Project_model->update_settings([
            'footer_text' => $this->input->post('footer_text')
        ]);
        redirect($this->agent->referrer());
    }

    /* =============================
        HELPERS
    ============================== */

    private function upload_image($id) {
        $folder = FCPATH . "uploads/projects/items/$id/";
        if (!is_dir($folder)) mkdir($folder, 0777, true);
        foreach (glob($folder.'*') as $f) unlink($f);

        if (!empty($_FILES['image']['name'])) {
            $config = [
                'upload_path' => $folder,
                'allowed_types' => 'jpg|jpeg|png|webp',
                'encrypt_name' => true
            ];
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $this->Project_model->update_project($id, [
                    'image' => $this->upload->data('file_name')
                ]);
            }
        }
    }

    private function get_category_key($category_id) {
        return $this->db
            ->where('id', $category_id)
            ->get('project_categories')
            ->row()
            ->category_key;
    }
}
