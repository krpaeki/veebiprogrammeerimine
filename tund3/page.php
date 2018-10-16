<?php
	//echo "Tataaaa";
	
	$name = "Tundmatu";
	$surname = "inimene";
	
	//var_dump($_POST);
	if (isset($_POST["firstName"])){
			$name = $_POST["firstName"];
	}
	if (isset($_POST["surName"])){
			$surname = $_POST["surName"];
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
	<h1>HEHEHHEHEHEeee</h1>
	<p>Siin on minu õppetöö raames tehtud veebilehed. Need ei oma mingit tähtsust ja kopeerimisel pole mõtet.</p>
	<hr>
	
	<form method="POST"
	<label>Eesnimi:</label>
	<input name="firstName" type="text" value=""><br>
	<label>Perekonnanimi:</label>
	<input name="surName" type="text" value=""><br>
	<label>Sünniaasta:</label>
	<input name="birthYear" type="number" min="1924" max="2003" value="1992"><br>
	<input name="submitUserData" type="submit" value="Saada andmed">
	</form>
	
	<?php
		if (isset($_POST["submitUserData"])){
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
