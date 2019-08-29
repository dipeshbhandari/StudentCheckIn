<?php

include('../../functions.php');

if(!isset($_GET['month'])){
	$currentMonth = date('m'); // 01-12
	$currentMonthName = date('F');
	$currentYear = date('Y'); //XXXX
	$numDays = date('t'); //28-31
}else{
	$currentMonth = $_GET['month']; // 01-12
	$currentYear = $_GET['year']; //XXXX
	$currentMonthName = date('F', strtotime($currentMonth . '/01/' . $currentYear));	
	$numDays = date('t', strtotime($currentMonth . '/01/' . $currentYear)); //28-31	
}

$weekday = date('w', strtotime($currentMonth . '/01/' . $currentYear)); //returns 0-6 Sun-Sat

//echo $currentMonth . '<br>' . $currentMonthName . '<br>' . $numDays . '<br>' . $currentYear . '<br>' . $weekday . '';

$previousMonth = $currentMonth - 1;
$nextMonth = $currentMonth + 1;
if($previousMonth == 0){
	$prevLinkMonth = 12;
	$prevLinkYear = $currentYear - 1;
}else{
	$prevLinkMonth = $previousMonth;
	$prevLinkYear = $currentYear;
}

if($nextMonth == 13){
	$nextLinkMonth = 1;
	$nextLinkYear = $currentYear + 1;
}else{
	$nextLinkMonth = $nextMonth;
	$nextLinkYear = $currentYear;	
}

$html = '<div id="calendar"><div id="header"><div id="previous"><a href="month.php?month=' . $prevLinkMonth . '&year=' . $prevLinkYear . '"><< Prev</a></div><div id="month">' . $currentMonthName . ' ' . $currentYear . '</div><div id="next"><a href="month.php?month=' . $nextLinkMonth . '&year=' . $nextLinkYear . '">Next >></a></div></div>';
$html .= '<div><div class="day-header">Sunday</div><div class="day-header">Monday</div><div class="day-header">Tuesday</div><div class="day-header">Wednesday</div><div class="day-header">Thursday</div><div class="day-header">Friday</div><div class="day-header">Saturday</div></div>';


$k = 0;

for($j = 0; $j < $weekday; $j++){
	$html .= '<div class="day"></div>';
	$k++;
}

for($i = 1; $i <= $numDays; $i++){
	
	$k++;
	
	if($k % 7 == 0){
		$clearRight = ' clear-right';
		
		$k = 0;
	}else{
		$clearRight = '';		
	}
	
	$sql = "SELECT COUNT(student_id) AS visits FROM student_log WHERE time_start between '" . $currentYear . "-" . $currentMonth . "-" . $i . " 6:00:00' and '" . $currentYear . "-" . $currentMonth . "-" . $i . " 21:00:00'";
	$result = do_sql($sql);
	$row = mysqli_fetch_assoc($result);
	$visits = $row['visits'];

	$html .= '<div class="day' . $clearRight . '">' . $i . '<br><br><span class="visits">' . $visits . '</span></div>';
	//echo $sql;
}

$html .= '</div>';

?>

<html>
<head>
<style>
* {
	box-sizing: border-box;
}

#calendar{
	width: 100%;
	max-width: 1400px;
}

#header{
	width: 100%;
}

.day-header{
	font-weight: bold;
	float:left;
	width: 14.28%;
	border: 1px solid black;
}

#previous{
	width: 14.28%;
	float:left;
	height: 40px;
	line-height: 30px;

}

#month{
	width: 71.44%;
	float:left;
	text-align:center;
	font-weight: bold;
	height: 40px;
	font-size:30px;
}

#next{
	width: 14.28%;
	float:left;
	text-align: right;
	height: 40px;
	line-height: 30px;
}

.day{
	float:left;
	width: 14.28%;
	height: 100px;
	border: 1px solid black;
}

.visits{
	display: block;
	font-size: 40px;
	width:100%;
	text-align:center;
}

.clear-right{
	clear: right;
}
</style>
</head>
<body>
<?php echo $html; ?>
</body>
</html>
