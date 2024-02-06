<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuación</p>

<?php
    include_once __DIR__ .'/../alertas.php';
?>

<?php if($error) return ;?>

<div class=" contenido-formulario">
    <form class="formulario" method="POST">
        <div class="campo">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Tu Password" name="password">
        </div>
        <input type="submit" class="boton" value="Guardar y Enviar">
        </form>
</div>



<div class="acciones">
    <a href="\">¿Ya tienes Cuenta? Iniciar Sesión</a>
    <a href="\crear-cuenta">¿Aún no tienes Cuenta? Crear Una</a>
</div>