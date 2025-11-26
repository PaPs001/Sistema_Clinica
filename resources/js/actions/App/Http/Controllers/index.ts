<<<<<<< HEAD
=======
import MedicationController from './MedicationController'
>>>>>>> e0c9e08e56ac51648f68884e5af6292a21ba6ea5
import LoginController from './LoginController'
import passwordFirstLoginController from './passwordFirstLoginController'
import CorreoController from './CorreoController'
import ControladoresMedico from './ControladoresMedico'
import ControladoresPaciente from './ControladoresPaciente'
import Administrador from './Administrador'
<<<<<<< HEAD
import ReceptionistController from './ReceptionistController'
import PatientController from './PatientController'
import AppointmentController from './AppointmentController'
const Controllers = {
    LoginController: Object.assign(LoginController, LoginController),
=======
import EnfermeraController from './EnfermeraController'
const Controllers = {
    MedicationController: Object.assign(MedicationController, MedicationController),
LoginController: Object.assign(LoginController, LoginController),
>>>>>>> e0c9e08e56ac51648f68884e5af6292a21ba6ea5
passwordFirstLoginController: Object.assign(passwordFirstLoginController, passwordFirstLoginController),
CorreoController: Object.assign(CorreoController, CorreoController),
ControladoresMedico: Object.assign(ControladoresMedico, ControladoresMedico),
ControladoresPaciente: Object.assign(ControladoresPaciente, ControladoresPaciente),
Administrador: Object.assign(Administrador, Administrador),
<<<<<<< HEAD
ReceptionistController: Object.assign(ReceptionistController, ReceptionistController),
PatientController: Object.assign(PatientController, PatientController),
AppointmentController: Object.assign(AppointmentController, AppointmentController),
=======
EnfermeraController: Object.assign(EnfermeraController, EnfermeraController),
>>>>>>> e0c9e08e56ac51648f68884e5af6292a21ba6ea5
}

export default Controllers