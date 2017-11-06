var inicio = document.getElementById('createSolicitud_fechaInicio');
var fin = document.getElementById('createSolicitud_fechaFin');

fin.onfocus = function(){

    var a = moment(inicio.value,"YYYY-MM-DD");
    var b = moment(fin.value, "YYYY-MM-DD");
    var days = 0;

    if (a.isValid){
        if (b.isValid){
            if( b.isSameOrAfter(a)){
                days = b.diff(a,'days') + 1 ;
                if( days > 45 ){
                    document.getElementById('days').innerHTML= ' <i class="fa fa-exclamation-triangle"></i> solicita más de 45 días!';
                }
                else{
                    if ( (inicio.value == '') && (fin.value == '')  ){
                        document.getElementById('days').innerHTML= 'No se han seleccionado correctamente las fechas';
                    }
                    else
                        document.getElementById('days').innerHTML= days + ' días solicitados';
                }
            }
            else{
                document.getElementById('days').innerHTML= ' <i class="fa fa-exclamation-triangle"></i> Revisar las fechas';
            }
        }
        else {
            document.getElementById('days').innerHTML= 'Fechas inválidas';
        }
    }

    /*//if ( a.isValid() && b.isValid() && (b.isSame(a)) || (b.isAfter(a))){
     if ( a.isValid() ){


     days = b.diff(a,'days') + 1 ;



     if( days > 45 ){
     document.getElementById('days').innerHTML= ' <i class="fa fa-exclamation-triangle"></i> solicita más de 45 días!';
     *//*            fin.value = '';*//*
     }
     else{

     if ( (inicio.value == '') && (fin.value == '')  ){

     document.getElementById('days').innerHTML= ' No se han seleccionado correctamente las fechas';

     }
     else
     document.getElementById('days').innerHTML= days + ' días solicitados';
     }
     }

     else {
     if( a.isValid == false ){
     document.getElementById('days').innerHTML= 'Fecha de inicio inválida';
     inicio.value = '';}
     if( b.isValid == false ){
     fin.value = '';
     }

     document.getElementById('days').innerHTML= 'Fechas inválidas';
     inicio.value = '';
     fin.value = '';

     }
     */
}