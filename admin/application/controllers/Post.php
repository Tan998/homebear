<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Post extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session', 'upload'));
        $this->load->helper(array('url', 'form'));
        $this->load->model('Post_model');
        $this->load->database();

        // Yêu cầu đăng nhập
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function create_posts() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $this->input->post('title');
            $text_content = $this->input->post('text_content');

            $before_issue = $this->input->post('before_issue');
            $after_effect = $this->input->post('after_effect');
            $used_features = $this->input->post('used_features');

            $ShopName = $this->input->post('ShopName');
            $Address = $this->input->post('Address');
            $Link = $this->input->post('Link');

            $publish_date = $this->input->post('publish_date');

            // Insert trước để lấy post_id
            $post_data = array(
                'title' => $title,
                'text_content' => $text_content,

                'before_issue' => $before_issue,
                'after_effect' => $after_effect,
                'used_features' => $used_features,
                
                'ShopName' => $ShopName,
                'Address' => $Address,
                'Link' => $Link,
                
                'title_img' => '', // tạm để rỗng
                'publish_date' => $publish_date ?: date('Y-m-d')
            );
            $post_id = $this->Post_model->insert_post($post_data);

            // Tạo folder riêng cho title_img
            $title_img_folder = './uploads/posts/title_img/' . $post_id . '/';
            if (!is_dir($title_img_folder)) {
                mkdir($title_img_folder, 0755, true);
            }

            // Upload title_img
            if (!empty($_FILES['title_img']['name'])) {
                $config['upload_path'] = $title_img_folder;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);
                if ($this->upload->do_upload('title_img')) {
                    $title_img_file = $this->upload->data('file_name');

                    // Cập nhật lại title_img vào post
                    $this->Post_model->update_post($post_id, ['title_img' => $title_img_file]);
                }
            }

            // Tạo folder con cho sub_img
            $sub_img_folder = './uploads/posts/sub_img/' . $post_id . '/';
            if (!is_dir($sub_img_folder)) {
                mkdir($sub_img_folder, 0755, true);
            }

            // Xử lý upload nhiều sub_img
            if (!empty($_FILES['sub_img']['name'][0])) {
                $files = $_FILES['sub_img'];
                $count = count($files['name']);

                for ($i = 0; $i < $count; $i++) {
                    $_FILES['sub_img_single']['name']     = $files['name'][$i];
                    $_FILES['sub_img_single']['type']     = $files['type'][$i];
                    $_FILES['sub_img_single']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['sub_img_single']['error']    = $files['error'][$i];
                    $_FILES['sub_img_single']['size']     = $files['size'][$i];

                    $config['upload_path'] = $sub_img_folder;
                    $config['allowed_types'] = 'jpg|png|jpeg|gif';
                    $config['encrypt_name'] = TRUE;

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('sub_img_single')) {
                        $file_name = $this->upload->data('file_name');
                        // Lưu vào bảng phụ
                        $this->Post_model->insert_sub_image($post_id, $file_name);
                    }
                }
            }
            $data['title'] = 'Create Post';
            $data['success'] = '投稿が完了しました！';
            $this->load->view('post/create_posts', $data);
        }
        $data['title'] = 'Create Post';
        $this->load->view('post/create_posts', isset($data) ? $data : NULL);
    }

    public function edit($id) {
        $post = $this->Post_model->get_post($id);
        if (!$post) show_404();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $this->input->post('title');
            $text_content = $this->input->post('text_content');

            $before_issue = $this->input->post('before_issue');
            $after_effect = $this->input->post('after_effect');
            $used_features = $this->input->post('used_features');

            $ShopName = $this->input->post('ShopName');
            $Address = $this->input->post('Address');
            $Link = $this->input->post('Link');

            $publish_date = $this->input->post('publish_date');

            // --- Upload title_img mới (nếu có)
            $title_img_folder = './uploads/posts/title_img/' . $id . '/';
            if (!is_dir($title_img_folder)) {
                mkdir($title_img_folder, 0755, true);
            }

            $title_img = $post->title_img;
            if (!empty($_FILES['title_img']['name'])) {
                $config['upload_path'] = $title_img_folder;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);
                if ($this->upload->do_upload('title_img')) {
                    $title_img = $this->upload->data('file_name');
                    // (Tùy chọn) Xóa file cũ nếu muốn
                    // if ($post->title_img && file_exists($title_img_folder.$post->title_img)) {
                    //     unlink($title_img_folder.$post->title_img);
                    // }
                }
            }

            // --- Upload thêm sub_img mới (nếu có)
            $sub_img_folder = './uploads/posts/sub_img/' . $id . '/';
            if (!is_dir($sub_img_folder)) {
                mkdir($sub_img_folder, 0755, true);
            }

            if (!empty($_FILES['sub_img']['name'][0])) {
                $files = $_FILES['sub_img'];
                $count = count($files['name']);

                for ($i = 0; $i < $count; $i++) {
                    $_FILES['sub_img_single']['name']     = $files['name'][$i];
                    $_FILES['sub_img_single']['type']     = $files['type'][$i];
                    $_FILES['sub_img_single']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['sub_img_single']['error']    = $files['error'][$i];
                    $_FILES['sub_img_single']['size']     = $files['size'][$i];

                    $config['upload_path'] = $sub_img_folder;
                    $config['allowed_types'] = 'jpg|png|jpeg|gif';
                    $config['encrypt_name'] = TRUE;

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('sub_img_single')) {
                        $file_name = $this->upload->data('file_name');
                        $this->Post_model->insert_sub_image($id, $file_name);
                    }
                }
            }

            // --- Cập nhật DB
            $this->Post_model->update_post($id, [
                'title' => $title,
                'text_content' => $text_content,

                'before_issue' => $before_issue,
                'after_effect' => $after_effect,
                'used_features' => $used_features,
                
                'ShopName' => $ShopName,
                'Address' => $Address,
                'Link' => $Link,
                
                'title_img' => $title_img,
                'publish_date' => $publish_date

            ]);
            $data['title'] = 'Edit Post';
            $data['success'] = '更新に成功しました!';
            $this->load->view('post/create_posts', $data);
        }

        // Lấy sub_img để hiển thị
        $data = array(
            'title' => "Edit Post",
            'post' => $post
        );
        $data['sub_images'] = $this->Post_model->get_sub_images($id);
        $this->load->view('post/create_posts', $data);
    }

    public function delete_sub_image($image_id) {
        $image = $this->Post_model->get_sub_image($image_id);
        if (!$image) show_404();

        // Xoá file
        $file_path = './uploads/posts/sub_img/' . $image->post_id . '/' . $image->file_name;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Xoá DB
        $this->Post_model->delete_sub_image($image_id);

        // Redirect về trang edit của bài viết
        redirect('post/edit/' . $image->post_id);
    }


    public function delete($id) {
        $post = $this->Post_model->get_post($id);
        if ($post) {
            $this->Post_model->delete_post($id);
        }
        redirect('post/PostsListManage');
    }

    public function PostsListManage() {
        $posts = $this->Post_model->get_all();
        foreach ($posts as $post) {
            $post->sub_images = $this->Post_model->get_sub_images($post->id);
        }
        $data = array(
            'title' => "Posts Manage",
            'posts' => $posts,
            'session_data' => $this->session_data
        );
        $this->load->view('post/PostsListManage', $data);
    }
}
?>
