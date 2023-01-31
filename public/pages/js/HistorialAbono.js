$(document).ready(function() {
    $(".js-example-basic-single").select2();
});

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
        url: "/getArriendosAbonos/"+event,
        method: 'GET',
        success: function(result){
            if(result.arriendo.length == 0)
            {   
                alertify.error("Sin arriendos ingresados.");
                $('.listArriendo').empty();
                $('.divArriendo').hide();
                $('.listFactura').empty();
                $('.divFactura').hide();
                $('.listAbonos').empty();
                $('.divAbonos').hide();
                return;
            }

            $('.listArriendo').empty();
            $.each(result.arriendo, function(v,i){
                $('.listArriendo').append('<li>'+
                                            '<a href="javascript:void(0)">'+
                                                '<div class="d-flex align-items-start">'+
                                                    '<div class="flex-grow-1 overflow-hidden">'+
                                                        '<h5 class="text-truncate font-size-14 mb-1">N° '+i.sku+'</h5>'+
                                                        '<input type="month" onChange="verFacturas(this.id, this.value)" id="'+i.sku+'" class="form-control form-control-sm mesArriendo'+i.sku+'">'+
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
            
            $('.listFactura').empty();
            $('.divFactura').hide();
            $('.listAbonos').empty();
            $('.divAbonos').hide();
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

function verFacturas(sku,value)
{       
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getFacturaDeArriendo/"+sku+"/"+value,
        method: 'GET',
        success: function(result){
            if(result.length == 0)
            {   
                alertify.error("Sin facturas ingresadas.");
                $('.listAbonos').empty();
                $('.divAbonos').hide();
                $('.listFactura').empty();
                $('.divFactura').hide();
                return;
            }

            $('.listFactura').empty();
            $.each(result, function(v,i){
                $('.listFactura').append('<li>'+
                                            '<a href="javascript:void(0)" onclick="verAbonos(this.id)" id="'+i.id_factura+'">'+
                                                '<div class="d-flex align-items-start">'+
                                                    '<div class="flex-grow-1 overflow-hidden">'+
                                                        '<h5 class="text-truncate font-size-14 mb-1">Facturación N° '+i.n_factura+'</h5>'+
                                                        '<p class="text-truncate mb-0"><b>Monto:</b> $'+i.monto_total+'</p>'+
                                                    '</div>'+
                                                    '<div class="flex-shrink-0">'+
                                                        '<div class="font-size-11">2022-05-14</div>'+
                                                    '</div>'+
                                                    '<div class="unread-message estadoFactura'+i.sku+'">'+
                                                        
                                                    '</div>'+
                                                '</div>'+
                                           '</a>'+
                                        '</li>');

                if(i.estado_id == 9)
                {
                    $('.estadoFactura'+i.sku).html('<span class="badge bg-warning" style="padding: 5px;">Pendiente Pago</span>');
                }else if(i.estado_id == 8)
                {
                    $('.estadoFactura'+i.sku).html('<span class="badge bg-success" style="padding: 5px;">Pagado</span>');
                }
            });
            alertify.success("Facturas encontradas.");
            $('.listAbonos').empty();
            $('.divAbonos').hide();
            $('.divFactura').show();
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

function verAbonos(id)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getAbonoFactura/"+id,
        method: 'GET',
        success: function(result){
            if(result.length == 0)
            {   
                alertify.error("Sin abonos ingresados.");
                $('.listAbonos').empty();
                $('.divAbonos').hide();
                return;
            }

            $('.listAbonos').empty();
            $.each(result, function(v,i){
                $('.listAbonos').append('<li>'+
                                            '<a href="javascript:void(0)" onclick="verDetalleAbono(this.id)" id ="'+i.sku+'">'+
                                                '<div class="d-flex align-items-start">'+
                                                    '<div class="flex-grow-1 overflow-hidden">'+
                                                        '<h5 class="text-truncate font-size-14 mb-1">N° '+i.sku+'</h5>'+
                                                        '<p class="text-truncate mb-0"><b>Monto:</b> $'+i.monto+'</p>'+
                                                    '</div>'+
                                                    '<div class="flex-shrink-0">'+
                                                        '<div class="font-size-11">2022-05-14</div>'+
                                                    '</div>'+
                                                    '<div class="unread-message estadoAbono'+i.sku+'">'+
                                                    '</div>'+
                                                '</div>'+
                                           '</a>'+
                                        '</li>');

                if(i.estado_id == 12)
                {
                    $('.estadoAbono'+i.sku).html('<span class="badge bg-warning" style="padding: 5px;">No Rendida</span>');
                }else if(i.estado_id == 11) 
                {
                    $('.estadoAbono'+i.sku).html('<span class="badge bg-success" style="padding: 5px;">Rendida</span>');
                }else if(i.estado_id == 13)
                {
                    $('.estadoAbono'+i.sku).html('<span class="badge bg-danger" style="padding: 5px;">Anulado</span>');
                }
            });

            alertify.success("Abonos encontrados.");
            $('.divAbonos').show();
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

function verDetalleAbono(sku)
{   

    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getDetalleAbono/"+sku,
        method: 'GET',
        success: function(result){
            $('.divTitular').hide();
            $('.divBanco').hide();
            $('.divCheque').hide();
            $('.divVencimiento').hide();
            $('.divTransaccion').hide();
            $('.divFtransaccion').hide();
            $('.btnAnularAbono').hide();
            $('.btnMotivoAnulacion').hide();

            $('.inputPago').val(result.detalle.tipo_pago.nombre);
            $('.inputMonto').val(result.detalle.monto);
            $('.inputFechaAbono').val(result.detalle.fecha_emision);
            
            if(result.detalle.titular != null)
            {   
                $('.divTitular').show();
                $('.inputTitular').val(result.detalle.titular);
            }

            if(result.detalle.entidad_id != null)
            {   
                $('.divBanco').show();
                $('.inputBanco').val(result.detalle.entidad_financiera.nombre);
            }

            if(result.detalle.n_cheque != null)
            {   
                $('.divCheque').show();
                $('.inputCheque').val(result.detalle.n_cheque);
            }

            if(result.detalle.fecha_vencimiento != null)
            {   
                $('.divVencimiento').show();
                $('.inputVencimiento').val(result.detalle.fecha_vencimiento);
            }

            if(result.detalle.n_transferencia != null)
            {   
                $('.divTransaccion').show();
                $('.inputTransaccion').val(result.detalle.n_transferencia);
            }

            if(result.detalle.fecha_transaccion != null)
            {   
                $('.divFtransaccion').show();
                $('.inputFtransaccion').val(result.detalle.fecha_transaccion);
            }

            $('.btnAnularAbono').hide();
            $('.btnMotivoAnulacion').hide();
            
            if(result.detalle.estado_id == 12)
            {   
                if(result.permisoAnular == 1)
                {
                    $('.btnAnularAbono').show();
                    $('.btnAnularAbono').attr('id', result.detalle.id_abono);
                }
            }else if(result.detalle.estado_id == 13)
            {
                $('.btnMotivoAnulacion').show();
                $('.btnMotivoAnulacion').attr('id', result.detalle.id_abono);
            }

            $('#infoDetalleAbono').modal('show');
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

    $('#modalInforAbono').modal('show');
}

function verMotivoAnulacion(id)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/verMotivoAnulacionAbono/"+id,
        method: 'GET',
        success: function(result){
            $('.inputUsuarioAnulacion').val(result.user_anulacion.name);
            $('.inputFechaAnulacion').val(result.fecha_anulacion);
            $('.inputMotivoAnulacion').val(result.motivo);

            $('#modalMotivoAnulacion').modal('show');
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

function anularAbono(id)
{   
    $('.inputIdAbono').val(id);
    $('#modalAnularAbono').modal('show');
}

jQuery('#formAnulacion').on("submit", function(e){
    e.preventDefault();
    $('.btn-submit').hide();
    $('.btn-preloader').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/anularAbono",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){

            $("#formAnulacion")[0].reset();
            $('#modalAnularAbono').modal('hide');
            $('#infoDetalleAbono').modal('hide');
            verAbonos(result);
            alertify.error("Abono anulado exitosamente.");
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
