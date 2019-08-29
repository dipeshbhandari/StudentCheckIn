<?php

   function connect_tutoring(){
	
	$mysqli = new mysqli("localhost","tutor","QSUvtf4Ypq82NP1M","TutoringCenter");
	
	return $mysqli;

   }

   function connect_frontlab(){

        $mysqli = new mysqli("localhost","frontlab","ENYoApCCE532qNaL","FrontLab");

        return $mysqli;
   }


   $conn = connect_tutoring();
   $conn2 = connect_frontlab();
  


   function do_sql($sql){
	Global $conn;

	$result = $conn->query($sql);
	
	return $result;   
 
   } 	

   function do_sql_frontlab($sql){
	Global $conn2;

	$result = $conn2->query($sql);
	
	return $result;   
 
   } 	

   function clean($data){
	//$conn = connect_tutoring();
	Global $conn;	


	return $conn->real_escape_string($data);

   }
 

   function student_exists($banner_id){
        $sql = "SELECT * FROM student WHERE banner_id = $banner_id";
	echo $sql;
	$result = do_sql($sql);
	//echo mysqli_num_rows($result);	
	if(mysqli_num_rows($result) > 0){
		//student is in database
		$temp_array  = $result->fetch_array();
		return $temp_array[banner_id]; 
	}else{
		//student isnt in database
		return FALSE;
	}
   }
	
   function add_student($banner_id, $fname, $lname, $is_veteran,  $is_dual, $is_athlete, $card_id){
        
	$sql = "INSERT INTO student VALUES ($banner_id, '" . clean($fname) . "', '" . clean($lname) . "', $is_veteran, $is_dual, $is_athlete, '$card_id')";
	$result = do_sql($sql);
	
	}	



//For department table
   function department_exists($code){
        $sql = "SELECT * FROM course_department WHERE code = '$code'";
        echo $sql;
        $result = do_sql($sql);
        //echo mysqli_num_rows($result);
        if(mysqli_num_rows($result) > 0){
                //department exists
                $temp_array  = $result->fetch_array();
                return $temp_array[id];

       }
	else
	return FALSE;
   }
   function add_department($code){
   	Global $conn;
	$sql = "INSERT INTO course_department(code) VALUES ('$code')";
        echo $sql;
	$result = do_sql($sql);
	return mysqli_insert_id($conn);

	}

//For Course Number

    function course_exists($number, $department_id){
        $sql = "SELECT * FROM course_number WHERE number = '$number' AND course_department_id = $department_id";
        echo $sql;
        $result = do_sql($sql);
        //echo mysqli_num_rows($result);
        if(mysqli_num_rows($result) > 0){
                //course exists
                $temp_array  = $result->fetch_array();
                return $temp_array[id];

        }
        else
        return FALSE;
   }
    function add_course_number($number, $department_id){
	Global $conn;
        $sql = "INSERT INTO course_number(number,course_department_id) VALUES ('$number',$department_id)";
        $result = do_sql($sql);
        return mysqli_insert_id($conn);

        }
//For Semester

   function semester_exists($code){
	
        $sql = "SELECT * FROM semester where code = $code";
        echo $sql;
        $result = do_sql($sql);
        //echo mysqli_num_rows($result);
        if(mysqli_num_rows($result) > 0){
                //semester exists
                $temp_array  = $result->fetch_array();
                return $temp_array['id'];

        }
        else
        return FALSE;
   }
    function add_semester($code, $name){
	Global $conn;
        $sql = "INSERT INTO semester(name,code) VALUES ('$name',$code)";
        $result = do_sql($sql);
        return mysqli_insert_id($conn);
      }


   function get_semester_name($semester_code)
	{
		$year = substr($semester_code,0,4);
		$code = substr($semester_code,4,2);
		if($code == 20)
			$semester = 'Spring';
		else if($code == 40)
                        $semester = 'Summer';
		else if($code == 60)
                        $semester = 'Fall';
		else
			$semester = 'Winter';
		return $semester . " " . $year;
 
	}

//For Instructor
    function instructor_exists($email){	
        
	$sql = "SELECT * FROM instructor WHERE email = '$email'";
	echo $sql;
	$result = do_sql($sql);
	
	if(mysqli_num_rows($result) > 0){
		//instructor exists
		   $temp_array  = $result->fetch_array();
                return $temp_array[id];

	}
	else
		return FALSE;

        } 
	
     function add_instructor($fname, $lname, $email)
	{	
	Global $conn;
	$sql = "INSERT INTO instructor(first_name, last_name, email) VALUES ('$fname','$lname','$email')";
	$result = do_sql($sql);
	
	return mysqli_insert_id($conn);	
	}
     
//For Class
    function class_exist($crn, $semester_id){
		$sql = "SELECT * FROM class WHERE crn_number = $crn AND semester_id = $semester_id";
		echo $sql;
		$result = do_sql($sql);
	
		if(mysqli_num_rows($result) > 0)
		{
       		        $temp_array  = $result->fetch_array();
	                return $temp_array[id];
			
		}
		else
			return FALSE;

	}
    function add_class($crn_number, $section, $instructor_id, $course_number_id, $semester_id)
	{
	Global $conn;
	$sql = "INSERT INTO class(crn_number,section,instructor_id, course_number_id, semester_id) VALUES ($crn_number, '$section', $instructor_id, $course_number_id, $semester_id)";
	
	echo $sql;
	$result = do_sql($sql);
	
	return mysqli_insert_id($conn);
	}
//Enrolling Students


     function check_enrollment($student_id, $class_id){	

		$sql = "SELECT * FROM students_to_classes WHERE student_id = $student_id AND class_id = $class_id";
                echo $sql;
                $result = do_sql($sql);

                if(mysqli_num_rows($result) > 0)
                {
                        $temp_array  = $result->fetch_array();
                        return $temp_array[id];

                }
                else
                        return FALSE;
	}








     function enroll_student($banner_id, $class_id){
	Global $conn;
	$sql = "INSERT INTO students_to_classes(student_id, class_id) VALUES ($banner_id, $class_id)";
	echo $sql;
	$result = do_sql($sql);
	return mysqli_insert_id($conn);
	}

     function search_student($key){
		Global $conn;
		if(is_numeric($key))
		{
			$sql = "Select * FROM student where banner_id = $key";
		}
		else
			$sql = "Select * FROM student where first_name LIKE '%$key%' OR last_name LIKE '%$key%'";

		$result	= do_sql($sql);
                
		$number_rows = mysqli_num_rows($result);
		
		echo "<br>" . $number_rows . " students found!<br>";
		//loop through result set
                while($row = $result->fetch_array()){
                        $FirstName  = $row['first_name'];
                        $LastName = $row['last_name'];
                        $ID = $row['banner_id'];

			echo "<br>";
			echo '<a href = "check_in.php?id=' . $ID . '" class = "list"  >' . $FirstName . " " . $LastName . " " . $ID . "</a>";
		}
		
	}

	function search_class($student_id){		
		Global $conn;
		
		//get semester id of current semester

                $current_semester_id = get_current_semester_id();


                $sql = "SELECT class_id FROM students_to_classes, class where student_id = $student_id AND students_to_classes.class_id = class.id AND class.semester_id = $current_semester_id";

                $result = do_sql($sql);

		$number_rows = mysqli_num_rows($result);

	        echo "<br>" . $number_rows . " classes found!<br>";
	
		while($row = $result->fetch_array()){
                        $class_id = $row['class_id'];
			
			$sql2 = "SELECT * FROM class where id = $class_id";
			$result2 = do_sql($sql2);
			$row2 = $result2->fetch_array();
			$instructor = get_instructor($row2['instructor_id']);
			$course_number = get_course($row2['course_number_id']);
			$section = $row2['section'];
                        echo "<br>";
                       
                        echo '<a href ="logged_in.php?id=' .$student_id.'&class='.$class_id.'" class = "list"  >' . $student_id. "   " . "$course_number"." " ."$section "." ". "$instructor" . "</a>";
                }


	}	
	
	function get_current_semester_id(){
                Global $conn;

                $sql = "SELECT id FROM semester WHERE 1 order by code desc";
                $result = do_sql($sql);

                $row = $result->fetch_array();

                return $row['id'];
        }

	function get_instructor($id){	
			
			Global $conn;
 			$sql = "SELECT * FROM instructor WHERE id = $id";
			$result  = do_sql($sql);
				
			$row = $result->fetch_array();
			
			$name = $row['first_name']." ".$row['last_name'];
			return $name;
		
		}

	function get_course($id){
			
                        Global $conn;
                        $sql = "SELECT * FROM course_number WHERE id = $id";
		
                        $result  = do_sql($sql);

                        $row = $result->fetch_array();
			
			$course_department = get_department($row['course_department_id']);
			
			$class_name  = $course_department." ".$row['number'];
			
			return $class_name; 


		}
	function get_department($id){
	
			Global $conn;
                        $sql = "SELECT * FROM course_department WHERE id = $id";
		        			                
			$result  = do_sql($sql);

                        $row = $result->fetch_array();
			
			return $row['code'];

		
	}	
	function insert_student_log($id, $class_id){
		Global $conn;
		
		$sql = "INSERT INTO student_log(student_id,class_id,time_start,time_finish) VALUES ($id,$class_id,NOW(),NOW())";
		
		
		$result = do_sql($sql);	
		
		}
		
		
	function get_student_name($id){
		
		   Global $conn;
                   $sql = "SELECT * FROM student WHERE banner_id = $id";
                   $result  = do_sql($sql);

                   $row = $result->fetch_array();

                   $name = $row['first_name']." ".$row['last_name'];
                   return $name;

	
	}	

	function get_students(){	
	
		Global $conn;
		
		$sql = "SELECT * FROM student_log where time_start = time_finish";
		
		$result = do_sql($sql);
		
		
	
		while($row = $result->fetch_array()){
			


			echo '<a href ="sign_out.php?id=' .$row['id'].'" class = "button" >'. $row['student_id']."<br>".get_student_name($row['student_id']) . "</a>" ;

		}

	
		
	};





	  function insert_finish_time($id){

                Global $conn;

                $sql = "UPDATE student_log SET time_finish = NOW() WHERE id = $id";
		$result = do_sql($sql);

		}


echo '<head>
<style>
.button {
    width: 250px;
    border-radius: 7px;
    background-color: #04529C;
    border: none;
    margin:18px 25px 18px 18px;	
    color: white;
    padding: 30px 60px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 30px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgb;

}

.list{

    height: 20;
    border-radius: 7px;
    background-color: #04529C;
    border: none;
    margin:10px;
    color: white;
    padding: 15px 30px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 25px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgb;




}

</style>
</head>';




//echo '<a href ="logged_in.php?id=' .$ston insert_finish_time($id){

          


?>
