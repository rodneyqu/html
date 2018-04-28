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
#$keyword="p\.Glu255Val";
$TranslatorID=$_POST['TranslatorID'];
//$keyword='EGFR';
//$database=$_POST['Database'];
//$reviewer=$_POST['ReviewerID'];
//$reviewer=1;
//$priority=$_POST['Priority'];

if (preg_match("/^p\./",$keyword)){
//	$variantdesc_query="SELECT VariantDesc.VariantDescID,VariantDesc.VariantDesc_en,VariantDesc.AllocationDate,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDescRecords.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.ReviewerID=Employee.EmployeeID JOIN VariantDescRecords ON VariantDesc.VariantDescID=VariantDescRecords.VariantDescID WHERE Variant.HGVSp=\"$keyword\" AND VariantDesc.Status=3 ORDER BY VariantDescRecords.VariantDescRecordsID DESC limit 1";
	$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.VariantDescID,VariantDesc.AllocationDate,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.ReviewerID=Employee.EmployeeID WHERE VariantDesc.TranslatorID=\"$TranslatorID\" AND VariantDesc.Status=3 AND Variant.HGVSp=\"$keyword\"";
	$result = $mysql_link->query($variantdesc_query);
	$variantdesc_array = array();
	while($row = $result->fetch_assoc()) {
	    $arr['ID']=$row['VariantDescID'];
	    $arr['VariantDesc_en'] = $row['VariantDesc_en'];
	    $arr['ApproveDate']=$row['AllocationDate'];
	    $arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
	    $arr['Database'] = 'VariantDesc';
	    $arr['Count'] = $row['Count'];
//    $arr['Status'] = $row['Status'];
	    $arr['Reviewer'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
	    $arr['Priority'] = $row['Priority'];
	    array_push($variantdesc_array, $arr);
	}
}else{
//	$variantdesc_query="SELECT VariantDesc.VariantDescID,VariantDesc.VariantDesc_en,VariantDesc.AllocationDate,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDescRecords.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.ReviewerID=Employee.EmployeeID JOIN VariantDescRecords ON VariantDesc.VariantDescID=VariantDescRecords.VariantDescID WHERE Gene.Symbol=\"$keyword\" AND VariantDesc.Status=3 ORDER BY VariantDescRecords.VariantDescRecordsID DESC limit 1";
	$variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.VariantDescID,VariantDesc.AllocationDate,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.ReviewerID=Employee.EmployeeID WHERE VariantDesc.TranslatorID=\"$TranslatorID\" AND VariantDesc.Status=3 AND Gene.Symbol=\"$keyword\"";
	$variantdesc_query1="SELECT GeneIntro.GeneIntr_en,GeneIntro.GeneIntroID,GeneIntro.AllocationDate,Gene.Symbol,GeneIntro.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.Priority FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee ON GeneIntro.ReviewerID=Employee.EmployeeID WHERE GeneIntro.TranslatorID=\"$TranslatorID\" AND GeneIntro.Status=3 AND Gene.Symbol=\"$keyword\"";
//** Query VariantDesc tables;
$result = $mysql_link->query($variantdesc_query);
$variantdesc_array = array();
while($row = $result->fetch_assoc()) {
    $arr['ID']=$row['VariantDescID'];
    $arr['VariantDesc_en'] = $row['VariantDesc_en'];
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
    $arr['ID']=$row['GeneIntroID'];
    $arr['VariantDesc_en'] = $row['GeneIntr_en'];
    $arr['ApproveDate']=$row['AllocationDate'];
    $arr['KeyWord'] = $row['Symbol'];
    $arr['Database'] = 'GeneIntro';
    $arr['Count'] = $row['Count'];
//    $arr['Status'] = $row['Status'];
    $arr['Reviewer'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
    $arr['Priority'] = $row['Priority'];
    array_push($variantdesc_array, $arr);
}
}
echo json_encode($variantdesc_array);
?>
