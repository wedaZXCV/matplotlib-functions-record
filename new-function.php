<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>New Function</title>
</head>
<body>
  <nav>
    <div class="button">
      <button class="button-button back-to-main-page" type="submit">Back to main page</button>
    </div>
    <div class="wrapper">
      <h1> NEW FUNCTION PAGE</h1>
    </div>
  </nav>
  

  <div class="container">

    <div class="form-container">
      <form action="new-function.php" method="post" id="newFunction-form">
        <div class="form-rows">
          <div class="labels">
            <label for="function-id" id="id-label">Function id</label>
          </div>
          <div class="fields">
            <input type="text" name="fu-id" id="function-id" class="input-fields" placeholder="Enter the function id" required>
          </div>
        </div>
        <div class="form-rows">
          <div class="labels">
            <label for="input-name" id="name-label">Function name</label>
          </div>
          <div class="fields">
            <input type="text" name="fu-na" value="<?php 
              if(!isset($_POST['new-fu-na'])){
                
              } else{
                $newFuNa = $_POST['new-fu-na'];
                echo($newFuNa);
              }
            ?>" id="input-name" class="input-fields" placeholder="Enter the function name" required>
          </div>
        </div>
        <div class="form-rows">
          <div class="labels">
            <label for="input-code" id="code-label">Source code (type the code bellow)</label>
          </div>
          <div class="fields">
            <textarea id="input-code" name="fu-co" class="input-fields-large" rows = "30" cols = "100" required> </textarea>
          </div>
        </div>
        <div class="form-rows">
          <div class="labels">
            <label for="input-expl" id="expl-label">Code explanation</label>
          </div>
          <div class="fields">
            <textarea id="input-expl" name="fu-ex" class="input-fields-large" rows = "50" cols = "100" required> </textarea>
          </div>
        </div>

        <!--INSERT IMAGES-->
        <div class="form-rows">
          <div class="labels">
            <label for="image-url" id="image-label">Image URL</label>
          </div>
          <div class="fields">
            <input type="text" id="image-url" name="fu-img" class="input-fields" placeholder="Enter the url for explaining images" required>
          </div>
        </div>
        <div class="button">
          <button class="button-button" id="save-function" type="submit">Save</button>
        </div>
      </form>
    </div>

  </div>
  <?php 
    
    //Prepare values to store in database table
    //Check if the form is not filled yet
    if(!isset($_POST['fu-id']) || !isset($_POST['fu-na'])){
      
    } else{
      $id = $_POST["fu-id"];
      $name = $_POST["fu-na"];
      $scod = $_POST["fu-co"];
      echo "<h4>".$scod."  </h4>";
      // change the quotes into \" in order to be successfully able to get inserted in SQL
      $scod = preg_replace("$\"|\'$","\\\"",$scod);
      echo "<br>";
      echo "<h3>".$scod."  </h3>";
      // detect endline carrieage return
      // $scod = preg_replace("$\n$");
      preg_match_all("$\r$",$scod,$matches, PREG_OFFSET_CAPTURE);
      //echo "<pre>"; print_r($matches); echo "</pre>";   // now we can detect the location of \r
      
      //all we need to do then is re-insert \r\n into the location as \\r\\n
      $newLineLoc = array();
      foreach($matches[0] as $key=>$value){
        if($key > 0){
          $newLineLoc[$key] = $matches[0][$key][1] + 4;
        } else {
          $newLineLoc[$key] = $matches[0][$key][1];
        }
      }
      foreach($newLineLoc as $key=>$value){
        $scod = substr_replace($scod, "\\r\\n", $newLineLoc[$key], 0);
      }
      echo "<br>new one<br>";
      echo "<h3>".$scod."  </h3>";

      //if the \r\n happens multiple of times, yields things like \r\r\r\n\n\n
      // then we need to regex it into a single \r\n

      

      // echo "<h3> number of occurence \\n is".$occ."</h3>";
      // echo "<h3> number of occurence \\r is".$ocd."</h3>";
      // $explaination = $_POST["fu-ex"];
      // $imagie = $_POST["fu-img"];

      // //Do connection and send to MySQL server
      // include 'db-connection.php';
      // $conn = OpenCon();
      // echo "Connected Successfully";
      

      // $sql = "INSERT INTO functi VALUES($id, '$name', '$explaination', '$scod', '$imagie');";
      // if($conn->query($sql) === TRUE){
      //   echo "New record created successfully";
      // } else {
      //   echo "Error: ". $sql . "<br>" . $conn->error;
      // }
      // CloseCon($conn);
    }
    
    
  ?>
</body>
</html>