<?php
require("../../../config.php");
$database = "if18_kristian_kp_1";

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
			$notice = "ok";
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