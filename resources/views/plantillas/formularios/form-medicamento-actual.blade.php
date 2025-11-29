<div class="form-grid bloque-medicamento">
    <div class="form-group full-width">
        <label>Medicamento *</label>
        <input
            type="text"
            class="medicamentos-actuales"
            name="medicamentos-actuales[]"
            required
            autocomplete="off"
            placeholder="Ej. Paracetamol 500mg"
        >
        <div class="sugerencias-lista sugerencias-medicamentos-actuales"></div>
        <input type="hidden" class="medicamentos-actuales_id" name="medicamentos-actuales_id[]">
    </div>

    <div class="form-group">
        <label>Dosis</label>
        <input
            type="text"
            class="dosis-medicamento"
            name="dosis_medicamento[]"
            placeholder="Ej. 500mg"
        >
    </div>

    <div class="form-group">
        <label>Frecuencia</label>
        <input
            type="text"
            class="frecuencia-medicamento"
            name="frecuencia_medicamento[]"
            placeholder="Ej. Cada 8 horas"
        >
    </div>
</div>
