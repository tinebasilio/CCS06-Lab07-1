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

</head>
<body>
		<h1>Analogy Exam Registration</h1>
		<h4>Kindly register your basic information before starting the exam.</h4>

		<form method="POST" action="register.php">
				<label>Enter your Full Name:</label>
				<input type="text" name="complete_name" placeholder="Full Name" required />
					<br />
				<label>Email Address:</label>
				<input type="email" name="email" placeholder="Email Address" required/>
					<br />
				<label>Birthdate:</label>
				<input type="date" name="birthdate" />
					<br />  
				<button type="submit">Submit</button>
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