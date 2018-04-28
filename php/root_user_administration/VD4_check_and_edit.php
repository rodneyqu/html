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
$UserID=$_POST['EmployeeID'];
//** Query VariantDesc tables;
$query="SELECT  `FirstName`,`MiddleName`,`LastName`,`CreateDate`,`Email`,`Password`,`Authority`,`Status` FROM Employee WHERE EmployeeID=\"$UserID\"";
$result = $mysql_link->query($query);
//$array = array();
while($row = $result->fetch_assoc()) {
    $arr['CreateDate'] = $row['CreateDate'];
    $arr['Email'] = isset($row['Email'])? $row['Email']:'';
    $arr['Password'] = $row['Password'];
    $arr['Authority'] = $row['Authority'];
    $arr['Status'] = $row['Status'];
    $arr['FirstName'] = isset($row['FirstName'])? $row['FirstName']:'';
    $arr['MiddleName'] = isset($row['MiddleName'])? $row['MiddleName']:'';
    $arr['LastName'] = isset($row['LastName'])? $row['LastName']:'';
//    array_push($array, $arr);
}
//echo json_encode($array);
echo json_encode($arr);
?>
