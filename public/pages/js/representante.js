
function LoadRepresentante()
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionRepresentante/create",
        method: 'GET',
        success: function(result){
            console.log(result);
            $('.body-representantes').empty();
            $.each(result, function(v,i){
                $('.body-representantes').append('<tr>'+
                                '<td>'+i.rut+'</td>'+
                                '<td>'+i.nombres+' '+i.apellidos+'</td>'+
                                '<td>'+i.correo+'</td>'+
                                '<td>+56 '+i.celular+'</td>'+
                                '<td>'+
                                '<a href="javascript:void(0)" onclick="Editar(this.id)" id="'+i.id_representante+'" class="text-warning p-2"><i class="fa fa-edit"></i></a>'+
                                '<a href="" class="text-danger p-2"><i class="fa fa-trash"></i></a>'+
                                '</td>'+
                                '</tr>');
            }); 
             
        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                alertify.success(i[0]);
            });
            $('.btn-submit').show();
            $('.btn-preloader').hide();
        }
    });
}

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
    if(cuerpo.length < 7) {$('#input_dni').css({"border-color":"red","boder":"1px solid red"}); return false;}
    
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
    if(dvEsperado != dv) {$('#input_dni').css({"border-color":"red","boder":"1px solid red"}); return false; }
    
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
        url: "/gestionRepresentante/"+rut.value+"/verificar",
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

function Editar(id)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionRepresentante/"+id+"/edit",
        method: 'GET',
        success: function(result){
            $('.divFormNuevo').hide(); //Oculta formulario crear
            $('.divFormEditar').show(); //Muestra formulario editar

            $('.inputID').val(result.rep.id_representante);
            $('.inputRut').val(result.rep.rut);
            $('.inputNombres').val(result.rep.nombres);
            $('.inputApellidos').val(result.rep.apellidos);
            $('.inputCorreo').val(result.rep.correo);
            $('.inputCelular').val(result.rep.celular);

            alertify.success('Edición activada.');
        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                alertify.warning(i);
            });
            $('.btn-submit').show();
            $('.btn-preloader').hide();
        }
    });
}

jQuery('#formEditRepresentante').on("submit", function(e){
    e.preventDefault();
    $('.btn-submitE').hide();
    $('.btn-preloaderE').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionRepresentante/"+$('.inputID').val(),
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            LoadRepresentante();
            alertify.success(result.mensaje);
            $("#formEditRepresentante")[0].reset();
            $('.btn-submitE').show();
            $('.btn-preloaderE').hide();
            $('.divFormEditar').hide();
            $('.divFormNuevo').show();
        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                alertify.error(i[0]);
            });
            $('.btn-submitE').show();
            $('.btn-preloaderE').hide();
        }
    });

});

function CancelarEdicion()
{
    $('.divFormNuevo').show(); //Muestra formulario crear
    $('.divFormEditar').hide(); //Oculta formulario editar

    alertify.error('Edición cancelada.');
}

function Eliminar(id)
{       
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/verificarUsoRepresentante/"+id,
        method: 'GET',
        success: function(result){
            if(result.codigoEstado == 0)
            {
                Swal.fire({
                    title: 'Eliminar Representante',
                    text: result.mensaje,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar.'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({ 
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "/gestionRepresentante/"+id,
                            method: 'DELETE',
                            success: function(result){
                                alertify.error(result.mensaje);
                                LoadRepresentante();
                            },
                            error: function(result){
                                console.clear();
                                $.each(result.responseJSON.errors, function(v,i){
                                    alertify.warning(i);
                                });
                                $('.btn-submit').show();
                                $('.btn-preloader').hide();
                            }
                        });
                    }
                });
            }else{
                alertify.error(result.mensaje);
            }
            
        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                alertify.warning(i);
            });
            $('.btn-submit').show();
            $('.btn-preloader').hide();
        }
    });
    
}