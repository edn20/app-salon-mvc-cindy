<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<?php include_once __DIR__ . '/../templates/barra.php'; ?>
<p class="descripcion-pagina">Elige tus servicios y registra tus datos</p>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Registra tus datos y escoge la fecha de la cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                    id="nombre"
                    type="text"
                    placeholder="Tu nombre"
                    value="<?php echo $nombre; ?>"
                    disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input
                    id="fecha"
                    type="date"
                    min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input
                    id="hora"
                    type="time">
            </div>
            <input type="hidden" id="id" value="<?php echo $id ?>">
        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que este correcta tu informacion y cita</p>
    </div>
    <div class="paginacion">
        <button
            id="anterior"
            class="boton">&laquo; Anterior</button>
        <button
            id="siguiente"
            class="boton">Siguiente &raquo;</button>
    </div>
</div>

<?php
$script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";

?>

<?php if(isset($_GET['reagendada'])): 
    $script_sweet = "
        <script>
            Swal.fire({
                title: '¡Cita Reagendada!',
                text: 'Tu cita fue reagendada con éxito',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.history.replaceState({}, document.title, '/cita');
            });
        </script>
    ";
endif; ?>

