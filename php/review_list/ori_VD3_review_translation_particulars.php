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
//$ID=1;

//array_push($array1,$array2);
//$query="SELECT VariantDesc.VariantDescID,VariantDescRecords.VariantDescRecordsID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName,VariantDesc.LatestUpdateDate,VariantDesc.VariantDesc_en,VariantDesc.VariantDesc_cn FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN VariantDescRecords ON VariantDesc.VariantDescID=VariantDescRecords.VariantDescID JOIN Employee as b ON VariantDescRecords.TranslatorID=b.EmployeeID JOIN Employee as c ON VariantDescRecords.ReviewerID=c.EmployeeID WHERE VariantDesc.VariantDescID=\"$ID\""; 
//$query="SELECT VariantDesc.VariantDescID,VariantDescRecords.VariantDescRecordsID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName,VariantDesc.VariantDesc_en,VariantDesc.VariantDesc_cn,VariantDesc.Status,VariantDesc.TranslationDate FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN VariantDescRecords ON VariantDesc.VariantDescID=VariantDescRecords.VariantDescID JOIN Employee as b ON VariantDescRecords.TranslatorID=b.EmployeeID JOIN Employee as c ON VariantDescRecords.ReviewerID=c.EmployeeID WHERE VariantDesc.VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC limit 1";
//$query="SELECT VariantDesc.VariantDescID,VariantDescRecords.VariantDescRecordsID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.VariantDesc_en,VariantDesc.VariantDesc_cn,VariantDesc.Status,VariantDesc.TranslationDate FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN VariantDescRecords ON VariantDesc.VariantDescID=VariantDescRecords.VariantDescID JOIN Employee ON VariantDescRecords.TranslatorID=Employee.EmployeeID WHERE VariantDesc.VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC limit 1";
//$query="SELECT VariantDesc.VariantDescID,VariantDescRecords.VariantDescRecordsID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,b.FirstName,b.MiddleName,b.LastName,c.FirstName,c.MiddleName,c.LastName,VariantDesc.LatestUpdateDate,VariantDesc.VariantDesc_en,VariantDesc.VariantDesc_cn,VariantDesc.Status FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN VariantDescRecords ON VariantDesc.VariantDescID=VariantDescRecords.VariantDescID JOIN Employee as b ON VariantDescRecords.TranslatorID=b.EmployeeID JOIN Employee as c ON VariantDescRecords.ReviewerID=c.EmployeeID WHERE VariantDesc.VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC limit 1";
if($ID<=1283){
	$query="SELECT VariantDesc.VariantDescID,VariantDescRecords.VariantDescRecordsID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.TranslationDate,VariantDesc.VariantDesc_en,VariantDesc.VariantDesc_cn FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN VariantDescRecords ON VariantDesc.VariantDescID=VariantDescRecords.VariantDescID JOIN Employee ON VariantDescRecords.TranslatorID=Employee.EmployeeID WHERE VariantDesc.VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC limit 1";
	$result = $mysql_link->query($query);
//$array = array();
	while($row = $result->fetch_assoc()) {
		$arr['ID'] = $row['VariantDescID'];
		$arr['VariantDescRecordsID'] = $row['VariantDescRecordsID'];
		$arr['KeyWord'] = $row['Symbol'] . " " . $row['HGVSp'];
		$arr['Count'] = $row['Count'];
		$arr['Translator'] = $row['LastName'].$row['Employee.MiddleName'].$row['FirstName'];
		$arr['TranslationDate']=$row['TranslationDate'];
		$arr['VariantDesc_en']=$row['VariantDesc_en'];
		$arr['VariantDesc_cn']=$row['VariantDesc_cn'];
	}
}else{
	$query="SELECT GeneIntro.GeneIntroID,GeneIntroRecords.GeneIntroRecordsID,Gene.Symbol,GeneIntro.Count,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.TranslationDate,GeneIntro.GeneIntr_en,GeneIntro.GeneIntr_cn FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN GeneIntroRecords ON GeneIntro.GeneIntroID=GeneIntroRecords.GeneIntroID JOIN Employee ON GeneIntroRecords.TranslatorID=Employee.EmployeeID WHERE GeneIntro.GeneIntroID=\"$ID\"-1283 ORDER BY GeneIntroRecordsID DESC limit 1";
	$result = $mysql_link->query($query);
	while($row = $result->fetch_assoc()) {
                $arr['ID'] = $row['GeneIntroID']+1283;
                $arr['VariantDescRecordsID'] = $row['GeneIntroRecordsID'];
                $arr['KeyWord'] = $row['Symbol'];
                $arr['Count'] = $row['Count'];
                $arr['Translator'] = $row['LastName'].$row['Employee.MiddleName'].$row['FirstName'];
                $arr['TranslationDate']=$row['TranslationDate'];
                $arr['VariantDesc_en']=$row['GeneIntr_en'];
                $arr['VariantDesc_cn']=$row['GeneIntr_cn'];
        }
}

//$array['Desc']=$arr;
//echo json_encode($array);
echo json_encode($arr);
?>
