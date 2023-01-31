
function RendirAbonos()
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/storeRendicionAbono",
        method: 'GET',
        success: function(result){
            
            alertify.success(result);
            $('.divBotonRendir').hide();
            $('.divTablaDatos').hide();
            $('.divNoRigistros').show();
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

function changeMes(data)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getHistorialRendicionAbono/"+data,
        method: 'GET',
        success: function(result){
            console.log(result);
            if(result.length == 0)
            {   
                alertify.error("Rendiciones no encontradas");
                return false;
            } 

            $('.body-rendicion').empty();
            $.each(result, function(i,v){
                        
                $('.body-rendicion').append('<tr>'+
                                        '<td>'+v.folio+'</td>'+
                                        '<td>$'+v.monto_efectivo+'</td>'+
                                        '<td>$'+v.monto_cheque+'</td>'+
                                        '<td>$'+v.monto_transferencia+'</td>'+
                                        '<td>$'+v.monto+'</td>'+
                                        '<td>'+v.fecha_emision+'</td>'+
                                        '<td class="text-center"><button class="btn btn-sm btn-info" onclick="verAbono(this.id)" id="'+v.id_rendicion+'"><i class="fa fa-eye"></i></button></td>'+
                                        '</tr>');
        });

        $('.divRendiciones').show();
        alertify.success("Rendiciones encontradas");

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

function verAbono(data)
{   
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getAbonosRendicion/"+data,
        method: 'GET',
        success: function(result){
            $('.listAbono').empty();
            if(result.length == 0)
            {   
                $('.listAbono').html('<p>No se han encontrado abonos.</p>');
                return;
            }
            $.each(result, function(v,i){
                console.log(i);
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
            $('.btnMotivoAnulacion').hide();

            $('.inputPago').val(result.detalle.tipo_pago.nombre);
            $('.inputMonto').val(result.detalle.monto);
            $('.inputFechaAbono').val(result.detalle.fecha_emision);
            
            if(result.detalle.titular != null)
            {   
                $('.divTitular').show();
                $('.inputTitular').show();
                $('.inputTitular').val(result.detalle.titular);
            }

            if(result.detalle.entidad_id != null)
            {   
                $('.divBanco').show();
                $('.inputBanco').show();
                $('.inputBanco').val(result.detalle.entidad_financiera.nombre);
            }

            if(result.detalle.n_cheque != null)
            {   
                $('.divCheque').show();
                $('.inputCheque').show();
                $('.inputCheque').val(result.detalle.n_cheque);
            }

            if(result.detalle.fecha_vencimiento != null)
            {   
                $('.divVencimiento').show();
                $('.inputVencimiento').show();
                $('.inputVencimiento').val(result.detalle.fecha_vencimiento);
            }

            if(result.detalle.n_transferencia != null)
            {   
                $('.divTransaccion').show();
                $('.inputTransaccion').show();
                $('.inputTransaccion').val(result.detalle.n_transferencia);
            }

            if(result.detalle.fecha_transaccion != null)
            {   
                $('.divFtransaccion').show();
                $('.inputFtransaccion').show();
                $('.inputFtransaccion').val(result.detalle.fecha_transaccion);
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