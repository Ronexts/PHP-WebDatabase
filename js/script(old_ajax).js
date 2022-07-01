var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var container = document.getElementById('container');

//event
keyword.addEventListener('keyup', function() {

    //buat object
    var xhr = new XMLHttpRequest();

    //cek ajax
    xhr.onreadystatechange = function () {
        if( xhr.readyState == 4 && xhr.status == 200 ) {
            container.innerHTML = xhr.responseText;
        }
    }

    //eksekusi
    xhr.open('GET', 'ajax/mahasiswa.php?keyword=' + keyword.value, true);
    xhr.send();
})