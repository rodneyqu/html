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
$query="UPDATE Employee SET Password='123456' WHERE EmployeeID=\"$UserID\"";
$mysql_link->query($query);
?>
