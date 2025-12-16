<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Company_Profile_Ver2_model extends CI_Model {


    public function insert_profile($data) {
        $this->db->insert('company_profile_ver2', $data);
        return $this->db->insert_id();
    }

    public function update_profile($id, $data) {
        return $this->db->where('id', $id)->update('company_profile_ver2', $data);
    }

    public function get($id) {
        return $this->db->get_where('company_profile_ver2', ['id' => $id])->row();
    }

    public function get_all() {
        return $this->db->order_by('created_at', 'DESC')->get('company_profile_ver2')->result();
    }

    // FIELDS
    public function insert_field($id, $data) {
        $data['company_profile_id'] = $id;
        return $this->db->insert('company_profile_fields_ver2', $data);
    }

    public function get_fields($id) {
        return $this->db->order_by('sort_order ASC')->get_where('company_profile_fields_ver2', [
            'company_profile_id' => $id
        ])->result();
    }

    public function delete_all_fields($id) {
        return $this->db->delete('company_profile_fields_ver2', ['company_profile_id' => $id]);
    }

    // IMAGES
    public function insert_image($id, $file) {
        return $this->db->insert('company_profile_images_ver2', [
            'company_profile_id' => $id,
            'file_name' => $file
        ]);
    }

    public function delete_images_by_profile($profile_id)
    {
        return $this->db
            ->where('company_profile_id', $profile_id)
            ->delete('company_profile_images_ver2');
    }

    public function get_images($id) {
        return $this->db->get_where('company_profile_images_ver2', ['company_profile_id' => $id])->result();
    }

    public function has_profile()
    {
        return $this->db->count_all('company_profile_ver2') > 0;
    }

    public function get_first_profile()
    {
        return $this->db->order_by('id', 'ASC')->limit(1)->get('company_profile_ver2')->row();
    }
}
?>
