function LoadArea() 
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionLocales/area",
        method: 'GET',
        success: function(result){
            //Verificamos si hay ingresada areas, si es asi, desbloqueamos el formulario de locales.
            if(result.length > 0)
            {
                $('.divBloqueoAcceso').hide();
                $('.divFormularioLocal').show();
            }else{
                $('.divBloqueoAcceso').show();
                $('.divFormularioLocal').hide();
            }

            
            $('.inputAreaSelect').html('<option value="">Seleccionar</option>');
            $('.body-areas').empty();

            $.each(result, function(v,i){
                $('.inputAreaSelect').append('<option value="'+i.id_area+'">'+i.nombre+'</option>');
                $('.body-areas').append('<tr>'+
                                '<td>'+i.nombre+'</td>'+
                                '<td>'+
                                '<a href="javascript:void(0)" onclick="EditarArea(this.id)" id="'+i.id_area+'" class="text-warning p-2"><i class="fa fa-edit"></i></a>'+
                                '<a href="javascript:void(0)" onclick="EliminarArea(this.id)" id="'+i.id_area+'" class="text-danger p-2"><i class="fa fa-trash"></i></a>'+
                                '</td>'+
                                '</tr>');
            }); 
            
        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                alertify.success(i);
            });
            $('.btn-submit').show();
            $('.btn-preloader').hide();
        }
    });
}

jQuery('#formArea').on("submit", function(e){
    e.preventDefault();
    $('.btn-submit').hide();
    $('.btn-preloader').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/crearArea",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            LoadArea();
            alertify.success(result.mensaje);
            $("#formArea")[0].reset();
            $('.btn-submit').show();
            $('.btn-preloader').hide();
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

function EditarArea(id)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/editarArea/"+id,
        method: 'GET',
        success: function(result){
            
            $('.inputNombre').val(result.area.nombre);
            $('.inputAreaID').val(result.area.id_area);

            $('.divAreaEditar').show();
            $('.divAreaNuevo').hide();

            $('.titleAreaNuevo').hide();
            $('.titleAreaEditar').show();   
            alertify.success(result.mensaje);
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
}

function CancelarArea()
{
    $('.divAreaEditar').hide();
    $('.divAreaNuevo').show()
    $('.titleAreaNuevo').show();
    $('.titleAreaEditar').hide();   
    $("#formEditarArea")[0].reset();
    alertify.error('Edición cancelada.');
}

jQuery('#formEditarArea').on("submit", function(e){
    e.preventDefault();
    $('.btn-submitE').hide();
    $('.btn-preloaderE').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/updateArea/"+$('.inputAreaID').val(),
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            LoadArea();
            LoadLocal();
            alertify.success(result.mensaje);
            $('.divAreaEditar').hide();
            $('.divAreaNuevo').show()
            $('.titleAreaNuevo').show();
            $('.titleAreaEditar').hide();   
            $("#formEditarArea")[0].reset();
            $('.btn-submitE').show();
            $('.btn-preloaderE').hide();
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

function EliminarArea(id)
{       
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/verificarUsoArea/"+id,
        method: 'GET',
        success: function(result){
            if(result.codigoEstado == 0)
            {
                Swal.fire({
                    title: 'Eliminar Area',
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
                            url: "/eliminarArea/"+id,
                            method: 'DELETE',
                            success: function(result){
                                alertify.error(result.mensaje);
                                LoadArea();
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