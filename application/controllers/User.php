<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class User extends CI_Controller {

public function view()
{
    $id = $this->uri->segment(3);
    if(empty($id)) {
        redirect('404');
    }
    $data = array(
        'layout' => $this->load->view('layout', NULL, TRUE),
        'user' => $this->ion_auth->user($id)->row(),
    );
    $this->load->view('user/user_view', $data);
}
        
}
        
    /* End of file  User.php */
        
                            