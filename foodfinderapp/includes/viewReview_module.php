<div class="res-left-mod review-wrapper" id="viewReviews">
  <span class='res-food-subheader'><?php echo $numofreview?> Reviews</span>
  <?php
  $showReview = "SELECT firstName, lastName, AvgRating, reviewResponse FROM user INNER JOIN review ON user.userId = review.userId WHERE review.foodEstablishmentId=".$_GET['foodEstablishmentId'];
  if ($result1 = mysqli_query($conn, $showReview) or die(mysqli_connect_error)) {
    $rowcount1 = mysqli_num_rows($result1);
    if ($rowcount1 > 0) {
      //for ($i = 0; $i < $rowcount1; $i++) {
      while($rowReview = mysqli_fetch_assoc($result1)){
        //$rowReview = mysqli_fetch_array($result1, MYSQLI_NUM);
        echo "<div class='demo-table review-row'>"
        ."<span class='review-name'>".$rowReview['firstName']." ".$rowReview['lastName']."</span>";

        echo "<ul class='star-row'>";
        for($i=1;$i<=5;$i++) {
          echo '<input type="hidden" name="rating" id="rating"/>';
          $selected = "";
          if(!empty($rowReview['AvgRating']) && $i<=$rowReview['AvgRating']) {
            $selected = "selected";
          }
          echo '<li class="'.$selected.'">&#9733;</li>';
        }
        echo "</ul>";

        echo '<div class="review-text">'.$rowReview['reviewResponse'].'</div>';
        echo "</div>";
      }
    }
    else{
      echo "<span class='res-empty'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> There are no reviews yet.</span>";
    }
  }
  ?>
</div>
