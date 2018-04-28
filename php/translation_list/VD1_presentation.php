<?php
//********************************************************************************************// 
// Filename: VariantDesc.php
// Author: Xiang Zuo
// Version: 2.0
// Create Date: 2018/03/01
// Function: This script connect to the local mysql database
// Input files: Database_Connect.php
// Output: Get the browse list of Variant Description database
//********************************************************************************************// 

//** Database_Connect.php, connected to the mysql database//
include(__DIR__ . '/Database_Connect.php');




$page=$_POST['page']; //当前页
$page=(empty($page))?'1':$page;
$count=$_POST['count'];
$count=(empty($count))?'10':$count;// 每页多少条数据 // 2个数据库 // 以后最好融合成1个库 减少查询db 次数 增加性能
$count=$count;

//$order=0; // 0 - 不变 1 - 反序
getList($page,$count);


function getList($page,$count){
    Global $mysql_link;

    //query VariantDesc table total
    $VariantDesc_total_query="select count(*) as total from VariantDesc;";
    $result = $mysql_link->query($VariantDesc_total_query);
    while($row=$result->fetch_assoc()){
         $VariantDesc_total=$row['total'];
    }


    // query GeneIntro table total
    $GeneIntro_total_query="select count(*) as total from GeneIntro;";
    $result = $mysql_link->query($GeneIntro_total_query);
    while($row=$result->fetch_assoc()){
         $GeneIntro_total=$row['total'];
    }
    $variantdesc_array['total']=$VariantDesc_total+$GeneIntro_total;


    $start=($page-1)*$count;
    $n=0;        #GeneIntroID is calculated after the last VariantDescID
    $variantdesc_array['list'] = array();
    //** query VariantDesc table
    
    $variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.CreateDate,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName,VariantDesc.TranslationDate FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID JOIN Employee as b ON VariantDesc.TranslatorID=b.EmployeeID JOIN Employee as c ON VariantDesc.ReviewerID=c.EmployeeID limit ".$start.",". $count;
    $result = $mysql_link->query($variantdesc_query);
    while($row = $result->fetch_assoc()) {
        $n++;
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
        array_push($variantdesc_array['list'], $arr);
    }
     if($page-1>=ceil($VariantDesc_total/$count)){
	
        $count=$count-count($variantdesc_array['list']);
	$start=($page-1-ceil($VariantDesc_total/$count))*$count;
        //** query GeneIntro table
        $variantdesc_query1="SELECT GeneIntro.GeneIntr_en,GeneIntro.CreateDate,GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.Status,b.FirstName as TranslatorFirstName,b.MiddleName as TranslatorMiddleName,b.LastName as TranslatorLastName,c.FirstName as ReviewerFirstName,c.MiddleName as ReviewerMiddleName,c.LastName as ReviewerLastName,GeneIntro.TranslationDate FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID JOIN Employee as b ON GeneIntro.TranslatorID=b.EmployeeID JOIN Employee as c ON GeneIntro.ReviewerID=c.EmployeeID limit ".$start.",". $count;
        $result1 = $mysql_link->query($variantdesc_query1);
        while($row = $result1->fetch_assoc()) {
            $arr['VariantDesc_en'] = $row['GeneIntr_en'];
            $arr['CreateDate'] = $row['CreateDate'];
            $arr['ID'] = $row['GeneIntroID'] + $VariantDesc_total;
            $arr['KeyWord'] = $row['Symbol'];
            $arr['Database']='GeneIntro';
            $arr['Count'] = $row['Count'];
            $arr['Status'] = $row['Status'];
            $arr['Translator'] = $row['TranslatorLastName'].$row['TranslatorMiddleName'].$row['TranslatorFirstName'];
            $arr['Reviewer'] = $row['ReviewerLastName'].$row['ReviewerMiddleName'].$row['ReviewerFirstName'];
            $arr['TranslationDate'] = $row['TranslationDate'];
            array_push($variantdesc_array['list'], $arr);
        }
    }
    echo json_encode($variantdesc_array);
}

?>

