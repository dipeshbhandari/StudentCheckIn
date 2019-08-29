<?php

function connect_frontlab(){

	$mysqli = new mysqli("localhost","frontlab","ENYoApCCE532qNaL","FrontLab");

	return $mysqli;
}

$conn = connect_frontlab();

function do_sql($sql){
	Global $conn;

	$result = $conn->query($sql);

	return $result;
}

function getStudentId($cardId){
	Global $conn;

	$sql = "SELECT studentId FROM students WHERE cardId = '" . $cardId . "'";
	$result = do_sql($sql);

	$row = $result->fetch_assoc();

	return $row['studentId'];
}

function getStudentIdFromBannerId($bannerId){
	Global $conn;

	$sql = "SELECT studentId FROM students WHERE bannerId = '" . $bannerId . "'";
	$result = do_sql($sql);

	$row = $result->fetch_assoc();

	return $row['studentId'];
}

function studentExists($bannerId){
	Global $conn;

	$sql = "SELECT * FROM students WHERE bannerId = '" . $bannerId . "'";
	$result = do_sql($sql);

	if(mysqli_num_rows($result) > 0){
		return true;
	}else{
		return false;
	}
}

function studentExistsByCardId($cardId){
	Global $conn;

	$sql = "SELECT * FROM students WHERE cardId = '" . $cardId . "'";
	$result = do_sql($sql);

	if(mysqli_num_rows($result) > 0){
		return true;
	}else{
		return false;
	}
}

function addStudent($bannerId, $firstName, $lastName, $cardId, $isAthlete){
	Global $conn;

	$sql = "INSERT INTO students(bannerId,firstName,lastName,cardId,isAthlete) VALUES('" . $bannerId . "','" . $firstName . "','" . $lastName . "','" . $cardId . "'," . $isAthlete . ")";
	$result = do_sql($sql);

	return mysqli_insert_id($conn);
}

function getStudentInfo($studentId){
	Global $conn;

	$sql = "SELECT * FROM students WHERE studentId = " . $studentId;
	$result = do_sql($sql);

	$row = mysqli_fetch_assoc($result);

	return $row;
}

function isStudentLoggedIn($studentId){
	Global $conn;
	
	$currentDateTime = date('Y-m-d H:i:s');

	//if student has been logged in for over 3 hours and never logged out, consider them logged out
	$sql = "SELECT * FROM studentsInOut WHERE timeIn > SUBTIME('" . $currentDateTime . "', '0 3:0:0.0') AND timeOut = '0000-00-00 00:00:00' AND studentId = " . $studentId;
	$result = do_sql($sql);

	if(mysqli_num_rows($result) > 0){
		return true;
	}else{
		return false;
	}
}

function logStudentIn($studentId){
	Global $conn;

	$sql = "INSERT INTO studentsInOut(studentId,timeIn,timeOut) VALUES(" . $studentId . ", NOW(),'0000-00-00 00:00:00')";
	$result = do_sql($sql);
}

function logStudentOut($studentId){
	Global $conn;

	$currentDateTime = date('Y-m-d H:i:s');

	$sql = "UPDATE studentsInOut SET timeOut = NOW() WHERE studentId = " . $studentId . " AND timeIn > SUBTIME('" . $currentDateTime . "', '0 3:0:0.0') AND timeOut = '0000-00-00 00:00:00'";
	$result = do_sql($sql);
}

function isAthlete($bannerId){
	Global $conn;

	$sql = "SELECT * FROM students WHERE bannerId = '" . $bannerId . "' AND isAthlete = 1";
	$result = do_sql($result);

	if(mysqli_num_rows($result) > 0){
		return true;
	}else{
		return false;
	}
}

function storeCardValue($cardId){
	Global $conn;

	$sql = "INSERT INTO cardValues(cardId,timeIn) VALUES('" . $cardId . "', NOW())";
	$result = do_sql($sql);
}

function totalLoginsToday(){
	Global $conn;
	$currentDate = date('Y-m-d');

	$sql = "SELECT COUNT(studentId) AS totalLogins FROM studentsInOut WHERE timeIn > '" . $currentDate . " 00:00:00'";
	$result = do_sql($sql);
	$row = $result->fetch_assoc();

	return $row['totalLogins'];
}

function recentCardIds(){
	Global $conn;

	$sql = "SELECT * FROM cardValues WHERE 1 ORDER BY id DESC LIMIT 0,3";
	$result = do_sql($sql);
	$table = '<table border=1""><tr><th>Card ID</th><th>Time</th></tr>';
	while($row = $result->fetch_assoc()){
		$table .= '<tr><td>' . $row['cardId'] . '</td><td>' . $row['timeIn'] . '</td></tr>';
	}
	$table .= '</table>';

	return $table;	
}

function recentLogins(){
	Global $conn;

	$sql = "SELECT * FROM studentsInOut,students WHERE studentsInOut.studentId = students.studentId ORDER BY inOutId DESC LIMIT 0,10";
	$result = do_sql($sql);
	$table = '<table border=1""><tr><th>Card ID</th><th>Time In</th><th>Time Out</th></tr>';
	while($row = $result->fetch_assoc()){
		$table .= '<tr><td>' . $row['cardId'] . '</td><td>' . $row['timeIn'] . '</td><td>' . $row['timeOut'] . '</td></tr>';
	}
	$table .= '</table>';

	return $table;	
}



?>
