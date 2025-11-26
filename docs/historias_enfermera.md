# Historias de Usuario - Rol Enfermera

ID: CUA-HU-05
Título: Registrar signos vitales
Como enfermera, quiero registrar signos vitales, para actualizar el expediente del paciente.
Criterios de aceptación (Given / When / Then):
- Dado que consulto el expediente de un paciente, cuando selecciono la opción de registrar signos vitales, entonces puedo ingresar presión arterial, frecuencia cardíaca, temperatura y saturación de oxígeno.
- Dado que completo los campos obligatorios de signos vitales, cuando guardo el registro, entonces el sistema valida que los valores estén en rangos numéricos y confirma el guardado exitoso.
- Dado que registro signos vitales, cuando finalizo el ingreso, entonces el expediente del paciente refleja la fecha, hora y nombre de la enfermera que capturó la información.

ID: CUA-HU-10
Título: Actualizar tratamientos aplicados
Como enfermera, quiero actualizar tratamientos aplicados, para dar seguimiento.
Criterios de aceptación (Given / When / Then):
- Dado que estoy en el expediente de un paciente con tratamientos activos, cuando selecciono un tratamiento aplicado, entonces puedo registrar dosis, vía de administración y observaciones.
- Dado que registro la aplicación de un tratamiento, cuando guardo la actualización, entonces el sistema almacena fecha, hora y responsable de la aplicación.
- Dado que un tratamiento fue actualizado, cuando reviso el expediente del paciente, entonces el historial muestra el tratamiento aplicado con los datos recabados y la fecha de la última actualización.
