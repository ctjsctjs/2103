<?php

	// For localhost
	//$dbServer = "localhost";

	// For Alicloud
	$dbServer = "47.74.176.36";

	$dbUserName = "root";

	// For localhost
	//$dbPassword = "";

	// For Alicloud
	$dbPassword = "foobar123!";

	$dbName = "foodfinderapp";
	
	$googleKey = 'AIzaSyDbEqIHfTZwLD9cgm9-elubEhOCm7_C3VE';
	$datamallKey = 'SFHPvNC5RP+jFTzftMxxFQ==';

	$conn = mysqli_connect($dbServer, $dbUserName, $dbPassword, $dbName);