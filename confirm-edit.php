<?php  
  include "db-connection.php";
  $id = $_POST["id-con"];
  $name = $_POST["fu-na"];
  $scod = $_POST["fu-co"];
  $explaination = $_POST["fu-ex"];
  $imagie = $_POST["fu-img"];
  $conn = OpenCon();
  $sql = "UPDATE functi SET name='$name', scod='$scod', explaination='$explaination', imagie='$imagie' WHERE id='$id';";
      if($conn->query($sql) === TRUE){
        echo "New change applied successfully";
      } else {
        echo "Error: ". $sql . "<br>" . $conn->error;
      }
  CloseCon($conn);
  header("Location: functions-page.php", TRUE, 301);
?>