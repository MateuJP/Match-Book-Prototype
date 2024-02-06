document.addEventListener('DOMContentLoaded',function(){
    iniciarApp();

});

function iniciarApp(){
    libros();
    eliminar();
    
}

function libros(){
    const anuncios=document.querySelectorAll('.libroB');
    anuncios.forEach(anuncio=>{
        anuncio.addEventListener('click',function(e){
            console.log(anuncio);

            const idLibro=(anuncio.attributes.value.value)
            console.log(idLibro);

            const botonEliminar=document.querySelector(`[data-idlibro="${idLibro}"]`)

            
            if(anuncio.classList.contains('ocultar')){
                anuncio.classList.remove('ocultar');
                botonEliminar.classList.add('ocultar');
            }else{
                anuncio.classList.add('ocultar');
                botonEliminar.classList.remove('ocultar');
            }
            
        })
    })
}
function eliminar(){
    const botonEliminar=document.querySelectorAll('.eliminar-libro');
    
    botonEliminar.forEach(eliminar=>{
        eliminar.addEventListener('click',function(e){
            const idLibro=(eliminar.attributes.value.value)
            const anuncio=document.querySelector(`[data-idanuncio="${idLibro}"]`)
            if(eliminar.classList.contains('ocultar')){
                eliminar.classList.remove('ocultar');
                anuncio.classList.add('ocultar');
            }else{
                eliminar.classList.add('ocultar');
                anuncio.classList.remove('ocultar');
            }
            
        })
    })
}