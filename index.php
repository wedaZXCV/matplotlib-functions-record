<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Matplotlib functions</title>
  <?php 
  ?>
</head>
<body>
  <nav>
    <div class="wrapper">
      <!-- TITLE CONTENT GOES HERE -->
      <h1>MATPLOTLIB FUNCTIONS</h1>
    </div>
  </nav>
  <div class="container">
    <div class="history">
      <p>
        <!-- ADD MATPLOTLIB HISTORY -->
        Here is some of matplotlib history.
      </p>
    </div>
    <div class="box-create">
      <div class="add-new">
        <!-- ADD NEW ACTIVITY BUTTON -->
        <p>
          Any new activity to get recorded?
        </p>
        <form action="new-activities.php" method="post" class="main-button">
          <div class="button">
            <button type="submit" class="button-button" id="add-activity">Add activity</button>
          </div>
        </form>
        
      </div>
      <div class="add-new">
        <!-- ADD NEW FUNCTION BUTTON -->
        <p>
          Any new function you've learned from internet?
        </p>
        <form action="new-function.php" method="post" class="main-button">
          <div class="button">
            <button class="button-button" id="add-function">Add function</button>
          </div>
        </form>
      </div>
    </div>

    <div class="learned-activities">
      <form action="activities-page-copy.php" method="post" class="main-button">
        <div class="button">
          <button type="submit" class="button-button" id="go-to-activity-list">Activity list</button>
        </div>
      </form>
      <p>
        recently added activites:
      </p>
      <!-- TOP FIVE LIST OF RECENTLY ADDED ACTIVITES -->
      <!-- AND n more-->
      <!-- SEE ALL BUTTON -->
      <ul class="activities-list">
        <?php 
        include "db-connection.php";
        $conn = OpenCon();
        $sql = "SELECT id, name FROM activities ORDER BY id DESC LIMIT 5;";
          $result = $conn->query($sql);
          if ($result->num_rows > 0){
            // output data of each row
            while($row = $result->fetch_assoc()){ 
              echo"
              <form action=\"activity-detail.php\" method=\"post\" class=\"fu-form-li\">
                <button type=\"submit\" name=\"clkd-btn\" value=\"".$row["id"]."\" class=\"fu-li-btn\">
                  <li class=\"function-list-item\">".$row["name"]."</li>
                </button>
              </form>
              ";
            }
          }
        ?>
      </ul>
      <div class="see-more">
        <a href="activities-page-copy.php" class="see-more-activities">see more...</a>
      </div>
    </div>

    <div class="learned-functions">
      <form action="functions-page.php" method="post" class="main-button">
        <div class="button">
          <button class="button-button" id="go-to-function-list">Function list</button>
        </div>
      </form>
      <p>
        recently added functions:
      </p>
      <!-- TOP FIVE LIST OF RECENTLY ADDED FUNCTIONS -->
      <!-- AND n more-->
      <!-- SEE ALL BUTTON -->
      
      <ul class="functions-list">
        <?php 
          $sql = "SELECT id, name FROM functi ORDER BY id DESC LIMIT 5;";
          $result = $conn->query($sql);
          if ($result->num_rows > 0){
            // output data of each row
            while($row = $result->fetch_assoc()){ 
              echo"
              <form action=\"function-detail.php\" method=\"post\" class=\"fu-form-li\">
                <button type=\"submit\" name=\"clkd-btn\" value=\"".$row["id"]."\" class=\"fu-li-btn\">
                  <li class=\"function-list-item\">".$row["name"]."</li>
                </button>
              </form>
              ";
            }
          }
        closeCon($conn);
        
        ?>
      </ul>
      <div class="see-more">
        <a href="functions-page.php" class="see-more-functions">see more...</a>
      </div>
      
    </div>
  </div>



  <!-- <script src="app.js"></script> -->
</body>
</html>