<?php
  require("functions.php");
  require("header.php");
  //kui pole sisse loginud
  if(!isset($_SESSION["userId"])){
	  header("Location: index.php");
	  exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	session_destroy();
	header("Location: index.php");
	exit();
  }
  
  //$publicThumbnail = readAllPublicPictureThumbs();
  $publicThumbnail = readAllPublicPictureThumbsPage();
  
  $userslist = listusers();
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>
	  <?php
	    echo $_SESSION["userName"];
		echo " ";
		echo $_SESSION["userSurname"];
	  ?>
	, õppetöö</title>
  </head>
  <body>
    <h1>
	  <?php
	    echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"];
	  ?>
	</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<ul>
	  <li><a href="?logout=1">Logi välja</a>!</li>
	  <li><a href="main.php">Tagasi pealehele</a></li>
	</ul>
	<hr>
	<?php echo $publicThumbnail; ?>
	
  </body>
</html>