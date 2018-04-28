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

if($ID<=1283){
	foreach ($ID as $value){
		$query="UPDATE VariantDesc SET Status=1 WHERE VariantDescID=\"$value\"";
		$mysql_link->query($query);
	}
}else{
	foreach ($ID as $value){
                $query="UPDATE GeneIntro SET Status=1 WHERE GeneIntroID=\"$value\"-1283";
                $mysql_link->query($query);
        }
}
?>
