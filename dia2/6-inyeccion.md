# Inyección

https://phpsecurity.readthedocs.io/en/latest/Cross-Site-Scripting-(XSS).html

# SQL

Ejemplo de inyección:

        <?php
        $índice    = $argv[0]; // ¡Cuidado, no hay validación en la entrada de datos!
        $consulta  = "SELECT id, name FROM products ORDER BY name LIMIT 20 OFFSET $índice;";
        $resultado = pg_query($conexión, $consulta);
        ?>


- Nunca conectarse como superusuario o como propietario de la base de datos. Siempre utilice usuarios con privilegios muy limitados.
- Emplear sentencias preparadas con variables vinculadas. Usando PDO, MySQLi y otras bibliotecas.
- Comprobar si la entrada proporcionada tiene el tipo de datos previsto.
- Si la expresión espera una entrada numérica, verificar los datos con la función ctype_digit().


#### NO USES SENTENCIAS DINÁMICAS NI FUNCIONES mysql_*

Las funciones `mysql_*` (mysql_connect, mysql_query, etc.) son inseguras por naturaleza y su uso no sólo no está recomendado, sino que se consideran obsoletas y se han eliminado completamente a partir de PHP7.

Incluso los métodos nativos que existen en PHP para sanear las entradas de usuario (como mysql_real_escape_string) pueden presentar (raros) problemas y fallar en algunos casos como cuando se usan codificación de caracteres diferentes a UTF-8 junto a versiones no actualizadas de MySQL (en las páginas de PHP para estas funciones se avisa de este riesgo).


Usa sentencias preparadas y consultas parametrizadas
Aunque se podrían sanear las entradas usando métodos como mysqli_real_escape_string, es más recomendable la utilización de sentencias preparadas o parametrizadas. Las sentencias preparadas te permitirán ejecutar la misma sentencia con gran eficiencia.

En PHP, tienes dos alternativas principales: PDO y MySQLi. Hay varias diferencias entre ambas, pero la principal es que PDO se puede usar con diferentes tipos de base de datos (dependiendo del driver utilizado) mientras que MySQLi es exclusivamente para bases de datos MySQL. Es por ello que recomendaría PDO sobre MySQLi.



# Tools

https://www.owasp.org/index.php/OWASP_Zed_Attack_Proxy_Project

        golismero.bat scan https://mediavida.com -o report.html
        python .\sqlmap-dev\sqlmap.py -u https://www.codespaceacademy.com/clickheat/index.php?language=1

### SVG

[firefox SVG](../firefox.svg)