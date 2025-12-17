<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /* =============================
        CATEGORY
    ============================== */

    public function get_categories() {
        return $this->db
            ->order_by('sort_order', 'ASC')
            ->get('project_categories')
            ->result();
    }

    public function get_category_by_key($key) {
        return $this->db
            ->where('category_key', $key)
            ->get('project_categories')
            ->row();
    }
    public function get_category_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('project_categories')
            ->row();
    }
    /* =============================
        PROJECT ITEMS
    ============================== */

    public function get_projects_by_category($category_id) {
        return $this->db
            ->where('category_id', $category_id)
            ->order_by('sort_order', 'ASC')
            ->get('project_items')
            ->result();
    }

    public function get_project($id) {
        return $this->db->where('id', $id)->get('project_items')->row();
    }

    public function insert_project($data) {
        $this->db->insert('project_items', $data);
        return $this->db->insert_id();
    }

    public function update_project($id, $data) {
        return $this->db->where('id', $id)->update('project_items', $data);
    }

    public function delete_project($id) {
        return $this->db->where('id', $id)->delete('project_items');
    }

    public function update_sort($ids) {
        foreach ($ids as $index => $id) {
            $this->db->where('id', $id)->update('project_items', [
                'sort_order' => $index
            ]);
        }
    }

    /* =============================
        SETTINGS
    ============================== */

    public function get_settings() {
        return $this->db->where('id', 1)->get('project_settings')->row();
    }

    public function update_settings($data) {
        return $this->save_settings($data);
    }
    public function save_settings($data)
    {
        $exists = $this->db
            ->where('id', 1)
            ->count_all_results('project_settings');

        if ($exists == 0) {
            $data['id'] = 1;
            return $this->db->insert('project_settings', $data);
        }

        return $this->db
            ->where('id', 1)
            ->update('project_settings', $data);
    }

}
