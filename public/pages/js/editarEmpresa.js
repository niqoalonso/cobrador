var image = document.getElementById('image');
var cropper;

$("body").on("change", ".image", function(e){
        
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
    if(!allowedExtensions.exec(filePath)){

        alertify.error('Debes seleccionar una archivo de imagen.');
        fileInput.value = ''; 
        image.src = '';
        if(cropper != null){
            cropper.destroy();
        }
        return false;
    }
    
    var files = e.target.files;
        var done = function (url) {
            if(cropper != null){
                cropper.destroy();
            }
            image.src = url;
            cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            cropBoxResizable: true,
        });
    };

    var reader;
    var file;
    var url;
    
    if (files && files.length > 0) {
    file = files[0];

    if (URL) {
        done(URL.createObjectURL(file));
    } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
        done(reader.result);
        };
        reader.readAsDataURL(file);
    }
    }
});

jQuery('#formUpdate').on("submit", function(e){
    e.preventDefault();
    $('.btn-submit').hide();
    $('.btn-preloader').show();
    var formData = new FormData(this);
    var id = $('.id_producto').val();
    
    if(typeof cropper == 'undefined' || typeof cropper == null){          
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/gestionEmpresas/"+$('.inputID').val(),
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false, 
            processData: false,
            success: function(result){
                alertify.success(result.mensaje);
                $('.btn-submit').show();
                $('.btn-preloader').hide();
            },
            error: function(result){
                console.clear();
                $.each(result.responseJSON.errors, function(v,i){
                    Toast.fire({
                        icon: 'warning',
                        text: i,
                    });
                });
                  $('.btn-submit').show();
                  $('.btn-preloader').hide();
            }
        });
      }else{
        canvas = cropper.getCroppedCanvas({
            width: 3000,
            height: 1000,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });
    
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob); 
            reader.onloadend = function() {

                var base64data = reader.result;	
                formData.append('img', base64data);
                        
                    $.ajaxSetup({ 
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/gestionEmpresas/"+$('.inputID').val(),
                        method: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(result){
                            $('.linkInputImg').attr('id', '../../storage'+result.empresa);
                            cropper.destroy();
                            $('#image').attr('src', '');
                            alertify.success(result.mensaje);
                            $('.btn-submit').show();
                            $('.btn-preloader').hide();
                        },
                        error: function(result){
                            console.clear();
                            $.each(result.responseJSON.errors, function(v,i){
                                Toast.fire({
                                    icon: 'warning',
                                    text: i,
                                });
                            });
                            $('.btn-submit').show();
                            $('.btn-preloader').hide();
                        }
                    });
            }
        },'image/jpeg', 10);
      }
   
});

function verImagen(img)
{   
    $('.imgVer').attr('src', '../../storage'+img);
    $('#modalImagen').modal('show');
}