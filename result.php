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
    <title>Results</title>
</head>
<body>
        <h1>Thank You!</h1>
        <p style="color: gray">You've completed the exam.</p>
        <p>Congratulations <b><?php echo $_SESSION['user_completename']; ?></b> (<b><?php echo $_SESSION['user_email'];?></b>)<p>
        <p>Score: <b><span style='color:blue'><?php echo $score; ?></span></b> out of <b><?php echo $questionSize; ?></b> items</p>
        
        <p>Your Answers:</p>
        <ol>
        <?php foreach ($_SESSION['answers'] as $index => $answer): ?>
            <?php $question = $manager->retrieveQuestion($index); ?>
            <li>
                <?php 
                echo $answer." ";
                if ($answer === $question->getAnswer()) {
                    echo "(<span style='color:blue'>correct</span>)";
                } else {
                    echo "(<span style='color:red'>incorrect</span>)";
                }
                ?>
            </li>
        <?php endforeach; ?>
        </ol>
</body>
</html>

<!-- DEBUG MODE -->
<pre>
<?php
var_dump($_SESSION);
?>
</pre>