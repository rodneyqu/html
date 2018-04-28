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
$reviewerID=$_POST['CuratorID'];
$keyword=$_POST['KeyWord'];
//$database=$_POST['Database'];
//$translator=$_POST['TranslatorID'];
//$priority=$_POST['Priority'];

if ($_POST['KeyWord']){
	if (preg_match("/^p\./",$keyword)){          //search by HGVSp
		$variantdesc_query="SELECT VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Status,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.TranslatorID=Employee.EmployeeID WHERE Variant.HGVSp=\"$keyword\" AND ReviewerID=\"$reviewerID\" AND (VariantDesc.Status=3 OR VariantDesc.Status=4)";
	}else{                                             //search by gene symbol
		$variantdesc_query="SELECT VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Status,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.TranslatorID=Employee.EmployeeID WHERE Gene.Symbol=\"$keyword\" AND ReviewerID=\"$reviewerID\" AND (VariantDesc.Status=3 OR VariantDesc.Status=4)";
		$variantdesc_query1="SELECT GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.Status,GeneIntro.Priority FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee ON GeneIntro.TranslatorID=Employee.EmployeeID WHERE Gene.Symbol=\"$keyword\" AND ReviewerID=\"$reviewerID\" AND (GeneIntro.Status=3 OR GeneIntro.Status=4)";
	}
	$result = $mysql_link->query($variantdesc_query);
	$variantdesc_array = array();
	while($row = $result->fetch_assoc()) {
    	$arr['ID'] = $row['VariantDescID'];
    	$arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
    	$arr['Database'] = 'VariantDesc';
    	$arr['Count'] = $row['Count'];
    	$arr['TranslationDate'] =$row['TranslationDate'];
    	$arr['Translator'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
    	$arr['Status'] = $row['Status'];
    	$arr['Priority'] = $row['Priority'];
	array_push($variantdesc_array, $arr);
	}

	$result1 = $mysql_link->query($variantdesc_query1);
	while($row = $result1->fetch_assoc()) {
	$arr['ID'] = $row['GeneIntroID'];
        $arr['KeyWord'] = $row['Symbol'];
        $arr['Database'] = 'GeneIntro';
        $arr['Count'] = $row['Count'];
        $arr['TranslationDate'] =$row['TranslationDate'];
        $arr['Translator'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
        $arr['Status'] = $row['Status'];
        $arr['Priority'] = $row['Priority'];
	array_push($variantdesc_array, $arr);
	}
	echo json_encode($variantdesc_array);
}else{
	$variantdesc_query="SELECT VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Status,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.TranslatorID=Employee.EmployeeID WHERE (VariantDesc.Status=3 OR VariantDesc.Status=4) AND ReviewerID=\"$reviewerID\"";
	$variantdesc_query1="SELECT GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.Status,GeneIntro.Priority FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee ON GeneIntro.TranslatorID=Employee.EmployeeID WHERE (GeneIntro.Status=3 OR GeneIntro.Status=4) AND ReviewerID=\"$reviewerID\"";
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
	$result1 = $mysql_link->query($variantdesc_query1);
	while($row = $result1->fetch_assoc()) {
                $arr['ID'] = $row['GeneIntroID'];
                $arr['KeyWord'] = $row['Symbol'];
                $arr['Database'] = 'GeneIntro';
                $arr['Count'] = $row['Count'];
                $arr['TranslationDate'] = $row['TranslationDate'];
                $arr['Translator'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
                $arr['Status'] = $row['Status'];
                $arr['Priority'] = $row['Priority'];
                array_push($variantdesc_array, $arr);
        }
        echo json_encode($variantdesc_array);
}

//** Query VariantDesc tables;
/*
$result = $mysql_link->query($variantdesc_query);
$variantdesc_array = array();
while($row = $result->fetch_assoc()) {
    $arr['ID'] = $row['VariantDescID'];
    $arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
    $arr['Database'] = 'CKB';
    $arr['Count'] = $row['Count'];
    $arr['TranslationDate'] =$row['TranslationDate'];
    $arr['Translator'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
    $arr['Status'] = $row['Status'];    
    $arr['Priority'] = $row['Priority'];
    array_push($variantdesc_array, $arr);
}
echo json_encode($variantdesc_array);
*/
?>
