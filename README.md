# Practica5-PHP

- [Características](#características)
- [Configuraciones de Seguridad](#configuraciones-de-seguridad)
- [Configuraciones de Seguridad en .htaccess](#configuraciones-de-seguridad-en-htaccess)
- [Licencia](#licencia)

## Características
- Estructura de código modular siguiendo el patrón MVC.
- Registro de usuarios con verificación de nombres de usuario y correos únicos.
- Validación de contraseñas para cumplir con estándares de seguridad.
- Gestión adecuada de sesiones para autenticación de usuarios.
- Implementación de cookies para recordar a los usuarios durante el inicio de sesión.
- Validación de entradas antes de ejecutar consultas SQL.
- Uso de constantes para mostrar mensajes y notificaciones.
- Estilo CSS básico para mejorar la interfaz de usuario.

## Configuraciones de Seguridad
- **Verificación de Usuarios Únicos**: Compruebo que los nombres de usuario y correos electrónicos sean únicos antes del registro.
- **Validación de Contraseñas**: Valido las contraseñas para cumplir con estándares de seguridad, incluyendo requisitos de complejidad.
- **Validación de Entradas**: Valido todos los datos en el servidor antes de ejecutar consultas SQL para prevenir inyecciones SQL.
- **Gestión de Sesiones**: Manejo adecuadamente las sesiones para garantizar la autenticación y autorización de usuarios.
- **Implementación de Cookies**: Utilizo cookies en el controlador de inicio de sesión para recordar de forma segura a los usuarios.
- **Constantes para Mensajes**: Gestiono los mensajes de error y notificaciones usando constantes para mantener la consistencia.

## Configuraciones de Seguridad en .htaccess
En el archivo `.htaccess`:

- Fuerzo el uso de conexiones cifradas, reduciendo el riesgo de intercepciones.
- Restringo el acceso a archivos sensibles, evitando su exposición directa.
- Prevengo el uso no autorizado de mi sitio a través de iframes de terceros.
- Activo mecanismos de protección contra ataques Cross-Site Scripting.

Estas acciones, sumadas a las implementadas en la lógica interna de la aplicación, refuerzan significativamente la protección global del sistema.

