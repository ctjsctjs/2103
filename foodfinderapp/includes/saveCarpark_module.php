<div class="res-right-mod-wrap">
  <?php
  $userID = $_SESSION['ID'];
  if (isset($_POST['saveFood']) == 'save'.$carparkID){
    $insert = "INSERT INTO favouriteCarpark(carparkId, userId, status)
    VALUES  ($carparkID,$userID , '1')";
    if ($conn->query($insert) === TRUE) {
      echo "<span class='res-saved'><i class='fa fa-check' aria-hidden='true'></i> Added to favourites</span>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  echo "<form method='post' action='carpark.php?carparkId=".$carparkID."' id='form' name='form'>"
  . "<input type='hidden' name='saveFood' value='save".$carparkID."'>"
  . "<button class='button button-red button-wide' id='btn-save'>Save</button>"
  . "</form>";
  ?>
</div>
