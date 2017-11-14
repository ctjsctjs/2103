<section class="adv-search-cont">
  <div class="adv-search-inner">
    <form role="form" autocomplete="off" action="advancedSearch_result.php" method="POST">
      <input type="text" class="form" placeholder="Enter a food establishment or carpark" name="search">
      <div class="slider-wrappper">
        <div class="slidecontainer">
          <input name="radius" type="range" min="50" max="500" value="50" class="slider" id="radius">
          <p>Value: <span id="radius-output"></span></p>
        </div>
        <div class="slidecontainer" id="slidecontainer2 minimum-carparks">
          <input name="minCarpark" type="range" min="1" max="10" value="1" class="slider" id="minCarpark">
          <p>Value: <span id="minCarpark-output"></span></p>
        </div>
        <div class="slidecontainer" id="minimum-lots">
          <input name="minLots" type="range" min="1" max="100" value="1" class="slider" id="minLots">
          <p>Value: <span id="minLots-output"></span></p>
        </div>
      </form>
    </div>
  </div>
</section>
