<?php
//********************************************************************************************// 
// Filename: Database_Connect.php
// Author: Weixing Ye PhD
// Version: 1.0
// Create Date: 2018/01/30
// Function: This script connect to the local mysql database
// Input files: config.inc
// Output: Link to the mysql database
//********************************************************************************************// 

//** Configuration files, including MySQL login parameters and directories
include(__DIR__ . '/config.inc');

//Connected to mysql database
$mysql_link = new mysqli($db_server, $db_username, $db_password);
if (!$mysql_link) {
    die('Could not connect:' . mysqli_error());
}
$mysql_link->query("set NAMES 'utf8'");
$mysql_link->select_db($db_name);
?>
