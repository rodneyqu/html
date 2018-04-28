<?php
//********************************************************************************************// 
// Filename: 
// Author: Xiang Zuo
// Version: 1.0
// Create Date: 2018/02/06
// Function: 
// Input files: 
// Output: 
//********************************************************************************************// 

include(__DIR__ . '/Database_Connect.php');

header('Content-Type: text/html; charset=UTF-8');
$ID=$_POST['ID'];
$database=$_POST['Database'];


if($database=='VariantDesc'){
	$query="UPDATE VariantDesc SET Status=3 WHERE VariantDescID=\"$ID\"";
}
if($database=='GeneIntro'){
	$query="UPDATE GeneIntro SET Status=3 WHERE GeneIntroID=\"$ID\"";
}
if($database=='Therapy_Test'){
	$query="UPDATE TherapyEfficacy SET Status=3 WHERE TherapyID=\"$ID\"";
}
$mysql_link->query($query);
?>
