<?php
# Con esta directiva PHP mostrará los errores en el navegador (muy util para debuggear)
ini_set("display_errors", true);

# Logeamos con todo por defecto
<<<<<<< HEAD
error_log("Esto ya no es un error! KO KO Ko");
=======
error_log("Esto ya no es un error! ok ok ok");
>>>>>>> test

# Con el segundo parámetro de error_log a 1, error_log enviará un email
error_log("Hola!", 1, "kidandcat@gmail.com");
