<?php
require '../functional.php';

$id = $_GET['id'];

$user = query("SELECT * FROM user WHERE id = $id")[0]; //query itu adalah function


if (isset($_POST["submit"])) {
    if (edituser($_POST) > 0) {
        echo "<script>
        alert('Data User Berhasil di Edit.');
        document.location.href='../dashboard.php';
        </script>";
    } else {
        var_dump($_POST);
        echo "<script>
        alert('Data User Gagal di Edit.');
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit user</title>
    <style>
        label {
            font-size: 20px;
        }
    </style>
</head>

<body>

    <h2>Edit user</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $user['id']; ?>">
        <div style="margin:10px; padding:10px;">
            <label for="username">Username</label>
            <input class="form-control" type="text" name="username" id="username" value="<?= $user['username']; ?>">
        </div>
        <div style="margin:10px; padding:10px;">
            <label for="password">Password</label>
            <p style="font-style: italic;">Kosongkan bila tidak ada perbaikan password</p>
            <input class="form-control" type="text" name="password" id="password">
        </div>
        <div style="margin:10px; padding:10px;">
            <label for="role_id">Role</label>
            <select name="role_id" id="role_id">
                <?php foreach ($roles as $u) : ?>
                    <option value="<?= $u['id']; ?>" <?= ($user['role_id'] == $u['id'] ? 'selected' : ''); ?>><?php echo $u["name"]; ?></option>
                    <!-- ambil id pada table roles lalu diluar value jika $user"id" cocok dengan table roles maka tambilkan data true, jika false atau salah maka jalankan selected dengan tanda "-" -->
                <?php endforeach; ?>
            </select>
        </div>
        <div style="margin:10px; padding:10px;">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="aktif" <?= ($user['status'] == 'aktif' ? 'selected' : ''); ?>>Aktif</option>
                <option value="tidak aktif" <?= ($user['status'] == 'tidak aktif' ? 'selected' : ''); ?>>Tidak Aktif</option>
            </select>
        </div>
        <br>
        <button type="submit" name="submit">Save</button>
    </form>

</body>

</html>