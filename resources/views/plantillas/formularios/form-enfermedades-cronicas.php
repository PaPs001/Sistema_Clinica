<div class="form-grid bloque-cronica">
    <div class="form-group full-width">
        <label>Nombre de la Enfermedad Crónica *</label>
        <input
            type="text"
            class="enfermedades-cronicas"
            name="enfermedades-cronicas[]"
            required
            autocomplete="off"
            placeholder="Ej. Diabetes mellitus tipo 2"
        >
        <div class="sugerencias-lista sugerencias-enfermedades-cronicas"></div>
        <input type="hidden" class="enfermedades-cronicas_id" name="enfermedades-cronicas_id[]">
    </div>

    <div class="form-group full-width">
        <label for="notas">Notas de la enfermedad</label>
        <textarea
            class="notas"
            name="notas_enfermedades[]"
            rows="2"
            placeholder="Curso, tratamientos previos, controles, etc."
        ></textarea>
    </div>
</div>
