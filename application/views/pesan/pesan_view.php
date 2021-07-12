<?= $layout ?>

<div class="container">
<hr/>
<h1 class="text-center">Lihat Pesan</h1>
<hr/>
<div class='row card'>
    <div class="card-body">
        <div class="flex-container">
            <p class="display-6 text-center">Subject : <?= $pesan->subject ?></p>
            <hr/>
            <div class="text-center">
                <div style="margin-left:30px" class="mt-3">
                    <?= $pesan->pesan ?>
                </div>
            </div>
        </div>
            <div class="float-start">
                <small>
                    Dikirim oleh : <?= $pengirim->first_name ?>. Penerima : <?= $penerima->first_name ?>
                </small>
            </div>
            <div class="float-end">
                <small>
                    Dikirim pada : <?= $pesan->created ?>
                </small>
            </div>
            </div>
            <?php
                if($this->ion_auth->get_user_id() == $pesan->id_pengirim) {
                    //empty
                } else {
            ?>
                    <div class="text-center">
                    <div style="margin-left:30px" class="mt-5">
                        <a href="<?= base_url('pesan/create/'.$pengirim->id) ?>" class="btn btn-primary">Balas Pesan</a>
                    </div>
                </div>
            <?php
                }
            ?>
</div>
</div>
</body>
</html>