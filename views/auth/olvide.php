<h1 class="nombre-pagina">Olvide</h1>
<p class="descripcion-pagina">Restablece tu contraseña escribiendo tu email a continuación</p>



 <div class="contenido-formulario">
 <?php
        include_once __DIR__ .'/../alertas.php';
 ?>
    <form class="formulario" method="POST" action="/olvide/password">
        <div class="campo">
            <label for=email>E-mail</label>
            <input type="email" id="email" placeholder="Tu E-mail" name="email">
        </div>
    <input type="submit" value="Enviar" class="boton">
    </form>
 </div>

<div class="acciones">
    <a href="/">¿Ya Tienes Cuenta? Iniciar Sesión</a>
    <a href="/crea/cuenta">¿No tienes Cuenta? Crear una</a>
</div>