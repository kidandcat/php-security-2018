# Cross-Origin Resource Sharing


El estándar de Intercambio de Recursos de Origen Cruzado trabaja añadiendo nuevos encabezados HTTP que permiten a los servidores describir el conjunto de orígenes que tienen permiso de leer la información usando un explorador web.  Adicionalmente, para métodos de solicitud HTTP que causan efectos secundarios en datos del usuario, la especificación sugiere que los exploradores "verifiquen" la solicitud, solicitando métodos soportados desde el servidor con un método de solicitud HTTP OPTIONS, y luego, con la "aprobación" del servidor, enviar la verdadera solicitud con el método de solicitud HTTP verdadero. Los servidores pueden también notificar a los clientes cuando sus "credenciales" (incluyendo Cookies y datos de autenticación HTTP) deben ser enviados con solicitudes.

## MDN

https://developer.mozilla.org/es/docs/Web/HTTP/Access_control_CORS

# Solicitud simple

Una solicitud de sitio cruzado simple es aquella que cumple las siguientes condiciones:

Los únicos métodos aceptados son:
- GET
- HEAD
- POST.

Aparte de los encabezados establecidos automáticamente por el agente usuario (ej. Connection, User-Agent,etc.), los únicos encabezados que están permitidos para establecer manualmente son:

- Accept
- Accept-Language
- Content-Language
- Content-Type

Los únicos valores permitidos del encabezado Content-Type son:

- application/x-www-form-urlencoded
- multipart/form-data
- text/plain


```
+-----+                                                                                 +-----+
|     |                                                                                 |     |
|     |  +--------------------------------------------------------------------------->  |     |
|     |                       GET /resources/upload                                     |     |
|     |                       Origin: http://bar.example                                |     |
|     |                                                                                 |     |
|     |  <---------------------------------------------------------------------------+  |     |
|     |                       200 OK                                                    |     |
|     |         + +           Access-Control-Allow-Origin: http://foo.example           |     |
|     |         | |           Content-Type: application/json                            |     |
|  B  |         | |                                                                     |  S  |
|  r  |         | |             {                                                       |  e  |
|  o  |         | |               "name": "Jairo",                                      |  r  |
|  w  |         | |               "age": 25                                             |  v  |
|  s  |         | |             }                                                       |  e  |
|  e  |         | |                                                                     |  r  |
|  r  |         + +                                                                     |     |
|     |                                                                                 |     |
|     |                                                                                 |     |
|     |                                                                                 |     |
|     |                                                                                 |     |
|     |  +--------------------------------------------------------------------------->  |     |
|     |                       GET /resources/upload                                     |     |
|     |                       Origin: http://foo.example                                |     |
|     |                                                                                 |     |
|     |  <---------------------------------------------------------------------------+  |     |
|     |                       200 OK                                                    |     |
|     |                                                                                 |     |
|     |                       Access-Control-Allow-Origin: http://foo.example           |     |
|     |                       Content-Type: application/json                            |     |
|     |                                                                                 |     |
|     |                         {                                                       |     |
|     |                           "name": "Jairo",                                      |     |
|     |                           "age": 25                                             |     |
|     |                         }                                                       |     |
|     |                                                                                 |     |
|     |                                                                                 |     |
+-----+                                                                                 +-----+
```



# Solicitud verificada

- Usa métodos distintos a GET, HEAD o POST.  

- Si POST es utilizado para enviar solicitudes de información con Content-Type distinto a application/x-www-form-urlencoded, multipart/form-data, o text/plain, ej. si la solicitud POST envía una carga XML al servidor utilizando application/xml or text/xml, entonces la solicitud es verificada.

- Si se establecen encabezados personalizados (ej. la solicitud usa un encabezado como X-PINGOTHER)

```
+-----+  +--------------------------------------------------------------------------->  +-----+
|     |                                                                                 |     |
|     |                       OPTIONS /resources/upload                                 |     |
|     |                                                                                 |     |
|     |                       Access-Control-Request-Method: POST                       |     |
|     |                       Access-Control-Request-Headers: X-PINGOTHER               |     |
|     |                       Origin: http://foo                                        |     |
|     |                                                                                 |     |
|     |                                                                                 |     |
|     |                                                                                 |     |
|  B  |  <---------------------------------------------------------------------------+  |  S  |
|  r  |                                                                                 |  e  |
|  o  |                       200 OK                                                    |  r  |
|  w  |                                                                                 |  v  |
|  s  |                       Access-Control-Allow-Origin: http://foo.example           |  e  |
|  e  |                       Access|Control|Allow|Methods: POST, GET, OPTIONS          |  r  |
|  r  |                       Access|Control|Allow-Headers: X-PINGOTHER                 |     |
|     |                       Access-Control-Max-Age: 1728000                           |     |
|     |                                                                                 |     |
|     |                                                                                 |     |
|     |                                                                                 |     |
|     |  +--------------------------------------------------------------------------->  |     |
|     |                                                                                 |     |
|     |                       POST /resources/upload                                    |     |
|     |                                                                                 |     |
|     |                       X-PINGOTHER: pingpong                                     |     |
|     |                       Content-Type: application/json                            |     |
|     |                       Content-Length: 55                                        |     |
|     |                       Origin: http://foo.example                                |     |
|     |                                                                                 |     |
|     |                         {                                                       |     |
|     |                           "name": "Jairo",                                      |     |
|     |                           "age": 25                                             |     |
|     |                         }                                                       |     |
|     |                                                                                 |     |
|     |  <---------------------------------------------------------------------------+  |     |
|     |                                                                                 |     |
+-----+                       200 OK                                                    +-----+
```


# Solicitud con credenciales

Por defecto, en las peticiones AJAX de un sitio curzado, los navegadores no enviarán credenciales.
Para trabajar con credenciales y cookies:

        var ajax = new XMLHttpRequest();

        ajax.open('GET', 'http://bar.example', true);
        ajax.withCredentials = true;
        ajax.onreadystatechange = handler;
        ajax.send(); 

La opción withCredentials tiene que ser establecida para poder hacer la llamada con Cookies. 

Para que la llamada tenga éxito, el servidor debe responder con las siguientes cabeceras:

        Access-Control-Allow-Origin: http://bar.example
        Access-Control-Allow-Credentials: true

Si el servidor no responde con esas dos cabeceras, el navegador descartará la respuesta recibida.
IMPORTANTE: `Access-Control-Allow-Origin: *` no es válido para peticiones con credenciales. 