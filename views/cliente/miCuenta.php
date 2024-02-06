<header class="header">
    <div class="contenido-header">
        <div class="barra">
            <a href="/cliente/cuenta?usuario=<?php echo $idUsuario;?>">
                MATCH BOOK
            </a>
        </div>
    </div>
</header>

<div class="contenedor-cuenta">
    <div class="menu-Izquierda">
        <div class="contenido-Izquierda">
            <a href="/cuenta/actualizar">Actualizar Cuenta</a>
        </div>
        <div class="contenido-Izquierda">
            <a href="/crear/sesion">Cerrar Sessión</a>
        </div>
        <div class="contenido-Izquierda">
            <a href="/info/match">¿Que es un Match?</a>
        </div>
    </div>

    <div class="buscador">
        <h1 class="titulo-buscador">Buscador</h1>
            <form class="buscador" method="POST" action="/cliente/buscar">
                <div class="opcion-busqueda">
                <fieldset>
                    <legend>Elige una Opción</legend>
                    <label>
                        <input id="radio" type="radio" name="opcion" value="titulo"> Buscar por Título
                    </label>
                    <label>
                        <input id="radio" type="radio" name="opcion" value="match"> Buscar Match
                    </label>
                </fieldset>
                </div>
                <div class="busquedaMatch ocultar">
                    <div class="campoBuscar">
                        <legend>Seleccionar Provincia</legend>
                        <select id="opciones-provincia" name="Provincia[opciones]">
                            <option value="<?php echo $provinciaCliente->id;?>"  selected>--<?php echo $provinciaCliente->nombre;?>--</option>
                                <?php foreach($provincias as $provincia){
                                ?>
                            <option value=<?php echo $provincia->id;?>> <?php echo $provincia->nombre;?></option>
                            <?php };?>
                        </select>
                    </div>
                    <input type="submit" id="buscarMatch" class="boton ocultar" value="Buscar Match">
                </div>

                <div class="busquedatitulo ocultar ">
                    <div class="campoTitulo">
                        <label for="titulo">Título</label>
                        <input type="text" name="titulo" placeholder="Titulo" >
                    </div>
                    <div class="campoTitulo">
                        <label for="autor">Autor</label>
                        <input type="text" name="autor" placeholder="Autor" >
                    </div>
                    <div class="campoTitulo">
                        <select id="opciones" name="categoria[opciones]">
                            <option value="mantener"  selected>--Categoria--</option>
                                <?php foreach($categorias as $categoria){
                                ?>
                            <option value=<?php echo $categoria->idCategoria;?>> <?php echo $categoria->nombreCategoria;?></option>
                            <?php };?>
                        </select>
                    </div>
                    <div class="campoTitulo">
                        <select id="opciones-provincia" name="Provincia[opciones]">
                            <option value="<?php echo $provinciaCliente->id;?>"  selected>--<?php echo $provinciaCliente->nombre;?>--</option>
                            <option value="-1">--Todas--</option>

                                <?php foreach($provincias as $provincia){
                                ?>
                            <option value=<?php echo $provincia->id;?>> <?php echo $provincia->nombre;?></option>
                            <?php };?>
                        </select>
                    </div>
                    <div class="campoBuscar">
                        <input type="submit" class="boton" value="Buscar">
                    </div>
            </div>
        </form>
    </div>

    <div class="menu-derecha">
        <div class="lista" id="listaD">
            <div class="titulo-lista">
                <h3> Lista de Deseos</h3>
            </div>
            <?php if($listaD!=Null){
             ?>
             <div class="contenido-derecha">
                <span><?php echo $listaD->nombre;?></span>
             </div>
             <?php }else{;?>
                <div class="contenido-derecha">
                    <p>Lista Bacia</p>
                </div>
              <?php };?>     

        </div>
        <div class="lista" id="listaC">
            <div class="titulo-lista">
                <h3>Lista de Compartir</h3>
            </div>
            <?php if($listaC!=Null){
             ?>
             <div class="contenido-derecha">
                <span><?php echo $listaC->nombre;?></span>
             </div>
             
             <?php }else{;?>
                <div class="contenido-derecha">
                    <p>Lista Bacia</p>
                </div>

                <?php };?>

        </div>


    </div>
</div>

<script src="/build/js/buscador.js"></script>