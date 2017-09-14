<?php
//muutujad
$myName = "Edgar Johannes";
$myFamilyName = "Trumm";
//hindan päeva osa võrdlemine ( > < >= <= == != )
$hourNow = date("H");
$partofDay = "";
if ($hourNow < 8){$partofDay = "varajane hommik";}
if ($hourNow >= 8 and $hourNow < 16){$partofDay = "koolipäev";}
if ($hourNow >16){$partofDay = "vaba aeg";}
//echo $partofDay
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
echo date("d.m.Y") .", kell oli lehe avamise hetkel " .date("H:i:s");
echo ", hetkel on" .$partofDay .".</p>";
   ?>
   
   
 </body>
</html>