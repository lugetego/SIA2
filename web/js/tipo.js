var $participacion = $("#createActividad_motivo_2");

$(document).ready(function(){

    $participacion.change(function(){
        if ( document.getElementById('createActividad_motivo_2').checked )
        {
            $('#createActividad_tituloTrabajo').attr('readonly', false);
        }
        else{
            $('#createActividad_tituloTrabajo').attr('readonly', true);
        }
    });
});
