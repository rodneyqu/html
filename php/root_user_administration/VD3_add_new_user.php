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
$Authority=$_POST['Authority'];
$Status=$_POST['Status'];
$CreateDate=$_POST['CreateDate'];
$FirstName=$_POST['FirstName'];
$MiddleName=$_POST['MiddleName'];
$LastName=$_POST['LastName'];

//** Query VariantDesc tables;
$query="INSERT INTO Employee (FirstName,MiddleName,LastName,Email,Password,Authority,Status,CreateDate) values (\"$FirstName\",\"$MiddleName\",\"$LastName\",\"$Email\",\"$Password\",\"$Authority\",\"$Status\",\"$CreateDate\")";
$mysql_link->query($query);
