<?php
//muutujad
$myName = "Edgar Johannes";
$myFamilyName = "Trumm";
$picDir = "../../Pics/";
$picFiles = [];
$picFileTypes = ["jpg", "jpeg", "pmg", "gif", "JPG"];
$allFiles = array_slice (scandir($picDir), 2);
foreach ($allFiles as $file){
	$fileType = pathinfo($file, PATHINFO_EXTENSION);
	if (in_array($fileType, $picFileTypes) == true){
		array_push($picFiles, $file);
	}
}//foreach lõppeb
//var_dump($allFiles);
//$picFiles = array_slice($allFiles, 2);
//var_dump($picFiles)
$picFileCount = count($picFiles);
$picNumber = mt_rand(0, $picFileCount - 1);
$picFile = $picFiles[$picNumber];
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Edgar Johannes Trumm</title>
</head>
 <body>
   <h1><?php echo $myName ." " .$myFamilyName; ?></h1>
   <p>Ei sisalda mingisugust tõsiseltvõetavat sisu.</p>
   <img src="<?php echo $picDir .$picFile; ?>" alt="Photoshop pildid">
 </body>
</html>