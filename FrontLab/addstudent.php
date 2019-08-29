<?php
include('frontlabfunctions.php');


if(isset($_POST['submit'])){
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$bannerId = $_POST['bannerId'];
	$cardId = $_POST['cardId'];
	$isAthlete = $_POST['isAthlete'];

	addStudent($bannerId,$firstName,$lastName,$cardId,$isAthlete);

}

?>

<html>
<head></head>
<body>

<?php if(!isset($_POST['submit'])){ ?>

<form action="addstudent.php" method="POST">
First Name: <input type="text" name="firstName"><br>
Last Name: <input type="text" name="lastName"><br>
Banner ID: <input type="text" name="bannerId"><br>
Card ID: <input type="text" name="cardId"><br>
Athlete: <input type="text" name="isAthlete"><br>
<input type="submit" name="submit">
</form>

<?php }else{ ?>

Student Added. Have student try ID again.<br>

<?php } ?>
<br><br>
<a href="worker.php">Back to Worker Screen</a>

</body>
</html>
