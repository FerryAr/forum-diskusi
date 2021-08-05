<?php
$keyword = [
    'name' => 'keyword',
    'class' => 'form-control',
    'value' => $keyword,
    'placeholder' => 'Keyword...'
];
$submit = [
    'name' => 'submit',
    'class' => 'btn btn-primary',
    'value' => 'Cari',
    'type' => 'submit',
];
?>
<?= $layout ?>
<h1 class="mt-2">Threads</h1>
<?php if($this->ion_auth->logged_in()) { ?>
<a href="<?= base_url('thread/create')?>" class="btn btn-primary mt-3 mb-3 ms-1 float-none">Buat Thread Baru</a>
<br/>
<?php } ?>
<?= form_open('thread/index', ['class'=>'row row-cols-lg-auto g-3 align-items-center mb-3 ms-1 float-start'])?>
<div>
    <?= form_input($keyword); ?>
</div>
<div class="ml-3">
    <?= form_submit($submit) ?>
</div>
<?=form_close()?>

<div class="dropdown d-flex justify-content-center mb-3">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        Pelajaran
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <?php foreach($arrayPel as $key=>$arrayPel): ?>
        <li><a class="dropdown-item" href="<?= base_url('thread')?>?pelajaran=<?= $arrayPel ?>"><?= $arrayPel ?></a></li>
        <?php endforeach;?>
    </ul>
</div>
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
        <?php if($this->input->get('pelajaran')) {
            foreach($thread2 as $key=>$thread2):?>
            <tr>
            <td>
                <?=$offset+$key+1?></td>
                <td><a class="fw-bold" href="<?=base_url('thread/view/'.$thread2->id) ?>">
                    <?= $thread2->judul ?>
                </a>
                </td>
                <td><?= $thread2->pelajaran ?></td>
                <td><?= $thread2->first_name ?></td>
            </tr>
            <?php endforeach; ?>
            <?php } else {?>
            
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
        <?php } ?>
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
<script src="<?= base_url('assets/js/popper.min.js')?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>