$( document ).ready(function() {
    $('#datatableLocal').DataTable();
});

function LoadLocal() 
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionLocales/local",
        method: 'GET',
        success: function(result){
            $('.body-locales').empty();
            $.each(result, function(v,i){
                $('.body-locales').append('<tr>'+
                                '<td>'+i.identificador+'</td>'+
                                '<td>'+i.area.nombre+'</td>'+
                                '<td>'+
                                '<a href="javascript:void(0)" onclick="EditarLocal(this.id)" id="'+i.id_local+'" class="text-warning p-2"><i class="fa fa-edit"></i></a>'+
                                '<a href="javascript:void(0)" class="text-danger p-2"><i class="fa fa-trash"></i></a>'+
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

jQuery('#formLocal').on("submit", function(e){
    e.preventDefault();
    $('.btn-submitL').hide();
    $('.btn-preloaderL').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/crearLocal",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            LoadLocal();
            alertify.success(result.mensaje);
            $("#formLocal")[0].reset();
            $('.btn-submitL').show();
            $('.btn-preloaderL').hide();
        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                alertify.error(i[0]);
            });
            $('.btn-submitL').show();
            $('.btn-preloaderL').hide();
        }
    });

});

function EditarLocal(id)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/editarLocal/"+id,
        method: 'GET',
        success: function(result){
            
            $('.inputIDLocal').val(result.local.id_local);
            $('.inputIdentificador').val(result.local.identificador);
            $('.inputDireccion').val(result.local.direccion);

            $('.inputAreaSelectEdit').html('<option value="">Seleccionar</option>');

            $.each(result.areas, function(y,b){
                if (b.id_area == result.local.area_id) {
                  $('.inputAreaSelectEdit').append('<option value="'+b.id_area+'" selected>'+b.nombre+'</option>');
                }else{
                  $('.inputAreaSelectEdit').append('<option value="'+b.id_area+'">'+b.nombre+'</option>');
                }                
            })

            $('.divFormLocalEdit').show();
            $('.divFormLocalNuevo').hide();

            $('.titleLocalNuevo').hide();
            $('.titleLocalEditar').show();   
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

function CancelarLocal()
{
    $('.divFormLocalEdit').hide();
    $('.divFormLocalNuevo').show()
    $('.titleLocalNuevo').show();
    $('.titleLocalEditar').hide();   
    $("#formEditarLocal")[0].reset();
    alertify.error('Edición cancelada.');
}

jQuery('#formEditarLocal').on("submit", function(e){
    e.preventDefault();
    $('.btn-submitLE').hide();
    $('.btn-preloaderLE').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/updateLocal/"+$('.inputIDLocal').val(),
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            LoadLocal();
            alertify.success(result.mensaje);
            $('.divFormLocalEdit').hide();
            $('.divFormLocalNuevo').show()
            $('.titleLocalNuevo').show();
            $('.titleLocalEditar').hide();  
            $("#formEditarLocal")[0].reset();
            $('.btn-submitLE').show();
            $('.btn-preloaderLE').hide();
        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                alertify.error(i[0]);
            });
            $('.btn-submitLE').show();
            $('.btn-preloaderLE').hide();
        }
    });

});