<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("location: index.php");
} elseif ($_SESSION["role_id"] == 2) {
    header("location: index.php");
    exit;
}

require  'functional.php';

$roles = mysqli_query($conn, "SELECT * FROM roles");

$users = mysqli_query($conn, "SELECT user.id, user.username, user.role_id, roles.name, user.status FROM user INNER JOIN roles ON user.role_id = roles.id");

$user = mysqli_fetch_assoc($users);

if (isset($_POST["submit"])) {
    if (AddUser($_POST) > 0) {
        echo "<script>
        alert('User berhasil ditambahkan');
        document.location.href='dashboard.php';
        </script>";
    } else {
        echo "<script>
        alert('User Gagal ditambahkan');
        document.location.href='dashboard.php';
        </script>";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | SyahriProject</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oregano&display=swap" rel="stylesheet">
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
                    <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                    <a class="nav-link" href="users/index.php">Users</a>
                    <a class="nav-link" href="posts/index.php">Posts</a>
                    <a class="nav-link" href="#">Tags</a>
                    <a class="nav-link" href="#">Categorys</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">

        <head>
            <h1>Selamat Datang
                <small class="text-muted"> - <?php echo $_SESSION["login"]; ?></small>
            </h1>
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="20000">
                        <img src="/data/img/admin3.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item" data-bs-interval="10000">
                        <img src="/data/img/soryy2.png" class="d-block w-100" alt="...">
                    </div>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div>
                <a href="https://api.whatsapp.com/send?phone=6285792314401&text=Hallo%20Selamat%20Datang"><img style="position: fixed; right:15px; top: 85%; width:50px; height:50px;" src="/data/img/wa.png" alt=""></a>
            </div>
        </head>

    </div>


    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>