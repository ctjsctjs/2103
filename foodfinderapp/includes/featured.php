<?php

$sql = "SELECT foodEstablishmentId, image, name FROM foodestablishment WHERE foodEstablishmentId IN
(SELECT foodEstablishmentId FROM review GROUP BY foodEstablishmentId ORDER BY AVG(AvgRating) DESC) LIMIT 3";
$result = mysqli_query($conn, $sql);
if ($result) {
  if (mysqli_num_rows($result) > 0) {
    echo '<ul id="res-food-cont">';
    while($row = mysqli_fetch_assoc($result)) {

      /*EACH FOOD INSTANCE*/
      echo '<li class="res-row-food">';
      echo '<a class="res-food-img" href="restaurant.php?foodEstablishmentId='.$row["foodEstablishmentId"].'">';
      echo '<img src=images/'. $row['image'] .'>';
      echo '</a>';
      echo "<div class='res-food'>";
      echo '<a class="results-header hide-overflow" href="restaurant.php?foodEstablishmentId='.$row["foodEstablishmentId"].'">' . $row["name"] . '</a>';
      echo "<span class='res-food-subheader'>Nearest Carpark</span>";
      echo "<a class='res-more' href='restaurant.php?foodEstablishmentId=".$row['foodEstablishmentId']."'>View more <i class='fa fa-caret-right' aria-hidden='true'></i></a>";
      echo "</div>";
    }
    echo "</li>";
  }
  echo '</ul>';
}

?>
