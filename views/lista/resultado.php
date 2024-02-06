<?php
use Model\Estado;
use Model\Libro;
use Model\LibroLista;
?>
<header class="header">
    <div class="contenido-header">
        <div class="barra">
            <a href="/cliente/cuenta?usuario=<?php echo $idUsuario??'';?>">
                MATCH BOOK
            </a>
            <div class="derecha">
            <nav class="navegacion">
                <a href="/cliente/buscar/match?Provincia=<?php echo $idProvincia??'';?>">Más Resultados</a>

            </nav>
        </div>
        </div>
    </div>
</header>

<div class="resultado-busqueda">
    <div class="lista-izquierda">
        <h3>Lista Deseos</h3>
        

        <?php
            $librosListaD=LibroLista::where('idLista',$listaD->idLista,true);
            foreach($librosListaD as $ld){
                $libro=Libro::where('idLibro',$ld->idLibro);
        ?>
          
            <div class="li-res" id="libro" value='<?php echo $ld->URL;?>'>
                <p>Titulo:<span><?php echo (($libro->titulo));?></span></p>
                <p>Autor:<span><?php echo $libro->autor;?></span></p>
            </div>            
        <?php };?>        

    </div>
    <div class="lista-derecha">
        <h3>Para Compartir</h3>
        <?php
            $librosListaC=LibroLista::where('idLista',$listaC->idLista,true);
            foreach($librosListaC as $lc){
                $libro=Libro::where('idLibro',$lc->idLibro);
                $estado=Estado::where('idEstado',$lc->idEstado);
        ?>  
            <div class="li-der" id="libro" value=<?php echo $lc->URL;?>>
                <p>Titulo:<span><?php echo (($libro->titulo));?></span></p>
                <p>Autor:<span><?php echo $libro->autor;?></span></p>
                <p>Estado:<span><?php echo $estado->nombreEstado;?></span></p>
            </div>
           
            
        <?php };?>        

    </div>
</div>

<script src="/build/js/libros.js"></script>
