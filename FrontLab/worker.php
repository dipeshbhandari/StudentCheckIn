<?php
include("frontlabfunctions.php");

//total logins today
$logins = totalLoginsToday();


$recentCards = recentCardIds();
$recentLogins = recentLogins();
?>

<html>
<head>
<meta http-equiv="Refresh" content="1">
</head>
<body>
<a href="searchforstudent.php">Search for Student</a> | <a href="addstudent.php">Add Student</a>
<br><br>
<?php echo 'Logins Today: ' . $logins; ?>
<br><br>
<b>Recent Failed Card Ids</b>
<?php echo $recentCards; ?>
<br><br>
<?php echo $recentLogins; ?>

</body>
</html>
