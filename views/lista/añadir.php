<header class="header">
    <div class="contenido-header">
        <div class="barra">
            <a href="/">
                MATCH BOOK
            </a>
          
        </div>
    </div>
</header>
<h1 class="nombre-pagina">Añadir Libro</h1>
<?php

use Model\Categoria;
use Model\Estado;
use Model\Lista;

    if($resultado){
        $titulo='Libro Añadido';
        $mensaje='El Libro ha sido Añadido Correctamente';

    }else{
        $titulo='Libro No Añadido';

        $mensaje='Ha Ocurrido un problema,vuelva a intentarlo';

    }
    $reload=false;
    $header=true;
    $listaD=Lista::where('idLista',$idLista);
    $d=$listaD->getD();
    $headerDir="/lista/ver?d=${d}";
    include_once __DIR__ .'/../sweetAlert.php';
;?>

<form class="formulario" method="POST">

    <div class="center">
        <div class="campo">
            <label for="titulo">Titulo</label>
            <input type="text" placeholder="Titulo del Libro" name="titulo" required>
        </div>
        <div class="campo">
            <label for="Autor">Autor</label>
            <input type="text" placeholder="Nombre del Autor" name="autor" required>
        </div>

        <div class="campo-categoria">
            <label class="label-desplegable" for="categoria">Categoria</label>
                <select class = "select-categoria" id="opciones" name="categoria[opciones]">
                <option value="mantener"  selected>--Categoria--</option>
                     <?php 
                     $categorias=Categoria::all();
                     foreach($categorias as $categoria){
                     ?>
                        <option value=<?php echo $categoria->idCategoria;?>> <?php echo $categoria->nombreCategoria;?></option>
                    <?php };?>
                </select>
        </div>    
        <?php 
        $listaD=Lista::where('idLista',$idLista);
        $d=$listaD->getD();
        if(strcmp($d,"1")!=0){
        ;?>
        <div class="campo">
            <label class="label-desplegable" for="estado">Estado</label>
                <select id="opciones" name="estado[opciones]">
                <option value="mantener"  selected>--Estado del Libro--</option>
                     <?php 
                     $estados=Estado::all();
                     foreach($estados as $estado){
                        if($estado->idEstado!=4){
                     ?>

                        <option value=<?php echo $estado->idEstado;?>> <?php echo $estado->nombreEstado;?></option>
                        <?php };?>
                    <?php };?>
                </select>
        </div>
    </div>

    <?php };?>
    <input type="submit" class="boton" value="Añadir">
   
</form>