<?php
$servername = "localhost";
$username = "root";   
$password = "1234";  
$dbname = "taskapp";    


  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    throw new Exception("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";
  
  return $conn;
?>