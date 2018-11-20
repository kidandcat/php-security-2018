<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/post.php" method="POST">
        <input type="text" name="name" id="name">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"] ?>">
        <input type="submit" value="submit">
    </form>
    <script>
        function ajax(){
            var result = fetch("/post.php");
        }

    </script>
</body>
</html>