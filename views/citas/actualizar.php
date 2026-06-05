<h1 class="nombre-pagina">Reagendar Citas</h1>
<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<?php 
    include_once __DIR__ . '/../templates/alertas.php'; 
?>

<div id="actualizar-cita">
        <p class="text-center">Escoge la nueva fecha de la cita</p>

        <form method="POST" class="formulario" >
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input
                    id="fecha"
                    type="date"
                    min="<?php echo date('Y-m-d'); ?>"
                    name="fecha"
                    value="<?php echo $cita->fecha; ?>"
                >
                    
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input
                    id="hora"
                    type="time"
                    name="hora"
                    value="<?php echo $cita->hora; ?>"
                >
            </div>
           <input type="hidden" id="usuarioId" name="usuarioId" value="<?php echo $cita->usuarioId; ?>">
            <input 
                type="submit"
                class="boton"
                value="Reagendar Cita"
            >
        </form>
 </div>