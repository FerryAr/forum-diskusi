<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Pesan_model extends CI_Model {
                        
public function inbox($id_penerima) {
    $query = $this->db->select('users.first_name AS nama, pesan.subject, pesan.pesan, pesan.id AS pesan_id, pesan.created AS pesan_created, pesan.is_read')
            ->from('pesan')
            ->join('users', 'users.id=pesan.id_pengirim', 'left')
            ->where('id_penerima', $id_penerima)
            ->get()->result();
    return $query;
}
public function outbox($id_pengirim)
{
    $query = $this->db->select('users.first_name AS nama, pesan.subject, pesan.pesan, pesan.id AS pesan_id, pesan.created AS pesan_created, pesan.is_read')
            ->from('pesan')
            ->join('users', 'users.id=pesan.id_penerima', 'left')
            ->where('id_pengirim', $id_pengirim)
            ->get()->result();
    return $query;
}
public function getPesanById($id)
{
    $query = $this->db->select('*')
                ->from('pesan')
                ->where('id', $id)
                ->get()->row();
    return $query;
    
}
public function createPesan($id_pengirim, $id_penerima, $subject, $pesan)
{
    $data = array(
        'id_pengirim' => $id_pengirim,
        'id_penerima' => $id_penerima,
        'subject' => $subject,
        'pesan' => $pesan,
    );
    $this->db->insert('pesan', $data);
}
}
                        
/* End of file Pesan.php */
    
                        