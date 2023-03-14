document.addEventListener("DOMContentLoaded", function () {
    const selectHorario = document.getElementById("horario");

    const selectDoctor = document.getElementById("doctor");

    const divID = document.getElementById("divID");
    const inputID = document.getElementById("id");

    let formulario = document.querySelector("#form-cita");

    const calendarEl = document.getElementById("agenda");

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "timeGridWeek",
        slotMinTime: "9:00",
        slotMaxTime: "16:00",
        height: 495,
        locale: "es",

        headerToolbar: {
            left: "prev next today",
            center: "title",
            right: "timeGridWeek listWeek",
        },

        businessHours: {
            // days of week. an array of zero-based day of week integers (0=Sunday)
            daysOfWeek: [1, 2, 3, 4, 5], // Monday - Friday

            startTime: "9:00", // a start time (9am in this example)
            endTime: "16:00", // an end time (16pm in this example)
        },

        // events: "http://127.0.0.1:8000/citas/mostrar",
        
        // conf del despliegue
        events: "https://consultorioodont-production.up.railway.app/citas/mostrar",

        // seleccionar dia
        selectable: true,

        select: function (info) {},

        dateClick: function (info) {
            formulario.reset();
            // de "2023-03-16T10:30:00-05:00" obtiene la fecha "2023-03-16"
            divID.classList.add("d-none");
            selectHorario.disabled = false;
            selectDoctor.disabled = false;
            const dia = info.dateStr.slice(0, 10);
            formulario.dia.value = dia;

            $("#cita").modal("show");
        },

        eventClick: function (info) {
            var cita = info.event;
            const idCita = cita.title.match(/\d+/)[0];
            // console.log(idCita);

            var token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

                // http://127.0.0.1:8000/cita/editar/
                
            fetch("https://consultorioodont-production.up.railway.app/cita/editar/" + idCita, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    divID.classList.remove("d-none");
                    formulario.id.value = data.id;

                    formulario.dia.value = data.day_hour;

                    // obtener hora de la cita
                    console.log(data.startHour);
                    const arregloHora = data.startHour.split(":");
                    var inicio = arregloHora[0];
                    if (inicio === "09") {
                        inicio = "9";
                    }
                    const optionHorario = document.querySelector(
                        `option[id="${inicio}"]`
                    );

                    optionHorario.selected = true;
                    selectHorario.disabled = true;

                    // obtener doctor de la cita
                    const idDoctor = data.user_id;
                    const optionDoctor = document.querySelector(
                        `option[id="${idDoctor}"]`
                    );

                    optionDoctor.selected = true;
                    selectDoctor.disabled = true;
                    $("#cita").modal("show");
                })
                .catch((error) => {
                    console.log(error);
                    alert(error);
                });
        },
    });

    calendar.render();

    var btnGuardar = document.getElementById("btnGuardar");

    if (btnGuardar) {
        btnGuardar.addEventListener("click", function () {
            // valores del formulario
            var datos = {
                dia: formulario.dia.value,
                horario: formulario.horario.value,
                doctor: formulario.doctor.value,
            };

            // console.log(datos);

            var token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

                // http://127.0.0.1:8000/cita/crear
            fetch("https://consultorioodont-production.up.railway.app/cita/crear", {
                method: "POST",
                body: JSON.stringify(datos),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                },
            })
                .then((response) => {
                    if (response.ok) {
                        calendar.refetchEvents();
                        $("#cita").modal("hide");
                    } else {
                        throw new Error(
                            "Error en la respuesta de la solicitud."
                        );
                    }
                })
                .catch((error) => {
                    console.log(error);
                    alert(error);
                });
        });
    }

    var btnReservar = document.getElementById("btnReservar");

    if (btnReservar) {
        btnReservar.addEventListener("click", function () {
            // valores del formulario
            console.log(formulario.id.value);
            var id = formulario.id.value;

            // console.log(datos);

            var token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

                http://127.0.0.1:8000/cita/reservar/
            fetch("https://consultorioodont-production.up.railway.app/cita/reservar/" + id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                },
            })
                .then((response) => {
                    if (response.ok) {
                        calendar.refetchEvents();
                        $("#cita").modal("hide");
                    } else {
                        throw new Error(
                            "Error en la respuesta de la solicitud."
                        );
                    }
                })
                .catch((error) => {
                    console.log(error);
                    alert(error);
                });
        });
    }

    var btnCancelar = document.getElementById("btnCancelar");

    if (btnCancelar) {
        btnCancelar.addEventListener("click", function () {
            // valores del formulario
            console.log(formulario.id.value);
            var id = formulario.id.value;

            // console.log(datos);

            var token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

                // http://127.0.0.1:8000/cita/cancelar/
            fetch("https://consultorioodont-production.up.railway.app/cita/cancelar/" + id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                },
            })
                .then((response) => {
                    if (response.ok) {
                        calendar.refetchEvents();
                        $("#cita").modal("hide");
                    } else {
                        throw new Error(
                            "Error en la respuesta de la solicitud."
                        );
                    }
                })
                .catch((error) => {
                    console.log(error);
                    alert(error);
                });
        });
    }
});
