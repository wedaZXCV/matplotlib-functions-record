<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Activity Detail</title>
</head>
<body>
  <nav>
    <form action="index.php" method="GET">
      <button class="button-button back-to-main-page" type="submit">Back to main page</button>
    </form>
    <div class="wrapper">
      <h1> ACTIVITY DETAIL</h1>
    </div>
  </nav>
  <div class="container">
    <div class="briefing">
    <?php
      include "db-connection.php";
      if(!isset($_POST['clkd-btn'])){
        
      } else {
        $clkd_btn = $_POST["clkd-btn"];
        $conn = OpenCon();
        
        //retreive the selected activity based on id within $clkd_btn
        $sql = "SELECT * FROM activities WHERE id = ".$clkd_btn.";";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
          while($row = $result->fetch_assoc()) {
            //RegEx untuk menemukan delimiter ; antarfungsi.
            $pattern = "/[;]+/";
            $components = preg_split($pattern,$row["fuid"], -1, PREG_SPLIT_NO_EMPTY);
            $sourceCode = nl2br(htmlspecialchars($row["scod"]));
            //Print list
            echo "
            <div id=\"activity-title\">
              <h2>".$row['name']."</h2>
            </div>
            <div id=\"id-activity\"> 
              <h3>Activity ID ".$row['id']."</h3>
            </div>
            <h2> Description </h2>
            <p>
              ".$row['expl']."
            </p>
            <div class=\"description-images\">
              <img src=\"".$row['img']."\" alt=\"description image\"
              width=\"800\"
              height=\"600\"
              >
            </div>
            <hr>
            <br>
            <h2> Source Code </h2>
            <div class=\"source-code\">
              <p>
                ".$sourceCode."
              </p>
            </div>
            <hr>
            <br>
            <h2> Engaged Functions </h2>
            <p>".
            $row["fuid"]
            ."
            </p>
            ";
          }
        }
        CloseCon($conn);
        echo "<ul id=\"list-con\"";
        $conn = OpenCon();
        foreach($components as &$poin){
          echo "<br>";
          $sql = "SELECT id, name FROM functi WHERE name = \"".$poin."\";";
          $result = $conn->query($sql);
          if ($result->num_rows == 0){
            echo "
            <div class=\"list-item-btn-back\">
              <div class=\"fu-li-activity-detail\">
                <li class=\"list-item\">".$poin."</li>
              </div>
              <div class=\"modifier\">
                <div class=\"add-new-fu-button\">
                  <form action=\"new-function.php\" method=\"post\" class=\"engaged-func-list\">
                    <button type=\"submit\" name=\"new-fu-na\" value=\"".$poin."\">Add Function</button>
                  </form>
                </div>
              </div>
            </div>
            ";
            // if func-name exists
          } else if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
              echo "
              <form action=\"function-detail.php\" method=\"post\" class=\"engaged-func-list\">
                <button name=\"clkd-btn\" value=\"".$row["id"]."\"type=\"submit\" class=\"list-item-btn\">
                  <li class=\"list-item\">".$poin."</li>
                </button>
              </form>
              ";
            }
          }
        }
        
        CloseCon($conn);
        echo "</ul>";
      }
      
    ?>
    </div>
  </div>

</body>
</html>