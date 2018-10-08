<?php
require("../../../config.php");
$database = "if18_kristian_kp_1";
	
	//alustan sessiooni
	session_start();
	
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