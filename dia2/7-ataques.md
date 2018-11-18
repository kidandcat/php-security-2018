http://php.net/manual/es/security.general.php

    Un sistema completamente seguro es prácticamente imposible, de modo que el enfoque usado con mayor frecuencia en la profesión de seguridad es uno que busque el balance adecuado entre riesgo y funcionalidad.
|

    Un sistema es apenas tan bueno como el eslabón más débil de una cadena. 
|

    Cuando realice pruebas, tenga en mente que no será capaz de probar todas las diferentes posibilidades, incluso para las páginas más simples. Los datos de entrada que usted puede esperar en sus aplicaciones no necesariamente tendrán relación alguna con el tipo de información que podría ingresar un empleado disgustado, un cracker con meses de tiempo entre sus manos, o un gato doméstico caminando sobre el teclado. 
|

    No importa si usted administra un sitio pequeño o grande, usted es un objetivo por el simple hecho de estar en línea, por tener un servidor al cual es posible conectarse. Muchas aplicaciones de cracking no hacen distinciones por tamaños, simplemente recorren bloques masivos de direcciones IP en busca de víctimas. 
|

    Trate de no convertirse en una.

# Ataques CSRF / XSS

![csrf](../csrf.png)

El ataque se puede prevenir generando un token y enviando el token en una entrada oculta en el formulario. Además, establece una variable de sesión para el token. En su formulario PHP que recibe los datos del POST, verifique si el token de sesión y el token enviado coinciden. Si coinciden, el formulario provino de su sitio.


# HPP

## ¿Qué es HTTP Parameter Pollution(HPP)?

Un ataque de polución de parámetros HTTP consiste en la inyección de delimitadores de query string codificados en otros parámetros existentes. Si el parámetro en el que se ha realizado la inyección no se valida correctamente y se utiliza decodificado para generar una URL, el atacante puede insertar uno o más parámetros en dicha URL. 

http://www.elladodelmal.com/2011/03/hpp-http-parameter-pollution.html

## Bytes nulos

http://php.net/manual/es/security.filesystem.nullbytes.php

# Ataques

https://www.owasp.org/index.php/Category:Attack