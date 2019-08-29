<?php
include("functions.php"); 



$i = 0;

$handle = fopen("new_files/Fall2019Tutoring.csv","r");
while($content = fgetcsv($handle, 1000, "," )){
//  while(!feof($handle)){

   if($i == 0){//skip first line of file
	$content = fgetcsv($handle, 1000, "," );
	$i++;
   }
	
//   $content = fgetcsv($handle, 1000, "," );


   $banner_id = $content[0];
   $card_id = $content[1];
   $student_lname = $content[2];
   $student_fname = $content[3];
   $course_abbr = $content[4];
   $course_no = $content[5];
   $course_section = $content[6];
   $crn_no  = $content[7];
   $semester_code = $content[8];
   $instructor_fname  = $content[9];
   $instructor_lname  = $content[10];
   $instructor_email = $content[11];
   $athlete = $content[12];
   $veteran = $content[13];
   $dual_enroll = $content[14];
   
   if(!student_exists($banner_id))
   {
         add_student($banner_id, $student_fname, $student_lname, $veteran, $dual_enroll, $athlete, $card_id);	
  	echo 'student added <br>';
   }

   if(!department_exists($course_abbr))
	{
		$department_id = add_department($course_abbr);
		echo 'Department Added<br>';
	}
   else  
	$department_id = department_exists($course_abbr);

   



	
   if(!course_exists($course_no, $department_id))
        {
               $course_id = add_course_number($course_no, $department_id);
                echo 'Course Added<br>';
        }
   else 
	$course_id = course_exists($course_no, $department_id);
	



   if(!semester_exists($semester_code))
	{	
		$semester_name = get_semester_name($semester_code);
		$semester_id = add_semester($semester_code,$semester_name);
		echo 'Semester Added<br>';
	}
   else
	$semester_id = semester_exists($semester_code);

  
echo "<br>" . $semester_id . "<br>";


    if(!instructor_exists($instructor_email))
	{
		$instructor_id = add_instructor($instructor_fname, $instructor_lname, $instructor_email);
		echo 'Instructor_added<br>';
	}
	
    else
	$instructor_id = instructor_exists($instructor_email);
	





	
	
     if(!class_exist($crn_no, $semester_id))
	{
		$class_id = add_class($crn_no, $course_section, $instructor_id, $course_id, $semester_id);
		echo 'Class Added<br>';
	}
     else
		$class_id = class_exist($crn_no, $semester_id);
	 	

     if(!check_enrollment($banner_id, $class_id))
	{
		$enrollment_id = enroll_student($banner_id, $class_id);
		echo 'Student Enrolled <br>';
	}
     else 
		$enrollment_id = check_enrollment($banner_id, $class_id);


}

?>
