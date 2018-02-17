<?php
require("../config/config.php");

$bank_query=$mysqli->prepare("SELECT bank_name FROM bank_new") or die($mysqli->error);
$bank_query->execute();
$bank_query->bind_result($bank_name);

$count=1;
while($bank_query->fetch())
{
	$bank_code='13'.str_pad($count,3,'0',STR_PAD_LEFT);
	$update_query=$mysqli1->prepare("UPDATE bank_new SET bank_cd=? WHERE bank_name=?") or die($mysqli1->error);
	$update_query->bind_param("ss",$bank_code,$bank_name) or die($update_query->error);
	$update_query->execute() or die($update_query->error);
	$update_query->close();
	
	$count=$count+1;
}

$bank_query->close();

echo "Bank Records : $count Updated Successfully...";

/*

$bank_query=$mysqli->prepare("SELECT bank_cd,bank_name FROM bank") or die($mysqli->error);
$bank_query->execute();
$bank_query->bind_result($bank_cd,$bank_name);
?>
<table cellpadding="5" cellspacing="0" border="2">
<tr><th>Bank Code</th><th>Bank Name</th></tr>
<?php
while($bank_query->fetch())
{
?>
<tr>
<td>
<?php echo $bank_cd;?>
</td>
<td>
<?php echo $bank_name;?>
</td>
</tr>
<?php
}
$bank_query->close();*/
?>