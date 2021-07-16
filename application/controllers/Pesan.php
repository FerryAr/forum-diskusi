<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Pesan extends CI_Controller {

public function __construct()
{
    parent::__construct();
    $this->load->model('pesan_model');
    $this->load->database();
    $this->load->library(['ion_auth', 'form_validation']);
    $this->load->helper('url');
}

public function inbox()
{
    if(!$this->ion_auth->logged_in()) {
        redirect('auth/login');
    }
    $id_penerima = $this->ion_auth->get_user_id();
    $pesan = $this->pesan_model->inbox($id_penerima);
    $data = array(
        'layout' => $this->load->view('layout', NULL, TRUE),
        'pesan' => $pesan,
    );
    $this->load->view('pesan/inbox', $data);
}
public function outbox()
{
    if(!$this->ion_auth->logged_in()) {
        redirect('auth/login');
    }
    $id_pengirim = $this->ion_auth->get_user_id();
    $pesan = $this->pesan_model->outbox($id_pengirim);
    $data = array(
        'layout' => $this->load->view('layout', NULL, TRUE),
        'pesan' => $pesan,
    );
    $this->load->view('pesan/outbox', $data);
}
public function view()
{
    if(!$this->ion_auth->logged_in()) {
        redirect('auth/login');
    }
    $id = $this->uri->segment(3);
    $pesan = $this->pesan_model->getPesanById($id);
    $pengirim = $this->ion_auth->user($pesan->id_pengirim)->row();
    $penerima = $this->ion_auth->user($pesan->id_penerima)->row();
    if($pesan->id_pengirim == $this->ion_auth->get_user_id() || $pesan->id_penerima == $this->ion_auth->get_user_id()) {
        //pass
    } else {
        redirect('404');
    }
    if($pesan->id_penerima == $this->ion_auth->get_user_id()) {
        $this->db->set('is_read', 1);
        $this->db->where('id', $id);
        $this->db->update('pesan');
    }
    $data = array(
        'layout' => $this->load->view('layout', NULL, TRUE),
        'pesan' => $pesan,
        'pengirim' => $pengirim,
        'penerima' => $penerima,
    );
    $this->load->view('pesan/pesan_view', $data);
    
}
public function create()
{
    if(!$this->ion_auth->logged_in()) {
        redirect('auth/login');
    }
    $id_penerima = $this->uri->segment(3);
    if(empty($id_penerima)) {
        redirect('404');
    }
    if($id_penerima == $this->ion_auth->get_user_id()) {
        redirect('pesan/inbox');
    }
    $penerima = $this->ion_auth->user($id_penerima)->row();

    if($this->input->post()) {
        $id_pengirim = $this->ion_auth->get_user_id();
        $subject = $this->input->post('subject');
        $pesan = $this->input->post('pesan');
        $this->pesan_model->createPesan($id_pengirim, $id_penerima, $subject, $pesan);
        redirect(base_url('pesan/outbox'));
    }
    $data = array(
        'layout' => $this->load->view('layout', NULL, TRUE),
        'penerima' => $penerima,
    );
    $this->load->view('pesan/pesan_create', $data);
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
            move_uploaded_file($file, './assets/images/pesan/' . $new_image_name);
            $function_number = $_GET['CKEditorFuncNum'];
            $url = base_url().'assets/images/pesan/' . $new_image_name;
            $message = 'Paste url image ke tab Image Info : ';
            echo "<script>alert('".$message.$url."');</script>";
        }
    }
}
}
        
    /* End of file  Pesan.php */
        
                            