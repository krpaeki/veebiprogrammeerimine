<?php
  require("functions.php");
  //kui pole sisse loginud
  
  if(!isset($_SESSION["userId"])){
	  header("Location: index.php");
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: index.php");
	  exit();
  }
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Pealeht</title>
  </head>
  <body>
    <h1>Pealeht</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Olete sisse loginud nimega: <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?>. <b><a href="?logout=1">Logi välja!</a></b></p>
	<ul>
	  <li>Valideeri anonüümseid <a href="validatemsg.php">Sõnumeid</a></li>
	  <li><a href="users.php">Süsteemi kasutajad</a>.</li>
	  <li><a href="validatedmessages.php"> Valideeritud sõnumid kasutajate kaupa</a>.</li>
	  <li><a href="userprofile.php"> Kasutajaprofiil</a>.</li>
	</ul>
	
  </body>
</html>