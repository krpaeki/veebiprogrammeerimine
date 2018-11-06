<?php
  require("functions.php");
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
	<p>Oled sisse loginud nimega <?php echo $_SESSION["userFirstName"] . ' ' . $_SESSION["userLastName"];?></p>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea><br/>
		<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
		<label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
		<input type="submit" value="Submit" name="submitProfile">
	</form>
  </body>
 
  
</html>