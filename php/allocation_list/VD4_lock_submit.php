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
$ApproveDate=date('Y-m-d',strtotime($_POST['ApproveDate']));           //allocation date

$TranslationDate=date('Y-m-d',strtotime($_POST['TranslationDate']));
$ReviewerID=$_POST['ReviewerID'];
$ReviewDate=$_POST['ReviewDate'];
$database=$_POST['Database'];
//** get the records count of VariantDesc


if($database=='VariantDesc'){
	$query1="UPDATE VariantDesc SET Status=0,VariantDesc_cn=\"$Translation\",Count=Count+1,TranslatorID=\"$TranslatorID\",ReviewerID=\"$ReviewerID\",AllocationDate=\"$ApproveDate\",TranslationDate=\"$TranslationDate\",ReviewDate=\"$ReviewDate\",Priority=\"$Priority\" WHERE VariantDescID=\"$ID\";";
	$query2="INSERT INTO VariantDescRecords (VariantDescID,Priority,TranslationResults,TranslatorID,TranslationDate,ReviewerID,ReviewDate,AllocationDate) VALUES (\"$ID\",\"$Priority\",\"$Translation\",\"$TranslatorID\",\"$TranslationDate\",\"$ReviewerID\",\"$ReviewDate\",\"$ApproveDate\")";
}
if($database=='GeneIntro'){
        $query1="UPDATE GeneIntro SET Status=0,GeneIntr_cn=\"$Translation\",Count=Count+1,TranslatorID=\"$TranslatorID\",ReviewerID=\"$ReviewerID\",AllocationDate=\"$ApproveDate\",TranslationDate=\"$TranslationDate\",ReviewDate=\"$ReviewDate\",Priority=\"$Priority\" WHERE GeneIntroID=\"$ID\";";
        $query2="INSERT INTO GeneIntroRecords (GeneIntroID,Priority,TranslationResults,TranslatorID,TranslationDate,ReviewerID,ReviewDate,AllocationDate) VALUES (\"$ID\",\"$Priority\",\"$Translation\",\"$TranslatorID\",\"$TranslationDate\",\"$ReviewerID\",\"$ReviewDate\",\"$ApproveDate\")";
}

if($database=='Therapy_Test'){
	$query1="UPDATE TherapyEfficacy SET Status=0,TherapyEfficacy_cn=\"$Translation\",Count=Count+1,TranslatorID=\"$TranslatorID\",ReviewerID=\"$ReviewerID\",AllocationDate=\"$ApproveDate\",TranslationDate=\"$TranslationDate\",ReviewDate=\"$ReviewDate\",Priority=\"$Priority\" WHERE TherapyID=\"$ID\"";
	
	$query2="INSERT INTO TherapyEfficacyRecord (TherapyID,Priority,TranslationResults,TranslatorID,TranslationDate,ReviewerID,ReviewDate,AllocationDate) VALUES (\"$ID\",\"$Priority\",\"$Translation\",\"$TranslatorID\",\"$TranslationDate\",\"$ReviewerID\",\"$ReviewDate\",\"$ApproveDate\")";


}
$mysql_link->query($query1);
$mysql_link->query($query2);
?>
