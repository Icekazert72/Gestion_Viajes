document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form_reserva");
    const mensajeExito = document.getElementById("mensaje_exito");
    const btnDescargarPDF = document.getElementById("descargar_pdf");

    // Recuperar datos de localStorage
    const origen = localStorage.getItem("origen") || "No definido";
    const destino = localStorage.getItem("destino") || "No definido";
    const viajeros = parseInt(localStorage.getItem("viajeros")) || 1;
    const tipo = localStorage.getItem("tipo") || "basico";
    const agencia = localStorage.getItem("agencia") || "AGENCIA";
    const horaIni = localStorage.getItem("hora_ini") || "--:--";
    const horaFin = localStorage.getItem("hora_fin") || "--:--";
    const numBus = localStorage.getItem("num_bus") || "No definido";

    const precioBase = parseInt(localStorage.getItem("precio")) || 0;
    const precioServicio = parseInt(localStorage.getItem("precio_servicio")) || 0;
    const precioIndividual = precioBase + precioServicio;
    const precioTotal = precioIndividual * viajeros;

    // Rellenar campos ocultos
    document.getElementById("origen").value = origen;
    document.getElementById("destino").value = destino;
    document.getElementById("viajeros").value = viajeros;
    document.getElementById("tipo").value = tipo;

    // Validación de edad
    document.getElementById("edad").addEventListener("input", (e) => {
        const edad = parseInt(e.target.value);
        const tutorDiv = document.getElementById("tutorInfo");

        if (!isNaN(edad) && edad < 18) {
            tutorDiv.style.display = "block";
            tutorDiv.querySelectorAll("input").forEach(input => input.required = true);
        } else {
            tutorDiv.style.display = "none";
            tutorDiv.querySelectorAll("input").forEach(input => {
                input.required = false;
                input.value = '';
            });
        }
    });

    // Crear campos para otros viajeros
    const extraContainer = document.getElementById("viajerosExtra");
    extraContainer.innerHTML = ""; // Limpiar antes de generar

    if (viajeros > 1) {
        const h4 = document.createElement("h4");
        h4.textContent = "Información de otros viajeros";
        extraContainer.appendChild(h4);

        for (let i = 2; i <= viajeros; i++) {
            const group = document.createElement("div");
            group.classList.add("mb-3");

            group.innerHTML = `
            <div class="input-group mb-2">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control" name="nombre_extra_${i}" placeholder="Nombre del viajero ${i}" required>
            </div>

            <div class="input-group mb-2">
                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                <input type="text" class="form-control" name="apellido_extra_${i}" placeholder="Apellido del viajero ${i}" required>
            </div>

            <div class="input-group mb-2">
                <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                <input type="number" class="form-control" name="edad_extra_${i}" placeholder="Edad del viajero ${i}" required>
            </div>

            <div class="input-group mb-2">
                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                <input type="text" class="form-control" name="contacto_extra_${i}" placeholder="Contacto del viajero ${i}" required>
            </div>
        `;
            extraContainer.appendChild(group);
        }
    }


    // Envío de formulario
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        form.style.display = "none";
        mensajeExito.style.display = "block";
    });

    // Generación del PDF
    btnDescargarPDF.addEventListener("click", () => {
        const nombre = form.nombre.value;
        const apellido = form.apellido.value;
        const edad = parseInt(form.edad.value);

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            unit: "mm",
            format: [80, 170 + viajeros * 6],
        });

        // Encabezado
        doc.setFillColor(0, 102, 204);
        doc.rect(0, 0, 80, 15, "F");
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(10);
        doc.setFont("helvetica", "bold");
        doc.text(`RESERVA DE TICKET DE ${agencia.toUpperCase()}`, 40, 10, { align: "center" });

        let y = 18;
        doc.setTextColor(0);
        doc.setFontSize(9);
        doc.setFont("helvetica", "normal");

        doc.text("Origen:", 5, y); doc.text(origen, 30, y); y += 5;
        doc.text("Destino:", 5, y); doc.text(destino, 30, y); y += 5;
        doc.text("Servicio:", 5, y); doc.text(tipo.toUpperCase(), 30, y); y += 5;
        doc.text("Viajeros:", 5, y); doc.text(`${viajeros}`, 30, y); y += 5;
        doc.text("Horario:", 5, y); doc.text(`${horaIni} - ${horaFin}`, 30, y); y += 5;
        doc.text("Bus:", 5, y); doc.text(numBus, 30, y); y += 8;

        // Viajero principal
        doc.setDrawColor(150);
        doc.rect(4, y - 4, 72, 20);
        doc.text("Viajero principal:", 6, y);
        y += 5;
        doc.text(`Nombre: ${nombre}`, 6, y); y += 5;
        doc.text(`Apellido: ${apellido}`, 6, y); y += 5;
        doc.text(`Edad: ${edad}`, 6, y); y += 8;

        // Tutor si es menor
        if (edad < 18) {
            doc.rect(4, y - 4, 72, 15);
            doc.text("Información del tutor:", 6, y); y += 5;
            doc.text(`Nombre: ${form.nombre_tutor.value}`, 6, y); y += 5;
            doc.text(`Contacto: ${form.contacto_tutor.value}`, 6, y); y += 8;
        }

        // Otros viajeros
        if (viajeros > 1) {
            const altura = 6 + (viajeros - 1) * 5;
            doc.rect(4, y - 4, 72, altura);
            doc.text("Otros viajeros:", 6, y); y += 5;

            for (let i = 2; i <= viajeros; i++) {
                const nombreExtra = form[`nombre_extra_${i}`].value;
                const apellidoExtra = form[`apellido_extra_${i}`].value;
                doc.text(`• ${nombreExtra} ${apellidoExtra}`, 6, y);
                y += 5;
            }
            y += 3;
        }

        // Precios
        doc.setDrawColor(0);
        doc.setLineWidth(0.2);
        doc.line(5, y, 75, y); y += 4;

        doc.setFont("helvetica", "bold");
        doc.text("Resumen de precio:", 6, y); y += 5;

        const precioIndividual = precioBase + precioServicio;

        doc.setFont("helvetica", "normal");
        doc.text(`Precio base: ${precioBase} XAF`, 6, y); y += 5;
        doc.text(`Servicio (${tipo}): ${precioServicio} XAF`, 6, y); y += 5;

        doc.setFont("helvetica", "italic");
        doc.text(`Subtotal individual: ${precioIndividual} XAF`, 6, y); y += 5;
        doc.text(`× ${viajeros} viajero(s)`, 6, y); y += 5;

        doc.setFont("helvetica", "bold");
        doc.text(`Total: ${precioTotal} XAF`, 6, y); y += 8;

        // Footer
        doc.setFont("helvetica", "normal");
        doc.setFontSize(8);
        doc.text("Gracias por confiar en nuestro servicio", 40, y, { align: "center" });

        // Descargar PDF
        doc.save("ticket_reserva.pdf");

        // Esperar brevemente para asegurar descarga antes de limpiar y redirigir
        // setTimeout(() => {
        //     // Comprobar si se marcó la descarga como exitosa
        //     if (localStorage.getItem("pdf_descargado") === "true") {
        //         localStorage.clear(); // Limpiar datos
        //         window.location.href = "../../index.php"; // Redirigir
        //     } else {
        //         // Si no se marcó, volver a intentar guardar el PDF
        //         doc.save("ticket_reserva.pdf");

        //         // Esperar otro segundo y forzar salida
        //         setTimeout(() => {
        //             localStorage.clear();
        //             window.location.href = "../../index.php";
        //         }, 10000);
        //     }
        // }, 1000); // 1 segundo de espera (puedes ajustar este tiempo si es necesario)
    });

});
