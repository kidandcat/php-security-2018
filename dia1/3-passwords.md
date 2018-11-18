# Restauración y almacenaje de de contraseñas

## password_hash
http://php.net/manual/en/function.password-hash.php

### How to use https://stackoverflow.com/a/30279440/4158710

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