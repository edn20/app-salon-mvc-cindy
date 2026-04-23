<h1 class="nombre-pagina">Servicios</h1>
<?php include_once __DIR__ . '/../templates/barra.php' ?>
<p class="descripcion-pagina">Administracion de Servicios</p>

<ul class="servicios">
    <?php 
        foreach($servicios as $servicio) { 
    ?>
            <li>
                <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
                <p>Precio: <span>$<?php echo $servicio->precio; ?></span></p>

                <div class="acciones">
                    <a href="/servicios/actualizar?id=<?php echo $servicio->id; ?>" class="boton">📝 Actualizar Servicio</a>
                    <form action="/servicios/eliminar" method="POST">
                        <input 
                            type="hidden"
                            name="id"
                            value="<?php echo $servicio->id; ?>"
                        >
                        <input type="submit" value="🗑️ Borrar Servicio" class="boton-eliminar">
                    </form>
                </div>
            </li>
    <?php 
        } //Cierre del Foreach
    ?>
</ul>

