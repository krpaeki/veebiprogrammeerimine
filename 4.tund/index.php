<?php
	//echo "Tataaaa";
	
	$name = "Kristian";
	$surname = "Paekivi";
	
	$todaysDate = date("d.m.Y");
	$weekDayNow = date("N");
	$weekDayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	$hourNow = date("H");
	$partOfDay = "";
		if ($hourNow <8){
			$partOfDay = "varajane hommik";
		}
		if ($hourNow >=8 and $hourNow<16) {
			$partOfDay = "kooliaeg";
		}
		if ($hourNow >= 16) {
			$partOfDay = "vaba aeg";
		}
		
		//loosime juhusliku pildi
		$picNum = mt_rand(2,43);//random
		//echo $picNum;
		$picURL = "http://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
		$picEXT = ".jpg";
		$picFileName = $picURL .$picNum .$picEXT;
		//echo $picFileName;
		
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
	Intro</title>
	<style>
	
	img:hover {
		-webkit-filter: drop-shadow(8px 8px 10px green);
		filter: drop-shadow(8px 8px 10px green);}
	
	a {
		text-decoration: none;
		color: black;}
		
	a:link, a:visited {
		color: hotpink; }
	
	a:hover {
		color: black;}
	
	h2 {
		font-size: 15px;}
	
	</style>
</head>
<body>
	<h1>HEHEHHEHEHEeee</h1>
	<p>Siin on minu õppetöö raames tehtud veebilehed. Need ei oma mingit tähtsust ja kopeerimisel pole mõtet.</p>
	<?php
		echo "<p>Täna on " .$weekDayNamesET[$weekDayNow -1] .", " .$todaysDate,"</p>\n";
		echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .", käes on " ,$partOfDay .".</p> \n";
	?>
	<p>Lisan rea kodutöö eesmärgil</p>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames.</p>
	<p>Mul on ka sõber, kes teeb ka <a href="../../../~raimpre"> veebi</a></p>
	
	<h2><?php
		echo $name ," " ,$surname
	?>
	</h2>
	
	<img src="../../gnr2bnot2bin2bthis2blifetime.png" alt= "Gnr logo"
	> 
	
	<!--<img src="../../pildike.png" alt= "GnFnR" Height=300 width=300
	>-->
	<!--<img src="../http://www.gunsandrosestweettour.com/images/gnfr.svg" alt= "GnFnR" Height=300 width=300
	>-->
	<img src="<?php echo $picFileName; ?>" alt="juhuslik pilt TLÜ-st">
	<img src="papaaaa.jpg" alt= "GnR pilt">
	
</body>
</html>
