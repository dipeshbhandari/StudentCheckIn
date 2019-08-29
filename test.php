<?php 
	include_once('functions.php');


	$test_val = 201840;	
	/*if($result = class_exist($test_val))
     	{
         
		echo '<br><br>' . $result;	
		echo '<br><br>found!';


	}
	else
	{

		$id = add_class($test_val,'B',1,3,1);
		echo '<br>Added';
	}
	echo 'test';
	$test = enroll_student(128796, 2);
	echo'test2';
	*/
	$semester = get_semester_name($test_val);
	echo $semester; 
	
?>
