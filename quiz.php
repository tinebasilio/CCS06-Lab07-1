<?php

require "vendor/autoload.php";
session_start();

use App\QuestionManager;

$number = null;
$question = null;

try {
    $manager = new QuestionManager;
    $manager->initialize();

    $questions = [];

    for ($number = 1; $number <= $manager->getQuestionSize(); $number++) {
        $question = $manager->retrieveQuestion($number);
        array_push($questions, $question);
    }

    if (isset($_SESSION['is_quiz_started'])) {
        $number = 1;
        //$number = $_SESSION['current_question_number'];
    } else {
        // Marker for a started quiz
        $_SESSION['is_quiz_started'] = true;
        $_SESSION['answers'] = [];
        $number = 1;
    }
    
    if (isset($_POST['submit'])) {
        for ($number = 1; $number <= $manager->getQuestionSize(); $number++) {
            if (isset($_POST['answer_'.$number])) {
                $_SESSION['answers'][$number] = $_POST['answer_'.$number];
            }
        }

        // Has user answered all items
        $answeredQuestions = count($_SESSION['answers']);
        if ($answeredQuestions == $manager->getQuestionSize()) {
            header("Location: result.php");
            exit;
        }
    } 
    
    //$question = $manager->retrieveQuestion($number);

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
    <title>Quiz</title>

</head>
<body>

    <h1>Analogy Questions</h1>
        <h3>Instructions</h3>
        <p style="color: gray">
            There is a certain relationship between two given words on one side of : : and one word is given on another side of : : 
            while another word is to be found from the given alternatives, having the same relation with this word as the words of 
            the given pair bear. Choose the correct alternative.
        </p>

        <form method="POST" action="quiz.php">

            <?php foreach ($questions as $question): ?>
                <h1>Question #<?php echo $question->getNumber(); ?></h1>
                <h2 style="color: blue"><?php echo $question->getQuestion(); ?></h2>
                <h4 style="color: blue">Choices</h4>
                <input type="hidden" name="number_<?php echo $question->getNumber(); ?>" value="<?php echo $question->getNumber();?>" />
                
                <?php foreach ($question->getChoices() as $choice): ?>
                    <div>
                        <input type="radio" name="answer_<?php echo $question->getNumber(); ?>" value="<?php echo $choice->letter; ?>" id="<?php echo $choice->letter; ?>"/>
                        <label for="<?php echo $choice->letter; ?>"><?php echo $choice->letter . ') ' . $choice->label; ?></label>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <input type="submit" name="submit" value="Submit">
        </form>
    </div>

</div>
</body>
</html>

<!-- DEBUG MODE -->
<pre>
<?php
var_dump($_SESSION);
?>
</pre>