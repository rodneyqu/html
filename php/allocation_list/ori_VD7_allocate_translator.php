<?php
//********************************************************************************************// 
// Filename: 
// Author: Xiang Zuo
// Version: 1.0
// Create Date: 2018/02/06
// Function: 
// Input files: 
// Output: 
//********************************************************************************************// 

include(__DIR__ . '/Database_Connect.php');

header('Content-Type: text/html; charset=UTF-8');

$query="SELECT EmployeeID,FirstName,MiddleName,LastName FROM Employee WHERE Authority<>1 AND Authority<>4";
$result = $mysql_link->query($query);
$array = array();
while($row = $result->fetch_assoc()) {
	$arr['ID'] = $row['EmployeeID'];
	$arr['Name'] = $row['LastName'] . $row['MiddleName'] . $row['FirstName'];
	array_push($array, $arr);
}

echo json_encode($array);
?>
