<?php
$submit = [
    'name' => 'submit',
    'class' => 'btn btn-light btn-sm form-control',
    'value' => 'Cari',
    'type' => 'submit',
];
?>
<?= $layout ?>
<div class="container">
<div class="main-body p-0">
    <div class="inner-wrapper">
        <!-- Inner sidebar -->
        <div class="inner-sidebar">
            <!-- Inner sidebar header -->
            <div class="inner-sidebar-header justify-content-center">
            <a class="link-light" href="<?= base_url('thread/create') ?>" style="text-decoration:none;">
                <button class="btn btn-primary btn-outline-* has-icon" type="button">
                    <i class="fas fa-plus"></i> DISKUSI BARU
                </button>
            </a>
            </div>
            <!-- /Inner sidebar header -->

            <!-- Inner sidebar body -->
            <div class="inner-sidebar-body p-0">
                <div class="p-3 h-100" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: -16px;">
                        <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                                    <div class="simplebar-content" style="padding: 16px;">
                                        <nav class="nav nav-pills nav-gap-y-1 flex-column">
                                        <a class="nav-link nav-link-faded has-icon" href="<?= base_url('thread') ?>">Semua Diskusi</a>
                                        <?php foreach($arrayPel as $arrayPela): ?>
                                            <a href="<?= base_url('thread') ?>?pelajaran=<?= $arrayPela ?>" class="nav-link has-icon"><?= $arrayPela ?></a>
                                        <?php endforeach;?>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: 234px; height: 292px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 151px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div>
                </div>
            </div>
            <!-- /Inner sidebar body -->
        </div>
        <!-- /Inner sidebar -->

        <!-- Inner main -->
        <div class="inner-main">
            <!-- Inner main header -->
            <div class="inner-main-header">
                <a class="nav-link nav-icon rounded-circle nav-link-faded me-3 d-md-none" href="#" data-bs-toggle="inner-sidebar"><i class="material-icons">arrow_forward_ios</i></a>
                <button class="btn btn-light btn-sm border border-1 dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Pelajaran
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <?php foreach($arrayPel as $key=>$arrayPel): ?>
                        <li><a class="dropdown-item" href="<?= base_url('thread')?>?pelajaran=<?= $arrayPel ?>"><?= $arrayPel ?></a></li>
                    <?php endforeach;?>
                </ul>
                <!-- <form method="POST" action="<?= base_url()?>thread/index"> -->
                <?=form_open('thread/index', ['class'=>"form-inline input-icon input-icon-sm ms-auto w-auto"]) ?>
                        <div class="form-group d-flex">
                    <input type="text" class="form-control form-control-sm form-control-md mb-4 mt-4" name="keyword" placeholder="Search forum" value="<?= $keyword ?>">
                    <button type="submit" class="form-control mb-4 mt-4 ms-2 btn btn-sm" style="background-color:var(--primary-color)">Cari</button>
                    </div>
                <?=form_close()?>
                <!-- </form> -->
            </div>
            <!-- /Inner main header -->

            <!-- Inner main body -->

            <!-- Forum List -->
            <?php if($this->input->get('pelajaran')) { ?>
                <div class="inner-main-body p-2 p-sm-3 forum-content show" style="overflow-y:scroll">
            <?php foreach($thread2 as $key=>$thread):?>
                <div class="card mb-2">
                    <div class="card-body p-2 p-sm-3">
                        <div class="d-flex forum-item">
                            <a href="#"><img src="<?= base_url() ?>assets/images/avatars/<?= $thread->avatar ?>" class="me-3 flex-shrink-0" style="width:50px; height:40px" alt="User" /></a>
                            <div>
                                <h6><a href="<?= base_url('thread/view/'.$thread->id) ?>" class="text-body"><?= $thread->judul ?></a></h6>
                                <p class="text-secondary" style="overflow: hidden;">
                                    <?= strip_tags(word_limiter($thread->isi, 6)) ?>
                                </p>
                                <p class="text-muted"><a href="javascript:void(0)"><?= $latestRep->first_name ?></a> replied <span class="text-secondary fw-bold">13 minutes ago</span></p>
                            </div>
                        </div>
                        <div class="float-end text-muted small text-center align-self-center">
                                <span class="d-none d-sm-inline-block"><i class="far fa-eye"></i> <?=$thread->views?></span>
                                <?php 
                                    $count = $this->db->select('reply')
                                            ->from('reply')
                                            ->where('id_thread', $thread->id)
                                            ->count_all_results();
                                ?>
                                <span><i class="far fa-comment ms-3"></i> <?= $count ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php } else { ?>
            <div class="inner-main-body p-2 p-sm-3 forum-content show" style="overflow-y:scroll">
            <?php foreach($threads as $key=>$thread):?>
                <div class="card mb-2">
                    <div class="card-body p-2 p-sm-3">
                        <div class="d-flex forum-item">
                            <a href="#"><img src="<?= base_url() ?>assets/images/avatars/<?= $thread->avatar ?>" class="me-3 flex-shrink-0 rounded" style="width:50px" alt="User" /></a>
                            <div>
                                <h6><a href="<?= base_url('thread/view/'.$thread->id) ?>" class="text-body"><?= $thread->judul ?></a></h6>
                                <p class="text-secondary" style="overflow: hidden;">
                                    <?= strip_tags(word_limiter($thread->isi, 6)) ?>
                                </p>
                                <?php
                                    $ci =&get_instance();
                                    $ci->load->model('Reply_model');
                                    $latestRep = $ci->reply_model->getLatestReply($thread->id);
                                ?>
                                <?= $latestRep ?>
                                </div>
                        </div>
                        <div class="float-end text-muted small text-center align-self-center">
                                <span class="d-none d-sm-inline-block"><i class="far fa-eye"></i> <?=$thread->views?></span>
                                <?php 
                                    $count = $this->db->select('reply')
                                            ->from('reply')
                                            ->where('id_thread', $thread->id)
                                            ->count_all_results();
                                ?>
                                <span><i class="far fa-comment ms-3"></i> <?= $count ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php } ?>
            <!-- /Forum Detail -->

            <!-- /Inner main body -->
        </div>
        <!-- /Inner main -->
    </div>

    <!-- <div class="theme-switch-wrapper">
    <label class="theme-switch" for="checkbox">
        <input type="checkbox" id="checkbox" />
        <div class="slider round"></div>
  </label>
  <em>Enable Dark Mode!</em>
</div>
</div> -->
</div>
<script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/js/popper.min.js')?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
<script>
    const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
function switchTheme(e) {
    if (e.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
    }
    else {
        document.documentElement.setAttribute('data-theme', 'light');
    }    
}
toggleSwitch.addEventListener('change', switchTheme, false);
</script>
</body>
</html>
