<?php
session_start();

$pizza  = "piece1,piece2,piece3,piece4,piece5,piece6";
$pieces = explode(",", $pizza);
echo $pieces[3]; // piece1
echo $pieces[4]; // piece2
?>