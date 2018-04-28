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
$array1 = array();   #final result is stored in the array
$array2 = array();
//** get the records count of VariantDesc

if($database=='VariantDesc'){
	$query1="SELECT VariantDesc.VariantDescID,VariantDescRecords.VariantDescRecordsID,Gene.Symbol,Variant.HGVSp,VariantDesc.Priority,Employee.LastName,Employee.MiddleName,Employee.FirstName,VariantDesc.VariantDesc_en,VariantDesc.VariantDesc_cn FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee ON VariantDesc.ReviewerID=Employee.EmployeeID JOIN VariantDescRecords ON VariantDesc.VariantDescID=VariantDescRecords.VariantDescID WHERE VariantDesc.VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC LIMIT 1;";
	$result1 = $mysql_link->query($query1);
	while($row1 = $result1->fetch_assoc()) {
		$arr1['ID'] = $row1['VariantDescID'];
		$arr1['VariantDescRecordsID'] = $row1['VariantDescRecordsID'];
		$arr1['KeyWord'] = $row1['Symbol'] . " " . $row1['HGVSp'];
		$arr1['Database'] = 'VariantDesc';
		$arr1['Priority'] = $row1['Priority'];
		$arr1['Reviewer'] = $row1['LastName'].$row1['MiddleName'].$row1['FirstName'];
		$arr1['VariantDesc_en'] = $row1['VariantDesc_en'];
		$arr1['VariantDesc_cn'] = $row1['VariantDesc_cn'];
	}
}

if($database=='GeneIntro'){
	$query1="SELECT GeneIntro.GeneIntroID,GeneIntroRecords.GeneIntroRecordsID,Gene.Symbol,GeneIntro.Priority,Employee.LastName,Employee.MiddleName,Employee.FirstName,GeneIntro.GeneIntr_en,GeneIntro.GeneIntr_cn FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee ON GeneIntro.ReviewerID=Employee.EmployeeID JOIN GeneIntroRecords ON GeneIntro.GeneIntroID=GeneIntroRecords.GeneIntroID WHERE GeneIntro.GeneIntroID=\"$ID\" ORDER BY GeneIntroRecordsID DESC LIMIT 1;";
	$result1  = $mysql_link->query($query1);
	while($row1 = $result1->fetch_assoc()) {
        	$arr1['ID'] = $row1['GeneIntroID'];
	        $arr1['VariantDescRecordsID'] = $row1['GeneIntroRecordsID'];
        	$arr1['KeyWord'] = $row1['Symbol'];
	        $arr1['Database'] = 'GeneIntro';
        	$arr1['Priority'] = $row1['Priority'];
	        $arr1['Reviewer'] = $row1['LastName'].$row1['MiddleName'].$row1['FirstName'];
        	$arr1['VariantDesc_en'] = $row1['GeneIntr_en'];
        	$arr1['VariantDesc_cn'] = $row1['GeneIntr_cn'];
	}
}
	
if($database=='Therapy_Test'){
    $sql='select ter.TherapyEfficacyID,te.Priority,te.TherapyID,te.Keyword,te.TherapyEfficacy_en,te.TherapyEfficacy_cn,e.LastName,e.MiddleName,e.FirstName from TherapyEfficacy as te join TherapyEfficacyRecord as ter 
    on te.TherapyID= ter.TherapyID
    join Employee as e
    on te.ReviewerID=e.EmployeeID
     where te.TherapyID='.$ID.' order by TherapyEfficacyID desc limit 1;';
    $result3 = $mysql_link->query($sql);
    while($row1 = $result3->fetch_assoc()) {
            $arr1['ID'] = $row1['TherapyID']; 
            $arr1['VariantDescRecordsID'] = $row1['TherapyEfficacyID'];
            $arr1['KeyWord'] = $row1['Keyword']; 
            $arr1['Database'] = 'Therapy_Test';
            $arr1['Priority'] = $row1['Priority'];
	        $arr1['Reviewer'] = $row1['LastName'].$row1['MiddleName'].$row1['FirstName'];
            $arr1['VariantDesc_en'] = $row1['TherapyEfficacy_en'];
            $arr1['VariantDesc_cn'] = $row1['TherapyEfficacy_cn'];
    }
}

if($database=='VariantDesc'){
	$query2="SELECT VariantDescRecords.TranslationResults,VariantDescRecords.VariantDescRecordsID,VariantDescRecords.TranslationDate,VariantDescRecords.Priority,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName FROM VariantDescRecords JOIN Employee as b ON VariantDescRecords.TranslatorID=b.EmployeeID JOIN Employee as c ON VariantDescRecords.ReviewerID=c.EmployeeID WHERE VariantDescRecords.VariantDescID=\"$ID\" ORDER BY VariantDescRecordsID DESC";
	$result2 = $mysql_link->query($query2);
	
	while($row2 = $result2->fetch_assoc()) {
	    $arr2['TranslationResults']=$row2['TranslationResults'];
	    $arr2['VariantDescRecordsID']=$row2['VariantDescRecordsID'];
   	    $arr2['TranslationDate']=$row2['TranslationDate'];
	    $arr2['Priority']=$row2['Priority'];
	    $arr2['Translator']=$row2['TranslatorLastName'].$row2['TranslatorMiddleName'].$row2['TranslatorFirstName'];
	    $arr2['Reviewer']=$row2['ReviewerLastName'].$row2['ReviewerMiddleName'].$row2['ReviewerFirstName'];
	    array_push($array2, $arr2);
	}
}

if($database=='GeneIntro'){
	$query2="SELECT GeneIntroRecords.TranslationResults,GeneIntroRecords.GeneIntroRecordsID,GeneIntroRecords.TranslationDate,GeneIntroRecords.Priority,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName FROM GeneIntroRecords JOIN Employee as b ON GeneIntroRecords.TranslatorID=b.EmployeeID JOIN Employee as c ON GeneIntroRecords.ReviewerID=c.EmployeeID WHERE GeneIntroRecords.GeneIntroID=\"$ID\" ORDER BY GeneIntroRecordsID DESC";
	$result2 = $mysql_link->query($query2);
	
	while($row2 = $result2->fetch_assoc()) {
	    $arr2['TranslationResults']=$row2['TranslationResults'];
	    $arr2['VariantDescRecordsID']=$row2['GeneIntroRecordsID'];
	    $arr2['TranslationDate']=$row2['TranslationDate'];
	    $arr2['Priority']=$row2['Priority'];
	    $arr2['Translator']=$row2['TranslatorLastName'].$row2['TranslatorMiddleName'].$row2['TranslatorFirstName'];
	    $arr2['Reviewer']=$row2['ReviewerLastName'].$row2['ReviewerMiddleName'].$row2['ReviewerFirstName'];
	    array_push($array2, $arr2);
	}
}


if($database=='Therapy_Test'){
    $query4="SELECT ter.TranslationResults,ter.TherapyEfficacyID,ter.TranslationDate,ter.Priority,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName FROM TherapyEfficacyRecord as ter JOIN Employee as b ON ter.TranslatorID=b.EmployeeID JOIN Employee as c ON ter.ReviewerID=c.EmployeeID WHERE ter.TherapyID=\"$ID\" ORDER BY TherapyEfficacyID DESC";
    $result4 = $mysql_link->query($query4);

    while($row2 = $result4->fetch_assoc()) {
        $arr2['TranslationResults']=$row2['TranslationResults'];
        $arr2['VariantDescRecordsID']=$row2['TherapyEfficacyID'];
        $arr2['TranslationDate']=$row2['TranslationDate'];
        $arr2['Priority']=$row2['Priority'];
        $arr2['Translator']=$row2['TranslatorLastName'].$row2['TranslatorMiddleName'].$row2['TranslatorFirstName'];
        $arr2['Reviewer']=$row2['ReviewerLastName'].$row2['ReviewerMiddleName'].$row2['ReviewerFirstName'];
        array_push($array2, $arr2);
    }
}

$array1['Desc']=$arr1;
$array1['DescRecords']=$array2;

echo json_encode($array1);
?>
