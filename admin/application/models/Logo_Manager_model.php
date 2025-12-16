<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logo_Manager_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // lấy logo hiện tại
    public function get_setting() {
        return $this->db->get_where('company_logo_settings', ['id' => 1])->row_array();
    }

    // update logo chính được dùng trên homepage
    public function update_logo($filename) {

        $exists = $this->db->get_where('company_logo_settings', ['id' => 1])->row_array();

        if ($exists) {
            return $this->db->where('id', 1)->update('company_logo_settings', [
                'logo_filename' => $filename
            ]);
        }

        return $this->db->insert('company_logo_settings', [
            'id' => 1,
            'logo_filename' => $filename
        ]);
    }
}
