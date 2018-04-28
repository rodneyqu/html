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
$ReviewDate=date('Y-m-d',strtotime($_POST['ReviewDate']));
$VariantDesc_cn=$_POST['VariantDesc_cn'];
$database=$_POST['Database'];

if($database=='VariantDesc'){
	$query="UPDATE VariantDesc SET Status=1,ReviewDate=\"$ReviewDate\",VariantDesc_cn=\"$VariantDesc_cn\" WHERE VariantDescID=\"$ID\";";
	$mysql_link->query($query);
	$query ="UPDATE VariantDescRecords SET ReviewDate=\"$ReviewDate\",TranslationResults=\"$VariantDesc_cn\" WHERE VariantDescRecordsID IN (SELECT t.VariantDescRecordsID FROM (SELECT VariantDescRecordsID FROM VariantDescRecords WHERE VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC LIMIT 1)AS t)";
	$mysql_link->query($query);
}
if($database=='GeneIntro'){
	$query="UPDATE GeneIntro SET Status=1,ReviewDate=\"$ReviewDate\",GeneIntr_cn=\"$VariantDesc_cn\" WHERE GeneIntroID=\"$ID\"";
	$mysql_link->query($query);
	$query="UPDATE GeneIntroRecords SET ReviewDate=\"$ReviewDate\",TranslationResults=\"$VariantDesc_cn\" WHERE GeneIntroRecordsID IN (SELECT t.GeneIntroRecordsID FROM (SELECT GeneIntroRecordsID FROM GeneIntroRecords WHERE GeneIntroID=\"$ID\" ORDER BY GeneIntroRecordsID DESC LIMIT 1)AS t)";
	$mysql_link->query($query);
}
if($database=='Therapy_Test'){
	$query="UPDATE TherapyEfficacy SET Status=1,ReviewDate=\"$ReviewDate\",TherapyEfficacy_cn=\"$VariantDesc_cn\" WHERE TherapyID=\"$ID\"";
	$mysql_link->query($query);
	$query="UPDATE TherapyEfficacyRecord SET ReviewDate=\"$ReviewDate\",TranslationResults=\"$VariantDesc_cn\" WHERE TherapyEfficacyID IN (SELECT t.TherapyEfficacyID FROM (SELECT TherapyEfficacyID FROM TherapyEfficacyRecord WHERE TherapyID=\"$ID\" ORDER BY TherapyEfficacyID DESC LIMIT 1)AS t)";
	$mysql_link->query($query);
}

//$mysql_link->multi_query($query);
?>
