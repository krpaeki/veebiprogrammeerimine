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
  
  $notice = readallunvalidatedmessages();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Anonüümsed sõnumid</title>
</head>
<body>
  <h1>Sõnumid</h1>
  <p>Siin on minu <a href="http://www.tlu.ee">TLÜ</a> õppetöö raames valminud veebilehed. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet. <a href="?logout=1">Logi välja!</a></p>
  <hr>
  <ul>
	
  </ul>
  <hr>
  
  <?php echo $notice; ?>

</body>
</html>