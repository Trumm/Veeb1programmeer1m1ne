<?php
	require("../../../config.php");
	require("functions.php");
	//echo $serverHost;
	//kui on sisselogitud, siis pealehele
	if(isset($_SESSION["userId"])){
			header("Locatuon: main.php");
			exit();
	}
	$signupFirstName = "";
	$signupFamilyName = "";
	$signupEmail = "";
	$gender = "";
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	$loginEmail = "";
	$notice = "";
	//vigade muutujad
	$signupFirstNameError = "";
	$signupFamilyNameError = "";
	$signupBirthDayError = "";
	$signupGenderError = "";
	$signupEmailError = "";
	$signupPasswordError = "";
	$loginEmailError = ""; 
	//kas klõpsati sisselogimise nuppu
	if(isset($_POST["signinButton"])){
	//kas on kasutajanimi sisestatud
	if (isset($_POST["loginEmail"])){
		if (empty ($_POST["loginEmail"])){
			$loginEmailError ="NB! Sisselogimiseks on vajalik kasutajatunnus (e-posti aadress)!";
		} else {
			$loginEmail = $_POST["loginEmail"];
		}
	}
	if(!empty($loginEmail) and !empty($_POST["loginPassword"])){
			//echo "Logime sisse!";
			$notice = signIn($loginEmail, $POST["loginPassword"]);
	}
	}//kas sisselogimine lõppeb
	//kas luuakse uut kasutajat, vajutati nuppu
	if(isset($_POST["signupButton"])){
	//kontrollime, kas kirjutati eesnimi
	if (isset($_POST["signupFirstName"])){
			if (empty ($_POST["signupFirstName"])){
					$signupFirstNameError ="NB! Väli on kohustuslik!";
			} else {
					$signupFirstName = test_input($_POST["signupFirstName"]);
			}
	}
	
	//kontrollime, kas kirjutati perekonnanimi
	if (isset($_POST["signupFamilyName"])){
			if (empty ($_POST["signupFamilyName"])){
					$signupFamilyNameError ="NB! Väli on kohustuslik!";
			} else {
				$signupFamilyName = test_input($_POST["signupFamilyName"]);
			}
	}
	//kas päev on sisestatud
	if (isset($_POST["signupBirthDay"])){
			$signupBirthDay = $_POST["signupBirthDay"];
			//echo $signupBirthDay;
	} else {
			$signupBirthDayError = "Kuupäeva pole sisestatud!";	
	}
	//Kas kuu on sisestatud
	if(isset($_POST["signupBirthMonth"])){
		$signupBirthMonth = intval($_POST["signupBirthMonth"]);
	} else {
			$signupBirthDayError .= " Kuu pole sisestatud!";
	}
	//kas sünniaasta on sisestatud
	if (isset($_POST["signupBirthYear"])){
		$signupBirthYear = $_POST["signupBirthYear"];
		//echo $signupBirthYear;
	} else {
			$signupBirthDayError .= "Aasta pole sisestatud!";
	}
	//kontrollime, kas sisestatud kuupäev on valiidne
	if (isset($_POST["signupBirthDay"]) and isset($_POST["signupBirthMonth"]) and isset ($_POST["signupBirthYear"])){
		if (checkdate(intval($_POST["signupBirthMonth"]), intval($_POST["signupBirthDay"]),intval($_POST["signupBirthYear"]))){
			$birthDate = date_create($_POST["signupBirthMonth"] ."/" .$_POST["signupBirthDay"] ."/" .$_POST["signupBirthYear"]);
			$signupBirthDate = date_format($birthDate, "Y-m-d");
			//echo $signupBirthDate;
		} else {
				$signupBirthDayError = "Sünnikuupäev ei ole valiidne!";
		}
	}
	//kontrollime, kas kirjutati kasutajanimeks email
	if (isset($_POST["signupEmail"])){
		if (empty ($_POST["signupEmail"])){
				$signupEmailError ="NB! Väli on kohustuslik!";
		} else {
			$signupEmail = test_input($_POST["signupEmail"]);
			$signupEmail = filter_var($signupEmail, FILTER_SANITIZE_EMAIL);
			$signupEmail = filter_var($signupEmail, FILTER_SANITIZE_EMAIL);
		}
	}
	
	if (isset($_POST["signupPassword"])){
		if (empty ($_POST["signupPassword"])){
				$signupPasswordError = "NB! Väli on kohustuslik!";
		} else {
			//polnud tühi
			if (strlen($_POST["signupPassword"]) < 8){
					$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			}
		}
	}
	
	if (isset($_POST["gender"]) && !empty($_POST["gender"])){ //kui on määratud ja pole tühi
			$gender = intval($_POST["gender"]);
		} else {
				$signupGenderError = " (Palun vali sobiv!) Määramata!";
		}	
		
	//UUE KASUTAJA LISAMINE ANDMEBAASI
	if (empty($signupFirstNameError) and empty($signupFamilyNameError) and empty($signupBirthDayError) and empty($signupGenderError) and empty($signupEmailError) and empty($signupPasswordError) and !empty($_POST["signupPassword"])){
		echo "Hakkan andmeid salvestama!";
		$signupPassword = hash("sha512", $_POST["signupPassword"]);
		//ühendus serveriga
		$database = "if17_edgar";
		$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
		//käsk serverile
		$stmt = $mysqli->prepare("INSERT INTO VPUSERS(firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//s - string ehk tekst
		//i - integer ehk täisarv
		//d - decimal, ujukomaarv
		$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		//$stmt->execute();
		if($stmt->execute()){
			echo "Läks väga hästi";
		} else {
			echo "Tekkis viga: " .$stmt->error;
		}
	}
		
	//Tekitame kuupäeva valiku
	$signupDaySelectHTML = "";
	$signupDaySelectHTML .= '<select name="signupBirthDay">' ."\n";
	$signupDaySelectHTML .= '<option value="" selected disabled>päev</option>' ."\n";
	for ($i = 1; $i < 32; $i ++){
		if($i == $signupBirthDay){
			$signupDaySelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupDaySelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ." \n";
		}
	}
	$signupDaySelectHTML.= "</select> \n";
	//tekian sünnikuu valiku
	$monthNamesEt=["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august",
	"september", "oktoober", "november", "detsember"];
	$signupMonthSelectHTML = "";
	$signupMonthSelectHTML .= '<select name="signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .= '<option value="" selected disabled>kuu</option>' . "\n";
	foreach($monthNamesEt as $key=>$month){
		if($key + 1 === $signupBirthMonth){
			$signupMonthSelectHTML .='<option value="' .($key + 1) .'" selected>' .$month ."</option> \n";
		} else {
			$signupMonthSelectHTML .='<option value="' .($key + 1) .'">' .$month ."</option> \n";
		}
	}
	$signupMonthSelectHTML .= "</select> \n";
	//Tekitame aasta valiku
	$signupYearSelectHTML = "";
	$signupYearSelectHTML .= '<select name="signupBirthYear">' ."\n";
	$signupYearSelectHTML .= '<option value="" selected disabled>aasta</option>' ."\n";
	$yearNow = date("Y");
	for ($i = ($yearNow - 10); $i > 1900; $i --){
		if($i == $signupBirthYear){
			$signupYearSelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupYearSelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ."\n";
		}
	}
	$signupYearSelectHTML.= "</select> \n";
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Sisselogimine või uue kasutaja loomine</title>
</head>
<body>
	<h1>Heade mõtete veeb<h1>
	<p>Värskeim hea mõte: <span><?php echo latestIdea(); ?></span></p>
	<h2>Logi sisse!</h2>
	<p>Siin harjutame sisselogimise funktsionaalsust.</p>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Kasutajanimi (E-post): </label>
		<input name="loginEmail" type="email" value="<?php echo $loginEmail; ?>"><span><?php echo $loginEmailError; ?></span>
		<br><br>
		<input name="loginPassword" placeholder="Salasõna" type="password"><span></span>
		<br><br>
		<input name="signupButton" type="submit" value="Logi sisse"><span><?php echo $notice; ?></span>
	</form>
	
	<h2>Loo kasutaja</h2>
	<p>Kui pole veel kasutajat....</p>
	
	<form method="POST" action"<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Eesnimi </label>
		<input name="signupFirstName" type="text" value="<?php echo $signupFirstName; ?>">
		<span><?php echo $signupFirstNameError; ?></span>
		<br>
		<label>Perekonnanimi </label>
		<input name="signupFamilyName" type="text" value="<?php echo $signupFamilyName; ?>">
		<span><?php echo $signupFamilyNameError; ?></span>
		<br>
		<label>Sisesta oma sünnikuupäev!</label>
		<?php
			echo $signupDaySelectHTML ."\n" .$signupMonthSelectHTML ."\n".$signupYearSelectHTML;
		?>
		<span><?php echo $signupBirthDayError; ?></span>
		<br><br>
		<label>Sugu</label>
		<br>
		<input type="radio" name="gender" value="1" <?php if ($gender == '1') {echo 'checked';} ?>><label>Mees</label> <!-- Kõik läbi POST'i on string!!! -->
		<input type="radio" name="gender" value="2" <?php if ($gender == '2') {echo 'checked';} ?>><label>Naine</label><span><?php echo $signupGenderError; ?></span>
		<br><br>
		
		<label>Kasutajanimi (E-post)</label>
		<input name="signupEmail" type="email" value="<?php echo $signupEmail; ?>">
		<span><?php echo $signupEmailError; ?></span>
		<br><br>
		<input name="signupPassword" placeholder="Salasõna" type="password">
		<span><?php echo $signupPasswordError; ?></span>
		<br><br>

		
		<input name="signupButton" type="submit" value="Loo kasutaja">
	</form>		
</body>
</html>