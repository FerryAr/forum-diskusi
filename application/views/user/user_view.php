<?= $layout ?>

<div class="container" style="margin-top:60px">
    <div class="card row">
        <h1 class="card-title text-center mt-3 mb-4">Halaman Profil</h1>
        <hr/>
        <div class="col-md-4 card-body">
            <table width="100%" border=0>
                <tbody>
                <tr>
                    <td valign="top">
                        <table border="0" width="200%" style="padding-left: 10px; padding-right: 14px;">
                        <tbody>
                            <tr>
                                <td width="25%" valign="top">Nama Depan</td>
                                <td width="2%">:</td>
                                <td style="color: rgb(118, 157, 29); font-weight:bold"><?= $user->first_name ?></td>
                            </tr>
                            <tr>
                                <td width="25%" valign="top">Nama Belakang</td>
                                <td width="2%">:</td>
                                <td style="color: rgb(118, 157, 29); font-weight:bold"><?= $user->last_name ?></td>
                            </tr>
                            <tr>
                                <td width="25%" valign="top">Username</td>
                                <td width="2%">:</td>
                                <td><?= $user->username ?></td>
                            </tr>
                            <tr>
                                <td width="25%" valign="top">Email</td>
                                <td width="2%">:</td>
                                <td><?= $user->email ?></td>
                            </tr>
                            <tr>
                                <td width="25%" valign="top">No. HP</td>
                                <td width="2%">:</td>
                                <td><?= $user->phone ?></td>
                            </tr>
                            <tr>
                                <td width="25%" valign="top">Akun Dibuat</td>
                                <td width="2%">:</td>
                                <td><?= date('Y-m-d H:i:s', $user->created_on) ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Terakhir Login</td>
                                <td width="2%">:</td>
                                <td><?= date('Y-m-d H:i:s', $user->last_login) ?></td>
                            </tr>
                        </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            </table>

        </div>
    </div>
</div>
</body>
</html>