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
                url: "/aprobarRendicionAbonos/"+id,
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
                                                            '<button class="btn btn-sm btn-info" onclick="verAbono(this.id)" id="'+i.id_rendicion+'"><i class="fa fa-eye"></i></button>'+
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