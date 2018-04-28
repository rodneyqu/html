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
$ApproveDate=date('Y-m-d',strtotime($_POST['ApproveDate']));
$TranslatorID=$_POST['TranslatorID'];
$ReviewerID=$_POST['ReviewerID'];
$database=$_POST['Database'];

//** get the records count of VariantDesc
/*
$n=0;
$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.CreateDate,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status,VariantDesc.TranslationDate FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID";
$result = $mysql_link->query($variantdesc_query);
while($row = $result->fetch_assoc()) {
    $n++;
}

*/
foreach($ID as $key=>$value){
	updateOperation($value,$Priority,$ApproveDate,$TranslatorID,$ReviewerID,$database);
}
function updateOperation($ID,$Priority,$ApproveDate,$TranslatorID,$ReviewerID,$database){
	global $mysql_link;
	if($database=='VariantDesc'){
	
		$query1="UPDATE VariantDesc SET Status=3,Count=Count+1,TranslatorID=\"$TranslatorID\",ReviewerID=\"$ReviewerID\",AllocationDate=\"$ApproveDate\",Priority=\"$Priority\" WHERE VariantDescID=\"$ID\";";
		$query2="INSERT INTO VariantDescRecords (VariantDescID,Priority,TranslatorID,ReviewerID,AllocationDate) VALUES (\"$ID\",\"$Priority\",\"$TranslatorID\",\"$ReviewerID\",\"$ApproveDate\")"; 
	}elseif($database=='GeneIntro'){
	
	
		$query1="UPDATE GeneIntro SET Status=3,Count=Count+1,TranslatorID=\"$TranslatorID\",ReviewerID=\"$ReviewerID\",AllocationDate=\"$ApproveDate\",Priority=\"$Priority\" WHERE GeneIntroID=\"$ID\";";
		$query2="INSERT INTO GeneIntroRecords (GeneIntroID,Priority,TranslatorID,ReviewerID,AllocationDate) VALUES (\"$ID\",\"$Priority\",\"$TranslatorID\",\"$ReviewerID\",\"$ApproveDate\")";
	}elseif($database=='Therapy_Test'){
		$query1="UPDATE TherapyEfficacy SET Status=3,Count=Count+1,TranslatorID=\"$TranslatorID\",ReviewerID=\"$ReviewerID\",AllocationDate=\"$ApproveDate\",Priority=\"$Priority\" WHERE TherapyID=\"$ID\";";
		$query2="INSERT INTO TherapyEfficacyRecord (TherapyID,Priority,TranslatorID,ReviewerID,AllocationDate) VALUES (\"$ID\",\"$Priority\",\"$TranslatorID\",\"$ReviewerID\",\"$ApproveDate\")";
	}

	$test=$mysql_link->query($query1);
	$test2=$mysql_link->query($query2);

	//$mysql_link->multi_query($query);

}
?>

