<?php
	include 'functions.php';
		$id = $_GET['id'];
		insert_finish_time($id);
		header('Location:get_students.php');
?>
