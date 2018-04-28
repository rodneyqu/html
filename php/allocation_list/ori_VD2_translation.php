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
$array1 = array();

$query1="SELECT VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Status,VariantDesc.VariantDesc_en FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID WHERE VariantDesc.VariantDescID=\"$ID\"";
$result1 = $mysql_link->query($query1);
while($row1 = $result1->fetch_assoc()) {
	$arr1['VariantDescID'] = $row1['VariantDescID'];
	$arr1['KeyWord'] = $row1['Symbol'] . " " . $row1['HGVSp'];
	$arr1['Database'] = 'VariantDesc';
	$arr1['Status'] = $row1['Status'];
	$arr1['VariantDesc_en']=$row1['VariantDesc_en'];
}
$query3="SELECT GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Status,GeneIntro.GeneIntr_en FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID WHERE GeneIntro.GeneIntroID=\"$ID\"-1283";
$result3 = $mysql_link->query($query3);
while($row1 = $result3->fetch_assoc()) {
                $arr1['VariantDescID'] = $row1['GeneIntroID']+1283;
		$arr1['KeyWord'] = $row1['Symbol'];
                $arr1['database'] = 'GeneIntro';
                $arr1['Status'] = $row1['Status'];
                $arr1['VariantDesc_en'] = $row1['GeneIntr_en'];
}


$query2="SELECT VariantDescRecords.TranslationResults,VariantDescRecords.VariantDescRecordsID,VariantDescRecords.TranslationDate,VariantDescRecords.Priority,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName FROM VariantDescRecords JOIN Employee as b ON VariantDescRecords.TranslatorID=b.EmployeeID JOIN Employee as c ON VariantDescRecords.ReviewerID=c.EmployeeID WHERE VariantDescRecords.VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC";
$result2 = $mysql_link->query($query2);
$array2 = array();
while($row2 = $result2->fetch_assoc()) {
    $arr2['TranslationResults']=$row2['TranslationResults'];
    $arr2['VariantDescRecordsID']=$row2['VariantDescRecordsID'];
    $arr2['TranslationDate']=$row2['TranslationDate'];
    $arr2['Priority']=$row2['Priority'];
    $arr2['Translator']=$row2['TranslatorLastName'].$row2['TranslatorMiddleName'].$row2['TranslatorFirstName'];
    $arr2['Reviewer']=$row2['ReviewerLastName'].$row2['ReviewerMiddleName'].$row2['ReviewerFirstName'];
//    $arr2['Status']=$row2['Status'];
    array_push($array2, $arr2);
}
$query4="SELECT GeneIntroRecords.TranslationResults,GeneIntroRecords.GeneIntroRecordsID,GeneIntroRecords.TranslationDate,GeneIntroRecords.Priority,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName FROM GeneIntroRecords JOIN Employee as b ON GeneIntroRecords.TranslatorID=b.EmployeeID JOIN Employee as c ON GeneIntroRecords.ReviewerID=c.EmployeeID WHERE GeneIntroRecords.GeneIntroID=\"$ID\"-1283 ORDER BY GeneIntroRecordsID DESC";
$result4 = $mysql_link->query($query4);
while($row2 = $result4->fetch_assoc()) {
    $arr2['TranslationResults']=$row2['TranslationResults'];
    $arr2['VariantDescRecordsID']=$row2['GeneIntroRecordsID'];
    $arr2['TranslationDate']=$row2['TranslationDate'];
    $arr2['Priority']=$row2['Priority'];
    $arr2['Translator']=$row2['TranslatorLastName'].$row2['TranslatorMiddleName'].$row2['TranslatorFirstName'];
    $arr2['Reviewer']=$row2['ReviewerLastName'].$row2['ReviewerMiddleName'].$row2['ReviewerFirstName'];
    array_push($array2, $arr2);
}

$array1['Desc']=$arr1;
$array1['DescRecords']=$array2;
echo json_encode($array1);
?>
