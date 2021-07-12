<?= $layout ?>

<h1>Outbox</h1>
<a href="<?= base_url('pesan/inbox') ?>">Go to Inbox</a>
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Dikirim ke</th>
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
                            echo "&#10060;";
                        } else {
                            echo "&#10004;";
                        }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>