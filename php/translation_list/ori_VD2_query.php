<?php
//********************************************************************************************// 
// Filename: VD19.php
// Author: Xiang Zuo
// Version: 1.0
// Create Date: 2018/02/02
// Function: Search by a key word, there are 3 ways, by item number,pdot information or gene symbol
// Input files: Database_Connect.php
// Output: Get the browse list of Variant Description database
//********************************************************************************************// 

//** Database_Connect.php, connected to the mysql database//
include(__DIR__ . '/Database_Connect.php');

header('Content-Type: text/html; charset=UTF-8');
$keyword=$_POST['KeyWord'];
//$database=$_POST['Database'];

if (preg_match("/^p\./",$keyword)){          //search by HGVSp
	$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.CreateDate,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID WHERE Variant.HGVSp=\"$keyword\"";
}else{                                             //search by gene symbol
	$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.CreateDate,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID WHERE Gene.Symbol=\"$keyword\"";
}

$variantdesc_query1="SELECT GeneIntro.GeneIntr_en,GeneIntro.CreateDate,GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.Status FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID WHERE Gene.Symbol=\"$keyword\"";

//** Query VariantDesc tables;
$result = $mysql_link->query($variantdesc_query);
$variantdesc_array = array();
while($row = $result->fetch_assoc()) {
    $arr['VariantDesc_en'] = $row['VariantDesc_en'];
    $arr['CreateDate'] = $row['CreateDate'];
    $arr['ID'] = $row['VariantDescID'];
    $arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
    $arr['Database']='VariantDesc';
    $arr['Count'] = $row['Count'];
    $arr['Status'] = $row['Status'];
    array_push($variantdesc_array, $arr);
}

$result1 = $mysql_link->query($variantdesc_query1);
while($row = $result1->fetch_assoc()) {
    $arr['VariantDesc_en'] = $row['GeneIntr_en'];
    $arr['CreateDate'] = $row['CreateDate'];
    $arr['ID'] = 1283+$row['GeneIntroID'];
    $arr['KeyWord'] = $row['Symbol'];
    $arr['Database']='GeneIntro';
    $arr['Count'] = $row['Count'];
    $arr['Status'] = $row['Status'];
    array_push($variantdesc_array, $arr);
}

echo json_encode($variantdesc_array);
?>
