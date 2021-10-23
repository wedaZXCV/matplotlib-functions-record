<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Function Detail</title>
</head>
<body>
  <nav>
    <div class="button">
      <button class="button-button back-to-main-page" type="submit">Back to main page</button>
    </div>
    <div class="wrapper">
      <h1> FUNCTION DETAIL</h1>
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
        
        //retreive the selected function id within $clkd_btn
        $sql = "SELECT * FROM functi WHERE id = ".$clkd_btn.";";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
          while($row = $result->fetch_assoc()) {
            // prepare the scod variable to display CRLF format
            $sourceCode = nl2br(htmlspecialchars($row["scod"]));
            echo "
            <div id=\"function-title\">
              <h2>".$row['name']."</h2>
            </div>
            <div id=\"id-function\"> 
              <h3>Function ID ".$row['id']."</h3>
            </div>
            <h2> Description </h2>
            <p>
              ".$row['explaination']."
            </p>
            <div class=\"description-images\">
              <img src=\"".$row['imagie']."\" alt=\"description image\"
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
            ";
          }
        }
        CloseCon($conn);
      }
      
    ?>
      
    </div>
    
  </div>


</body>
</html>