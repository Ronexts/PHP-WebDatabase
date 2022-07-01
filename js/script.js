$(document).ready(function (){

    $('#tombol-cari').hide();

    //event keyword ditulis
    $('#keyword').on('keyup', function() {
        //loader
        $('.loader').show();

        //ajax load
        //$('#container').load('ajax/mahasiswa.php?keyword=' + $('#keyword').val());        
    
        //$.get()
        $.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data) {

            $('#container').html(data);
            $('.loader').hide();

        });
    });
});

function previewImage() {

    const gambar = document.querySelector('.gambar');
    const imgPreview = document.querySelector('.img-preview');

    const oFReader = new FileReader();
    oFReader.readAsDataURL(gambar.files[0]);

    oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
    };

}

