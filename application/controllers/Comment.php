<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Comment extends CI_Controller {

public function __construct()
{
    parent::__construct();
    $this->load->model('thread_model');
    $this->load->model('reply_model');
    $this->load->model('comment_model');
    $this->load->database();
    $this->load->library(['ion_auth', 'form_validation']);
    $this->load->helper('url');
}

public function create()
{
    if($this->input->post('add_reply')) {
        $id_reply = $this->input->post('id');
        $id_user = $this->ion_auth->get_user_id();
        $isi = $this->input->post('isi');
        $created_at = date("Y-m-d H:i:s");
        $created_by = $this->ion_auth->get_user_id();
        $this->comment_model->create($id_reply, $id_user, $isi, $created_at, $created_by);

        echo "Komen berhasil ditambahkan";
    }
    else {
        echo "Kosong lek";
    }
}
public function read()
{
    if($this->input->post('show_sub_reply')) {
        $arrReply = [];
        $id = $this->input->post('id');
        $comment = $this->comment_model->getComment($id);
        foreach($comment as $c) {
            $id = $c['id'];
            $first_name = $c['first_name'];
            $created_at = $c['created_at'];
            $isi = $c['isi'];

            array_push($arrReply, ['id' => $id, 'first_name' => $first_name, 'created_at' => $created_at, 'isi' => $isi]);
        }
        header('Content-type: application/json');
        if(empty($arrReply)) {
            echo "Tidak ada balasan";
        }
        echo json_encode($arrReply);
    } else {
        redirect('404');
    }
}
        
}
        
    /* End of file  Comment.php */
        
                            