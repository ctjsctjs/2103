<nav class="nav">
  <a href="index.php"><img class="nav-logo ease"src="images/logo.svg"></a>
  <div class="center">
    <ul class="nav-left">
      <li>
        <a href="#">Carpark</a>
      </li>
      <li>
        <a class="" href="#">Food Establishment</a>
      </li>
      <li>
        <a class="" href="#">Favourites</a>
      </li>
    </ul></div>
  <ul class="nav-right">
    <li id="nav-profile">
      <a href="#" class="">Hi <?php echo $_SESSION['FIRSTNAME']?>,</a>
    </li>
    <li>
      <form action="protected/logout_validation.php" method="POST">
        <button class="button button-red" name="submit" type="submit">Logout</a>
      </form>

    </li>
  </ul>
</nav>
<div class="nav-push"></div>
</header>