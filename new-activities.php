<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>New activity</title>
</head>
<body>
<nav>
  <form action="index.php" method="GET">
    <button class="button-button back-to-main-page" type="submit">Back to main page</button>
  </form>
  <div class="wrapper">
    <h1> NEW ACTIVITY PAGE</h1>
  </div>
</nav>

<div class="container">
  <div class="form-container">
    <form action="new-activities.php" method="post" id="newActivity-form"> 
    <?php 
    //Prepare values to store in database table
    //Check if the form is not filled yet
    if(!isset($_POST['ac-id']) || !isset($_POST['ac-na'])){
      include 'db-connection.php';
      $conn = OpenCon();
      //close connection happens on the moment after idt declaration
    } else{

      $id = $_POST['ac-id'];
      $name = $_POST['ac-na'];
      $expl = $_POST['ac-ex'];
      $scod = $_POST['ac-co'];
      $img = $_POST['ac-img'];
      $fuid = $_POST['ac-fu-id'];

      // change the quotes into \" in order to be successfully able to get inserted in SQL
      $scod = preg_replace("$\"|\'$","\\\"",$scod);

      // detect endline carrieage return
      preg_match_all("$\r$",$scod,$matches, PREG_OFFSET_CAPTURE);
      // echo "<pre>"; print_r($matches); echo "</pre>";   // now we can detect the location of \r
      
      //all we need to do then is re-insert \r\n into the location as \\r\\n
      $newLineLoc = array();
      foreach($matches[0] as $key=>$value){
        if($key > 0){
          $newLineLoc[$key] = $matches[0][$key][1] + ($key * 2);
        } else {
          $newLineLoc[$key] = $matches[0][$key][1];
        }
      }
      // firstly first we need to remove any real \r and \n whitespace char
      $scod = preg_replace("#\n|\r#", "", $scod);
      foreach($newLineLoc as $key=>$value){
        $scod = substr_replace($scod, "\\r\\n", $newLineLoc[$key], 0);
      }

      //if the \r\n happens multiple of times, yields things like \r\r\r\n\n\n
      // then we need to regex it into a single \r\n
      $scod = preg_replace('/(\\\r){2,}(\\\n){2,}/', "\\r\\n", $scod); // it must be three times to match \ (backslash)
      
      $expl = preg_replace("$\"$","\\\"",$expl);
      $expl = preg_replace("$\'$","\\'",$expl);

      //Do connection and send to MySQL server
      include 'db-connection.php';
      $conn = OpenCon();

      $sql = "INSERT INTO activities VALUES($id, '$name', '$expl', '$scod', '$img', '$fuid');";
      if($conn->query($sql) === TRUE){
        echo "New record created successfully";
      } else {
        echo "Error: ". $sql . "<br>" . $conn->error;
      }
      //close connection happens on the moment after idt declaration
    }
    ?>

      <!--INPUT HIDDEN FOR THE ID -->
      <input type="hidden" name="ac-id" value=<?php 
        $sql = "SELECT id FROM activities ORDER BY id;";
        // code bellow for idt declaration. $idt is the value assigned to input "ac-id"
        $result = $conn->query($sql);
        CloseCon($conn);
        $arrayNew = array();
        if ($result->num_rows > 0){
          $itt = 0;
          $idt = 0;
          while($row = $result->fetch_assoc()) {
            array_push($arrayNew, $row["id"]);
            if($itt == 0){
              if($row["id"] != 0){
                $idt = 0;
                break;
              } else {
                $idt = $row["id"];
                // no break;
              }
            } else {
              // jumping case
              if(($row["id"] - $temp) > 1){
                $idt = $temp + 1;
                break;
                // normal case
              } else{
                $idt = $row["id"] + 1;
              }
            }
            $itt += 1;
            $temp = $row["id"];
          }
        }
        echo($idt)?>>

      <div class="form-rows">
        <div class="labels">
          <label for="input-name" id="name-label">Activity name</label>
        </div>
        <div class="fields">
          <input type="text" name="ac-na" id="input-name" class="input-fields" placeholder="Enter the function name" required>
        </div>
      </div>
      <div class="form-rows">
        <div class="labels">
          <label for="input-code" id="code-label">Full source code (type the code bellow)</label>
        </div>
        <div class="fields">
          <textarea id="input-code" name="ac-co" class="input-fields-large" rows = "30" cols = "100"></textarea>
        </div>
      </div>
      <div class="form-rows">
        <div class="labels">
          <label for="input-expl" id="expl-label">Code explanation</label>
        </div>
        <div class="fields">
          <textarea id="input-expl" name="ac-ex" class="input-fields-large" rows = "50" cols = "100"></textarea>
        </div>
      </div>

      <!--INSERT IMAGES-->
      <div class="form-rows">
        <div class="labels">
          <label for="image-url" id="image-label">Image URL</label>
        </div>
        <div class="fields">
          <input type="text" id="image-url" name="ac-img" class="input-fields" placeholder="Enter the url for related images">
        </div>
      </div>

      <div class="form-rows">
        <div class="labels">
          <label for="fu-id" id="fu-id-label">Function engaged (use Semicolon (;) to seperate different function name). After the name ends, don't put space. Immediately semicolon (;)</label>
        </div>
        <div class="fields">
          <textarea name="ac-fu-id" class="input-fields-large" id="fu-id" rows="25" cols="100"></textarea>
        </div>
      </div><br>
      <div class="button">
        <button class="button-button" id="save-activity" type="submit">Save</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>