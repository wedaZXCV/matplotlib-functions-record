<?php  
  include "db-connection.php";
  $id = $_POST["id-con"];
  $name = $_POST["fu-na"];
  $scod = $_POST["fu-co"];
  $explaination = $_POST["fu-ex"];
  $imagie = $_POST["fu-img"];
  $fuid = $_POST["ac-fu-id"];
  $conn = OpenCon();
  $sql = "UPDATE activities SET name='$name', scod='$scod', expl='$explaination', img='$imagie', fuid='$fuid'  WHERE id='$id';";
      if($conn->query($sql) === TRUE){
        echo "New change applied successfully";
      } else {
        echo "Error: ". $sql . "<br>" . $conn->error;
      }
  CloseCon($conn);
  header("Location: activities-page.php", TRUE, 301);
?>