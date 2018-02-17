<?php
session_start();

if(isset($_SESSION['Subdiv']))
	echo json_encode('TRUE');
else
	echo json_encode('FALSE');
?>