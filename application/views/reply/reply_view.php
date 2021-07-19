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
<?php if($this->ion_auth->logged_in()) { ?>
<div style="margin-left:auto" class="mt-3">
	<button id="displayReply" class="btn btn-primary btn-md">Buat Reply</button>
</div>
<?php } ?>

<div style="display:none" class="mt-3" id="createReply">
<div class="container">
        <?= form_open_multipart('reply/create/'.$thread->id) ?>
        <?= form_hidden($hidden_data) ?>

<?= form_textarea($isi) ?>

            <?= form_submit($submit) ?>

        <?= form_close() ?>

    </div>
</div>
</div>
<hr/>
    <h1 class="text-center">REPLY</h1>
    <hr>
    <?php foreach($reply as $r): ?>
        <div class="container card mb-3" style="margin-top:10px">
        <div class="card-body">
            <div class="flex-container">
                <div style="text-align:center">
                    <small><strong><?= $r->first_name ?></strong></small><br>                
                    <small><?= $r->created_at ?></small>
                </div>
                <div style="margin-left:30px" class="mt-3">
                    <?= $r->isi ?>
                </div>
            </div>
            <?php if($this->ion_auth->logged_in()) { ?>
                <div class="float-start mx-2">
                    <button id="displaySubReply" class="btn btn-secondary btn-sm">Balas</button>
                    <div style="display:none" class="mt-3" id="createSubReply">
                        <?= form_open_multipart('reply/reply/'.$r->id) ?>
                            <?= form_hidden($hidden_data) ?>

                            <?= form_textarea($isi_balasan) ?>

                            <?= form_hidden('status', $r->id) ?>
                            
                            <?= form_submit($submit) ?>

                            <?= form_close() ?>

                        </div>
                    <?php if(!empty($reply_update->updated_at)) { ?>
                    <?php foreach($reply_update as $r_up): ?>
                        <small> | Updated by <a href="<?= base_url('user/view/'.$r_up->id)?>"></a><?= $r_up->first_name ?> at <?= $r_up->updated_at ?>. Alasan : <?= $r_up->reason ?></small>
                    <?php endforeach; ?>
                    <?php } ?>
                </div>
                <div class="float-end mx-2">
                    <a href="<?= base_url('reply/edit/'.$r->id) ?>" style="color:#3498db" >Edit</a>
                    <a href="<?= base_url('reply/delete/'.$r->id.'/'.$thread->id) ?>" style="color:#c0392b">Delete</a>
                </div>
        <?php } ?>
            </div>
        </div>
        <?php 
            foreach($CI->reply_model->getSubReply($r->id, $thread->id) as $balasan):
        ?>
        <div class="container">
            <div class="card mb-3" style="margin-top:10px; margin-left:40%;">
                <div class="card-body">
                    <div class="flex-container">
                        <div class="text-center">
                            <small><strong> <?= $balasan->first_name ?></strong></small><br/>
                            <small><?= $balasan->created_at ?></small>
                        </div>
                        <div style="margin-left:30px" class="mt-3">
                            <?= $balasan->isi ?>
                        </div>
                    </div>
                    <?php if($this->ion_auth->logged_in()) { ?>
                <div class="float-start mx-2">
                    <button id="displaySubSubReply" class="btn btn-secondary btn-sm">Balas</button>
                    <div style="display:none" class="mt-3" id="createSubSubReply">
                        <?= form_open_multipart('reply/reply/'.$balasan->id) ?>
                            <?= form_hidden($hidden_data) ?>

                            <?= form_textarea($isi_balasbalasan) ?>

                            <?= form_hidden('status', $balasan->id) ?>
                            
                            <?= form_submit($submit) ?>

                            <?= form_close() ?>

                        </div>
                    <?php if(!empty($reply_update->updated_at)) { ?>
                    <?php foreach($reply_update as $r_up): ?>
                        <small> | Updated by <a href="<?= base_url('user/view/'.$r_up->id)?>"></a><?= $r_up->first_name ?> at <?= $r_up->updated_at ?>. Alasan : <?= $r_up->reason ?></small>
                    <?php endforeach; ?>
                    <?php } ?>
                </div>
                <div class="float-end mx-2">
                    <a href="<?= base_url('reply/edit/'.$balasan->id) ?>" style="color:#3498db" >Edit</a>
                    <a href="<?= base_url('reply/delete/'.$balasan->id.'/'.$thread->id) ?>" style="color:#c0392b">Delete</a>
                </div>
        <?php } ?>
                </div>
            </div>
        </div>
        <?php
            foreach($CI->reply_model->getSubReply($balasan->id, $thread->id) as $balasanbalas):
        ?>
        <div class="container">
            <div class="card mb-3" style="margin-top:10px; margin-left:50%;">
                <div class="card-body">
                    <div class="flex-container">
                        <div class="text-center">
                            <small><strong> <?= $balasanbalas->first_name ?></strong></small><br/>
                            <small><?= $balasanbalas->created_at ?></small>
                        </div>
                        <div style="margin-left:30px" class="mt-3">
                            <?= $balasanbalas->isi ?>
                        </div>
                    </div>
                    <?php if($this->ion_auth->logged_in()) { ?>
                <div class="float-start mx-2">
                    <button id="displayComment" class="btn btn-secondary btn-sm">Balas</button>
                    <?php if(!empty($reply_update->updated_at)) { ?>
                    <?php foreach($reply_update as $r_up): ?>
                        <small> | Updated by <a href="<?= base_url('user/view/'.$r_up->id)?>"></a><?= $r_up->first_name ?> at <?= $r_up->updated_at ?>. Alasan : <?= $r_up->reason ?></small>
                    <?php endforeach; ?>
                    <?php } ?>
                </div>
                <div class="float-end mx-2">
                    <a href="<?= base_url('reply/edit/'.$balasan->id) ?>" style="color:#3498db" >Edit</a>
                    <a href="<?= base_url('reply/delete/'.$balasan->id.'/'.$thread->id) ?>" style="color:#c0392b">Delete</a>
                </div>
        <?php } ?>
                </div>
            </div>
        </div>
        <?php
            endforeach;
        ?>
        <?php
            endforeach;
        ?>
    <?php endforeach; ?>




    <div id="begin" class="container card mb-3" style="margin-top:10px">\
                            <div class="card-body">\
                                <div class="flex-container">\
                                    <div style="text-align:center">\
                                        <small><strong>'+value.first_name+'</strong></small><br>\
                                        <small>'+value.created_at +'</small>\
                                    </div>\
                                <div id="isi" style="margin-left:30px" class="mt-3">\
                                    '+value.isi+'\
                                </div>\
                            </div>\
                            <?php if($this->ion_auth->logged_in()):?>
                                <div class="float-start mt-2 mb-2">\
                                    <button value="'+value.id+'" id="displaySubReply" class="btn btn-secondary btn-sm">Balas</button>\
                                </div>\
                            <?php endif; ?>
                                </div>\
                                <div id="after">\
                                </div>\
                            </div>\


                            <div class="reply_box border p-2 mb-2">\
                        <h6 class="border-bottom d-inline">'+value.first_name+'</h6>\
                        <p class="para">'+value.isi+'</p>\
                        <button value="'+value.isi+'" class="badge btn-warning text-dark reply_btn">Reply</button>\
                        <div class="ml-4 reply_section">\
                        </div>\
                        </div>\