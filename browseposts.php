<html>
<head>
</head>
<body>
<?php
	//initiates PHP session
	session_start();
	
	//connects to the MySQL database
	include_once('resources/init.php');


	//Checks that the fields are all set
 	if (isset (
		$_POST['Email']
		)) 
		
		echo(' ');

		//error checking		

		//Creates an array that will hold error messages
		$errors = array();
	
		//assigns posted, html-sanitized data to variables 
		$Email = htmlentities($_POST['Email']);

		//Checks email using regex and adds relevant error messages to the $errors array
		$emailRegex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 

		$emailVal = preg_match($emailRegex, $Email);
		if ($emailVal = 0) 
			{
				$errors[] = 'Please enter a valid email address in the Email field.';		
			};

		//Displays accumulated errors to the user
		if (!empty($errors)) 
		{
			foreach ($errors as $error) 
			{
				echo '<strong>', $error, '</strong><br />';
				echo 'Please click the <strong>Back</strong> button and try again';

			};
		}

		//When email address has been entered successfully, shows the user's posts
		echo '<h1>Here are the posts you have created.</h1><br />';
		
		//Assigns SQL query to $query
		$query =
			"SELECT `Title` , `Description` , `Price` , `Location` , `Subcategory` , 
				`Image_1` , `Image_2` , `Image_3` , `Image_4` , `Image_1` 
			FROM `Posts` 
			WHERE `Email` = '{$Email}'";

				// Display each result
				if ($result = mysqli_query($link, $query)) {
					while ($row = mysqli_fetch_row($result)) {
						echo '<h2>' , $row[0] , '</h2><br />';
						echo '<strong>Description: </strong>' , $row[1] , '<br />';
						echo '<strong>Price: </strong> ' , $row[2] , '<br />';
						echo '<strong>Location: </strong> ' , $row[3] , '<br />';
						echo '<strong>Subcategory: </strong> ' , $row[4] , '<br />';
						if (!empty($row[6])) {
							echo '<img src="data:image/gif;base64,' , $row[6] , '" />';
						}



					}
					$result->free();
					}

		session_destroy();

?>
</body>
</html>