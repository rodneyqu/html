<?php
//********************************************************************************************// 
// Filename: VD22.php
// Author: Xiang Zuo
// Version: 1.0
// Create Date: 2018/02/05
// Function: 
// Input files: 
// Output: 
//********************************************************************************************// 

include(__DIR__ . '/Database_Connect.php');

header('Content-Type: text/html; charset=UTF-8');
$ID=$_POST['ID'];

if($ID<=1283){
	$query="UPDATE VariantDesc SET Status=1 WHERE VariantDescID=\"$ID\" AND Status=0;";
	$query.="UPDATE VariantDesc SET Status=2 WHERE VariantDescID=\"$ID\" AND Status=1"; 
}else{
	$query="UPDATE GeneIntro SET Status=1 WHERE GeneIntroID=\"$ID\"-1283 AND Status=0;";
	$query.="UPDATE GeneIntro SET Status=2 WHERE GeneIntroID=\"$ID\"-1283 AND Status=1";
}

$mysql_link->multi_query($query);
?>
