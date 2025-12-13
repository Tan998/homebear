<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Company_Profile_Manager extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session', 'upload'));
        $this->load->helper(array('url', 'form'));
        $this->load->model('Company_Profile_model');
        $this->load->database();

        // Yêu cầu đăng nhập
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function create_profile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //profile info
            $text_company_profile = $this->input->post('text_company_profile');
            $text_content = $this->input->post('text_content');

            //profile table
            $company_name = $this->input->post('company_name');
            $company_address = $this->input->post('company_address');
            $company_phone = $this->input->post('company_phone');

            $establishment_date = $this->input->post('establishment_date');
            $capital_stock = $this->input->post('capital_stock');
            $list_staff = $this->input->post('list_staff');
            $number_of_employees = $this->input->post('number_of_employees');

            $permits_and_licenses = $this->input->post('permits_and_licenses');
            $intellectual_property = $this->input->post('intellectual_property');
            $business_content = $this->input->post('business_content');
            $bank_info = $this->input->post('bank_info');
            // Insert trước để lấy post_id
            $company_profile_data = array(
                'text_company_profile' => $text_company_profile,
                'text_content' => $text_content,

                'company_name' => $company_name,
                'company_address' => $company_address,
                'company_phone' => $company_phone,
                
                'establishment_date' => $establishment_date,
                'capital_stock' => $capital_stock,
                'list_staff' => $list_staff,
                'number_of_employees' => $number_of_employees,

                'permits_and_licenses' => $permits_and_licenses,
                'intellectual_property' => $intellectual_property,
                'business_content' => $business_content,
                'bank_info' => $bank_info
            );
            $company_profile_id = $this->Company_Profile_model->insert_company_profile($company_profile_data);

            // Folder cố định
            $title_img_folder = './uploads/company_profile/title_img/1/';

            // Tạo folder nếu chưa có
            if (!is_dir($title_img_folder)) {
                mkdir($title_img_folder, 0755, true);
            }

            // XÓA toàn bộ ảnh cũ trước khi upload
            $old_files = glob($title_img_folder . "*"); // lấy tất cả file
            foreach ($old_files as $file) {
                if (is_file($file)) {
                    unlink($file); // xóa file
                }
            }

            // Upload title_img
            if (!empty($_FILES['title_img']['name'])) {
                $config['upload_path'] = $title_img_folder;
                $config['allowed_types'] = 'jpg|png|jpeg|gif|webp';
                $config['encrypt_name'] = TRUE;  // có thể đổi tên random nếu bạn muốn
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('title_img')) {

                    $title_img_file = $this->upload->data('file_name');

                    // Cập nhật vào DB
                    $this->Company_Profile_model->update_company_profile(
                        $company_profile_id,
                        ['title_img' => $title_img_file]
                    );
                }
            }

            // Folder cố định cho sub_img (luôn là 1)
            $sub_img_folder = './uploads/company_profile/sub_img/1/';
            // Tạo folder nếu chưa có
            if (!is_dir($sub_img_folder)) {
                mkdir($sub_img_folder, 0755, true);
            }
            // XÓA ảnh cũ trong folder
            $old_files = glob($sub_img_folder . "*"); // lấy tất cả file
            foreach ($old_files as $file) {
                if (is_file($file)) unlink($file);
            }
            // Xử lý upload sub_img
            if (!empty($_FILES['sub_img']['name'])) {
                $config['upload_path'] = $sub_img_folder;
                $config['allowed_types'] = 'jpg|png|jpeg|gif|webp';
                $config['encrypt_name'] = TRUE;  // có thể đặt TRUE hoặc FALSE tùy ý
                $config['overwrite'] = TRUE;
                $this->upload->initialize($config);
                // chú ý: đây phải là name="sub_img" (KHÔNG phải sub_img_single)
                if ($this->upload->do_upload('sub_img')) {
                    $file_name = $this->upload->data('file_name');
                    // Lưu vào bảng phụ
                    $this->Company_Profile_model->insert_sub_image(
                        $company_profile_id,
                        $file_name
                    );
                }
            }

            $data['title'] = 'Create Company Profile';
            $data['success'] = '会社概要を作成完了しました！';
            $this->load->view('company_profile/create_company_profile', $data);
        }
        $data['title'] = 'Create Post';
        $this->load->view('company_profile/create_company_profile', isset($data) ? $data : NULL);
    }

    public function edit($id) {

        $company_profile = $this->Company_Profile_model->get_company_profile($id);
        if (!$company_profile) show_404();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $text_company_profile = $this->input->post('text_company_profile');
            $text_content = $this->input->post('text_content');

            $company_name = $this->input->post('company_name');
            $company_address = $this->input->post('company_address');
            $company_phone = $this->input->post('company_phone');

            $establishment_date = $this->input->post('establishment_date');
            $capital_stock = $this->input->post('capital_stock');
            $list_staff = $this->input->post('list_staff');
            $number_of_employees = $this->input->post('number_of_employees');

            $permits_and_licenses = $this->input->post('permits_and_licenses');
            $intellectual_property = $this->input->post('intellectual_property');
            $business_content = $this->input->post('business_content');
            $bank_info = $this->input->post('bank_info');

            // ===============================
            // 1) TITLE IMAGE (folder cố định: 1)
            // ===============================
            $title_img_folder = './uploads/company_profile/title_img/1/';

            if (!is_dir($title_img_folder)) {
                mkdir($title_img_folder, 0755, true);
            }

            $title_img = $company_profile->title_img; // file cũ trong DB

            if (!empty($_FILES['title_img']['name'])) {

                // XÓA ảnh cũ trong folder trước khi upload ảnh mới
                $old_files = glob($title_img_folder . "*");
                foreach ($old_files as $file) {
                    if (is_file($file)) unlink($file);
                }

                // Config upload
                $config['upload_path']   = $title_img_folder;
                $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                $config['encrypt_name']  = TRUE;
                $config['overwrite']     = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('title_img')) {
                    $title_img = $this->upload->data('file_name'); // tên mới
                }
            }



            // =================================
            // 2) SUB IMAGES (folder cố định: 1)
            // =================================
            $sub_img_folder = './uploads/company_profile/sub_img/1/';

            if (!is_dir($sub_img_folder)) {
                mkdir($sub_img_folder, 0755, true);
            }

            if (!empty($_FILES['sub_img']['name'])) {

                // XÓA toàn bộ ảnh cũ trong thư mục sub_img/1/
                $old_sub_files = glob($sub_img_folder . "*");
                foreach ($old_sub_files as $file) {
                    if (is_file($file)) unlink($file);
                }

                // Config upload
                $config['upload_path']   = $sub_img_folder;
                $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                $config['encrypt_name']  = TRUE;
                $config['overwrite']     = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('sub_img')) {
                    $file_name = $this->upload->data('file_name');

                    // Lưu DB
                    $this->Company_Profile_model->insert_sub_image($id, $file_name);
                }
            }

            // --- Save to DB ---
            $this->Company_Profile_model->update_company_profile($id, [
                'text_company_profile' => $text_company_profile,
                'text_content' => $text_content,

                'company_name' => $company_name,
                'company_address' => $company_address,
                'company_phone' => $company_phone,

                'establishment_date' => $establishment_date,
                'capital_stock' => $capital_stock,
                'list_staff' => $list_staff,
                'number_of_employees' => $number_of_employees,

                'permits_and_licenses' => $permits_and_licenses,
                'intellectual_property' => $intellectual_property,
                'business_content' => $business_content,
                'bank_info' => $bank_info,

                'title_img' => $title_img
            ]);
            $data['title'] = 'Edit Company Profile';
            $data['success'] = "更新に成功しました！";
            $data['company_profile'] = $company_profile;
            $this->load->view('company_profile/create_company_profile', $data);
        }

        $data['title'] = 'Edit Company Profile';
        $data['company_profile'] = $company_profile;
        $data['sub_images'] = $this->Company_Profile_model->get_sub_images($id);

        $this->load->view('company_profile/create_company_profile', $data);
    }


    public function delete_sub_image($id) {
        $folder = './uploads/company_profile/sub_img/1/';
        $files = glob($folder . '*');

        foreach ($files as $file) {
            if (is_file($file)) unlink($file);
        }

        // Redirect về trang edit có ID cha
        redirect('Company_Profile_Manager/edit/' . $id);
    }



    public function delete($id) {
        $company_profile = $this->Company_Profile_model->get_company_profile($id);
        if ($company_profile) {
            $this->Company_Profile_model->delete_company_profile($id);
        }
        redirect('company_profile/CompanyProfileManager');
    }

    public function CompanyProfileManager() {
        $company_profile = $this->Company_Profile_model->get_all();
        /*foreach ($company_profile as $item) {
            $item->sub_images = $this->Company_Profile_model->get_sub_images($item->id);
        }*/
        $data = array(
            'title' => "Company Profile Manager",
            'company_profile' => $company_profile,
            'session_data' => $this->session_data
        );
        $data['has_profile'] = $this->Company_Profile_model->has_profile();
        $this->load->view('company_profile/CompanyProfileManager', $data);
    }
}
?>
