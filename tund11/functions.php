<?php
require("../../../config.php");
$database = "if18_kristian_kp_1";
	
	
	
	
	//alustan sessiooni
	session_start();
	
	function readAllPublicPictureThumbsPage(){
		$privacy = 2;
		$html = "<p>Kahjuks pilte pole!</p>";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT filename, alttext FROM vp_photos WHERE privacy=? AND deleted IS NULL LIMIT 6");
		echo $mysqli->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($filenameFromDb, $altFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			$html = '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">' ."\n";
		}
		
		while($stmt->fetch()){
			$html = '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">' ."\n";
		}
		
		$stmt->close();
		$mysqli->close();
		return $html;
	}
	
	/* function readAllPublicPictureThumbs(){
		$privacy = 2;
		$html = "<p>Kahjuks pilte pole!</p>";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $mysqli->prepare("SELECT filename, alttext FROM vp_photos WHERE id=(SELECT MAX(id) FROM vp_photos WHERE privacy=? AND deleted IS NULL)");
		$stmt = $mysqli->prepare("SELECT filename, alttext FROM vp_photos WHERE privacy=? AND deleted IS NULL");
		echo $mysqli->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($filenameFromDb, $altFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			$html = '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">' ."\n";
		}
		
		while($stmt->fetch()){
			$html = '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">' ."\n";
		}
		
		$stmt->close();
		$mysqli->close();
		return $html;
	} */
	
	function latestPicture($privacy){
		$html = "<p>Pole pilti, mida näidata!";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT filename, alttext FROM vp_photos WHERE id=(SELECT MAX(id) FROM vp_photos WHERE privacy=? AND deleted IS NULL)");
		echo $mysqli->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($filenameFromDb, $altFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			//<img src=" " alt="">
			//$GLOBALS["picDir"] .$filenameFromDb
			$html = '<img src="' .$GLOBALS["picDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">';
		}
		
		$stmt->close();
		$mysqli->close();
		return $html;
	}
	
	function addPhotoData($fileName, $alt, $privacy){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("INSERT INTO vp_photos (userID, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
			echo $mysqli->error;
			$stmt->bind_param("issi", $_SESSION["userId"], $fileName, $alt, $privacy);
			if($stmt->execute()){
			echo "Andmebaasiga on korras!";
			} else {
			echo "Andmebaasiga on jama: " .$stmt->error;
			}
		
			$stmt->close();
			$mysqli->close();
	}
	
	function storeuserprofile($desc, $bgcol, $txtcol){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT description, bgcolor, txtcolor FROM vpuserprofiles WHERE userid=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
		$stmt->bind_result($description, $bgcolor, $txtcolor);
		$stmt->execute();
		if($stmt->fetch()){
			//profiil juba olemas, uuendame
			$stmt->close();
			$stmt = $mysqli->prepare("UPDATE vpuserprofiles SET description=?, bgcolor=?, txtcolor=? WHERE userid=?");
			echo $mysqli->error;
			$stmt->bind_param("sssi", $desc, $bgcol, $txtcol, $_SESSION["userId"]);
			if($stmt->execute()){
				$notice = "Profiil edukalt uuendatud!";
				$_SESSION["bgColor"] = $bgcol;
				$_SESSION["txtColor"] = $txtcol;
			} else {
				$notice = "Profiili uuendamisel tekkis tõrge! " .$stmt->error;
			}
		} else {
			//profiili pole, salvestame
			$stmt->close();
			//INSERT INTO vpusers3 (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)"
			$stmt = $mysqli->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
			echo $mysqli->error;
			$stmt->bind_param("isss", $_SESSION["userId"], $desc, $bgcol, $txtcol);
			if($stmt->execute()){
				$notice = "Profiil edukalt salvestatud!";
				$_SESSION["bgColor"] = $bgcol;
				$_SESSION["txtColor"] = $txtcol;
			} else {
				$notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
			}
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
  
  //kasutajaprofiili väljastamine
  function showmyprofile(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT description, bgcolor, txtcolor FROM vpuserprofiles WHERE userid=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
		$stmt->bind_result($description, $bgcolor, $txtcolor);
		$stmt->execute();
		$profile = new Stdclass();
		if($stmt->fetch()){
			$profile->description = $description;
			$profile->bgcolor = $bgcolor;
			$profile->txtcolor = $txtcolor;
		} else {
			$profile->description = "";
			$profile->bgcolor = "";
			$profile->txtcolor = "";
		}
		$stmt->close();
		$mysqli->close();
		return $profile;
	}
	
	function readprofilecolors(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT bgcolor, txtcolor FROM vpuserprofiles WHERE userid=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
		$stmt->bind_result($bgcolor, $txtcolor);
		$stmt->execute();
		$profile = new Stdclass();
		if($stmt->fetch()){
			$_SESSION["bgColor"] = $bgcolor;
			$_SESSION["txtColor"] = $txtcolor;
		} else {
			$_SESSION["bgColor"] = "#FFFFFF";
			$_SESSION["txtColor"] = "#000000";
		}
		$stmt->close();
		$mysqli->close();
	}
	
	
	function readallvalidatedmessagesbyuser(){
		$result = "";
		$msghtml = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, name, surname FROM vpusers");
		
		echo $mysqli->error;
		
		$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
		
		$stmt2 = $mysqli->prepare("SELECT message, valid FROM vpamsg WHERE validator=?");
		echo $mysqli->error;
		$stmt2->bind_param("i", $idFromDb);
		$stmt2->bind_result($msgFromDb, $validFromDb);
		
		$stmt->execute();
		$stmt->store_result();
		
		while($stmt->fetch()){
			//panen valideerija nime paika
			$msgCount = 0;
			$msghtml= "";
			$msghtml .="<h3>" .$firstnameFromDb ." " .$lastnameFromDb ."</h3> \n";
					
			$stmt2->execute();
			while($stmt2->fetch()){
				//$msghtml .="<h3>" .$firstnameFromDb ." " .$lastnameFromDb ."</h3> \n";
				$msghtml .= "<p><b>";
				if($validFromDb == 0){
					$msghtml .= "Keelatud ";
				}	else {
					$msghtml .= "Lubatud ";
				}
				$msgCount ++;
				$msghtml .= "</b>" .$msgFromDb ."</p> \n";
			}
			if ($msgCount != 0){
				$result .= $msghtml;
			}
				
		}
		$stmt->close();
		$stmt2->close();
		$mysqli->close();
		return $result;
	}
	
	function listusers(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT name, surname, email FROM vpusers WHERE id !=?");
	//$stmt = $mysqli->prepare("SELECT firstname, lastname, email, description FROM vpusers, vpuserprofiles WHERE vpuserprofiles.userid=vpusers.id");
	
	$mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($firstname, $lastname, $email);
	//$stmt->bind_result($firstname, $lastname, $email, $description);
	if($stmt->execute()){
	  $notice .= "<ol> \n";
	  while($stmt->fetch()){

		  $notice .= "<li>" .$firstname ." " .$lastname .", kasutajatunnus: " .$email ."</li> \n";
		  //$notice .= "<li>" .$firstname ." " .$lastname .", kasutajatunnus: " .$email ."<br>" .$description ."</li> \n";
	  }
	  $notice .= "</ol> \n";
	} else {
		$notice = "<p>Kasutajate nimekirja lugemisel tekkis tehniline viga! " .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
	}
	
	
	function allvalidmessages(){
	$html = "";
	$valid = 1;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE valid=? ORDER BY validated DESC");
	echo $mysqli->error;
	$stmt->bind_param("i", $valid);
	$stmt->bind_result($msg);
	$stmt->execute();
	while($stmt->fetch()){
		$html .= "<p>" .$msg ."</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	if(empty($html)){
		$html = "<p>Kontrollitud sõnumeid pole.</p>";
	}
	return $html;
	}
		
	function validatemsg($editId, $validation){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE vpamsg SET validator=?, valid=?, validated=now() WHERE id=?");
	$stmt->bind_param("iii", $_SESSION["userId"], $validation, $editId);
	if($stmt->execute()){
	  echo "Õnnestus";
	  header("Location: validatemsg.php");
	  exit();
	} else {
	  echo "Tekkis viga: " .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	}
	
	//valideerimata sõnumid	
	function readallunvalidatedmessages(){
		$notice = "<ul> \n";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, message FROM vpamsg WHERE valid IS NULL ORDER BY id DESC");
		echo $mysqli->error;
		$stmt->bind_result($id, $msg);
		$stmt->execute();
		
		while($stmt->fetch()){
			$notice .= "<li>" .$msg .'<br><a href="validatemessage.php?id=' .$id .'">Valideeri</a>' ."</li> \n";
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	
	function readmsgforvalidation($editId){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
		$stmt->bind_param("i", $editId);
		$stmt->bind_result($msg);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $msg;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	//test input
	function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	}
	
	//sisselogimise funktsioon
	function signin($email, $password) {
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, name, surname, password FROM vpusers WHERE email=?");
		echo $mysqli->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb, $passwordFromDb);
		if($stmt->execute()){
			//kui päring õnnestus
			if($stmt->fetch()){
				//kasutaja on olemas
				if(password_verify($password, $passwordFromDb)){
					//kui salasõna klapib
					$notice = "Logisite sisse";
					//määran sessiooni muutujad
					$_SESSION["userId"] = $idFromDb;
					$_SESSION["userFirstName"] = $firstnameFromDb;
					$_SESSION["userLastName"] = $lastnameFromDb;
					$_SESSION["userEmail"] = $email;
					readprofilecolors();
					//liigume kohe vaid sisseloginutele mõeldud pealehele
					$stmt -> close();
					$mysqli -> close();
					header("Location: main.php");
					exit();
				} else {
					$notice = "Vale salasõna";
				}
			} else {
				$notice = "Sellist kasutajat (" . $email .") ei leitud";
			}
		} else {
			$notice = "Sisselogimisel tekkis tehniline viga" .$stmt->error;
		}
		
		$stmt -> close();
		$mysqli -> close();
		return $notice;
		
	}//sisselogimine lõppeb

	function signup($name, $surname, $email, $gender, $birthDate, $password) {
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpusers (name, surname, email, gender, birthDate, password) VALUES(?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//krüptida passwordi, kasutades juhuslikku soolamise fraasi (salting string)
		$options = [
			"cost" => 12,
			"salt" => substr(sha1(rand()), 0, 22),
			]; 
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
		$stmt -> bind_param("sssiss", $name, $surname, $email, $gender, $birthDate, $pwdhash);
		if ($stmt -> execute()){
			$notice = "Good job!";
		} else {
			$notice = "error";
		}
		$stmt -> close();
		$mysqli -> close();
		return $notice;
		
	}


	function saveAMsg($msg) {
		//echo "Töötab!";
		$notice = ""; //see teade, mis antakse salvestamise kohta
		//loome ühenduse andmebaasiga
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette sql päringu
		$stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
		echo $mysqli->error;
		$stmt->bind_param("s", $msg); //s - string 1 - integar d - decimal	
		if ($stmt->execute ()) {
			$notice = 'Sõnum; "' .$msg .'" on salvestatud!';
		} else {
			$notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;	
	}
	
	
?>