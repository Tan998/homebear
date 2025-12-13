<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HP_TopBackgroundIMG_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // đảm bảo DB được load
    }

    // Lấy cài đặt background hiện tại
    public function get_setting() {
        return $this->db->get_where('hp_background_settings', ['id' => 1])->row_array();
    }

    // Cập nhật ảnh lớn và nhỏ vào bảng setting
    public function update_setting($bg_lg, $bg_sm)
    {
        // Kiểm tra đã có row id=1 chưa
        $exists = $this->db->get_where('hp_background_settings', ['id' => 1])->row_array();

        if ($exists) {
            // UPDATE
            $this->db->where('id', 1);
            return $this->db->update('hp_background_settings', [
                'bg_lg_filename' => $bg_lg,
                'bg_sm_filename' => $bg_sm
            ]);
        } else {
            // INSERT
            return $this->db->insert('hp_background_settings', [
                'id' => 1,
                'bg_lg_filename' => $bg_lg,
                'bg_sm_filename' => $bg_sm
            ]);
        }
    }

    // Lưu riêng từng ảnh (nếu cần)
    public function update_bg_lg($file_name) {
        return $this->db->where('id', 1)->update('hp_background_settings', [
            'bg_lg_filename' => $file_name
        ]);
    }

    public function update_bg_sm($file_name) {
        return $this->db->where('id', 1)->update('hp_background_settings', [
            'bg_sm_filename' => $file_name
        ]);
    }

    // Lấy tên file ảnh đang dùng (phục vụ xoá file cũ nếu cần)
    public function get_bg_lg_filename() {
        $row = $this->db->select('bg_lg_filename')->where('id', 1)->get('hp_background_settings')->row();
        return $row ? $row->bg_lg_filename : null;
    }

    public function get_bg_sm_filename() {
        $row = $this->db->select('bg_sm_filename')->where('id', 1)->get('hp_background_settings')->row();
        return $row ? $row->bg_sm_filename : null;
    }
}
