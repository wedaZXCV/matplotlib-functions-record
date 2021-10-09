<?php 
  $numbers = array(5,4,3,5,15,2);
  for($i = 0; $i < 6; $i++){
    for($j = 0; $j < 6; $j++){
      if($j != 6-1){
        $mem = $numbers[$j+1];
        if($numbers[$j] > $numbers[$j+1]){
          $numbers[$j+1] = $numbers[$j];
          $numbers[$j] = $mem;
        }
      }
    }
  }
  echo "<br><br>";
  for($i = 0; $i <6; $i++){
    echo $numbers[$i]."<br>";
  }

?>