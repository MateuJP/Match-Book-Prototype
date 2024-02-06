<header class="header">
    <div class="contenido-header">
        <div class="barra">
            <a href="/">
                MATCH BOOK
            </a>
          
        </div>
    </div>
</header>
<h1 class="nombre-pagina">Nueva Lista</h1>

<?php 
    include_once __DIR__ .'/../alertas.php';
    if($resultado){
        $titulo='Lista Creada';
        $mensaje='La Lista ha sido creada Correctamente';

    }else{
        $titulo='Lista No Creada';

        $mensaje='Ha Ocurrido un problema,vuelva a intentarlo';

    }
    $reload=false;
    $header=true;
    $headerDir='/lista/ver?d=<?php echo $d;?>';
    include_once __DIR__ .'/../sweetAlert.php';
;?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" placeholder="Nombre de la Lista" name="nombre">
    </div>
    <input type="submit" class="boton" value="Crear Lista">
   
</form>