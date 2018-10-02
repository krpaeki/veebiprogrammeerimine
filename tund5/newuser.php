<?php
	//echo "Tataaaa";
	
	require ("functions.php");
	
	$name = "";
	$surname = "";
	$email = "";
	$gender = "";
	$birthMonth = null;
	$birthYear = null;
	$birthDay = null;
	$birthDate = null;
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
	
	//muutujad võimalike veateadetega
	$nameError = "";
	$surnameError = "";
	$birthMonthError = "";
	$birthYearError = "";
	$birthDayError = "";
	$genderError = "";
	$emailError = "";
	$passwordError = "";
	
	//kui on uue kasutaja loomise nuppu vajutatud
	if(isset($_POST["submitUserData"])){
	
		if (isset($_POST["firstName"]) and !empty($_POST["firstName"])){
			//$name = $_POST["firstName"];
			$name = test_input($_POST["firstName"]);
		}	else {
			$nameError = "#Palun sisesta eesnimi!";
		}
		if (isset($_POST["surname"]) and !empty($_POST["surname"])){
			//$surname = $_POST["surname"];
			$surname = test_input($_POST["surname"]);
		}	else {
				$surnameError = "#Palun sisesta perenimi!";
		}
		
		if(isset($_POST["gender"])){
		$gender = intval($_POST["gender"]);
		} else {
		  $genderError = "#Palun märgi sugu!";
		}
		
		//kontrollime sünnipäeva õigsust
		if(isset($_POST["birthDay"])) {
			$birthDay = $_POST["birthDay"];
		}
		if(isset($_POST["birthMonth"])) {
			$birthMonth = $_POST["birthMonth"];
		}
		if(isset($_POST["birthYear"])) {
			$birthYear = $_POST["birthYear"];
		}
		
		if(isset($_POST["birthDay"]) and isset($_POST["birthMonth"]) and isset($_POST["birthYear"])){
			if(checkdate(intval($_POST["birthDay"]), intval($_POST["birthMonth"]), intval($_POST["birthYear"]))){
				$birthDate = date_create($_POST["birthMonth"] ."/" .$_POST["birthDay"] ."/" .$_POST["birthYear"]);
				$birthDate = date_format($birthDate, "Y-m-d");
				echo $birthDate;
			} else {
				$birthYearError = "Kuupäev on vigane";
			}
		}
	if(empty($nameError) and empty($surnameError) and empty($birthMonthError) and empty($birthYearError) and empty($birthDayError) and empty($genderError)and empty($emailError) and empty($passwordError)){
		$notice = signup($name, $surname, $email, $gender, $birthDate, $_POST["password"]);
		echo $notice;
	}
	
	}
	
	
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	function fullName() {
	$GLOBALS["fullName"] = $GLOBALS["name"] . " " .$GLOBALS["surName"];
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		<?php
		echo $name;
		echo " ";
		echo $surname;
		?>
	</title>
</head>
<body>
	<h1>
	 <?php
	    echo $name ." " .$surname;
	  ?>
	</h1>
	<p>Siin on minu õppetöö raames tehtud veebilehed. Need ei oma mingit tähtsust ja kopeerimisel pole mõtet.</p>
	<p>Loome testkasutaja konto</p>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Eesnimi:</label>
	<input name="firstName" type="text" value="<?php echo $name; ?>"><span><?php echo $nameError;
		?></span><br>
	<label>Perekonnanimi:</label>
	<input name="surname" type="text" value="<?php echo $surname; ?>"><span><?php echo $surnameError;?></span><br>
		
	<input type="radio" name="gender" value="2"<?php if($gender == "2") { echo " checked";	}?>><label>Naine</label>
	<input type="radio" name="gender" value="1"<?php if($gender == "2") { echo " checked";	}?>><label>Mees</label>
	<span><?php echo $genderError;
		?></span><br>
	
	 <label>Sünnipäev: </label>
	  <?php
	    echo '<select name="birthDay">' ."\n";
		echo '<option value="" selected disabled>päev</option>' ."\n";
		for ($i = 1; $i < 32; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthDay){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label>Sünnikuu: </label>
	  <?php
	    echo '<select name="birthMonth">' ."\n";
		echo '<option value="" selected disabled>kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthMonth){
				echo " selected ";
			}
			echo ">" .$monthNamesET[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label>Sünniaasta: </label>
	  <?php
	    echo '<select name="birthYear">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") -15; $i >= date("Y") - 100; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthYear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
		?><br>
		
		<label>E-mail (kasutajatunnus):</label><br>
		<input type="email" name="email"><span><?php echo $emailError;
		?></span><br>
		
		<label>Salasõna:</label>
		<input name="password" type="text" value=""><span><?php echo $passwordError;
		?></span><br>
		
	<input name="submitUserData" type="submit" value="Loo kasutaja">
	</form>
	
	
</body>
</html>
