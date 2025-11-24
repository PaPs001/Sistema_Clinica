
        <div class="form-group full-width">
            <label>Alergia *</label>
            <input type="text" class="alergias" name="alergias[]" required autocomplete="off">
            <div class="sugerencias-lista sugerencias-alergias"></div>
            <input type="hidden" class="alergias_id" name="alergias_id">
        </div>
        <div class="form-group">
            <label>Alergenos *</label>
            <input type="text" class="alergenos" name="alergenos[]" required autocomplete="off">
            <div class="sugerencias-lista sugerencias-alergenos"></div>
            <input type="hidden" class="alergenos_id" name="alergenos_id">
        </div>
        <div class="form-group">
            <label>Severidad</label>
            <select class="input-severidad" name="severidad_alergia[]">
                <option value="">Seleccionar</option>
                <option value="Leve">Leve</option>
                <option value="Moderada">Moderada</option>
                <option value="Grave">Grave</option>
            </select>
        </div>
        <div class="form-group">
            <label>Estado</label>
            <select class="status_alergia" name="status_alergia[]">
                <option value="">Seleccionar</option>
                <option value="Activa">Activa</option>
                <option value="Inactiva">Inactiva</option>
            </select>
        </div>
        <div class="form-group full-width">
            <label>Síntomas de la alergia</label>
            <textarea class="sintomas_alergia" name="sintomas_alergia[]" rows="2"></textarea>
        </div>
        <div class="form-group full-width">
            <label>Tratamiento</label>
            <textarea class="tratamiento_alergias" name="tratamiento_alergias[]" rows="2"></textarea>
        </div>
        <div class="form-group full-width">
            <label>Notas adicionales</label>
            <textarea class="notas" name="notas[]" rows="2"></textarea>
        </div>
    </div>
    