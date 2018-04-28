<?php
//********************************************************************************************// 
// Filename: 
// Author: Xiang Zuo
// Version: 1.0
// Create Date: 2018/02/08
// Function: 
// Input files: 
// Output: 
//********************************************************************************************// 

include(__DIR__ . '/Database_Connect.php');

header('Content-Type: text/html; charset=UTF-8');
$ID=$_POST['ID'];
$Translation=$_POST['Translation'];
$TranslationDate=date('Y-m-d',strtotime($_POST['TranslationDate']));
$database=$_POST['Database'];
//** get the records count of VariantDesc


if($database=='VariantDesc'){

	$query1="UPDATE VariantDesc SET Status=4,VariantDesc_cn=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE VariantDescID=\"$ID\";";
	$query2="UPDATE VariantDescRecords SET TranslationResults=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE VariantDescRecordsID IN (SELECT t.VariantDescRecordsID FROM (SELECT VariantDescRecordsID FROM VariantDescRecords WHERE VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC LIMIT 1)AS t)";
}
if($database=='GeneIntro'){
	$query1="UPDATE GeneIntro SET Status=4,GeneIntr_cn=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE GeneIntroID=\"$ID\";";
	$query2="UPDATE GeneIntroRecords SET TranslationResults=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE GeneIntroRecordsID IN (SELECT t.GeneIntroRecordsID FROM (SELECT GeneIntroRecordsID FROM GeneIntroRecords WHERE GeneIntroID=\"$ID\" ORDER BY GeneIntroRecordsID DESC LIMIT 1)AS t)";
}

if($database=='Therapy_Test'){
	$query1="UPDATE TherapyEfficacy SET Status=4,TherapyEfficacy_cn=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE TherapyID=\"$ID\";";
	$query2="UPDATE TherapyEfficacyRecord SET TranslationResults=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE TherapyEfficacyID IN (SELECT t.TherapyEfficacyID FROM (SELECT TherapyEfficacyID FROM TherapyEfficacyRecord WHERE TherapyID=\"$ID\" ORDER BY TherapyEfficacyID DESC LIMIT 1)AS t)";
}

$mysql_link->query($query1);
$mysql_link->query($query2);
?>
