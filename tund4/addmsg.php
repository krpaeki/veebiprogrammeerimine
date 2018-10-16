<?php
	require("functions.php");
	$notice = null;

	if (isset($_POST["submitMessage"])){
		if (!empty($_POST["message"])) {
			$notice = "sõnum olemas";
			$notice = saveAMsg($_POST["message"]); 
		} else {
			$notice = "Palun kirjutage sõnum";
		}
	}	
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sõnumi lisamine</title>
</head>
<body>
	<h1>Sõnumi lisamine</h1>
	<p>Siin on minu õppetöö raames tehtud veebilehed. Need ei oma mingit tähtsust ja kopeerimisel pole mõtet.</p>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Sõnum (max 256 märki):</label>
		<br>
		<textarea rows="4" cols="64" name="message" placeholder="Kirjuta siia oma sõnum ..."></textarea>
		<br>
		<input name="submitMessage" type="submit" value="Salvesta sõnum">
	</form>
	<br>
	<p>
	<?php
		echo $notice;
	?>
	</p>
	
	
</body>
</html>
