<?php

	// For localhost
	//$dbServer = "localhost";

	// For Alicloud
	$dbServer = "localhost";

	$dbUserName = "root";

	// For localhost
	$dbPassword = "";

	// For Alicloud
	//$dbPassword = "foobar123!";

	$dbName = "foodfinderapp";

	$googleKey = 'AIzaSyA7yo2mB_XCwyyrg0j43lduD5iXK6zbdnY';
	$datamallKey = 'SFHPvNC5RP+jFTzftMxxFQ==';

	$conn = mysqli_connect($dbServer, $dbUserName, $dbPassword, $dbName);
