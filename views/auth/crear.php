<h1 class="nombre-pagina">Crear Cuenta</h1>

<div class="contenido-formulario">
    <?php
    include_once __DIR__ .'/../alertas.php';
    ?>
    <form class="formulario" method="POST" action="/crear/cuenta">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input 
                type="text" 
                placeholder="Mi nombre" 
                name="nombre" 
                value="<?php echo $usuario->nombre ?? '';?>"
                required>
        </div>
        <div class="campo">
            <label  for="apellido">Apellido</label>
            <input  type="text" 
                    placeholder="Mi Apellido" 
                    name="apellido" 
                    value="<?php echo $usuario->apellido ?? '';?>"
                    required>
        </div>
        <div class="campo">
            <label  for="email">E-Mail</label>
            <input  type="email" 
                    placeholder="Mi e-mail" 
                    name="email" 
                    value="<?php echo $usuario->email ?? '';?>"
                    required>
        </div>
        <div class="campo-provincia">
        <select id="opciones" name="Provincia[opciones]">
        <option value="mantener"  selected>--Provincia--</option>
             <?php foreach($provincias as $provincia){
             ?>
                <option value=<?php echo $provincia->id;?>> <?php echo $provincia->nombre;?></option>
            <?php };?>
        </select>
        </div>
        <div class="campo">
            <label  for="password">Password</label>
            <input  type="password" 
                    placeholder="Password" 
                    name="password"
                    required>
        </div>
        <div class="campo">
            <label  for="twitter">Cuenta de Twitter (No Obligatorio)</label>
            <input  type="text" 
                    placeholder="Enlace a Mi Cuenta de Twitter" 
                    name="TW">
        </div>
        <div class="campo">
            <label  for="instagram">Cuenta de Instagram (No Obligatorio)</label>
            <input  type="text" 
                    placeholder="Enlace a Mi Cuenta de Instagram" 
                    name="INS">
        </div>
        <div class="campo">
            <label  for="twitter">Cuenta de FaceBook (No Obligatorio)</label>
            <input  type="text" 
                    placeholder="Enlace a Mi Cuenta de FaceBook" 
                    name="FB">
        </div>

        <input type="submit" class="boton" value="Crear Cuenta">
        
    </form> 
</div>
