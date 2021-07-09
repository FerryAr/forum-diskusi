<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Reply extends CI_Controller {

public function __construct()
{
    parent::__construct();
    $this->load->model('thread_model');
    $this->load->model('pelajaran_model');
    $this->load->model('reply_model');
    $this->load->database();
    $this->load->library(['ion_auth', 'form_validation']);
    $this->load->helper('url');
}

public function create($id_thread)
{
    $id_thread = $this->uri->segment(3);
    $thread = $this->thread_model->findThreadById($id_thread);
    if($this->input->post()) {
        $id_user = $this->ion_auth->get_user_id();
        $isi = $this->input->post('isi');
        $created_at = date('Y-m-d H:i:s');
        $created_by = $this->ion_auth->get_user_id();
        $this->reply_model->createReply($id_thread, $id_user, $isi, $created_at, $created_by);

        return redirect(base_url('thread/view/'.$id_thread));
    }
    $data = array (
        'thread' => $thread,
        'layout' => $this->load->view('layout', NULL, TRUE),
    );
    $this->load->view('reply/reply_create', $data);
}
public function edit($id)
{
    $id = $this->uri->segment(3);
    $reply = $this->reply_model->findReplyById($id);
    if($this->input->post()) {
        $isi = $this->input->post('isi');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->ion_auth->get_user_id();
        $reason = $this->input->post('reason');
        $this->reply_model->updateReply($isi, $updated_at, $updated_by, $reason, $id);
        return redirect(base_url('thread/view/'.$reply->id_thread));
    }
    $data = array(
        'reply' => $reply,
        'layout' => $this->load->view('layout', NULL, TRUE),
    );
    $this->load->view('reply/reply_update', $data);
}
public function delete($id, $id_thread)
{
    $id = $this->uri->segment(3);
    $id_thread = $this->uri->segment(4);
    $this->reply_model->deleteReply($id);
    return redirect(base_url('thread/view/'.$id_thread));
}
    public function upImage() {
        if(isset($_FILES['upload']['name'])){
            $file = $_FILES['upload']['tmp_name'];
            $file_name = $_FILES['upload']['name'];
            $file_name_array = explode(".", $file_name);
            $extension = end($file_name_array);
            $new_image_name = rand() . '.' . $extension;
            $allowed_extension = array("jpg", "jpeg", "png","PNG","JPEG","JPG");
            if(in_array($extension, $allowed_extension))
            {
                move_uploaded_file($file, './assets/images/reply/' . $new_image_name);
                $function_number = $_GET['CKEditorFuncNum'];
                $url = base_url().'assets/images/reply/' . $new_image_name;
                $message = 'Paste url image ke tab Image Info : ';
                echo "<script>alert('".$message.$url."');</script>";
            }
        }
    }
}
        
    /* End of file  Reply.php */
        
                            