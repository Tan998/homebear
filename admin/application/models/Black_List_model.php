<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Black_List_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function exists($ip)
    {
        return $this->db->where('ip', $ip)
                        ->count_all_results('black_list_ip') > 0;
    }
    public function insert($data) {
        return $this->db->insert('black_list_ip', $data);
    }

    public function delete($ip) {
        return $this->db->delete('black_list_ip', ['ip' => $ip]);
    }

    public function get($ip) {
        return $this->db->get_where('black_list_ip', ['ip' => $ip])->row();
    }

    public function get_all() {
        return $this->db->order_by('blocked_at', 'DESC')
                        ->get('black_list_ip')
                        ->result();
    }
}
?>
