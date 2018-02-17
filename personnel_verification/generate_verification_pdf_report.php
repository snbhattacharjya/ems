<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$report=$_POST['report'];
$file_name=$_POST['file_name'];

$_SESSION['report']=$report;
$_SESSION['file_name']=$file_name;
$_SESSION['report_title']='Verification List for Office - '.$file_name;
?>

