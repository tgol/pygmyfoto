<?php

$id = $_GET['id'];

$db = new PDO('sqlite:pygmyfoto.sqlite');
$db->query("UPDATE photos SET published = '1' WHERE id='$id'");
$db = NULL;

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'archive.php';
header("Location: http://$host$uri/$extra");
exit;

?>