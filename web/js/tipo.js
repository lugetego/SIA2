var $participacion = $("#createSolicitud_motivo_2");

$(document).ready(function(){

    $participacion.change(function(){
        if ( document.getElementById('createSolicitud_motivo_2').checked )
        {
            $('#createSolicitud_tituloTrabajo').attr('readonly', false);
        }
        else{
            $('#createSolicitud_tituloTrabajo').attr('readonly', true);
        }
    });
});
