import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../wayfinder'
/**
 * @see [serialized-closure]:2
 * @route '/'
 */
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/'
 */
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/'
 */
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/'
 */
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/'
 */
    const loginForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: login.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/'
 */
        loginForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: login.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/'
 */
        loginForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: login.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    login.form = loginForm
/**
* @see \App\Http\Controllers\LoginController::login_Attempt
 * @see app/Http/Controllers/LoginController.php:12
 * @route '/login'
 */
export const login_Attempt = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: login_Attempt.url(options),
    method: 'post',
})

login_Attempt.definition = {
    methods: ["post"],
    url: '/login',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\LoginController::login_Attempt
 * @see app/Http/Controllers/LoginController.php:12
 * @route '/login'
 */
login_Attempt.url = (options?: RouteQueryOptions) => {
    return login_Attempt.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\LoginController::login_Attempt
 * @see app/Http/Controllers/LoginController.php:12
 * @route '/login'
 */
login_Attempt.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: login_Attempt.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\LoginController::login_Attempt
 * @see app/Http/Controllers/LoginController.php:12
 * @route '/login'
 */
    const login_AttemptForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: login_Attempt.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\LoginController::login_Attempt
 * @see app/Http/Controllers/LoginController.php:12
 * @route '/login'
 */
        login_AttemptForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: login_Attempt.url(options),
            method: 'post',
        })
    
    login_Attempt.form = login_AttemptForm
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
/**
 * @see [serialized-closure]:2
 * @route '/dashboard'
 */
export const dashboardMedico = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardMedico.url(options),
    method: 'get',
})

dashboardMedico.definition = {
    methods: ["get","head"],
    url: '/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/dashboard'
 */
dashboardMedico.url = (options?: RouteQueryOptions) => {
    return dashboardMedico.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/dashboard'
 */
dashboardMedico.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardMedico.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/dashboard'
 */
dashboardMedico.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboardMedico.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/dashboard'
 */
    const dashboardMedicoForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: dashboardMedico.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/dashboard'
 */
        dashboardMedicoForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboardMedico.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/dashboard'
 */
        dashboardMedicoForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboardMedico.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    dashboardMedico.form = dashboardMedicoForm
/**
 * @see [serialized-closure]:2
 * @route '/registro-expediente'
 */
export const registroExpediente = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: registroExpediente.url(options),
    method: 'get',
})

registroExpediente.definition = {
    methods: ["get","head"],
    url: '/registro-expediente',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/registro-expediente'
 */
registroExpediente.url = (options?: RouteQueryOptions) => {
    return registroExpediente.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/registro-expediente'
 */
registroExpediente.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: registroExpediente.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/registro-expediente'
 */
registroExpediente.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: registroExpediente.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/registro-expediente'
 */
    const registroExpedienteForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: registroExpediente.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/registro-expediente'
 */
        registroExpedienteForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: registroExpediente.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/registro-expediente'
 */
        registroExpedienteForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: registroExpediente.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    registroExpediente.form = registroExpedienteForm
/**
 * @see [serialized-closure]:2
 * @route '/consulta-historial'
 */
export const consultaHistorial = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: consultaHistorial.url(options),
    method: 'get',
})

consultaHistorial.definition = {
    methods: ["get","head"],
    url: '/consulta-historial',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/consulta-historial'
 */
consultaHistorial.url = (options?: RouteQueryOptions) => {
    return consultaHistorial.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/consulta-historial'
 */
consultaHistorial.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: consultaHistorial.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/consulta-historial'
 */
consultaHistorial.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: consultaHistorial.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/consulta-historial'
 */
    const consultaHistorialForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: consultaHistorial.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/consulta-historial'
 */
        consultaHistorialForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: consultaHistorial.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/consulta-historial'
 */
        consultaHistorialForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: consultaHistorial.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    consultaHistorial.form = consultaHistorialForm
/**
 * @see [serialized-closure]:2
 * @route '/subir-documentos'
 */
export const subirDocumentos = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: subirDocumentos.url(options),
    method: 'get',
})

subirDocumentos.definition = {
    methods: ["get","head"],
    url: '/subir-documentos',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/subir-documentos'
 */
subirDocumentos.url = (options?: RouteQueryOptions) => {
    return subirDocumentos.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/subir-documentos'
 */
subirDocumentos.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: subirDocumentos.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/subir-documentos'
 */
subirDocumentos.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: subirDocumentos.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/subir-documentos'
 */
    const subirDocumentosForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: subirDocumentos.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/subir-documentos'
 */
        subirDocumentosForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: subirDocumentos.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/subir-documentos'
 */
        subirDocumentosForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: subirDocumentos.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    subirDocumentos.form = subirDocumentosForm
/**
 * @see [serialized-closure]:2
 * @route '/filtrar-expedientes'
 */
export const filtrarExpedientes = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: filtrarExpedientes.url(options),
    method: 'get',
})

filtrarExpedientes.definition = {
    methods: ["get","head"],
    url: '/filtrar-expedientes',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/filtrar-expedientes'
 */
filtrarExpedientes.url = (options?: RouteQueryOptions) => {
    return filtrarExpedientes.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/filtrar-expedientes'
 */
filtrarExpedientes.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: filtrarExpedientes.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/filtrar-expedientes'
 */
filtrarExpedientes.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: filtrarExpedientes.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/filtrar-expedientes'
 */
    const filtrarExpedientesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: filtrarExpedientes.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/filtrar-expedientes'
 */
        filtrarExpedientesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: filtrarExpedientes.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/filtrar-expedientes'
 */
        filtrarExpedientesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: filtrarExpedientes.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    filtrarExpedientes.form = filtrarExpedientesForm
/**
 * @see [serialized-closure]:2
 * @route '/registro-alergias'
 */
export const registroAlergias = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: registroAlergias.url(options),
    method: 'get',
})

registroAlergias.definition = {
    methods: ["get","head"],
    url: '/registro-alergias',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/registro-alergias'
 */
registroAlergias.url = (options?: RouteQueryOptions) => {
    return registroAlergias.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/registro-alergias'
 */
registroAlergias.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: registroAlergias.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/registro-alergias'
 */
registroAlergias.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: registroAlergias.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/registro-alergias'
 */
    const registroAlergiasForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: registroAlergias.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/registro-alergias'
 */
        registroAlergiasForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: registroAlergias.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/registro-alergias'
 */
        registroAlergiasForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: registroAlergias.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    registroAlergias.form = registroAlergiasForm
/**
 * @see [serialized-closure]:2
 * @route '/dashboard-paciente'
 */
export const dashboardPaciente = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardPaciente.url(options),
    method: 'get',
})

dashboardPaciente.definition = {
    methods: ["get","head"],
    url: '/dashboard-paciente',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/dashboard-paciente'
 */
dashboardPaciente.url = (options?: RouteQueryOptions) => {
    return dashboardPaciente.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/dashboard-paciente'
 */
dashboardPaciente.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardPaciente.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/dashboard-paciente'
 */
dashboardPaciente.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboardPaciente.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/dashboard-paciente'
 */
    const dashboardPacienteForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: dashboardPaciente.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/dashboard-paciente'
 */
        dashboardPacienteForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboardPaciente.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/dashboard-paciente'
 */
        dashboardPacienteForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboardPaciente.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    dashboardPaciente.form = dashboardPacienteForm
/**
 * @see [serialized-closure]:2
 * @route '/historial_Paciente'
 */
export const historialPaciente = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: historialPaciente.url(options),
    method: 'get',
})

historialPaciente.definition = {
    methods: ["get","head"],
    url: '/historial_Paciente',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/historial_Paciente'
 */
historialPaciente.url = (options?: RouteQueryOptions) => {
    return historialPaciente.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/historial_Paciente'
 */
historialPaciente.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: historialPaciente.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/historial_Paciente'
 */
historialPaciente.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: historialPaciente.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/historial_Paciente'
 */
    const historialPacienteForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: historialPaciente.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/historial_Paciente'
 */
        historialPacienteForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: historialPaciente.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/historial_Paciente'
 */
        historialPacienteForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: historialPaciente.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    historialPaciente.form = historialPacienteForm
/**
 * @see [serialized-closure]:2
 * @route '/citas-Paciente'
 */
export const citasPaciente = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: citasPaciente.url(options),
    method: 'get',
})

citasPaciente.definition = {
    methods: ["get","head"],
    url: '/citas-Paciente',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/citas-Paciente'
 */
citasPaciente.url = (options?: RouteQueryOptions) => {
    return citasPaciente.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/citas-Paciente'
 */
citasPaciente.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: citasPaciente.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/citas-Paciente'
 */
citasPaciente.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: citasPaciente.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/citas-Paciente'
 */
    const citasPacienteForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: citasPaciente.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/citas-Paciente'
 */
        citasPacienteForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: citasPaciente.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/citas-Paciente'
 */
        citasPacienteForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: citasPaciente.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    citasPaciente.form = citasPacienteForm
/**
 * @see [serialized-closure]:2
 * @route '/alergias-Paciente'
 */
export const alergiasPaciente = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: alergiasPaciente.url(options),
    method: 'get',
})

alergiasPaciente.definition = {
    methods: ["get","head"],
    url: '/alergias-Paciente',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/alergias-Paciente'
 */
alergiasPaciente.url = (options?: RouteQueryOptions) => {
    return alergiasPaciente.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/alergias-Paciente'
 */
alergiasPaciente.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: alergiasPaciente.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/alergias-Paciente'
 */
alergiasPaciente.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: alergiasPaciente.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/alergias-Paciente'
 */
    const alergiasPacienteForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: alergiasPaciente.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/alergias-Paciente'
 */
        alergiasPacienteForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: alergiasPaciente.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/alergias-Paciente'
 */
        alergiasPacienteForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: alergiasPaciente.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    alergiasPaciente.form = alergiasPacienteForm
/**
 * @see [serialized-closure]:2
 * @route '/documentos-Paciente'
 */
export const documentosPaciente = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: documentosPaciente.url(options),
    method: 'get',
})

documentosPaciente.definition = {
    methods: ["get","head"],
    url: '/documentos-Paciente',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/documentos-Paciente'
 */
documentosPaciente.url = (options?: RouteQueryOptions) => {
    return documentosPaciente.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/documentos-Paciente'
 */
documentosPaciente.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: documentosPaciente.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/documentos-Paciente'
 */
documentosPaciente.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: documentosPaciente.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/documentos-Paciente'
 */
    const documentosPacienteForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: documentosPaciente.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/documentos-Paciente'
 */
        documentosPacienteForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: documentosPaciente.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/documentos-Paciente'
 */
        documentosPacienteForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: documentosPaciente.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    documentosPaciente.form = documentosPacienteForm
/**
 * @see [serialized-closure]:2
 * @route '/perfil-Paciente'
 */
export const perfilPaciente = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: perfilPaciente.url(options),
    method: 'get',
})

perfilPaciente.definition = {
    methods: ["get","head"],
    url: '/perfil-Paciente',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/perfil-Paciente'
 */
perfilPaciente.url = (options?: RouteQueryOptions) => {
    return perfilPaciente.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/perfil-Paciente'
 */
perfilPaciente.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: perfilPaciente.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/perfil-Paciente'
 */
perfilPaciente.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: perfilPaciente.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/perfil-Paciente'
 */
    const perfilPacienteForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: perfilPaciente.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/perfil-Paciente'
 */
        perfilPacienteForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: perfilPaciente.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/perfil-Paciente'
 */
        perfilPacienteForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: perfilPaciente.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    perfilPaciente.form = perfilPacienteForm
/**
 * @see [serialized-closure]:2
 * @route '/dashboard-admin'
 */
export const dashboardAdmin = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardAdmin.url(options),
    method: 'get',
})

dashboardAdmin.definition = {
    methods: ["get","head"],
    url: '/dashboard-admin',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/dashboard-admin'
 */
dashboardAdmin.url = (options?: RouteQueryOptions) => {
    return dashboardAdmin.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/dashboard-admin'
 */
dashboardAdmin.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardAdmin.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/dashboard-admin'
 */
dashboardAdmin.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboardAdmin.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/dashboard-admin'
 */
    const dashboardAdminForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: dashboardAdmin.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/dashboard-admin'
 */
        dashboardAdminForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboardAdmin.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/dashboard-admin'
 */
        dashboardAdminForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboardAdmin.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    dashboardAdmin.form = dashboardAdminForm
/**
 * @see [serialized-closure]:2
 * @route '/auditoria'
 */
export const auditoria = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: auditoria.url(options),
    method: 'get',
})

auditoria.definition = {
    methods: ["get","head"],
    url: '/auditoria',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/auditoria'
 */
auditoria.url = (options?: RouteQueryOptions) => {
    return auditoria.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/auditoria'
 */
auditoria.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: auditoria.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/auditoria'
 */
auditoria.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: auditoria.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/auditoria'
 */
    const auditoriaForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: auditoria.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/auditoria'
 */
        auditoriaForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: auditoria.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/auditoria'
 */
        auditoriaForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: auditoria.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    auditoria.form = auditoriaForm
/**
 * @see [serialized-closure]:2
 * @route '/configuracion'
 */
export const configuracion = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: configuracion.url(options),
    method: 'get',
})

configuracion.definition = {
    methods: ["get","head"],
    url: '/configuracion',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/configuracion'
 */
configuracion.url = (options?: RouteQueryOptions) => {
    return configuracion.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/configuracion'
 */
configuracion.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: configuracion.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/configuracion'
 */
configuracion.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: configuracion.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/configuracion'
 */
    const configuracionForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: configuracion.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/configuracion'
 */
        configuracionForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: configuracion.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/configuracion'
 */
        configuracionForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: configuracion.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    configuracion.form = configuracionForm
/**
 * @see [serialized-closure]:2
 * @route '/control-accesos'
 */
export const controlAccesos = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: controlAccesos.url(options),
    method: 'get',
})

controlAccesos.definition = {
    methods: ["get","head"],
    url: '/control-accesos',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/control-accesos'
 */
controlAccesos.url = (options?: RouteQueryOptions) => {
    return controlAccesos.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/control-accesos'
 */
controlAccesos.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: controlAccesos.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/control-accesos'
 */
controlAccesos.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: controlAccesos.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/control-accesos'
 */
    const controlAccesosForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: controlAccesos.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/control-accesos'
 */
        controlAccesosForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: controlAccesos.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/control-accesos'
 */
        controlAccesosForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: controlAccesos.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    controlAccesos.form = controlAccesosForm
/**
 * @see [serialized-closure]:2
 * @route '/gestion-roles'
 */
export const gestionRoles = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: gestionRoles.url(options),
    method: 'get',
})

gestionRoles.definition = {
    methods: ["get","head"],
    url: '/gestion-roles',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/gestion-roles'
 */
gestionRoles.url = (options?: RouteQueryOptions) => {
    return gestionRoles.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/gestion-roles'
 */
gestionRoles.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: gestionRoles.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/gestion-roles'
 */
gestionRoles.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: gestionRoles.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/gestion-roles'
 */
    const gestionRolesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: gestionRoles.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/gestion-roles'
 */
        gestionRolesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: gestionRoles.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/gestion-roles'
 */
        gestionRolesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: gestionRoles.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    gestionRoles.form = gestionRolesForm
/**
 * @see [serialized-closure]:2
 * @route '/respaldo-datos'
 */
export const respaldoDatos = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: respaldoDatos.url(options),
    method: 'get',
})

respaldoDatos.definition = {
    methods: ["get","head"],
    url: '/respaldo-datos',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/respaldo-datos'
 */
respaldoDatos.url = (options?: RouteQueryOptions) => {
    return respaldoDatos.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/respaldo-datos'
 */
respaldoDatos.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: respaldoDatos.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/respaldo-datos'
 */
respaldoDatos.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: respaldoDatos.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/respaldo-datos'
 */
    const respaldoDatosForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: respaldoDatos.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/respaldo-datos'
 */
        respaldoDatosForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: respaldoDatos.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/respaldo-datos'
 */
        respaldoDatosForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: respaldoDatos.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    respaldoDatos.form = respaldoDatosForm
/**
 * @see [serialized-closure]:2
 * @route '/dasboard-recepcionista'
 */
export const dashboardRecepcionista = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardRecepcionista.url(options),
    method: 'get',
})

dashboardRecepcionista.definition = {
    methods: ["get","head"],
    url: '/dasboard-recepcionista',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/dasboard-recepcionista'
 */
dashboardRecepcionista.url = (options?: RouteQueryOptions) => {
    return dashboardRecepcionista.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/dasboard-recepcionista'
 */
dashboardRecepcionista.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardRecepcionista.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/dasboard-recepcionista'
 */
dashboardRecepcionista.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboardRecepcionista.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/dasboard-recepcionista'
 */
    const dashboardRecepcionistaForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: dashboardRecepcionista.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/dasboard-recepcionista'
 */
        dashboardRecepcionistaForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboardRecepcionista.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/dasboard-recepcionista'
 */
        dashboardRecepcionistaForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboardRecepcionista.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    dashboardRecepcionista.form = dashboardRecepcionistaForm
/**
 * @see [serialized-closure]:2
 * @route '/agenda'
 */
export const agenda = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: agenda.url(options),
    method: 'get',
})

agenda.definition = {
    methods: ["get","head"],
    url: '/agenda',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/agenda'
 */
agenda.url = (options?: RouteQueryOptions) => {
    return agenda.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/agenda'
 */
agenda.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: agenda.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/agenda'
 */
agenda.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: agenda.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/agenda'
 */
    const agendaForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: agenda.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/agenda'
 */
        agendaForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: agenda.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/agenda'
 */
        agendaForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: agenda.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    agenda.form = agendaForm
/**
 * @see [serialized-closure]:2
 * @route '/gestion-citas'
 */
export const gestionCitas = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: gestionCitas.url(options),
    method: 'get',
})

gestionCitas.definition = {
    methods: ["get","head"],
    url: '/gestion-citas',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/gestion-citas'
 */
gestionCitas.url = (options?: RouteQueryOptions) => {
    return gestionCitas.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/gestion-citas'
 */
gestionCitas.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: gestionCitas.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/gestion-citas'
 */
gestionCitas.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: gestionCitas.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/gestion-citas'
 */
    const gestionCitasForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: gestionCitas.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/gestion-citas'
 */
        gestionCitasForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: gestionCitas.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/gestion-citas'
 */
        gestionCitasForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: gestionCitas.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    gestionCitas.form = gestionCitasForm
/**
 * @see [serialized-closure]:2
 * @route '/pacientes-recepcionista'
 */
export const pacientesRecepcionista = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pacientesRecepcionista.url(options),
    method: 'get',
})

pacientesRecepcionista.definition = {
    methods: ["get","head"],
    url: '/pacientes-recepcionista',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/pacientes-recepcionista'
 */
pacientesRecepcionista.url = (options?: RouteQueryOptions) => {
    return pacientesRecepcionista.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/pacientes-recepcionista'
 */
pacientesRecepcionista.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pacientesRecepcionista.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/pacientes-recepcionista'
 */
pacientesRecepcionista.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pacientesRecepcionista.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/pacientes-recepcionista'
 */
    const pacientesRecepcionistaForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: pacientesRecepcionista.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/pacientes-recepcionista'
 */
        pacientesRecepcionistaForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: pacientesRecepcionista.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/pacientes-recepcionista'
 */
        pacientesRecepcionistaForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: pacientesRecepcionista.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    pacientesRecepcionista.form = pacientesRecepcionistaForm
/**
 * @see [serialized-closure]:2
 * @route '/recordatorios'
 */
export const recordatorios = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: recordatorios.url(options),
    method: 'get',
})

recordatorios.definition = {
    methods: ["get","head"],
    url: '/recordatorios',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/recordatorios'
 */
recordatorios.url = (options?: RouteQueryOptions) => {
    return recordatorios.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/recordatorios'
 */
recordatorios.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: recordatorios.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/recordatorios'
 */
recordatorios.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: recordatorios.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/recordatorios'
 */
    const recordatoriosForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: recordatorios.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/recordatorios'
 */
        recordatoriosForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: recordatorios.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/recordatorios'
 */
        recordatoriosForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: recordatorios.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    recordatorios.form = recordatoriosForm
/**
 * @see [serialized-closure]:2
 * @route '/registro-paciente'
 */
export const registroPaciente = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: registroPaciente.url(options),
    method: 'get',
})

registroPaciente.definition = {
    methods: ["get","head"],
    url: '/registro-paciente',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/registro-paciente'
 */
registroPaciente.url = (options?: RouteQueryOptions) => {
    return registroPaciente.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/registro-paciente'
 */
registroPaciente.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: registroPaciente.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/registro-paciente'
 */
registroPaciente.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: registroPaciente.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/registro-paciente'
 */
    const registroPacienteForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: registroPaciente.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/registro-paciente'
 */
        registroPacienteForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: registroPaciente.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/registro-paciente'
 */
        registroPacienteForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: registroPaciente.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    registroPaciente.form = registroPacienteForm
/**
 * @see [serialized-closure]:2
 * @route '/dashboard-enfermera'
 */
export const dashboardEnfermera = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardEnfermera.url(options),
    method: 'get',
})

dashboardEnfermera.definition = {
    methods: ["get","head"],
    url: '/dashboard-enfermera',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/dashboard-enfermera'
 */
dashboardEnfermera.url = (options?: RouteQueryOptions) => {
    return dashboardEnfermera.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/dashboard-enfermera'
 */
dashboardEnfermera.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardEnfermera.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/dashboard-enfermera'
 */
dashboardEnfermera.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboardEnfermera.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/dashboard-enfermera'
 */
    const dashboardEnfermeraForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: dashboardEnfermera.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/dashboard-enfermera'
 */
        dashboardEnfermeraForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboardEnfermera.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/dashboard-enfermera'
 */
        dashboardEnfermeraForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboardEnfermera.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    dashboardEnfermera.form = dashboardEnfermeraForm
/**
 * @see [serialized-closure]:2
 * @route '/citas-enfermera'
 */
export const citasEnfermera = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: citasEnfermera.url(options),
    method: 'get',
})

citasEnfermera.definition = {
    methods: ["get","head"],
    url: '/citas-enfermera',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/citas-enfermera'
 */
citasEnfermera.url = (options?: RouteQueryOptions) => {
    return citasEnfermera.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/citas-enfermera'
 */
citasEnfermera.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: citasEnfermera.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/citas-enfermera'
 */
citasEnfermera.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: citasEnfermera.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/citas-enfermera'
 */
    const citasEnfermeraForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: citasEnfermera.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/citas-enfermera'
 */
        citasEnfermeraForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: citasEnfermera.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/citas-enfermera'
 */
        citasEnfermeraForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: citasEnfermera.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    citasEnfermera.form = citasEnfermeraForm
/**
 * @see [serialized-closure]:2
 * @route '/medicamentos'
 */
export const medicamentos = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: medicamentos.url(options),
    method: 'get',
})

medicamentos.definition = {
    methods: ["get","head"],
    url: '/medicamentos',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/medicamentos'
 */
medicamentos.url = (options?: RouteQueryOptions) => {
    return medicamentos.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/medicamentos'
 */
medicamentos.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: medicamentos.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/medicamentos'
 */
medicamentos.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: medicamentos.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/medicamentos'
 */
    const medicamentosForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: medicamentos.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/medicamentos'
 */
        medicamentosForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: medicamentos.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/medicamentos'
 */
        medicamentosForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: medicamentos.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    medicamentos.form = medicamentosForm
/**
 * @see [serialized-closure]:2
 * @route '/pacientes-enfermera'
 */
export const pacientesEnfermera = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pacientesEnfermera.url(options),
    method: 'get',
})

pacientesEnfermera.definition = {
    methods: ["get","head"],
    url: '/pacientes-enfermera',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/pacientes-enfermera'
 */
pacientesEnfermera.url = (options?: RouteQueryOptions) => {
    return pacientesEnfermera.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/pacientes-enfermera'
 */
pacientesEnfermera.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pacientesEnfermera.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/pacientes-enfermera'
 */
pacientesEnfermera.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pacientesEnfermera.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/pacientes-enfermera'
 */
    const pacientesEnfermeraForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: pacientesEnfermera.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/pacientes-enfermera'
 */
        pacientesEnfermeraForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: pacientesEnfermera.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/pacientes-enfermera'
 */
        pacientesEnfermeraForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: pacientesEnfermera.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    pacientesEnfermera.form = pacientesEnfermeraForm
/**
 * @see [serialized-closure]:2
 * @route '/reportes-enfermera'
 */
export const reportesEnfermera = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reportesEnfermera.url(options),
    method: 'get',
})

reportesEnfermera.definition = {
    methods: ["get","head"],
    url: '/reportes-enfermera',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/reportes-enfermera'
 */
reportesEnfermera.url = (options?: RouteQueryOptions) => {
    return reportesEnfermera.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/reportes-enfermera'
 */
reportesEnfermera.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reportesEnfermera.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/reportes-enfermera'
 */
reportesEnfermera.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reportesEnfermera.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/reportes-enfermera'
 */
    const reportesEnfermeraForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: reportesEnfermera.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/reportes-enfermera'
 */
        reportesEnfermeraForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: reportesEnfermera.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/reportes-enfermera'
 */
        reportesEnfermeraForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: reportesEnfermera.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    reportesEnfermera.form = reportesEnfermeraForm
/**
 * @see [serialized-closure]:2
 * @route '/signos-vitales'
 */
export const signosVitales = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: signosVitales.url(options),
    method: 'get',
})

signosVitales.definition = {
    methods: ["get","head"],
    url: '/signos-vitales',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/signos-vitales'
 */
signosVitales.url = (options?: RouteQueryOptions) => {
    return signosVitales.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/signos-vitales'
 */
signosVitales.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: signosVitales.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/signos-vitales'
 */
signosVitales.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: signosVitales.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/signos-vitales'
 */
    const signosVitalesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: signosVitales.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/signos-vitales'
 */
        signosVitalesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: signosVitales.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/signos-vitales'
 */
        signosVitalesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: signosVitales.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    signosVitales.form = signosVitalesForm
/**
 * @see [serialized-closure]:2
 * @route '/tratamientos'
 */
export const tratamientos = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: tratamientos.url(options),
    method: 'get',
})

tratamientos.definition = {
    methods: ["get","head"],
    url: '/tratamientos',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/tratamientos'
 */
tratamientos.url = (options?: RouteQueryOptions) => {
    return tratamientos.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/tratamientos'
 */
tratamientos.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: tratamientos.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/tratamientos'
 */
tratamientos.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: tratamientos.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/tratamientos'
 */
    const tratamientosForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: tratamientos.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/tratamientos'
 */
        tratamientosForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: tratamientos.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/tratamientos'
 */
        tratamientosForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: tratamientos.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    tratamientos.form = tratamientosForm