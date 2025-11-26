import MedicationController from './MedicationController'
import LoginController from './LoginController'
import passwordFirstLoginController from './passwordFirstLoginController'
import CorreoController from './CorreoController'
import ControladoresMedico from './ControladoresMedico'
import ControladoresPaciente from './ControladoresPaciente'
import Administrador from './Administrador'
import EnfermeraController from './EnfermeraController'
const Controllers = {
    MedicationController: Object.assign(MedicationController, MedicationController),
LoginController: Object.assign(LoginController, LoginController),
passwordFirstLoginController: Object.assign(passwordFirstLoginController, passwordFirstLoginController),
CorreoController: Object.assign(CorreoController, CorreoController),
ControladoresMedico: Object.assign(ControladoresMedico, ControladoresMedico),
ControladoresPaciente: Object.assign(ControladoresPaciente, ControladoresPaciente),
Administrador: Object.assign(Administrador, Administrador),
EnfermeraController: Object.assign(EnfermeraController, EnfermeraController),
}

export default Controllers