<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reply_model extends CI_Model {
    public function getReply($id) {
        $query = $this->db->select('reply.id, reply.isi, reply.created_at, reply.updated_at, reply.reason, users.first_name, users.avatar ')
                ->from('reply', 'users')
                ->join('users', 'users.id = reply.id_user', 'left')
                ->where('id_thread', $id)
                ->get()->result_array();
        return $query;
    }
    public function getLatestReply($id)
    {
        $query = $this->db->select('reply.created_at, users.id AS user_id, users.first_name')
                ->from('reply')
                ->join('users', 'users.id = reply.id_user', 'left')
                ->where('id_thread', $id)
                ->order_by('reply.id', 'desc')
                ->limit(1)->get()->row();
        if(!$query) {
            $text = '';
        } else {
        $awal = strtotime($query->created_at);
        $akhir = time();
        $selisih = $akhir - $awal;
        $jam   = floor($selisih / (60 * 60));
        $menit = $selisih - ($jam * (60 * 60));
        $menit_proc = floor($menit / 60);
        $bulan = 1 + (date("Y",$akhir)-date("Y",$awal))*12;
        $bulan += date("m",$akhir)-date("m",$awal);
        $detik = $selisih % 60;
        if ($bulan > 1) {
            $text = '<p class="text-muted"><a href="'.base_url('user/view/'.$query->user_id).'">'.$query->first_name.'</a> membalas <span class="text-secondary fw-bold">'.$bulan.' bulan yang lalu</span></p>';
        }
        else if($jam > 24) {
            $hari = floor($selisih / (60 * 60 * 24));
            $text = '<p class="text-muted"><a href="'.base_url('user/view/'.$query->user_id).'">'.$query->first_name.'</a> membalas <span class="text-secondary fw-bold">'.$hari.' hari yang lalu</span></p>';
        }
        else if($jam < 24 && $jam > 0) {
            $text = '<p class="text-muted"><a href="'.base_url('user/view/'.$query->user_id).'">'.$query->first_name.'</a> membalas <span class="text-secondary fw-bold">'.$jam.' jam yang lalu</span></p>';
        } else if($jam < 1 && $menit_proc > 0) {
            $text = '<p class="text-muted"><a href="'.base_url('user/view/'.$query->user_id).'">'.$query->first_name.'</a> membalas <span class="text-secondary fw-bold">'.$menit_proc.' menit yang lalu</span></p>';
        } else if ($detik >= 1) {
            $text = '<p class="text-muted"><a href="'.base_url('user/view/'.$query->user_id).'">'.$query->first_name.'</a> membalas <span class="text-secondary fw-bold">'.$detik.' detik yang lalu</span></p>';
        } else {
            //
        }
    }
        return $text;
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