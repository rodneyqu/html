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
$ReviewDate=$_POST['ReviewDate'];
$VariantDesc_cn=$_POST['VariantDesc_cn'];

if($ID<=1283){
	$query="UPDATE VariantDesc SET Status=0,ReviewDate=\"$ReviewDate\",VariantDesc_cn=\"$VariantDesc_cn\" WHERE VariantDescID=\"$ID\";";
	$query.="UPDATE VariantDescRecords SET ReviewDate=\"$ReviewDate\",TranslationResults=\"$VariantDesc_cn\" WHERE VariantDescRecordsID IN (SELECT t.VariantDescRecordsID FROM (SELECT VariantDescRecordsID FROM VariantDescRecords WHERE VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC LIMIT 1)AS t)";
}else{
	$query="UPDATE GeneIntro SET Status=0,ReviewDate=\"$ReviewDate\",VariantDesc_cn=\"$VariantDesc_cn\" WHERE GeneIntroID=\"$ID\"-1283;";
	$query.="UPDATE GeneIntroRecords SET ReviewDate=\"$ReviewDate\",TranslationResults=\"$VariantDesc_cn\" WHERE GeneIntroRecordsID IN (SELECT t.GeneIntroRecordsID FROM (SELECT GeneIntroRecordsID FROM GeneIntroRecords WHERE GeneIntroID=\"$ID\"-1283 ORDER BY GeneIntroRecordsID DESC LIMIT 1)AS t)";
}
$mysql_link->multi_query($query);
?>
