<?php
//********************************************************************************************// 
// Filename: VariantDesc.php
// Author: Weixing Ye PhD
// Version: 1.0
// Create Date: 2018/01/30
// Function: This script connect to the local mysql database
// Input files: Database_Connect.php
// Output: Get the browse list of Variant Description database
//********************************************************************************************// 

//** Database_Connect.php, connected to the mysql database//
include(__DIR__ . '/Database_Connect.php');
$Email=$_POST['Email'];
$Password=$_POST['Password'];

//** Query VariantDesc tables;
$query="SELECT EmployeeID,Email,Authority,Status FROM Employee WHERE Email REGEXP '^$Email' AND Password=\"$Password\"";
$result = $mysql_link->query($query);
//$variantdesc_array = array();
/*
while($row = $result->fetch_array(MYSQL_ASSOC)){
	$ID = $row['EmployeeID'];
	$Email = $row['Email'];
	$Authority = $row['Authority'];
	$Status = $row['Status'];
}
echo $ID;
if($Status==1){
	array_push($variantdesc_array, $arr);
	echo json_encode($variantdesc_array);
}elseif($Status==0){
	echo '状态未登陆!';
}
*/
while($row = $result->fetch_assoc()) {
    $arr['ID'] = $row['EmployeeID'];
    $arr['Email'] = $row['Email'];
    $arr['Authority'] = $row['Authority'];
    $arr['Status'] = $row['Status'];
    if ($arr['Status']==1){
        echo json_encode($arr);
    }elseif($arr['Status']==2){
	echo '状态未启用!';
    }
}
?>
