<h1 class="nombre-pagina">Gestión de Citas</h1>
<?php include_once __DIR__ . '/../templates/barra.php'; ?>
<p class="descripcion-pagina">Gestiona tus citas a continuación:</p>

<div class="mostrar-cita">
    <?php 
        if(count($citas) === 0) {
            echo "<h2>No ha reservado ninguna cita</h2>";
            echo "<a class=boton href=/cita>Agendar Ahora</a>";
        } else {
            echo "<a class=boton href=/cita>Agendar otra cita</a>";
        }
    ?>
</div>

<div class="citas-admin">
    <ul class="citas">
        <?php
           $idCita = 0;
           foreach($citas as $key => $cita) {
                if($idCita !== $cita->id) {
                    $total = 0; 
        ?>
                    <li>
                        <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                        <p>Fecha: <span><?php echo formatearFecha($cita->fecha); ?></span></p>
                        <h3 class="servicio-cita">Servicios Seleccionados:</h3>
                <?php 
                        $idCita = $cita->id;
                } //Fin de IF 
                    $total += $cita->precio;
                ?> 
                        <p class="servicio"><?php echo $cita->servicio. " -> $ ". $cita->precio; ?></p>
                <?php 
                    $actual = $cita->id;
                    $proximo = $citas[$key + 1]->id ?? 0;

                    if(esUltimo($actual, $proximo)) { 
                ?>
                        <p class="total">Total: <span>$ <?php echo $total; ?></span></p>

                        <div class="acciones">
                            <a href="/citas/actualizar?id=<?php echo $cita->id; ?>" class="boton">📝 Reagendar Cita</a>
                            <form action="/api/eliminar" method="POST">
                                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                                <input type="submit" class="boton-eliminar" value="✖ Cancelar Cita">
                            </form>
                        
                <?php
                    }
            } //Fin de FOREACH 
        ?>
                        </div>
    </ul>
    
</div>