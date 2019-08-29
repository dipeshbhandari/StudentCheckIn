<?php
	include 'functions.php';
	
	$id = $_GET['id'];
	$class_id = $_GET['class'];

	insert_student_log($id,$class_id);
	header('Location: search.php');	
?>
