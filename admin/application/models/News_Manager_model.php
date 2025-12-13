<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class News_Manager_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->order_by('publish_date', 'DESC')
                        ->get('news')
                        ->result();
    }

    public function insert($title, $content, $publish_date) {
        return $this->db->insert('news', [
            'news_title'   => $title,
            'news_content' => $content,
            'publish_date' => $publish_date
        ]);
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('news')->row();
    }

    public function update($id, $title, $content, $publish_date) {
        return $this->db->where('id', $id)
                        ->update('news', [
                            'news_title'   => $title,
                            'news_content' => $content,
                            'publish_date' => $publish_date
                        ]);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('news');
    }
}
