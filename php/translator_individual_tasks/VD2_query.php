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
$TranslatorID=$_POST['TranslatorID'];
$Status=$_POST['Status'];
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

if($database=='VariantDesc'){              #VariantDesc
	if($Status){
		$statusSql=' and VariantDesc.Status= '.$Status;
	}
	if (preg_match("/^p\./",$keyword)){
		$variantdesc_query="SELECT VariantDesc.TranslationDate,VariantDesc.Status,VariantDesc.VariantDesc_en,VariantDesc.VariantDescID,VariantDesc.AllocationDate,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.ReviewerID=Employee.EmployeeID WHERE VariantDesc.TranslatorID=\"$TranslatorID\"   AND Variant.HGVSp=\"$keyword\"".$statusSql;
	}elseif(empty($keyword)){
		$variantdesc_query="SELECT VariantDesc.TranslationDate,VariantDesc.Status,VariantDesc.VariantDesc_en,VariantDesc.VariantDescID,VariantDesc.AllocationDate,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.ReviewerID=Employee.EmployeeID WHERE VariantDesc.TranslatorID=\"$TranslatorID\"".$statusSql;
	}elseif(preg_match("/^[\w\d]+$/",$keyword)){
		$variantdesc_query="SELECT VariantDesc.TranslationDate,VariantDesc.Status,VariantDesc.VariantDesc_en,VariantDesc.VariantDescID,VariantDesc.AllocationDate,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.Priority FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.ReviewerID=Employee.EmployeeID WHERE VariantDesc.TranslatorID=\"$TranslatorID\" AND Gene.Symbol=\"$keyword\"".$statusSql;
	}
	$result = $mysql_link->query($variantdesc_query);
	while($row = $result->fetch_assoc()) {
            $arr['ID']=$row['VariantDescID'];
            $arr['VariantDesc_en'] = $row['VariantDesc_en'];
            $arr['ApproveDate']=$row['AllocationDate'];
            $arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
            $arr['Database'] = 'VariantDesc';
            $arr['Count'] = $row['Count'];
            $arr['Reviewer'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
            $arr['Priority'] = $row['Priority'];
            $arr['TranslationDate'] = $row['TranslationDate'];
	    	$arr['Status'] =$row['Status'];
            array_push($variantdesc_array, $arr);
        }
}elseif($database=='GeneIntro'){                  #GeneIntro
	if($Status){
		$statusSql=' and GeneIntro.Status= '.$Status;
	}
	if(empty($keyword)){
		$variantdesc_query="SELECT GeneIntro.TranslationDate,GeneIntro.Status,GeneIntro.GeneIntr_en,GeneIntro.GeneIntroID,GeneIntro.AllocationDate,Gene.Symbol,GeneIntro.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.Priority FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee ON GeneIntro.ReviewerID=Employee.EmployeeID WHERE GeneIntro.TranslatorID=\"$TranslatorID\"".$statusSql;
	}elseif(preg_match("/^[\w\d]+$/",$keyword)){
		$variantdesc_query="SELECT GeneIntro.TranslationDate,GeneIntro.Status,GeneIntro.GeneIntr_en,GeneIntro.GeneIntroID,GeneIntro.AllocationDate,Gene.Symbol,GeneIntro.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.Priority FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee ON GeneIntro.ReviewerID=Employee.EmployeeID WHERE GeneIntro.TranslatorID=\"$TranslatorID\" AND  Gene.Symbol=\"$keyword\"".$statusSql;
	}
	$result = $mysql_link->query($variantdesc_query);
	while($row = $result->fetch_assoc()) {
	    $arr['ID']=$row['GeneIntroID'];
	    $arr['VariantDesc_en'] = $row['GeneIntr_en'];
	    $arr['ApproveDate']=$row['AllocationDate'];
	    $arr['KeyWord'] = $row['Symbol'];
	    $arr['Database'] = 'GeneIntro';
	    $arr['Count'] = $row['Count'];
	    $arr['Reviewer'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
	    $arr['Priority'] = $row['Priority'];
	    $arr['TranslationDate'] = $row['TranslationDate'];
	    $arr['Status'] =$row['Status'];
	    array_push($variantdesc_array, $arr);
	}
}elseif($database=='Therapy_Test'){

	if($Status){
		$statusSql=' and te.Status= '.$Status;
	}
	if(empty($keyword)){

		$variantdesc_query="SELECT te.Status,te.TranslationDate,te.TherapyEfficacy_en,te.TherapyID,te.AllocationDate,te.Keyword,te.Count,e.LastName,e.MiddleName,e.FirstName,te.Priority FROM TherapyEfficacy as te JOIN Employee  as e ON te.ReviewerID=e.EmployeeID WHERE te.TranslatorID=\"$TranslatorID\" ".$statusSql;
	}elseif($keyword){
		$variantdesc_query="SELECT te.Status,te.TranslationDate,te.TherapyEfficacy_en,te.TherapyID,te.AllocationDate,te.Keyword,te.Count,e.LastName,e.MiddleName,e.FirstName,te.Priority FROM TherapyEfficacy as te JOIN Employee as e ON te.ReviewerID=e.EmployeeID WHERE te.TranslatorID=\"$TranslatorID\" AND te.Keyword=\"$keyword\"" .$statusSql;
	}
	$result = $mysql_link->query($variantdesc_query);
	while($row = $result->fetch_assoc()) {
	    $arr['ID']=$row['TherapyID'];
	    $arr['VariantDesc_en'] = $row['TherapyEfficacy_en'];
	    $arr['ApproveDate']=$row['AllocationDate'];
	    $arr['KeyWord'] = $row['Keyword'];
	    $arr['Database'] = 'Therapy_Test';
	    $arr['Count'] = $row['Count'];
	    $arr['Reviewer'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
	    $arr['Priority'] = $row['Priority'];
	    $arr['TranslationDate'] = $row['TranslationDate'];
	    $arr['Status'] =$row['Status'];
	    array_push($variantdesc_array, $arr);
	}
}

echo json_encode($variantdesc_array);
?>
