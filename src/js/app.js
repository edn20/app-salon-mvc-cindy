let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}


document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); // Cambia la seccion cuando se presione en los tabs
    botonesPaginador(); //Agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();
    consultarAPI(); // COnsulta la API en el backend de PHP
    idCliente(); // Añade el id del usuario al objeto de cita
    nombreCliente(); // Añade el nombre del usuario al objeto de cita
    seleccionarFecha(); // Añade la fecha de la cita la objeto
    seleccionarHora(); // Añade la hora de la cita al objeto
    mostrarResumen(); // Muestra el resumen de la cita
}

function mostrarSeccion() {
    //Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    //Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //Quita la calse de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        });
    });
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();

}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    })
}
function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    })
}

async function consultarAPI() {

    try {
        const url = '/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(categorias) {

    const contenedorServicios = document.querySelector('#servicios');
    contenedorServicios.innerHTML = '';

    categorias.forEach(categoria => {

        const categoriaDiv = document.createElement('DIV');
        categoriaDiv.classList.add('categoriaservicio');

        const tituloCategoria = document.createElement('H3');
        tituloCategoria.classList.add('categoriaservicio__titulo');
        tituloCategoria.textContent = categoria.nombre;

        const listadoServicios = document.createElement('DIV');
        listadoServicios.classList.add('categoriaservicio__listado');

        categoria.servicios.forEach(servicio => {
            const { id, nombre, precio, tipopago, detalle, tiempo, recomendaciones } = servicio;

            const nombreServicio = document.createElement('P');
            nombreServicio.classList.add('nombre-servicio');
            nombreServicio.textContent = nombre;

            const precioServicio = document.createElement('P');
            precioServicio.classList.add('precio-servicio');

            if (tipopago && tipopago.toLowerCase() === 'desde') {
                precioServicio.textContent = `Desde $${precio}`;
            } else {
                precioServicio.textContent = `$${precio}`;
            }

            const detalleServicio = document.createElement('P');
            detalleServicio.classList.add('detalle-servicio');
            detalleServicio.innerHTML = `<span>Detalle del servicio:</span> ${detalle}`;

            const tiempoServicio = document.createElement('P');
            tiempoServicio.classList.add('tiempo-servicio');
            tiempoServicio.innerHTML = `<span>Tiempo estimado del servicio</span><br> ${tiempo} minutos`;

            const servicioDiv = document.createElement('DIV');
            servicioDiv.classList.add('servicio');
            servicioDiv.dataset.idServicio = id;

            servicioDiv.onclick = function () {
                seleccionarServicio(servicio);
            };

            servicioDiv.appendChild(nombreServicio);
            servicioDiv.appendChild(precioServicio);
            servicioDiv.appendChild(detalleServicio);
            servicioDiv.appendChild(tiempoServicio);

            listadoServicios.appendChild(servicioDiv);
        });

        categoriaDiv.appendChild(tituloCategoria);
        categoriaDiv.appendChild(listadoServicios);

        contenedorServicios.appendChild(categoriaDiv);
    });

    function seleccionarServicio(servicio) {
        const { id } = servicio;
        const { servicios } = cita;

        const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

        if (servicios.some(agregado => agregado.id === id)) {
            cita.servicios = servicios.filter(agregado => agregado.id !== id);
            divServicio.classList.remove('seleccionado');
        } else {
            cita.servicios = [...servicios, servicio];
            divServicio.classList.add('seleccionado');
        }
    }
}

function idCliente() {
    const id = document.querySelector('#id').value;
    cita.id = id
}

function nombreCliente() {
    const nombre = document.querySelector('#nombre').value;
    cita.nombre = nombre
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {
        const dia = new Date(e.target.value).getUTCDay();

        if ([0].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('Domingos no laboramos', 'error', '.formulario');
        } else {
            cita.fecha = e.target.value;
        }

    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {

        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        if (hora < 10 || hora > 21) {
            e.target.value = '';
            mostrarAlerta('Hora no valida - Aceptamos citas de 10:00 a 21:00', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;
        }

    });
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    // Previene que se genere mas de una alerta
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    }

    // Scripting para generar la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) {
        // Elimina en 2.5 seg. la alerta
        setTimeout(() => {
            alerta.remove();
        }, 2500);
    }

}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    //Limpiar el contenido de Resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos o seleccionar un servicio', 'error', '.contenido-resumen', false);
        return;
    }

    // Formatear el div de resumen
    const { nombre, fecha, hora, servicios, } = cita;

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
    const fechaFormateada = fechaUTC.toLocaleDateString('es-EC', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    //Heading para servicios en resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de servicios escogidos';
    resumen.appendChild(headingServicios);

    // Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const { id, precio, nombre, tipopago, recomendaciones } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        if (tipopago && tipopago.toLowerCase() === 'desde') {
            precioServicio.innerHTML = `<span>Desde:</span> $${precio}`;
        } else {
            precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;
        }

        const recomendacionServicio = document.createElement('P');
        recomendacionServicio.classList.add('recomendacion-servicio');

        if (recomendaciones) {
            recomendacionServicio.innerHTML = `<span>Recomendación:</span> ${recomendaciones}`;
        }

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);
        if (recomendaciones) {
            contenedorServicio.appendChild(recomendacionServicio);
        }

        resumen.appendChild(contenedorServicio);
    });

    // Calcular total de servicios
    const total = servicios.reduce((acumulado, servicio) => {
        return acumulado + Number(servicio.precio);
    }, 0);

    // Verificar si existe algún servicio con tipo de pago "Desde"
    const tienePrecioDesde = servicios.some(servicio => {
        return servicio.tipopago && servicio.tipopago.toLowerCase() === 'desde';
    });

    const totalServicio = document.createElement('P');
    totalServicio.classList.add('total-servicio');

    if (tienePrecioDesde) {
        totalServicio.innerHTML = `<span>Total Aproximado:</span> $${total.toFixed(2)}`;

        const notaTotal = document.createElement('P');
        notaTotal.classList.add('nota-total');
        notaTotal.innerHTML = `<span>Nota:</span> El valor aproximado puede variar previa evaluación del cliente.`;

        resumen.appendChild(totalServicio);
        resumen.appendChild(notaTotal);
    } else {
        totalServicio.innerHTML = `<span>Total:</span> $${total.toFixed(2)}`;
        resumen.appendChild(totalServicio);
    }

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(botonReservar);
}

async function reservarCita() {
    const { nombre, fecha, hora, servicios, id } = cita;
    const idServicios = servicios.map(servicio => servicio.id);
    // console.log(idServicios);
    const datos = new FormData();
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    // console.log([...datos]);

    try {
        // Peticion hacia la API
        const url = '/api/citas';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });
        const resultado = await respuesta.json();

        if (resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Cita Agendada",
                text: "Su cita fue agendada exitosamente",
                button: 'OK'
            }).then(() => {
                setTimeout(() => {
                    window.location.reload();
                }, 100);
            });
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error Inesperado",
            text: "hubo un error al guardar la cita",
            button: 'OK'
        });
    }




    // console.log([...datos]);


}

