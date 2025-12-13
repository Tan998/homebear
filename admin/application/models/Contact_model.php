<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Contact_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // thêm dòng này để model load DB
    }

    // Lấy toàn bộ dữ liệu từ bảng contact
    public function get_all_contacts() {
        return $this->db->order_by('created_at', 'DESC')->get('contact')->result(); // SELECT * FROM contact
    }

    // Xoá liên hệ theo ID
    public function delete_contact($id) {
        return $this->db->where('id', $id)->delete('contact');
    }
}
