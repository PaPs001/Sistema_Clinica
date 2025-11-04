import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\LoginController::LoginRequest
* @see app/Http/Controllers/LoginController.php:12
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
* @see app/Http/Controllers/LoginController.php:12
* @route '/login'
*/
LoginRequest.url = (options?: RouteQueryOptions) => {
    return LoginRequest.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\LoginController::LoginRequest
* @see app/Http/Controllers/LoginController.php:12
* @route '/login'
*/
LoginRequest.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: LoginRequest.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\LoginController::logout
* @see app/Http/Controllers/LoginController.php:45
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
* @see app/Http/Controllers/LoginController.php:45
* @route '/logout'
*/
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\LoginController::logout
* @see app/Http/Controllers/LoginController.php:45
* @route '/logout'
*/
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

const LoginController = { LoginRequest, logout }

export default LoginController