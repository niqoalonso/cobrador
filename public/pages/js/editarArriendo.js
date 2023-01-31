$(document).ready(function() {
    $(".js-example-basic-multiple").select2();
});

jQuery('#formUpdate').on("submit", function(e){
    e.preventDefault();
    $('.btn-submitE').hide();
    $('.btn-preloaderE').show();
    $.ajaxSetup({ 
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestionArriendo/"+$('.inputID').val(),
        method: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(result){
            console.log(result);
            $('.inputContrato').val("");
            if(result.documento != null)
            {
                $('.linkContrato').attr('href', '../../storage/'+result.documento);
            }
            alertify.success(result.mensaje);
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