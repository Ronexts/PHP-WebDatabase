<?php
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'function.php';

if( isset($_POST["submit"]) ) {

    //feedback
    if( tambah($_POST) > 0 ) {
        echo "
            <script>
                alert('Berhasil!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "    
            <script>
                alert('Gagal');
            </script>
        ";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Tambah Riwayat Studi</title>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    
    <h1>Tambah Data Mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" require>
            </li>
            <li>
                <label for="nim">NIM : </label>
                <input type="text" name="nim" id="nim" require>
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email" require>
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" require>
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <input type="file" name="gambar" id="gambar" class="gambar" onchange="previewImage()">
                <img src="img/nophoto.png" width="120" style="display:block;" class="img-preview">
            </li>
            <li>
                <button type="submit" name="submit">Tambahkan</button>
            </li>
        </ul>
    </form>


</head>
</body>
</html>