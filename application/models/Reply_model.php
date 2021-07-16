<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reply_model extends CI_Model {
    public function getReply($id) {
        $query = $this->db->select('reply.id, reply.isi, reply.created_at, users.first_name ')
                ->from('reply')
                ->join('users', 'users.id = reply.id_user', 'left')
                ->where('status =', NULL)
                ->where('id_thread', $id)
                ->get()
                ->result();
        return $query;
    }
    public function getReplyUpdate($id) {
        $query = $this->db->select('reply.id, reply.isi, reply.updated_at, reply.reason, users.first_name ')
                ->from('reply')
                ->join('users', 'users.id = reply.updated_by', 'left')
                ->where('id_thread', $id)
                ->get()
                ->result();
        return $query;
    }
    public function getSubReply($status, $id_thread)
    {
        $query = $this->db->select('reply.id, reply.isi, reply.created_at, users.first_name ')
                    ->from('reply')
                    ->join('users', 'users.id = reply.id_user', 'left')
                    ->where('status =', $status)
                    ->where('id_thread', $id_thread)
                    ->get()
                    ->result();
        return $query;
    }
    public function findReplyById($id) {
        $query = $this->db->select('*')
                ->from('reply')
                ->where('id', $id)
                ->get()->row();
        return $query;
    }
    public function createReply($id_thread, $id_user, $isi, $created_at, $created_by)
    {
        $data = array(
            'id_thread' => $id_thread,
            'id_user' => $id_user,
            'isi' => $isi,
            'created_at' => $created_at,
            'created_by' => $created_by,
            'status' => NULL,
        );
        $this->db->insert('reply', $data);
    }
    public function createSubReply($id_thread, $id_user, $isi, $created_at, $created_by, $status)
    {
        $data = array(
            'id_thread' => $id_thread,
            'id_user' => $id_user,
            'isi' => $isi,
            'created_at' => $created_at,
            'created_by' => $created_by,
            'status' => $status,
        );
        $this->db->insert('reply', $data);
    }
    public function updateReply($isi, $updated_at, $updated_by, $reason, $id)
    {
        $data = array(
            'isi' => $isi,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by,
            'reason' => $reason,
        );
        $this->db->where('id', $id);
        $this->db->update('reply', $data);
    }
    public function deleteReply($id) {
        $this->db->where('id', $id);
        $this->db->delete('reply');
    }
}