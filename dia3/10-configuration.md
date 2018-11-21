# Sanitizar salida de datos y riesgos de no hacerlo

http://php.net/manual/es/ini.core.php#ini.expose-php

    expose_php=Off


# Find Built-in PHP Modules

To see the set of compiled-in PHP modules type the following command:

    php -m

Disable unused modules:

    mv /etc/php.d/sqlite3.ini /etc/php.d/sqlite3.disable

## Hide all logs

Edit /etc/php.d/security.ini and set the following directive:

`allow_url_fopen`

Esta opción habilita las envolturas fopen de tipo URL que permiten el acceso a objetos URL como ficheros. Las envolturas predeterminadas están proporcionads para el acceso de ficheros remotos usando los protocolos ftp o http, algunas extensiones como zlib pueden registrar envolturas adicionales.

`allow_url_include`

Esta opción permite es uso de envolturas fopen de tipo URL con las siguientes funciones: include, include_once, require, require_once.

    display_errors=Off
    allow_url_fopen=Off
    allow_url_include=Off


## Max execution time

En segundos:

    max_execution_time =  30
    max_input_time = 30
    memory_limit = 40M