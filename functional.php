<?php

$conn = mysqli_connect("localhost", "root", "", "belajarphp");

$user = mysqli_query($conn, "SELECT * FROM user WHERE username = 'username'");

$roles = mysqli_query($conn, "SELECT * FROM roles");

function register($data)
{
    global $conn;

    $role_id = $data["role_id"];
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);


    //cek konfirmasi usernamse apakah sudah ada didatabase
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('Username sudah ada.');
        </script>";
        return false;
    }

    // cek apakah konfirmasi password sesuai
    if ($password !== $password2) {
        echo "<script>
        alert('Konfirmasi Password Tidak sesuai.');
        </script>";
        return false;
    }

    //enksripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $result = "INSERT INTO user (username, password, role_id) VALUES ('$username', '$password', '$role_id')";
    // Koneksikan ke database
    mysqli_query($conn, $result);

    return mysqli_affected_rows($conn);
}

function AddUser($user)
{
    global $conn;
    $username = strtolower(stripslashes($user["username"]));
    $password = mysqli_real_escape_string($conn, $user["password"]);
    $password2 = mysqli_real_escape_string($conn, $user["password2"]);
    $role = $user["role_id"];
    $status = $user["status"];

    // cek apakah username susah ada
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('Username sudah Ada, Mohon cari yang lain.');
        </script>";
        return false;
    }
    //cek konfirmasi password apa kah sesuai
    if ($password !== $password2) {
        echo "<script>
        alert('Konfirmasi password tidak sesuai.');
        </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user (username, password, role_id, status) VALUES ('$username', '$password','$role', '$status')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function edituser($user)
{

    global $conn;

    $id = $user['id'];
    $username = $user['username'];
    $password = $user['password'];
    $role_id = $user['role_id'];
    $status = $user['status'];

    // endskripsi password
    $passwordend = password_hash($password, PASSWORD_DEFAULT);


    $query = "UPDATE user SET 
                username = '$username',
                password = '$passwordend',
                role_id = '$role_id',
                status = '$status'
                WHERE id = $id
                ";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapususer($user)
{
    global $conn;

    $result = "DELETE FROM user WHERE id = $user ";

    mysqli_query($conn, $result);

    return mysqli_affected_rows($conn);
}

function query($query)
{
    global $conn; //ambil koneksi diluar functions  

    $user = mysqli_query($conn, $query); //hubungkan koneksi dengan nilai dari query dan masukan ke dalam variabel

    $rows = []; //array kosong
    while ($row = mysqli_fetch_assoc($user)) { //jdi ketika membuka bungkus aray kecil buka aray besat terlebih dahulu yaitu dengan
        $rows[] = $row; //dengan masukan ke variabelrows kosong
    }
    return ($rows); //lalu kembalikan eksekusi akhir dengan varibel akhir yaitu $rows
}







// function post


function upload_post()
{
    // panggil dulu $_files sesuai filed input tambah
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $tmpFile = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];

    // cek apakah file ada error
    if ($error === 4) { //kenapa dikasih nilai no 4 karena itu adalah code default dari $_files.
        echo "<script>
        alert('Pilih gambar terlebih dahulu')
        document.location.href='../posts/tambah_post.php'

        </script>";
    }

    $nameFileValid = ['jpeg', 'jpg', 'png']; //format gambar
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $nameFileValid)) {
        echo "<script>
        alert('File yang anda pilih bukan gambar.')
        alert('Format harus JPG, JPEG, PNG.')
        document.location.href='../posts/tambah_post.php'
        </script>";
        exit;
    }

    if ($ukuranFile > 2000000) {
        echo "<script>
        alert('File Max 2mb.')
        </script>";
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpFile, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

function slug($title, $separator = '-')
{

    // Convert all dashes/underscores into separator
    $flip = $separator === '-' ? '_' : '-';

    $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);

    // Replace @ with the word 'at'
    $title = str_replace('@', $separator . 'at' . $separator, $title);

    // Remove all characters that are not the separator, letters, numbers, or whitespace.

    // Replace all separator characters and whitespace by a single separator
    $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);

    return trim($title, $separator);
}


function waktu()
{
    $unixTime = time();
    $timeZone = new \DateTimeZone('Asia/Jakarta');


    $time = new \DateTime();
    $time->setTimestamp($unixTime)->setTimezone($timeZone);

    $formattedTime = $time->format('Y-m-d H:i:s');
    return $formattedTime;
}


function add_post($post)
{
    global $conn;

    $judul = $post["judul"];
    $slug = slug($judul, "-");
    $text = $post["text"];
    $user = $post["create_by"];
    $status = $post["status"];
    $tag_id = $post["tag_id"];
    $category_id = $post["category_id"];
    $created_at = waktu();
    $gambar = upload_post();

    $result = "INSERT INTO posts (judul, slug, text, gambar, status, tag_id, category_id, create_by, created_at) VALUES ('$judul', '$slug', '$text', '$gambar', '$status', '$tag_id', '$category_id', '$user', '$created_at')";

    mysqli_query($conn, $result);

    return mysqli_affected_rows($conn);
}

function edit_post($data)
{
    global $conn;

    $id = $data["id"];
    $judul = $data["judul"];
    $text = $data["text"];
    $created_by = $data["create_by"];
    $slug = slug($judul, "-");
    $user = waktu();
    $gambarLama = $data["gambar_lama"];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload_post();
    }

    $query = "UPDATE posts SET judul = '$judul', text = '$text', create_by = '$created_by', gambar = '$gambar', slug = '$slug', created_at = '$user' WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function delete_post($hapus)
{
    global $conn;

    $result = "DELETE FROM posts WHERE id = $hapus";

    mysqli_query($conn, $result);

    return mysqli_affected_rows($conn);
}

function Hours()
{
    $unixTime = time();
    $timeZone = new \DateTimeZone('Asia/Jakarta');

    $time = new \DateTime();
    $time->setTimestamp($unixTime)->setTimezone($timeZone);

    $formattedTime = $time->format('d F Y H:i');

    return $formattedTime;
}

function cari($keyword)
{
    $result = "SELECT * FROM posts WHERE 
    judul LIKE '%$keyword%'";

    return query($result);
}
