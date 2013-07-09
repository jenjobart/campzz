<html>
<head>
</head>
<body>
<?php
	//initiates PHP session
	session_start();
	
	//connects to the MySQL database
	include_once('resources/init.php');

	//Takes an image field as input. 
	//If the image field contains an image, uploads it to a binary file, encodes the contents, and returns the encoded contents.  
	//If the image field is empty returns NULL
	function encodeImage($image) {
		if ($_FILES[$image]['size'] > 0) { 
			echo '<strong>We received the image file called: </strong>' . (string)$_FILES[$image]['name'] . '<br />';
			echo '<strong>&nbsp;&nbsp;File size is: </strong>' . (float)$_FILES[$image]['size'] . '<br />';
			echo '<strong>&nbsp;&nbsp;File type is: </strong>' . (string)$_FILES[$image]['type'] . '<br />';
		
			$fh = fopen($_FILES[$image]['tmp_name'], "rb");
			$contents = fread($fh, $_FILES[$image]['size']);
			fclose($fh);
			return "'" . base64_encode($contents) . "'";
		} else {
			return 'NULL';
		}
	}


	//Checks that the fields are all set
 	if (isset (
		$_POST['Subcategory'], 
		$_POST['Location'],  
		$_POST['Title'],  
		$_POST['Price'], 
		$_POST['Description'],  
		$_POST['Email'],  
		$_POST['Confirmemail'],  
		$_POST['Termsok']
		)) 
		
		echo(' ');
		
	{ 
		//Creates an array that will hold error messages
		$errors = array();
		
		//assigns posted, html-sanitized data to variables 
		$Subcategory = htmlentities($_POST['Subcategory']);
		$Location = htmlentities($_POST['Location']);
		$Title = htmlentities($_POST['Title']);
		$Price = htmlentities($_POST['Price']);
		$Description = htmlentities($_POST['Description']);
		$Email = htmlentities($_POST['Email']);
		$Confirmemail = htmlentities($_POST['Confirmemail']);
		$Termsok = htmlentities($_POST['Termsok']);

		//Checks data validity and adds relevant error messages to the $errors array
		if ($Subcategory == 'empty') 
			{
				$errors[] = 'Please specify an item type.';
			}

		if ($Location == 'empty') 
			{
				$errors[] = 'Please specify your location.';	
			}
			
		if (filter_var($Price, FILTER_VALIDATE_FLOAT) === FALSE)
			{
				$errors[] = 'Please specify a valid price.';
			}

		$emailRegex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	
		$emailVal = preg_match($emailRegex, $Email);
		if ($emailVal = 0) 
			{
				$errors[] = 'Please enter a valid email address in the Email field.';		
			};
	
		$cfmEmailVal = preg_match($emailRegex, $Confirmemail);
		if ($cfmEmailVal = 0) 
			{
				$errors[] = 'Please enter a valid email address in the Confirm Email field.';		
			}
			else 
			{
				if ($Email != $Confirmemail) 
				{
					$errors[] = 'The email addresses you entered do not match.';
				};
			};

		if (!isset($Termsok)) 
			{
				$errors[] = 'Please agree to the terms and conditions.';	
			}



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
			echo '<strong>Your post has been registered. It contains the following information:</strong><br />';
			echo '<strong>Subcategory: </strong>', $Subcategory, '<br />';
			echo '<strong>Location: </strong>', $Location, '<br />';
			echo '<strong>Title: </strong>', $Title, '<br />';
			echo '<strong>Price: </strong>', $Price, '<br />';
			echo '<strong>Description: </strong>', $Description, '<br />';
			echo '<strong>Subcategory: </strong>', $Subcategory, '<br />';
			echo '<strong>Email: </strong>', $Email, '<br />';
			echo '<strong>Confirmation Email: </strong>', $Confirmemail, '<br />';
			
			$image1 = encodeImage('image1');
			$image2 = encodeImage('image2');
			$image3 = encodeImage('image3');
			$image4 = encodeImage('image4');
			$image5 = encodeImage('image5');

			//Inserts data into database
			$query =
				"INSERT INTO `Posts` SET
				`SubCategory` = '{$Subcategory}', 
				`Location` = '{$Location}',
				`Title` = '{$Title}',
				`Price` = '{$Price}',
				`Description` = '{$Description}',
				`Email` = '{$Email}',
				`Agreement` = '{$Termsok}',
				`Image_1` = {$image1},				
				`Image_2` = {$image2},				
				`Image_3` = {$image3},				
				`Image_4` = {$image4},				
				`Image_5` = {$image5}";
			mysqli_query($link, $query);

			echo '<strong>If you wish, you may now <a href="./browse.html">Browse your posts.</a></strong><br />';
			
		};


	};
		//frees all variables used in session
		session_destroy();

?>
 </body>
</html>