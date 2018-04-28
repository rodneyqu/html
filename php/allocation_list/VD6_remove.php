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
//** get the records count of VariantDesc


foreach ($ID as $value){          #a group of IDs need to be deleted
	if ($database=='VariantDesc'){
		$query="UPDATE VariantDesc SET Status=1 WHERE VariantDescID=\"$value\"";
		$mysql_link->query($query);
	}elseif($database=='GeneIntro'){
		$query="UPDATE GeneIntro SET Status=1 WHERE GeneIntroID=\"$value\"";
		$mysql_link->query($query);
	}elseif($database=='Therapy_Test'){
		$query="UPDATE TherapyEfficacy SET Status=1 WHERE TherapyID=\"$value\"";
		$mysql_link->query($query);
	}
}
?>
