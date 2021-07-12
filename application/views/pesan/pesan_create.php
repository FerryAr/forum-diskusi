<?= $layout ?>
<?php
    $submit = [
        'value' => 'Kirim',
        'type' => 'submit',
        'class' => 'button'
        ];    
?>
<h1>Kirim pesan ke <?= $penerima->first_name ?></h1>
<div class="container">
    <?= form_open_multipart('pesan/create/'.$penerima->id) ?>

        <?= form_label("Subject", "subject") ?>
        <?= form_input("subject") ?><br/>

        <?= form_label("Pesan", "pesan") ?>
        <?= form_textarea("pesan") ?><br>

        <?= form_submit($submit) ?>
    <?= form_close() ?>
</div>