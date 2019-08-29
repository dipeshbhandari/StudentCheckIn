<?php

include('../functions.php');

$date = date('Y-m-d');
$date2 = date('Y-m-d', strtotime('+1 day'));

$sortByTutor = " ORDER BY time_start ASC";
$sortByFront = " ORDER BY timeIn ASC";

if(isset($_POST['submit']) && $_POST['date'] != ''){
	if($_POST['date'] != '' && $_POST['date2'] == ''){
		$date = date('Y-m-d', strtotime($_POST['date']));
		$date2 = date('Y-m-d', strtotime($_POST['date'] . ' +1 day'));
	}else{
		$date = date('Y-m-d', strtotime($_POST['date']));
		$date2 = date('Y-m-d', strtotime($_POST['date2']));
	}

	if($_POST['sortBy'] == 'byTimeIn'){
		$sortByTutor = " ORDER BY time_start ASC";
		$sortByFront = " ORDER BY timeIn ASC";
	}else{
		$sortByTutor = " ORDER BY last_name,first_name DESC, time_start ASC";
		$sortByFront = " ORDER BY lastName,firstName DESC, timeIn ASC";
	}
}

//Tutoring Center
$sql = "SELECT first_name, last_name, student.banner_id, time_start,time_finish,TIMESTAMPDIFF(minute, student_log.time_start ,student_log.time_finish) AS total_minutes FROM student_log,student WHERE student.banner_id=student_log.student_id AND student.is_athlete = 1 AND time_start > '" . $date . "' AND time_start < '" . $date2 . "'" . $sortByTutor;
//echo $sql;
$result = do_sql($sql);

$table = '<table border="1"><tr><th>First Name</th><th>Last Name</th><th>Time In</th><th>Time Out</th><th>Minutes</th></tr>';

if(mysqli_num_rows($result) > 0){
	while($row = $result->fetch_array()){
		$table .= '<tr><td>' . $row['first_name'] . '</td><td>' . $row['last_name'] . '</td><td>' . $row['time_start'] . '</td><td>' . $row['time_finish'] . '</td><td>' . $row['total_minutes'] . '</td></tr>';	
	}
$table .= '</table>';

}else{
	$table = 'No athletes clocked in on this day.';
}



//Front Lab
$sql = "SELECT firstName, lastName, students.bannerId, timeIn,timeOut,TIMESTAMPDIFF(minute, studentsInOut.timeIn, studentsInOut.timeOut) AS total_minutes FROM studentsInOut,students WHERE students.studentId=studentsInOut.studentId AND students.isAthlete = 1 AND timeIn > '" . $date . "' AND timeOut < '" . $date2 ."'" . $sortByFront;
$result = do_sql_frontlab($sql);

$table2 = '<table border="1"><tr><th>First Name</th><th>Last Name</th><th>Time In</th><th>Time Out</th><th>Minutes</th></tr>';

if(mysqli_num_rows($result) > 0){
	while($row = $result->fetch_array()){
		$table2 .= '<tr><td>' . $row['firstName'] . '</td><td>' . $row['lastName'] . '</td><td>' . $row['timeIn'] . '</td><td>' . $row['timeOut'] . '</td><td>' . $row['total_minutes'] . '</td></tr>';	
	}
$table2 .= '</table>';

}else{
	$table2 = 'No athletes clocked in on this day.';
}


?>

<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
  $( function() {
    $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
  } );

  $( function() {
    $( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
  } );

</script>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
Start Date: <input type="text" id="datepicker" name="date"><br>
End Date: <input type="text" id="datepicker2" name="date2"> (Leave blank if only looking at 1 day's time)<br>
Sort By: <input type="radio" name="sortBy" value="byTimeIn" checked="checked">Time In <input type="radio" name="sortBy" value="byAthlete">Athlete<br>
<input type="submit" name="submit" value="Submit">

</form>
<br><br>


<h1>Tutoring Center - <?php echo $date; ?> <?php if(isset($_POST['submit']) && $_POST['date2'] != ''){ echo ' to ' . $date2; } ?></h1>
<br>
<?php
echo $table;
?>
<br><br>
<h1>Front Computer Lab - <?php echo $date; ?> <?php if(isset($_POST['submit']) && $_POST['date2'] != ''){ echo ' to ' . $date2; } ?></h1>
<br>NOTE:NOT ALL ATHLETES INCLUDED YET
<?php
echo $table2;
?>

</body>
</html>
