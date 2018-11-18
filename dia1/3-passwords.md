# Restauración y almacenaje de de contraseñas

## password_hash
http://php.net/manual/en/function.password-hash.php

### How to use https://stackoverflow.com/a/30279440/4158710

Double step hash:

```
        +-----------+                       Password travels encrypted                   +--------------+
        |           |                                                                    |              |
        |  Browser  |      +--------------------------------------------------------->   |    Server    |
        |           |                                                                    |              |
        +-----------+                                                                    +--------------+

Basic encryption client-side                                                 Receives password and hash it before saving

        MD5(password)


   +                                        +                                           +
   |                                        |                                           |
   |                                        |                                           |
   |                                        |                                           |
   | Client compromised                     | Connection compromised                    | Server compromised
   | Our own system is compromised          | Our own system is compromised             | Our own system is compromised
   | And                                    | But                                       | But
   | Client's passwords                     | Client's passwords are safe               | Client's passwords are safe
   | are also compromised                   |                                           |
   |                                        |                                           |
   |                                        |                                           |
   v                                        v                                           v

```

### Salt

In cryptography, a salt is random data that is used as an additional input to a one-way function that "hashes" data.

A new salt is randomly generated for each password. The salt and the password are concatenated and processed with a cryptographic hash function, and the resulting output is stored with the salt in a database.

Salts defend against dictionary attacks or against their hashed equivalent, a pre-computed rainbow table attack.

https://es.wikipedia.org/wiki/Ataque_de_fuerza_bruta
https://es.wikipedia.org/wiki/Ataque_de_diccionario
https://es.wikipedia.org/wiki/Tabla_arco%C3%ADris

### Two Factor Authentication

https://medium.com/@richb_/easy-two-factor-authentication-2fa-with-google-authenticator-php-108388a1ea23