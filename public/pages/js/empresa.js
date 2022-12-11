function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) {$('#input_dni').css({"border-color":"red","boder":"1px solid red"}); $('.divFormulario').hide(); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    dvEsperado = 11 - (suma % 11);

    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) {$('#input_dni').css({"border-color":"red","boder":"1px solid red"}); $('.divFormulario').hide(); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    $('#input_dni').css({"border-color":"#40A944","boder":"1px solid #40A944"});

    verificarRut(rut);
    
}

function verificarRut(rut)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionEmpresas/"+rut.value+"/verificar",
        method: 'GET',
        success: function(result){
            if(result.codigoEstado == 3)
            {   
                alertify.success("Ingrese Información Representante");
                $('.divFormulario').show();
            }else if(result.codigoEstado == 0)
            {
                alertify.error("Representante ya esta ingresado.");
                $('.divFormulario').hide();
            }else if(result.codigoEstado == 1)
            {
                alertify.error("Activar Representante");
                $('.divFormulario').hide();
            }
        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                Toast.fire({
                    icon: 'error',
                    text: "Ha ocurrido un error!."
                });
            });
            $('.btn-submit').show();
            $('.btn-preloader').hide();
        }
    });
}

jQuery('#formRepresentante').on("submit", function(e){
    e.preventDefault();
    $('.btn-submit').hide();
    $('.btn-preloader').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionRepresentante",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            LoadRepresentante();
            alertify.success(result.mensaje);
            $("#formRepresentante")[0].reset();
            $('.btn-submit').show();
            $('.btn-preloader').hide();
            $('.divFormulario').hide();
        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                alertify.error(i[0]);
            });
            $('.btn-submit').show();
            $('.btn-preloader').hide();
        }
    });

});

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

jQuery('#formEmpresa').on("submit", function(e){
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
            url: "/gestionEmpresas",
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false, 
            processData: false,
            success: function(result){
                $("#formEmpresa")[0].reset();
                alertify.success(result.mensaje);
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
                        url: "/gestionEmpresas",
                        method: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(result){
                            $("#formEmpresa")[0].reset();
                            cropper.destroy();
                            $('#image').attr('src', '');
                            alertify.success(result.mensaje);
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