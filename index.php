<?php
require "vendor/autoload.php";

// 1. What does this function session_start() do to the application?

/* The session_start() function will start a new session or resume an existing one. 
   It helps to store data across multiple pages of the application so that we can use it later on. */

session_start();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f7f7f7;
			margin: 0;
			padding: 0;
		}

		h1, h4 {
			text-align: center;
			margin-top: 50px;
			margin-bottom: 20px;
		}

		form {
			background-color: white;
			padding: 30px;
			margin: auto;
			width: 60%;
			max-width: 600px;
			border-radius: 10px;
			box-shadow: 0px 0px 10px #aaa;
		}

		label {
			display: block;
			font-size: 1.1em;
			margin-bottom: 10px;
		}

		input[type=text],
		input[type=email],
		input[type=date] {
			font-size: 1.1em;
			padding: 10px;
			width: 95%;
			margin-bottom: 20px;
			border-radius: 5px;
			border: none;
			box-shadow: 0px 0px 5px #aaa;
		}

		button[type=submit] {
			display: block;
			margin: auto;
			padding: 10px 20px;
			background-color: #007bff;
			color: white;
			border-radius: 5px;
			border: none;
			cursor: pointer;
			font-size: 1.2em;
			transition: all 0.2s ease-in-out;
		}

		button[type=submit]:hover {
			background-color: #0066cc;
		}
	</style>
</head>
<body>
	<h1>Analogy Exam Registration</h1>
	<h4>Kindly register your basic information before starting the exam.</h4>

	<form method="POST" action="register.php">
		<label>Enter your Full Name:</label>
		<input type="text" name="complete_name" placeholder="Full Name" required />
		<label>Email Address:</label>
		<input type="email" name="email" placeholder="Email Address" required/>
		<label>Birthdate:</label>
		<input type="date" name="birthdate" />
		<button type="submit">Register</button>
	</form>
</div>
</body>
</html>

<!-- DEBUG MODE
<pre>
<?php
// var_dump($_SESSION);
?>
</pre>
-->
