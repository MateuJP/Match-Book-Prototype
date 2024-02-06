<header class="header">
    <div class="contenido-header">
        <div class="barra">
            <a href="/">
                MATCH BOOK
            </a>
            <div class="derecha">
            <nav class="navegacion">
                <a href="/cliente/cuenta?usuario=<?php echo $idUsuarioP??'';?>">Mi Cuenta</a>
            </nav>
        </div>
        </div>
    </div>
</header>

<h1 class="nombre-pagina">Descripción del Libro</h1>

<div class="contenido-ver">

    <div class="libro">
        <p>Nombre de la Lista :<span><?php echo $lista->nombre?></span></p>
        <?php 
        if(strcmp($lista->deseo,'1')==0){
        ?>
            <p>Tipo :<span> Lista de Deseos</span></p>
        <?php }else{;?>
            <p>Tipo :<span> Para Compartir</span></p>
        <?php };?>
        <p>Título:<span><?php echo $libro->titulo;?></span></p>
        <p>Autor:<span><?php echo $libro->autor;?></span></p>
        <?php
        if($estado->idEstado!=4){
        ?>
        <p>Estado: <span><?php echo$estado->nombreEstado;?></span></p>
        <?php };?>
        <h1 class="t-contact">Información Contacto</h1>
        <div class="contacto">
            <p>Usuario : <span><?php echo $usuario->nombre.''.$usuario->apellido?></span></p>
            <?php if($usuario->TW){
            ?>    
            <a href="<?php echo $usuario->TW;?>">
                <img src="/build/img/twitter.png">
            </a>
            <?php };?>

            <?php if($usuario->INS){
            ?>    
            <a href="<?php echo $usuario->INS;?>">
                <img src="/build/img/Instagram.png">
            </a>
            <?php };?>

            <?php if($usuario->FB){
            ?>    
            <a href="<?php echo $usuario->INS;?>">
                <img src="/build/img/facebook.jpeg">
            </a>
            <?php };?>
        </div>
</div>

</div>
