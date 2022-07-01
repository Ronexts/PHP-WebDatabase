<?php
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'function.php';

$id = $_GET["id"];

$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

if( isset($_POST["submit"]) ) {

    //feedback
    if( ubah($_POST) > 0 ) {
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

    <title>Ubah Riwayat Studi</title>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>

    <h1>Ubah Data Mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value=" <?= $mhs["id"]; ?>">
        
        <ul>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" value="<?= $mhs["nama"]; ?>">
            </li>
            <li>
                <label for="nim">NIM : </label>
                <input type="text" name="nim" id="nim" value="<?= $mhs["nim"]; ?>">
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email" value="<?= $mhs["email"]; ?>">
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" value="<?= $mhs["jurusan"]; ?>">
            </li>
            <li>
                <input type="hidden" name="gambarlama" value="<?= $mhs["gambar"]; ?>">
                <label for="gambar">Gambar : </label> <br>
                <input type="file" name="gambar" id="gambar" class="gambar" onchange="previewImage()">
                <img src="img/<?= $mhs["gambar"] ?>" width="120" style="display:block;" class="img-preview">
            </li>
            <li>
                <button type="submit" name="submit">Ubah</button>
            </li>
        </ul>
    </form>

</body>
</html>