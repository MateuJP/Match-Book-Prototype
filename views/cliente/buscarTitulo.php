<header class="header">
    <div class="contenido-header">
        <div class="barra">
            <a href="/cliente/cuenta?usuario=<?php echo $idUsuario??'';?>">
                MATCH BOOK
            </a>
            <div class="derecha">
            <nav class="navegacion">
                <a href="/cliente/cuenta?usuario=<?php echo $idUsuario??'';?>">Mi Cuenta</a>
            </nav>
        </div>
        </div>
    </div>
</header>

<h1 class="nombre-pagina">Resultados de la Busqueda</h1>
<div class="descripcion">
  <?php if(strcmp('match','1')==0){
    ?>
    <p>A continuacón se muestran los usuarios que tienen para compartir alguno de los 
    libros que usted desea y que usted tiene para compartir alguno de los libros que el desea.
    </p>
    <?php };?>
</div>
<div class="resultadoBusqueda">


</div>
<?php

use Model\Lista;
use Model\Usuario;

  if($idUsuarios!=null){

    foreach($idUsuarios as $idusuario){
        $listaDesos=Lista::whereAnd('idUsuario','deseo',$idusuario,'0');
        $usuario=Usuario::where('idUsuario',$idusuario);
?>
    <div class="resultado">
        <p>Lista:<?php echo $listaDesos->nombre?></p>
        <p>Creador:<?php echo $usuario->nombre;?></p>
        <a href="/lista/busqueda/ver?idUsuario=<?php echo $idusuario;?>&Provincia=<?php echo $_GET['Provincia'];?>"class="boton">Ver Más</a>
    </div>

<?php };?>
<?php }else{
;?>
     <div class="alerta error">
        <p>No hay ningún Resultado</p>

    </div>

<?php };?>




<?php 

  if($hidenPag){

?>
<nav class="navegacionPaginacion ocultar">

<?php }else{

;?>
<nav class="navegacionPaginacion">

  <ul class="pagination">
    
    
    <li class="page-item"><a class="page-link" 
    href="/cliente/buscar/titulo?Provincia=<?php echo $_GET['Provincia'];?>&Categoria=<?php echo $_GET['Categoria'];?>&titulo=<?php echo $_GET['titulo'];?>&autor=<?php echo $_GET['autor'];?>&pagina=<?php 

      if(($_GET['pagina']??1)>1){
        echo ($_GET['pagina']??1)-1;
      }else{
        echo 1;
      }
    ?>">Anterior
  </a>
    </li>
       

    <?php  for($i=0;$i<$numPaginas;$i++){
    ?>
          <li class="page-item"><a class="page-link" href="/cliente/buscar/titulo?Provincia=<?php echo $_GET['Provincia'];?>&Categoria=<?php echo $_GET['Categoria'];?>&titulo=<?php echo $_GET['titulo'];?>&autor=<?php echo $_GET['autor'];?>&pagina=<?php echo ($i+1);?>"><?php echo ($i+1);?></a></li>
    <?php };?>  
    
    <li class="page-item"><a class="page-link" 
    href="/cliente/buscar/titulo?Provincia=<?php echo $_GET['Provincia'];?>&Categoria=<?php echo $_GET['Categoria'];?>&titulo=<?php echo $_GET['titulo'];?>&autor=<?php echo $_GET['autor'];?>&pagina=<?php 
      if(($_GET['pagina']??1)<$numPaginas){
        echo ($_GET['pagina']??1)+1;
      }else{
        echo ($_GET['pagina']??1);
      }
    ?>">Siguiente
  </a></li>
  </ul>
</nav>
<?php };?>
