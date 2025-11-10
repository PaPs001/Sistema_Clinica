import LoginController from './LoginController'
import mediController from './mediController'
const Controllers = {
    LoginController: Object.assign(LoginController, LoginController),
mediController: Object.assign(mediController, mediController),
}

export default Controllers