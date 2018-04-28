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
$Email=$_POST['Email'];
$Authority=$_POST['Authority'];
$Status=$_POST['Status'];
$FirstName=$_POST['FirstName'];
$MiddleName=$_POST['MiddleName'];
$LastName=$_POST['LastName'];

//** Query VariantDesc tables;
$query="UPDATE Employee SET FirstName=\"$FirstName\",MiddleName=\"$MiddleName\",LastName=\"$LastName\" ,Email=\"$Email\",Authority=\"$Authority\",Status=\"$Status\" WHERE EmployeeID=\"$UserID\"";
$mysql_link->query($query);
