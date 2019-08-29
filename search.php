<?php
	include 'functions.php';

		echo '<p style =" font-size:45px;text-align:center;" >THE TUTORING CENTER!</p>';




		echo '<p style =" font-size:45px;" >Enter <b style = "color :blue;" >Student Name</b> or<b style = "color :blue;" > Banner ID</b>!</p>';
?>
 <HTML>
                <head>
		<title>Student Check In</title>

		<style>
			.search_box{
				  border: 2px solid blue;
    				  border-radius: 4px;	
			          width : 600px;	
			          height : 45px;
				  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);

				}
			
			.search_button {
    				  background-color: blue; /* blue */
	   			  border: none;
				  border-radius: 7px;
				  color: white;
				  padding: 15px 32px;
			          text-align: center;
				  text-decoration: none;
                  	          display: inline-block;
			          font-size: 16px;
				  height: 50px;
				  opacity: 0.8;
			          transition: 0.3s;
				box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
				cursor: pointer;
}

			
		</style>
			
	 	
		</head>
                <body>

                        <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method= "post">
                                <input type = "text" name = "keyword" class ="search_box" >
                                <input type = "submit" value = "Search" name = "search" class = "search_button" >
                        </form>

                </body>

        </HTML>

<?php
	

	      if(isset($_POST['search']))
        {
                $key = $_POST['keyword'];
                search_student($key);
        }
        




?>
