# Sesiones

## Qué es una sesión

Una sesión es un mecanismo que permite conservar información sobre un usuario al pasar de una página a otra. A diferencia de una cookie, los datos asociados a una sesión se almacenan en el servidor y nunca en el cliente.

En la mayoría de las tecnologías de web scripting, las sesiones se implementan mediante una cookie que almacena un valor que identifica al usuario en el servidor web cada vez que pasa de una página web a otra. En el servidor web están almacenados todos los datos de la sesión y se accede a ellos cada vez que se pasa de página gracias al identificador almacenado en la cookie.


```
+---------------------------------+                       +---------------------------------------------+
|                                 |                       |                                             |
|                                 |                       |                                             |
|             Browser       +---------------------------------------+        Server                     |
|                           |     |                       |         |                                   |
|                           |     |                       |         |                                   |
|                           |     |                       |         |                                   |
|             Cookies       |     |                       |         |    Cookies Storage                |
|                           +     |                       |         v                                   |
|   session_id: 79sdiHS18Djw129   |                       |   79sdiHS18Djw129: {name: Jairo, age: 25}   |
|                                 |                       |                                             |
|                                 |                       |                                             |
+---------------------------------+                       +---------------------------------------------+

```

## Dónde guarda PHP la información

## Cómo funciona un ataque de suplantación de identidad

## En un ataque, qué agentes intervienen (servidor, código cliente, usuario, navegador, agente malicioso)

## Propiedades de las cookies
 * Nombre
 * Valor
 * Dominio*
 * Path*
 * Expiración*
 * Tamaño*
 * HTTP*
 * Secure*
 * SameSite*


# Tareas

### Propiedades de las cookies:

Investigar sobre una de las propiedades de las cookies con * qué tipo de ataques pueden prevenir si se usan correctamente.

### Frameworks PHP:

Investigar sobre uno de los frameworks qué tipo de cookies usa para mantener las sesiones (¿usan su propio mecanismo?, ¿usan la sesion de php sin modificaciones?)

- Laravel
- Symfony
- Zend
- Codeigniter
- Phalcon
- Yii
- CakePHP
- FuelPHP
- PHPixie


http://es.php.net/manual/es/intro.session.php
http://es.php.net/manual/es/session.security.php

- SessionHandler http://es.php.net/manual/es/class.sessionhandlerinterface.php
