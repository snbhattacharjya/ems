<?PHP
session_start();

require_once("../config/config.php");

$password=$_POST['Password'];
$newpassword=hash('sha256',$_POST['NewPassword']);	

$userid=$_SESSION['UserID'];

$check_password_query=mysql_query("SELECT Password,ChangePassword FROM users WHERE UserID='$userid'");
$data=mysql_fetch_array($check_password_query);

?>

<div class="text-center">
    <h3>
<?php
if($data['ChangePassword']==0)
{
	$pswd=$data['Password'];
	$password=hash('sha256',trim($password));
}
else
{
	$pswd=$data['Password'];	
}
if($pswd==$password)
{
$query_submit=mysql_query("UPDATE users SET Password='$newpassword',ChangePassword=0,ModifiedDate=now() WHERE UserID='$userid'");

echo "Password Successfully Changed.";
}
else
{
	echo "Please Provide Your Current Password Correctly...";
}
?>
</h3>
</div>