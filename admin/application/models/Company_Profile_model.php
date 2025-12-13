<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Profile_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database(); // thêm dòng này để model load DB
    }

    public function insert_company_profile($data) {
        $this->db->insert('company_profile', $data);
        return $this->db->insert_id();  // Quan trọng: trả về ID mới
    }
    public function insert_sub_image($company_profile_id, $file_name) {
        return $this->db->insert('company_profile_images', array(
            'company_profile_id' => $company_profile_id,
            'file_name' => $file_name
        ));
    }

    public function get_sub_images($company_profile_id) {
        return $this->db->get_where('company_profile_images', array('company_profile_id' => $company_profile_id))->result();
    }

    // Lấy thông tin 1 sub ảnh theo ID
    public function get_sub_image($id) {
        return $this->db->where('id', $id)->get('company_profile_images')->row();
    }

    // Xoá sub ảnh theo ID
    public function delete_sub_image($id) {
        $this->db->where('id', $id)->delete('company_profile_images');
    }

    // Cập nhật bài viết
    public function update_company_profile($id, $data) {
        return $this->db->where('id', $id)->update('company_profile', $data);
    }

    // Xóa bài viết
    public function delete_company_profile($id) {
        return $this->db->delete('company_profile', array('id' => $id));
    }

    // Lấy 1 bài viết theo ID
    public function get_company_profile($id) {
        return $this->db->get_where('company_profile', array('id' => $id))->row();
    }

    public function get_all() {
        return $this->db->order_by('created_at', 'DESC')->get('company_profile')->result();
    }
    public function has_profile()
    {
        return $this->db->count_all('company_profile') > 0;
    }

}
?>
