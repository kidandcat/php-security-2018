# Cross-Origin Resource Sharing


## Socorro, tengo un error de cors!! 

[Ah, gracias :D](https://enable-cors.org/server_php.html)



## Resumen

El estándar de Intercambio de Recursos de Origen Cruzado trabaja añadiendo nuevos encabezados HTTP que permiten a los servidores describir el conjunto de orígenes que tienen permiso de leer la información usando un explorador web.  Adicionalmente, para métodos de solicitud HTTP que causan efectos secundarios en datos del usuario, la especificación sugiere que los exploradores "verifiquen" la solicitud, solicitando métodos soportados desde el servidor con un método de solicitud HTTP OPTIONS, y luego, con la "aprobación" del servidor, enviar la verdadera solicitud con el método de solicitud HTTP verdadero. Los servidores pueden también notificar a los clientes cuando sus "credenciales" (incluyendo Cookies y datos de autenticación HTTP) deben ser enviados con solicitudes.

## MDN

https://developer.mozilla.org/es/docs/Web/HTTP/Access_control_CORS

