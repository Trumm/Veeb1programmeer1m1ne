<?php
	require("../../../config.php");
	$database = "if17_edgar";
	$gender= "";
	$test = "asdsadasdasd";
	function generateUserTable(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, firstname, lastname, birthday, gender, email, password FROM VPUSERS");
		$stmt->bind_result($id, $firstNameFromDb, $lastNameFromDb, $birthdayFromDb, $genderFromDb, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		echo "<select name='language'>";
		echo '<option value="" selected disabled>keel</option>';
		while($stmt->fetch()){
			echo "<tr>";
				echo "<th>" . $firstNameFromDb ."</th>" . "<th>" . $lastNameFromDb ."</th>" . "<th>" . $birthdayFromDb ."</th>" . "<th>" . $gender ."</th>" ."<th>" . $emailFromDb ."</th>";
			echo "</tr>";
		}
		echo "</table>";
	}
?>