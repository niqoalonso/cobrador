function getLocalesDisponibles()
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getLocalDisponible",
        method: 'GET',
        success: function(result){
            $('.selectLocales').empty();
            $.each(result, function(v,i){
                $('.selectLocales').append('<option value="'+i.id_local+'" >'+i.identificador+'</option>');
            });
            $(".js-example-basic-multiple").select2(); 
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

function buscarArriendo(data)
{   

    if(data.length == 0)
    {
        $('.divNuevoContrato').hide();
        $('.body-arriendo').empty();
        return;
    }   
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionArriendo/"+data,
        method: 'GET',
        success: function(result){
            $('.idEmpresa').val(result.empresa.id_empresa);
            $('.body-arriendo').empty();
            $('.divNuevoContrato').show();
            $.each(result.arriendos, function(v,i){
                if(i.estado_id == 5)
                {
                    $('.body-arriendo').append('<tr>'+
                                '<td class="text-center" > <a href="storage/'+i.url_contrato+'" target="_blank"> <button class="btn btn-success btn-sm"><i class="fa fa-file"></i> Ver</button> </a></td>'+
                                '<td>$'+i.valor_arriendo+'</td>'+
                                '<td>'+i.fecha_inicio+'</td>'+
                                '<td><span class="badge bg-success">En Curso</span></td>'+
                                '<td>'+
                                '<a href="javascript:void(0)" onclick="verContrato(this.id)" id="'+i.id_arriendo+'" class="text-primary p-2"><i class="fa fa-info-circle"></i></a>'+
                                '<a href="/gestionArriendo/'+i.sku+'/edit" class="text-warning p-2"><i class="fa fa-edit"></i></a>'+
                                '<a href="javascript:void(0)" onclick="EliminarArea(this.id)" id="'+i.id_area+'" class="text-danger p-2"><i class="fa fa-trash"></i></a>'+
                                '</td>'+
                                '</tr>');
                }else if(i.estado_id == 6){
                    $('.body-arriendo').append('<tr>'+
                                '<td class="text-center"> <a href="storage/'+i.url_contrato+'" target="_blank"> <button class="btn btn-success btn-sm"><i class="fa fa-file"></i> Ver</button> </a> </td>'+
                                '<td>$'+i.valor_arriendo+'</td>'+
                                '<td>'+i.fecha_inicio+'</td>'+
                                '<td><span class="badge bg-warning">No Iniciado</span></td>'+
                                '<td>'+
                                '<a href="javascript:void(0)" onclick="verContrato(this.id)" id="'+i.id_arriendo+'" class="text-primary p-2"><i class="fa fa-info-circle"></i></a>'+
                                '<a href="/gestionArriendo/'+i.sku+'/edit" class="text-warning p-2"><i class="fa fa-edit"></i></a>'+
                                '<a href="javascript:void(0)" onclick="EliminarArea(this.id)" id="'+i.id_area+'" class="text-danger p-2"><i class="fa fa-trash"></i></a>'+
                                '</td>'+
                                '</tr>');
                }else{
                    $('.body-arriendo').append('<tr>'+
                                '<td class="text-center"> <a href="storage/'+i.url_contrato+'" target="_blank"> <button class="btn btn-success btn-sm"><i class="fa fa-file"></i> Ver</button> </a> </td>'+
                                '<td>$'+i.valor_arriendo+'</td>'+
                                '<td>'+i.fecha_inicio+'</td>'+
                                '<td><span class="badge bg-danger">Terminado</span></td>'+
                                '<td>'+
                                '<a href="javascript:void(0)" onclick="verContrato(this.id)" id="'+i.id_arriendo+'" class="text-primary p-2"><i class="fa fa-info-circle"></i></a>'+
                                '<a href="/gestionArriendo/'+i.sku+'/edit" class="text-warning p-2"><i class="fa fa-edit"></i></a>'+
                                '<a href="javascript:void(0)" onclick="EliminarArea(this.id)" id="'+i.id_area+'" class="text-danger p-2"><i class="fa fa-trash"></i></a>'+
                                '</td>'+
                                '</tr>');
                }
                
            }); 

            getLocalesDisponibles();
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

function verContrato(id)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionArriendoOnly/"+id,
        method: 'GET',
        success: function(result){
            $('.inputValorArriendo').val(result.valor_arriendo);
            $('.inputFechaInicio').val(result.fecha_inicio);
            $('.inputFechaTermino').val(result.fecha_termino);

            $('.divLocales').empty();
            $.each(result.local, function(v,i){
                $('.divLocales').append('<div class="col-3 mb-2">'+
                                        '<div class="form-group">'+
                                        '<div class="form-check">'+
                                        '- '+
                                        '<label class="form-check-label">'+i.identificador+'</label>'+
                                        '</div></div></div>');
            });

            $('#infoContrato').modal('show');
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

jQuery('#formNuevoContrato').on("submit", function(e){
    e.preventDefault();
    $('.btn-submit').hide();
    $('.btn-preloader').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionArriendo",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            $("#formNuevoContrato")[0].reset();
            buscarArriendo(result.id_empresa);

            alertify.success(result.mensaje);
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
