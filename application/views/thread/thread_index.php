<?php
$keyword = [
    'name' => 'keyword',
    'value' => $keyword,
    'placeholder' => 'Keyword...'
];
$submit = [
    'name' => 'submit',
    'value' => 'Cari',
    'type' => 'submit',
];
?>
<?= $layout ?>
<h1 class="mt-2">Threads</h1>
<?php if($this->ion_auth->logged_in()) { ?>
<a href="<?= base_url('thread/create')?>" class="btn btn-primary mt-3 mb-3 ms-1">Buat Thread Baru</a>
<?php } ?>
<?= form_open('thread/index', ['class'=>'row row-cols-lg-auto g-3 align-items-center mb-3 ms-1'])?>
<div>
    <?= form_input($keyword); ?>
</div>
<div class="ml-3">
    <?= form_submit($submit) ?>
</div>
<?=form_close()?>

<?= $pesan ?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Pelajaran</th>
            <th>Posted by</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($threads as $key=>$thread):?>
            <tr>
                <td><?=$offset+$key+1?></td>
                <td><a class="fw-bold" href="<?=base_url('thread/view/'.$thread->id) ?>">
                    <?= $thread->judul ?>
                </a>
                </td>
                <td><?= $thread->pelajaran ?></td>
                <td><?= $thread->first_name ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php 
    $config = array(
        'base_url' => base_url('thread'),
        'total_rows' => $total,
        'per_page' => $perPage,
        'page_query_string' => TRUE,
        'query_string_segment' => 'page',
    );
    $this->pagination->initialize($config);
    echo $this->pagination->create_links();
?>

<script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>