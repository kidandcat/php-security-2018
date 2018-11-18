# Logs

### error_log
http://php.net/manual/es/function.error-log.php

By default, whenever an error or exception is thrown, PHP sends the error message directly to the user via STDOUT. In a command-line environment, this means that errors are rendered in the terminal. In a web server environment, the logs will be showed or stored depending on the web server and its configuration.


### Dónde se guardan los logs:
    phpinfo "error_log"


### Tipos de logs y configuraciones:
https://www.loggly.com/ultimate-guide/php-logging-basics/


## Tareas

Investigar servicios de logging. Ejemplo:

- https://sentry.io (open source https://github.com/getsentry/sentry)
- https://airbrake.io