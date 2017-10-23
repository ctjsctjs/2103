<nav class="navbar navbar-light navbar-expand-md bg-faded justify-content-center">
  <a href="" class="navbar-brand d-flex w-50 mr-auto">FoodApp</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-collapse collapse" id="collapsingNavbar3">
    <ul class="navbar-nav mx-auto w-100 justify-content-center">
      <li class="nav-item">
        <a class="nav-link" href="viewAllCarparks.php">Carpark</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="viewAllFood.php">Food Establishment</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Favourites</a>
      </li>
    </ul>
    <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
      <li class="nav-item">
        <a class="nav-link active">Hi <?php echo $_SESSION['FIRSTNAME']?>,</a>
      </li>
      <li class="nav-item">
        <form action="protected/logout_validation.php" method="POST">
          <button class="btn btn-outline-dark my-2 my-sm-0" name="submit" type="submit">Logout</a>
        </form>

      </li>
    </ul>
  </div>
</nav>
</header>
