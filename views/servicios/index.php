<h1 class="nombre-pagina">Servicios</h1>
<?php include_once __DIR__ . '/../templates/barra.php' ?>
<p class="descripcion-pagina">Administracion de Servicios</p>

<div class="buscador-servicios">
    <input
        type="text"
        id="buscarServicio"
        placeholder="Buscar servicio por nombre..."
    >
</div>

<ul class="servicios">
    <?php 
        foreach($servicios as $servicio) { 
    ?>
            <li class="servicio-admin" data-nombre="<?php echo htmlspecialchars($servicio->nombre); ?>">
                <p>Nombre: <span> <?php echo $servicio->nombre; ?></span></p>
                <p>Categoría:<span> <?php echo $servicio->categoria->nombre; ?></span></p>
                <p>Detalle:<span> <?php echo $servicio->detalle->detalle; ?></span></p>
                <p>Tiempo Estimado:<span> <?php echo $servicio->detalle->tiempo; ?> Min.</span></p>
                <p>Recomendaciones:<span> <?php echo $servicio->detalle->recomendaciones; ?></span></p>
                <p>Precio: <span> $<?php echo $servicio->precio; ?></span></p>
                <p>Estado: <span> <?php echo $servicio->estado->estado; ?></span></p>
                <p>Tipo de Pago: <span> <?php echo $servicio->tipopago->nombre; ?></span></p>
                

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

<?php 
    $script = "<script src='build/js/buscador.js'></script>"
?>

