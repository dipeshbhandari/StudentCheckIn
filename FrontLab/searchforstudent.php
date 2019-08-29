<?php

include('frontlabfunctions.php');

$resultHTML = '';

if(isset($_POST['submit'])){
	$bannerid = $_POST['bannerid'];

	if(studentExists($bannerid)){
		//get studentId
		$studentId = getStudentIdFromBannerId($bannerid);
		
		$studentInfo = getStudentInfo($studentId); //index: bannerId,firstName,lastName,cardId,isAthlete
		
		$resultHTML = '<a href="editstudent.php?id=' . $studentInfo['studentId'] . '">' . $studentInfo['firstName'] . ' ' . $studentInfo['lastName'] . ' ' . $studentInfo['bannerId'] . ' Athlete:' . $studentInfo['isAthlete'] . '</a>';
	}else{
		$resultHTML = 'Student does not exist. <a href="addstudent.php">Add Student</a>';
	}

}





?>




<html>
<head>
</head>
<body>
<form action="searchforstudent.php" method="POST">
Banner ID: <input type="text" name="bannerid">
<input type="submit" name="submit">
<br>

<?php echo $resultHTML; ?>
<br><br>
<a href="worker.php">Back to Worker Screen</a>
</form>
</body>
</html>
