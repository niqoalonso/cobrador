function LoadRoles()
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestion-rol-permision/create",
        method: 'GET',
        success: function(result){
            console.log(result);
            $('.body-roles').empty();
            $.each(result, function(v,i){
                $('.body-roles').append('<tr>'+
                                '<td>'+i.name+'</td>'+
                                '<td>'+i.permissions.length+'</td>'+
                                '<td>'+
                                '<a href="javascript:void(0)" onclick="Editar(this.id)" id="'+i.id+'" class="text-warning p-2"><i class="fa fa-edit"></i></a>'+
                                '<a href="javascript:void(0)" onclick="Eliminar(this.id)" id="'+i.id+'" class="text-danger p-2"><i class="fa fa-trash"></i></a>'+
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

jQuery('#formRol').on("submit", function(e){
    e.preventDefault();
    $('.btn-submit').hide();
    $('.btn-preloader').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestion-rol-permision",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            LoadRoles();
            alertify.success(result.mensaje);
            $("#formRol")[0].reset();
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

function Editar(id)
{   
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestion-rol-permision/"+id+"/edit",
        method: 'GET',
        success: function(result){
        
            $('.inputID').val(result.id);
            $('.inputNombre').val(result.name);

            $("input[name='permisos[]']").each(function(indice, elemento) {
                indice++;
                $('#formrow-customCheckEdit'+indice).attr('checked', false);
            });

            $('.divFormEditar').show();
            $('.divFormNuevo').hide();

            $.each(result.permissions, function(v,i){
                $('#formrow-customCheckEdit'+i.id).attr('checked', true);
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

function Cancelar(id)
{
    $('.divFormEditar').hide();
    $('.divFormNuevo').show();

    $("#formRolEditar")[0].reset();

    alertify.error("Edición cancelada.");
}

jQuery('#formRolEditar').on("submit", function(e){
    e.preventDefault();
    $('.btn-submitE').hide();
    $('.btn-preloaderE').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestion-rol-permision/"+$('.inputID').val(),
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            LoadRoles();
            alertify.success(result.mensaje);
            $("#formRolEditar")[0].reset();
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

function Eliminar(id)
{       
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/verificarUsoRol/"+id,
        method: 'GET',
        success: function(result){
            if(result.codigoEstado == 0)
            {
                Swal.fire({
                    title: 'Eliminar ROL',
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
                            url: "/gestion-rol-permision/"+id,
                            method: 'DELETE',
                            success: function(result){
                                alertify.error(result.mensaje);
                                LoadRoles();
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

function verDescripcion(info)
{   
    $('#infoDescripcion').modal('show');
    $('.divContenido').html('<p><b>'+info+'</b></p>')
} 