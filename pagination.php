<?php 
  // display the page buttons as pagination
  // maybe it is for loop n-times... until all is displayed
  // use one form with action the same php, then name use the index of for loop
  
  // set the minimum limit to start the accordion creation
  $minimalAmount = 11;
  if($pages >= $minimalAmount){
    // the accordion has different display based on different page clicked
    
    
    if(isset($_POST["page-number"])){
      // highlight the current page-number
      echo "<style type=\"text/css\">
          #pb-".$_POST["page-number"]."{
            border-style: solid;
            border-color: red;
          }
          </style>";

      // check if the selected page number is at near the top start or top end
      if(($_POST["page-number"]>=1 && $_POST["page-number"]<=2) || ($_POST["page-number"]>=$pages-1 && $_POST["page-number"]<=$pages)){
        for($i = 1; $i <= 3; $i++){
          echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
        }
        echo "<div class=\"t-dot-pages\"> ... </div>";
        for($i = $pages-2; $i <= $pages; $i++){
          echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
        } // check if the selected page number is at pre-center or center point
        // at pre-center point, like 3 and $pages-2
      } else if($_POST["page-number"] == 3 || $_POST["page-number"] == $pages-2){
        for($i = 1; $i <= 3; $i++){
          echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
        }
        echo "<div class=\"t-dot-pages\"> ... </div>";
        // the 3 or the $pages-2?
        if($_POST["page-number"] == 3){
          for($i = 3+1; $i <= 3+1+4; $i++){
            echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
          }
        } else if($_POST["page-number"] == $pages-2){
          for($i = $pages-7; $i <= $pages-7+4; $i++){
            echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
          } 
        }
        echo "<div class=\"t-dot-pages\"> ... </div>";
        for($i = $pages-2; $i <= $pages; $i++){
          echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
        }
        
        // at center point
      } else {
        for($i = 1; $i <= 3; $i++){
          echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
        } 
        echo "<div class=\"t-dot-pages\"> ... </div>";
        
        if($_POST["page-number"]-2 > 3 && $_POST["page-number"]+2 < $pages-2){
          // here the current page number can be set as the mid point
          for($i = $_POST["page-number"]-2; $i < $_POST["page-number"]-2+5; $i++){
            echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
          }
        } else {
          // here the current page number can not be set as the mid point
          // which loc? near start or end?
          if($_POST["page-number"] <= 3+2){
            $itt = 3+1;
            for($i = $itt; $i < $itt+5; $i++){
              echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
            }
          } else if($_POST["page-number"] >= ($pages-2)-2){
            $itt = $pages-7;
            for($i = $itt; $i < $itt+5; $i++){
              echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
            }
          }
        }
        echo "<div class=\"t-dot-pages\"> ... </div>";
        for($i = $pages-2; $i <= $pages; $i++){
          echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
        }
      }
      
    // initial display (no POST page-number retreived)
    } else if(!isset($_POST["page-number"])){
      // highlight page number 1
      echo "<style type=\"text/css\">
          #pb-1{
            border-style: solid;
            border-color: red;
          }
          </style>";

      for($i = 1; $i <= 3; $i++){
        echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
      }
      echo "<div class=\"t-dot-pages\"> ... </div>";
      for($i = $pages-2; $i <= $pages; $i++){
        echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
      }
    } // this following is when the amount is less than 11 (the minimum pages requirement)
  } else{
    // highlight the current page if $_POST["page-number"] exists, hightlight page 1 if doesn't
    if(isset($_POST["page-number"])){
      // highlight the current page-number
      echo "<style type=\"text/css\">
          #pb-".$_POST["page-number"]."{
            border-style: solid;
            border-color: red;
          }
          </style>";
    } else{
      // highlight page number 1
      echo "<style type=\"text/css\">
          #pb-1{
            border-style: solid;
            border-color: red;
          }
          </style>";
    }
    for($i = 1; $i <= $pages; $i++){
      echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
    }
  }
?>