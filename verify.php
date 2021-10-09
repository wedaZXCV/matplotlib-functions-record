<?php 
  include "db-connection.php";
  $conn = OpenCon();
  
  //Get the row count, then divide by 15 to get the number of pages
  $sql = "SELECT * FROM functi;";
  $result = $conn->query($sql);
  $totalItem = $result->num_rows;
  echo $totalItem."<br>";

  CloseCon($conn);
?>