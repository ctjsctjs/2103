
<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/databaseconnection.php' ?>
<?php
if (isset($_SESSION['FIRSTNAME'])) {
  include_once 'includes/nav_user.php';
} else {
  include_once 'includes/nav_index.php';
}

if(isset($_GET['foodEstablishmentId'])) {

  // Editted SQL statement (Nizam)
  $foodID = $_GET['foodEstablishmentId'];
  $checkReview = "SELECT COUNT(*) FROM review WHERE review.foodEstablishmentId = ".$_GET['foodEstablishmentId']." AND review.userId = ".$_SESSION['ID'];

  $checkresult = mysqli_query($conn, $checkReview) or die(mysqli_connect_error());
  $checkrow = mysqli_fetch_array($checkresult);
  $check = $checkrow[0];

  $selectedFoodEstablishment = "SELECT name, address, RIGHT(address, 6) as postalcode,CAST(AVG(review.AvgRating) as decimal(18,1)), COUNT(review.AvgRating),foodestablishment.foodEstablishmentId FROM foodestablishment INNER JOIN review ON foodestablishment.foodestablishmentId = review.foodEstablishmentId WHERE foodestablishment.foodEstablishmentId = '".$_GET['foodEstablishmentId']."'";
  $result = mysqli_query($conn, $selectedFoodEstablishment) or die(mysqli_connect_error());
  $row = mysqli_fetch_array($result);
  $rating = $row[3];
  $numofreview = $row[4];
  //$restaurantID = $row[5];


}

?>
<section class="">
        <?php
        if($check == 0){
          $property = array("Quality","Cleaniness","Comfort","Ambience","Service");

          echo "<div>";
          echo "<form class='view-delete-form' role='form' method='POST' action='foodReview.php?foodEstablishmentId=".$_GET['foodEstablishmentId']."'>";


          for($i =0;$i<5;$i++){
            echo "<tr>";
            echo "<th>".$property[$i].": </th>";

            echo "<th><select name='p-".$property[$i]."' id='p-".$property[$i]."' style='width:100%'>";
            echo "<option value='-1'>--Select A Rating--</option>";
            for($y =1;$y<6;$y++){
              echo "<option value='".$y."'>".$y."</option>";
            }
            echo "</select></th></tr>";
          }
          echo "<span>Review</span><span><input style='height:50px; width: 100%; border: 1px solid #efefef;' ></span>";

          echo "<tr style='border-style: none;'><th style='border-style: none;'><input type='hidden' name='rate'></th>";
          echo "<th style='border-style: none;'><button class='button button-red'>Submit Rate</button></th></tr>";
          echo "</form></div>";

        }
        else{
          echo "</br>You have made a review for this restaurant";
        }

        ?>

        <?php
        if (isset($_POST['rate'])){
          $store = array();
          for($q =0;$q<5;$q++){
            if(isset($_POST['p-'.$property[$q]])){

              array_push($store, $_POST['p-'.$property[$q]]);

            }

          }
          if(in_array(-1, $store) || $_POST['reviewText'] == ""){
            echo "Please enter all field";

          }
          else{
            $response = $_POST['reviewText'];
            $queryTest = $store[0].','.$store[1].','.$store[2].','.$store[3].','.$store[4].'';
            $avgrating = array_sum($store)/5;
            $insert = "INSERT INTO review(quality,clean,comfort,ambience,service,AvgRating, reviewResponse,userId,foodEstablishmentId)
            VALUES  (".$queryTest.",".$avgrating.",'".$response."',".$_SESSION['ID'].",".$_GET['foodEstablishmentId'].")";

            if ($conn->query($insert) === TRUE) {

              echo "Added to new review";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
          }
          echo "<meta http-equiv='refresh' content='0;url=foodReview.php?foodEstablishmentId=".$_GET['foodEstablishmentId']."'>";
        }

        ?>

          <?php
          $showReview = "SELECT firstName, lastName, AvgRating, reviewResponse FROM user INNER JOIN review ON user.userId = review.userId WHERE review.foodEstablishmentId=".$_GET['foodEstablishmentId'];
          if ($result1 = mysqli_query($conn, $showReview) or die(mysqli_connect_error)) {
            $rowcount1 = mysqli_num_rows($result1);
            if ($rowcount1 > 0) {
              echo "</br><h2>Reviews</h2>";
              echo "<div class='demo-div'><tr><th>Name</th><th>Stars</th><th>Response</th></tr>";
              //for ($i = 0; $i < $rowcount1; $i++) {
              while($rowReview = mysqli_fetch_assoc($result1)){
                //$rowReview = mysqli_fetch_array($result1, MYSQLI_NUM);


                echo "";
                echo "<tr><th>".$rowReview['firstName']." ".$rowReview['lastName']."";
                echo "<th>";
                for($i=1;$i<=5;$i++) {
                  echo '<input type="hidden" name="rating" id="rating"/>';
                  $selected = "";
                  if(!empty($rowReview['AvgRating']) && $i<=$rowReview['AvgRating']) {
                    $selected = "selected";
                  }

                  echo '<li class="'.$selected.'">&#9733;</li>';
                }
                echo '</th>';
                echo '<th>'.$rowReview['reviewResponse'].'</th></tr>';
              }
              echo "</div>";
            }
            else{
              echo "No reviews";
            }
          }


          ?>

    </section>
