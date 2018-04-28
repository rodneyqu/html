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
$Priority=$_POST['Priority'];
$Translation=$_POST['Translation'];
$TranslatorID=$_POST['TranslatorID'];
$ApproveDate=$_POST['ApproveDate'];           //allocation date
$TranslationDate=$_POST['TranslationDate'];
$ReviewerID=$_POST['ReviewerID'];
$ReviewDate=$_POST['ReviewDate'];

if($ID<=1283){
	$query="UPDATE VariantDesc SET Status=1,VariantDesc_cn=\"$Translation\",Count=Count+1,TranslatorID=\"$TranslatorID\",ReviewerID=\"$ReviewerID\",AllocationDate=\"$ApproveDate\",TranslationDate=\"$TranslationDate\",ReviewDate=\"$ReviewDate\",Priority=\"$Priority\" WHERE VariantDescID=\"$ID\";";
	$query.="INSERT INTO VariantDescRecords (VariantDescID,Priority,TranslationResults,TranslatorID,TranslationDate,ReviewerID,ReviewDate,AllocationDate) VALUES (\"$ID\",\"$Priority\",\"$Translation\",\"$TranslatorID\",\"$TranslationDate\",\"$ReviewerID\",\"$ReviewDate\",\"$ApproveDate\")"; 
}else{
	$query="UPDATE GeneIntro SET Status=1,GeneIntr_cn=\"$Translation\",Count=Count+1,TranslatorID=\"$TranslatorID\",ReviewerID=\"$ReviewerID\",AllocationDate=\"$ApproveDate\",TranslationDate=\"$TranslationDate\",ReviewDate=\"$ReviewDate\",Priority=\"$Priority\" WHERE GeneIntroID=\"$ID\"-1283;";
	$query.="INSERT INTO GeneIntroRecords (GeneIntroID,Priority,TranslationResults,TranslatorID,TranslationDate,ReviewerID,ReviewDate,AllocationDate) VALUES (\"$ID\"-1283,\"$Priority\",\"$Translation\",\"$TranslatorID\",\"$TranslationDate\",\"$ReviewerID\",\"$ReviewDate\",\"$ApproveDate\")";
}
//echo $query;
$mysql_link->multi_query($query);
?>
