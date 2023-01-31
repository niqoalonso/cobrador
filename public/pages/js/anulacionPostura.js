$(document).ready(function() {
    $(".js-example-basic-single").select2();
});

var list=new Array;

function selectCliente(event)
{   
    if(event.length == 0)
    {   
        $('.contentFactura').empty();
        return;
    }
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getArriendosPosturas/"+event,
        method: 'GET',
        success: function(result){
            if(result.arriendo.length == 0)
            {   
                alertify.error("Sin arriendos ingresados.");
                $('.listArriendo').empty();
                $('.divArriendo').hide();
                return;
            }

            $('.listArriendo').empty();
            $.each(result.arriendo, function(v,i){
                $('.listArriendo').append('<li>'+
                                            '<a href="javascript:void(0)">'+
                                                '<div class="d-flex align-items-start">'+
                                                    '<div class="flex-grow-1 overflow-hidden">'+
                                                        '<h5 class="text-truncate font-size-14 mb-1">N° '+i.sku+'</h5>'+
                                                        '<div class="row"><div class="col-12">'+
                                                        '<div class="d-grid gap-2">'+
                                                            '<button class="btn btn-success btn-sm" type="button" onclick="buscarPostura('+i.sku+')"><i class="fa fa-search"></i> Buscar Posturas</button>'+
                                                        '</div>'+
                                                        '</div></div>'+
                                                    '</div>'+
                                                    '<div class="flex-shrink-0">'+
                                                        '<div class="font-size-11"><b>N°</b> '+i.sku+'</div>'+
                                                    '</div>'+
                                                    '<div class="unread-message"><button class="btn btn-warning btn-sm" onclick="verLocales(this.id)" id="'+i.sku+'"><i class="fa fa-home"></i></button></div>'+
                                                '</div>'+
                                            '</a>'+
                                        '</li>');
            });

            alertify.success("Arriendos encontrados.");
            
            $('.divPosturas').hide();
            $('.listPosturas').empty();
            $('.divArriendo').show();
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

function buscarPostura(sku)
{   
    $('.listPosturas').empty();
    $('.divPosturas').hide();
    $('.inputIdBusqueda').val(sku);
    $('#modalBuscarPostura').modal('show'); 
}

jQuery('#formBusquedaPostura').on("submit", function(e){
    e.preventDefault();
    $('.btn-submit').hide();
    $('.btn-preloader').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/searchPostura",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            if(result.length > 0)
            {   
                $('.listPosturas').empty();
                $.each(result, function(v,i){
                    $('.listPosturas').append('<li>'+
                                                '<a href="javascript:void(0)" onclick="verDetallePostura('+i.sku+')">'+
                                                    '<div class="d-flex align-items-start">'+
                                                        '<div class="flex-grow-1 overflow-hidden">'+
                                                            '<h5 class="text-truncate font-size-14 mb-1">N° '+i.sku+'</h5>'+
                                                            '<p class="text-truncate mb-0"><b>Monto:</b> $'+i.total+' | <b>Tipo Pago:</b> '+i.tipo_pago.nombre+'</p>'+
                                                        '</div>'+
                                                        '<div class="flex-shrink-0">'+
                                                            '<div class="font-size-11">2022-05-14</div>'+
                                                        '</div>'+
                                                        '<div class="unread-message estadoPago'+v+'">'+
                                                            
                                                        '</div>'+
                                                    '</div>'+
                                                '</a>'+
                                            '</li>');

                        if(i.estado_id == 12)
                        {
                            $('.estadoPago'+v).html('<span class="badge bg-warning" style="padding: 5px;">No Rendido</span>');
                        }else if(i.estado_id == 11)
                        {
                            $('.estadoPago'+v).html('<span class="badge bg-success" style="padding: 5px;">Rendido</span>');
                        }else if(i.estado_id == 13)
                        {
                            $('.estadoPago'+v).html('<span class="badge bg-danger" style="padding: 5px;">Anulado</span>');
                        }
                });

                $('.divPosturas').show();

                $("#formBusquedaPostura")[0].reset();
                $('#modalBuscarPostura').modal('hide'); 

                alertify.success("Posturas encontradas.");

            }else{
                $('.listPosturas').empty();
                $('.divPosturas').hide();

                alertify.error("No se han encontrado posturas.");
            }
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

function verDetallePostura(sku)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getDetallePostura/"+sku,
        method: 'GET',
        success: function(result){
            
            $('#modalVerPostura').modal('show');

            $('.inputSku').val(result.postura.sku);
            $('.inputFecha').val(result.postura.fecha_emision);
            $('.inputTipoPago').val(result.postura.tipo_pago.nombre);
            $('.inputTotal').val(result.postura.total);

            $('.listDetallePostura').empty();

            $.each(result.postura.detalle_postura, function(v,i){
                $('.listDetallePostura').append('<li>'+
                                            '<a href="javascript:void(0)">'+
                                                '<div class="d-flex align-items-start">'+
                                                    '<div class="flex-grow-1 overflow-hidden">'+
                                                        '<h5 class="text-truncate font-size-14 mb-1">'+i.item_postura.nombre+'</h5>'+
                                                        '<div class="d-grid gap-2">'+
                                                            '<p class="text-truncate mb-0"><b>Unitario:</b> $'+i.valor_unitario+' | <b>Total:</b> $'+i.total+'</p>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="flex-shrink-0">'+
                                                        '<div class="font-size-11"><b>Cantidad</b> '+i.cantidad+'</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</a>'+
                                        '</li>');
            });

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

function verLocales(data)
{   
    
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getLocalesArriendo/"+data,
        method: 'GET',
        success: function(result){
            $('.listaLocales').empty();
            $.each(result.local, function(v,i){
                $('.listaLocales').append('<li class="py-1"><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i><b>'+i.area.nombre+'</b> - '+i.identificador+'</li>');
            });
            $('#modalLocales').modal('show');
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

function anularPostura(id)
{
    $('#modalAnularPostura').modal('show');
    $('.inputIdPostura').val(id);
}

function motivoAnulacionVer(id)
{   
    $('.divMotivoAnulacion').html('<p>'+id+'</p>');
    $('#modalInformacionDetalleAnulacion').modal('show');
}

function confirmarAnulacion(id)
{   
    $('.inputIdPostura').val(id);
    $('#modalAnularPostura').modal('show');
}

jQuery('#formAceptaAnulacion').on("submit", function(e){
    e.preventDefault();
    $('.btn-submit').hide();
    $('.btn-preloader').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/aceptarAnulacionPostura",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            console.log(result);
            $('.body-anulacion').empty();
            if(result.data.length > 0)
            {
                $.each(result.data, function(v,i){
                    $('.body-anulacion').append('<tr>'+    
                                                '<td>'+i.arriendo.empresa.rut+'</td>'+
                                                '<td>'+i.arriendo.empresa.alias+'</td>'+
                                                '<td>$'+i.total+'</td>'+
                                                '<td class="text-center"><a href="javascript:void(0)" onclick="motivoAnulacionVer(this.id)" id="'+i.motivo+'" class="text-warning p-2"><i class="fa fa-exclamation-triangle"></i></a>'+
                                                '<td>'+i.fecha_emision+'</td>'+
                                                '<td class="text-center">'+
                                                '<a href="javascript:void(0)" class="text-info p-2"><i class="fa fa-list-alt"></i></a>'+
                                                '<a href="javascript:void(0)" class="text-success p-2" onclick="confirmarAnulacion(this.id)" id="'+i.id_postura+'"><i class="fa fa-check-circle"></i></a>'+
                                                '</td>'+
                                                '</tr>');
                });
            }

            $("#formAceptaAnulacion")[0].reset();
            $('#modalAnularPostura').modal('hide');

            alertify.error(result.mensaje);
            
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
