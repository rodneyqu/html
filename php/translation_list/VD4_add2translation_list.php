<?php
//********************************************************************************************// 
// Filename: VD22.php
// Author: Xiang Zuo
// Version: 1.0
// Create Date: 2018/02/05
// Function: 
// Input files: 
// Output: 
//********************************************************************************************// 

include(__DIR__ . '/Database_Connect.php');

header('Content-Type: text/html; charset=UTF-8');
$ID=$_POST['ID'];
$status=$_POST['Status'];
$Database=$_POST['Database'];
//** get the records count of VariantDesc
/*
$n=0;
$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.CreateDate,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status,VariantDesc.TranslationDate FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID";
$result = $mysql_link->query($variantdesc_query);
while($row = $result->fetch_assoc()) {
    $n++;
}
*/
/*
if($ID<=$n){
	$query="UPDATE VariantDesc SET Status=1 WHERE VariantDescID=\"$ID\" AND Status=0;";

//	$query.="UPDATE VariantDesc SET Status=2 WHERE VariantDescID=\"$ID\" AND Status=1"; 
}else{
	$query="UPDATE GeneIntro SET Status=1 WHERE GeneIntroID=\"$ID\"-$n AND Status=0;";
//	$query.="UPDATE GeneIntro SET Status=2 WHERE GeneIntroID=\"$ID\"-$n AND Status=1";
}
*/
if(count($ID)>0){
	foreach($ID as $key=>$value){
		addTranslationList($value,$status[$key],$Database[$key]);
	}
}
if(count($ID)==1){
	addTranslationList($ID,$status,$Database);
}

function addTranslationList($ID,$status,$Database){

	global $mysql_link;
	if($status=='0'){
		if($Database=='VariantDesc'){
			$query="UPDATE VariantDesc SET Status=1 WHERE VariantDescID=\"$ID\" AND Status=0";
		}elseif($Database=='GeneIntro'){
			$query="UPDATE GeneIntro SET Status=1 WHERE GeneIntroID=\"$ID\" AND Status=0";
		}elseif($Database=='Therapy_Test'){
			$query="UPDATE TherapyEfficacy SET Status=1 WHERE TherapyID=\"$ID\" AND Status=0";
		}else{
			return false;
		}
	}
	if($status=='1'){
		if($Database=='VariantDesc'){
			$query="UPDATE VariantDesc SET Status=2 WHERE VariantDescID=\"$ID\" AND Status=1";
		}elseif($Database=='GeneIntro'){
			$query="UPDATE GeneIntro SET Status=2 WHERE GeneIntroID=\"$ID\" AND Status=1";
		}elseif($Database=='Therapy_Test'){
			$query="UPDATE TherapyEfficacy SET Status=2 WHERE TherapyID=\"$ID\" AND Status=1";
		}else{
			return false;
		}
	}
	$mysql_link->query($query);
}
#$mysql_link->multi_query($query);
?>

