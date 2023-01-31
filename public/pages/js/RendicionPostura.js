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
            
            $('.btnAnular').attr('id', result.postura.id_postura);
            $('.btnAnular').hide();
            $('.btnMotivoAnulacion').hide();

            if(result.postura.estado_id == 12)
            {   
                if(result.permisoAnular == 1)
                {
                    $('.btnAnular').show();
                    $('.btnAnular').attr('id', result.postura.id_postura);
                }
            }else if(result.postura.estado_id == 13)
            {
                $('.btnMotivoAnulacion').show();
                $('.btnMotivoAnulacion').attr('id', result.postura.id_postura);
            }

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

function RendirPosturas()
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/storeRendicionPostura",
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
        url: "/getHistorialRendicionPostura/"+data,
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
                                        '<td class="text-center"><button class="btn btn-sm btn-info" onclick="verPosturas(this.id)" id="'+v.id_rendicion+'"><i class="fa fa-eye"></i></button></td>'+
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

function verPosturas(id)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getPosturasRendicion/"+id,
        method: 'GET',
        success: function(result){
            $('#modalInfoPosturas').modal('show');
            $('.listPosturas').empty();
            $.each(result, function(v,i){
                console.log(i);
                $('.listPosturas').append('<li>'+
                                        '<a href="javascript:void(0)" onclick="verDetallePostura(this.id)" id ="'+i.sku+'">'+
                                            '<div class="d-flex align-items-start">'+
                                                '<div class="flex-grow-1 overflow-hidden">'+
                                                    '<h5 class="text-truncate font-size-14 mb-1">N° '+i.sku+'</h5>'+
                                                    '<p class="text-truncate mb-0"><b>Monto:</b> $'+i.total+' | <b>Tipo Pago:</b> '+i.tipo_pago.nombre+'</p>'+
                                                '</div>'+
                                                '<div class="flex-shrink-0">'+
                                                    '<div class="font-size-11">'+i.fecha_emision+'</div>'+
                                                '</div>'+
                                                '<div class="unread-message estadoPostura'+i.sku+'">'+
                                                    '<span class="badge bg-success" style="padding: 5px;">Pagado</span>'+
                                                '</div>'+
                                            '</div>'+
                                        '</a>'+
                                    '</li>');

                if(i.estado_id == 12)
                {
                    $('.estadoPostura'+i.sku).html('<span class="badge bg-warning" style="padding: 5px;">No Rendida</span>');
                }else if(i.estado_id == 11)
                {
                    $('.estadoPostura'+i.sku).html('<span class="badge bg-success" style="padding: 5px;">Rendida</span>');
                }else if(i.estado_id == 13)
                {
                    $('.estadoPostura'+i.sku).html('<span class="badge bg-danger" style="padding: 5px;">Anulado</span>');
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
            
            $('.btnAnular').attr('id', result.postura.id_postura);
            $('.btnAnular').hide();
            $('.btnMotivoAnulacion').hide();

            if(result.postura.estado_id == 12)
            {   
                if(result.permisoAnular == 1)
                {
                    $('.btnAnular').show();
                    $('.btnAnular').attr('id', result.postura.id_postura);
                }
            }else if(result.postura.estado_id == 13)
            {
                $('.btnMotivoAnulacion').show();
                $('.btnMotivoAnulacion').attr('id', result.postura.id_postura);
            }

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