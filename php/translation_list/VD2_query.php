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
$keyword=$_POST['KeyWord'];
$database=$_POST['Database'];
$Status=$_POST['Status'];
//$order=0; // 0 - 不变 1 - 反序
//$searchArr['KeyWord']=$keyword;
$searchArr['Gene.Symbol']=$keyword;
$searchArr['Variant.HGVSp']=$keyword;
$searchArr[$database.'.Status']=$Status;



getList($searchArr,$page,$count,$database);


function getList($searchArr,$page,$count,$database){
   		 Global $mysql_link;

	    //query VariantDesc table total
	    



	    $start=($page-1)*$count;
	   
	    $variantdesc_array['list'] = array();
	    //** query VariantDesc table

	   
		
	    if($database=='VariantDesc'){
	    	
	    	if($searchArr['Gene.Symbol']){
	    		$whereSql ='Gene.Symbol like "%'.$searchArr['Gene.Symbol'].'%" or Variant.HGVSp like "%'.$searchArr['Variant.HGVSp'].'%"';
	    	}
	    	if($searchArr[$database.'.Status']!=''){
	    		if($whereSql){
	    			$whereSql .=' or '.$database.'.Status = '. $searchArr[$database.'.Status'];	    	
	    		}else{
	    			$whereSql .=$database.'.Status = '. $searchArr[$database.'.Status'];	    	
	    		}
	    	}

			if($whereSql){
				$where=' where ';
			}
		    $variantdesc_query="SELECT VariantDesc.VariantDesc_en,VariantDesc.CreateDate,VariantDesc.VariantDescID,Gene.Symbol,Variant.HGVSp,VariantDesc.Count,VariantDesc.Status,VariantDesc.TranslationDate FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID".$where.$whereSql." limit ".$start.",". $count;
		    $result = $mysql_link->query($variantdesc_query);
		    while($row = $result->fetch_assoc()) {
		        
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
		    $VariantDesc_total_search_query="SELECT count(*) as total FROM VariantDesc JOIN Variant ON VariantDesc.VariantID=Variant.VariantID JOIN Transcript ON Transcript.TranscriptID=Variant.TranscriptID JOIN Gene ON Gene.GeneID=Transcript.GeneID".$where.$whereSql;
		    $result=$mysql_link->query($VariantDesc_total_search_query);
			while($row = $result->fetch_assoc()) {
				$total=$row['total'];
			}
			$variantdesc_array['total']=$total;

		}

		if($database=='GeneIntro'){
			if($searchArr['Gene.Symbol']){
	    		$whereSql ='Gene.Symbol like "%'.$searchArr['Gene.Symbol'].'%"';
	    	}
	    	if($searchArr[$database.'.Status']!=''){
	    		if($whereSql){
	    			$whereSql .=' or '.$database.'.Status = '. $searchArr[$database.'.Status'];	    	
	    		}else{
	    			$whereSql .=$database.'.Status = '. $searchArr[$database.'.Status'];	    	
	    		}
	    	}
	        if($whereSql){
				$where=' where ';
			}
		//** query GeneIntro table
	        $GeneIntro_query="SELECT GeneIntro.GeneIntr_en,GeneIntro.CreateDate,GeneIntro.GeneIntroID,Gene.Symbol,GeneIntro.Count,GeneIntro.Status,GeneIntro.TranslationDate FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID".$where.$whereSql." limit ".$start.",". $count;
	        $result = $mysql_link->query($GeneIntro_query);
		while($row = $result->fetch_assoc()) {
	            $arr['VariantDesc_en'] = $row['GeneIntr_en'];
	            $arr['CreateDate'] = $row['CreateDate'];
	            $arr['ID'] = $row['GeneIntroID'] ;
	            $arr['KeyWord'] = $row['Symbol'];
	            $arr['Database']='GeneIntro';
	            $arr['Count'] = $row['Count'];
	            $arr['Status'] = $row['Status'];
	            $arr['Translator'] = $row['TranslatorLastName'].$row['TranslatorMiddleName'].$row['TranslatorFirstName'];
	            $arr['Reviewer'] = $row['ReviewerLastName'].$row['ReviewerMiddleName'].$row['ReviewerFirstName'];
	            $arr['TranslationDate'] = $row['TranslationDate'];
	            array_push($variantdesc_array['list'], $arr);
	        }

	        $GeneIntro_total_search_query="SELECT count(*) as total FROM GeneIntro JOIN Gene ON GeneIntro.GeneID=Gene.GeneID".$where.$whereSql;
		    $result=$mysql_link->query($GeneIntro_total_search_query);
			while($row = $result->fetch_assoc()) {
				$total=$row['total'];
			}
			$variantdesc_array['total']=$total;
			
			
        }


        if($database=='Therapy_Test'){
			
	    	$keyword=$_POST['KeyWord'];
	    	if($keyword){
	    		$whereSql ='KeyWord like "%'.addslashes($keyword).'%"';
	    	}
	    	if($searchArr[$database.'.Status']!=''){
	    		if($whereSql){
	    			$whereSql .=' and Status = '. $searchArr[$database.'.Status'];	    	
	    		}else{
	    			$whereSql .=' Status = '. $searchArr[$database.'.Status'];	    	
	    		}
	    	}
	        if($whereSql){
				$where=' where ';
			}
		//** query GeneIntro table
	        $Therapy_Test_query="select TherapyID,Keyword,TherapyEfficacy_en,`Status`,CreateDate,Count,TranslationDate from TherapyEfficacy
".$where.$whereSql." limit ".$start.",". $count;
	        $result = $mysql_link->query($Therapy_Test_query);
		while($row = $result->fetch_assoc()) {
	            $arr['VariantDesc_en'] = $row['TherapyEfficacy_en'];
	            $arr['CreateDate'] = $row['CreateDate'];
	            $arr['ID'] = $row['TherapyID'] ;
	            $arr['KeyWord'] = $row['Keyword'];
	            $arr['Database']='Therapy_Test';
	            $arr['Count'] = $row['Count'];
	            $arr['Status'] = $row['Status'];
	            $arr['Translator'] = $row['TranslatorLastName'].$row['TranslatorMiddleName'].$row['TranslatorFirstName'];
	            $arr['Reviewer'] = $row['ReviewerLastName'].$row['ReviewerMiddleName'].$row['ReviewerFirstName'];
	            $arr['TranslationDate'] = $row['TranslationDate'];
	            array_push($variantdesc_array['list'], $arr);
	        }

	        $Therapy_Test_total_search_query="select count(TherapyID) as total from TherapyEfficacy
".$where.$whereSql;
		    $result=$mysql_link->query($Therapy_Test_total_search_query);
			while($row = $result->fetch_assoc()) {
				$total=$row['total'];
			}
			$variantdesc_array['total']=$total;
			
			
        }
    
    echo json_encode($variantdesc_array);
}

?>
