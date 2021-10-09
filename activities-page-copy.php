<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Functions page</title>
</head>
<body>
  <nav>
    <div class="button">
      <button class="button-button back-to-main-page" type="submit">Back to main page</button>
    </div>
    <div class="wrapper">
      <h1> FUNCTION LIST PAGE</h1>
    </div>
  </nav>

  <div class="container">
    <div class="briefing">
      <p>You can see all of the recorded matplotlib function in the list bellow.
        Also you can modify them by hovering mouse over a function and click the appearing edit button </p>
      <div class="search-bar">
        <!-- THIS GOES TO DEDICATED SEARCH PAGE-->
        <form action="functions-search.php" method="post">
          <?php 
          if(!isset($_POST['fu-search'])){
            echo "
            <input type=\"text\" name=\"fu-search\" value=\"\" class=\"input-fields-short\" id=\"function-search\" placeholder=\"Find function from the list\" required>
            ";
          } else {
            echo "
            <input type=\"text\" name=\"fu-search\" value=\"".$_POST["fu-search"]."\" class=\"input-fields-short\" id=\"function-search\" placeholder=\"Find function from the list\" required>
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
      // check if this is the initial display
      if(isset($_POST['status_data'])){
        //retreive data from array without query anymore
        //display based on selected page number
        $pageNumber = $_POST["page-number"];
        $nameArr = unserialize($_POST['array_data']);
        $idArr = unserialize($_POST['array_id']);

        $totalItem = count($nameArr);
        
        $displaying = 15;
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
        $sql = "SELECT id, name FROM functi;";
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
        $sql = "SELECT * FROM functi;";
        $result = $conn->query($sql);
        $totalItem = $result->num_rows;
        $displaying = 15;
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
      <form action="functions-page.php" method="post">
        <!-- status_data to check if it's no need to query anymore,
          the next display will not initial display-->
        <input type="hidden" name="status_data" value="True">

        <!-- array_data is the data fetched from SQL, already sorted.
          Is passed to the next display -->
        <input type="hidden" name="array_data" value="<?php echo htmlentities(serialize($nameArr));?>">

        <!-- as well as the idArr -->
        <input type="hidden" name="array_id" value="<?php echo htmlentities(serialize($idArr));?>">

        <?php 
        // display the page buttons as pagination
        // maybe it is for loop n-times... until all is displayed
        // use one form with action the same php, then name use the index of for loop
        
        // set the minimum limit to start the accordion creation
        $minimalAmount = 11;
        if($pages >= $minimalAmount){
          // the accordion has different display based on different page clicked
          
          // check if the selected page number is at near the top start or top end
          if(isset($_POST["page-number"])){
            if(($_POST["page-number"]>=1 && $_POST["page-number"]<=2) || ($_POST["page-number"]>=$pages-1 && $_POST["page-number"]<=$pages)){
              for($i = 1; $i <= 3; $i++){
                echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
              }
              echo "<div class=\"t-dot-pages\"> ... </div>";
              for($i = $pages-2; $i <= $pages; $i++){
                echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
              } // check if the selected page number is at pre-center or center point
              // at pre-center point, like 3 and $pages-2
            } else if($_POST["page-number"] == 3 || $_POST["page-number"] == $pages-2){
              for($i = 1; $i <= 3; $i++){
                echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
              }
              echo "<div class=\"t-dot-pages\"> ... </div>";
              // the 3 or the $pages-2?
              if($_POST["page-number"] == 3){
                for($i = 3+1; $i <= 3+1+4; $i++){
                  echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
                }
              } else if($_POST["page-number"] == $pages-2){
                for($i = $pages-7; $i <= $pages-7+4; $i++){
                  echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
                } 
              }
              echo "<div class=\"t-dot-pages\"> ... </div>";
              for($i = $pages-2; $i <= $pages; $i++){
                echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
              }
              
              // at center point
            } else {
              for($i = 1; $i <= 3; $i++){
                echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
              } 
              echo "<div class=\"t-dot-pages\"> ... </div>";
              
              if($_POST["page-number"]-2 > 3 && $_POST["page-number"]+2 < $pages-2){
                // here the current page number can be set as the mid point
                for($i = $_POST["page-number"]-2; $i < $_POST["page-number"]-2+5; $i++){
                  echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
                }
              } else {
                // here the current page number can not be set as the mid point
                // which loc? near start or end?
                if($_POST["page-number"] <= 3+2){
                  $itt = 3+1;
                  for($i = $itt; $i < $itt+5; $i++){
                    echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
                  }
                } else if($_POST["page-number"] >= ($pages-2)-2){
                  $itt = $pages-7;
                  for($i = $itt; $i < $itt+5; $i++){
                    echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
                  }
                }
              }
              echo "<div class=\"t-dot-pages\"> ... </div>";
              for($i = $pages-2; $i <= $pages; $i++){
                echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
              }
            }
            
           // initial display (no POST page-number retreived)
          } else if(!isset($_POST["page-number"])){
            for($i = 1; $i <= 3; $i++){
              echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
            }
            echo "<div class=\"t-dot-pages\"> ... </div>";
            for($i = $pages-2; $i <= $pages; $i++){
              echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
            }
          } // this following is when the amount is less than 11 (the minimum pages requirement)
        } else{
          for($i = 1; $i <= $pages; $i++){
            echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
          }
        }

        // if this is the innitial display
        // highlight the first page
        // if(!isset($_POST["status_data"])){
        //   echo "<style type=\"text/css\">
        //     #pb-".$i."{
        //       border-style: solid;
        //       border-color: red;
        //     }
        //   </style>
        //   ";
        // }
        ?>
      </form>
    
    </div>
    <ul id="list-con">
    <?php 
      // SHOW THE FUNCTION LIST (NORMALLY)
      // print sorted list items    
      foreach($displayArr as $key=>$value){
        echo "
          <div class=\"list-item-btn-back\">
            <form action=\"function-detail.php\" method=\"post\" class=\"btn-form\">
              <button name=\"clkd-btn\" value=\"".$displayIdArr[$key]."\" class=\"list-item-btn\" id=\"check-function\" type=\"submit\">
                <li class=\"list-item\">". $value ."</li>
              </button>
            </form>
            <div class=\"modifier\">
              <div class=\"edit-button\">
                <form action=\"edit-function.php\" method=\"POST\" class=\"btn-form-edit\">
                  <button type=\"submit\" name=\"idItemEdit\" value=\"".$displayIdArr[$key]."\" class=\"list-item-btn-edit\">
                    EDIT
                  </button>
                </form>
              </div>
              <div class=\"delete-button\">
                <form action=\"delete.php\" method=\"POST\" class=\"btn-form-edit\">
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
    
  </div>
  
  
  
</body>
</html>