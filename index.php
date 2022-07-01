<?php
session_start();

    if( !isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }

    //koneksi ke function
    require 'function.php';

    //pagination
    $jumlahDataPerHalaman = 4;

    $jumlahData = count(query("SELECT * FROM mahasiswa"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    
    $halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;

    $awalData = ( $jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;

    $mahasiswa = query("SELECT * FROM mahasiswa ORDER BY nama ASC LIMIT $awalData, $jumlahDataPerHalaman");

    //saat tombol cari dieksekusi
    if( isset($_POST["cari"]) ) {
        $mahasiswa = cari($_POST["keyword"]);
    }

?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Halaman Admin</title>
    <style>
        .loader {
            width: 180px;
            position: absolute;
            top: 85px;
            left: 270px;
            z-index: -1;
            display:none;
        }
    </style>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>

    <a href="logout.php">Log out</a>

    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">Tambah Data Mahasiswa</a>
    <br><br>

    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword pencarian.." autocomplete="off" id="keyword">
        <button type="submit" name="cari" id="tombol-cari">Cari</button>

        <img src="img/loader.gif" class="loader">
    </form>
    <br><br>

    <div id="container">
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Opsi</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>

        <?php $i = 1; ?> 
        <?php foreach( $mahasiswa as $row ) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id"] ; ?>">ubah</a>
                <a href="hapus.php?id=<?= $row["id"] ; ?>" onclick=" return confirm('yakin?');">hapus</a>
            </td>
            <td><img src="img/<?= $row['gambar']; ?>" width="100"></td>
            <td><?= $row["nama"]; ?></td>
            <td><?= $row["nim"]; ?></td>
            <td><?= $row["email"]; ?></td>
            <td><?= $row["jurusan"]; ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    </div>
    <br>
    
<?php if( !isset($_POST["cari"]) ) : ?>
    <?php if( $halamanAktif > 1 ) : ?>
        <a href="?halaman=<?= $halamanAktif - 1; ?>"><</a>
    <?php endif; ?>

    <?php for( $i = 1; $i <= $jumlahHalaman; $i++ ) : ?>
        <?php if( $i == $halamanAktif ) : ?>
            <a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: red;"><?= $i ?></a>
        <?php else : ?>
            <a href="?halaman=<?= $i; ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if( $halamanAktif < $jumlahHalaman ) : ?>
        <a href="?halaman=<?= $halamanAktif + 1; ?>">></a>
    <?php endif; ?>

<?php else : ?>
    
<?php endif; ?>



</body>
</html>