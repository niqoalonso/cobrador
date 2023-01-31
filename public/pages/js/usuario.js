
function LoadUsers()
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/GestionUser/create",
        method: 'GET',
        success: function(result){
            console.log(result);
            $('.body-users').empty();
            $.each(result, function(v,i){
                $('.body-users').append('<tr>'+
                                '<td>'+i.name+'</td>'+
                                '<td>'+i.email+'</td>'+
                                '<td>'+
                                '<a href="javascript:void(0)" onclick="Editar(this.id)" id="'+i.id+'" class="text-warning p-2"><i class="fa fa-edit"></i></a>'+
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
        url: "/GestionUser/"+rut.value+"/verificar",
        method: 'GET',
        success: function(result){
            if(result.codigoEstado == 3)
            {   
                alertify.success("Ingrese Información Usuario");
                $('.divFormulario').show();
            }else if(result.codigoEstado == 0)
            {
                alertify.error("Usuario ya esta ingresado.");
                $('.divFormulario').hide();
            }else if(result.codigoEstado == 1)
            {
                alertify.error("Activar Usuario");
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

jQuery('#formUsuario').on("submit", function(e){
    e.preventDefault();
    $('.btn-submit').hide();
    $('.btn-preloader').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/GestionUser",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            LoadUsers();
            alertify.success(result.mensaje);
            $("#formUsuario")[0].reset();
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
        url: "/GestionUser/"+id+"/edit",
        method: 'GET',
        success: function(result){
            $('.divFormNuevo').hide(); //Oculta formulario crear
            $('.divFormEditar').show(); //Muestra formulario editar

            $('.inputID').val(result.user.id);
            $('.inputRut').val(result.user.rut);
            $('.inputNombres').val(result.user.nombres);
            $('.inputApellidos').val(result.user.apellidos);
            $('.inputCorreo').val(result.user.email);

            $('.body-usersEdit').html('<option value="">Seleccionar</option>');
            $.each(result.roles, function(v,i){
                if(i.name == result.rolUser)
                {
                    $('.body-usersEdit').append('<option value="'+i.name+'" selected>'+i.name+'</option>');
                }else{
                    $('.body-usersEdit').append('<option value="'+i.name+'">'+i.name+'</option>');
                }
              
            }); 

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

jQuery('#formEditUsuario').on("submit", function(e){
    e.preventDefault();
    $('.btn-submitE').hide();
    $('.btn-preloaderE').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/GestionUser/"+$('.inputID').val(),
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            LoadUsers();
            alertify.success(result.mensaje);
            $("#formEditUsuario")[0].reset();
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