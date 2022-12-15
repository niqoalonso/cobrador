function ShowEmpresa(id)
{
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionEmpresas/"+id,
        method: 'GET',
        success: function(result){
            $('.inputRUT').val(result.rut);
            $('.inputRazonSocial').val(result.razon_social);
            $('.inputFantasia').val(result.nombre_fantasia);
            $('.inputAlias').val(result.alias);
            $('.inputCorreo').val(result.correo);
            $('.inputTelefono').val(result.telefono);
            $('.inputCelular').val('+56'+result.celular);
            if(result.solicita_fac_email == 0)
            {
                $('.inputFactura').val('NO');
            }else{
                $('.inputFactura').val('SI');
            }
            
            $('#infoEmpresaModal').modal('show');
            alertify.success('Informacion Cargada.');
        },
        error: function(result){
            console.clear();
            $.each(result.responseJSON.errors, function(v,i){
                alertify.success(i[0]);
            });
            $('.btn-submit').show();
            $('.btn-preloader').hide();
        }
    });

}

function DarBaja(id)
{       
    Swal.fire({
        title: 'Cliente',
        text: 'REVISAR ARRIENDOA ANTES DE DAR DE BAJA.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Dar baja.'
      }).then((result) => {
        if (result.isConfirmed) {
            
        }
    });
    
}
