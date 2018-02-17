<?php
session_start();

if(isset($_SESSION['Office']))
	echo json_encode('TRUE');
else
	echo json_encode('FALSE');
?>