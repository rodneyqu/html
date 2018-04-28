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
$reviewerID=$_POST['CuratorID'];

//** get the records count of VariantDesc
$n=0;
$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.CreateDate,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status,VariantDesc.TranslationDate FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID";
$result = $mysql_link->query($variantdesc_query);
while($row = $result->fetch_assoc()) {
    $n++;
}

$variantdesc_query="SELECT VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Status,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.TranslatorID=Employee.EmployeeID WHERE (VariantDesc.Status=3 OR VariantDesc.Status=4) AND ReviewerID=\"$reviewerID\"";
$result = $mysql_link->query($variantdesc_query);
$variantdesc_array = array();
while($row = $result->fetch_assoc()) {
    $arr['ID'] = $row['VariantDescID'];
    $arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
    $arr['Database'] = 'VariantDesc';
    $arr['Count'] = $row['Count'];
    $arr['TranslationDate'] = $row['TranslationDate'];
    $arr['Translator'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
    $arr['Status'] = $row['Status'];
    $arr['Priority'] = $row['Priority'];
    array_push($variantdesc_array, $arr);
}

$variantdesc_query1="SELECT GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.Status,GeneIntro.Priority FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee ON GeneIntro.TranslatorID=Employee.EmployeeID WHERE (GeneIntro.Status=3 OR GeneIntro.Status=4) AND ReviewerID=\"$reviewerID\"";
$result1 = $mysql_link->query($variantdesc_query1);
while($row = $result1->fetch_assoc()) {
    $arr['ID'] = $n+$row['GeneIntroID'];  
    $arr['KeyWord'] = $row['Symbol'];
    $arr['Database']='GeneIntro';
    $arr['Count'] = $row['Count'];
    $arr['TranslationDate'] = $row['TranslationDate'];
    $arr['Translator'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
    $arr['Status'] = $row['Status'];
    $arr['Priority'] = $row['Priority'];
    array_push($variantdesc_array, $arr);
}

echo json_encode($variantdesc_array);
?>
