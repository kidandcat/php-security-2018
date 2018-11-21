# Sanitizar entrada de datos

### SQL prepared statements

http://php.net/manual/es/mysqli.quickstart.prepared-statements.php

---

### Escapar cadenas (método antiguo, PHP < 5.2)

- HTML http://php.net/manual/es/function.htmlspecialchars.php
- Shell
   - http://php.net/manual/es/function.escapeshellcmd.php
   - http://php.net/manual/es/function.escapeshellarg.php

---

# Validación y saneamiento (PHP 5 >= 5.2.0, PHP 7)

http://php.net/manual/es/intro.filter.php

## Validación

http://php.net/manual/es/filter.examples.validation.php

- Filtros disponibles http://php.net/manual/es/filter.filters.validate.php

## Saneamiento

http://php.net/manual/es/filter.examples.sanitization.php

- Filtros disponibles http://php.net/manual/es/filter.filters.sanitize.php

## Filter Input

http://php.net/manual/es/function.filter-input.php

## PHP MySQL PDO

There is no final query. The server receives your SQL-statement and your params and executes that optimized. The query itself will never get stringified together with the params.

### Enable log

For mysql < 5.1.29

      To enable the query log, put this in /etc/my.cnf in the [mysqld] section

      log   = /path/to/query.log  #works for mysql < 5.1.29
      Also, to enable it from MySQL console

      SET general_log = 1;


With mysql 5.1.29+

      The log option is deprecated. To specify the logfile and enable logging, use this in my.cnf in the [mysqld] section:

      general_log_file = /path/to/query.log
      general_log      = 1
      Alternately, to turn on logging from MySQL console (must also specify log file location somehow, or find the default location):

      SET global general_log = 1;