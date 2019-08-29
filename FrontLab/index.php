<?php
include("frontlabfunctions.php");

if(isset($_POST['submit'])){
	$cardvalue = $_POST['idcode'];

	$ucsurl = "https://onecard.mcneese.edu/json/checkAccess/static.anyValid/".$cardvalue;

	$ucsconnect = file_get_contents($ucsurl);
	$output = json_decode($ucsconnect);

	$firstName = $output->person->firstName;
	$lastName = $output->person->lastName;
	$bannerId = $output->person->spridenId;
	$studentstatus = $output->status;

	if($studentstatus=="GRANTED"){

		//check if student is in database
		if(!studentExists($bannerId)){ //add student
			$studentId = addStudent($bannerId,$firstName,$lastName,$cardvalue,0);
		}else{ //get studentId
			$studentId = getStudentId($cardvalue);
		}

		//check if student is logged in
		if(!isStudentLoggedIn($studentId)){ //log student in
			logStudentIn($studentId);
			$colorfunction = '<script>grantedcolor();</script><audio autoplay="autoplay"><source src="signout2.mp3" type="audio/mp3"></audio>';
		}else{ //log student out
			logStudentOut($studentId);
			$colorfunction = '<script>grantedcolor();</script><audio autoplay="autoplay"><source src="thankyou.mp3" type="audio/mp3"></audio>';
		}

	}else{
		//check if student exists by card ID
		if(!studentExistsByCardId($cardvalue)){
			storeCardValue($cardvalue);
			//see lab monitor
			$colorfunction = '<script>deniedcolor();</script><audio autoplay="autoplay"><source src="seemonitor.mp3" type="audio/mp3"></audio>';		

		}else{ //get studentId
			$studentId = getStudentId($cardvalue);

			if(!isStudentLoggedIn($studentId)){ //log student in
				logStudentIn($studentId);
				$colorfunction = '<script>grantedcolor();</script><audio autoplay="autoplay"><source src="signout2.mp3" type="audio/mp3"></audio>';
			}else{ //log student out
				logStudentOut($studentId);
				$colorfunction = '<script>grantedcolor();</script><audio autoplay="autoplay"><source src="thankyou.mp3" type="audio/mp3"></audio>';
			}

		}	
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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<input type="text" name="idcode" id="idcode" autofocus="autofocus">
	<input type="submit" name="submit" id="submitid">

</form>
</div>
</div>
<div id="bottomimage">
</div>
</body>
</html>
