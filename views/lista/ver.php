<header class="header">
    <div class="contenido-header">
        <div class="barra">
            <a href="/cliente/cuenta?usuario=<?php echo $idUsuario;?>">
                MATCH BOOK
            </a>
            <div class="derecha">
            <nav class="navegacion">
              <?php if($lista){
              ?>
                <a href="/lista/añadir?idLista=<?php echo $lista->idLista;?>">Añadir</a>
              <?php };?>
              <a href="/cuenta/actualizar?usuario=<?php echo $idUsuario;?>">Mi Cuenta</a>
            </nav>
        </div>
        </div>
    </div>
</header>
<?php

use Model\Estado;
use Model\Libro;
use Model\LibroLista;

    if($d=='1'){
?>
    <h1 class="nombre-pagina">Mi Lista de Deseos</h1>
<?php }else{;?>
    <h1 class="nombre-pagina">Mi Lista Para Compartir</h1>


<?php };?>
<?php
    if($lista==Null){
    ?>
        <p class="descripcion-pagina">No tiene Creada Ningúna Lista,por favor Presione el boton Crear
            para crear  Una </p>
        
        <a href="/lista/crear?d=<?php echo $d;?>" class="boton-crear">Crear Nueva Lista</a>
    <?php }
else{
?>

<div class="ver-lista">
  <div class="lista">
    <p class="nombre">Nombre:<span><?php echo $lista->nombre??'';?></span></p>
  </div>

    <h2>Libros</h2>
    <?php
        if($idLibros==Null){
    ?>
        <p>La Lista esta Bacia,presione Inserir Para añadir Libros</p>
        <a href="/lista/añadir?idLista=<?php echo $lista->idLista;?>" class="boton-crear">Añadir Libro</a>
    <?php };?>

    <div class="contenido-lista">
        
        <?php 
            foreach($idLibros as $idLibro){
                $libro=Libro::where('idLibro',$idLibro->idLibro);
                $estado=Estado::where('idEstado',LibroLista::getEstado('idLista','idLibro',$lista->idLista,$idLibro->idLibro));
        ?>
            <div class="libroB" value="<?php echo $libro->idLibro;?>"data-idanuncio="<?php echo $libro->idLibro;?>">
                <p class="texto">Titulo:<span><?php echo $libro->titulo;?></span></p>
                <p class="texto">Autor:<span><?php echo $libro->autor;?></span></p>
                <?php if($d=='0'){
                ?>
                <p class="texto">Estado:<span><?php echo $estado->nombreEstado;?></span></p>
                <?php };?>
                
            </div>

            <div class="eliminar-libro ocultar" data-idLibro="<?php echo $libro->idLibro;?>" value="<?php echo $libro->idLibro;?>">
            <a class="boton-eliminar" href="/lista/libro/eliminar?idLista=<?php echo $lista->idLista;?>&idLibro=<?php echo $libro->idLibro;?>">Eliminar</a>
          </div>
      
        <?php };?>
    </div>



</div>


<?php };?>

<script src="/build/js/misLibros.js"></script>
