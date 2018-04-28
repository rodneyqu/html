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
$query="SELECT Password FROM Employee WHERE EmployeeID=\"$UserID\"";
$result = $mysql_link->query($query);
while($row = $result->fetch_assoc()) {
//    $arr['Password'] = $row['Password'];
    $old_password=$row['Password'];
}
echo json_encode($old_password);
?>
