<?php include_once 'includes/header.php' ?>

<?php
  if(isset($_SESSION['FIRSTNAME']))
    include_once 'includes/nav_user.php';
else
  include_once 'includes/nav_index.php';
?>

<script>
var slider1 = document.getElementById("radius");
var output1 = document.getElementById("radius-output");
output1.innerHTML = slider1.value;
slider1.oninput = function() {
  output1.innerHTML = this.value;
}

var slider2 = document.getElementById("minLots");
var output2 = document.getElementById("minLots-output");
output2.innerHTML = slider2.value;
slider2.oninput = function() {
  output2.innerHTML = this.value;
}

var slider3 = document.getElementById("minCarpark");
var output3 = document.getElementById("minCarpark-output");
output3.innerHTML = slider3.value;
slider3.oninput = function() {
  output3.innerHTML = this.value;
}
</script>
