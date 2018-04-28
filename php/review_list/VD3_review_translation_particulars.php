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
$database=$_POST['Database'];
//** get the records count of VariantDesc


if($database=='VariantDesc'){
	$query="SELECT VariantDesc.VariantDescID,VariantDescRecords.VariantDescRecordsID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.TranslationDate,VariantDesc.VariantDesc_en,VariantDesc.VariantDesc_cn FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN VariantDescRecords ON VariantDesc.VariantDescID=VariantDescRecords.VariantDescID JOIN Employee ON VariantDescRecords.TranslatorID=Employee.EmployeeID WHERE VariantDesc.VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC limit 1";
	$result = $mysql_link->query($query);
//$array = array();
	while($row = $result->fetch_assoc()) {
		$arr['ID'] = $row['VariantDescID'];
		$arr['VariantDescRecordsID'] = $row['VariantDescRecordsID'];
		$arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
		$arr['Count'] = $row['Count'];
		$arr['Database'] = 'VariantDesc';
		$arr['Translator'] = $row['LastName'].$row['Employee.MiddleName'].$row['FirstName'];
		$arr['TranslationDate']=$row['TranslationDate'];
		$arr['VariantDesc_en']=$row['VariantDesc_en'];
		$arr['VariantDesc_cn']=$row['VariantDesc_cn'];
	}
}
if($database=='GeneIntro'){
	$query="SELECT GeneIntro.GeneIntroID,GeneIntroRecords.GeneIntroRecordsID,Gene.Symbol,GeneIntro.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.TranslationDate,GeneIntro.GeneIntr_en,GeneIntro.GeneIntr_cn FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN GeneIntroRecords ON GeneIntro.GeneIntroID=GeneIntroRecords.GeneIntroID JOIN Employee ON GeneIntroRecords.TranslatorID=Employee.EmployeeID WHERE GeneIntro.GeneIntroID=\"$ID\" ORDER BY GeneIntroRecordsID DESC limit 1";
	$result = $mysql_link->query($query);
	while($row = $result->fetch_assoc()) {
                $arr['ID'] = $row['GeneIntroID'];
                $arr['VariantDescRecordsID'] = $row['GeneIntroRecordsID'];
                $arr['KeyWord'] = $row['Symbol'];
                $arr['Count'] = $row['Count'];
                $arr['Database'] = 'GeneIntro';
                $arr['Translator'] = $row['LastName'].$row['Employee.MiddleName'].$row['FirstName'];
                $arr['TranslationDate']=$row['TranslationDate'];
                $arr['VariantDesc_en']=$row['GeneIntr_en'];
                $arr['VariantDesc_cn']=$row['GeneIntr_cn'];
        }
}
if($database=='Therapy_Test'){
    $query="SELECT te.TherapyEfficacy_en,te.TherapyEfficacy_cn,te.TherapyID,te.Keyword,te.Count,ter.TherapyEfficacyID,ter.TranslationDate,c.FirstName ,c.MiddleName,c.LastName  FROM TherapyEfficacyRecord as ter JOIN Employee as b ON ter.TranslatorID=b.EmployeeID JOIN Employee as c ON ter.ReviewerID=c.EmployeeID
    join TherapyEfficacy as te on te.TherapyID=ter.TherapyID WHERE ter.TherapyID=\"$ID\" ORDER BY TherapyEfficacyID DESC limit 1";
    $result = $mysql_link->query($query);

    while($row = $result->fetch_assoc()) {
        $arr['ID'] = $row['TherapyID'];
        $arr['VariantDescRecordsID']=$row['TherapyEfficacyID'];
 		$arr['KeyWord'] = $row['Keyword'];
        $arr['Count'] = $row['Count'];
        $arr['Database'] = 'Therapy_Test';
        $arr['Translator'] = $row['LastName'].$row['MiddleName'].$row['FirstName'];
        $arr['TranslationDate']=$row['TranslationDate'];
        $arr['VariantDesc_en']=$row['TherapyEfficacy_en'];
        $arr['VariantDesc_cn']=$row['TherapyEfficacy_cn'];
        
        
    }
}
echo json_encode($arr);
?>
