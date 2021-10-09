<?php 
  include 'db-connection.php';
  //DELETE FUNCTION FIRST IF TRIGGERED BY DELETE BUTTON
  //If we about to delete a function at its database
  if(isset($_POST['isDelete'])){
    $item_id = $_POST['isDelete'];
    $conn = OpenCon();
    $sql = "DELETE FROM functi WHERE id=\"".$item_id."\"";
    $conn->query($sql);
    CloseCon($conn);
    header("Location: functions-page.php", TRUE, 301);
  }
  

?>