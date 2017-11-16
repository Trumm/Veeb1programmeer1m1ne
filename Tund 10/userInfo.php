<?php 
	//Et pääseks ligi sessioonile
	require("functions.php");
	require("usertables.php");
	
	//Kui pole sisseloginud, liigume login lehele
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}

	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Edgar Johannes Trumm</title>
</head>

<body> 
	<h1>Foto</h1>
	<h1><?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?> </h1>
	<br>
	<br>
	<?php generateUserTable(); ?>
	<p><a href="?logout=1">Logi välja!</a></p>
	<p><a href="main.php">Pealehele</a></p>
</body>
</html>