<?php
	//echo "Tataaaa";
	
	$name = "Kristian";
	$surname = "Paekivi";
	$dirToRead = "../../pics/";
	$allFiles = array_slice(scandir($dirToRead),2);
	
	
	
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
	<!--<img src="<?php echo $picFileName; ?>" alt="juhuslik pilt TLÜ-st"><br>-->
	
	<?php
		for ($i = 0; $i <count($allFiles); $i ++){
			echo '<img src="' .$dirToRead .$allFiles[$i] .'" alt="pilt"><br>';
		}
	?>
	
	
</body>
</html>
