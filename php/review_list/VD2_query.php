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
$database=$_POST['Database'];
$EmployeeID=$_POST['EmployeeID'];
$variantdesc_array = array();

if($database=='VariantDesc'){          #select database VariantDesc
    if($EmployeeID){
        $whereTranslatorID=' and VariantDesc.TranslatorID='.$EmployeeID;
    }else{
        $whereTranslatorID='';
    }


    if (preg_match("/^p\./",$keyword)){          //search by HGVS
		$variantdesc_query="SELECT VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Status,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.TranslatorID=Employee.EmployeeID WHERE Variant.HGVSp=\"$keyword\" AND ReviewerID=\"$reviewerID\" AND (VariantDesc.Status=3 OR VariantDesc.Status=4)".$whereTranslatorID;
	}elseif(empty($keyword)){	
		$variantdesc_query="SELECT VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Status,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.TranslatorID=Employee.EmployeeID WHERE ReviewerID=\"$reviewerID\" AND (VariantDesc.Status=3 OR VariantDesc.Status=4)".$whereTranslatorID;
	}elseif(preg_match("/^[\w\d]+$/",$keyword)){
		$variantdesc_query="SELECT VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Status,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.TranslatorID=Employee.EmployeeID WHERE Gene.Symbol=\"$keyword\" AND ReviewerID=\"$reviewerID\" AND (VariantDesc.Status=3 OR VariantDesc.Status=4)".$whereTranslatorID;
	}
	$result = $mysql_link->query($variantdesc_query);
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
}

if($database=='GeneIntro'){
    if($EmployeeID){
        $whereTranslatorID=' and GeneIntro.TranslatorID='.$EmployeeID;
    }else{
        $whereTranslatorID='';
    }
	if(empty($keyword)){
		$variantdesc_query="SELECT GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.Status,GeneIntro.Priority FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee ON GeneIntro.TranslatorID=Employee.EmployeeID WHERE ReviewerID=\"$reviewerID\" AND (GeneIntro.Status=3 OR GeneIntro.Status=4)".$whereTranslatorID;;
	}elseif(preg_match("/^[\w\d]+$/",$keyword)){
		$variantdesc_query="SELECT GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.TranslationDate,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.Status,GeneIntro.Priority FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee ON GeneIntro.TranslatorID=Employee.EmployeeID WHERE Gene.Symbol=\"$keyword\" AND ReviewerID=\"$reviewerID\" AND (GeneIntro.Status=3 OR GeneIntro.Status=4)".$whereTranslatorID;
	}
	$result = $mysql_link->query($variantdesc_query);
        while($row = $result->fetch_assoc()) {
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
}

if($database=='Therapy_Test'){
    if($EmployeeID){
        $whereTranslatorID=' and te.TranslatorID='.$EmployeeID;
    }else{
        $whereTranslatorID='';
    }
    if(empty($keyword)){
        $variantdesc_query="SELECT te.TranslatorID,te.Status,te.TranslationDate,te.TherapyEfficacy_en,te.TherapyID,te.AllocationDate,te.Keyword,te.Count,ee.LastName,ee.MiddleName,ee.FirstName,te.Priority 
FROM TherapyEfficacy as te 
JOIN Employee  as e 
ON te.ReviewerID=e.EmployeeID 
join Employee as ee
on ee.EmployeeID = te.TranslatorID WHERE te.ReviewerID=\"$reviewerID\" AND (te.Status=3 or te.Status=4)".$whereTranslatorID;
    }elseif($keyword){
        $variantdesc_query="SELECT te.TranslatorID,te.Status,te.TranslationDate,te.TherapyEfficacy_en,te.TherapyID,te.AllocationDate,te.Keyword,te.Count,ee.LastName,ee.MiddleName,ee.FirstName,te.Priority 
FROM TherapyEfficacy as te 
JOIN Employee  as e 
ON te.ReviewerID=e.EmployeeID 
join Employee as ee
on ee.EmployeeID = te.TranslatorID WHERE te.ReviewerID=\"$reviewerID\" AND (te.Status=3 or te.Status=4) AND te.Keyword=\"$keyword\"".$whereTranslatorID;
    }

    $result = $mysql_link->query($variantdesc_query);
    while($row = $result->fetch_assoc()) {
        $arr['ID']=$row['TherapyID']; 
        $arr['KeyWord'] = $row['Keyword'];
        $arr['Database'] = 'Therapy_Test';
        $arr['Count'] = $row['Count'];
        $arr['TranslationDate'] =$row['TranslationDate'];
        $arr['Translator'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
        $arr['Status'] = $row['Status'];
        $arr['Priority'] = $row['Priority'];
        array_push($variantdesc_array, $arr);
    }            
        
            
            
}

echo json_encode($variantdesc_array);
?>
