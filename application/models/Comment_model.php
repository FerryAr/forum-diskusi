<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Comment_model extends CI_Model {
                        
public function getComment($id){
    $query = $this->db->select('comment.id, comment.id_reply, comment.isi, comment.created_at, users.first_name')
            ->from('comment')
            ->join('users', 'users.id = comment.id_user', 'left')
            ->where('id_reply', $id)
            ->where('parent_id =', NULL)
            ->get()
            ->result();
    return $query;
}
public function getSubComment($id, $id_parent)
{
    $query = $this->db->select('comment.id, comment.id_reply, comment.isi, comment.created_at, users.first_name')
                ->from('comment')
                ->join('users', 'users.id = comment.id_user', 'left')
                ->where('id_reply', $id)
                ->where('parent_id', $id_parent)
                ->get()
                ->result();
    return $query;
}
}

/* End of file Comment.php */
