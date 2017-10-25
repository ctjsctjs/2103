<nav class="nav">
  <div class="center">
    <ul class="nav-center">
      <li>
        <a href="#">Carpark</a>
      </li>
      <li>
        <a class="" href="#">Food Establishment</a>
      </li>
      <li>
        <a class="" href="#">Favourites</a>
      </li>
    </ul>
  </div>
  <div class="container-responsive">
    <a href="index.php"><img class="nav-logo ease"src="images/logo.svg"></a>

    <ul class="nav-right">
      <li id="nav-profile">
        <a href="#" class="">Hi <?php echo $_SESSION['FIRSTNAME']?>,</a>
      </li>
      <li>
        <form action="protected/logout_validation.php" method="POST">
          <button class="button button-red" name="submit" type="submit">Logout</button>
        </form>

      </li>
    </ul>
  </div>
</nav>
<div class="nav-push"></div>
</header>