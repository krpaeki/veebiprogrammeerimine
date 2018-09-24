<?php
require("../../../config.php");
$database = "if18_kristian_kp_1";

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