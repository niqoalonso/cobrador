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

function AprobarRendicion(id)
{
    Swal.fire({
        title: 'Aprobar Rendición',
        text: '¿Esta seguro que desea aprobar rendición?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, aprobar rendición.'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({ 
                headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "/aprobarRendicionPosturas/"+id,
                method: 'get',
                success: function(result){
                    console.log(result);
                    $('.body-rendiciones').empty();
                    if(result.rendiciones.length == 0)
                    {   
                        $('.divTablaDatos').hide();
                        $('.divNoRigistros').show();
                        return;
                    }
                    $.each(result.rendiciones, function(v,i){
                        console.log(i);
                        $('.body-rendiciones').append('<tr>'+
                                                        '<td>'+i.user.name+'</td>'+
                                                        '<td>'+i.folio+'</td>'+
                                                        '<td>$'+i.monto_efectivo+'</td>'+
                                                        '<td>$'+i.monto_cheque+'</td>'+
                                                        '<td>$'+i.monto_transferencia+'</td>'+
                                                        '<td>$'+i.monto+'</td>'+
                                                        '<td>'+i.fecha_emision+'</td>'+
                                                        '<td class="text-center">'+
                                                            '<button class="btn btn-sm btn-info ml-2" onclick="verPosturas(this.id)" id="'+i.id_rendicion+'"><i class="fa fa-eye"></i></button>'+
                                                            '<button class="btn btn-sm btn-success" onclick="AprobarRendicion(this.id)" id="'+i.id_rendicion+'"><i class="fa fa-check-circle"></i></button>'+
                                                        '</td>'+
                                                    '</tr> ');

                    });

                    alertify.success(result.mensaje);
                   
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
}