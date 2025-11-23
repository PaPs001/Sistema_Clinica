import LoginController from './LoginController'
import passwordFirstLoginController from './passwordFirstLoginController'
import ControladoresMedico from './ControladoresMedico'
import ControladoresPaciente from './ControladoresPaciente'
const Controllers = {
    LoginController: Object.assign(LoginController, LoginController),
passwordFirstLoginController: Object.assign(passwordFirstLoginController, passwordFirstLoginController),
ControladoresMedico: Object.assign(ControladoresMedico, ControladoresMedico),
ControladoresPaciente: Object.assign(ControladoresPaciente, ControladoresPaciente),
}

export default Controllers