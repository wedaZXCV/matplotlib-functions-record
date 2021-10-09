<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Edit Activity</title>
</head>
<body>
  <nav>
    <div class="button">
      <button class="button-button back-to-main-page" type="submit">Back to main page</button>
    </div>
    <div class="wrapper">
      <h1> EDIT ACTIVITY PAGE</h1>
    </div>
  </nav>

  <div class="container">
    <?php
      include "db-connection.php";

      // Get the id of function as reference in database
      $id = $_POST["idItemEdit"];
      //populate form with id based information from the database
      //firstly first, retreive all of the information.
      $conn = OpenCon();
      $sql = "SELECT * FROM activities WHERE id = '$id';";
      $result = $conn->query($sql);
      if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
    ?>
    <div class="form-container">
      <form action="confirm-edit-ac.php" method="POST" id="editFunction-form">
        <div class="form-rows">
          <div class="labels">
            <label for="input-name" id="name-label">Activity name</label>
          </div>
          <div class="fields">
            <input type="text" name="fu-na" value="<?php echo($row['name'])?>"id="input-name" class="input-fields" required>
          </div>
        </div>
        <div class="form-rows">
          <div class="labels">
            <label for="input-code" id="code-label">Source code (type the code bellow)</label>
          </div>
          <div class="fields">
            <textarea id="input-code" name="fu-co" class="input-fields-large" rows = "30" cols = "100" required><?php echo($row['scod'])?></textarea>
          </div>
        </div>
        <div class="form-rows">
          <div class="labels">
            <label for="input-expl" id="expl-label">Code explanation</label>
          </div>
          <div class="fields">
            <textarea id="input-expl" name="fu-ex" class="input-fields-large" rows = "50" cols = "100" required><?php echo($row['expl'])?></textarea>
          </div>
        </div>

        <!--INSERT IMAGES-->
        <div class="form-rows">
          <div class="labels">
            <label for="image-url" id="image-label">Image URL</label>
          </div>
          <div class="fields">
            <input type="text" name="fu-img" value="<?php echo($row['img']) ?>"id="image-url" class="input-fields" required>
          </div>
        </div>

        <div class="form-rows">
          <div class="labels">
            <label for="fu-id" id="fu-id-label">Function engaged (use Semicolon (;) to seperate different function name). After the name ends, don't put space. Immediately semicolon (;)</label>
          </div>
          <div class="fields">
            <textarea name="ac-fu-id" class="input-fields-large" id="fu-id" rows="25" cols="100"><?php echo($row["fuid"]);?></textarea>
          </div>
        </div><br>
        <div class="button">
          <button name="id-con" value="<?php echo($id) ?>" class="button-button" id="edit-function" type="submit">Save Changes</button>
        </div>
      </form>
    </div>
    <?php }}
    CloseCon($conn);
    
    ?>
  </div>
  
</body>
</html>