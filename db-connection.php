<?php 
  function OpenCon(){
    $dbhost = "localhost:3306";
    $dbuser = "root";
    $dbpass = "Hinterrollover7<3";
    $db = "latihan";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connec failed: %s\n". $conn -> error);
    return $conn;
  }

  function CloseCon($conn){
    $conn -> close();
  }

?>