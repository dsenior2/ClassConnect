<?php
/*
handles routing between pages:
    home  -> group
    home  -> class
    class -> group
    class -> home
    group -> home
    *     -> email
    email -> *
*/

$url = $_POST['url'];
header('Location: '.$url);
die();
?>