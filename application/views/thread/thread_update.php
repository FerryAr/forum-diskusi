<?= $layout ?>
<h1>Update Postingan</h1>
<?php
    $judul = [
        'name' => 'judul',
    ];
    $isi = [
        'name' => 'isi',
        'id' => 'isi',
    ];
    $id_pelajaran = [
        'name' => 'id_pelajaran',
        'options' => $arrayPel,
        'selected' => $pelajaran,
    ];
    $submit = [
        'name' => 'submit',
        'value' => 'Submit',
        'type' => 'submit',
        'class' => 'btn btn-primary',
    ];
    $id = $thread->id;

    ?>
    <div class="container">
        <?= form_open_multipart('thread/update/'.$id) ?>
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" value="<?= $thread->judul?>">
            <br/>

            <?= form_label('Pelajaran', 'id_pelajaran') ?>
            <?= form_dropdown($id_pelajaran,) ?>

            <br/>

            <?= form_label('Isi', 'isi') ?>
            <textarea name="isi" id="isi" class="form-control ckeditor"><?php  echo $thread->isi; ?></textarea>

            <br/>

            <?= form_label('Alasan', 'reason') ?>
            <input type="text" name="reason" id="reason" required/>

            <br/>
            <br/>

            <?= form_submit($submit) ?>

        <?= form_close() ?>

    </div>
    <script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
    <script src="<?= base_url('assets/ckeditor/ckeditor.js')?>"></script>
    <script>
    CKEDITOR.replace( 'isi', {
        height: 300,
        filebrowserUploadUrl: '<?php echo base_url('thread/upImage') ?>'
    });
    </script>
</body>
</html>