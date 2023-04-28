<?php
require "vendor/autoload.php";

session_start();

use App\QuestionManager;

$score = null;

try {
    $manager = new QuestionManager;
    $manager->initialize();
    $questionSize = $manager->getQuestionSize();

    if (!isset($_SESSION['answers'])) {
        throw new Exception('Missing answers');
    }

    $score = $manager->computeScore($_SESSION['answers']);

} catch (Exception $e) {
    echo '<h1>An error occurred:</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz Results</title>

    <style>
        body {
		font-family: Arial, sans-serif;
		background-color: #f2f2f2;
		margin: 0;
		padding: 0;
	    }

       	.container {
		max-width: 800px;
		margin: 0 auto;
		background-color: #fff;
		border-radius: 10px;
		box-shadow: 0px 0px 10px #aaa;
		padding: 30px;
		margin-top: 100px;
		margin-bottom: 100px;;
	    }
	
	h5 {
		margin: 20px 0 0;
		color: #999;
	    }
	
	p {
		margin: 0 0 10px;
		color: #333;
	    }
	    
	li {
		margin: 5px 0;
		color: #333;
	    }

	.correct {
		color: blue;
	    }

	.incorrect {
		color: red;
	    }
</style>

</head>
<body>
	<div class="container">
		<h1>Thank You!</h1>
		<p>Congratulations <b><?php echo $_SESSION['user_completename']; ?></b> (<b><?php echo $_SESSION['user_email']; ?></b>)!<p>
		<p>Score: <b><span style='color:blue'><?php echo $score; ?></span></b> out of <b><?php echo $questionSize; ?></b> items</p>
        <p>Your answers:</p>
        <ol>
            <?php foreach ($_SESSION['answers'] as $index => $answer):
                $question = $manager->retrieveQuestion($index);
                $isCorrect = $answer === $question->getAnswer();
                $color = $isCorrect ? 'correct' : 'incorrect';
                ?>
                <li><?php echo "$answer (<span class='$color'>" . ($isCorrect ? 'correct' : 'incorrect') . "</span>)"; ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</body>
</html>

<!-- DEBUG MODE -->
<pre>
<?php
//var_dump($_SESSION);
//var_dump($_POST);
?>
</pre>
