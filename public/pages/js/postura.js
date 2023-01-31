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
                                                        '<div class="row"><div class="col-6">'+
                                                        '<div class="d-grid gap-2">'+
                                                            '<button class="btn btn-success btn-sm" type="button" onclick="nuevaPostura('+i.sku+')"><i class="fa fa-plus-circle"></i> Nueva</button>'+
                                                        '</div>'+
                                                        '</div><div class="col-6">'+
                                                        '<div class="d-grid gap-2">'+
                                                            '<button class="btn btn-info btn-sm" type="button" onclick="verPosturaArriendo('+i.sku+')"><i class="fa fa-list"></i> Ver</button>'+
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

function nuevaPostura(sku)
{   
    $('.listPosturas').empty();
    $('.divPosturas').hide();
    $('#infoDetalleAbono').modal('show'); 
    list = new Array;
    $('.listPostura').empty();
    $('.inputIDArriendo').val(sku);
}

function verPosturaArriendo(sku)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/getPosturasArriendo/"+sku,
        method: 'GET',
        success: function(result){
            if(result.postura_n_o_rendidas.length > 0)
            {   
                $('.listPosturas').empty();
                $.each(result.postura_n_o_rendidas, function(v,i){
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

            }else{
                alertify.error("No se han encontrado posturas ingresadas recientemente.");
            }

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

function seleccionarItem(id)
{   
    if(id.length != 0)
    {
        $.ajaxSetup({ 
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/getItemPostura/"+id,
            method: 'GET',
            success: function(result){
                $('.inputID').val(result.id_item_postura);
                $('.inputItemName').val(result.nombre);
                if(result.valor == null)
                {
                    $('.inputMontoUnitario').attr("readonly", false);
                    $('.inputMontoUnitario').val(0);
                }else{
                    $('.inputMontoUnitario').attr("readonly", true);
                    $('.inputMontoUnitario').val(result.valor);
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
    }
    
}

function agregarPostura()
{   
    var alertaExiste = 0;
    var id = $('.inputID').val();
    var nombre = $('.inputItemName').val();
    var cantidad = $('.inputCantidad').val();
    var monto = $('.inputMontoUnitario').val();
    var total = monto*cantidad;

    if(monto.length == 0 || monto == 0)
    {   
        alertify.error("Debe ingresar un monto unitario.");
        return false;
    }

    if(list.length > 0)
    {
        $.each(list, function(v,i){
            if(i.id == id)
            {   
                alertify.error("Item ya esta ingresado.");
                alertaExiste = 1;
                return false;
            }
        });
    }
    
    if(alertaExiste == 1)
    {
        return false;
    }

    item = {'id': id, 'nombre': nombre, 'cantidad': cantidad, 'monto': monto, 'total': total}

    list.push(item);

    $('.listPostura').empty();
    $.each(list, function(v,i){
        $('.listPostura').append('<li>'+
                                    '<a href="javascript:void(0)">'+
                                        '<div class="d-flex align-items-start">'+
                                            '<div class="flex-grow-1 overflow-hidden">'+
                                                '<h5 class="text-truncate font-size-14 mb-1">'+i.nombre+'</h5>'+
                                                '<div class="d-grid gap-2">'+
                                                    '<p class="text-truncate mb-0"><b>Unitario:</b> $'+i.monto+' | <b>Total:</b> $'+i.monto*i.cantidad+'</p>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="flex-shrink-0">'+
                                                '<div class="font-size-11"><b>Cantidad</b> '+i.cantidad+'</div>'+
                                            '</div>'+
                                            '<div class="unread-message"><button class="btn btn-danger btn-sm" onclick="eliminarItem('+i.id+')"><i class="fa fa-trash"></i> Eliminar</button></div>'+
                                        '</div>'+
                                    '</a>'+
                                '</li>');
    });

    $('.selectItemPostura').val("");
    $('.inputID').val("");
    $('.inputItemName').val("");
    $('.inputCantidad').val(1);
    $('.inputMontoUnitario').val("");

}

function eliminarItem(id)
{
    $.each(list, function(v,i){
        if(i.id == id)
        {
            list.splice(v, 1);
            return false;
        }
    });

    $('.listPostura').empty();
    $.each(list, function(v,i){
        $('.listPostura').append('<li>'+
                                    '<a href="javascript:void(0)">'+
                                        '<div class="d-flex align-items-start">'+
                                            '<div class="flex-grow-1 overflow-hidden">'+
                                                '<h5 class="text-truncate font-size-14 mb-1">'+i.nombre+'</h5>'+
                                                '<div class="d-grid gap-2">'+
                                                    '<p class="text-truncate mb-0"><b>Unitario:</b> $'+i.monto+' | <b>Total:</b> $'+i.monto*i.cantidad+'</p>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="flex-shrink-0">'+
                                                '<div class="font-size-11"><b>Cantidad</b> '+i.cantidad+'</div>'+
                                            '</div>'+
                                            '<div class="unread-message"><button class="btn btn-danger btn-sm" onclick="eliminarItem('+i.id+')"><i class="fa fa-trash"></i> Eliminar</button></div>'+
                                        '</div>'+
                                    '</a>'+
                                '</li>');
    });

    alertify.error("Item eliminado exitosamente.");
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

function IngresarPostura()
{   
    var formData = new FormData();
    formData.append('sku', $('.inputIDArriendo').val());
    formData.append('detalle', JSON.stringify(list));
    formData.append('tipo_pago', $('.selectTipoPago').val());
    
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionPostura",
        method: 'POST',
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            
            $('.selectItemPostura').val("");
            $('.inputID').val("");
            $('.inputItemName').val("");
            $('.inputCantidad').val(1);
            $('.inputMontoUnitario').val("");
            $('.inputIDArriendo').val("");

            $('#infoDetalleAbono').modal('hide'); 

            list = new Array;

            alertify.success(result);

        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                Toast.fire({
                    icon: 'warning',
                    text: i,
                });
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
        url: "/anularPostura",
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            $("#formAnulacion")[0].reset();
            $('#modalAnularPostura').modal('hide');
            $('.listDetallePostura').empty();
            $('.inputSku').val("");
            $('.inputFecha').val("");
            $('.inputTipoPago').val(""); 
            $('.inputTotal').val("");
            $('.btnAnular').attr('id', "");
            $('#modalVerPostura').modal('hide');
            $('.listPosturas').empty();
            $('.divPosturas').hide();

            alertify.error("Postura anulada exitosamente.");
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


