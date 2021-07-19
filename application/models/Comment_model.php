<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Comment_model extends CI_Model {
                        
    public function getComment($id) {
        $query = $this->db->select('comment.id, comment.isi, comment.created_at, users.first_name ')
                ->from('comment')
                ->join('users', 'users.id = comment.id_user', 'left')
                ->where('id_reply', $id)
                ->get()->result_array();
        return $query;
    }
public function create($id_reply, $id_user, $isi, $created_at, $created_by)
{
    $data = array(
        'id_reply' => $id_reply,
        'id_user' => $id_user,
        'isi' => $isi,
        'created_at' => $created_at,
        'created_by' => $created_by,
    );
    $this->db->insert('comment', $data);
}

}

/* End of file Comment.php */
