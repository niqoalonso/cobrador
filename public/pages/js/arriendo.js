function buscarArriendo(data)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionArriendo/"+data.value,
        method: 'GET',
        success: function(result){
            $('.body-arriendo').empty();

            $.each(result, function(v,i){
                if(i.estado_id == 5)
                {
                    $('.body-arriendo').append('<tr>'+
                                '<td class="text-center" > <a href="storage/'+i.url_contrato+'" target="_blank"> <button class="btn btn-success btn-sm"><i class="fa fa-file"></i> Ver</button> </a></td>'+
                                '<td>$'+i.valor_arriendo+'</td>'+
                                '<td>'+i.fecha_inicio+'</td>'+
                                '<td><span class="badge bg-success">Vigente</span></td>'+
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
                                '<td><span class="badge bg-danger">Finalizado</span></td>'+
                                '<td>'+
                                '<a href="javascript:void(0)" onclick="verContrato(this.id)" id="'+i.id_arriendo+'" class="text-primary p-2"><i class="fa fa-info-circle"></i></a>'+
                                '<a href="/gestionArriendo/'+i.sku+'/edit" class="text-warning p-2"><i class="fa fa-edit"></i></a>'+
                                '<a href="javascript:void(0)" onclick="EliminarArea(this.id)" id="'+i.id_area+'" class="text-danger p-2"><i class="fa fa-trash"></i></a>'+
                                '</td>'+
                                '</tr>');
                }
                
            }); 
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