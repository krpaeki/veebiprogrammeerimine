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
  
  $page = 1;
  $totalImages = findTotalPublicImages();
  //echo $totalImages;
  $limit = 10;
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;
  } elseif (round(($_GET["page"] - 1) * $limit) > $totalImages){
	  $page = round($totalImages / $limit) - 1;
  } else {
	  $page = $_GET["page"];
  }
  //$publicThumbnails = readAllPublicPictureThumbs();
  $publicThumbnails = readAllPublicPictureThumbsPage($page, $limit);
  
  $pageTitle = "Pildigalerii";
  $scripts = '<link rel="stylesheet" type="text/css" href="style/modal.css">' ."\n" .'<script type="text/javascript" src="javascript/modal.js" defer></script>' ."\n" ;
  
  require("header.php");
  
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
	
	<!-- The Modal W3Schools eeskujul-->
	<div id="myModal" class="modal">
		<!-- The Close Button -->
		<span class="close">&times;</span>
		<!-- Modal Content (The Image) -->
		<img class="modal-content" id="modalImg">
		<!-- Modal Caption (Image Text) -->
		<div id="caption"></div>
	</div>
	
	<div id="gallery"
	
	/* <?php echo $publicThumbnail; ?> lisa see kui see asi yldiselt ei tööta */
	<?php
		echo "<p>";
		if ($page > 1){
			echo '<a href="?page=' .($page - 1) .'">Eelmised pildid</a> ';
		} else {
			echo "<span>Eelmised pildid</span> ";
		}
		if ($page * $limit < $totalImages){
			echo '| <a href="?page=' .($page + 1) .'">Järgmised pildid</a>';
		} else {
			echo "| <span>Järgmised pildid</span>";
		}
		echo "</p> \n";
		echo $publicThumbnails;
	?>
	</div>
	
  </body>
</html>