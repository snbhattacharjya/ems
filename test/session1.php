<?php
session_start();

$_SESSION['session_time']=time();

echo "Session Started";
echo session_id();

echo "<p>".$_SERVER['REMOTE_ADDR']."</p>";

?>