<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$report=$_POST['report'];
$file_name=$_POST['file_name'];
$report_title=$_POST['report_title'];

$_SESSION['report']=$report;
$_SESSION['file_name']=$file_name;
$_SESSION['report_title']=$report_title;
?>

