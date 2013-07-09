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
		$_POST['Email'],  
		$_POST['confirmEmail'],  
		$_POST['Password'],  
		$_POST['confirmPassword'] 
		)) 
		
		echo(' ');
		
	{ 
		//Creates an array that will hold error messages
		$errors = array();
		
		//assigns posted, html-sanitized data to variables 
		$Email = htmlentities($_POST['Email']);
		$confirmEmail = htmlentities($_POST['confirmEmail']);
		$Password = htmlentities($_POST['Password']);
		$confirmPassword = htmlentities($_POST['confirmPassword']);

		//Adds relevant error messages to the $errors array		
		$emailRegex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	
		$emailVal = preg_match($emailRegex, $Email);
		if ($emailVal = 0) 
			{
				$errors[] = 'Please enter a valid email address in the first Email field.';		
			};
	
		$cfmEmailVal = preg_match($emailRegex, $confirmEmail);
		if ($cfmEmailVal = 0) 
			{
				$errors[] = 'Please enter a valid email address in the second Email field.';		
			}
			else 
			{
				if ($Email != $confirmEmail) 
				{
					$errors[] = 'The email addresses you entered do not match.';
				};
			};

		if ($Password != $confirmPassword) 
		{
			$errors[] = 'The passwords you entered do not match.';
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
		
		//When all information has been entered successfully, echoes the info back to the user
		else 
		{
			echo '<strong>Thank you for registering!</strong><br />';
			echo '<strong>You may now <a href="./addpost.html">create a post</a><br />';

			//Inserts data into database
			$query =
				"INSERT INTO `Posts` SET
				`Email` = '{$Email}',
				`Password` = '{$Password}'";
			mysqli_query($link, $query);
						
		};


	};

		session_destroy();

?>
 </body>
</html>