<h1 class="nombre-pagina">Confirmar Cuenta</h1>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<?php if ($tokenValido) {  ?>
    <div class="acciones">
        <a class="boton" href="/">Iniciar Sesión</a>
    </div>
<?php }else {  ?>
    <div class="acciones">
        <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una aquí</a>
    </div>
<?php } ?>