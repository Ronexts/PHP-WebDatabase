<?php 

//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "mahasiswa");


function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];

    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {

    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $nim = htmlspecialchars($data["nim"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    //upload gambar
    $gambar = upload();
    if( !$gambar ) {
        return false;
    }

    $query = "INSERT INTO mahasiswa
                VALUES
                ('', '$nama', '$nim', '$email', '$jurusan', '$gambar')
            ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload() {

    $namaFile = $_FILES['gambar']['name'];
    $tipeFile = $_FILES['gambar']['type'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek keadaan gambar
    if( $error === 4 ) {
        // echo "<script>
        //     alert('pilih gambar terlebih dahulu');
        //     </script>";
        return 'nophoto.png';
    }

    //yang boleh diupload hanya gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if ( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "<script>
            alert('yang anda upload bukan gambar');
            </script>";
        return false;
    }

    //cek tipe file 2
    if( $tipeFile != 'image/jpeg' && $tipeFile != 'image/png'){
        echo "<script>
            alert('yang anda upload bukan gambar');
            </script>";
        return false;
    }

    //cek jika ukuran terlalu besar
    if( $ukuranFile > 5000000 ) {
        echo "<script>
            alert('ukuran gambar terlalu besar');
            </script>";
        return false;
    }

    //lolos pengecekan
    //generate gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;


}

function hapus($id) {

    global $conn;

    //menghapus gambar
    $mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];
    
    if( $mhs['gambar'] != 'nophoto.png' ) {
        unlink('img/' . $mhs['gambar']);
    }

    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);

}

function ubah($data) {
    
    global $conn;
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nim = htmlspecialchars($data["nim"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarlama = htmlspecialchars($data["gambarlama"]);
    
    //cek user pilih gambar baru atau tidak
    // if ( $_FILES['gambar']['error'] === 4 ) {
    //     $gambar = $gambarlama;
    // } else {
    //     $gambar = upload();
    // }

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    if ($gambar == 'nophoto.png') {
        $gambar = $gambarlama;
    }

    $query = "UPDATE mahasiswa SET
                nama = '$nama',
                nim = '$nim',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
                WHERE id = $id
            ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}

function cari($keyword) {
    $query = "SELECT * FROM mahasiswa 
                WHERE
                nama LIKE '%$keyword%' OR
                nim LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%'
                ORDER BY nama ASC
            ";

    return query($query);
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek keberadaan username
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if( mysqli_fetch_assoc($result) ) {
        echo "<script>
            alert('username sudah terdaftar');
            </script>";
        
        return false;
    }

    //cek konfirmasi password
    if( $password !== $password2 ) {
        echo "<script>
            alert('konfirmasi password tidak sesuai');
            </script>";
        return false;
    }
    
    //enskripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);

}

?>