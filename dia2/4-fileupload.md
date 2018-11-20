# Carga de archivos de forma segura y uso de variables en nombres de ficheros

http://php.net/manual/es/features.file-upload.post-method.php

`$_FILES['fichero_usuario']['name']`
El nombre original del fichero en la máquina del cliente.

`$_FILES['fichero_usuario']['type']`
El tipo MIME del fichero, si el navegador proporcionó esta información. Un ejemplo sería "image/gif". Este tipo MIME, sin embargo, no se comprueba en el lado de PHP y por lo tanto no se garantiza su valor.

`$_FILES['fichero_usuario']['size']`
El tamaño, en bytes, del fichero subido.

`$_FILES['fichero_usuario']['tmp_name']`
El nombre temporal del fichero en el cual se almacena el fichero subido en el servidor.

`$_FILES['fichero_usuario']['error']`
El código de error asociado a esta subida.

# Comprobaciones

#### Tamaño

Utilizar la variable `size` para descartar cualquier fichero que sea demasiado pequeño o demasiado grande.

Utilizar la variable `type` para descartar cualquier fichero que no corresponda con un cierto criterio de tipo.

#### is_uploaded_file 

http://php.net/manual/es/function.is-uploaded-file.php

Devuelve TRUE si el archivo nombrado por filename fue subido mediante HTTP POST. Esto es útil para intentar asegurarse de que un usuario malicioso no ha intentado engañar al script haciéndole trabajar con archivos con los que no debiera de estar trabajando--por ejemplo, /etc/passwd.