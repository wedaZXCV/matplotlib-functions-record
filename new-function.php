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
      $explaination = $_POST["fu-ex"];
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
      CloseCon($conn);
    }
    
    
  ?>
</body>
</html>