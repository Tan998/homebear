<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Download_Materials_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // thêm dòng này để model load DB
    }

    // Lấy toàn bộ dữ liệu từ bảng
    public function get_all_download_materials() {
        return $this->db->order_by('submitted_at', 'DESC')->get('download_materials_form')->result(); // SELECT * FROM download_materials_form
    }

    // Xoá liên hệ theo ID
    public function delete_download_materials($id) {
        return $this->db->where('id', $id)->delete('download_materials_form');
    }
}
