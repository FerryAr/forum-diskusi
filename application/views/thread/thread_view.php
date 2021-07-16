<?= $layout ?>
<?php
    $hidden = [
        'id_thread' => $thread->id,
        'id_user' => $user[0]->id,
    ];
$hidden_data = [
    'id_thread' => $thread->id,
    'id_user' => $this->ion_auth->get_user_id(),
    'created_at' => date('Y-m-d H:i:s'),
    'created_by' => $this->ion_auth->get_user_id(),
];
$isi = [
    'name' => 'isi',
    'id' => 'isi',
    'class' => 'form-control ckeditor',
];
$submit = [
    'name' => 'submit',
    'value' => 'Submit',
    'type' => 'submit',
    'class' => 'btn btn-secondary mt-3'
];
$isi_balasan = [
    'name' => 'isi',
    'id' => 'isi_balasan',
    'class' => 'form-control ckeditor',
];
$isi_balasbalasan = [
    'name' => 'isi',
    'id' => 'isi_balasbalasan',
    'class' => 'form-control ckeditor',
];
$submit = [
    'name' => 'submit',
    'value' => 'Submit',
    'type' => 'submit',
    'class' => 'btn btn-secondary mt-3'
];
$CI =& get_instance();
$CI->load->model('reply_model');
?>
<div class="container">
<div class="card mt-3">
    <h1 class="card-title mt-3" style="text-align:center"><?= $thread->judul ?></h1>
    <hr class="mb-auto"/>
    <div class="card-body">
        <?php if($thread->created_by == $this->ion_auth->get_user_id() || $this->ion_auth->is_admin()):?>
        <div class="float-end">
                <a href="<?= base_url('thread/update/'.$thread->id) ?>"><i class="far fa-edit"></i></a>
                |
                <a href="<?= base_url('thread/delete/'.$thread->id) ?>"><i class="far fa-trash-alt"></i></a>
        </div>
        <br/><br/>
        <?php endif; ?>
    <?= $thread->isi ?>
    <small>
        <br/>
        <span class="float-start">Created by <a href="<?= base_url('user/view/'.$user[0]->id)?>"><?= $user[0]->first_name?></a> on <?= $pelajaran->pelajaran ?> at <?= $thread->created_at ?></span>
        <?php if (!empty($thread->updated_by)):
        ?>
        <span class="float-end">Updated by <a href="<?= base_url('user/view/'.$user_update[0]->id)?>"><?= $user_update[0]->first_name?></a> at <?= $thread->updated_at ?>. Alasan : <?= $thread->reason ?></span><br/>
        <?php endif; ?>
    </small>
        </div>

</div>
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
<script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
    <script src="<?= base_url('assets/ckeditor/ckeditor.js')?>"></script>
    <script>
		$(document).ready(function() {
			$("#displayReply").click(function() {
				$("#createReply").toggle("slow");
			});
		});
        CKEDITOR.replace( 'isi', {
            height: 300,
            filebrowserUploadUrl: '<?php echo base_url('reply/upImage') ?>'
        });
        $(document).ready(function() {
			$("#displaySubReply").click(function() {
				$("#createSubReply").toggle("slow");
			});
		});
        CKEDITOR.replace( 'isi_balasan', {
            height: 300,
            filebrowserUploadUrl: '<?php echo base_url('reply/upImage') ?>'
        });
        $(document).ready(function() {
			$("#displaySubSubReply").click(function() {
				$("#createSubSubReply").toggle("slow");
			});
		});
        CKEDITOR.replace( 'isi_balasbalasan', {
            height: 300,
            filebrowserUploadUrl: '<?php echo base_url('reply/upImage') ?>'
        });
    </script>
</body>
</html>
