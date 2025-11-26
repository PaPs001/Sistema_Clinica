import LoginController from './LoginController'
import passwordFirstLoginController from './passwordFirstLoginController'
import CorreoController from './CorreoController'
import ControladoresMedico from './ControladoresMedico'
import ControladoresPaciente from './ControladoresPaciente'
import Administrador from './Administrador'
import PatientController from './PatientController'
import AppointmentController from './AppointmentController'
const Controllers = {
    LoginController: Object.assign(LoginController, LoginController),
passwordFirstLoginController: Object.assign(passwordFirstLoginController, passwordFirstLoginController),
CorreoController: Object.assign(CorreoController, CorreoController),
ControladoresMedico: Object.assign(ControladoresMedico, ControladoresMedico),
ControladoresPaciente: Object.assign(ControladoresPaciente, ControladoresPaciente),
Administrador: Object.assign(Administrador, Administrador),
PatientController: Object.assign(PatientController, PatientController),
AppointmentController: Object.assign(AppointmentController, AppointmentController),
}

export default Controllers