<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thread_model extends CI_Model {

    public function getThread($page, $keyword, $limit, $offset) {

        $query = $this->db->select('thread.id, thread.judul, pelajaran.pelajaran, users.first_name ')
                ->from('thread')
                ->join('pelajaran', 'thread.id_pelajaran = pelajaran.id', 'left')
                ->join('users', 'thread.created_by = users.id', 'left')
                ->like('thread.isi', $keyword)
                ->or_like('thread.judul', $keyword)
                ->limit($limit, $offset)
                ->get()->result();
        return $query;
    }
    public function getTotalThread($keyword) {
        $query = $this->db->select('thread.id, thread.judul, pelajaran.pelajaran, users.first_name ')
                    ->from('thread')
                    ->join('pelajaran', 'thread.id_pelajaran = pelajaran.id', 'left')
                    ->join('users', 'thread.created_by = users.id', 'left')
                    ->like('thread.isi', $keyword)
                    ->or_like('thread.judul', $keyword)
                    ->count_all_results();
        return $query;
    }

    public function findThreadById($id) {
        $query = $this->db->select('*')
                ->from('thread')
                ->where('id', $id)
                ->get()->row();
        return $query;
    }
    public function createThread($judul, $isi, $id_pelajaran, $created_by, $created_at) {
        $data = array (
            'judul' => $judul,
            'isi' => $isi,
            'id_pelajaran' => $id_pelajaran,
            'created_by' => $created_by,
            'created_at' => $created_at,
        );
        $this->db->insert('thread', $data);
    }
    public function updateThread($judul, $isi, $id_pelajaran, $updated_by, $update_at, $reason, $id) {
        $data = array (
            'judul' => $judul,
            'isi' => $isi,
            'id_pelajaran' => $id_pelajaran,
            'updated_by' => $updated_by,
            'updated_at' => $update_at,
            'reason' => $reason,
        );
        $this->db->where('id', $id);
        $this->db->update('thread', $data);
    }
    public function deleteThread($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('thread');
    }
}