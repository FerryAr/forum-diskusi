<?= $layout ?>

<h1>Inbox</h1>
<a href="<?= base_url('pesan/outbox') ?>">Go to Outbox</a>
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Dari</th>
            <th>Subject Pesan</th>
            <th>Dikirim pada</th>
            <th>Dibaca</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($pesan as $key=>$pesan): ?>
            <tr>
                <td><?= $key+1 ?></td>
                <td><?= $pesan->nama ?></td>
                <td>
                    <a href="<?= base_url('pesan/view/'.$pesan->pesan_id) ?>">
                        <?= $pesan->subject ?>
                    </a>
                </td>
                <td><?= $pesan->pesan_created ?></td>
                <td>
                    <?php 
                        if($pesan->is_read == 0) {
                            echo "<i class='fas fa-times'></i>";
                        } else {
                            echo "<i class='fas fa-check'></i>";
                        }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>