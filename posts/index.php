<?php
session_start();

if ($_SESSION["role_id"] == 2) {
    header("location: ../index.php");
    exit;
}

require  '../functional.php';

$posts = mysqli_query($conn, "SELECT * FROM posts");

$status = mysqli_fetch_assoc($posts);

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posts | SyahriProject</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">Home</a>
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
                <h1>Posts
                    <small class="text-muted"> - <?php echo $_SESSION["login"]; ?></small>
                </h1>

            </div>
            <div>
                <a type="button" class="btn btn-dark  " href="../posts/tambah_post.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                    </svg>
                    Add Post
                </a>
            </div>
        </div>
        <br>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>

                <?php foreach ($posts as $post) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $post["judul"]; ?></td>
                        <td><?= $post["status"]; ?></td>
                        <td>
                            <a href="" class="btn btn-primary">View</a>
                            <a class="btn btn-success" href="/data/posts/edit_post.php?id=<?= $post['id']; ?>">Edit</a>
                            <a href="/data/posts/delete_post.php?id=<?= $post['id']; ?>" onclick="return confirm('Yakin hapus <?= $post['judul']; ?> ?');" class=" btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
                <table class="table table-striped table-hover">
                    ...
                </table>
            </tbody>
        </table>
    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>