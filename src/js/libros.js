document.addEventListener('DOMContentLoaded',function(e){
    iniciarApp();
});

function iniciarApp(){
    seleccionarLibro();
}

function seleccionarLibro(){
    const Anuncios=document.querySelectorAll('#libro');

    Anuncios.forEach(anuncio=>{
        anuncio.addEventListener('click',function(e){
            const URL=anuncio.attributes.value.value;
            window.location=`/libros/ver${URL}`
        });
    })
}