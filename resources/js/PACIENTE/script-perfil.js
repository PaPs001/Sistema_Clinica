// script-perfil.js
document.addEventListener('DOMContentLoaded', function () {
    console.log('Página Mi Perfil cargada');

    setupEditModals();

    setupSettingsSwitches();

    setupAccountActions();
});

function setupEditModals() {
    const editButtons = document.querySelectorAll('.btn-edit');
    const editModal = document.getElementById('edit-modal');
    const closeModal = document.querySelector('.close-modal');
    const cancelBtn = document.querySelector('.btn-cancel');
    const modalTitle = document.getElementById('modal-title');
    const formFields = document.getElementById('form-fields');
    const editForm = document.getElementById('edit-form');

    const editConfigs = {
        'edit-personal': {
            title: 'Editar Información Personal',
            fields: [
                { type: 'text', name: 'fullName', label: 'Nombre Completo', value: 'María González Rodríguez' },
                { type: 'date', name: 'birthDate', label: 'Fecha de Nacimiento', value: '1985-08-15' },
                { type: 'select', name: 'gender', label: 'Género', options: ['Femenino', 'Masculino', 'Otro'], value: 'Femenino' },
                { type: 'text', name: 'dni', label: 'DNI', value: '12345678A' },
                { type: 'tel', name: 'phone', label: 'Teléfono', value: '+34 612 345 678' },
                { type: 'email', name: 'email', label: 'Correo Electrónico', value: 'maria.gonzalez@email.com' }
            ]
        },
        'edit-medical': {
            title: 'Editar Información Médica',
            fields: [
                { type: 'select', name: 'bloodType', label: 'Grupo Sanguíneo', options: ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'], value: 'O+' },
                { type: 'number', name: 'weight', label: 'Peso (kg)', value: '65' },
                { type: 'number', name: 'height', label: 'Altura (cm)', value: '165' },
                { type: 'text', name: 'allergies', label: 'Alergias Conocidas', value: 'Penicilina, Mariscos' },
                { type: 'text', name: 'conditions', label: 'Condiciones Crónicas', value: 'Hipertensión, Hipercolesterolemia' },
                { type: 'text', name: 'primaryDoctor', label: 'Médico de Cabecera', value: 'Dra. Ana Martínez' }
            ]
        },
        'edit-emergency': {
            title: 'Editar Contactos de Emergencia',
            fields: [
                { type: 'text', name: 'contact1Name', label: 'Nombre Contacto 1', value: 'Juan González' },
                { type: 'text', name: 'contact1Relation', label: 'Parentesco', value: 'Esposo' },
                { type: 'tel', name: 'contact1Phone', label: 'Teléfono', value: '+34 623 456 789' },
                { type: 'email', name: 'contact1Email', label: 'Correo', value: 'juan.gonzalez@email.com' },
                { type: 'text', name: 'contact2Name', label: 'Nombre Contacto 2', value: 'Laura González' },
                { type: 'text', name: 'contact2Relation', label: 'Parentesco', value: 'Hija' },
                { type: 'tel', name: 'contact2Phone', label: 'Teléfono', value: '+34 634 567 890' },
                { type: 'email', name: 'contact2Email', label: 'Correo', value: 'laura.gonzalez@email.com' }
            ]
        }
    };

    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const configId = this.id;
            const config = editConfigs[configId];

            if (config) {
                modalTitle.textContent = config.title;
                loadFormFields(config.fields);
                editModal.classList.add('active');

                editForm.onsubmit = function (e) {
                    e.preventDefault();
                    handleFormSubmit(configId, config.fields);
                };
            }
        });
    });

    closeModal.addEventListener('click', function () {
        editModal.classList.remove('active');
    });

    cancelBtn.addEventListener('click', function () {
        editModal.classList.remove('active');
    });

    editModal.addEventListener('click', function (e) {
        if (e.target === editModal) {
            editModal.classList.remove('active');
        }
    });
}

function loadFormFields(fields) {
    const formFields = document.getElementById('form-fields');
    formFields.innerHTML = '';

    fields.forEach(field => {
        const formGroup = document.createElement('div');
        formGroup.className = 'form-group';

        const label = document.createElement('label');
        label.textContent = field.label;
        label.htmlFor = field.name;

        let input;

        if (field.type === 'select') {
            input = document.createElement('select');
            input.id = field.name;
            input.name = field.name;
            input.required = true;

            field.options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option;
                optionElement.textContent = option;
                if (option === field.value) {
                    optionElement.selected = true;
                }
                input.appendChild(optionElement);
            });
        } else {
            input = document.createElement('input');
            input.type = field.type;
            input.id = field.name;
            input.name = field.name;
            input.value = field.value;
            input.required = true;
        }

        formGroup.appendChild(label);
        formGroup.appendChild(input);
        formFields.appendChild(formGroup);
    });
}

function handleFormSubmit(configId, fields) {
    const formData = {};
    fields.forEach(field => {
        const input = document.getElementById(field.name);
        formData[field.name] = input.value;
    });

    console.log('Datos del formulario:', formData);

    Swal.fire({
        icon: 'success',
        title: '¡Guardado!',
        text: 'Cambios guardados exitosamente.',
        timer: 2000,
        showConfirmButton: false
    });
    document.getElementById('edit-modal').classList.remove('active');

    updateProfileDisplay(configId, formData);
}

function updateProfileDisplay(configId, formData) {
    console.log(`Actualizando perfil para: ${configId}`, formData);
}

function setupSettingsSwitches() {
    const switches = document.querySelectorAll('.switch input');
    switches.forEach(switchEl => {
        switchEl.addEventListener('change', function () {
            const setting = this.closest('.setting-item').querySelector('h4').textContent;
            const status = this.checked ? 'activada' : 'desactivada';
            console.log(`Configuración ${setting} ${status}`);

        });
    });
}

function setupAccountActions() {
    const changePasswordBtn = document.querySelector('.btn-change-password');
    const deleteAccountBtn = document.querySelector('.btn-delete-account');

    if (changePasswordBtn) {
        changePasswordBtn.addEventListener('click', function () {
            alert('Función de cambio de contraseña.\nSe abriría un formulario para cambiar la contraseña.');
        });
    }

    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener('click', function () {
            if (confirm('¿Estás seguro de que quieres eliminar tu cuenta? Esta acción no se puede deshacer.')) {
                alert('Cuenta marcada para eliminación.\nSe enviará un correo de confirmación.');
            }
        });
    }

    const changeAvatarBtn = document.querySelector('.btn-change-avatar');
    if (changeAvatarBtn) {
        changeAvatarBtn.addEventListener('click', function () {
            alert('Función de cambio de avatar.\nSe abriría un selector de archivos para subir nueva foto.');
        });
    }
}