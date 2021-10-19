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
        
    <?php 
    //Prepare values to store in database table
    //Check if the form is not filled yet
    if(!isset($_POST['fu-id']) || !isset($_POST['fu-na'])){
      include 'db-connection.php';
      $conn = OpenCon();
      //close connection happens on the moment after idt declaration
    } else{

      $id = $_POST["fu-id"];
      echo "<br><br><br>"; echo($id);
      $name = $_POST["fu-na"];
      $scod = $_POST["fu-co"];
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
      
      $explaination = $_POST["fu-ex"];
      $explaination = preg_replace("$\"$","\\\"",$explaination);
      $explaination = preg_replace("$\'$","\\'",$explaination);
      $imagie = $_POST["fu-img"];

      //Do connection and send to MySQL server
      include 'db-connection.php';
      $conn = OpenCon();
      echo "Connected Successfully";
      

      $sql = "INSERT INTO functi VALUES($id, '$name', '$explaination', '$scod', '$imagie');";
      if($conn->query($sql) === TRUE){
        echo "New record created successfully";
      } else {
        echo "Error: ". $sql . "<br>" . $conn->error;
      }
      //close connection happens on the moment after idt declaration

      //display arrayNew (retreived ids)
      
    }
  ?>
        <!--INPUT HIDDEN FOR THE ID -->
        <input type="hidden" name="fu-id" value=<?php 
        $sql = "SELECT id FROM functi ORDER BY id;";
        // code bellow for idt declaration. $idt is the value assigned to input "fu-id"
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

    <?php 
      foreach($arrayNew as $value){
        echo($value);
        echo(" ");
      }
    
    ?>

  </div>
  
</body>
</html>