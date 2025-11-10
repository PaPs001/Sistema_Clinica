import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\LoginController::LoginRequest
 * @see app/Http/Controllers/LoginController.php:13
 * @route '/login'
 */
export const LoginRequest = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: LoginRequest.url(options),
    method: 'post',
})

LoginRequest.definition = {
    methods: ["post"],
    url: '/login',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\LoginController::LoginRequest
 * @see app/Http/Controllers/LoginController.php:13
 * @route '/login'
 */
LoginRequest.url = (options?: RouteQueryOptions) => {
    return LoginRequest.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\LoginController::LoginRequest
 * @see app/Http/Controllers/LoginController.php:13
 * @route '/login'
 */
LoginRequest.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: LoginRequest.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\LoginController::LoginRequest
 * @see app/Http/Controllers/LoginController.php:13
 * @route '/login'
 */
    const LoginRequestForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: LoginRequest.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\LoginController::LoginRequest
 * @see app/Http/Controllers/LoginController.php:13
 * @route '/login'
 */
        LoginRequestForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: LoginRequest.url(options),
            method: 'post',
        })
    
    LoginRequest.form = LoginRequestForm
/**
* @see \App\Http\Controllers\LoginController::LoginRequest
* @see app/Http/Controllers/LoginController.php:12
* @route '/login'
*/
const LoginRequestForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: LoginRequest.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\LoginController::LoginRequest
* @see app/Http/Controllers/LoginController.php:12
* @route '/login'
*/
LoginRequestForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: LoginRequest.url(options),
    method: 'post',
})

LoginRequest.form = LoginRequestForm

/**
* @see \App\Http\Controllers\LoginController::logout
 * @see app/Http/Controllers/LoginController.php:46
 * @route '/logout'
 */
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\LoginController::logout
 * @see app/Http/Controllers/LoginController.php:46
 * @route '/logout'
 */
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\LoginController::logout
 * @see app/Http/Controllers/LoginController.php:46
 * @route '/logout'
 */
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

<<<<<<< HEAD
    /**
* @see \App\Http\Controllers\LoginController::logout
 * @see app/Http/Controllers/LoginController.php:46
 * @route '/logout'
 */
    const logoutForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: logout.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\LoginController::logout
 * @see app/Http/Controllers/LoginController.php:46
 * @route '/logout'
 */
        logoutForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: logout.url(options),
            method: 'post',
        })
    
    logout.form = logoutForm
=======
/**
* @see \App\Http\Controllers\LoginController::logout
* @see app/Http/Controllers/LoginController.php:45
* @route '/logout'
*/
const logoutForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: logout.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\LoginController::logout
* @see app/Http/Controllers/LoginController.php:45
* @route '/logout'
*/
logoutForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: logout.url(options),
    method: 'post',
})

logout.form = logoutForm

>>>>>>> e7da33a9ea93deea329c2232c000b374f0a1fba2
const LoginController = { LoginRequest, logout }

export default LoginController