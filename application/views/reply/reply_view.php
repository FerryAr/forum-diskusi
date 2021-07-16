<?php
$CI =& get_instance();
$CI->load->model('reply_model');
$hidden_data = [
    'id_thread' => $thread->id,
    'id_user' => $this->ion_auth->get_user_id(),
    'created_at' => date('Y-m-d H:i:s'),
    'created_by' => $this->ion_auth->get_user_id(),
];

?>
