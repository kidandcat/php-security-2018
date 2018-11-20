# Restauración y almacenaje de de contraseñas

## password_hash
http://php.net/manual/en/function.password-hash.php

### How to use https://stackoverflow.com/a/30279440/4158710

### Salt

En criptografía, una sal es un dato aleatorio que se usa como una entrada adicional a una función unidireccional que "hashea" datos.

Se genera aleatoriamente una nueva sal para cada contraseña. La sal y la contraseña se concatenan y procesan con una función criptográfica de hash, y la salida resultante se almacena con la sal en una base de datos.

Las sales defienden contra los ataques de diccionario o contra su hash equivalente, un ataque de tabla arco-iris precalculado.

https://es.wikipedia.org/wiki/Ataque_de_diccionario
https://es.wikipedia.org/wiki/Tabla_arco%C3%ADris


Nueva contraseña:

```
                 +------------------------------------------+
                 |                   PHP                    |
 new Password    |                                          |
                 | $salt = random_salt();                   |
+------------>   |                                          |
                 | $hpass = password_hash($password.$salt); |
                 |                                          |
                 | db_write($hpass, $salt);                 |
                 |     +                                    |
                 +------------------------------------------+
                       |
                       |
                       |
                       |
                       v
                +------+------+
                |             |
                |  Database   |
                |             |
                +-------------+
                |             |
                | hpass, salt |
                |             |
                +-------------+

```

Login:

```
             +------------------------------------------+                   +-------------+
             |                   PHP                    |                   |             |
 Password    |                                          |       $salt       |  Database   |
             | $salt = get_salt_for_user($user);        | <---------------+ |             |
+-------->   |                                          |                   +-------------+
             | $hpass = password_hash($password.$salt); |                   |             |
             |                                          |      $hpass       | hpass, salt |
             | $db_hpass = db_read_hpass($user);        | <---------------+ |             |
             |                                          |                   +-------------+
             | $hpass === $db_hpass                     |
             |                                          |
             +------------------------------------------+

```

### Password Recovery

Nunca resetear una contraseña a una cadena larga y aleatoria y enviarla por email. Ese tipo de contraseñas son dificiles de recordar, y harán
que algunos usuarios las apunten en algún medio escrito en vez de cambiarlas. Siempre enviar un enlace con un token único y un tiempo de vida
corto que envíe al usuario directamente a crear una nueva contraseña.


### Password strengh

        public function checkPassword($pwd, &$errors) {
                $errors_init = $errors;

                if (strlen($pwd) < 8) {
                        $errors[] = "Password too short!";
                }

                if (!preg_match("#[0-9]+#", $pwd)) {
                        $errors[] = "Password must include at least one number!";
                }

                if (!preg_match("#[a-zA-Z]+#", $pwd)) {
                        $errors[] = "Password must include at least one letter!";
                }     

                return ($errors == $errors_init);
        }


### Rapid-Fire Login Attempts

1. It takes virtually no time to crack a weak password, even if you're cracking it with an abacus

2. It takes virtually no time to crack an alphanumeric 9-character password if it is case insensitive

3. It takes virtually no time to crack an intricate, symbols-and-letters-and-numbers, upper-and-lowercase password if it is less than 8 characters long (a desktop PC can search the entire keyspace up to 7 characters in a matter of days or even hours)

4. It would, however, take an inordinate amount of time to crack even a 6-character password, if you were limited to one attempt per second!

Protección:

- CAPTCHA después de N intentos.
- Bloquear la cuenta y requerir verificación por email después de N intentos.
- Delay (pausa), establecer un tiempo de espera después de N intentos.

Lo más efectivo:

1 intento fallido = 0s delay
2 intento fallido = 2s delay
3 intento fallido = 4s delay
4 intento fallido = 8s delay
5 intento fallido = 16s delay

### Two Factor Authentication

Las credenciales pueden verse comprometidas, ya sea por exploits, porque se escriben y se pierden o los usuarios son víctimas de phising. Los inicios de sesión pueden protegerse aún más con la autenticación de dos factores, como enviar un email con un token de unos pocos carácteres.

https://medium.com/@richb_/easy-two-factor-authentication-2fa-with-google-authenticator-php-108388a1ea23