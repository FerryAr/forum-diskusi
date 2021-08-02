<?= $layout ?>
<?php
    /*$hidden = [
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
];*/
$CI =& get_instance();
$CI->load->model('reply_model');

?>
<div id='preloader'>
<div id='container' class='spinner'>
  <div id='dot'></div>
    <div class='step' id='s1'></div>
    <div class='step' id='s2'></div>
    <div class='step' id='s3'></div>
</div>
</div>
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
<div id="error"></div>
<?php if($this->ion_auth->logged_in()) { ?>
<div style="margin-left:auto" class="mt-3">
	<button id="displayReply" class="btn btn-primary btn-md text-center">Buat Reply</button>
</div>
<?php } ?>
<div style="display:none" class="mt-3" id="createReply">
<div class="container">
        <input type="hidden" id="csrf" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $csrf_hash ?>"/>
        <textarea id="isi" class="form-control mb-3" name="isi"></textarea>
        <button id="create" class="btn btn-secondary btn-md">Submit</button>
    </div>
</div>
</div>
<hr/>
    <h1 class="text-center">REPLY</h1>
    <hr>
    <div id="reply" class="text-center">
        <button id="show" class="btn btn-primary btn-md mt-3 mb-3">Tampilkan Komentar</button>
    </div>

    <script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
    <script>
	$(document).ready(function () {
        $("#preloader").fadeOut();
        $("#displayReply").click(function() {
            $("#createReply").toggle("slow");
        });
        $('#create').click(function (e) { 
            e.preventDefault();
            let isi = $('#isi').val();
            if($.trim(isi).length == 0) {
                err = "Isi Komen dulu ngab";
                $('#error').text(err);
            } else {
                err = '';
                $('#error').text(err);
            }

            if (err != '') {
                return false;
            } else {
                let csrfName = $('#csrf').attr("name");
                let csrfHash = $('#csrf').val();
                let data = {
                    [csrfName]: csrfHash,
                    'id_thread': <?= $thread->id ?>,
                    'isi': isi,
                };
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('reply/create') ?>",
                    data: data,
                    success: function (response) {
                        
                        load_comment();
                    }
                });
            }
        });
        function load_comment() {
            $.ajax({
                type: "POST",
                url: "<?= base_url('reply/read') ?>",
                data: {
                    '<?= $this->security->get_csrf_token_name() ?>': '<?= $csrf_hash ?>',
                    'show_reply': true,
                    'id': <?= $thread->id ?>,
                },
                success: function (response) {
                    $('#reply').html("");
                    $.each(response, function (key, value) {
                        console.log(value);
                        $('#reply').append('<div id="begin" class="container card mb-3" style="margin-top:10px">\
                            <div class="card-body">\
                                <div class="flex-container">\
                                    <div style="text-align:center">\
                                    <img style="width:50px" src="<?= base_url('assets/images/avatars/')?>'+value.avatar+'"></img><br/>\
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
                                    <button value="'+value.id+'" id="view_reply" class="btn btn-info btn-sm">Lihat Balasan</button>\
                                </div>\
                            <?php endif; ?>
                                </div>\
                                <div id="after">\
                                </div>\
                                <div id="sub"></div>\
                            </div>\
                        ');
                    });
                },
                error : function(jqXHR,textStatus,errorThrown) {
                    console.log(textStatus);
                }
            });
        }
        $(document).on('click','#show', function () {
                load_comment();
            });
        $(document).on('click', '#displaySubReply', function() {
            let click = $(this);
            let id = click;

            $('#after').html('');
            click.closest('#begin').find('#view_reply').prop('disabled', false);
            click.closest('#begin').find('#sub').html('');
            click.closest('#begin').find('#after').html('\
                <input type="text" class="form-control my-2" id="isi_balasan" placeholder="Balas">\
                    <div class="text-end mb-4 mt-3">\
                    <button class="btn btn-sm btn-primary" id="btn_tambah_reply">Reply</button>\
                    <button class="btn btn-sm btm-danger cancel" id="cancel_reply">Cancel</button>\
                    </div>\
            ');
            $(document).on('click', '.cancel', function () {
            let click = $(this);
            let id = click;
            $('#after').append('');
            click.closest('#begin').find('#after').html('');
        });
        });
        // $(document).on('click', '#cancel_reply', function () {
        //     let click = $(this);
        //     let id = click;
        //     $('#after').append('');
        //     click.closest('#begin').find('#after').append('');
        // });
        $(document).on('click', '#btn_tambah_reply', function (e) {
            e.preventDefault();
            let click = $(this);
            let id = click.closest('#begin').find('#displaySubReply').val();
            let isi = click.closest('#begin').find('#isi_balasan').val();
            let data = {
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $csrf_hash ?>',
                'id': id,
                'isi':isi,
                'add_reply': true,
            };
            $.ajax({
                type: "POST",
                url: "<?= base_url('comment/create') ?>",
                data: data,
                success: function (response) {
                    alert(response);
                }
            });
        });
        /*function load_subcomment() {
            let id = $('#view_reply').val();
            let data = {
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $csrf_hash ?>',
                'id': id,
                'show_sub_reply': true,
            };
            $('#sub').append('');
            $.ajax({
                type: "POST",
                url: "<?= base_url('comment/read') ?>",
                data: data,
                success: function (response) {
                    $('#view_reply').hide();
                    $.each(response, function (key, value) {
                        $("#sub").append('<div class="container card mb-3" style="margin-top:10px; width:45%;margin-left:50%">\
                            <div class="card-body">\
                                <div class="card-body">\
                                <div class="flex-container">\
                                    <div style="text-align:center">\
                                        <small><strong>'+value.first_name+'</strong></small><br>\
                                        <small>'+value.created_at+'</small>\
                                    </div>\
                                <div id="isi" style="margin-left:30px" class="mt-3">\
                                    '+value.isi+'\
                                </div>\
                            </div>\
                            <?php if($this->ion_auth->logged_in()):?>
                                <div class="float-start mt-2 mb-2">\
                                    <button id="displaySubReply" class="btn btn-secondary btn-sm">Balas</button>\
                                </div>\
                            <?php endif; ?>
                                </div>\
                                <div id="after">\
                                </div>\
                            </div>\
                            </div>\
                            </div>\
                            ');
                    });
                }
            });
        }*/
        $(document).on('click', '#view_reply', function() {
            let click = $(this);
            let id = click.val();

            let data = {
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $csrf_hash ?>',
                'id': id,
                'show_sub_reply': true,
            };
            click.closest('#begin').find('#sub').html('');
            $.ajax({
                type: "POST",
                url: "<?= base_url('comment/read') ?>",
                data: data,
                success: function (response) {
                    click.prop('disabled', true);
                    click.closest('#begin').find('#after').html('');
                    $.each(response, function (key, value) {
                        click.closest('#begin').find('#sub').append('<div class="container card mb-3" style="margin-top:10px; width:45%;margin-left:50%">\
                                <div class="card-body">\
                                <div class="flex-container">\
                                    <div style="text-align:center">\
                                    <img style="width:50px" src="<?= base_url('assets/images/avatars/')?>'+value.avatar+'"></img><br/>\
                                        <small><strong>'+value.first_name+'</strong></small><br>\
                                        <small>'+value.created_at+'</small>\
                                    </div>\
                                <div id="isi" style="margin-left:30px" class="mt-3">\
                                    '+value.isi+'\
                                </div>\
                            </div>\
                            <?php if($this->ion_auth->logged_in()):?>
                                <div class="float-start mt-2 mb-2">\
                                    <button id="displaySubsubReply" class="btn btn-secondary btn-sm btn-rep">Balas</button>\
                                </div>\
                            <?php endif; ?>
                                </div>\
                                <div id="aftersub">\
                                </div>\
                            </div>\
                            </div>\
                            </div>\
                            ');
                            
                    });
                }
            });
        });
        $(document).on('click', '.btn-rep', function() {
            let click = $(this);
            let id = click;

            $('#aftersub').append('');
            click.parent().parent().parent().find('#aftersub').html('\
                <input type="text" class="form-control my-2" id="isi_balasbalasan" placeholder="Balas">\
                    <div class="text-end mb-4 mt-3">\
                    <button class="btn btn-sm btn-primary" id="btn_tambah_subreply">Reply</button>\
                    <button class="btn btn-sm btm-danger" id="cancel_subreply">Cancel</button>\
                    </div>\
            ');
        });
        $(document).on('click', '#cancel_subreply', function () {
            let click = $(this);
            let id = click;
            $('#aftersub').append('');
            click.parent().parent().parent().find('#aftersub').html('');
        });
        $(document).on('click', '#btn_tambah_subreply', function (e) {
            e.preventDefault();
            let click = $(this);
            let id = click.closest('#begin').find('#displaySubReply').val();
            let isi = click.closest('#begin').find('#isi_balasbalasan').val();
            let data = {
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $csrf_hash ?>',
                'id': id,
                'isi':isi,
                'add_reply': true,
            };
            $.ajax({
                type: "POST",
                url: "<?= base_url('comment/create') ?>",
                data: data,
                success: function (response) {
                    alert(response);
                }
            });
        });
    });
    </script>
</body>
</html>
