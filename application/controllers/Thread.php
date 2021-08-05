<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thread extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('thread_model');
        $this->load->model('pelajaran_model');
        $this->load->model('reply_model');
        $this->load->model('comment_model');
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper('url');
        $this->load->library('pagination');
    }
    public function index() {
        $page = 1;
        $keyword = '';

        $perPage = 20;

        $limit = $perPage;
        $offset = ($page-1)*$perPage;
        if ($this->input->get('page')) {
            $page = $this->input->get('page');
        }
        if ($this->input->post('keyword')) {
            $keyword = $this->input->post('keyword');
        }
        $pel = '';
        if ($this->input->get('pelajaran')) {
            $pel = $this->input->get('pelajaran');
        }
        $pelajaran = $this->pelajaran_model->showPel();
        foreach($pelajaran as $p) {
            $arrayPel[$p->id] = $p->pelajaran;
        }
        $thread = $this->thread_model->getThread($page, $keyword, $limit, $offset);
        $thread2 = $this->thread_model->getThreadbyPel($page, $pel, $limit, $offset);
        $data = array (
            'pesan' => $this->session->flashdata('pesan'),
            'threads' => $thread,
            'arrayPel' => $arrayPel,
            'thread2' => $thread2,
            'total' => $this->thread_model->getTotalThread($keyword),
            'page' => $page,
            'perPage' => $perPage,
            'offset' => $offset,
            'keyword' => $keyword,
            'layout' => $this->load->view('layout', NULL, TRUE),
        );
        $this->load->view('thread/thread_index', $data);
    }
    public function view() {
        $id = $this->uri->segment(3);
        $thread = $this->thread_model->findThreadById($id);
        if(empty($id)) {
            redirect('404');
        } else if (is_null($thread)) {
            redirect('404');
        }

        $pelajaran = $this->pelajaran_model->findPelById($thread->id_pelajaran);
        $user = $this->ion_auth->user($thread->created_by)->result();
        $user_update = $this->ion_auth->user($thread->updated_by)->result();
        //if(!empty($reply)) {
        //foreach ($reply as $r) {
            //$comment = $this->comment_model->getComment($r->id);
        //foreach ($comment as $c) {
            //$subComment = $this->comment_model->getSubComment($r->id, $c->id);
        //}
        //}
        
    //}
        $data = array (
            'thread' => $thread,
            'pelajaran' => $pelajaran,
            'user' => $user,
            'user_update' => $user_update,
            'layout' => $this->load->view('layout', NULL, TRUE),
        );
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        /*if(!empty($reply)) {
            if(!empty($comment)) {
                $data['comment'] = $comment;
            }
            if(!empty($subComment)) {
                $data['subComment'] = $subComment;
            }
        }*/
        $this->add_count($id);
        $this->load->view('thread/thread_view', $data);
    }
    public function create() {
        if ($this->input->post()) {
            $judul = $this->input->post('judul', TRUE);
            $id_pelajaran = $this->input->post('id_pelajaran', TRUE);
            $isi = $this->input->post('isi', TRUE);
            $created_by = $this->ion_auth->get_user_id();
            $created_at = date('Y-m-d H:i:s');
            $this->thread_model->createThread($judul, $isi, $id_pelajaran, $created_by, $created_at);
            $id = $this->db->insert_id();

            return redirect(base_url('thread/view/'.$id));
        }
        $pelajaran = $this->pelajaran_model->showPel();
        foreach($pelajaran as $p) {
            $arrayPel[$p->id] = $p->pelajaran;
        }
        $data = array (
            'layout' => $this->load->view('layout', NULL, TRUE),
            'arrayPel' => $arrayPel,
        );
        $this->load->view('thread/thread_create', $data);
    }
    public function update($id)
    {
        $id = $this->uri->segment(3);
        $thread = $this->thread_model->findThreadById($id);
        if ($this->input->post()) {
            $judul = $this->input->post('judul');
            $id_pelajaran = $this->input->post('id_pelajaran');
            $isi = $this->input->post('isi');
            $updated_by = $this->ion_auth->get_user_id();
            $updated_at = date('Y-m-d H:i:s');
            $reason = $this->input->post('reason');
            $this->thread_model->updateThread($judul, $isi, $id_pelajaran, $updated_by, $updated_at, $reason, $id);
            
            return  redirect(base_url('thread/view/'.$id));
        }
        $pelajaran = $this->pelajaran_model->showPel();
        foreach ($pelajaran as $p) {
            $arrayPel[$p->id] = $p->pelajaran;
        }
        $pelajaran = $this->pelajaran_model->findPelById($thread->id_pelajaran);
        $data = array(
            'layout' => $this->load->view('layout', NULL, TRUE),
            'thread' => $thread,
            'pelajaran' => $pelajaran->id,
            'arrayPel' => $arrayPel,
        );
        $this->load->view('thread/thread_update', $data);
    }

    public function delete($id)
    {
        $id = $this->uri->segment(3);
        $q = $this->thread_model->deleteThread($id);
        $this->session->set_flashdata('pesan', 'Data berhasil dihapus');
        redirect(base_url('thread'));
        
    }
    function add_count($id)
    {
        $this->load->helper('cookie');
        $check_visitor = $this->input->cookie(urldecode($id), FALSE);
        $ip = $this->input->ip_address();
        if ($check_visitor == false) {
            $cookie = array("name" => urldecode($id), "value" => "$ip", "expire" => time() + 7200, "secure" => false);
            $this->input->set_cookie($cookie);
            $this->thread_model->update_counter(urldecode($id));
        }
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
                move_uploaded_file($file, './assets/images/thread/' . $new_image_name);
                $function_number = $_GET['CKEditorFuncNum'];
                $url = base_url().'assets/images/thread/' . $new_image_name;
                $message = 'Paste url image ke tab Image Info : ';
                echo "<script>alert('".$message.$url."');</script>";
            }
        }
    }
}