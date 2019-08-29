<?php
include('frontlabfunctions.php');

if(isset($_GET['id'])){
	$studentId = $_GET['id'];

	$studentInfo = getStudentInfo($studentId);
}

if(isset($_POST['submit'])){
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$bannerId = $_POST['bannerId'];
	$cardId = $_POST['cardId'];
	$isAthlete = $_POST['isAthlete'];

	$sql = "UPDATE students SET firstName = '" . $firstName . "',lastName = '" . $lastName . "', bannerId = '" . $bannerId . "', cardId = '" . $cardId . "', isAthlete = '" . $isAthlete . "' WHERE studentId = " . $studentId;
	do_sql($sql);
}

?>

<html>
<head></head>
<body>

<?php if(!isset($_POST['submit'])){ ?>

<form action="editstudent.php?id=<?php echo $studentId; ?>" method="POST">
First Name: <input type="text" name="firstName" value="<?php echo $studentInfo['firstName']; ?>"><br>
Last Name: <input type="text" name="lastName" value="<?php echo $studentInfo['lastName']; ?>"><br>
Banner ID: <input type="text" name="bannerId" value="<?php echo $studentInfo['bannerId']; ?>"><br>
Card ID: <input type="text" name="cardId" value="<?php echo $studentInfo['cardId']; ?>"><br>
Athlete: <input type="text" name="isAthlete" value="<?php echo $studentInfo['isAthlete']; ?>"><br>
<input type="submit" name="submit">
</form>

<?php }else{ ?>

Information has been updated.<br>
<a href="worker.php">Back to Worker Screen</a>

<?php } ?>

</body>
</html>
