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
//$ReviewDate=$_POST['ReviewDate'];

//$query="UPDATE VariantDesc SET Status=3,ReviewDate=\"$ReviewDate\" WHERE VariantDescID=\"$ID\"";
if($ID<=1283){
	$query="UPDATE VariantDesc SET Status=3 WHERE VariantDescID=\"$ID\"";
}else{
	$query="UPDATE GeneIntro SET Status=3 WHERE VariantDescID=\"$ID\"-1283";
}
$mysql_link->query($query);
?>
