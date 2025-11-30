document.addEventListener('DOMContentLoaded', function () {
    // Main Registration Form
    const mainForm = document.getElementById('patient-registration-form');
    if (mainForm) {
        mainForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(mainForm);
            const data = {
                name: formData.get('patient-name'),
                email: formData.get('patient-email'),
                phone: formData.get('patient-phone'),
                dob: formData.get('patient-dob'),
                gender: formData.get('patient-gender'),
                id_number: formData.get('patient-id'),
                address: formData.get('patient-address'),
                city: formData.get('patient-city'),
                state: formData.get('patient-state'),
                zip: formData.get('patient-zip'),
                // Optional fields
                blood_type: formData.get('patient-blood-type'),
                allergies: formData.get('patient-allergies'),
                medications: formData.get('patient-medications'),
                conditions: formData.get('patient-conditions'),
                notes: formData.get('patient-notes'),
                _token: document.querySelector('input[name="_token"]').value
            };

            submitPatientForm(data, mainForm.action);
        });
    }

    // Quick Registration Form
    const quickForm = document.getElementById('quick-registration-form');
    if (quickForm) {
        quickForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(quickForm);
            const data = {
                name: formData.get('quick-name'),
                phone: formData.get('quick-phone'),
                dob: formData.get('quick-dob'),
                is_quick_registration: true,
                _token: document.querySelector('input[name="_token"]').value
            };

            // Use the same action URL as the main form or a specific one if defined
            // Assuming the main form action is the correct endpoint
            const actionUrl = mainForm ? mainForm.action : '/recepcionista/registrar-paciente';

            submitPatientForm(data, actionUrl);
        });
    }

    // Modal Logic
    const quickBtn = document.getElementById('quick-registration-btn');
    const modal = document.getElementById('quick-registration-modal');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-quick-registration');

    if (quickBtn && modal) {
        quickBtn.addEventListener('click', () => {
            modal.classList.add('active');
        });

        const closeModal = () => {
            modal.classList.remove('active');
        };

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
    }

    // Clear Form
    const clearBtn = document.getElementById('clear-form');
    if (clearBtn && mainForm) {
        clearBtn.addEventListener('click', () => {
            mainForm.reset();
        });
    }
});

function submitPatientForm(data, url) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': data._token,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Paciente registrado exitosamente');
                window.location.reload();
            } else {
                let errorMessage = result.message || 'Error al registrar paciente';
                if (result.errors) {
                    errorMessage += '\n' + Object.values(result.errors).flat().join('\n');
                }
                alert(errorMessage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al procesar la solicitud.');
        });
}
