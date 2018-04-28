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

$TranslatorID=$_POST['TranslatorID'];

//** Query VariantDesc tables;
//$variantdesc_query="SELECT VariantDesc.VariantDescID,VariantDesc.VariantDesc_en,VariantDesc.AllocationDate,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDescRecords.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.ReviewerID=Employee.EmployeeID JOIN VariantDescRecords ON VariantDesc.VariantDescID=VariantDescRecords.VariantDescID WHERE VariantDesc.TranslatorID=\"$TranslatorID\" AND Status=3 ORDER BY VariantDescRecordsID DESC limit 1";

$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.VariantDescID,VariantDesc.AllocationDate,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.ReviewerID=Employee.EmployeeID WHERE VariantDesc.TranslatorID=\"$TranslatorID\" AND VariantDesc.Status=3";
$variantdesc_query1="SELECT GeneIntro.GeneIntr_en,GeneIntro.GeneIntroID,GeneIntro.AllocationDate,Gene.Symbol,GeneIntro.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.Priority FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee ON GeneIntro.ReviewerID=Employee.EmployeeID WHERE GeneIntro.TranslatorID=\"$TranslatorID\" AND GeneIntro.Status=3";

$result = $mysql_link->query($variantdesc_query);
$variantdesc_array = array();
while($row = $result->fetch_assoc()) {
    $arr['VariantDesc_en'] = $row['VariantDesc_en'];
    $arr['ID']=$row['VariantDescID'];
    $arr['ApproveDate']=$row['AllocationDate'];
    $arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
    $arr['Database'] = 'VariantDesc';
    $arr['Count'] = $row['Count'];
//    $arr['Status'] = $row['Status'];
    $arr['Reviewer'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
    $arr['Priority'] = $row['Priority'];
    array_push($variantdesc_array, $arr);
}
$result1 = $mysql_link->query($variantdesc_query1);
while($row = $result1->fetch_assoc()) {
    $arr['VariantDesc_en'] = $row['GeneIntr_en'];
    $arr['ID']=$row['GeneIntroID'] + 1283;
    $arr['ApproveDate']=$row['AllocationDate'];
    $arr['KeyWord'] = $row['Symbol'];
    $arr['Database'] = 'GeneIntro';
    $arr['Count'] = $row['Count'];
    $arr['Reviewer'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
    $arr['Priority'] = $row['Priority'];
    array_push($variantdesc_array, $arr);
}
echo json_encode($variantdesc_array);
?>
