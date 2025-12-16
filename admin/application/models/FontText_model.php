<?php
class FontText_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->order_by("id", "ASC")->get("font_settings")->result();
    }

    public function save_font_settings($data) {
        return $this->db->insert("font_settings", $data);
    }

    public function delete($id) {
        return $this->db->where("id", $id)->delete("font_settings");
    }
}
