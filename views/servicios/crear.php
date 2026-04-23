<h1 class="nombre-pagina">Nuevo Servicio</h1>
<?php
    include_once __DIR__ . '/../templates/barra.php'; 
    
?>
<p class="descripcion-pagina">Llena todos los campos del formulariop para crear un nuevo servicio</p>
<?php 
    include_once __DIR__ . '/../templates/alertas.php'; 
?>

<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php' ?>
    <input 
        type="submit"
        class="boton"
        value="Guardar Servicio"
    >
</form>
