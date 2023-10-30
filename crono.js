var inicio=0;
var timeout=0;
var result=0

function empezarDetener(elemento){
    if(timeout==0){
        // empezar el cronometro
        elemento.value="Detener";
        // Obtenemos el valor actual
        inicio=new Date().getTime();
        // Guardamos el valor inicial en la base de datos del navegador
        localStorage.setItem("inicio",inicio);
        // iniciamos el proceso
        funcionando();
    }else{
        // detemer el cronometro
        elemento.value="Empezar";
        clearTimeout(timeout);
        // Eliminamos el valor inicial guardado
        localStorage.removeItem("inicio");
        timeout=0;
    }
}

function funcionando(){
    // obteneos la fecha actual
    var actual = new Date().getTime();
    // obtenemos la diferencia entre la fecha actual y la de inicio
    var diff=new Date(actual-inicio);
    // mostramos la diferencia entre la fecha actual y la inicial
    var tempsImcrement=LeadingZero(diff.getUTCHours())+":"+LeadingZero(diff.getUTCMinutes())+":"+LeadingZero(diff.getUTCSeconds());
    console.log(tempsImcrement);
    // Indicamos que se ejecute esta función nuevamente dentro de 1 segundo
    timeout=setTimeout("funcionando()",1000);
}

/* Funcion que pone un 0 delante de un valor si es necesario */
function LeadingZero(Time){
    return (Time < 10) ? "0" + Time : + Time;
}

window.onload=function(){
    if(localStorage.getItem("inicio")!=null){
        // Si al iniciar el navegador, la variable inicio que se guarda
        // en la base de datos del navegador tiene valor, cargamos el valor
        // y iniciamos el proceso.
        inicio=localStorage.getItem("inicio");
        funcionando();

    }
}
