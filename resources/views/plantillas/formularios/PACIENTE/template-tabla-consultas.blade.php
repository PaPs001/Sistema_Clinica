<template id="cita-template">
    <tr>
        <td>
            <div class="appointment-info">
                <strong class="fecha"></strong>
                <span class="hora"></span>
            </div>
        </td>
        <td>
            <div class="doctor-info">
                <div class="doctor-avatar"><i class="fas fa-user-md"></i></div>
                <div>
                    <strong class="doctor-nombre"></strong>
                    <span class="doctor-servicio"></span>
                </div>
            </div>
        </td>
        <td class="doctor-especialidad"></td>
        <td>
            <button class="btn-view">Ver Detalles</button>
            <button class="btn-cancel">Cancelar</button>
        </td>
    </tr>
</template>