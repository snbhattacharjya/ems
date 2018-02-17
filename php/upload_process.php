<?php
include "../config/config.php";
if ($_FILES["upload_file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["upload_file"]["error"] . "<br>";
  }
else
  {
  //echo "Upload: " . $_FILES["upload_file"]["name"] . "<br>";
  //echo "Type: " . $_FILES["upload_file"]["type"] . "<br>";
  //echo "Size: " . ($_FILES["upload_file"]["size"] / 1024) . " kB<br>";
  //echo "Stored in: " . $_FILES["upload_file"]["tmp_name"]."<br>";
  	$extension=explode(".",$_FILES["upload_file"]["name"]);
	$extention=end($extension);
/*
	$max_photo_id=mysql_query("SELECT MAX(photo_id) AS max_photo_id FROM file_upload")or die("Query Error");
	$max_photo_id=mysql_fetch_array($max_photo_id)or die("Fecth Error");
	if(empty($max_photo_id['max_photo_id']))
		$max_photo_id=1;
	else
		$max_photo_id=$max_photo_id['max_photo_id']+1; 
		*/
  	move_uploaded_file($_FILES["upload_file"]["tmp_name"],
      "uploads/"."_img.".$extention);
	 /* mysql_query("INSERT INTO file_upload (photo_id,file_path) VALUES($max_photo_id, 'uploads/" . $max_photo_id."_img.".$extention."')") or die("INSERT Query Error: ".mysql_error());*/
      //echo "Stored in: " . "uploads/" . $max_photo_id."_img.".$extention;
	  echo "<img src='uploads/"."_img.".$extention."'></img>";
  }
    //echo "Hello ". $_POST['wife']." Your Husband ".$_POST['husband']." loves you a lot.";
  //echo '<div style="background-color:#ffa; padding:20px">' . $_POST['message'] . '</div>';
?> 