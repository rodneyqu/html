<?php
//********************************************************************************************// 
// Filename: 
// Author: Xiang Zuo
// Version: 1.0
// Create Date: 2018/02/07
// Function: 
// Input files: 
// Output: 
//********************************************************************************************// 

//** Database_Connect.php, connected to the mysql database//
include(__DIR__ . '/Database_Connect.php');

header('Content-Type: text/html; charset=UTF-8');
$keyword=$_POST['KeyWord'];
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
$variantdesc_array = array();
if($database=='VariantDesc'){
	if (preg_match("/^p\./",$keyword)){          //search by HGVSp
		$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID WHERE Variant.HGVSp=\"$keyword\" AND Status=2"; 
	}elseif(empty($keyword)){                                             //search by gene symbol
		$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID WHERE Status=2";
	}elseif(preg_match("/^[\w\d]+$/",$keyword)){
		$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID WHERE Gene.Symbol=\"$keyword\" AND Status=2";
	}
	$result = $mysql_link->query($variantdesc_query);
        while($row = $result->fetch_assoc()) {
                $arr['VariantDesc_en'] = $row['VariantDesc_en'];
                $arr['ID'] = $row['VariantDescID'];
                $arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
                $arr['Database']='VariantDesc';
                $arr['Count'] = $row['Count'];
                $arr['Status'] = $row['Status'];
                array_push($variantdesc_array, $arr);
        }
}elseif($database=='GeneIntro'){          #select database GeneIntro
	if(empty($keyword)){
		$variantdesc_query="SELECT GeneIntro.GeneIntr_en,GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.Status FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID WHERE Status=2";
	}elseif(preg_match("/^[\w\d]+$/",$keyword)){
		$variantdesc_query="SELECT GeneIntro.GeneIntr_en,GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.Status FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID WHERE Gene.Symbol=\"$keyword\" AND Status=2";
	}
	$result = $mysql_link->query($variantdesc_query);
        while($row = $result->fetch_assoc()) {
                $arr['VariantDesc_en'] = $row['GeneIntr_en'];
                $arr['ID'] = $row['GeneIntroID'];
                $arr['KeyWord'] = $row['Symbol'];
                $arr['Database']='GeneIntro';
                $arr['Count'] = $row['Count'];
                $arr['Status'] = $row['Status'];
                array_push($variantdesc_array, $arr);
        }
}elseif($database=='Therapy_Test'){
	if($keyword){
	   $variantdesc_query="SELECT TherapyEfficacy_en,TherapyID,Keyword,Count,Status FROM TherapyEfficacy WHERE keyword=\"$keyword\" AND Status=2";
	}else{
        $variantdesc_query="SELECT TherapyEfficacy_en,TherapyID,Keyword,Count,Status FROM TherapyEfficacy WHERE Status=2";
    }
	$result = $mysql_link->query($variantdesc_query);
	while($row = $result->fetch_assoc()) {
            	$arr['VariantDesc_en'] = $row['TherapyEfficacy_en'];
                $arr['ID'] = $row['TherapyID'];
    	        $arr['KeyWord'] = $row['Keyword'];
            	$arr['Database']='Therapy_Test';
                $arr['Count'] = $row['Count'];
    	        $arr['Status'] = $row['Status'];
            	array_push($variantdesc_array, $arr);
	}
	
}

echo json_encode($variantdesc_array);
?>
