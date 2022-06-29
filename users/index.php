<?php
session_start();

if (!$_SESSION["login"]) {
    header("location: index.php");
    exit;
}

require  '../functional.php';

$roles = mysqli_query($conn, "SELECT * FROM roles");

$users = mysqli_query($conn, "SELECT user.id, user.username, user.role_id, roles.name, user.status FROM user INNER JOIN roles ON user.role_id = roles.id");

$user = mysqli_fetch_assoc($users);

if (isset($_POST["submit"])) {
    if (AddUser($_POST) > 0) {
        echo "<script>
        alert('User berhasil ditambahkan');
        document.location.href='/data/users/index.php';
        </script>";
    } else {
        echo "<script>
        alert('User Gagal ditambahkan');
        document.location.href='/data/users/index.php';
        </script>";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users | SyahriProject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/data/index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="/data/dashboard.php">Dashboard</a>
                    <a class="nav-link" href="/data/users/index.php">Users</a>
                    <a class="nav-link" href="/data/posts/index.php">Posts</a>
                    <a class="nav-link" href="#">Tags</a>
                    <a class="nav-link" href="#">Categorys</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">

        <div class="d-flex p-2 justify-content-between">
            <div class="head">
                <h1>Users
                    <small class="text-muted"> - <?php echo $_SESSION["login"]; ?></small>
                </h1>

            </div>
            <?php if (($_SESSION["role_id"] == 3)) : ?>
                <div>
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                        </svg>Add User
                    </button>
                </div>
            <?php else : ?>
                <div>
                    <button onclick="return alert('Maaf anda bukan SubAdmin.');" class="btn btn-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                        </svg>Add User
                    </button>
                </div>
            <?php endif; ?>
        </div>




        <!-- start modal adduser -->

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Username</label>
                                <input type="text" class="form-control" id="recipient-name" name="username" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Password</label>
                                <input class="form-control" id="message-text" name="password" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="message-text2" class="col-form-label">Konfirmasi Password</label>
                                <input class="form-control" id="message-text2" name="password2" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="role_id" class="col-form-label">Choose Role</label>
                                <select class="form-select" name="role_id" id="role_id">
                                    <?php foreach ($roles as $role) : ?>
                                        <option value="<?= $role["id"]; ?>"><?php echo $role["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Choose Status</label>
                                <select class="form-select" id="message-text" name="status">
                                    <option value="aktif" class="">Aktif</option>
                                    <option value="tidak aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end modal adduser -->

        <br>
        <?php if (($_SESSION["role_id"] == 3)) : ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $user["username"]; ?></td>
                            <td><?= $user["name"]; ?></td>
                            <td><?= $user["status"]; ?></td>
                            <td>
                                <a href="" class="btn btn-primary">View</a> ||
                                <a class="btn btn-success" href="/data/users/edit.php?id=<?= $user['id']; ?>">Edit</a> ||
                                <a href="/data/users/delete.php?id=<?= $user['id']; ?>" onclick="return confirm('Yakin hapus <?= $user['username']; ?> ?');" class=" btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-info" role="alert">
                Maaf hanya SubAdmin yang bisa atur user!
            </div>
        <?php endif; ?>
    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>