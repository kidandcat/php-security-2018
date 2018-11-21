<?php

$buscar_html_raw = $_GET['buscar'];

$buscar_html = filter_var($buscar_html_raw, FILTER_SANITIZE_SPECIAL_CHARS);


# - - - - - -


$buscar_html = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_SPECIAL_CHARS);