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
      <div class="form-rows">
        <div class="labels">
          <label for="activity-id" id="id-label">Activity id</label>
        </div>
        <div class="fields">
          <input type="text" name="ac-id" id="activity-id" class="input-fields" placeholder="Enter the function id" required>
        </div>
      </div>
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
<?php 
  if(!isset($_POST['ac-id']) || !isset($_POST['ac-na'])){

  } else{
      include "db-connection.php";
      $id = $_POST['ac-id'];
      $name = $_POST['ac-na'];
      $expl = $_POST['ac-ex'];
      $scod = $_POST['ac-co'];
      $img = $_POST['ac-img'];
      $fuid = $_POST['ac-fu-id'];
      $conn = OpenCon();
      $sql = "INSERT INTO activities VALUES($id, '$name', '$expl', '$scod', '$img', '$fuid');";
      $result = $conn->query($sql);
      echo "insert complete";
      CloseCon($conn);
  }
?>
</body>
</html>