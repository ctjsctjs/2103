<nav class="nav" id="nav-user">
  <div class="nav-centerlinks">
    <ul class="nav-center">
      <li><a href="viewAllCarparks.php">Carpark</a></li>
      <li><a href="viewAllFood.php">Food Establishment</a></li>
      <li><a href="#">Favourites</a></li>
      <li><a class="modal-advSearchBtn">Advanced Search</a></li>
      <li id="nav-mobile-logout">
        <form action="protected/logout_validation.php" method="POST">
          <button class="nav-logout-link" name="submit" type="submit">Logout</button>
        </form>
      </li>
      </ul>
    </div>
    <div class="container-responsive">
      <a href="index.php"><img class="nav-logo ease"src="images/logo.svg"></a>
      <div class="nav-right">
        <i class="fa fa-bars" aria-hidden="true" id="nav-hamburger"></i>
        <form action="protected/logout_validation.php" method="POST">
          <button class="button button-red nav-logout" name="submit" type="submit">Logout</button>
        </form>
      </div>
    </div>
  </nav>
  <div class="nav-push"></div>
  <section class="modal">
    <div class="modal-container" id="modal-advSearch">
      <form class="form" role="form" autocomplete="off" action="advancedSearch_result.php" method="POST">
        <div class="main-row">
          <input type="text" class="main-form" placeholder="Enter a food establishment or carpark" name="search">
          <button type ="submit" class="main-button"><i class="fa fa-search" aria-hidden="true"></i>
          </button>
        </div>
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
  </section>
</header>
