<?= $layout ?>
<h1>Reply untuk thread : <?= $thread->judul ?></h1>
<?php
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
    'class' => 'button'
];    
    ?>
    <div class="container">
        <?= form_open_multipart('reply/create/'.$thread->id) ?>
        <?= form_hidden($hidden_data) ?>

<?= form_textarea($isi) ?>

            <?= form_submit($submit) ?>

        <?= form_close() ?>

    </div>
    <script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
    <script src="<?= base_url('assets/ckeditor/ckeditor.js')?>"></script>
    <script>
        CKEDITOR.replace( 'isi', {
            height: 300,
            filebrowserUploadUrl: '<?php echo base_url('reply/upImage') ?>'
        });
    </script>
</body>
</html>