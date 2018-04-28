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

//** Database_Connect.php, connected to the mysql database//
include(__DIR__ . '/Database_Connect.php');

//** get the records count of VariantDesc
$n=0;
$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.CreateDate,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status,VariantDesc.TranslationDate FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID";
$result = $mysql_link->query($variantdesc_query);
while($row = $result->fetch_assoc()) {
    $n++;
}

//** Query VariantDesc tables
$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID WHERE Status=2";    #status 2 means this record is going to be allocated
$result = $mysql_link->query($variantdesc_query);
$variantdesc_array = array();
while($row = $result->fetch_assoc()) {
    $arr['VariantDesc_en'] = $row['VariantDesc_en'];
    $arr['ID']=$row['VariantDescID'];
    $arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
    $arr['Database'] = 'VariantDesc';
    $arr['Count'] = $row['Count'];
    $arr['Status'] = $row['Status'];
    array_push($variantdesc_array, $arr);
}

//** Query GeneIntro tables
$variantdesc_query1="SELECT GeneIntro.GeneIntr_en,GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.Status FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID WHERE Status=2";
$result1  = $mysql_link->query($variantdesc_query1);
while($row = $result1->fetch_assoc()) {
    $arr['VariantDesc_en'] = $row['GeneIntr_en'];
    $arr['ID']=$n+$row['GeneIntroID'];
    $arr['KeyWord'] = $row['Symbol'];
    $arr['Database'] = 'GeneIntro';
    $arr['Count'] = $row['Count'];
    $arr['Status'] = $row['Status'];
    array_push($variantdesc_array, $arr);
}

echo json_encode($variantdesc_array);
?>
