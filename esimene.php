<?php
//muutujad
$myName = "Edgar Johannes";
$myFamilyName = "Trumm";
$monthNamesEt=["jaanuar", "veebruar", "m�rts", "aprill", "mai", "juuni", "juuli", "august",
"september", "oktoober", "november", "detsember"];
//var_dump($monthNamesEt);
//echo $monthNamesEt [3];
$monthNow=$monthNamesEt[date("n")-1];
//hindan päeva osa võrdlemine ( > < >= <= == != )
$hourNow = date("H");
$partofDay = "";
if ($hourNow < 8){$partofDay = "varajane hommik";}
if ($hourNow >= 8 and $hourNow < 16){$partofDay = "koolipäev";}
if ($hourNow >16){$partofDay = "vaba aeg";}
//echo $partofDay
//vanusega tegelemine
//var_dump($_POST);
//echo $_POST["birthYear"];
$mybirthYear;
if ( isset($_POST["birthYear"]) and $_POST["birthYear"] !=0){
	$myAge = date("Y") - $_POST["birthYear"];
	$mybirthYear = $_POST["birthYear"];
	$ageNotice = "<p>Te olete umbkaudu " .$myAge ." aastat vana.</p>";
	$ageNotice .= "<p>Olete elanud j�rgnevatel aastatel:</p> <ol>";
	for ($i = $mybirthYear; $i <= date("Y"); $i++){
	$ageNotice .="<li>" .$i ."</li>";
	}
	 $ageNotice .= "</ol>";
	}
	/*for ($i = 0; $i < 5; $i ++){
		echo "ho";
	}*/
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
   <?php
echo "<p>Algas PHP õppimine</p>";
echo "<p>Täna on ";
echo date("d. ") .$monthNow .date(" Y") .", kell oli lehe avamise hetkel " .date("H:i:s");
echo ", hetkel on " .$partofDay .".</p>";
   ?>
	<h2>Natuke vanusest</h2>
	<form method="POST">
	<label>Teie s�nniaasta</label>
	<input name="birthYear" id="birthYear" type="number" value="<?php echo $mybirthYear; ?>" min="1900" max="2017">
	<input name="sumbitbirthYear" type="submit" value="Sisesta">
	</form>
   <?php
   if($ageNotice != ""){
	   echo $ageNotice;
   }
   ?>
 </body>
</html>