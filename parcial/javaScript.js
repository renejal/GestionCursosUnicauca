
function buscar_codigo(){
    var edt;
    edt=document.getElementById("codigo_a_buscar");
    var codigo = edt.value;
    $.ajax({
            url:'server.php',
            method:'POST',
            data:{'codigo':codigo}
        
    }).done(function(respuesta) {
        /*Mostras la respuesta DOM*/ 
        informacion_es=document.getElementById("informacion");
        informacion_es.innerHTML=respuesta;
       
    }).fail(function(jqXHR) {
        alert(jqXHR.statusText);
    });
}
function buscar_codigomodal(){
    edt=document.getElementById("codigo_a_buscarmodal");
    var codigo = edt.value;
    $.ajax({
            url:'server.php',
            method:'POST',
            data:{'codigo':codigo}
        
    }).done(function(respuesta) {
        /*Mostras la respuesta DOM*/ 
        informacion_es=document.getElementById("informacion");
        informacion_es.innerHTML=respuesta;
        let node = document.getElementById("dialog");
        if (node.parentNode) {
            node.parentNode.removeChild(node);
        }

    }).fail(function(jqXHR) {
        alert(jqXHR.statusText);
    });
}

function cambiar_estado_materia(comp){
    let id = comp.id;
    console.log(id);
    $.ajax({
        url:'server.php',
        method:'POST',
        data:{'id_codigo':id}
    
    }).done(function(respuesta) {
    /*Mostras la respuesta DOM*/ 
        informacion_es=document.getElementById(("_").concat(id));
        informacion_es.innerHTML=respuesta;
        var snd = new Audio("./sonidos/reloj.mp3");
        snd.play();
    }).fail(function(jqXHR) {
        alert(jqXHR.statusText);
    });
}
$(document).ready(function(){
    $('#myModal').modal('show');
});