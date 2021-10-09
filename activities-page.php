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
    <button class="button-button back-to-main-page" type="submit">Back to main page</button>
  </div>
  <div class="wrapper">
    <h1> ACTIVITY LIST PAGE</h1>
  </div>
</nav>
<div class="container">
  <div class="briefing">
    <p>Here are some matplotlib activity to process stuffs.
      Also you can modify them by hovering mouse over an activity and click the appearing edit button </p>
      <hr>
  </div>
  <div class="contents">
    <ul id="list-con">
      <?php 
        //do connection
        include 'db-connection.php';

      

        // SHOW THE FUNCTION LIST (NORMALLY)

        $conn = OpenCon();
        //retreive all function name, then can be clicked later to expand more details on another page (maybe some amount next time, then after some scroll next amount)
        $sql = "SELECT id, name FROM activities;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
          // output data of each row
          while($row = $result->fetch_assoc()){
            //print with li tag
            echo "
            <div class=\"list-item-btn-back\">
              <form action=\"activity-detail.php\" method=\"post\" class=\"btn-form\">
                <button name=\"clkd-btn\" value=\"".$row["id"]."\" class=\"list-item-btn\" id=\"check-function\" type=\"submit\">
                  <li class=\"list-item\">". $row["name"] ."</li>
                </button>
              </form>
              <div class=\"modifier\">
                <div class=\"edit-button\">
                  <form action=\"edit-activity.php\" method=\"POST\" class=\"btn-form-edit\">
                    <button type=\"submit\" name=\"idItemEdit\" value=\"".$row["id"]."\" class=\"list-item-btn-edit\">
                      EDIT
                    </button>
                  </form>
                </div>
                <div class=\"delete-button\">
                  <form action=\"delete-ac.php\" method=\"POST\" class=\"btn-form-edit\">
                    <button type=\"submit\" name=\"isDelete\" value=\"".$row["id"]."\" class=\"list-item-btn-delete\" id=\"".$row["id"]."\">
                      DELETE
                    </button>
                  </form>
                </div>
              </div>
            </div><br>
            ";
          }
        }
        CloseCon($conn);
      ?>
    </ul>
  </div>
</div>
</body>
</html>