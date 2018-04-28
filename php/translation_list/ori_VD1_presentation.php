<?php
//********************************************************************************************// 
// Filename: VariantDesc.php
// Author: Weixing Ye PhD
// Version: 1.0
// Create Date: 2018/01/30
// Function: This script connect to the local mysql database
// Input files: Database_Connect.php
// Output: Get the browse list of Variant Description database
//********************************************************************************************// 

//** Database_Connect.php, connected to the mysql database//
include(__DIR__ . '/Database_Connect.php');

//** Query VariantDesc tables;
#$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.CreateDate,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID";

$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.CreateDate,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName,VariantDesc.TranslationDate FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee as b ON VariantDesc.TranslatorID=b.EmployeeID JOIN Employee as c ON VariantDesc.ReviewerID=c.EmployeeID";

$variantdesc_query1="SELECT GeneIntro.GeneIntr_en,GeneIntro.CreateDate,GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.Status,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName,GeneIntro.TranslationDate FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee as b ON GeneIntro.TranslatorID=b.EmployeeID JOIN Employee as c ON GeneIntro.ReviewerID=c.EmployeeID";

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
    $arr['Translator'] = $row['TranslatorLastName'].$row['TranslatorMiddleName'].$row['TranslatorFirstName'];
    $arr['Reviewer'] = $row['ReviewerLastName'].$row['ReviewerMiddleName'].$row['ReviewerFirstName'];
    $arr['TranslationDate'] = $row['TranslationDate'];
    array_push($variantdesc_array, $arr);
}
$result1 = $mysql_link->query($variantdesc_query1);
while($row = $result1->fetch_assoc()) {
    $arr['VariantDesc_en'] = $row['GeneIntr_en'];
    $arr['CreateDate'] = $row['CreateDate'];
    $arr['ID'] = $row['GeneIntroID'] + 1283;
    $arr['KeyWord'] = $row['Symbol'];
    $arr['Database']='GeneIntro';
    $arr['Count'] = $row['Count'];
    $arr['Status'] = $row['Status'];
    $arr['Translator'] = $row['TranslatorLastName'].$row['TranslatorMiddleName'].$row['TranslatorFirstName'];
    $arr['Reviewer'] = $row['ReviewerLastName'].$row['ReviewerMiddleName'].$row['ReviewerFirstName'];
    $arr['TranslationDate'] = $row['TranslationDate'];
    array_push($variantdesc_array, $arr);
}
echo json_encode($variantdesc_array);
?>
