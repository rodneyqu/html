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
//** Query VariantDesc tables;
#$query="SELECT EmployeeID,CreateDate,Email,Authority,Status FROM Employee WHERE Email=\"$Email\"";
$query="SELECT EmployeeID,CreateDate,Email,Authority,Status FROM Employee WHERE Email REGEXP '^$Email'";
$result = $mysql_link->query($query);
$array = array();
while($row = $result->fetch_assoc()) {
    $arr['EmployeeID'] = $row['EmployeeID'];
    $arr['CreateDate'] = $row['CreateDate'];
    $arr['Email'] = $row['Email'];
    $arr['Authority'] = $row['Authority'];
    $arr['Status'] = $row['Status'];
    array_push($array, $arr);
}
echo json_encode($array);
?>
