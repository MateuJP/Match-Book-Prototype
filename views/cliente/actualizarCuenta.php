
<h1 class="nombre-pagina">Actualizar Cuenta</h1>

<div class="descripcion">
    <p >
        Modifique los Registros de su cuenta que desea Actualizar y presione 
        el boton Actualizar cuando haya terminado.
    </p>
</div>


<?php 
    include_once __DIR__ .'/../alertas.php';
    if($resultado){
        $titulo='Cuenta Actualizado';
        $mensaje='Sus datos ham Sido Actualizado correctamente';

    }else{
        $titulo='Cuenta No Actualizado';

        $mensaje='Ha Ocurrido un problema,vuelva a intentarlo';

    }
    $reload=false;
    $header=true;
    $headerDir='/cliente/cuenta';
    include_once __DIR__ .'/../sweetAlert.php';




;?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input  type="text" 
                value="<?php echo $usuario->nombre ?? '';?>" 
                name="nombre">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input  type="text" 
                value="<?php echo $usuario->apellido??'';?>" 
                name="apellido">
    </div>
    <div class="campo">
        <label for="email">E-mail</label>
        <input  type="email" 
                value="<?php echo $usuario->email??'';?>" 
                name="email">
    </div>
    <div class="campo">
        <label class="label-desplegable" for="provincias">Provincia</label>
        <select id="opciones" name="Provincia[opciones]">
        <option value="mantener"  selected>--<?php echo $provinciaCliente->nombre;?>--</option>
             <?php foreach($provincias as $provincia){
             ?>
                <option value=<?php echo $provincia->id;?>> <?php echo $provincia->nombre;?></option>
            <?php };?>
        </select>
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input
                type="password"
                placeholder="Campo no Obligatorio";
                name="password">
    </div>



    
   

    <input type="submit" class="boton" value="Actualizar">

</form>