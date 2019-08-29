<?php
include("frontlabfunctions.php");

if(isset($_POST['submit'])){
$cardvalue = $_POST['idcode'];
$ucsurl = "https://onecard.mcneese.edu/json/checkAccess/static.stu/".$cardvalue;

$ucsconnect = file_get_contents($ucsurl);
$output = json_decode($ucsconnect);


$firstName = $output->person->firstName;
$lastName = $output->person->lastName;
$department = $output->person->department;
$bannerId = $output->person->spridenId;
$studentstatus = $output->status;

/*echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo $department;
echo "<br>";*/

if($studentstatus=="GRANTED"){
	$sql = "SELECT * FROM departments WHERE departmentName = '$department'";
	$result = doSQL($sql);
	$num = mysql_num_rows($result);

	if($num == 0){
		$sql = "INSERT INTO departments(departmentName) VALUES ('$department')";
		doSQL($sql);
		$departmentId = mysql_insert_id();
	}
	else{
		$row = mysql_fetch_assoc($result);
		$departmentId = $row['departmentId'];
	}
	$sql = "SELECT * FROM students WHERE bannerId = '$bannerId'";
	$result = doSQL($sql);
	$num = mysql_num_rows($result);
	if($num==0){

		$sql = "INSERT INTO students(bannerId,firstName,lastName,cardId,departmentId) VALUES ('$bannerId','$firstName','$lastName','$cardvalue',$departmentId)";
		doSQL($sql);
		$studentId = mysql_insert_id();
	}
	else{
		$row = mysql_fetch_assoc($result);
		$studentId = $row['studentId'];
	}
	$sql = "SELECT * FROM patronsInOut WHERE timeIn IS NOT NULL AND timeOut IS NULL AND studentId = $studentId";
	$result = doSQL($sql);
	$num = mysql_num_rows($result);
	if($num == 0){
		$sql = "INSERT INTO patronsInOut(studentId,timeIn) VALUES ($studentId,NOW())";
		doSQL($sql);
	}
	else{
		$sql = "UPDATE patronsInOut SET timeOut = NOW() WHERE timeOut IS NULL AND studentId = $studentId";
		doSQL($sql);
	}

$colorfunction = '<script>grantedcolor();</script><audio autoplay="autoplay"><source src="DingLing.mp3" type="audio/mp3"></audio>';
}
else{

$colorfunction = '<script>deniedcolor();</script><audio autoplay="autoplay"><source src="denied.mp3" type="audio/mp3"></audio>';


}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Academic Computing Center</title>
<LINK href="style.css" rel="stylesheet" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>
function grantedcolor(){
$(document).ready(function(){
$("body").css("background-color","green");
setTimeout(function(){
$("body").css("background-color","#003399");
},1000);
});
}

function deniedcolor(){
$(document).ready(function(){
$("body").css("background-color","red");
setTimeout(function(){
$("body").css("background-color","#003399");
},1000);
});
}

</script>
</head>
<body>
<?php
echo $colorfunction; ?>
<div id="topimage">
</div>
<div id="page">
<h2 align=center>Please scan your ID to sign in/out</h2>
<div id="table">

<form action="FrontLabLogin.php" method="post">
	<input type="text" name="idcode" id="idcode" autofocus="autofocus">
	<input type="submit" name="submit" id="submitid">

</form>
</div>
</div>
<div id="bottomimage">
</div>
</body>
</html>
