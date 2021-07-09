<?= $layout ?>
<?php
    $hidden = [
        'id_thread' => $thread->id,
        'id_user' => $user[0]->id,
    ];
?>
<div class="container">
<div class="card mt-3">
    <h1 class="card-title mt-3" style="text-align:center"><?= $thread->judul ?></h1>
    <hr/>
    <div class="card-body">
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
<div style="margin-left:auto" class="mt-3">
        <a class="btn btn-primary btn-md" href="<?= base_url('reply/create/'.$thread->id)?>">Buat Reply</a>
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
            <div class="float-start mx-2">
                <?php if(!empty($reply_update[0]->updated_at)) { ?>
                <?php foreach($reply_update as $r_up): ?>
                    <small>Updated by <a href="<?= base_url('user/view/'.$r_up->id)?>"></a><?= $r_up->first_name ?> at <?= $r_up->updated_at ?>. Alasan : <?= $r_up->reason ?></small>
                <?php endforeach; ?>
                <?php } ?>
            </div>
            <div class="float-end mx-2">
                <a href="<?= base_url('reply/edit/'.$r->id) ?>" style="color:#3498db" >Edit</a>
                <a href="<?= base_url('reply/delete/'.$r->id.'/'.$thread->id) ?>" style="color:#c0392b">Delete</a>
            </div>
        </div>
        </div>
    <?php endforeach ?>
<script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>
