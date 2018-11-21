# CSRF Token

Nuevo token generado en cada llamada. Asi evitamos multiples envíos del mismo formulario.

```php
<form action="/post.php" method="POST">
    <input type="text" name="name" id="name">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"] ?>">
    <input type="submit" value="submit">
</form>
```


# Idempotencia

https://stackoverflow.com/a/45019073/4158710