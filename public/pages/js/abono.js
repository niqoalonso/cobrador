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
        url: "/getFacturacionPagoPendiente/"+event,
        method: 'GET',
        success: function(result){
            console.log(result);
                $('.skuEmpresa').val(result.sku);
                $('.contentFactura').empty();
            $.each(result.arriendo, function(v,i){
                    
                if(i.factura_pendientes.length != 0)
                {   
                    $('.contentFactura').append('<div class="row">'+
                                                '<div class="col-12 text-center">'+
                                                ' <h5>Arriendo n°'+i.sku+'</h5>'+
                                                    '<hr>'+
                                                '</div>'+
                                                '<div class="col-12">'+
                                                    '<div class="row abonos'+v+'">'+
                                                        
                                                    '</div>'+
                                                '</div>'+
                                            '</div>');
                    $.each(i.factura_pendientes, function(b,y){
                        
                            $('.abonos'+v).append('<div class="col-xl-4 col-sm-6 col-12">'+
                                                '<div class="card">'+
                                                    '<div class="card-body overflow-hidden position-relative">'+
                                                        '<div>'+
                                                            '<i class="bx bx-detail widget-box-1-icon text-primary"></i>'+
                                                        '</div>'+
                                                        '<div class="faq-count">'+
                                                            '<h5 class="text-primary">N° Facturación: <small>'+y.n_factura+'</small></h5>'+
                                                        '</div>'+
                                                        '<h5 class="mt-3">$'+y.monto_total+'</h5>'+
                                                        '<div class="row">'+
                                                            '<div class="col-6">'+
                                                                '<p class="text-muted mt-3 mb-0"><b>Fecha:</b> '+y.fecha_emision+'</p>'+
                                                            '</div>'+
                                                            '<div class="col-6">'+
                                                                '<p class="text-muted mt-3 mb-0"><b>Pendiente:</b> $'+y.monto_pendiente+' </p>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<hr>'+
                                                        '<div class="row">'+
                                                            '<div class="col-4">'+
                                                                '<div class="d-grid gap-2">'+
                                                                    '<button class="btn btn-sm btn-warning" onclick="verLocales(this.id)" id="'+i.sku+'" type="button"><i class="fa fa-home"></i> Locales</button>'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="col-4">'+
                                                                '<div class="d-grid gap-2">'+
                                                                    '<button class="btn btn-sm btn-info" onclick="verDetalle(this.id)" id="'+y.id_factura+'" type="button"><i class="fa fa-info"></i> Ver Abonos</button>'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="col-4">'+
                                                                '<div class="d-grid gap-2">'+
                                                                    '<button class="btn btn-sm btn-success" onclick="nuevoAbono(this.id)" id="'+y.id_factura+'" type="button"><i class="fa fa-plus-circle"></i> Abonar</button>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div></div>');
                    });
                    
                }else{
                    $('.contentFactura').html('<h5>No se han encontrado facturaciones pendientes.</h5>');
                    return;
                }
                
                
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

function nuevoAbono(id)
{
    $('.idFactura').val(id);
    $('#nuevoAbono').modal('show');
}

function selectTipoPago(data)
{   
    if(data == 2)
    {
        $('.inputTitular').show();
        $('.inputBanco').show();
        $('.inputCheque').show();
        $('.inputVencimiento').show();
        $('.inputTransaccion').hide();
        $('.inputFTransaccion').hide();
        
        $('.iTransaccion').val("");
        $('.iFtransaccion').val("");
        $('.iFabono').val("");
        $('.iMonto').val("");

    }else if(data == 3)
    {
        $('.inputTitular').hide();
        $('.inputBanco').show();
        $('.inputCheque').hide();
        $('.inputVencimiento').hide();
        $('.inputTransaccion').show();
        $('.inputFTransaccion').show();
        
        $('.iTitular').val("");
        $('.iNcheque').val("");
        $('.iNcheque').val("");
        $('.iFvencimiento').val("");
        $('.iFabono').val("");
        $('.iMonto').val("");
    }else if(data == 1)
    {
        $('.inputTitular').hide();
        $('.inputBanco').hide();
        $('.inputCheque').hide();
        $('.inputVencimiento').hide();
        $('.inputTransaccion').hide();
        $('.inputFTransaccion').hide();

        $('.iTitular').val("");
        $('.iNcheque').val("");
        $('.iNcheque').val("");
        $('.iFvencimiento').val("");
        $('.iTransaccion').val("");
        $('.iFtransaccion').val("");
        $('.iFabono').val("");
        $('.iMonto').val("");
    }
}

jQuery('#formNuevoAbono').on("submit", function(e){
    e.preventDefault();
    $('.btn-submit').hide();
    $('.btn-preloader').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionAbono",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            if(result.status == 0)
            {
                alertify.error(result.mensaje);
            }else if(result.status == 1)
            {   
                $("#formNuevoAbono")[0].reset();
                $('.skuEmpresa').val(result.sku);
                alertify.success(result.mensaje);
                selectCliente(result.sku);
                $('#nuevoAbono').modal('hide');

                $('.inputTitular').hide();
                $('.inputBanco').hide();
                $('.inputCheque').hide();
                $('.inputVencimiento').hide();
                $('.inputTransaccion').hide();
                $('.inputFTransaccion').hide();

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

function verDetalle(data)
{   
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getAbonoFactura/"+data,
        method: 'GET',
        success: function(result){
            $('.listAbono').empty();
            if(result.length == 0)
            {   
                $('.listAbono').html('<p>No se han encontrado abonos.</p>');
                return;
            }
            $.each(result, function(v,i){
                $('.listAbono').append('<li>'+
                                        '<a href="javascript:void(0)" onclick="verDetalleAbono(this.id)" id ="'+i.sku+'">'+
                                            '<div class="d-flex align-items-start">'+
                                                '<div class="flex-grow-1 overflow-hidden">'+
                                                    '<h5 class="text-truncate font-size-14 mb-1">N° '+i.sku+'</h5>'+
                                                    '<p class="text-truncate mb-0"><b>Monto:</b> $'+i.monto+'</p>'+
                                                '</div>'+
                                                '<div class="flex-shrink-0">'+
                                                    '<div class="font-size-11">'+i.fecha_emision+'</div>'+
                                                '</div>'+
                                                '<div class="unread-message estadoAbono'+i.sku+'">'+
                                                    '<span class="badge bg-success" style="padding: 5px;">Pagado</span>'+
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

            $('.inputPago').val(result.tipo_pago.nombre);
            $('.inputMonto').val(result.monto);
            $('.inputFechaAbono').val(result.fecha_emision);
            
            if(result.titular != null)
            {   
                $('.divTitular').show();
                $('.inputTitular').val(result.titular);
            }

            if(result.entidad_id != null)
            {   
                $('.divBanco').show();
                $('.inputBanco').val(result.entidad_financiera.nombre);
            }

            if(result.n_cheque != null)
            {   
                $('.divCheque').show();
                $('.inputCheque').val(result.n_cheque);
            }

            if(result.fecha_vencimiento != null)
            {   
                $('.divVencimiento').show();
                $('.inputVencimiento').val(result.fecha_vencimiento);
            }

            if(result.n_transferencia != null)
            {   
                $('.divTransaccion').show();
                $('.inputTransaccion').val(result.n_transferencia);
            }

            if(result.fecha_transaccion != null)
            {   
                $('.divFtransaccion').show();
                $('.inputFtransaccion').val(result.fecha_transaccion);
            }
            
            if(result.estado_id == 12)
            {   
                $('.btnAnularAbono').show();
                $('.btnAnularAbono').attr('id', result.id_abono);
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
            $('#modalInforAbono').modal('hide');
            verDetalle(result);
            alertify.danger("Abono anulado exitosamente.");
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