<?php
session_start();

require '../functional.php';

$id = $_GET['id'];

$post = query("SELECT * FROM posts WHERE id = $id")[0];

if (isset($_POST["submit"])) {
    if (edit_post($_POST) >= 0) {
        echo "<script>
        alert('Post Berhasil diEdit.');
        document.location.href= '../posts/index.php';
        </script>";
    } else {
        echo "<script>
        alert('Post Gagal diEdit.');
        document.location.href= '../posts/edit_post.php';
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
    <title>Edit Post</title>
    <!-- summernote -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
</head>

<body>
    <style>
        body {
            padding: 10px;
        }

        .container {
            padding: 10px;
        }

        label {
            display: flex;
            flex-direction: row;
        }

        input {
            margin-bottom: 10px;
        }
    </style>
    <h1>Edit Post</h1>
    <br>
    <a href="../posts/index.php">Kembali</a>
    <br>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="create_by" id="create_by" value="<?= $_SESSION['login']; ?>">
            <input type="hidden" name="id" id="id" value="<?= $post['id']; ?>">
            <input type="hidden" name="gambar_lama" id="gambar_lama" value="<?= $post['gambar']; ?>">
            <label for="judul">Judul :</label>
            <input class="form-control" type="text" name="judul" id="judul" value="<?= $post['judul']; ?>" required autofocus>

            <label for="summernote">text</label>
            <textarea class="form-control" name="text" id="summernote"><?= $post["text"]; ?></textarea>
            <br>
            <br>
            <label class="title" for="gambar">Gambar :</label>
            <img src="img/<?= $post['gambar']; ?>" alt="" style="width: 200px; height: auto">
            <br>
            <input class="form-control" type="file" name="gambar" id="gambar">

            <br>
            <br>
            <button style="padding: 10px;" type="submit" name="submit">Kirim</button>
        </form>
    </div>

    <script>
        $('#summernote').summernote({
            tabsize: 2,
            height: 200,

        })
    </script>

</body>

</html>