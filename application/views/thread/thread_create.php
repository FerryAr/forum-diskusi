<?= $layout ?>
<h1>Buat Postingan Baru</h1>
<?php
    $judul = [
        'name' => 'judul',
    ];
    $id_pelajaran = [
        'name' => 'id_pelajaran',
        'options' => $arrayPel,
        'selected' => null,
    ];
    $submit = [
        'name' => 'submit',
        'value' => 'Submit',
        'type' => 'submit',
        'class' => 'btn btn-primary',
    ];

    ?>
    <div class="container">
        <?= form_open_multipart('thread/create') ?>
            <?= form_label("Judul", "judul") ?>
            <?=form_input('judul')?>
            
            <br/>

            <?= form_label('Pelajaran', 'id_pelajaran') ?>
            <?= form_dropdown($id_pelajaran) ?>

            <br/>

            <?= form_label('Isi', 'isi') ?>
            <textarea name="isi" id="isi" class="form-control ckeditor"></textarea>

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