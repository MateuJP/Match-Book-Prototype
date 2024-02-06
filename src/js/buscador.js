let provincia='';
document.addEventListener('DOMContentLoaded',function(){

    iniciarApp();
    

});

function iniciarApp(){
    seleccionarRadio();
    listaD();
    listaC();
    

}

function seleccionarRadio(){
    const radios=document.querySelectorAll('#radio');
    radios.forEach(radio=>{
        radio.addEventListener('click',function(e){
            mostrarBuscador(e.target.value);
        });
    });

   
}

function mostrarBuscador(valor){
    const match=document.querySelector('.busquedaMatch');
    const titulo=document.querySelector('.busquedatitulo');


    if(valor=='titulo'){
        titulo.classList.remove('ocultar');
        match.classList.add('ocultar');
        

    }
    else if(valor=='match'){
        match.classList.remove('ocultar');
        titulo.classList.add('ocultar');

    }

    

}

function listaD(){
    const lista=document.querySelector('#listaD');
    lista.addEventListener('click',function(e){
        window.location='/lista/ver?d=1'

    });
}
function listaC(){
    const lista=document.querySelector('#listaC');
    lista.addEventListener('click',function(e){
        window.location='/lista/ver?d=0'

    });
}
