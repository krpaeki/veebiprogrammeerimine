<?php
	//echo "Tataaaa";
	
	$name = "Tundmatu";
	$surname = "inimene";
	$fullName = $name ." " .$surname;
	$birthMonth = date("m");
	$birthYear = date("Y") - 15;
	$birthDay = date("d");
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
	
	//var_dump($_POST);
	
	if (isset($_POST["firstName"])){
		//$name = $_POST["firstName"];
		$name = test_input($_POST["firstName"]);
	}
	if (isset($_POST["surName"])){
		//$surname = $_POST["surName"];
		$surname = test_input($_POST["surName"]);
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
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Eesnimi:</label>
	<input name="firstName" type="text" value=""><br>
	<label>Perekonnanimi:</label>
	<input name="surName" type="text" value=""><br>
	
	<label>Sünnipäev: </label>
	  <?php
	    echo '<select name="birthDay">' ."\n";
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
	  <!--<input name="birthYear" type="number" min="1914" max="2003" value="1998">-->
	  <?php
	    echo '<select name="birthYear">' ."\n";
		for ($i = $birthYear; $i >= date("Y") - 100; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthYear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
		?>
	<input name="submitUserData" type="submit" value="Saada andmed">
	</form>
	
	<?php
		if (isset($_POST["submitUserData"])){
			//demoks väike funktsioon, mis on mõtetu
			
			echo "<br><p>Olete elanud järgnevatel aastatel:</p>";
			echo "<ul> \n";
			for ($i = $_POST["birthYear"]; $i <= date("Y"); $i++){
				echo "<li>" . $i ."</li> \n";
			}
			echo "</ul> \n";
		}
	?>
	
</body>
</html>
