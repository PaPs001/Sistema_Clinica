export function addVitalSigns(sv) {

    const input = {
        temp: document.querySelector("#temperatura"),
        presion: document.querySelector("#presionArterial"),
        frecuencia: document.querySelector("#frecuenciaCardiaca"),
        peso: document.querySelector("#peso"),
        estatura: document.querySelector("#estatura"),
        fecha: document.querySelector("#fechaConsulta")
    };

    const {
        temperatura,
        presion_arterial,
        frecuencia_cardiaca,
        peso,
        estatura,
        cita
    } = sv || {};

    input.temp.value = temperatura ?? '';
    input.presion.value = presion_arterial ?? '';
    input.frecuencia.value = frecuencia_cardiaca ?? '';
    input.peso.value = peso ?? '';
    input.estatura.value = estatura ?? '';

    if (cita) {
        const fechaHora = `${cita.fecha}T${cita.hora.slice(0, 5)}`;
        input.fecha.value = fechaHora;
    } else {
        input.fecha.value = '';
    }
}