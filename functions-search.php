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
    <ul id="list-con">
    <?php 
    // SHOW THE FUNCTION LIST (BASED ON GIVEN SEARCH INPUT)
      if(isset($_POST["fu-search"])){
        //do connection
        include 'db-connection.php';
        
        $fuName = $_POST["fu-search"];

        // SHOW THE FUNCTION LIST (BASED ON GIVEN SEARCH INPUT)


        $conn = OpenCon();
        //retreive all matches for the input given, use SQL Reg-Ex
        $sql = "SELECT id, name FROM functi WHERE name LIKE \"%".$fuName."%\";";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
          // output data of each row
          while($row = $result->fetch_assoc()){
            //print with li tag
            echo "
            <div class=\"list-item-btn-back\">
              <form action=\"function-detail.php\" method=\"post\" class=\"btn-form\">
                <button name=\"clkd-btn\" value=\"".$row["id"]."\" class=\"list-item-btn\" id=\"check-function\" type=\"submit\">
                  <li class=\"list-item\">". $row["name"] ."</li>
                </button>
              </form>
              <div class=\"modifier\">
                <div class=\"edit-button\">
                  <form action=\"edit-function.php\" method=\"POST\" class=\"btn-form-edit\">
                    <button type=\"submit\" name=\"idItemEdit\" value=\"".$row["id"]."\" class=\"list-item-btn-edit\">
                      EDIT
                    </button>
                  </form>
                </div>
                <div class=\"delete-button\">
                  <form action=\"delete.php\" method=\"POST\" class=\"btn-form-edit\">
                    <button type=\"submit\" name=\"isDelete\" value=\"".$row["id"]."\" class=\"list-item-btn-delete\" id=\"".$row["id"]."\">
                      DELETE
                    </button>
                  </form>
                </div>
              </div>
              
            </div><br>
            ";
          }
        } else if($result->num_rows == 0){
          echo "<h2>Nothing is found, give different input and try again</h2>";
          
          //return button has the abillity to revert into NORMAL DISPLAY
          // by purge the fu-search value
          echo "
            <form action=\"functions-page.php\" method=\"post\">
              <button class=\"button-button\">Return button</button>
            </form>
          ";
        }
        CloseCon($conn);
      } 
    ?>
    </ul>
    </div>
    
  </div>
</body>
</html>