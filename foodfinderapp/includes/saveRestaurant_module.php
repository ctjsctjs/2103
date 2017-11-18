<div class="res-right-mod-wrap" id="saveFav">
  <?php
  $userID = $_SESSION['ID'];
  if (isset($_POST['saveFood']) == 'save'.$foodID){
    $insert = "INSERT INTO favouritefood(foodestablishmentid, userid, status)
    VALUES  ($foodID,$userID , '1')";
    if ($conn->query($insert) === TRUE) {
      echo "<span class='res-saved'><i class='fa fa-check' aria-hidden='true'></i> Added to favourites</span>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  echo "<form method='post' action='restaurant.php?foodEstablishmentId=".$foodID."' id='form' name='form'>"
  . "<input type='hidden' name='saveFood' value='save".$foodID."'>"
  . "<button class='button button-red button-wide' id='btn-save'>Save</button>"
  . "</form>";
  ?>
</div>
