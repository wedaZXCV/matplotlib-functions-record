<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Activities page</title>
</head>
<body>
  <nav>
    <div class="button">
      <form action="index.php" method="GET">
        <button class="button-button back-to-main-page" type="submit">Back to main page</button>
      </form>
    </div>
    <div class="wrapper">
      <h1> ACTIVITY LIST PAGE</h1>
    </div>
  </nav>

  <div class="container">
    <div class="briefing">
      <p>Here are some matplotlib activity to process stuffs.
      Also you can modify them by hovering mouse over an activity and click the appearing edit button </p>
      <div class="search-bar">
        <!-- THIS GOES TO DEDICATED SEARCH PAGE-->
        <form action="activities-search.php" method="post">
          <?php 
          if(!isset($_POST['fu-search'])){
            echo "
            <input type=\"text\" name=\"fu-search\" value=\"\" class=\"input-fields-short\" id=\"function-search\" placeholder=\"Find activity from the list\" required>
            ";
          } else {
            echo "
            <input type=\"text\" name=\"fu-search\" value=\"".$_POST["fu-search"]."\" class=\"input-fields-short\" id=\"function-search\" placeholder=\"Find activity from the list\" required>
            ";
          }
          ?>
          <button class="button-button">Find</button>
        </form>
      </div>
      <hr>
    </div>
    <div class="contents">
    <!-- PAGINATION CLICKED -->
    <?php 
      include 'db-connection.php';
      // check if this is not the initial display
      if(isset($_POST['status_data'])){
        //retreive data from array without query anymore
        //display based on selected page number
        $pageNumber = $_POST["page-number"];
        $nameArr = unserialize($_POST['array_data']);
        $idArr = unserialize($_POST['array_id']);

        $totalItem = count($nameArr);
        
        $displaying = 2;
        //for temporary, we divide by item displayed
        $pages = ceil($totalItem / $displaying);
        // here we have difference with the starting point based on $pageNumber
        $iLocation = $pageNumber * $displaying - $displaying;
        
        // later, print only $displaying items
        $displayArr = array();
        for($i = $iLocation; $i < ($iLocation+$displaying); $i++){        
          // if the $nameArr[$i] is null, so break loop
          if(!isset($nameArr[$i])){
            break;
          }
          array_push($displayArr, $nameArr[$i]);
        }
        $displayIdArr = array();
        for($i = $iLocation; $i < ($iLocation+$displaying); $i++){
          // if the $idArr[$i] is null, so break loop
          if(!isset($idArr[$i])){
            break;
          }
          array_push($displayIdArr, $idArr[$i]);
        }
      // INITIAL DISPLAY
      } else {
        //do query to get array
        $conn = OpenCon();
        //retreive all function name, then can be clicked later to expand more details on another page
        $sql = "SELECT id, name FROM activities;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
          // output data of each row
          //Create new array for $row["name"] and $row["id"]
          $nameArr = array();
          $idArr = array();
          while($row = $result->fetch_assoc()){
            //insert into new array
            array_push($nameArr, $row["name"]);
            array_push($idArr, $row["id"]);
          }
          // get width
          $width = 0;
          foreach($nameArr as $value){
            $width += 1;
          }
          //sort value first by ord() << ASCII code
          foreach($nameArr as $key=>$value){
            for($j = 0; $j < $width; $j++){
              if($j != $width-1){
                $mem = $nameArr[$j+1];
                $memId = $idArr[$j+1];
                //check if the two value equals, shift to the next char comparison
                if(ord($nameArr[$j]) == ord($nameArr[$j+1])){
                  //get the less much char as the amount of $k time
                  if(strlen($nameArr[$j]) != strlen($nameArr[$j+1])){
                    $amount = min(strlen($nameArr[$j]),strlen($nameArr[$j+1]));
                  } else if(strlen($nameArr[$j]) == strlen($nameArr[$j+1])){
                    $amount = strlen($nameArr[$j]);
                  }
                  
                  //echo "<h5>".$amount."</h5>";
                  for ($k = 1; $k <= $amount-1; $k++){
                    if (ord($nameArr[$j][$k]) == ord($nameArr[$j+1][$k])){
                      // do nothing (itterate next)
                      continue;
                    } else if(ord($nameArr[$j][$k]) > ord($nameArr[$j+1][$k])){
                      $nameArr[$j+1] = $nameArr[$j];
                      $nameArr[$j] = $mem;
                      $idArr[$j+1] = $idArr[$j];
                      $idArr[$j] = $memId;
                      break;  //break of $k for loop
                    } else if(ord($nameArr[$j][$k]) < ord($nameArr[$j+1][$k])){
                      break;
                    }
                  }
                }
                else if(ord($nameArr[$j]) > ord($nameArr[$j+1])){
                  $nameArr[$j+1] = $nameArr[$j];
                  $nameArr[$j] = $mem;
                  $idArr[$j+1] = $idArr[$j];
                  $idArr[$j] = $memId;
                }
              }
            }
          }
        }
        //Get the row count, then divide by n to get the number of pages
        $sql = "SELECT * FROM activities;";
        $result = $conn->query($sql);
        $totalItem = $result->num_rows;
        $displaying = 2;
        $pages = ceil($totalItem / $displaying);
        // later, print only $displaying items
        $displayArr = array();
        for($i = 0; $i < $displaying; $i++){
          // if the $nameArr[$i] is null, so break loop
          if(!isset($nameArr[$i])){
            break;
          }
          array_push($displayArr, $nameArr[$i]);
        }
        $displayIdArr = array();
        for($i = 0; $i < $displaying; $i++){
          // if the $idArr[$i] is null, so break loop
          if(!isset($idArr[$i])){
            break;
          }
          array_push($displayIdArr, $idArr[$i]);
        }

        CloseCon($conn);
      }
    ?>
    <div class="pagination">
      <form action="activities-page-copy.php" method="post">
        <!-- status_data to check if it's no need to query anymore,
          the next display will not initial display-->
        <input type="hidden" name="status_data" value="True">

        <!-- array_data is the data fetched from SQL, already sorted.
          Is passed to the next display -->
        <input type="hidden" name="array_data" value="<?php echo htmlentities(serialize($nameArr));?>">

        <!-- as well as the idArr -->
        <input type="hidden" name="array_id" value="<?php echo htmlentities(serialize($idArr));?>">

        <?php 
          include "pagination.php";
        ?>
      </form>
    
    </div>
    <ul id="list-con">
    <?php 
      // SHOW THE ACTIVITY LIST (NORMALLY)
      // print sorted list items    
      foreach($displayArr as $key=>$value){
        echo "
          <div class=\"list-item-btn-back\">
            <form action=\"activity-detail.php\" method=\"post\" class=\"btn-form\">
              <button name=\"clkd-btn\" value=\"".$displayIdArr[$key]."\" class=\"list-item-btn\" id=\"check-function\" type=\"submit\">
                <li class=\"list-item\">". $value ."</li>
              </button>
            </form>
            <div class=\"modifier\">
              <div class=\"edit-button\">
                <form action=\"edit-activity.php\" method=\"POST\" class=\"btn-form-edit\">
                  <button type=\"submit\" name=\"idItemEdit\" value=\"".$displayIdArr[$key]."\" class=\"list-item-btn-edit\">
                    EDIT
                  </button>
                </form>
              </div>
              <div class=\"delete-button\">
                <form action=\"delete-ac.php\" method=\"POST\" class=\"btn-form-edit\">
                  <button type=\"submit\" name=\"isDelete\" value=\"".$displayIdArr[$key]."\" class=\"list-item-btn-delete\" id=\"".$displayIdArr[$key]."\">
                    DELETE
                  </button>
                </form>
              </div>
            </div>
            
          </div><br>
          ";
      }
      
    ?>
    </ul>
    </div>
    <div class="pagination">
      <form action="activities-page-copy.php" method="post">
        <!-- status_data to check if it's no need to query anymore,
          the next display will not initial display-->
        <input type="hidden" name="status_data" value="True">

        <!-- array_data is the data fetched from SQL, already sorted.
          Is passed to the next display -->
        <input type="hidden" name="array_data" value="<?php echo htmlentities(serialize($nameArr));?>">

        <!-- as well as the idArr -->
        <input type="hidden" name="array_id" value="<?php echo htmlentities(serialize($idArr));?>">

        <?php 
          include "pagination.php";
        ?>
      </form>
  </div>
  
  
  
</body>
</html>