<?php
error_reporting(0);
session_start();

include("../mpdf/mpdf.php");
//include('../includes/pagecontrol.php');
	//ini_set("memory_limit", "512M");
//print readfile('http://wbkanyashree.gov.in/includes/kp_image_display.php?type=photo&applicant_id=46.54.46.46.45.49.46.49.46.45.48.46.48.45.45.45.45.45.49.47.101');
 $temps2=($_SESSION['content']);
// $temps2=file_get_contents('../readwrite/icps_monitoring/'.$_SESSION['locationkey'].'_'.$_SESSION['stake_cd'].'.txt');
/*'c','A4','','',8,8,8,8,8,8*/
$htmlpdf=new mPDF('','A4','7',''); 


//$htmlpdf->SetAutoFont(AUTOFONT_ALL);
//$htmlpdf ->SetWatermarkText(" TrackChild 1.6",0.09);
//$htmlpdf ->showWatermarkText = true;
//$htmlpdf->SetDisplayMode('fullpage');

//$htmlpdf->SetHTMLHeader($header);
//$htmlpdf->SetTopMargin('30%');
//$htmlpdf->list_indent_first_level = 0;
	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
//$stylesheet = file_get_contents('../readwrite/reports_temp/css_'.session_id().'.css');
//$stylesheet = file_get_contents('./css/id_css.css');
//$htmlpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
//$htmlpdf->SetHTMLFooter($footer);
$htmlpdf->WriteHTML($temps2,2);
//unlink('./upload_pic/id_card/'.$_REQUEST['applicant_id'].'.jpg');
$htmlpdf->Output($_SESSION['file_name'].'.pdf','D');
unset($_SESSION['content']);
unset($_SESSION['file_name']);
exit;
?>