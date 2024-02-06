<h1 class="nombre-pagina">Iniciar Sesión</h1>

<div class="contenido-formulario">
    <?php
        include_once __DIR__ .'/../alertas.php';
    ?>
    <form class="formulario" method="POST" action="/">
        <div class="campo-login">
            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu E-mail" name="email">
        </div>
        <div class="campo-login">
            <label for="password">Password</label>
            <input type="password" placeholder="Tu Password" name="password">
        </div>
        <input type="submit" class="boton-login" value="Iniciar Sesion">

    </form>
</div>
<div class="acciones">
    <a href="/crear/cuenta">¿Aún no tienes Cuenta? Crear Una</a>
    <a href="/olvide/password">Olvidé el Password</a>
    <a href="/aboutUs">¿Que és Match Book?</a>
</div>