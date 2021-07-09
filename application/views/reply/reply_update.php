<?= $layout ?>
<h1 class="text-center">Edit Reply</h1>
<?php
$hidden_data = [
    'updated_at' => date('Y-m-d H:i:s'),
    'updated_by' => $this->ion_auth->get_user_id(),
];
$isi = [
    'name' => 'isi',
    'id' => 'isi',
    'class' => 'form-control ckeditor',
    'value' => $reply->isi,
];
$submit = [
    'name' => 'submit',
    'value' => 'Submit',
    'type' => 'submit',
    'class' => 'button'
];    
    ?>
    <div class="container">
        <?= form_open_multipart('reply/edit/'.$reply->id) ?>
        <?= form_hidden($hidden_data) ?>

<?= form_textarea($isi) ?><br/>
<label for="reason">Alasan</label>
<input type="text" name="reason" id="reason">

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