<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Video_Manager_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->order_by('created_at', 'DESC')
                        ->get('youtube_videos')
                        ->result();
    }

    public function insert($youtube_id,$video_title,  $status = 0) {
        $data = array(
            'youtube_id' => $youtube_id,
            'title' => $video_title,
            'status'     => $status,
        );
        return $this->db->insert('youtube_videos', $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('youtube_videos');
    }

    public function toggle_status($id) {
        // Lấy video hiện tại
        $video = $this->db->where('id', $id)->get('youtube_videos')->row();
        if (!$video) return false;

        // Nếu chuyển sang HIỂN THỊ
        if ($video->status == 0) {

            // 1) Set tất cả về 0
            $this->db->set('status', 0)->update('youtube_videos');

            // 2) Chỉ bật video được chọn
            return $this->db->where('id', $id)->update('youtube_videos', [
                'status' => 1
            ]);
        }

        // Nếu video hiện tại đang hiển thị → chuyển về 0
        return $this->db->where('id', $id)->update('youtube_videos', [
            'status' => 0
        ]);
    }
}
