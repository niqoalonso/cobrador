$(document).ready(function() {
    $(".js-example-basic-single").select2();
});

function motivoAnulacionVer(id)
{   
    $('.divMotivoAnulacion').html('<p>'+id+'</p>');
    $('#modalInformacionDetalleAnulacion').modal('show');
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

function confirmarAnulacion(id)
{   
    $('.inputIdAbono').val(id);
    $('#modalAnularAbono').modal('show');
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
        url: "/aceptarAnulacionAbono",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){

            $('.body-anulacion').empty();
            if(result.data.length > 0)
            {
                $.each(result.data, function(v,i){
                    $('.body-anulacion').append('<tr>'+    
                                                '<td>'+i.factura.arriendo.empresa.rut+'</td>'+
                                                '<td>'+i.factura.arriendo.empresa.alias+'</td>'+
                                                '<td>$'+i.monto+'</td>'+
                                                '<td class="text-center"><a href="javascript:void(0)" onclick="motivoAnulacionVer(this.id)" id="'+i.motivo+'" class="text-warning p-2"><i class="fa fa-exclamation-triangle"></i></a>'+
                                                '<td>'+i.fecha_emision+'</td>'+
                                                '<td class="text-center">'+
                                                '<a href="javascript:void(0)" class="text-info p-2" onclick="verDetalleAbono(this.id)" id="'+i.sku+'"><i class="fa fa-list-alt"></i></a>'+
                                                '<a href="javascript:void(0)" class="text-success p-2" onclick="confirmarAnulacion(this.id)" id="'+i.id_abono+'"><i class="fa fa-check-circle"></i></a>'+
                                                '</td>'+
                                                '</tr>');
                });
            }

            $("#formAceptaAnulacion")[0].reset();
            $('#modalAnularAbono').modal('hide');

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