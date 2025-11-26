// configuracion.js - Manteniendo el diseño del recepcionista

// Configuración del sistema
let systemConfig = {
    general: {
        systemName: "Hospital Management Pro",
        version: "v2.4.1",
        lastUpdate: "15 Ene 2024",
        license: "active",
        database: "MySQL 8.0",
        theme: "light",
        language: "es",
        timezone: "America/Mexico_City",
        dateFormat: "dd/mm/yyyy"
    },
    seguridad: {
        twoFactorAuth: true,
        sessionTimeout: true,
        sessionTimeoutValue: 30,
        maxSessions: 3,
        passwordPolicy: "standard",
        minPasswordLength: 8,
        passwordExpiry: 90,
        passwordHistory: true,
        firewallEnabled: true,
        sslEnabled: true,
        allowedIPs: ["192.168.1.0/24", "10.0.0.0/16"]
    },
    notificaciones: {
        smtpServer: "smtp.hospital.com",
        smtpPort: 587,
        smtpSecurity: "tls",
        systemEmail: "sistema@hospital.com",
        emailAlerts: {
            security: true,
            dailyReports: true,
            backup: false,
            errors: true
        },
        systemAlerts: {
            newUsers: true,
            suspiciousActivity: true,
            systemUpdates: false
        }
    },
    integraciones: {
        aws: {
            connected: true,
            region: "us-east-1",
            lastSync: "Hace 2 horas"
        },
        cloudBackup: {
            configured: false,
            provider: "No configurado",
            status: "Requiere configuración"
        },
        apiKey: "sk_live_**********",
        webhookUrl: "",
        webhookEnabled: false,
        webhookSecret: ""
    },
    avanzado: {
        database: {
            host: "localhost",
            port: 3306,
            name: "hospital_db",
            user: "******"
        }
    },
    modules: {
        users: {
            enabled: true,
            autoRegister: true
        },
        billing: {
            enabled: true,
            autoTax: true
        },
        inventory: {
            enabled: false,
            stockAlerts: false
        },
        reports: {
            enabled: true,
            autoGeneration: true
        }
    }
};

// Inicializar la página
document.addEventListener('DOMContentLoaded', function() {
    initializeTabs();
    loadConfiguration();
    updateSystemStats();
});

// Inicializar pestañas de navegación
function initializeTabs() {
    const tabs = document.querySelectorAll('.nav-tab');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remover clase active de todas las pestañas
            tabs.forEach(t => t.classList.remove('active'));
            // Agregar clase active a la pestaña clickeada
            this.classList.add('active');
            
            // Ocultar todos los contenidos
            document.querySelectorAll('.config-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Mostrar el contenido correspondiente
            document.getElementById(`${targetTab}-tab`).classList.add('active');
        });
    });
}

// Cargar configuración en la interfaz
function loadConfiguration() {
    // Configuración General
    document.getElementById('themeSelect').value = systemConfig.general.theme;
    document.getElementById('languageSelect').value = systemConfig.general.language;
    document.getElementById('timezoneSelect').value = systemConfig.general.timezone;
    document.getElementById('dateFormat').value = systemConfig.general.dateFormat;
    
    // Configuración de Seguridad
    document.getElementById('twoFactorAuth').checked = systemConfig.seguridad.twoFactorAuth;
    document.getElementById('sessionTimeout').checked = systemConfig.seguridad.sessionTimeout;
    document.getElementById('sessionTimeoutValue').value = systemConfig.seguridad.sessionTimeoutValue;
    document.getElementById('maxSessions').value = systemConfig.seguridad.maxSessions;
    document.getElementById('passwordPolicy').value = systemConfig.seguridad.passwordPolicy;
    document.getElementById('minPasswordLength').value = systemConfig.seguridad.minPasswordLength;
    document.getElementById('passwordExpiry').value = systemConfig.seguridad.passwordExpiry;
    document.getElementById('passwordHistory').checked = systemConfig.seguridad.passwordHistory;
    document.getElementById('firewallEnabled').checked = systemConfig.seguridad.firewallEnabled;
    document.getElementById('sslEnabled').checked = systemConfig.seguridad.sslEnabled;
    
    // Configuración de Notificaciones
    document.getElementById('smtpServer').value = systemConfig.notificaciones.smtpServer;
    document.getElementById('smtpPort').value = systemConfig.notificaciones.smtpPort;
    document.getElementById('smtpSecurity').value = systemConfig.notificaciones.smtpSecurity;
    document.getElementById('systemEmail').value = systemConfig.notificaciones.systemEmail;
    
    // Configuración de Integraciones
    document.getElementById('apiKey').value = systemConfig.integraciones.apiKey;
    document.getElementById('webhookUrl').value = systemConfig.integraciones.webhookUrl;
    document.getElementById('webhookEnabled').checked = systemConfig.integraciones.webhookEnabled;
    document.getElementById('webhookSecret').value = systemConfig.integraciones.webhookSecret;
    
    // Configuración Avanzada
    document.getElementById('dbHost').value = systemConfig.avanzado.database.host;
    document.getElementById('dbPort').value = systemConfig.avanzado.database.port;
    document.getElementById('dbName').value = systemConfig.avanzado.database.name;
    document.getElementById('dbUser').value = systemConfig.avanzado.database.user;
    
    // Cargar IPs permitidas
    loadAllowedIPs();
}

// Cargar IPs permitidas en la lista
function loadAllowedIPs() {
    const ipList = document.querySelector('.ip-list');
    ipList.innerHTML = '';
    
    systemConfig.seguridad.allowedIPs.forEach(ip => {
        const ipItem = document.createElement('div');
        ipItem.className = 'ip-item';
        ipItem.innerHTML = `
            <span>${ip}</span>
            <button class="btn-action btn-delete" onclick="removeIP('${ip}')">
                <i class="fas fa-times"></i>
            </button>
        `;
        ipList.appendChild(ipItem);
    });
}

// Agregar nueva IP
function addIP() {
    const newIPInput = document.getElementById('newIP');
    const newIP = newIPInput.value.trim();
    
    if (!newIP) {
        showNotification('Por favor ingresa una dirección IP', 'error');
        return;
    }
    
    // Validación básica de IP
    if (!isValidIP(newIP)) {
        showNotification('Formato de IP inválido', 'error');
        return;
    }
    
    if (systemConfig.seguridad.allowedIPs.includes(newIP)) {
        showNotification('La IP ya está en la lista', 'warning');
        return;
    }
    
    systemConfig.seguridad.allowedIPs.push(newIP);
    loadAllowedIPs();
    newIPInput.value = '';
    showNotification('IP agregada correctamente', 'success');
}

// Remover IP
function removeIP(ip) {
    systemConfig.seguridad.allowedIPs = systemConfig.seguridad.allowedIPs.filter(item => item !== ip);
    loadAllowedIPs();
    showNotification('IP removida correctamente', 'success');
}

// Validar formato de IP
function isValidIP(ip) {
    // Validación simple para IPs y rangos CIDR
    const ipRegex = /^(\d{1,3}\.){3}\d{1,3}(\/\d{1,2})?$/;
    return ipRegex.test(ip);
}

// Buscar en configuración
function searchConfig() {
    const searchTerm = document.getElementById('searchConfig').value.toLowerCase();
    
    // Ocultar todas las pestañas primero
    document.querySelectorAll('.config-content').forEach(content => {
        content.classList.remove('active');
    });
    
    document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Buscar en diferentes secciones
    const sections = ['general', 'seguridad', 'notificaciones', 'integraciones', 'avanzado'];
    
    for (let section of sections) {
        const content = document.getElementById(`${section}-tab`);
        const text = content.textContent.toLowerCase();
        
        if (text.includes(searchTerm)) {
            content.classList.add('active');
            document.querySelector(`[data-tab="${section}"]`).classList.add('active');
            break;
        }
    }
    
    if (!searchTerm) {
        // Si no hay término de búsqueda, mostrar pestaña general
        document.getElementById('general-tab').classList.add('active');
        document.querySelector('[data-tab="general"]').classList.add('active');
    }
}

// Actualizar estadísticas del sistema
function updateSystemStats() {
    // Simular datos actualizados
    document.getElementById('uptime').textContent = '99.8%';
    document.getElementById('databaseSize').textContent = '2.4 GB';
    document.getElementById('activeUsers').textContent = '156';
    document.getElementById('securityScore').textContent = '92%';
}

// Configurar módulo
function configureModule(moduleName) {
    showNotification(`Configurando módulo: ${moduleName}`, 'info');
    // En una aplicación real, aquí abrirías un modal de configuración específico
}

// Probar configuración de email
function testEmailConfig() {
    showNotification('Probando configuración de email...', 'info');
    
    setTimeout(() => {
        showNotification('Configuración de email probada exitosamente', 'success');
    }, 2000);
}

// Configurar AWS
function configureAWS() {
    showNotification('Abriendo configuración de AWS...', 'info');
    // En una aplicación real, aquí abrirías un modal de configuración de AWS
}

// Configurar respaldo en nube
function setupCloudBackup() {
    showNotification('Iniciando configuración de respaldo en nube...', 'info');
    // En una aplicación real, aquí abrirías un wizard de configuración
}

// Regenerar API Key
function regenerateAPIKey() {
    if (confirm('¿Estás seguro de que deseas regenerar la API Key? Esto invalidará la clave actual.')) {
        const newKey = 'sk_live_' + Math.random().toString(36).substr(2, 32);
        systemConfig.integraciones.apiKey = newKey;
        document.getElementById('apiKey').value = newKey;
        showNotification('API Key regenerada correctamente', 'success');
    }
}

// Probar conexión a base de datos
function testDatabaseConnection() {
    showNotification('Probando conexión a base de datos...', 'info');
    
    setTimeout(() => {
        showNotification('Conexión a base de datos exitosa', 'success');
    }, 1500);
}

// Limpiar cache
function clearCache() {
    showNotification('Limpiando cache del sistema...', 'info');
    
    setTimeout(() => {
        showNotification('Cache limpiado correctamente', 'success');
    }, 1000);
}

// Optimizar base de datos
function optimizeDatabase() {
    showNotification('Optimizando base de datos...', 'info');
    
    setTimeout(() => {
        showNotification('Base de datos optimizada correctamente', 'success');
    }, 3000);
}

// Limpiar logs
function clearLogs() {
    if (confirm('¿Estás seguro de que deseas limpiar todos los logs del sistema?')) {
        showNotification('Limpiando logs del sistema...', 'info');
        
        setTimeout(() => {
            showNotification('Logs limpiados correctamente', 'success');
        }, 2000);
    }
}

// Buscar actualizaciones
function checkForUpdates() {
    showNotification('Buscando actualizaciones...', 'info');
    
    setTimeout(() => {
        showNotification('El sistema está actualizado', 'success');
    }, 2500);
}

// Mostrar modal de restablecimiento
function showResetModal() {
    document.getElementById('resetModal').classList.add('active');
}

// Cerrar modal de restablecimiento
function closeResetModal() {
    document.getElementById('resetModal').classList.remove('active');
}

// Restablecer a valores predeterminados
function resetToDefaults() {
    if (confirm('¿ESTÁS ABSOLUTAMENTE SEGURO? Esta acción restablecerá TODA la configuración del sistema.')) {
        showNotification('Restableciendo configuración...', 'info');
        
        setTimeout(() => {
            // En una aplicación real, aquí llamarías al backend para restablecer
            systemConfig = getDefaultConfig();
            loadConfiguration();
            closeResetModal();
            showNotification('Configuración restablecida correctamente', 'success');
        }, 3000);
    }
}

// Mostrar modal de eliminación
function showDeleteModal() {
    if (confirm('¡ACCIÓN EXTREMADAMENTE PELIGROSA! ¿Estás seguro de que deseas eliminar TODOS los datos del sistema? Esta acción es IRREVERSIBLE.')) {
        if (confirm('¿REALMENTE ESTÁS SEGURO? Esta acción eliminará permanentemente todos los datos.')) {
            const confirmation = prompt('Escribe "ELIMINAR TODO" para confirmar:');
            if (confirmation === 'ELIMINAR TODO') {
                showNotification('Eliminando todos los datos...', 'error');
                // En una aplicación real, aquí llamarías al backend para eliminar datos
            } else {
                showNotification('Acción cancelada', 'warning');
            }
        }
    }
}

// Obtener configuración predeterminada
function getDefaultConfig() {
    return {
        general: {
            systemName: "Hospital Management Pro",
            version: "v2.4.1",
            lastUpdate: new Date().toLocaleDateString('es-ES'),
            license: "active",
            database: "MySQL 8.0",
            theme: "light",
            language: "es",
            timezone: "America/Mexico_City",
            dateFormat: "dd/mm/yyyy"
        },
        seguridad: {
            twoFactorAuth: true,
            sessionTimeout: true,
            sessionTimeoutValue: 30,
            maxSessions: 3,
            passwordPolicy: "standard",
            minPasswordLength: 8,
            passwordExpiry: 90,
            passwordHistory: true,
            firewallEnabled: true,
            sslEnabled: true,
            allowedIPs: ["192.168.1.0/24"]
        },
        notificaciones: {
            smtpServer: "smtp.hospital.com",
            smtpPort: 587,
            smtpSecurity: "tls",
            systemEmail: "sistema@hospital.com",
            emailAlerts: {
                security: true,
                dailyReports: true,
                backup: false,
                errors: true
            },
            systemAlerts: {
                newUsers: true,
                suspiciousActivity: true,
                systemUpdates: false
            }
        },
        integraciones: {
            aws: {
                connected: false,
                region: "",
                lastSync: ""
            },
            cloudBackup: {
                configured: false,
                provider: "No configurado",
                status: "Requiere configuración"
            },
            apiKey: "sk_live_" + Math.random().toString(36).substr(2, 32),
            webhookUrl: "",
            webhookEnabled: false,
            webhookSecret: ""
        },
        avanzado: {
            database: {
                host: "localhost",
                port: 3306,
                name: "hospital_db",
                user: "******"
            }
        },
        modules: {
            users: {
                enabled: true,
                autoRegister: true
            },
            billing: {
                enabled: true,
                autoTax: true
            },
            inventory: {
                enabled: false,
                stockAlerts: false
            },
            reports: {
                enabled: true,
                autoGeneration: true
            }
        }
    };
}

// Guardar toda la configuración
function saveAllSettings() {
    // Recopilar configuración actualizada
    const updatedConfig = {
        general: {
            theme: document.getElementById('themeSelect').value,
            language: document.getElementById('languageSelect').value,
            timezone: document.getElementById('timezoneSelect').value,
            dateFormat: document.getElementById('dateFormat').value,
            // Mantener otros valores
            systemName: systemConfig.general.systemName,
            version: systemConfig.general.version,
            lastUpdate: systemConfig.general.lastUpdate,
            license: systemConfig.general.license,
            database: systemConfig.general.database
        },
        seguridad: {
            twoFactorAuth: document.getElementById('twoFactorAuth').checked,
            sessionTimeout: document.getElementById('sessionTimeout').checked,
            sessionTimeoutValue: parseInt(document.getElementById('sessionTimeoutValue').value),
            maxSessions: parseInt(document.getElementById('maxSessions').value),
            passwordPolicy: document.getElementById('passwordPolicy').value,
            minPasswordLength: parseInt(document.getElementById('minPasswordLength').value),
            passwordExpiry: parseInt(document.getElementById('passwordExpiry').value),
            passwordHistory: document.getElementById('passwordHistory').checked,
            firewallEnabled: document.getElementById('firewallEnabled').checked,
            sslEnabled: document.getElementById('sslEnabled').checked,
            allowedIPs: systemConfig.seguridad.allowedIPs
        },
        notificaciones: {
            smtpServer: document.getElementById('smtpServer').value,
            smtpPort: parseInt(document.getElementById('smtpPort').value),
            smtpSecurity: document.getElementById('smtpSecurity').value,
            systemEmail: document.getElementById('systemEmail').value,
            emailAlerts: systemConfig.notificaciones.emailAlerts,
            systemAlerts: systemConfig.notificaciones.systemAlerts
        },
        integraciones: {
            aws: systemConfig.integraciones.aws,
            cloudBackup: systemConfig.integraciones.cloudBackup,
            apiKey: document.getElementById('apiKey').value,
            webhookUrl: document.getElementById('webhookUrl').value,
            webhookEnabled: document.getElementById('webhookEnabled').checked,
            webhookSecret: document.getElementById('webhookSecret').value
        },
        avanzado: {
            database: {
                host: document.getElementById('dbHost').value,
                port: parseInt(document.getElementById('dbPort').value),
                name: document.getElementById('dbName').value,
                user: document.getElementById('dbUser').value
            }
        },
        modules: systemConfig.modules
    };
    
    systemConfig = updatedConfig;
    
    showNotification('Toda la configuración ha sido guardada correctamente', 'success');
}

// Descartar cambios
function resetChanges() {
    if (confirm('¿Descartar todos los cambios no guardados?')) {
        loadConfiguration();
        showNotification('Cambios descartados', 'info');
    }
}

// Función de logout
function logout() {
    if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        showNotification('Sesión cerrada correctamente', 'info');
        // En una aplicación real, aquí redirigirías al login
        setTimeout(() => {
            window.location.href = 'login.html';
        }, 1000);
    }
}

// Mostrar notificación
function showNotification(message, type = 'info') {
    // En una aplicación real, usarías un sistema de notificaciones más sofisticado
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#007bff'};
        color: white;
        border-radius: 5px;
        z-index: 1001;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Cerrar modales al hacer clic fuera de ellos
document.getElementById('resetModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeResetModal();
    }
});