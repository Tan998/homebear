<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database(); // thêm dòng này để model load DB
    }

    public function insert_post($data) {
        $this->db->insert('posts', $data);
        return $this->db->insert_id();  // Quan trọng: trả về ID mới
    }
    public function insert_sub_image($post_id, $file_name) {
        return $this->db->insert('post_images', array(
            'post_id' => $post_id,
            'file_name' => $file_name
        ));
    }

    public function get_sub_images($post_id) {
        return $this->db->get_where('post_images', array('post_id' => $post_id))->result();
    }

    // Lấy thông tin 1 sub ảnh theo ID
    public function get_sub_image($id) {
        return $this->db->where('id', $id)->get('post_images')->row();
    }

    // Xoá sub ảnh theo ID
    public function delete_sub_image($id) {
        $this->db->where('id', $id)->delete('post_images');
    }

    // Cập nhật bài viết
    public function update_post($id, $data) {
        return $this->db->where('id', $id)->update('posts', $data);
    }

    // Xóa bài viết
    public function delete_post($id) {
        return $this->db->delete('posts', array('id' => $id));
    }

    // Lấy 1 bài viết theo ID
    public function get_post($id) {
        return $this->db->get_where('posts', array('id' => $id))->row();
    }

    public function get_all() {
        return $this->db->order_by('created_at', 'DESC')->get('posts')->result();
    }


}
?>
