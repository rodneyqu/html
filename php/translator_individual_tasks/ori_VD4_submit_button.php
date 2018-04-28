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
//$RecordID=$_POST['RecordID'];
$Translation=$_POST['Translation'];
//$TranslatorID=$_POST['TranslatorID'];
$TranslationDate=$_POST['TranslationDate'];

if($ID<=1283){
	$query="UPDATE VariantDesc SET Status=4,Count=Count+1,VariantDesc_cn=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE VariantDescID=\"$ID\";";
//$query.="UPDATE VariantDescRecords SET TranslationResults=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE VariantDescID=\"$ID\"";
	$query.="UPDATE VariantDescRecords SET TranslationResults=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE VariantDescRecordsID IN (SELECT t.VariantDescRecordsID FROM (SELECT VariantDescRecordsID FROM VariantDescRecords WHERE VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC LIMIT 1)AS t)";
}else{
	$query="UPDATE GeneIntro SET Status=4,Count=Count+1,VariantDesc_cn=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE GeneIntroID=\"$ID\"-1283;";
	$query.="UPDATE GeneIntroRecords ET TranslationResults=\"$Translation\",TranslationDate=\"$TranslationDate\" WHERE GeneIntroRecordsID IN (SELECT t.GeneIntroRecordsID FROM (SELECT GeneIntroRecordsID FROM GeneIntroRecords WHERE GeneIntroID=\"$ID\"-1283 ORDER BY GeneIntroRecordsID DESC LIMIT 1)AS t)";
}
$mysql_link->multi_query($query);
?>
