document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    buscarPorFecha();
    buscarServicioPorNombre();
}

function buscarPorFecha() {
    const fechaInput = document.querySelector('#fecha');

    if (!fechaInput) return;

    fechaInput.addEventListener('input', function (e) {
        const fechaSeleccionada = e.target.value;
        window.location = `?fecha=${fechaSeleccionada}`;
    });
}

function normalizarTexto(texto) {
    return texto
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();
}

function buscarServicioPorNombre() {
    const inputBuscar = document.querySelector('#buscarServicio');
    const servicios = document.querySelectorAll('.servicio-admin');
    const listadoServicios = document.querySelector('.servicios');

    if (!inputBuscar || servicios.length === 0 || !listadoServicios) return;

    const mensajeBusqueda = document.createElement('H3');
    mensajeBusqueda.classList.add('mensaje-busqueda');

    listadoServicios.after(mensajeBusqueda);

    inputBuscar.addEventListener('input', function (e) {
        const busqueda = e.target.value.toLowerCase().trim();

        let coincidencias = 0;

        servicios.forEach(servicio => {
            const nombreServicio = servicio.dataset.nombre.toLowerCase();

            if (busqueda.length < 3) {
                servicio.style.display = 'block';
                coincidencias++;
                return;
            }

            if (nombreServicio.includes(busqueda)) {
                servicio.style.display = 'block';
                coincidencias++;
            } else {
                servicio.style.display = 'none';
            }
        });

        if (busqueda.length >= 3 && coincidencias === 0) {
            mensajeBusqueda.textContent = 'El servicio no ha sido creado';
        } else {
            mensajeBusqueda.textContent = '';
        }
    });
}

